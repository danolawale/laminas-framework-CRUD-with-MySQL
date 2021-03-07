<?php

namespace Models;

class StandardDbAdapter
    extends AbstractStandardDbAdapter
    implements StandardDbAdapterInterface
{
    public function fetchOne($sql, $bind= [])
    {
        $resultSet = $this->_execute($sql, $bind);

        $data = $resultSet->current();

        if (!$data)
        {
            throw new \InvalidArgumentException('Data not found');
        }

        return $data;
    }

    public function fetchAll($sql, $bind= [])
    {
        return $this->_execute($sql, $bind);
    }

    public function fetchAllArray($sql, $bind= []): array
    {
        return $this->fetchAll($sql, $bind)->toArray();
    }

    public function save($sql, $bind = [])
    {
        return $this->_execute($sql, $bind);
    }

    public function delete($sql, $bind)
    {
        return $this->_execute($sql, $bind);
    }
}