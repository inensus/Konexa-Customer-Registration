<?php
return [
    'csv_fields' => [

        'person' => [
            'name' => 'First Name',
            'm-name' => 'Middle Name',
            'surname' => 'Surname',
            'created_at' => 'Date of registration'
        ],

        'cluster' => [
            'name' => 'State'
        ],

        'mini_grid' => [
            'cluster_id' => 'cluster_id',
            'name' => 'LGA'
        ],

        'city' => [
            'cluster_id' => 'cluster_id',
            'mini_grid_id' => 'mini_grid_id',
            'name' => 'Village name'
        ],

        'address' => [
            'person_id' => 'person_id',
            'city_id' => 'city_id',
            'phone' => 'Phone number',
            'alternative_phone' => 'Alternate phone number'
        ],

        'tariff' => [
            'name' => 'Service selected by customer',
            'currency' => 'NGN',
            'price' => 0,
            'total_price' => 0
        ],

        'connection_type' => [
            'name' => 'Connection package'
        ],

        'connection_group' => [
            'name' => 'Purpose of connection'
        ],

        'appliance_type' => [
            'name' => 'What appliance would you like to purchase?',
            'price' => 0
        ],

        'manufacturer' => [
            'name' => 'Specify meter manufacturer '
        ],

        'meter' => [
            'serial_number' => 'Scan meter Barcode',
            'in_use' => 1,
            'manufacturer_id' => 'manufacturer_id',
        ],

        'meter_parameter' => [
            'owner_type' => 'person',
            'owner_id' => 'person_id',
            'meter_id' => 'meter_id',
            'connection_type_id' => 'connection_type_id',
            'connection_group_id' => 'connection_group_id',
            'tariff_id' => 'tariff_id'
        ],

        'geographical_information' => [
            'owner_type' => 'owner_type',
            'owner_id' => 'owner_id',
            'points' => 'points',
            'household_latitude' => '_GPS location of household_latitude',
            'household_longitude' => '_GPS location of household_longitude',
            'household' => 'GPS location of household'
        ],

        'person_docs' => [
            'customer_picture' => [
                'person_id'=>'person_id',
                'name' => 'name',
                'type' => 'Customer Picture',
                'location' => null
            ],
            'signed_contract' => [
                'person_id'=>'person_id',
                'name' => 'name',
                'type' => 'Take picture of signed contract',
                'location' => null
            ],
            'customer_id' => [
                'person_id'=>'person_id',
                'name' => 'name',
                'type' => 'Take picture of customer ID',
                'location' => null
            ],
            'payment receipt' => [
                'person_id'=>'person_id',
                'name' => 'name',
                'type' => 'Take picture of customer payment reciept',
                'location' => null
            ],
        ]

    ],
    'appliance_types' => ['TV - 24', 'Option 5', 'Fridge', 'Freezer', 'Fan'],

    'geocoder' => [
        'key' => 'AIzaSyAnSY-zdlCXxLwW9jgmbVEo_fwLMSDkG9E',
        'country' => 'NG',
    ],

    'reflections' => [
        'PersonService' => 'Inensus\KonexaBulkRegistration\Services\PersonService',
        'PersonDocumentService' => 'Inensus\KonexaBulkRegistration\Services\PersonDocumentService',
        'ClusterService' => 'Inensus\KonexaBulkRegistration\Services\ClusterService',
        'MiniGridService' => 'Inensus\KonexaBulkRegistration\Services\MiniGridService',
        'GeographicalInformationService' => 'Inensus\KonexaBulkRegistration\Services\GeographicalInformationService',
        'CityService' => 'Inensus\KonexaBulkRegistration\Services\CityService',
        'AddressService' => 'Inensus\KonexaBulkRegistration\Services\AddressService',
        'TariffService' => 'Inensus\KonexaBulkRegistration\Services\TariffService',
        'ConnectionTypeService' => 'Inensus\KonexaBulkRegistration\Services\ConnectionTypeService',
        'ConnectionGroupService' => 'Inensus\KonexaBulkRegistration\Services\ConnectionGroupService',
        'ApplianceTypeService' => 'Inensus\KonexaBulkRegistration\Services\ApplianceTypeService',
        'MeterParameterService' => 'Inensus\KonexaBulkRegistration\Services\MeterParameterService',
        'MeterService' => 'Inensus\KonexaBulkRegistration\Services\MeterService',
        'ManufacturerService' => 'Inensus\KonexaBulkRegistration\Services\ManufacturerService',
    ]
];