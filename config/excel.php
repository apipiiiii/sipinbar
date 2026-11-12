<?php

return [
    'exports' => [
        'chunk_size' => 1000,
        'pre_calculate_formulas' => false,
        'strict_null_comparison' => false,
        'csv' => [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => PHP_EOL,
            'use_bom' => false,
            'include_separator_line' => false,
            'excel_compatibility' => false,
        ],
        'properties' => [
            'creator' => 'SIPINBAR',
            'lastModifiedBy' => 'SIPINBAR',
            'title' => 'Laporan SIPINBAR',
            'description' => '',
            'subject' => '',
            'keywords' => '',
            'category' => '',
            'manager' => '',
            'company' => 'SMK Negeri 5 Surakarta',
        ],
    ],
    'extension_detector' => [
        'xlsx' => \Maatwebsite\Excel\Excel::XLSX,
        'xls' => \Maatwebsite\Excel\Excel::XLS,
        'csv' => \Maatwebsite\Excel\Excel::CSV,
    ],
    'value_binder' => [
        'default' => \Maatwebsite\Excel\DefaultValueBinder::class,
    ],
    'cache' => [
        'driver' => 'memory',
    ],
    'transactions' => [
        'handler' => 'db',
    ],
    'temporary_files' => [
        'local_path' => storage_path('framework/cache/laravel-excel'),
        'remote_disk' => null,
        'remote_prefix' => null,
        'force_resync_remote' => null,
    ],
];
