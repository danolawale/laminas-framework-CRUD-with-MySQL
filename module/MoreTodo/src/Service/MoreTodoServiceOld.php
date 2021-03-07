<?php

namespace MoreTodo\Service;

class MoreTodoServiceOld
    implements MoreTodoServiceInterface
{
	private $_dbAccess = null;
	
	public function __construct(\Models\DbAccess\StandardDbAccessInterface $dbAccess)
	{
		$this->_dbAccess = $dbAccess;
	}
	
	public function getAllTodos()
    {
        return $this->_dbAccess->fetchAll(\Models\Entity\MoreTodo::class);
    }

    public function getSingleTodo($id)
    {
        return $this->_dbAccess->fetchOne(\Models\Entity\MoreTodo::class, ['id' => $id]);
    }

    public function validateTodo(array $todoData): array
    {
        $errors = [];

        $errors = array_merge($errors , $this->_validateName($todoData['name']));

        $errors = array_merge($errors , $this->_validateDescription($todoData['description']));

        return array_filter($errors);
    }

    public function createTodo(array $todoData): \Models\Entity\EntityInterface
    {
        return $this->_dbAccess->create(\Models\Entity\MoreTodo::class, $todoData);
    }

   public function updateTodo(array $todoData, $id): \Models\Entity\EntityInterface
    {
        $todoData['id'] = $id;

        return $this->_dbAccess->update(\Models\Entity\MoreTodo::class, $todoData);
    }

    public function deleteTodo($id)
    {
        return $this->_dbAccess->delete(\Models\Entity\MoreTodo::class, ['id' => $id]);
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