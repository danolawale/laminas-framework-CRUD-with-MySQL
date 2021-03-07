<?php

namespace Models\Repository;

class MoreTodoRepository
    extends AbstractRepository
{
    public function fetchOne($id)
    {
        $select = $this->getSelect();
        $select->where(['id' => $id]);
        
        return $this->_fetchOne($select);
    }
    
    public function fetchAll($select = null)
    {
        return $this->_fetchAll($select);
    }
    
    public function fetchAllAsArray($select = null)
    {
        return $this->fetchAll($select)->toArray();
    }
    
    public function fetchByFields(array $data)
    {
         $select = $this->getSelect();
         $select->where($data);
         
         return $this->fetchAll($select);
    }
    
     public function create(array $data): \Models\Entity\MoreTodo
     {
        $insert = $this->getInsert();

        $insert
            ->columns(array_keys($data))
            ->values($data);
        
        if(!$this->_create($insert))
        {
            throw new \Exception('Unable to create Todo');
        }
        
        return $this->fetchOne($this->_getLastInsertId());
     }
     
     public function update(array $data, $id): \Models\Entity\MoreTodo
     {
        $update = $this->getUpdate();
        
        $update
            ->set($data)
            ->where(['id' => $id]);
            
        $result = $this->_update($update);
        
        return $this->fetchOne($id);
     }
     
     public function delete($id)
     {
        $delete = $this->getDelete();
        
        $delete
            ->where(['id' => $id]);
            
        if(!$this->_delete($delete))
        {
            throw new \Exception('Unable to delete Todo');
        }

        return null;
     }
}