<?php
require_once("InvalidKeyIdException.php");
require_once("java/util/List.php");
interface SignedPreKeyStore {
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    abstract function loadSignedPreKey ($signedPreKeyId); // [int signedPreKeyId]
    abstract function loadSignedPreKeys ();
    abstract function storeSignedPreKey ($signedPreKeyId, $record); // [int signedPreKeyId, SignedPreKeyRecord record]
    abstract function containsSignedPreKey ($signedPreKeyId); // [int signedPreKeyId]
    abstract function removeSignedPreKey ($signedPreKeyId); // [int signedPreKeyId]
}
SignedPreKeyStore::__staticinit(); // initialize static vars for this class on load
