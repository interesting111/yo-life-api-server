<?php

namespace Controller;

use Controller\BaseController;
use Common\ArrayToolkit;
use Component\WeAppErrorCode;

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
        $fields = $request->getParsedBody();

        $openId = $this->getWeAppProvider()->decryptOpenId($fields['thirdKey']);

        $sessionKey = $this->getRedis()->get('third_openid_'.$openId);

        $result = $this->getWeAppProvider()->decryptData($fields['encryptedData'], $fields['iv'], $fields['data'], $sessionKey);

        if ($result) {
            return $response->withJson($this->createFailResponse(
                $result,
                WeAppErrorCode::getErrorMsg($result)
            ));
        }

        $user = $this->getUserSerivce()->getUserByOpenId($openId);

        if (empty($user)) {
            $user = $this->getUserSerivce()->createUser($data);   
        } else {
            !ArrayToolkit::same(ArrayToolkit::parts($user, ['createdTime', 'updatedTime'])) && $user = $this->getUserSerivce()->updateUser($user['id'], $fields);
        }

        return $response->withJson($this->createSuccessResponse($user));
    }

    protected function getUserSerivce()
    {
        return $this->createService('User:UserService');
    }
}
