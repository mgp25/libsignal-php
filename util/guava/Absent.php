<?php
require_once("util/guava/Preconditions/checkNotNull.php");
require_once("java/util/Collections.php");
require_once("java/util/Set.php");
class Absent extends Optional {
    protected static $INSTANCE;    // Absent
    protected static $serialVersionUID;    // long
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$INSTANCE = Absent::constructor__();
        self::$serialVersionUID = 0;
    }
    public function isPresent ()
    {
        return  FALSE ;
    }
    public function get ()
    {
        throw new IllegalStateException("value is absent");
    }
    public function or_8c658f5f ($defaultValue) // [Object defaultValue]
    {
        return ???::checkNotNull($defaultValue, "use orNull() instead of or(null)")/* unable to resolve this call */;
    }
    public function or_4e24099b ($secondChoice) // [Optional<?> secondChoice]
    {
        return ???::checkNotNull($secondChoice)/* unable to resolve this call */;
    }
    public function or_463cb3af ($supplier) // [Supplier<?> supplier]
    {
        return ???::checkNotNull($supplier->get(), "use orNull() instead of a Supplier that returns null")/* unable to resolve this call */;
    }
    public function orNull ()
    {
        return null;
    }
    public function asSet ()
    {
        return $Collections->emptySet();
    }
    public function transform ($function) // [Function<? super Object, V> function]
    {
        ???::checkNotNull($function)/* unable to resolve this call */;
        return Optional::absent();
    }
    public function equals ($object) // [Object object]
    {
        return ($object == $this);
    }
    public function hashCode ()
    {
        return 0x598df91c;
    }
    public function toString ()
    {
        return "Optional.absent()";
    }
    protected function readResolve ()
    {
        return self::$INSTANCE;
    }
}
Absent::__staticinit(); // initialize static vars for this class on load
?>
