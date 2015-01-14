<?php
require_once("IdentityKey.php");
require_once("IdentityKeyPair.php");
interface IdentityKeyStore {
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	abstract function getIdentityKeyPair ();
	abstract function getLocalRegistrationId ();
	abstract function saveIdentity ($recipientId, $identityKey); // [long recipientId, IdentityKey identityKey]
	abstract function isTrustedIdentity ($recipientId, $identityKey); // [long recipientId, IdentityKey identityKey]
}
IdentityKeyStore::__staticinit(); // initialize static vars for this class on load
?>
