<?php

use Laminas\Db\Adapter;
use Laminas\Db\Adapter\AdapterAbstractServiceFactory;

return [
    'lazy_services' =>[
        'class_map' => [
            Adapter\AdapterInterface::class => Adapter\AdapterInterface::class,
            \Models\EntityTableGateway::class => \Models\EntityTableGateway::class,
            \Models\RepositoryFactory::class => \Models\RepositoryFactory::class,
        ]
    ],
    
    'delegators' => [
        Adapter\AdapterInterface::class => [
            \Laminas\ServiceManager\Proxy\LazyServiceFactory::class
        ],
        \Models\EntityTableGateway::class => [
            \Laminas\ServiceManager\Proxy\LazyServiceFactory::class
        ],
        \Models\RepositoryFactory::class => [
            \Laminas\ServiceManager\Proxy\LazyServiceFactory::class
        ]
    ],

    'factories' => [
        Adapter\AdapterInterface::class => Adapter\AdapterServiceFactory::class,
        
        'DefaultAdapter' => function($container)
        {
            $driver = $container->get(Adapter\AdapterInterface::class)->getDriver();
            
            return new Adapter\Adapter($driver);
        },

        \Models\EntityTableGateway::class => function ($container)
        {
            $dbAdapter = $container->get(Adapter\AdapterInterface::class);
            
            return new \Models\EntityTableGateway($dbAdapter);
        },
        
        \Models\RepositoryFactory::class => function($container)
        {
            return new \Models\RepositoryFactory($container->get(\Models\EntityTableGateway::class));
        },
        
        \Models\DbAccess\StandardDbAccessInterface::class => function($container)
        {
            return new \Models\DbAccess\StandardDbAccess($container->get('DefaultAdapter'));
        },
        
        \Models\DbAccess\DbSqlObjectAccessInterface::class => function($container)
        {
            $adapter = $container->get('DefaultAdapter');

            return new \Models\DbAccess\DbSqlObjectAccess(new \Laminas\Db\Sql\Sql($adapter), $adapter);
        }
    ]
];