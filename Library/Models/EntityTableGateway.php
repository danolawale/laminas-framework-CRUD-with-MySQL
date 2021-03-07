<?php 

namespace Models;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\Feature\RowGatewayFeature;
use Laminas\Db\ResultSet\HydratingResultSet;

class EntityTableGateway
    extends \Laminas\Db\TableGateway\AbstractTableGateway
{
    protected $adapter;
    protected $table;
    protected $columns;
    protected $featureSet;
    protected $resultSetPrototype;

    public function __construct(
        AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function setTable(string $table)
    {
        $this->table = $table;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }
    
    public function setFeature(RowGatewayFeature $feature)
    {
        $this->featureSet =  $feature;
    }
    
    public function setResultSetPrototype(HydratingResultSet $resulSettPrototype)
    {
        $this->resultSetPrototype = $resulSettPrototype;
    }
    
    public function getAdapter(): \Laminas\Db\Adapter\AdapterInterface
    {
        return $this->adapter;
    }
}