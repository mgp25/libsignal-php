<?php
require_once("InvalidKeyIdException.php");
interface PreKeyStore {
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    abstract function loadPreKey ($preKeyId); // [int preKeyId]
    abstract function storePreKey ($preKeyId, $record); // [int preKeyId, PreKeyRecord record]
    abstract function containsPreKey ($preKeyId); // [int preKeyId]
    abstract function removePreKey ($preKeyId); // [int preKeyId]
}
PreKeyStore::__staticinit(); // initialize static vars for this class on load
?>
