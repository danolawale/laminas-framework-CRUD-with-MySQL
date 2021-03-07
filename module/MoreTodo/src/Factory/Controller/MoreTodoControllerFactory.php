<?php 

namespace MoreTodo\Factory\Controller;

use Interop\Container\ContainerInterface;

class MoreTodoControllerFactory
    implements \Laminas\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repository = new \Models\Repository\MoreTodoRepository(
			\Models\Entity\MoreTodo::class,
			$container->get(\Models\EntityTableGateway::class));
        
        $service = new \MoreTodo\Service\MoreTodoService($repository);
        
        return new $requestedName($service);
    }
}