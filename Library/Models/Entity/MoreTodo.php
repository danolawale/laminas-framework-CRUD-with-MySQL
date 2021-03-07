<?php

namespace Models\Entity;

class MoreTodo
   extends AbstractEntity
{
   protected int $id;
   protected string $name;
   protected string $description;
   protected bool $completed;

   public static function getColumns(): array
   {
       return [
           'id',
           'name',
           'description',
           'completed'
       ];
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
   
   public function getCompleted(): bool
   {
      return $this->completed;
   }
   
    public static function getRepositoryName(): string
   {
      return \Models\Repository\MoreTodoRepository::class;
   }
   
   public static function getTable(): string
   {
      return \Models\Table\MoreTodo::class;
   }
   
   public function getEntityName(): string
   {
      return get_class();
   }
}