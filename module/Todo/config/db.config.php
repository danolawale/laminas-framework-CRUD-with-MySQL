<?php

use Laminas\Db\Adapter;
use Laminas\Db\Adapter\AdapterAbstractServiceFactory;

return [
    'factories' => [
        Adapter\AdapterInterface::class => Adapter\AdapterServiceFactory::class,

        \Models\StandardDbAdapterInterface::class => function($container)
        {
            return new \Models\StandardDbAdapter($container->get(\Models\Todo\TodoDbAdapterInterface::class));
        },

        \Models\EntityTableGateway::class => function ($container)
        {
            $dbAdapter = $container->get(Adapter\AdapterInterface::class);
            
            return new \Models\EntityTableGateway($dbAdapter);
        },
    ]
];