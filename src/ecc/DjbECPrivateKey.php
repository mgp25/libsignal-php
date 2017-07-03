<?php
namespace Libsignal\ecc;

class DjbECPrivateKey implements ECPrivateKey
{
    protected $privateKey;    // byte[] --> php string now

    public function __construct($privateKey) // [byte[] privateKey]
    {
        $this->privateKey = $privateKey;
    }

    public function serialize()
    {
        return $this->privateKey;
    }

    public function getType()
    {
        return Curve::DJB_TYPE;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }
}
