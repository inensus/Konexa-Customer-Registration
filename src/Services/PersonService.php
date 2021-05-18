<?php


namespace Inensus\KonexaBulkRegistration\Services;


use App\Models\Person\Person;

class PersonService extends CreatorService
{

    public function __construct(Person $person)
    {
        parent::__construct($person);
    }

    public function resolveCsvDataFromComingRow($csvData)
    {
        $personConfig = config('konexa-bulk-registration.csv_fields.person');
        $personData = [
            'name' => $csvData[$personConfig['name']] . ' ' . $csvData[$personConfig['m-name']],
            'surname' => $csvData[$personConfig['surname']],
        ];
        return $this->createRelatedDataIfDoesNotExists($personData);
    }
}