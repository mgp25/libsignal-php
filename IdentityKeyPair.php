<?php
require_once("com/google/protobuf/ByteString.php");
require_once("com/google/protobuf/InvalidProtocolBufferException.php");
require_once("ecc/Curve.php");
require_once("ecc/ECPrivateKey.php");
require_once("state/StorageProtos/IdentityKeyPairStructure.php");
class IdentityKeyPair {
    protected $publicKey;    // IdentityKey
    protected $privateKey;    // ECPrivateKey
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__b6659ff8 ($publicKey, $privateKey) // [IdentityKey publicKey, ECPrivateKey privateKey]
    {
        $me = new self();
        $me->__init();
        $me->publicKey = $publicKey;
        $me->privateKey = $privateKey;
        return $me;
    }
    public static function constructor__ae1a4a6a ($serialized) // [byte[] serialized]
    {
        $me = new self();
        $me->__init();
        try
        {
            $structure = $IdentityKeyPairStructure->parseFrom($serialized);
            $me->publicKey = IdentityKey::constructor__29e7cc9a($structure->getPublicKey()->toByteArray(), 0);
            $me->privateKey = Curve::decodePrivatePoint($structure->getPrivateKey()->toByteArray());
        }
        catch (InvalidProtocolBufferException $e)
        {
            throw InvalidKeyException::constructor__($e);
        }
        return $me;
    }
    public function getPublicKey ()
    {
        return $this->publicKey;
    }
    public function getPrivateKey ()
    {
        return $this->privateKey;
    }
    public function serialize ()
    {
        return $IdentityKeyPairStructure->newBuilder()->setPublicKey($ByteString->copyFrom($this->publicKey->serialize()))->setPrivateKey($ByteString->copyFrom($this->privateKey->serialize()))->build()->toByteArray();
    }
}
IdentityKeyPair::__staticinit(); // initialize static vars for this class on load
