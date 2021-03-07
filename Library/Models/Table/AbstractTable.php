<?php

namespace Models\Table;

abstract class AbstractTable
	extends AbstractTableAction
	implements TableInterface
{
	private static $_tableInstances;
	
	protected \Laminas\Db\Adapter\AdapterInterface $_adapter;
	
	public function setAdapter(\Laminas\Db\Adapter\AdapterInterface $adapter)
	{
		$this->_adapter = $adapter;
	}
	
	public function getAdapter(): ?\Laminas\Db\Adapter\AdapterInterface
	{
		return $this->_adapter;
	}
	
	public function fetchOne(array $data)
	{
		$primaryKeyValue = $data[$this->_primaryKey] ?? null;
		
		if($primaryKeyValue)
		{
			$select = "SELECT * FROM {$this->_tableName} WHERE {$this->_primaryKey} = ?";
		
			return $this->_fetchOne($select, [$primaryKeyValue]);
		}
		else
		{
			throw new \Exception("Unable to fetch entity");
		}
	}
	
	public function fetchAll(array $data = null)
	{
		$select = "SELECT * FROM {$this->_tableName} ";
		
		$bind = [];
		
		if($data)
		{
			$select .= "WHERE ";
			$lastKey = array_key_last($data);
			
			foreach($data as $key => $value)
			{
				if(is_scalar($value))
				{
					$select .= "{$key} = ? ";
					$bind[] = $value;
				}
				elseif(is_array($value))
				{
					$placeholders = implode(', ', array_fill(0, count($value), '?'));
					
					$select .= "{$key} IN ({$placeholders}) ";
					foreach($value as $val)
					{
						$bind[] = $val;
					}
				}
				
				$select .= $lastKey != $key ? "AND " : '';
			}
		}
		
		$result = $this->_fetch($select, $bind);
		
		if(count($result) == 1)
		{
			return $result[0];
		}
		
		return $result;
	}
	
	public function fetchAllByFields(array $data): array
	{
		$select = "SELECT * FROM {$this->_tableName} WHERE ";
		
		$lastKey = array_key_last($data);
		
		foreach($data as $key => $value)
		{
			$select .= "{$key} = ? ";
			
			$select .= $lastKey != $key ? "AND " : '';
		}
		
		return $this->_fetch($select, array_values($data));
	}
	
	public function fetchCols(array $fields, array $data = []): array
	{
		$select = "SELECT ";
		$select .= "'". implode(', ', $fields) . "'";
		$select .= " FROM {$this->_tableName} ";
		$select .= $data ? ' WHERE ' : '';
		
		$lastKey = array_key_last($data);
		
		foreach($data as $key => $value)
		{
			$select .= "{$key} = ? ";
			
			$select .= $lastKey != $key ? "AND " : '';
		}
		
		return $this->_fetch($select, array_values($data));
	}
	
	public function delete(array $data): int
	{
		$primaryKeyValue = $data[$this->_primaryKey] ?? null;
		
		if($primaryKeyValue)
		{
			$deleteSql = "DELETE FROM {$this->_tableName} WHERE {$this->_primaryKey} = ?";

			return $this->_delete($deleteSql, [$primaryKeyValue]);
		}
		
	}
	
	public function insert(array $data)
	{
		if($this->_isAutoIncremented)
		{
			if($data[ $this->_primaryKey ] ?? null)
			{
				unset($data[ $this->_primaryKey ]);
			}
		}

		$keys = array_keys($data);

        $columns = implode(', ', $keys);

        $placeholders = implode(', ', array_fill(0, count($keys), '?'));

        $insertSql = "INSERT INTO {$this->_tableName} ($columns) VALUES($placeholders)";

        $bind = array_values($data);
		
		$result = $this->_insert($insertSql, $bind);
		
		if(!$result)
		{
			throw new \Exception("Unable to create new {$this->_tableName}");
		}
		return $this->fetchOne([$this->_primaryKey => $result['generatedValue']]);
	}
	
	public function update(array $data)
	{
		$primaryKeyValue = $data[$this->_primaryKey] ?? null;
		
		unset($data[$this->_primaryKey]);
		$updateParams = array_reduce(array_keys($data), fn($acc, $ele) => $acc .= "{$ele} = ?,");
		$updateParams = substr($updateParams, 0, -1);
		
		$bind = [];
		
		if($primaryKeyValue)
		{
			$updateSql = "UPDATE {$this->_tableName} SET  {$updateParams} WHERE ";
			
			$bind = array_values($data);
			
			if(is_scalar($primaryKeyValue))
			{
				$updateSql .= "{$this->_primaryKey} = ?";
				
				$bind[] = $primaryKeyValue;
			}
			elseif(is_array($primaryKeyValue))
			{
				$placeholders = implode(', ', array_fill(0, count($primaryKeyValue), '?'));
				
				$updateSql .= "{$this->_primaryKey} IN ({$placeholders})";
				
				foreach($primaryKeyValue as $value)
				{
					$bind[] = $value;
				}
			}
			
			$this->_update($updateSql, $bind);
			
			return $this->fetchAll([$this->_primaryKey => $primaryKeyValue]);
		}
		else
		{
			throw new \Exception("Update execution failed");
		}
	}

	public static function getInstance(string $table): TableInterface
	{
		if(self::$_tableInstances[$table] ?? null)
		{
			return self::$_tableInstances[$table] ;
		}
		else
		{
			self::$_tableInstances[$table] = new $table;
		}
		
		return self::$_tableInstances[$table];
	}
}