<?php
namespace Libsignal\groups\ratchet;

use Libsignal\kdf\HKDFv3;
use Libsignal\util\ByteUtil;

class SenderMessageKey
{
    protected $iteration;    // int
    protected $iv;    // byte[]
    protected $cipherKey;    // byte[]
    protected $seed;    // byte[]

    public function __construct($iteration, $seed) // [int iteration, byte[] seed]
    {
        $hkdf = new HKDFv3();
        $derivative = $hkdf->deriveSecrets($seed, 'WhisperGroup', 48);
            /* match: 21c8b6ca */
        $parts = ByteUtil::split($derivative, 16, 32);
        $this->iteration = $iteration;
        $this->seed = $seed;
        $this->iv = $parts[0];
        $this->cipherKey = $parts[1];
    }

    public function getIteration()
    {
        return $this->iteration;
    }

    public function getIv()
    {
        return $this->iv;
    }

    public function getCipherKey()
    {
        return $this->cipherKey;
    }

    public function getSeed()
    {
        return $this->seed;
    }
}
