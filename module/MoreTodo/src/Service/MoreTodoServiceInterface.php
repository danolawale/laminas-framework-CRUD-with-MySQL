<?php

namespace MoreTodo\Service;

interface MoreTodoServiceInterface
{
    public function getAllTodos();
    public function getSingleTodo($id);
    public function validateTodo(array $todoData): array;
    #public function createTodo(array $todoData): int;
    public function createTodo(array $todoData): \Models\Entity\EntityInterface;
    #public function updateTodo(array $todoData, $id): int;
    public function updateTodo(array $todoData, $id): \Models\Entity\EntityInterface;
}