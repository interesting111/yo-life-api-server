<?php

namespace Biz\User\Dao\Impl;

use Biz\User\Dao\UserDao;
use Biz\BaseDao;

class UserDaoImpl extends BaseDao implements UserDao
{
    protected $table = 'user';

    public function getByOpenId($openid)
    {
        $statement = $this->getPdo()
        ->select()
        ->from($this->getTable())
        ->where('openid','=',$openid);

        return $statement->execute()->fetch();
    }
}