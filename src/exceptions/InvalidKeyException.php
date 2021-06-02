<?php
namespace Libsignal\exceptions;

use Exception;

class InvalidKeyException extends Exception{

    /**
     * InvalidKeyException constructor.
     * @param string $detailMessage
     */
    public function __construct($detailMessage){
        $this->message = $detailMessage;
    }

}