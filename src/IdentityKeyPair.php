<?php
namespace Libsignal;

use Localstorage\IdentityKeyPairStructure as Textsecure_IdentityKeyPairStructure;
use Libsignal\ecc\Curve;

class IdentityKeyPair
{
    protected $publicKey;    // IdentityKey
    protected $privateKey;    // ECPrivateKey

    public function __construct($publicKey = null, $privateKey = null, $serialized = null) // [IdentityKey publicKey, ECPrivateKey privateKey]
    {
        if ($serialized == null) {
            $this->publicKey = $publicKey;
            $this->privateKey = $privateKey;
        } else {
            $structure = new Textsecure_IdentityKeyPairStructure();
            $structure->mergeFromString($serialized);
            $this->publicKey = new IdentityKey($structure->getPublicKey(), 0);
            $this->privateKey = Curve::decodePrivatePoint($structure->getPrivateKey());
        }
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function serialize()
    {
        $struct = new Textsecure_IdentityKeyPairStructure();

        return $struct->setPublicKey((string) $this->publicKey->serialize())->setPrivateKey((string) $this->privateKey->serialize())->serializeToString();
    }
}
