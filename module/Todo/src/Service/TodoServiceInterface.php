<?php

namespace Todo\Service;

interface TodoServiceInterface
{
    public function getAllTodos(): array;
    public function getSingleTodo($id);
    public function validateTodo(array $todoData): array;
    public function createTodo(array $todoData): array;
    public function updateTodo(array $todoData, $id);
}