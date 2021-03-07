<?php

namespace Models;

interface StandardDbAdapterInterface
{
    public function fetchOne($sql, $bind= []);
    public function fetchAll($sql, $bind= []);
    public function fetchAllArray($sql, $bind= []): array;
    public function save($sql, $bind = []);
}