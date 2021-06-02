<?php
namespace Libsignal\exceptions;

use Exception;

class InvalidVersionException extends Exception{

    /**
     * InvalidVersionException constructor.
     * @param string $detailMessage
     */
    public function __construct($detailMessage){
        $this->message = $detailMessage;
    }

}