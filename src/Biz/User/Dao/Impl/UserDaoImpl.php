<?php

namespace Biz\User\Dao\Impl;

use Biz\User\Dao\UserDao;
use Biz\BaseDao;

class UserDaoImpl extends BaseDao implements UserDao
{
    protected $table = 'user';

    public function getByOpenId($openId)
    {
        $stmt = $this->getPdo()
                     ->select()
                     ->from($this->getTable())
                     ->where('openId', '=', $openId);

        return $stmt->execute()->fetch();
    }

    public function buildQueryStatement($conditions, $statement)
    {
        return $statement;
    }
}
