<?php
namespace Libsignal\kdf;

use Libsignal\util\ByteUtil;

class DerivedRootSecrets{

    const SIZE = 64;    // int
    protected $rootKey;    // byte[]
    protected $chainKey;    // byte[]

    public function __construct($okm) // [byte[] okm]
    {
        $keys = ByteUtil::split($okm, 32, 32);
        $this->rootKey = $keys[0];
        $this->chainKey = $keys[1];
    }

    public function getRootKey()
    {
        return $this->rootKey;
    }

    public function getChainKey()
    {
        return $this->chainKey;
    }

}