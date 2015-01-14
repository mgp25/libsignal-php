<?php
interface Supplier {
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	abstract function get (); 
}
Supplier::__staticinit(); // initialize static vars for this class on load
?>
