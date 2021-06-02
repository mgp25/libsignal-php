<?php
namespace Libsignal\exceptions;

use Exception;

class LegacyMessageException extends Exception{
    /**
     * LegacyMessageException constructor.
     * @param string $detailMesssage
     */
    public function __construct($detailMesssage){
        $this->message = $detailMesssage;
    }

}