<?php


namespace Inensus\KonexaBulkRegistration\Helpers;


class CsvDataProcessor
{
    private $geographicalLocationFinder;
    private $reflections;
    private $recentlyCreatedRecords;

    public function __construct(GeographicalLocationFinder $geographicalLocationFinder)
    {
        $this->geographicalLocationFinder = $geographicalLocationFinder;
        $this->reflections = config('konexa-bulk-registration.reflections');
        $this->recentlyCreatedRecords=[
            'cluster'=>0,
            'mini_grid'=>0,
            'village'=>0,
            'customer'=>0,
            'tariff'=>0,
            'connection_type'=>0,
            'connection_group'=>0,
            'meter'=>0,
        ];
    }
    public function processParsedCsvData($csvData)
    {
        Collect($csvData)->each(function ($row) {
            $person = $this->createRecordFromCsv($row, $this->reflections['PersonService']);
            $row['person_id'] = $person->id;
            $this->checkRecordWasRecentlyCreated($person,'customer');

            $this->createRecordFromCsv($row, $this->reflections['PersonDocumentService']);

            $cluster = $this->createRecordFromCsv($row, $this->reflections['ClusterService']);
            $row['cluster_id'] = $cluster->id;
            $this->checkRecordWasRecentlyCreated($cluster,'cluster');

            $miniGrid = $this->createRecordFromCsv($row, $this->reflections['MiniGridService']);
            $row['mini_grid_id'] = $miniGrid->id;
            $this->checkRecordWasRecentlyCreated($miniGrid,'mini_grid');

            $geographicalInformationService = app()->make($this->reflections['GeographicalInformationService']);
            $geographicalInformationService->resolveCsvDataFromComingRow($row, $miniGrid);

            $city = $this->createRecordFromCsv($row, $this->reflections['CityService']);
            $row['city_id'] = $city->id;
            $this->checkRecordWasRecentlyCreated($city,'village');

            $this->createRecordFromCsv($row, $this->reflections['AddressService']);

            $tariff = $this->createRecordFromCsv($row, $this->reflections['TariffService']);
            $row['tariff_id'] = $tariff->id;
            $this->checkRecordWasRecentlyCreated($tariff,'tariff');

            $connectionType = $this->createRecordFromCsv($row, $this->reflections['ConnectionTypeService']);
            $row['connection_type_id'] = $connectionType->id;
            $this->checkRecordWasRecentlyCreated($connectionType,'connection_type');

            $connectionGroup = $this->createRecordFromCsv($row, $this->reflections['ConnectionGroupService']);
            $row['connection_group_id'] = $connectionGroup->id;
            $this->checkRecordWasRecentlyCreated($connectionGroup,'connection_group');

            $this->createRecordFromCsv($row, $this->reflections['ApplianceTypeService']);

            $manufacturer = $this->createRecordFromCsv($row, $this->reflections['ManufacturerService']);
            if ($manufacturer) {
                $row['manufacturer_id'] = $manufacturer->id;
                $meter = $this->createRecordFromCsv($row, $this->reflections['MeterService']);
                if ($meter) {
                    $row['meter_id'] = $meter->id;
                    $this->checkRecordWasRecentlyCreated($meter,'meter');
                    $meterParameter = $this->createRecordFromCsv($row, $this->reflections['MeterParameterService']);
                    //initializes a new Access Rate Payment for the next Period
                    event('accessRatePayment.initialize', $meterParameter);
                    $geographicalInformationService = app()->make($this->reflections['GeographicalInformationService']);
                    $geographicalInformationService->resolveCsvDataFromComingRow($row, $meterParameter);
                }
            }
        });
        return $this->recentlyCreatedRecords;
    }

    private function createRecordFromCsv($row, $serviceName)
    {
        $service = app()->make($serviceName);
        return $service->resolveCsvDataFromComingRow($row);
    }

    private function checkRecordWasRecentlyCreated($record,$type){
        if($record->wasRecentlyCreated){
            $this->recentlyCreatedRecords[$type]++;
        }
    }
}