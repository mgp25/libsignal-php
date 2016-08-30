<?php

class FingerprintVersionMismatchException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }

    public function FingerprintVersionMismatchException(Exception $e)
    {
        parent::__construct($e);
    }
}
