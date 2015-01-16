<?php
require_once("com/google/protobuf/ByteString.php");
require_once("InvalidKeyException.php");
require_once("ecc/Curve.php");
require_once("ecc/ECKeyPair.php");
require_once("ecc/ECPrivateKey.php");
require_once("ecc/ECPublicKey.php");
require_once("java/io/IOException.php");
require_once("state/StorageProtos/SignedPreKeyRecordStructure.php");
class SignedPreKeyRecord {
    protected $structure;    // SignedPreKeyRecordStructure
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__e1c77ae1 ($id, $timestamp, $keyPair, $signature) // [int id, long timestamp, ECKeyPair keyPair, byte[] signature]
    {
        $me = new self();
        $me->__init();
        $me->structure = $SignedPreKeyRecordStructure->newBuilder()->setId($id)->setPublicKey($ByteString->copyFrom($keyPair->getPublicKey()->serialize()))->setPrivateKey($ByteString->copyFrom($keyPair->getPrivateKey()->serialize()))->setSignature($ByteString->copyFrom($signature))->setTimestamp($timestamp)->build();
        return $me;
    }
    public static function constructor__ae1a4a6a ($serialized) // [byte[] serialized]
    {
        $me = new self();
        $me->__init();
        $me->structure = $SignedPreKeyRecordStructure->parseFrom($serialized);
        return $me;
    }
    public function getId ()
    {
        return $this->structure->getId();
    }
    public function getTimestamp ()
    {
        return $this->structure->getTimestamp();
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
    public function getSignature ()
    {
        return $this->structure->getSignature()->toByteArray();
    }
    public function serialize ()
    {
        return $this->structure->toByteArray();
    }
}
SignedPreKeyRecord::__staticinit(); // initialize static vars for this class on load
?>
