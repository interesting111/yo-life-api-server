<?php

namespace Component;

use Component\WeAppErrorCode;

class WeAppProvider
{
    protected $appId;

    protected $appSecret;

    protected $encryptStr = '10082c39-4c81-473b-b6da-3fef84ff69e7';

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

    public function encryptOpenId($openId)
    {
        if (empty($openId)) {
            throw new \Exception('Invalid openId');
        }

        $find = array('+', '/', '=');
        $replace = array('-', '_', '');

        $thirdOpenId = base64_encode($openId.'|'.$this->encryptStr.'|'.time());

        return str_replace($find, $replace, $thirdOpenId);
    }

    public function decryptOpenId($encryptedStr)
    {
        $find = array('-', '_');
        $replace = array('+', '/');

        $encryptedStr = str_replace($find, $replace, $encryptedStr);

        $mod = strlen($encryptedStr) % 4;

        if ($mod) {
            $encryptedStr .= substr('====', $mod);
        }

        $str = base64_decode($encryptedStr);

        return explode('|', $str);
    }

    /**
     * 该方法由微信提供，进行了修改
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData($encryptedData, $iv, &$data, $sessionKey)
    {
        if (strlen($sessionKey) != 24) {
            return WeAppErrorCode::$illegalAesKey;
        }

        $aesKey = base64_decode($sessionKey);

        if (strlen($iv) != 24) {
            return WeAppErrorCode::$illegalIv;
        }

        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $resul = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj = json_decode($result);

        if($dataObj == NULL) {
            return WeAppErrorCode::$illegalBuffer;
        }

        if($dataObj->watermark->appid != $this->appId) {
            return WeAppErrorCode::$illegalBuffer;
        }

        $data = $result;

        return WeAppErrorCode::$ok;
    }
}
