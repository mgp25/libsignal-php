<?php
require_once("ecc/Curve.php");
require_once("ecc/ECPublicKey.php");
require_once("util/Hex.php");
class IdentityKey {
    protected $publicKey;    // ECPublicKey
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__de8cd838 ($publicKey) // [ECPublicKey publicKey]
    {
        $me = new self();
        $me->__init();
        $me->publicKey = $publicKey;
        return $me;
    }
    public static function constructor__29e7cc9a ($bytes, $offset) // [byte[] bytes, int offset]
    {
        $me = new self();
        $me->__init();
        $me->publicKey = Curve::decodePoint($bytes, $offset);
        return $me;
    }
    public function getPublicKey ()
    {
        return $this->publicKey;
    }
    public function serialize ()
    {
        return $this->publicKey->serialize();
    }
    public function getFingerprint ()
    {
            /* match: ae1a4a6a */
        return Hex::toString_ae1a4a6a($this->publicKey->serialize());
    }
    public function equals ($other) // [Object other]
    {
        if (($other == null))
            return  FALSE ;
        if (!($other instanceof IdentityKey))
            return  FALSE ;
        return $this->publicKey->equals(($other)::getPublicKey());
    }
    public function hashCode ()
    {
        return $this->publicKey->hashCode();
    }
}
IdentityKey::__staticinit(); // initialize static vars for this class on load
?>
