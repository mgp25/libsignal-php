<?php
class DjbECPrivateKey implements ECPrivateKey {
    protected $privateKey;    // byte[]
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__ae1a4a6a ($privateKey) // [byte[] privateKey]
    {
        $me = new self();
        $me->__init();
        $me->privateKey = $privateKey;
        return $me;
    }
    public function serialize ()
    {
        return $this->privateKey;
    }
    public function getType ()
    {
        return Curve::$DJB_TYPE;
    }
    public function getPrivateKey ()
    {
        return $this->privateKey;
    }
}
DjbECPrivateKey::__staticinit(); // initialize static vars for this class on load
