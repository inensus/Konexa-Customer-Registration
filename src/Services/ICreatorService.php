<?php


namespace Inensus\KonexaBulkRegistration\Services;


interface ICreatorService
{
    public function createRelatedDataIfDoesNotExists($resolvedCsvData);
}