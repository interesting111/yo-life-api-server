<?php

namespace Component;

class WeAppProvider
{
    protected $appId;

    protected $appSecret;

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;

        $this->appSecret = $appSecret;
    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function getAppSecret()
    {
        return $this->appSecret;
    }

    public function getLoginAuthUrl($code)
    {
        $httpQuery = [
            'appid' => $this->appId,
            'secret' => $this->appSecret,
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];

        return 'https://api.weixin.qq.com/sns/jscode2session?'.http_build_query($httpQuery);
    }

    public function encryptSessionKey($sessionKey, $openId)
    {
        $find = array('+', '/', '=');
        $replace = array('-', '_', '');

        $thirdSessionKey = base64_encode($sessionKey.'|'.$openId.'|'.time());

        return str_replace($find, $replace, $thirdSessionKey);
    }
}
