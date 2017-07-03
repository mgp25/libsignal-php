<?php
namespace Libsignal\exceptions;

class InvalidMacException extends \Exception
{
    public function __construct($detailMessage) // [String detailMessage]
    {
        $this->message = $detailMessage;
    }
}
