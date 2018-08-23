<?php

namespace Biz\User\Dao;

interface UserDao
{
    public function getByOpenId($openId);
}
