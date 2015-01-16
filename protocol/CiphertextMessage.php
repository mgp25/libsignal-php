<?php
interface CiphertextMessage {
    public static $UNSUPPORTED_VERSION;    // int
    public static $CURRENT_VERSION;    // int
    public static $WHISPER_TYPE;    // int
    public static $PREKEY_TYPE;    // int
    public static $SENDERKEY_TYPE;    // int
    public static $SENDERKEY_DISTRIBUTION_TYPE;    // int
    public static $ENCRYPTED_MESSAGE_OVERHEAD;    // int
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$UNSUPPORTED_VERSION = 1;
        self::$CURRENT_VERSION = 3;
        self::$WHISPER_TYPE = 2;
        self::$PREKEY_TYPE = 3;
        self::$SENDERKEY_TYPE = 4;
        self::$SENDERKEY_DISTRIBUTION_TYPE = 5;
        self::$ENCRYPTED_MESSAGE_OVERHEAD = 53;
    }
    abstract function serialize ();
    abstract function getType ();
}
CiphertextMessage::__staticinit(); // initialize static vars for this class on load
