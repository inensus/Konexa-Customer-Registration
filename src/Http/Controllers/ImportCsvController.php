<?php

namespace Inensus\KonexaBulkRegistration\Http\Controllers;


use Illuminate\Routing\Controller;
use Inensus\KonexaBulkRegistration\Exceptions\CsvDataParserException;
use Inensus\KonexaBulkRegistration\Http\Requests\ImportCsvRequest;
use Inensus\KonexaBulkRegistration\Http\Resources\KonexaCsvData as KonexaCsvDataResource;
use Inensus\KonexaBulkRegistration\Services\KonexaCsvDataService;

class ImportCsvController extends Controller
{
    private $konexaCsvDataService;
    public function __construct(KonexaCsvDataService $konexaCsvDataService)
    {
        $this->konexaCsvDataService = $konexaCsvDataService;
    }
    public function store(ImportCsvRequest $request)
    {
        try {
            return new KonexaCsvDataResource($this->konexaCsvDataService->create($request));
        } catch (\Exception $exception) {
            throw  new CsvDataParserException($exception->getMessage());
        }

    }
}