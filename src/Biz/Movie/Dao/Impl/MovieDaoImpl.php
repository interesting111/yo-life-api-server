<?php

namespace Biz\Movie\Dao\Impl;

use Biz\Movie\Dao\MovieDao;
use Biz\BaseDao;

class MovieDaoImpl extends BaseDao implements MovieDao
{
    protected $table = 'movie';

    public function buildQueryStatement($conditions, $statement)
    {
        if (!empty($conditions['id'])) {
            $statement = $statement->where('id', '=', $conditions['id']);
        }

        return $statement;
    }
}