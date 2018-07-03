<?php

namespace Controller;

use Component\Paginator;

trait ControllerTrait
{
    public function paginator($total, $offset, $limit)
    {
        $total = (int) $total;

        $offset = (int) $offset;

        $limit = (int) $limit;

        return new Paginator($total, $offset, $limit);
    }

    public function conditions($queryConditions, $default = array()) 
    {
        $conditions = array_merge($default, $queryConditions);

        unset($conditions['offset']);
        unset($conditions['limit']);

        return $conditions;
    }
}
