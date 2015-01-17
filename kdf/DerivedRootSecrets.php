<?php
require_once("util/ByteUtil.php");
class DerivedRootSecrets {
    public static $SIZE;    // int
    protected $rootKey;    // byte[]
    protected $chainKey;    // byte[]
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$SIZE = 64;
    }
    public static function constructor__ae1a4a6a ($okm) // [byte[] okm]
    {
        $me = new self();
        $me->__init();
            /* match: 21c8b6ca */
        $keys = ByteUtil::split_21c8b6ca($okm, 32, 32);
        $me->rootKey = $keys[0];
        $me->chainKey = $keys[1];
        return $me;
    }
    public function getRootKey ()
    {
        return $this->rootKey;
    }
    public function getChainKey ()
    {
        return $this->chainKey;
    }
}
DerivedRootSecrets::__staticinit(); // initialize static vars for this class on load
