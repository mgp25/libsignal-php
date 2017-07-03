<?php
namespace Libsignal\exceptions;

class DuplicateMessageException extends \Exception
{
    public function __construct($s) // [String s]
    {
        $this->message = $s;
    }
}
