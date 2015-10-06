<?php
require_once("util/guava/Preconditions/checkNotNull.php");
require_once("java/io/Serializable.php");
require_once("java/util/Iterator.php");
require_once("java/util/Set.php");
abstract class Optional implements Serializable {
    protected static $serialVersionUID;    // long
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$serialVersionUID = 0;
    }
    public static function absent ()
    {
        return Absent::$INSTANCE;
    }
    public static function of ($reference) // [T reference]
    {
        return Present::constructor__54(Helper::checkNotNull($reference)/* unable to resolve this call */);
    }
    public static function fromNullable ($nullableReference) // [T nullableReference]
    {
        return ( ((($nullableReference == null))) ? Optional::absent() : Present::constructor__54($nullableReference) );
    }
    public static function constructor__ ()
    {
        $me = new self();
        $me->__init();
        return $me;
    }
    abstract function isPresent ();
    abstract function get ();
    abstract function or_54 ($defaultValue); // [T defaultValue]
    abstract function or_426e7c8e ($secondChoice); // [Optional<? extends T> secondChoice]
    abstract function or_7d189da2 ($supplier); // [Supplier<? extends T> supplier]
    abstract function orNull ();
    abstract function asSet ();
    abstract function transform ($function); // [Function<? super T, V> function]
    abstract function equals ($object); // [Object object]
    abstract function hashCode ();
    abstract function toString ();
}
Optional::__staticinit(); // initialize static vars for this class on load
