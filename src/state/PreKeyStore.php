<?php
namespace Libsignal\state;

abstract class PreKeyStore
{

    /**
     * @param int $preKeyId
     * @return PreKeyRecord
     */
    abstract public function loadPreKey($preKeyId);

    /**
     * @param int $preKeyId
     * @param PreKeyRecord $record
     * @return mixed
     */
    abstract public function storePreKey($preKeyId, $record);

    /**
     * @param int $preKeyId
     * @return mixed
     */
    abstract public function containsPreKey($preKeyId);

    /**
     * @param int $preKeyId
     * @return mixed
     */
    abstract public function removePreKey($preKeyId);

}