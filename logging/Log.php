<?php
class Log extends AxolotlLogger {
    public static function verbose($tag, $msg) // [String tag, String msg]
    {
        self::log(self::VERBOSE, $tag, $msg);
    }
    public static function verboseException ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(self::VERBOSE, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    public static function debug ($tag, $msg) // [String tag, String msg]
    {
        self::log(self::DEBUG, $tag, $msg);
    }
    public static function debugException ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(self::DEBUG, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    public static function info ($tag, $msg) // [String tag, String msg]
    {
        self::log(self::INFO, $tag, $msg);
    }
    public static function infoException ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(self::INFO, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    public static function warning ($tag, $msg) // [String tag, String msg]
    {
        self::log(self::WARN, $tag, $msg);
    }
    public static function warningException ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(self::WARN, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    public static function warningShortException ($tag, $tr) // [String tag, Throwable tr]
    {
        self::log(self::WARN, $tag, self::getStackTraceString($tr));
    }
    public static function error ($tag, $msg) // [String tag, String msg]
    {
        self::log(self::ERROR, $tag, $msg);
    }
    public static function errorException ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(self::ERROR, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    protected static function getStackTraceString ($tr) // [Throwable tr]
    {
        if($tr instanceof Exception)
            return $tr->getTrace();
        else return "";
    }
    protected static function log ($priority, $tag, $msg) // [int priority, String tag, String msg]
    {
        $logger = AxolotlLoggerProvider::getProvider();
        if (($logger != null))
        {
            $logger->log($priority, $tag, $msg);
        }
    }
}
