<?php
interface ECPrivateKey {
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	abstract function serialize (); 
	abstract function getType (); 
}
ECPrivateKey::__staticinit(); // initialize static vars for this class on load
?>
