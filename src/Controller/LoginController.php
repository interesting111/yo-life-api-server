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

        $thirdOpenId = $this->getWeAppProvider()->encryptOpenId($result['body']['openid']);

        return $response->withJson($this->createSuccessResponse([
            'thirdOpenId' => $thirdOpenId,
        ]));
    }
}
