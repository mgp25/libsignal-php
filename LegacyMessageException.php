<?php
class LegacyMessageException extends Exception {
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	public static function constructor__943a4c31 ($s) // [String s]
	{
		$me = new self();
		$me->__init();
		/* constructor resolution using types matched overloadcode: */
		parent::constructor__($s);
		return $me;
	}
}
LegacyMessageException::__staticinit(); // initialize static vars for this class on load
?>
