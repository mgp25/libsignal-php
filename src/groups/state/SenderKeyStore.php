<?php
namespace Libsignal\groups\state;

abstract class SenderKeyStore{

    /**
     * @param string $senderKeyId
     * @param SenderKeyRecord $record
     * @return mixed
     */
    abstract public function storeSenderKey($senderKeyId, $record);

    /**
     * @param string $senderKeyId
     * @return mixed
     */
    abstract public function loadSenderKey($senderKeyId);

}