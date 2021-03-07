<?php

namespace Models;

use Laminas\Db\Sql\Sql;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Hydrator\ReflectionHydrator;

abstract class AbstractStandardDbAdapter
{
    protected \Laminas\Db\Adapter\Adapter $_adapter;
    private HydratorInterface $_hydrator;
    private string $_source;
    
    public function __construct(
        \Laminas\Db\Adapter\Adapter $adapter,
        HydratorInterface $hydrator = null)
    {
        $this->_adapter = $adapter;

        $this->_hydrator ??= new ReflectionHydrator();
    }

    public function setEntityName(string $source)
    {
        $this->_source = $source;
    }

    protected function _execute(string $sql, array $bind = [])
    {
        $statement = $this->_adapter->createStatement($sql, $bind);
        $result    = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) 
        {
            return $this->_hydrateResultSet($result);
        }
        else if($result instanceof ResultInterface && !$result->isQueryResult())
        {
            return $result;
        }
        else
        {
            throw new \Exception("Invalid result");
        }
    }

    private function _hydrateResultSet(ResultInterface $result): \Laminas\Db\ResultSet\HydratingResultSet
    {
        $resultSet = new HydratingResultSet(
            $this->_hydrator, 
            new $this->_source);

        $resultSet->initialize($result);

        return $resultSet;
    }
}