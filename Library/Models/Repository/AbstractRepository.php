<?php

namespace Models\Repository;

use Laminas\Db\TableGateway\Feature\RowGatewayFeature;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Hydrator\ReflectionHydrator as ReflectionHydrator;

abstract class AbstractRepository
	implements RepositoryInterface
{
	protected \Models\EntityTableGateway $_gateway;
	private string $_entityName;

    public function __construct(string $entityName,
       \Models\EntityTableGateway $gateway)
    {
		$this->_entityName = $entityName;

        $this->_gateway = $gateway;

        $this->_initializeRepository();
    }

    private function _initializeRepository(): void
    {
        $this->_gateway->setTable($this->_entityName::getTable()::getTableName());

        $this->_gateway->setColumns($this->_entityName::getColumns());
		
		$this->_gateway->setFeature(new RowGatewayFeature(new $this->_entityName));
		
		$this->_gateway->setResultSetPrototype(new HydratingResultSet(new ReflectionHydrator, new $this->_entityName));

        $this->_gateway->initialize();
    }
	
	public function getEntityName(): string
	{
		return $this->_entityName;
	}
	
	public function getAdapter(): Laminas\Db\Adapter\AdapterInterface
	{
		return $this->_gateway->getAdapter();
	}

	public function getSelect(): \Laminas\Db\Sql\Select
    {
        return $this->_gateway->getSql()->select();
    }
    
    public function getInsert(): \Laminas\Db\Sql\Insert
    {
        return $this->_gateway->getSql()->insert();
    }
    
    public function getUpdate(): \Laminas\Db\Sql\Update
    {
        return $this->_gateway->getSql()->update();
    }
    
    public function getDelete(): \Laminas\Db\Sql\Delete
    {
        return $this->_gateway->getSql()->delete();
    }
	
	public function getSqlString($sql): string
	{
		return $this->_gateway->getSql()->buildSqlString($sql);
	}
	
	protected function _fetchOne(\Laminas\Db\Sql\Select $select)
	{
		return $this->_gateway->selectWith($select)->current();
	}
	
	protected function _fetchAll(\Laminas\Db\Sql\Select $select = null)
	{
		return $select ? $this->_gateway->selectWith($select) : $this->_gateway->select();
	}
	
	protected function _create(\Laminas\Db\Sql\Insert $insert): int
	{
		return $this->_gateway->insertWith($insert);
	}
	
	protected function _update(\Laminas\Db\Sql\Update $update): int
	{
		return $this->_gateway->updateWith($update);
	}
	
	protected function _delete(\Laminas\Db\Sql\Delete $delete): int
	{
		return $this->_gateway->deleteWith($delete);
	}
	
	protected function _getLastInsertId(): int
	{
		return $this->_gateway->getLastInsertValue();
	}
}