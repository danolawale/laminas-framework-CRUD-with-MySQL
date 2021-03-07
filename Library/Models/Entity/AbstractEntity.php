<?php

namespace Models\Entity;

abstract class AbstractEntity
	implements EntityInterface
{
	private ?\Models\Table\TableInterface $_entityTable;
	private bool $_isNew = true;
	protected $_fields = [];
	
	public function __construct(\Models\Table\TableInterface $entityTable = null)
	{
		$this->_entityTable = $entityTable;
	}
	
	public function isNew(bool $isNew)
	{
		$this->_isNew = $isNew;
	}

	public function __get($key)
	{
		return $this->_fields[ $this->_validateField($key) ];
	}
	
	public function __set($key, $value)
	{
		$this->_fields[ $this->_validateField($key) ] = $value;
		
		$this->_fields['_isNew'] = $this->_isNew ?: false;
	}
	
	public function getFields(): array
	{
		return $this->_fields;
	}
	
	public function setEntityData(array $data = null): EntityInterface
	{
		$this->_setData($data);

		foreach($this->_fields as $key => $value)
		{
			$this->$key = $value;
		}
		
		return $this;
	}
	
	public function save()
	{
		$this->_entityTable ??= $this->_getEntityTable();
		
		$result = $this->_isNew ? $this->_entityTable->insert($this->_fields) : $this->_entityTable->update($this->_fields);
		
		$this->_isNew = false;
		
		return $result;
	}
	
	public function delete()
	{
		$this->_entityTable ??= $this->_getEntityTable();
		
		return $this->_entityTable->delete($this->_fields);
	}
	
	protected function _validateField(string $key): string
	{
		$columns = static::getColumns();
		
		if(!in_array($key, $columns))
		{
			throw new \Exception("Unable to access invalid field {$key} in ". $this->getEntityName());
		}
		
		return $key;
	}
	
	protected function _setData(array $data)
	{
		foreach($data as $key => $value)
		{
			if($this->_validateField($key))
			{
				$this->_fields[$key] = $value;
			}
		}
	}
	
	private function _getEntityTable()
	{
		$table = static::getTable();
	
		$tableIntance = $table::getInstance($table);
		
		if(!$tableIntance->getAdapter())
		{
			throw new \Exception("Unable to get adapter");
		}
		
		return $tableIntances;
	}
}