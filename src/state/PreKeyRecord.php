<?php
namespace Libaxolotl\state;

use Libaxolotl\ecc\Curve;
use Libaxolotl\ecc\ECKeyPair;
use Libaxolotl\ecc\ECPrivateKey;
use Libaxolotl\ecc\ECPublicKey;
use Libaxolotl\exceptions\InvalidKeyException;

class PreKeyRecord
{
    protected $structure;    // PreKeyRecordStructure

    public function __construct($id = null, $keyPair = null, $serialized = null) // [int id, ECKeyPair keyPair]
    {
        $this->structure = new Textsecure_PreKeyRecordStructure();
        if ($serialized == null) {
            $this->structure->setId($id)->setPublicKey((string) $keyPair->getPublicKey()->serialize())->setPrivateKey((string) $keyPair->getPrivateKey()->serialize());
        } else {
            try {
                $this->structure->parseFromString($serialized);
            } catch (Exception $ex) {
                throw new Exception('Cannot unserialize PreKEyRecordStructure');
            }
        }
    }

    public function getId()
    {
        return $this->structure->getId();
    }

    public function getKeyPair()
    {
        $publicKey = Curve::decodePoint($this->structure->getPublicKey(), 0);
        $privateKey = Curve::decodePrivatePoint($this->structure->getPrivateKey());

        return new ECKeyPair($publicKey, $privateKey);
    }

    public function serialize()
    {
        return $this->structure->serializeToString();
    }
}
