<?php
namespace Libaxolotl\exceptions;

class InvalidKeyIdException extends \Exception
{
    public function __construct($detailMessage) // [String detailMessage]
    {
        $this->message = $detailMessage;
    }
}
