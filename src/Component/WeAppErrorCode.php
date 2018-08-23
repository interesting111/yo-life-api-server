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
    public static $ok = 0;
    public static $illegalAesKey = -41001;
    public static $illegalIv = -41002;
    public static $illegalBuffer = -41003;
    public static $decodeBase64Error = -41004;
 }
