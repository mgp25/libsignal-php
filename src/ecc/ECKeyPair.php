<?php
namespace Libsignal\ecc;

class ECKeyPair{

    /**
     * @var ECPublicKey $publicKey
     */
    protected $publicKey;
    /**
     * @var ECPrivateKey $privateKey
     */
    protected $privateKey;

    /**
     * ECKeyPair constructor.
     * @param ECPublicKey $publicKey
     * @param ECPrivateKey$privateKey
     */
    public function __construct($publicKey, $privateKey){
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

}