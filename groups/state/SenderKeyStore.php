<?php
interface SenderKeyStore {
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    abstract function storeSenderKey ($senderKeyId, $record); // [String senderKeyId, SenderKeyRecord record]
    abstract function loadSenderKey ($senderKeyId); // [String senderKeyId]
}
SenderKeyStore::__staticinit(); // initialize static vars for this class on load
?>
