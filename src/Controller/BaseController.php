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
            'data' => $data,
        );
    }

    protected function createFailResponse($code = 500, $msg = '')
    {
        return array(
            'code' => $code,
            'msg' => $msg,
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

    protected function getWeAppProvider()
    {
        return $this->ci['weapp_provider'];
    }

    protected function getGuzzleServiceProvider()
    {
        return $this->ci['guzzle_provider'];
    }

    protected function getRedis()
    {
        return $this->ci['redis'];
    }
}
