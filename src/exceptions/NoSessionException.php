<?php
namespace Libsignal\exceptions;

use Exception;

class NoSessionException extends Exception{

    /**
     * NoSessionException constructor.
     * @param string $s
     */
    public function __construct($s){
        $this->message = $s;
    }

}