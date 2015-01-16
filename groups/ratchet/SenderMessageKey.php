<?php
require_once("kdf/HKDFv3.php");
require_once("util/ByteUtil.php");
class SenderMessageKey {
    protected $iteration;    // int
    protected $iv;    // byte[]
    protected $cipherKey;    // byte[]
    protected $seed;    // byte[]
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__4919b4ba ($iteration, $seed) // [int iteration, byte[] seed]
    {
        $me = new self();
        $me->__init();
        $derivative = HKDFv3::constructor__()->deriveSecrets($seed, "WhisperGroup" /* from: "WhisperGroup".getBytes() */, 48);
            /* match: 21c8b6ca */
        $parts = ByteUtil::split_21c8b6ca($derivative, 16, 32);
        $me->iteration = $iteration;
        $me->seed = $seed;
        $me->iv = $parts[0];
        $me->cipherKey = $parts[1];
        return $me;
    }
    public function getIteration ()
    {
        return $this->iteration;
    }
    public function getIv ()
    {
        return $this->iv;
    }
    public function getCipherKey ()
    {
        return $this->cipherKey;
    }
    public function getSeed ()
    {
        return $this->seed;
    }
}
SenderMessageKey::__staticinit(); // initialize static vars for this class on load
