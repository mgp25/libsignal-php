<?php
namespace Libsignal\state;

abstract class PreKeyStore
{

    /**
     * @param string $preKeyId
     * @return PreKeyRecord
     */
    abstract public function loadPreKey($preKeyId);

 // [int preKeyId]

    abstract public function storePreKey($preKeyId, $record);

 // [int preKeyId, PreKeyRecord record]

    abstract public function containsPreKey($preKeyId);

 // [int preKeyId]

    abstract public function removePreKey($preKeyId);

 // [int preKeyId]
}
