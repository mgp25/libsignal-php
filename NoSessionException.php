<?php
class NoSessionException extends Exception {
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
    public static function constructor__cfc1f02f ($nested) // [Exception nested]
    {
        $me = new self();
        $me->__init();
        /* constructor resolution using types matched overloadcode: */
        parent::constructor__($nested);
        return $me;
    }
}
NoSessionException::__staticinit(); // initialize static vars for this class on load
?>
