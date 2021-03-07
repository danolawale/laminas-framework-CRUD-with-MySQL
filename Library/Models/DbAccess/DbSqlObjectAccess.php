<?php

namespace Models\DbAccess;

final class DbSqlObjectAccess
	implements DbSqlObjectAccessInterface
{
	private \Laminas\Db\Sql\Sql $_sql;
	private \Laminas\Db\Adapter\AdapterInterface $_adapter;
	
	public function __construct(
		\Laminas\Db\Sql\Sql $sql, \Laminas\Db\Adapter\AdapterInterface $adapter = null)
	{
		$this->_sql = $sql;
		$this->_adapter = $adapter ?: $this->_sql->getAdapter();
	}
	
	private function _getTableName(string $entityName = null): ?string
	{
		$table = $entityName ? $entityName::getTable()::getTableName() : null;
		
		#$this->_sql->setTable($table);
		
		return $table;
	}
	
	public function getSelect(string $entityName = null): \Laminas\Db\Sql\Select
	{
		return $this->_sql->select($this->_getTableName($entityName));
	}
	
	public function getInsert(string $entityName = null): \Laminas\Db\Sql\Insert
	{
		return $this->_sql->insert($this->_getTableName($entityName));
	}
	
	public function getUpdate(string $entityName = null): \Laminas\Db\Sql\Update
	{
		return $this->_sql->update($this->_getTableName($entityName));
	}
	
	public function getDelete(string $entityName = null): \Laminas\Db\Sql\Delete
	{
		return $this->_sql->delete($this->_getTableName($entityName));
	}
	
	public function getSqlString($sql): string
	{
		return $tis->_sql->buildSqlString($sql);
	}
	
	public function execute($sql)
	{
		$statement = $sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();
	}
}