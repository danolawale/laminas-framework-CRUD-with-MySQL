<?php

namespace Models\DbAccess;

final class StandardDbAccess
	implements StandardDbAccessInterface
{
	private \Laminas\Db\Adapter\AdapterInterface $_adapter;
	
	private $_mapper = [
		\Models\Entity\MoreTodo::class => \Models\Table\MoreTodo::class
	];
	
	public function __construct(\Laminas\Db\Adapter\AdapterInterface $adapter)
	{
		$this->_adapter = $adapter;
	}
	
	public function getEntitySource(string $entityName): \Models\Table\TableInterface
	{
		$table = $this->_getMappedEntityTable($entityName);
		
		$tableInstance = $table::getInstance($table);
		
		$tableInstance->setAdapter($this->_adapter);
		
		return $tableInstance;
	}
	
	public function fetchOne(string $entityName, array $data): \Models\Entity\EntityInterface
	{
		return $this->getEntitySource($entityName)->fetchOne($data);
	}
	
	public function fetchAll(string $entityName): array
	{
		return $this->getEntitySource($entityName)->fetchAll();
	}
	
	public function fetchAllByFields(string $entityName, array $data): array
	{
		return $this->getEntitySource($entityName)->fetchAllByFields($data);
	}
	
	public function fetchCols(string $entityName, array $fields, array $data): array
	{
		return $this->getEntitySource($entityName)->fetchCols($fields, $data);
	}
	
	public function create(string $entityName, array $data = null): \Models\Entity\EntityInterface
	{
		$entity = new $entityName($this->getEntitySource($entityName));
		
		$entity = $data ? $entity->setEntityData($data) : $entity;
		
		$result = $entity->save();
		return $entity;
	}
	
	public function update(string $entityName, array $data): \Models\Entity\EntityInterface
	{
		$entity = $this->getEntitySource($entityName)->fetchOne($data);
		
		return $entity->setEntityData($data)->save();
	}
	
	public function delete(string $entityName, array $data)
	{
		$entity = $this->getEntitySource($entityName)->fetchOne($data);
		
		return $entity->setEntityData($data)->delete();
	}
	
	private function _getMappedEntityTable(string $entityName): string
	{
		if($this->_mapper[$entityName] ?? null)
		{
			return $this->_mapper[$entityName];
		}
		else
		{
			throw new \Exception("Entity not found in mapper");
		}
	}
}