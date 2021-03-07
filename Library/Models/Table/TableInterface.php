<?php

namespace Models\Table;

interface TableInterface
{
	public function setAdapter(\Laminas\Db\Adapter\AdapterInterface $adapter);
	public function getAdapter(): ?\Laminas\Db\Adapter\AdapterInterface;
	
	public function fetchOne(array $data);
	public function fetchAll(array $data = null);
	public function insert(array $data);
	public function update(array $data);
	public function delete(array $data): int;
}