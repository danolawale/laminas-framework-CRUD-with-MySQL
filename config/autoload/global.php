<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

 use Laminas\Db\Adapter;

return [
   'service_manager' => [
        'abstract_factories' => [
            Adapter\AdapterAbstractServiceFactory::class
        ]
    ],
    'db' => [
        'adapters' => [
            \Models\Todo\TodoDbAdapterInterface::class => [
                'driver' => 'Pdo',
                'dsn'    => 'mysql:dbname=todos_app;host=localhost;charset=utf8',
            ],
        ],
        'driver' => 'Pdo',
        'dsn'    => 'mysql:dbname=todos_app;host=localhost;charset=utf8',
    ],
];
