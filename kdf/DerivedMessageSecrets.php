<?php
require_once("util/ByteUtil.php");
require_once("java/text/ParseException.php");
require_once("javax/crypto/spec/IvParameterSpec.php");
require_once("javax/crypto/spec/SecretKeySpec.php");
class DerivedMessageSecrets {
    public static $SIZE;    // int
    protected static $CIPHER_KEY_LENGTH;    // int
    protected static $MAC_KEY_LENGTH;    // int
    protected static $IV_LENGTH;    // int
    protected $cipherKey;    // SecretKeySpec
    protected $macKey;    // SecretKeySpec
    protected $iv;    // IvParameterSpec
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$SIZE = 80;
        self::$CIPHER_KEY_LENGTH = 32;
        self::$MAC_KEY_LENGTH = 32;
        self::$IV_LENGTH = 16;
    }
    public static function constructor__ae1a4a6a ($okm) // [byte[] okm]
    {
        $me = new self();
        $me->__init();
        try
        {
            /* match: dc908fa */
            $keys = ByteUtil::split_dc908fa($okm, self::$CIPHER_KEY_LENGTH, self::$MAC_KEY_LENGTH, self::$IV_LENGTH);
            $me->cipherKey = new SecretKeySpec($keys[0], "AES");
            $me->macKey = new SecretKeySpec($keys[1], "HmacSHA256");
            $me->iv = new IvParameterSpec($keys[2]);
        }
        catch (ParseException $e)
        {
            throw new AssertionError($e);
        }
        return $me;
    }
    public function getCipherKey ()
    {
        return $this->cipherKey;
    }
    public function getMacKey ()
    {
        return $this->macKey;
    }
    public function getIv ()
    {
        return $this->iv;
    }
}
DerivedMessageSecrets::__staticinit(); // initialize static vars for this class on load
