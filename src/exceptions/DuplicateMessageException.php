<?php
namespace Libsignal\exceptions;

use Exception;

class DuplicateMessageException extends Exception{

    /**
     * DuplicateMessageException constructor.
     * @param string $s
     */
    public function __construct($s){
        $this->message = $s;
    }

}