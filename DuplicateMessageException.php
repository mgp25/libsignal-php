<?php
class DuplicateMessageException extends Exception {
    public static function DuplicateMessageException ($s) // [String s]
    {
        $this->message = $s;
    }
}