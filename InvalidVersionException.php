<?php
class InvalidVersionException extends Exception {
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	public static function constructor__943a4c31 ($detailMessage) // [String detailMessage]
	{
		$me = new self();
		$me->__init();
		/* constructor resolution using types matched overloadcode: */
		parent::constructor__($detailMessage);
		return $me;
	}
}
InvalidVersionException::__staticinit(); // initialize static vars for this class on load
?>
