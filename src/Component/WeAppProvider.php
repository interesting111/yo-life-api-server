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

    public function getLoginCheckUrl($code)
    {
        $httpQuery = [
            'appid' => $this->appid,
            'secret' => $this->appSecret,
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];

        return 'https://api.weixin.qq.com/sns/jscode2session?'.http_build_query($httpQuery);
    }
}
