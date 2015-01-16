<?php
class ECKeyPair {
    protected $publicKey;    // ECPublicKey
    protected $privateKey;    // ECPrivateKey
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__43f151c1 ($publicKey, $privateKey) // [ECPublicKey publicKey, ECPrivateKey privateKey]
    {
        $me = new self();
        $me->__init();
        $me->publicKey = $publicKey;
        $me->privateKey = $privateKey;
        return $me;
    }
    public function getPublicKey ()
    {
        return $this->publicKey;
    }
    public function getPrivateKey ()
    {
        return $this->privateKey;
    }
}
ECKeyPair::__staticinit(); // initialize static vars for this class on load
