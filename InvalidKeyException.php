<?php
class InvalidKeyException extends Exception {
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__ ()
    {
        $me = new self();
        $me->__init();
        return $me;
    }
    public static function constructor__943a4c31 ($detailMessage) // [String detailMessage]
    {
        $me = new self();
        $me->__init();
        /* constructor resolution using types matched overloadcode: */
        parent::constructor__($detailMessage);
        return $me;
    }
    public static function constructor__2c997920 ($throwable) // [Throwable throwable]
    {
        $me = new self();
        $me->__init();
        /* constructor resolution using types matched overloadcode: */
        parent::constructor__($throwable);
        return $me;
    }
    public static function constructor__4c6bf692 ($detailMessage, $throwable) // [String detailMessage, Throwable throwable]
    {
        $me = new self();
        $me->__init();
        /* constructor resolution using types matched overloadcode: */
        parent::constructor__($detailMessage, $throwable);
        return $me;
    }
}
InvalidKeyException::__staticinit(); // initialize static vars for this class on load
?>
