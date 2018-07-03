<?php

namespace Biz;

class BaseService
{
    protected $ci;

    public function __construct($ci)
    {
        $this->ci = $ci;
    }

    private function getAutoloader()
    {
        return $this->ci['service_autoloader'];
    }

    protected function createService($alias)
    {
        return $this->getAutoloader()->autoload('Service', $alias);
    }

    protected function createDao($alias)
    {
        return $this->getAutoloader()->autoload('Dao', $alias);
    }
}
