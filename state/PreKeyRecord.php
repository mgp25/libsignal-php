<?php
require_once("com/google/protobuf/ByteString.php");
require_once("InvalidKeyException.php");
require_once("ecc/Curve.php");
require_once("ecc/ECKeyPair.php");
require_once("ecc/ECPrivateKey.php");
require_once("ecc/ECPublicKey.php");
require_once("java/io/IOException.php");
require_once("state/StorageProtos/PreKeyRecordStructure.php");
class PreKeyRecord {
    protected $structure;    // PreKeyRecordStructure
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__99f1230b ($id, $keyPair) // [int id, ECKeyPair keyPair]
    {
        $me = new self();
        $me->__init();
        $me->structure = $PreKeyRecordStructure->newBuilder()->setId($id)->setPublicKey($ByteString->copyFrom($keyPair->getPublicKey()->serialize()))->setPrivateKey($ByteString->copyFrom($keyPair->getPrivateKey()->serialize()))->build();
        return $me;
    }
    public static function constructor__ae1a4a6a ($serialized) // [byte[] serialized]
    {
        $me = new self();
        $me->__init();
        $me->structure = $PreKeyRecordStructure->parseFrom($serialized);
        return $me;
    }
    public function getId ()
    {
        return $this->structure->getId();
    }
    public function getKeyPair ()
    {
        try
        {
            $publicKey = Curve::decodePoint($this->structure->getPublicKey()->toByteArray(), 0);
            $privateKey = Curve::decodePrivatePoint($this->structure->getPrivateKey()->toByteArray());
            return ECKeyPair::constructor__43f151c1($publicKey, $privateKey);
        }
        catch (InvalidKeyException $e)
        {
            throw new AssertionError($e);
        }
    }
    public function serialize ()
    {
        return $this->structure->toByteArray();
    }
}
PreKeyRecord::__staticinit(); // initialize static vars for this class on load
