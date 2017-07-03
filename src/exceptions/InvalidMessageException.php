<?php
namespace Libsignal\exceptions;

class InvalidMessageException extends \Exception
{
    public function __construct($detailMessage, $throw = null) // [String detailMessage]
    {
        $this->message = $detailMessage;
        if ($throw != null) {
            $this->previous = $throw;
        }
    }
}
