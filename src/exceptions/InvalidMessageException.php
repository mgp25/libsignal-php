<?php
namespace Libsignal\exceptions;

use Exception;

class InvalidMessageException extends Exception{

    /**
     * InvalidMessageException constructor.
     * @param string $detailMessage
     * @param null $throw
     */
    public function __construct($detailMessage, $throw = null){
        $this->message = $detailMessage;
        if ($throw != null) {
            $this->previous = $throw;
        }
    }

}