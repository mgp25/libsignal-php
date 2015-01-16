<?php
class HKDFv3 extends HKDF {
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    protected function getIterationStartOffset ()
    {
        return 1;
    }
}
HKDFv3::__staticinit(); // initialize static vars for this class on load
