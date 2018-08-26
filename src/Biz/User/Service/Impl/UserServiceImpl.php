<?php

namespace Biz\User\Service\Impl;

use Biz\User\Service\UserService; 
use Biz\BaseService;
use Common\ArrayToolkit;

class UserServiceImpl extends BaseService implements UserService
{
    public function createUser($fields)
    {
        if (!ArrayToolkit::requireds($fields, ['openId', 'nickname', 'gender', 'city', 'province', 'country', 'avatarUrl', 'unionId'])) {
            throw new \Exception('missing fields');
        }

        $fields['createdTime'] = time();
        $fields['updatedTime'] = time();

        return $this->getUserDao()->create($fields);
    }

    public function deleteUser($id)
    {
        return $this->getUserDao()->delete($id);
    }
    public function getUserByOpenId($openId)
    {
        return $this->getUserDao()->getByOpenId($openId);
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
        $fields = ArrayToolkit::parts($fields, ['openId', 'nickname', 'gender', 'city', 'province', 'country', 'avatarUrl', 'unionId']);

        $fields['updatedTime'] = time();

        return $this->getUserDao()->update($id, $fields);
    }

    protected function getUserDao()
    {
        return $this->createDao('User:UserDao');
    }
}
