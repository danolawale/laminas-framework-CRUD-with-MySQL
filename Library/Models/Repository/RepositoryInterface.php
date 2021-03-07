<?php

namespace Models\Repository;

interface RepositoryInterface
{
	public function getEntityName(): string;
	public function getSelect(): \Laminas\Db\Sql\Select;
	public function getInsert(): \Laminas\Db\Sql\Insert;
	public function getUpdate(): \Laminas\Db\Sql\Update;
	public function getDelete(): \Laminas\Db\Sql\Delete;
	public function getSqlString($sql): string;
	
}