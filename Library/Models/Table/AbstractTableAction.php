<?php

namespace Models\Table;

use Laminas\Hydrator\HydratorInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Hydrator\ReflectionHydrator;

abstract class AbstractTableAction
{
    protected \Laminas\Db\Adapter\AdapterInterface $_adapter;
    private HydratorInterface $_hydrator;
    
    public function __construct(HydratorInterface $hydrator = null)
    {
        $this->_hydrator ??= new ReflectionHydrator();
    }
    
    protected function _fetchOne(string $sql, array $bind = [])
    {
        $result = $this->_execute($sql, $bind);

        if (!$result)
        {
            throw new \InvalidArgumentException('Data not found');
        }

        return $result[0];
    }
    
    protected function _fetch(string $sql, array $bind = [])
    {
        return $this->_execute($sql, $bind);
    }
	
	protected function _insert(string $sql, array $bind = []): array
	{
		$result = $this->_execute($sql, $bind);

		if(! $result instanceof ResultInterface )
        {
            throw new \Exception("Unable to create new {$this->_entityName}");
        }

        return [
            'affectedRows' => $result->getAffectedRows(),
            'generatedValue' => $result->getGeneratedValue()
        ];
	}

	protected function _update(string $sql, array $bind = []): int
	{
		$result = $this->_execute($sql, $bind);
		
		if(! $result instanceof ResultInterface )
        {
            throw new \Exception("Unable to update entity {$this->_entityName}");
        }

        return $result->getAffectedRows();
	}
	
	protected function _delete(string $sql, array $bind = []): int
	{
		$result = $this->_execute($sql, $bind);
		
		if(! $result instanceof ResultInterface )
		{
		   throw new \Exception("Unable to delete entity {$this->_entityName}");
		}

        return $result->getAffectedRows();
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

    private function _hydrateResultSet(ResultInterface $result): array#\Laminas\Db\ResultSet\HydratingResultSet
    {
        $table = $this->_entityName::getTable();
        
        $tableInstance = $table::getInstance($table);
		
		$tableInstance->setAdapter($this->_adapter);
        
        $resultSet = new HydratingResultSet(
            $this->_hydrator, 
            new $this->_entityName($tableInstance));

        $resultSet->initialize($result);

        $data = [];
        foreach($resultSet as $row)
        {
            $row->isNew(false);
            
            $data[] = $row;
        }
        
         #return iterator_to_array($resultSet);
         return $data;
    }
}