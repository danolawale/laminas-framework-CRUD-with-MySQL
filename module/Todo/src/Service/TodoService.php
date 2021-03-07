<?php

namespace Todo\Service;

class TodoService
    implements TodoServiceInterface
{
    private $_todoRepository = null;

    public function __construct(\Models\Repository\TodoRepository $todoRepository)
    {
        $this->_todoRepository = $todoRepository;
    }

    public function getAllTodos(): array
    {
        return $this->_todoRepository->fetchAll();
    }

    public function getSingleTodo($id)
    {
        return $this->_todoRepository->fetchOne($id);
    }

    public function validateTodo(array $todoData): array
    {
        $errors = [];

        $errors = array_merge($errors , $this->_validateName($todoData['name']));

        $errors = array_merge($errors , $this->_validateDescription($todoData['description']));

        return array_filter($errors);
    }

    public function createTodo(array $todoData): array
    {
        return $this->_todoRepository->create($todoData);
    }

    public function updateTodo(array $todoData, $id)
    {
        return $this->_todoRepository->update($todoData, $id);
    }

    public function deleteTodo($id)
    {
        return $this->_todoRepository->delete($id);
    }

    private function _validateName(string $name = null): array
    {
        $errors = [];

        preg_match('/[a-zA-Z0-9\s]{3,}/', $name, $result);

        $errors[] = !$result ? "Invalid Todo Name" : null;

        $errors[] = $result && strlen($result[0] > 20) ? "Todo Name is too long" : null;

       return array_filter($errors);
    }

    private function _validateDescription(string $description = null): array
    {
        $errors = [];

        preg_match('/[a-zA-Z0-9\s]{10,}/', $description, $result);

        $errors[] = !$result ? "Invalid Todo Description. Minimum length is 10" : null;

        $errors[] = $result && strlen($result[0] > 255) ? "Todo Description is too long" : null;

       return array_filter($errors);
    }
}