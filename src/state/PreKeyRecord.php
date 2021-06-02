<?php
namespace Libsignal\state;

use Exception;
use Libsignal\ecc\Curve;
use Libsignal\ecc\ECKeyPair;
use Localstorage\PreKeyRecordStructure;

class PreKeyRecord{

    /**
     * @var PreKeyRecordStructure $structure
     */
    protected $structure;

    /**
     * PreKeyRecord constructor.
     * @param null $id
     * @param ECKeyPair $keyPair
     * @param null $serialized
     * @throws Exception
     */
    public function __construct($id = null, $keyPair = null, $serialized = null) // [int id, ECKeyPair keyPair]
    {
        $this->structure = new PreKeyRecordStructure();
        if ($serialized == null) {
            $this->structure->setId($id)->setPublicKey((string) $keyPair->getPublicKey()->serialize())->setPrivateKey((string) $keyPair->getPrivateKey()->serialize());
        } else {
            try {
                $this->structure->mergeFromString($serialized);
            } catch (Exception $ex) {
                throw new Exception('Cannot unserialize PreKEyRecordStructure');
            }
        }
    }

    public function getId()
    {
        return $this->structure->getId();
    }

    /**
     * @return ECKeyPair
     * @throws \Libsignal\exceptions\InvalidKeyException
     */
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
