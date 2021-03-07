<?php 

namespace Todo\Factory\Controller;

use Laminas\Db\Adapter;

use Interop\Container\ContainerInterface;

class TodoControllerFactory
    implements \Laminas\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repository = new \Models\Repository\TodoRepository($container->get(\Models\StandardDbAdapterInterface::class));
        
        $service = new \Todo\Service\TodoService($repository);

        return new $requestedName($service);
    }
}