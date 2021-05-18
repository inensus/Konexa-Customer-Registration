<?php


namespace Inensus\KonexaBulkRegistration\Services;


use App\Models\ConnectionType;

class ConnectionTypeService extends CreatorService
{

    public function __construct(ConnectionType $connectionType)
    {
        parent::__construct($connectionType);
    }

    public function resolveCsvDataFromComingRow($csvData)
    {
        $connectionTypeConfig = config('konexa-bulk-registration.csv_fields.connection_type');
        $connectionTypeData = [
            'name' => $csvData[$connectionTypeConfig['name']]
        ];
        return $this->createRelatedDataIfDoesNotExists($connectionTypeData);
    }
}