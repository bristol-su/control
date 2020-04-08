<?php

return [
    'api_prefix' => env('CONTROL_API_PREFIX', '/api/control'),
    'api_middleware' => [
        'api'
    ],
    
    'export' => [

        /*
        |--------------------------------------------------------------------------
        | Default Export Method
        |--------------------------------------------------------------------------
        |
        | This option defines the default export method for exporting control data.
        | The name specified in this option should match one of the configuration options
        | listed below.
        |
        */
        'default' => 'contact-details',

        /*
        |--------------------------------------------------------------------------
        | Log Channels
        |--------------------------------------------------------------------------
        |
        | Here you may configure the export drivers for control. Each option must 
        | reference a driver to use, and may additionally register any formatters
        | or configuration for that driver.
        |
        | Available Drivers:
        |     - save-csv     Save a csv to a given disk system
        |     - dump     Dump the results using the symfony dumper
        |
        */
        'local-roles' => [
            'driver' => 'save-csv',
            'formatters' => [
                \BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter::class => [],
                \BristolSU\ControlDB\Export\Formatter\Role\AddGroupInformationToRoles::class => [],
                \BristolSU\ControlDB\Export\Formatter\Role\AddPositionInformationToRoles::class => []
            ],
            'disk' => 'local',
            'filename' => 'export.csv',
        ],
        
        'contact-details' => [
            'driver' => 'save-csv',
            'formatters' => [
                \BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter::class => [],
                \BristolSU\ControlDB\Export\Formatter\Role\AddGroupInformationToRoles::class => [],
                \BristolSU\ControlDB\Export\Formatter\Role\AddPositionInformationToRoles::class => [],
                \BristolSU\ControlDB\Export\Formatter\Role\AddRoleHoldersAsNewItems::class => [],
                \BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn::class => [
                    'column' => 'Group Name'
                ]
            ],
            'disk' => 'local',
            'filename' => 'contact_details.csv',
        ]
    ]
];