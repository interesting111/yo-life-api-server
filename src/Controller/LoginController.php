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

        $thirdSessionKey = $this->getWeAppProvider()->encryptSessionKey($result['body']['session_key'], $result['body']['openid']);

        $this->getRedis()->set('third_sessionKey', $thirdSessionKey);

        return $response->withJson($this->createSuccessResponse([
            'thirdSessionKey' => $thirdSessionKey,
        ]));
    }
}
