<?php

require 'configs/database.php';

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations/%%PHINX_ENVIRONMENT%%',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds/%%PHINX_ENVIRONMENT%%'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => DB_HOST,
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => DB_TYPE,
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USER,
            'pass' => DB_PASS,
            'port' => DB_PORT,
            'charset' => 'utf8',
            'suffix' => '.db'
        ],
        'testing' => [
            'adapter' => 'sqlite',
            'name' => 'test',
            'suffix' => '.db'
        ]
    ],
    'version_order' => 'creation'
];
