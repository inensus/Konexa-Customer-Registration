<?php


namespace Inensus\KonexaBulkRegistration\Helpers;

use ParseCsv\Csv;

class CsvFileParser
{
    private $csv;

    public function __construct()
    {
        require_once(__DIR__ . '/../../../../../vendor/autoload.php');
        $this->csv = new Csv();
    }
    public function parseCsvFromFilePath($path)
    {
        $this->csv->auto($path);
        return $this->csv->data;
    }
}