<?php

namespace MoreTodo\Factory\Service;

class MoreTodoServiceFactory
    implements \Laminas\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName($container->get(\Models\Repository\MoreTodoRepository::class));
    }
}