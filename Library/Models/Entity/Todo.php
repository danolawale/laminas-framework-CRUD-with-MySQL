<?php

namespace Models\Entity;

class Todo
{
   private int $id;
   private string $name;
   private string $description;
   private bool $completed;
   
   public static function getTableName(): string
   {
      return 'todos';
   }
   
   public function getEntityName(): string
   {
      return get_class();
   }
   
   public function getId(): int 
   {
       return $this->id;
   }

   public function getName(): string 
   {
       return $this->name;
   }

   public function getDescription(): string 
   {
       return $this->description;
   }
}