<?php

namespace Biz\User\Service;

interface UserService
{
    public function createUser($fields);

    public function deleteUser($id);

    public function getUser($id);

    public function getUserByOpenId($openId);

    public function searchUsers($conditions, $orderBy, $start, $limit);

    public function countUser($conditions);

    public function updateUser($id, $fields);
}
