<?php

namespace Controller;

use Controller\BaseController;

class LoginController extends BaseController
{
    use ControllerTrait;

    public function index($request, $response, $args)
    {
        $loginAuthUrl = $this->getWeAppProvider()->getLoginAuthUrl($request->getQueryParam('code'));

        $result = $this->getGuzzleServiceProvider()->request('GET', $loginAuthUrl);

        $this->getRedis()->set("third_openid_{$result['body']['openid']}", $result['body']['session_key']);

        $thirdKey = $this->getWeAppProvider()->encryptOpenId($result['body']['openid']);

        return $response->withJson($this->createSuccessResponse([
            'thirdKey' => $thirdKey,
        ]));
    }

    public function bind($request, $response, $args)
    {
        //to do refactor see bind_refactor.txt
    }

    protected function getUserSerivce()
    {
        return $this->createService('User:UserService');
    }
}
