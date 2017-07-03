<?php
namespace Libsignal\exceptions;

class InvalidKeyException extends \Exception
{
    public function __construct($detailMessage) // [String detailMessage]
    {
        $this->message = $detailMessage;
    }
}
