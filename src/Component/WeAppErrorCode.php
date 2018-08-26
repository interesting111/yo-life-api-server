 <?php

 namespace Component;

/**
 * error code 说明
 *    -41001: encodingAesKey 非法
 *    -41003: aes 解密失败
 *    -41004: 解密后得到的buffer非法
 *    -41005: base64加密失败
 *    -41016: base64解密失败
 */
 class WeAppErrorCode
 {
    const OK = 0;

    const ILLEGAL_AES_KEY = -41001;

    const ILLEGAL_IV = -41002;

    const ILLEGAL_BUFFER = -41004;

    const DECODE_BASE64_ERROR = -41005;

    public function getErrorMsg($code)
    {
        switch ($code) {
            case self::ILLEGAL_AES_KEY:
                'encodingAesKey 非法';
                break;
            case self::ILLEGAL_IV:
                'iv 非法';
                break;
            case self::ILLEGAL_BUFFER:
                'buffer 非法';
                 break;
            case self::DECODE_BASE64_ERROR:
                'base64 解密失败'
                break;
        }
    }
 }
