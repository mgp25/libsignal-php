<?php
require_once("util/ByteUtil.php");
require_once("java/math/BigInteger.php");
require_once("java/util/Arrays.php");
class DjbECPublicKey implements ECPublicKey {
    protected $publicKey;    // byte[]
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__ae1a4a6a ($publicKey) // [byte[] publicKey]
    {
        $me = new self();
        $me->__init();
        $me->publicKey = $publicKey;
        return $me;
    }
    public function serialize ()
    {
        $type = [Curve::$DJB_TYPE];
        return ByteUtil::combine($type, $this->publicKey);
    }
    public function getType ()
    {
        return Curve::$DJB_TYPE;
    }
    public function equals ($other) // [Object other]
    {
        if (($other == null))
            return  FALSE ;
        if (!($other instanceof DjbECPublicKey))
            return  FALSE ;
        $that = $other;
        return $this->publicKey == $that->publicKey;
    }
    public function hashCode ()
    {
        return $Arrays->hashCode($this->publicKey);
    }
    public function compareTo ($another) // [ECPublicKey another]
    {
        return new BigInteger($this->publicKey)::compareTo(new BigInteger(($another)::$publicKey));
    }
    public function getPublicKey ()
    {
        return $this->publicKey;
    }
}
DjbECPublicKey::__staticinit(); // initialize static vars for this class on load
