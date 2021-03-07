<?php

namespace Todo\Factory\Service;

class TodoServiceFactory
    implements \Laminas\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName($container->get(\Models\Repository\TodoRepository::class));
    }
}