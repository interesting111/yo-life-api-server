<?php

namespace Controller;

use \Psr\Container\ContainerInterface;

class BaseController
{
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    private function getAutoloader()
    {
        return $this->ci['service_autoloader'];
    }

    protected function createSuccessResponse($data)
    {
        return array(
            'code' => 200,
            'msg' => 'success',
            'data' => $data,
        );
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
