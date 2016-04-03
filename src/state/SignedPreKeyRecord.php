<?php
namespace Libaxolotl\state;

use Libaxolotl\ecc\Curve;
use Libaxolotl\ecc\ECKeyPair;
use Libaxolotl\ecc\ECPrivateKey;
use Libaxolotl\ecc\ECPublicKey;
use Libaxolotl\exceptions\InvalidKeyException;
use Localstorage\SignedPreKeyRecordStructure as Textsecure_SignedPreKeyRecordStructure;

class SignedPreKeyRecord
{
    protected $structure;

    public function __construct($id = null, $timestamp = null, $keyPair = null, $signature = null, $serialized = null) // [int id, long timestamp, ECKeyPair keyPair, byte[] signature]
    {
        $struct = new Textsecure_SignedPreKeyRecordStructure();
        if ($serialized == null) {
            $struct->setId($id);
            $struct->setPublicKey((string) $keyPair->getPublicKey()->serialize());
            $struct->setPrivateKey((string) $keyPair->getPrivateKey()->serialize());
            $struct->setSignature((string) $signature);
            $struct->setTimestamp($timestamp);
        } else {
            $struct->parseFromString($serialized);
        }
        $this->structure = $struct; //$SignedPreKeyRecordStructure->newBuilder()->setId($id)->setPublicKey($ByteString->copyFrom($keyPair->getPublicKey()->serialize()))->setPrivateKey($ByteString->copyFrom($keyPair->getPrivateKey()->serialize()))->setSignature($ByteString->copyFrom($signature))->setTimestamp($timestamp)->build();
    }

    public function getId()
    {
        return $this->structure->getId();
    }

    public function getTimestamp()
    {
        return $this->structure->getTimestamp();
    }

    public function getKeyPair()
    {
        try {
            $publicKey = Curve::decodePoint($this->structure->getPublicKey(), 0);
            $privateKey = Curve::decodePrivatePoint($this->structure->getPrivateKey());

            return  new ECKeyPair($publicKey, $privateKey);
        } catch (InvalidKeyException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getSignature()
    {
        return $this->structure->getSignature();
    }

    public function serialize()
    {
        return $this->structure->serializeToString();
    }
}
