<?php
require_once("java/util/List.php");
interface SessionStore {
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    abstract function loadSession ($recipientId, $deviceId); // [long recipientId, int deviceId]
    abstract function getSubDeviceSessions ($recipientId); // [long recipientId]
    abstract function storeSession ($recipientId, $deviceId, $record); // [long recipientId, int deviceId, SessionRecord record]
    abstract function containsSession ($recipientId, $deviceId); // [long recipientId, int deviceId]
    abstract function deleteSession ($recipientId, $deviceId); // [long recipientId, int deviceId]
    abstract function deleteAllSessions ($recipientId); // [long recipientId]
}
SessionStore::__staticinit(); // initialize static vars for this class on load
?>
