<?php

namespace Inensus\KonexaBulkRegistration\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class KonexaCsvData extends JsonResource
{

    public function toArray($request)
    {

        return [
            'data' => [
                'type' => 'konexa_csv_data',
                'konexa_csv_data_id' => $this->id,
                'attributes' => [
                    'created_person_id' => $this->user_id,
                    'csv_filename' => $this->csv_filename,
                    'recently_created_records'=>$this->recently_created_records
                ]
            ]
        ];
    }
}