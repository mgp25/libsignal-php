<?php
class AxolotlLoggerProvider {
	protected static $provider;	// AxolotlLogger
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	public static function getProvider () 
	{
		return self::$provider;
	}
	public static function setProvider ($provider) // [AxolotlLogger provider]
	{
		AxolotlLoggerProvider::$provider = $provider;
	}
}
AxolotlLoggerProvider::__staticinit(); // initialize static vars for this class on load
?>
