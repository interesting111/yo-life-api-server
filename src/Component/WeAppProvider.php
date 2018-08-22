<?php

namespace Component;

class WeAppProvider
{
    protected $appId;

    protected $appSecret;

    protected $secretKey = "10082c39-4c81-473b-b6da-3fef84ff69e7";

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
            throw new \Exception('Invalid sessionKey or openId');
        }

        $find = array('+', '/', '=');
        $replace = array('-', '_', '');

        $thirdOpenID = base64_encode($openId.'|'.$secretKey.'|'.time());

        return str_replace($find, $replace, $thirdOpenID);
    }
    public function decryptSessionKey($sessionKey)
    {
        if (empty($sessionKey) || empty($openId)) {
            throw new \Exception('Invalid sessionKey or openId');
        }

        $find = array('+', '/', '=');
        $replace = array('-', '_', '');

        $thirdSessionKey = base64_encode($sessionKey.'|'.$openId.'|'.time());

        return str_replace($find, $replace, $thirdSessionKey);
    }
    /**
	 * 检验数据的真实性，并且获取解密后的明文.
	 * @param $encryptedData string 加密的用户数据
	 * @param $iv string 与用户数据一同返回的初始向量
	 * @param $data string 解密后的原文
     *
	 * @return int 成功0，失败返回对应的错误码
	 */
	public function decryptData( $encryptedData, $iv, $data,$sessionKey)
	{
		if (strlen($sessionKey) != 24) {
			return ErrorCode::$IllegalAesKey;
		}
		$aesKey=base64_decode($sessionKey);

        
		if (strlen($iv) != 24) {
			return ErrorCode::$IllegalIv;
		}
		$aesIV=base64_decode($iv);

		$aesCipher=base64_decode($encryptedData);

		$result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

		$dataObj=json_decode( $result );
		if( $dataObj  == NULL )
		{
			return ErrorCode::$IllegalBuffer;
		}
		if( $dataObj->watermark->appid != $this->appid )
		{
			return ErrorCode::$IllegalBuffer;
		}
		$data = $result;
		return ErrorCode::$OK;
	}

}
