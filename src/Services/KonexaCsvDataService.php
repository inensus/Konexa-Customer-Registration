<?php


namespace Inensus\KonexaBulkRegistration\Services;


use Inensus\KonexaBulkRegistration\Helpers\CsvDataProcessor;
use Inensus\KonexaBulkRegistration\Helpers\CsvFileParser;
use Inensus\KonexaBulkRegistration\Models\KonexaCsvData;

class KonexaCsvDataService
{
    private $konexaCsvData;
    private $csvDataProcessor;
    private $csvFileParser;

    public function __construct(KonexaCsvData $konexaCsvData, CsvFileParser $csvFileParser,CsvDataProcessor $csvDataProcessor)
    {
        $this->konexaCsvData = $konexaCsvData;
        $this->csvDataProcessor=$csvDataProcessor;
        $this->csvFileParser=$csvFileParser;

    }

    public function create($request)
    {

        $path = $request->file('csv');
        $parsedCsvData = $this->csvFileParser->parseCsvFromFilePath($path);
        $recentlyCreatedRecords = $this->csvDataProcessor->processParsedCsvData($parsedCsvData);
        $konexaCsvData = $this->konexaCsvData->newQuery()->create([
            'csv_filename' => $request->file('csv')->getClientOriginalName(),
            'user_id' => auth()->user()->id,
            'csv_data' => json_encode(array_values($parsedCsvData), true)
        ]);
         $konexaCsvData['recently_created_records']=$recentlyCreatedRecords;
        return $konexaCsvData;
    }
}