<?php
namespace Libsignal\exceptions;

use Exception;

class InvalidKeyIdException extends Exception{

    /**
     * InvalidKeyIdException constructor.
     * @param string $detailMessage
     */
    public function __construct($detailMessage){
        $this->message = $detailMessage;
    }

}