<?php
namespace Libsignal\Tests;

//from axolotl.state.signedprekeystore import SignedPreKeyStore
//from axolotl.state.signedprekeyrecord import SignedPreKeyRecord
//from axolotl.invalidkeyidexception import InvalidKeyIdException
use Libsignal\state\SignedPreKeyStore;
use Libsignal\state\SignedPreKeyRecord;
use Libsignal\exceptions\InvalidKeyIdException;

class InMemorySignedPreKeyStore extends SignedPreKeyStore
{
    protected $store;

    public function __construct()
    {
        $this->store = [];
    }

    public function loadSignedPreKey($signedPreKeyId)
    {
        if (!isset($this->store[$signedPreKeyId])) {
            throw new  InvalidKeyIdException('No such signedprekeyrecord! '.$signedPreKeyId);
        }

        return new  SignedPreKeyRecord(null, null, null, null, $this->store[$signedPreKeyId]);
    }

    public function loadSignedPreKeys()
    {
        $results = [];
        foreach ($this->store as $serialized) {
            $results[] = new SignedPreKeyRecord(null, null, null, null, $serialized);
        }

        return $results;
    }

    public function storeSignedPreKey($signedPreKeyId, $signedPreKeyRecord)
    {
        $this->store[$signedPreKeyId] = $signedPreKeyRecord->serialize();
    }

    public function containsSignedPreKey($signedPreKeyId)
    {
        return isset($this->store[$signedPreKeyId]);
    }

    public function removeSignedPreKey($signedPreKeyId)
    {
        unset($this->store[$signedPreKeyId]);
    }
}
