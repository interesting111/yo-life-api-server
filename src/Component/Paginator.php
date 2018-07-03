<?php

namespace Component;

class Paginator
{
    public $total;

    public $offset;

    public $limit;

    public function __construct($total, $offset, $limit)
    {
        $this->total = $total;

        $this->offset = $offset;

        $this->limit = $limit;
    }
}
