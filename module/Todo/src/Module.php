<?php

declare(strict_types=1);

namespace Todo;

class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig(): array
    {
       return array_merge_recursive(include __DIR__ . '/../config/db.config.php');
    }
}
