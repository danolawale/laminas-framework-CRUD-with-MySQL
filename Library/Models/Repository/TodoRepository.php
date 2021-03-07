<?php

namespace Models\Repository;

use \Laminas\Db\Sql\Sql;
use \Laminas\Db\Adapter;
use Laminas\Db\Adapter\Driver\ResultInterface;

class TodoRepository
{
    public function __construct(
       \Models\StandardDbAdapterInterface $standardAdapter)
    {
        $this->_standardAdapter = $standardAdapter;

        $this->_standardAdapter->setEntityName(\Models\Entity\Todo::class);
    }

    public function fetchAll()
    {
        $select = "SELECT * FROM todos";

        return $this->_standardAdapter->fetchAllArray($select);
    }

    public function fetchOne($id)
    {
        $select = "SELECT * FROM todos WHERE id = ?";

        return $this->_standardAdapter->fetchOne($select, [$id]);
    }

    public function create(array $data): array
    {
        $keys = array_keys($data);

        $columns = implode(', ', $keys);

        $placeholders = implode(', ', array_fill(0, count($keys), '?'));

        $insertSql = "INSERT INTO todos ($columns) VALUES($placeholders)";

        $bind = array_values($data);

        $result = $this->_standardAdapter->save($insertSql, $bind);

        if(! $result instanceof ResultInterface )
        {
            throw new \Exception("Unable to create new todo");
        }

        return [
            'affectedRows' => $result->getAffectedRows(),
            'generatedValue' => $result->getGeneratedValue()
        ];
    }

    public function update(array $data, $id): int 
    {
        $updateParams = array_reduce(array_keys($data), fn($acc, $ele) => $acc .= "{$ele} = ?,");
        $updateParams = substr($updateParams, 0, -1);

        $updateSql = "UPDATE todos SET  {$updateParams} WHERE id = ?";

        $bind = array_values($data);
        $bind[] = $id;

        $result = $this->_standardAdapter->save($updateSql, $bind);

        if(! $result instanceof ResultInterface )
        {
            throw new \Exception("Unable to update todo");
        }

        return $result->getAffectedRows();
    }

    public function delete($id): int
    {
        $deleteSql = "DELETE FROM todos WHERE id = ?";

        $result = $this->_standardAdapter->delete($deleteSql, [$id]);

        if(! $result instanceof ResultInterface )
        {
            throw new \Exception("Unable to delete todo");
        }

        return $result->getAffectedRows();
    }
}