<?php
namespace Libsignal\exceptions;

class InvalidVersionException extends \Exception
{
    public function __construct($detailMessage) // [String detailMessage]
    {
        $this->message = $detailMessage;
    }
}
