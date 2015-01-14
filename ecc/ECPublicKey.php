<?php
interface ECPublicKey extends Comparable {
	public static $KEY_SIZE;	// int
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
		self::$KEY_SIZE = 33;
	}
	abstract function serialize (); 
	abstract function getType (); 
}
ECPublicKey::__staticinit(); // initialize static vars for this class on load
?>
