<?php
namespace Libsignal\groups\state;

use Libsignal\ecc\Curve;
use Libsignal\ecc\DjbECPrivateKey;
use Libsignal\ecc\DjbECPublicKey;
use Libsignal\ecc\ECKeyPair;
use Libsignal\ratchet\ChainKey;
use Localstorage\SenderKeyStateStructure;
use Localstorage\SenderKeyStateStructure\SenderChainKey as Textsecure_SenderKeyStateStructure_SenderChainKey;
use Localstorage\SenderKeyStateStructure\SenderSigningKey as Textsecure_SenderKeyStateStructure_SenderSigningKey;
use Localstorage\SenderKeyStateStructure\SenderMessageKey as Textsecure_SenderKeyStateStructure_SenderMessageKey;
use Libsignal\groups\ratchet\SenderChainKey;
use Libsignal\groups\ratchet\SenderMessageKey;

class SenderKeyState{

    /**
     * @var SenderKeyStateStructure $senderKeyStateStructure
     */
    protected $senderKeyStateStructure;
    /**
     * @var Textsecure_SenderKeyStateStructure_SenderChainKey
     */
    protected $senderChainKey;

    /**
     * SenderKeyState constructor.
     * @param null $id
     * @param $iteration
     * @param ChainKey $chainKey
     * @param DjbECPublicKey $signatureKeyPublic
     * @param DjbECPrivateKey $signatureKeyPrivate
     * @param ECKeyPair $signatureKeyPair
     * @param SenderKeyStateStructure $senderKeyStateStructure
     */
    public function __construct($id = null, $iteration = null, $chainKey = null,
                 $signatureKeyPublic = null, $signatureKeyPrivate = null,
                 $signatureKeyPair = null, $senderKeyStateStructure = null)
    {

        /*if(!(($id && $iteration && $chainKey) || ($senderKeyStateStructure ^ ($signatureKeyPublic || $signatureKeyPair))
         || ($signatureKeyPublic ^ $signatureKeyPair)))
        {
            throw new Exception("Missing required arguments");
        }*/

        if ($senderKeyStateStructure) {
            $this->senderKeyStateStructure = $senderKeyStateStructure;
        } else {
            if ($signatureKeyPair != null) {
                $signatureKeyPublic = $signatureKeyPair->getPublicKey();
                $signatureKeyPrivate = $signatureKeyPair->getPrivateKey();
            }

            $this->senderKeyStateStructure = new SenderKeyStateStructure();
            $senderChainKeyStructure = $this->senderKeyStateStructure->getSenderChainKey();
            if ($senderChainKeyStructure == null) {
                $senderChainKeyStructure = new Textsecure_SenderKeyStateStructure_SenderChainKey();
                $this->senderKeyStateStructure->setSenderChainKey($senderChainKeyStructure);
            }

            $this->senderKeyStateStructure->getSenderChainKey()->setIteration($iteration);
            $this->senderKeyStateStructure->getSenderChainKey()->setSeed($chainKey);

            $signingKeyStructure = $this->senderKeyStateStructure->getSenderSigningKey();
            if ($signingKeyStructure == null) {
                $signingKeyStructure = new Textsecure_SenderKeyStateStructure_SenderSigningKey();
                $this->senderKeyStateStructure->setSenderSigningKey($signingKeyStructure);
            }
            $this->senderKeyStateStructure->getSenderSigningKey()->setPublic($signatureKeyPublic->serialize());

            if ($signatureKeyPrivate) {
                $this->senderKeyStateStructure->getSenderSigningKey()->setPrivate($signatureKeyPrivate->serialize());
            }

            $this->senderKeyStateStructure->setSenderKeyId($id);
            $this->senderChainKey = $senderChainKeyStructure;
            $this->senderKeyStateStructure->setSenderSigningKey($signingKeyStructure);
        }
    }

    public function getKeyId()
    {
        return $this->senderKeyStateStructure->getSenderKeyId();
    }

    public function getSenderChainKey()
    {
        return new SenderChainKey($this->senderKeyStateStructure->getSenderChainKey()->getIteration(),
                              $this->senderKeyStateStructure->getSenderChainKey()->getSeed());
    }

    /**
     * @param SenderChainKey $chainKey
     */
    public function setSenderChainKey($chainKey)
    {
        $this->senderKeyStateStructure->getSenderChainKey()->setIteration($chainKey->getIteration());
        $this->senderKeyStateStructure->getSenderChainKey()->setSeed($chainKey->getSeed());
    }

    /**
     * @return DjbECPublicKey
     * @throws \Libsignal\exceptions\InvalidKeyException
     */
    public function getSigningKeyPublic()
    {
        return Curve::decodePoint($this->senderKeyStateStructure->getSenderSigningKey()->getPublic(), 0);
    }

    public function getSigningKeyPrivate()
    {
        return Curve::decodePrivatePoint($this->senderKeyStateStructure->getSenderSigningKey()->getPrivate());
    }

    public function hasSenderMessageKey($iteration)
    {
        foreach ($this->senderKeyStateStructure->getSenderMessageKeys() as $senderMessageKey) {
            if ($senderMessageKey->getIteration() == $iteration) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param SenderMessageKey $senderMessageKey
     */
    public function addSenderMessageKey($senderMessageKey)
    {
        $smk = new Textsecure_SenderKeyStateStructure_SenderMessageKey();
        $smk->setIteration($senderMessageKey->getIteration());
        $smk->setSeed($senderMessageKey->getSeed());
        $this->senderKeyStateStructure->appendSenderMessageKeys($smk);
    }

    public function removeSenderMessageKey($iteration)
    {
        $keys = $this->senderKeyStateStructure->getSenderMessageKeys();
        $result = null;

        for ($i = 0; $i < count($keys); $i++) {
            $senderMessageKey = $keys[$i];
            if ($senderMessageKey->getIteration() == $iteration) {
                $result = $senderMessageKey;
                unset($keys[$i]);
                break;
            }
        }
        $this->senderKeyStateStructure->clearSenderMessageKeys();
        foreach ($keys as $key) {
            $this->senderKeyStateStructure->appendSenderMessageKeys($key);
        }

        if (!is_null($result)) {
            return new SenderMessageKey($result->getIteration(), $result->getSeed());
        }

        return null;
    }

    public function getStructure()
    {
        return $this->senderKeyStateStructure;
    }
}
