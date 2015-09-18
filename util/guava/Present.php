<?php
require_once("util/guava/Preconditions/checkNotNull.php");
require_once("java/util/Collections.php");
require_once("java/util/Set.php");
class Present extends Optional {
    protected $reference;    // T
    protected static $serialVersionUID;    // long
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$serialVersionUID = 0;
    }
    public static function constructor__54 ($reference) // [T reference]
    {
        $me = new self();
        $me->__init();
        $me->reference = $reference;
        return $me;
    }
    public function isPresent ()
    {
        return  TRUE ;
    }
    public function get ()
    {
        return $this->reference;
    }
    public function or_54 ($defaultValue) // [T defaultValue]
    {
        Helper::checkNotNull($defaultValue, "use orNull() instead of or(null)")/* unable to resolve this call */;
        return $this->reference;
    }
    public function or_426e7c8e ($secondChoice) // [Optional<? extends T> secondChoice]
    {
        Helper::checkNotNull($secondChoice)/* unable to resolve this call */;
        return $this;
    }
    public function or_7d189da2 ($supplier) // [Supplier<? extends T> supplier]
    {
        Helper::checkNotNull($supplier)/* unable to resolve this call */;
        return $this->reference;
    }
    public function orNull ()
    {
        return $this->reference;
    }
    public function asSet ()
    {
        return $Collections->singleton($this->reference);
    }
    public function transform ($function) // [Function<? super T, V> function]
    {
        return Present::constructor__54(Helper::checkNotNull($function->apply($this->reference), "Transformation function cannot return null.")/* unable to resolve this call */);
    }
    public function equals ($object) // [Object object]
    {
        if ($object instanceof Present)
        {
            $other = $object;
            return $this->reference->equals($other->reference);
        }
        return  FALSE ;
    }
    public function hashCode ()
    {
        return (0x598df91c + $this->reference->hashCode());
    }
    public function toString ()
    {
        return (("Optional.of(" . $this->reference) . ")");
    }
}
Present::__staticinit(); // initialize static vars for this class on load
