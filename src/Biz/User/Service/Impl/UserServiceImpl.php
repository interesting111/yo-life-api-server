<?php

namespace Biz\User\Service\Impl;

use Biz\User\Service\UserService; 
use Biz\BaseService;

class UserServiceImpl extends BaseService implements UserService
{
    public function createUser($fields)
    {
        return $this->getUserDao()->create($fields);
    }

    public function deleteUser($id)
    {
        return $this->getUserDao()->delete($id);
    }
    public function getUserByOpenId($openid)
    {
        return $this->getUserDao()->getByOpenId($openid);
    }
    public function getUser($id)
    {
        return $this->getUserDao()->get($id);
    }

    public function searchUsers($conditions, $orderBy, $start, $limit)
    {
        return $this->getUserDao()->search($conditions, $orderBy, $start, $limit);
    }

    public function countUser($conditions)
    {
        return $this->getUserDao()->count($conditions);
    }

    public function updateUser($id, $fields)
    {
        return $this->getUserDao()->update($id, $fields);
    }

    protected function getUserDao()
    {
        return $this->createDao('User:UserDao');
    }
}

