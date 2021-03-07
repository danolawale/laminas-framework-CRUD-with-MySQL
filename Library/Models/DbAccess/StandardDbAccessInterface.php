<?php

namespace Models\DbAccess;

interface StandardDbAccessInterface
{
	public function getEntitySource(string $entityName): \Models\Table\TableInterface;
	public function fetchOne(string $entityName, array $data): \Models\Entity\EntityInterface;
	public function fetchAll(string $entityName): array;
	public function fetchAllByFields(string $entityName, array $data): array;
	public function create(string $entityName, array $data = null): \Models\Entity\EntityInterface;
	public function update(string $entityName, array $data): \Models\Entity\EntityInterface;
}