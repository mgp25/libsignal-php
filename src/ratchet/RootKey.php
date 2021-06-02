<?php
namespace Libsignal\ratchet;

use Libsignal\kdf\DerivedRootSecrets;
use Libsignal\ecc\Curve;

class RootKey
{
    protected $kdf;
    protected $key;

    public function __construct($kdf, $key)
    {
        $this->kdf = $kdf;
        $this->key = $key;
    }

    public function getKeyBytes()
    {
        return $this->key;
    }

    /**
     * @param $ECPublicKey_theirRatchetKey
     * @param $ECKeyPair_ourRatchetKey
     * @return RootKey[]
     * @throws \Libsignal\exceptions\InvalidKeyException
     */
    public function createChain($ECPublicKey_theirRatchetKey, $ECKeyPair_ourRatchetKey)
    {
        $sharedSecret = Curve::calculateAgreement($ECPublicKey_theirRatchetKey, $ECKeyPair_ourRatchetKey->getPrivateKey());

        $derivedSecretBytes = $this->kdf->deriveSecrets($sharedSecret, 'WhisperRatchet', DerivedRootSecrets::SIZE, $this->key);
        $derivedSecrets = new DerivedRootSecrets($derivedSecretBytes);
        $newRootKey = new self($this->kdf, $derivedSecrets->getRootKey());
        $newChainKey = new ChainKey($this->kdf, $derivedSecrets->getChainKey(), 0);

        return [$newRootKey, $newChainKey];
    }
}
