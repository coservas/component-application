<?php

return [
    'name' => 'Component application',
    'migrations_namespace' => 'App\Migrations',
    'table_name' => 'migrations',
    'column_name' => 'version',
    'column_length' => 14,
    'executed_at_column_name' => 'executed_at',
    'migrations_directory' => 'src/Migrations',
    'all_or_nothing' => true,
    'check_database_platform' => true,
];