<?php 

namespace TodoTest\Controller;

use Todo\Controller\TodoController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Todo\Service\TodoServiceInterface;

class TodoControllerTest
    extends AbstractHttpControllerTestCase
{
    private TodoServiceInterface $_service;

    protected $traceError = true;

    public function setUp(): void 
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();

        $this->_service = $this->createMock(TodoServiceInterface::class);

       # $this->flashMessenger = $this->createMock(\Laminas\Mvc\Controller\Plugin\FlashMessenger::class);

        $services = $this->getApplicationServiceLocator();
        $services->setService(TodoServiceInterface::class, $this->_service);
        #$services->setService(\Laminas\Mvc\Controller\Plugin\FlashMessenger::class, $this->flashMessenger);
    }

    public function testTodos()
    {
        $this
            ->_service 
            #->expects($this->once())
            ->method('getAllTodos');

        $this->dispatch('http://localhost:8080/todos', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('todo');
        $this->assertControllerName(TodoController::class);
        $this->assertControllerClass('TodoController');
        $this->assertMatchedRouteName('home');
        $this->assertActionName('index');
    }

    public function testTodoUpdate()
    {
        $this
            ->_service 
            #->expects($this->once())
            ->method('getSingleTodo');

        $this
            ->_service 
            #->expects($this->once())
            ->method('validateTodo');

        $this
            ->_service 
            #->expects($this->once())
            ->method('updateTodo');

        $this->dispatch('http://localhost:8080/todos/1/update', 'POST', ['name' => 'Test', 'description' => 'Test Decription']);

        $this->assertResponseStatusCode(200);
        $this->assertMatchedRouteName('update');
        $this->assertActionName('update');
    }
}

