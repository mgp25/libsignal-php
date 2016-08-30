<?php

class FingerprintParsingException extends Exception
{
    public function __construct(Exception $nested)
    {
        parent::__construct($nested);
    }
}
