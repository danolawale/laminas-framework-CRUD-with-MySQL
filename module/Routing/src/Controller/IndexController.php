<?php

declare(strict_types=1);

namespace Routing\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function showAction()
    {
        return new JsonModel($this->_getItems());
    }

    public function showItemAction()
    {
        $itemId = $this->params()->fromRoute('id');

        $item = array_values(array_filter($this->_getItems(), function($item) use ($itemId)
        {
            return $item['id'] == $itemId;
        }));

        return new JsonModel($item);

       // return $this->getResponse();
    }

    private function _getItems(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Food Item',
                'owner' => 'Dan Olawale'
            ],
            [
                'id' => 2,
                'name' => 'Clothing Item',
                'owner' => 'Ruth Crystal'
            ],
            [
                'id' => 3,
                'name' => 'Electric Cars',
                'owner' => 'Tesla'
            ]
        ];
    }
}
