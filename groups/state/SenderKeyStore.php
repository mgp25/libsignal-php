<?php
interface SenderKeyStore {
    public function storeSenderKey ($senderKeyId, $record); // [String senderKeyId, SenderKeyRecord record]
    public function loadSenderKey ($senderKeyId); // [String senderKeyId]
}
