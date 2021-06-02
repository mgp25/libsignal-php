<?php
namespace Libsignal\ecc;

class DjbECPrivateKey implements ECPrivateKey{

    /**
     * @var string $privateKey
     */
    protected $privateKey;

    /**
     * DjbECPrivateKey constructor.
     * @param string $privateKey
     */
    public function __construct($privateKey){
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
