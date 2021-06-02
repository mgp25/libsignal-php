<?php
namespace Libsignal\state;

abstract class SignedPreKeyStore
{
    /**
     * @param string $signedPreKeyId
     * @return SignedPreKeyRecord
     */
    abstract public function loadSignedPreKey($signedPreKeyId);

 // [int signedPreKeyId]

    abstract public function loadSignedPreKeys();

    abstract public function storeSignedPreKey($signedPreKeyId, $record);

 // [int signedPreKeyId, SignedPreKeyRecord record]

    abstract public function containsSignedPreKey($signedPreKeyId);

 // [int signedPreKeyId]

    abstract public function removeSignedPreKey($signedPreKeyId);

 // [int signedPreKeyId]
}
