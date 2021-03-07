<?php

namespace Models\Table;

final class MoreTodo
	extends AbstractTable
{
	protected $_tableName = 'todos';
	protected $_primaryKey = 'id';
	protected $_entityName = \Models\Entity\MoreTodo::class;
	protected $_isAutoIncremented = true;
	
	public static function getTableName(): string
	{
		return 'todos';
	}
}