<?php
require_once("javax/crypto/spec/IvParameterSpec.php");
require_once("javax/crypto/spec/SecretKeySpec.php");
class MessageKeys {
    protected $cipherKey;    // SecretKeySpec
    protected $macKey;    // SecretKeySpec
    protected $iv;    // IvParameterSpec
    protected $counter;    // int
    public static function constructor__9e0e673d ($cipherKey, $macKey, $iv, $counter) // [SecretKeySpec cipherKey, SecretKeySpec macKey, IvParameterSpec iv, int counter]
    {
        $me = new self();
        $me->__init();
        $me->cipherKey = $cipherKey;
        $me->macKey = $macKey;
        $me->iv = $iv;
        $me->counter = $counter;
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
    public function getCounter ()
    {
        return $this->counter;
    }
}
MessageKeys::__staticinit(); // initialize static vars for this class on load
