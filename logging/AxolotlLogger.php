<?php
interface AxolotlLogger {
    public static $VERBOSE;    // int
    public static $DEBUG;    // int
    public static $INFO;    // int
    public static $WARN;    // int
    public static $ERROR;    // int
    public static $ASSERT;    // int
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$VERBOSE = 2;
        self::$DEBUG = 3;
        self::$INFO = 4;
        self::$WARN = 5;
        self::$ERROR = 6;
        self::$ASSERT = 7;
    }
    abstract function log ($priority, $tag, $message); // [int priority, String tag, String message]
}
AxolotlLogger::__staticinit(); // initialize static vars for this class on load
