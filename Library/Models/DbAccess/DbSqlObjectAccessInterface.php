<?php

namespace Models\DbAccess;

interface DbSqlObjectAccessInterface
{
	public function getSelect(string $entityName = null): \Laminas\Db\Sql\Select;
	public function getInsert(string $entityName = null): \Laminas\Db\Sql\Insert;
	public function getUpdate(string $entityName = null): \Laminas\Db\Sql\Update;
	public function getDelete(string $entityName = null): \Laminas\Db\Sql\Delete;
}