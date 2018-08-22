<?php

namespace Controller;

use Controller\BaseController;
use Service\User\Impl\UserServiceImpl;


class UserController extends BaseController
{
    //绑定用户
    public function index($request, $response, $args)
    {
        $params = $request->getQueryParams();
        $encryptedData = $params['encryptedData'];
        $iv = $params['iv'];
        $rawData = $params['rawData'];
        $signature = $params['signature'];
        $sessionKey = $params['sessionKey'];
        $openId =  $this->getWeAppProvider()->decryptOpenId($params['thirdOpenId']);
        $sessionKey = $this->getRedis()->get("third_openid_".openId);
        $data;
        $decryptFlag = $this->getWeAppProvider()->decryptData($encryptedData,$iv,$data,$sessionKey);

        if($decryptFlag != 0){
            return ErrorCode::false;
        }

        $user = $this->getUserSerivce()->getUserByOpenID($openId);
        if($user == null ){
            $user = new array({
                'openId' => $data['openId'],
                'nickname' => $data['nickname'],
                'gender' => $data['gender'],
                'city' => $data['city'],
                'province' => $data['province'],
                'country' => $data['country'],
                'avatarUrl' => $data['avatarUrl'],
                'unionId' => $data['unionId'],
                'createdTime' => strtotime ("now"),
                'updatedTime' => 0,
            });
            $this->getUserSerivce()->createUser($user);
        }else{
            $updateFlag = false;
            if($user['nickname'] != $data['nickname'])
            {
                $user['nickname'] = $data['nickname'];
                $updateFlag = true;
            }
            if($user['gender'] != $data['gender'])
            {
                $user['gender'] = $data['gender'];
                $updateFlag = true;
            }
            if($user['city'] != $data['city'])
            {
                $user['city'] = $data['city'];
                $updateFlag = true;
            }
            if($user['province'] != $data['province'])
            {
                $user['province'] = $data['province'];
                $updateFlag = true;
            }
            if($user['country'] != $data['country'])
            {
                $user['country'] = $data['country'];
                $updateFlag = true;
            }
            if($user['avatarUrl'] != $data['avatarUrl'])
            {
                $user['avatarUrl'] = $data['avatarUrl'];
                $updateFlag = true;
            }
            if($updateFlag)
            {
                $user['updatedTime'] = strtotime ("now");
                $this->getUserSerivce()->createUser($user['id'],$user);
            }
        }
        return $response->withJson(new array({
            'nickname' => $user['nickname'],
            'gender' => $user['gender'],
            'city' => $user['city'],
            'province' =>$user['province'],
            'country' => $user['country'],
            'avatarUrl' => $user['avatarUrl']
        }));
    }
    protected function getUserSerivce()
    {
        return $this->createService('User:UserService');
    }
}
