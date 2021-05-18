<?php
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'konexa-bulk-register'], function () {
    Route::group(['prefix' => 'import-csv'], function () {
        Route::post('/', 'ImportCsvController@store');
    });
});