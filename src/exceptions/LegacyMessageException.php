<?php
namespace Libsignal\exceptions;

class LegacyMessageException extends \Exception
{
    public function __construct($detailMesssage) // [String s]
    {
        $this->message = $detailMesssage;
    }
}
