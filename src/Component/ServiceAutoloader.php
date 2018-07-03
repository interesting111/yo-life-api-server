<?php

namespace Component;

use \Slim\Container;

class ServiceAutoloader
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function autoload($makerName, $alias)
    {
        $parts = explode(':', $alias);

        if (empty($parts) or count($parts) != 2) {
            throw new \Exception('service alias is invalid');
        }

        if (isset($this->container["@{$alias}"])) {
            return $this->container["@{$alias}"];
        }

        $prefix = $parts[0];

        $name = $parts[1];

        $class = "Biz\\{$prefix}\\{$makerName}\\Impl\\{$name}Impl";

        $obj = new $class($this->container);

        $this->container["@{$alias}"] = $obj;

        return $obj;
    }
}
