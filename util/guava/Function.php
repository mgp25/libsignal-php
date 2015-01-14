<?php
interface Function {
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	abstract function apply ($input); // [F input]
	abstract function equals ($object); // [Object object]
}
Function::__staticinit(); // initialize static vars for this class on load
?>
