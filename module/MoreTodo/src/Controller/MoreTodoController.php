<?php

declare(strict_types=1);

namespace MoreTodo\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class MoreTodoController extends AbstractActionController
{
    private \MoreTodo\Service\MoreTodoServiceInterface $_todoService;

    public function __construct(\MoreTodo\Service\MoreTodoServiceInterface $todoService)
    {
        $this->_todoService = $todoService;
    }

    public function indexAction()
    {
        $todos = $this->_todoService->getAllTodos();

        return new ViewModel(['todos' => $todos]);
    }

    public function showAction()
    {
        $id = $this->params()->fromRoute('id');

        $todo = $this->_todoService->getSingleTodo($id);

        return new ViewModel(['todo' => $todo]);
    }

    public function newTodoAction()
    {
       return new ViewModel();
    }

    public function storeAction()
    {
        $name = $this->params()->fromPost('name', '');

        $description = $this->params()->fromPost('description', '');

        $todoData = [
            'name' => $name,
            'description' => $description,
            'completed' => false
        ];

        $errors = $this->_todoService->validateTodo($todoData);

        if(!$errors)
        {
            $result = $this->_todoService->createTodo($todoData);

            #$this->flashMessenger()->addSuccessMessage('Successfully Created a new Todo');
        
            return $this->redirect()->toRoute('home');
        }
      
        $viewModel = new ViewModel(['errors' => $errors]);
    
        $viewModel->setTemplate('more-todo/more-todo/new-todo');

        return $viewModel;
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        $todo = $this->_todoService->getSingleTodo($id);

        return new ViewModel(['todo' => $todo]);
    }

    public function updateAction()
    {
        $id = $this->params()->fromRoute('id');

        $todo = $this->_todoService->getSingleTodo($id);

        if(!$todo)
        {
            //$this->flashMessenger()->addErrorMessage("Unable to retrieve todo");

            return $this->redirect()->toRoute('home');
        }

        $name = $this->params()->fromPost('name', '');

        $description = $this->params()->fromPost('description', '');
        
        $completed = $this->params()->fromPost('completed', 0);

        $todoData = [
            'name' => $name,
            'description' => $description,
            'completed' => $completed
        ];

        $errors = $this->_todoService->validateTodo($todoData);

        if(!$errors)
        {
            $result = $this->_todoService->updateTodo($todoData, $id);

            $this->flashMessenger()->addSuccessMessage("Successfully updated todo");
        
            return $this->redirect()->toRoute('home');
        }

        $viewModel = new ViewModel(['errors' => $errors, 'todo' => $todo]);
        $viewModel->setTemplate('/more-todo/more-todo/edit');
        
       return $viewModel;
    }

    public function completeAction()
    {
        $id = $this->params()->fromRoute('id');

        $todo = $this->_todoService->getSingleTodo($id);

        $todoData = ['completed' => true];

        $result = $this->_todoService->updateTodo($todoData, $id);

        #$this->flashMessenger()->addSuccessMessage("Successfully completed todo {$todo->getName()}");

        return $this->redirect()->toRoute('home');
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        if(!$id)
        {
            return $this->redirect()->toRoute('home');
        }

        $result = $this->_todoService->deleteTodo($id);

        #$this->flashMessenger()->addSuccessMessage("Successfully deleted todo");
        return $this->redirect()->toRoute('home');
    }
}