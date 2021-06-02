<?php
namespace Libsignal\exceptions;

use Exception;

class InvalidMacException extends Exception{

    /**
     * InvalidMacException constructor.
     * @param string $detailMessage
     */
    public function __construct($detailMessage){
        $this->message = $detailMessage;
    }

}