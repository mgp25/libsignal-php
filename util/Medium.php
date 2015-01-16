<?php
class Medium {
    public static $MAX_VALUE;    // int
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$MAX_VALUE = 0xFFFFFF;
    }
}
Medium::__staticinit(); // initialize static vars for this class on load
?>
