<?php
namespace Libsignal\Tests;
//from axolotl.state.prekeystore import PreKeyStore
//from axolotl.state.prekeyrecord import PreKeyRecord
//from axolotl.invalidkeyidexception import InvalidKeyIdException
use Libsignal\state\PreKeyStore;
use Libsignal\state\PreKeyRecord;
use Libsignal\exceptions\InvalidKeyIdException;

class InMemoryPreKeyStore extends PreKeyStore
{
    protected $store;

    public function __construct()
    {
        $this->store = [];
    }

    public function loadPreKey($preKeyId)
    {
        if (!isset($this->store[$preKeyId])) {
            throw new InvalidKeyIdException('No such prekeyRecord!');
        }

        return new PreKeyRecord(null, null, $this->store[$preKeyId]);
    }

    public function storePreKey($preKeyId, $preKeyRecord)
    {
        $this->store[$preKeyId] = $preKeyRecord->serialize();
    }

    public function containsPreKey($preKeyId)
    {
        return isset($this->store[$preKeyId]);
    }

    public function removePreKey($preKeyId)
    {
        if (isset($this->store[$preKeyId])) {
            unset($this->store[$preKeyId]);
        }
    }
}
