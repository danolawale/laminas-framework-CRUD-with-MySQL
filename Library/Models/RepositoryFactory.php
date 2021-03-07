<?php

namespace Models;

class RepositoryFactory
{
	private \Models\EntityTableGateway $_gateway;

	public function __construct(\Models\EntityTableGateway $gateway)
	{
		$this->_gateway = $gateway;
	}

	public function __invoke(string $entityName)
	{
		$repository = $entityName::getRepositoryName();

		return new $repository($entityName, $this->_gateway);
	}
}