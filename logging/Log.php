<?php
require_once("java/io/PrintWriter.php");
require_once("java/io/StringWriter.php");
require_once("java/net/UnknownHostException.php");
class Log {
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__ ()
    {
        $me = new self();
        $me->__init();
        return $me;
    }
    public static function v_79c13ff ($tag, $msg) // [String tag, String msg]
    {
        self::log(AxolotlLogger::$VERBOSE, $tag, $msg);
    }
    public static function v_5188d4e0 ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(AxolotlLogger::$VERBOSE, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    public static function d_79c13ff ($tag, $msg) // [String tag, String msg]
    {
        self::log(AxolotlLogger::$DEBUG, $tag, $msg);
    }
    public static function d_5188d4e0 ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(AxolotlLogger::$DEBUG, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    public static function i_79c13ff ($tag, $msg) // [String tag, String msg]
    {
        self::log(AxolotlLogger::$INFO, $tag, $msg);
    }
    public static function i_5188d4e0 ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(AxolotlLogger::$INFO, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    public static function w_79c13ff ($tag, $msg) // [String tag, String msg]
    {
        self::log(AxolotlLogger::$WARN, $tag, $msg);
    }
    public static function w_5188d4e0 ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(AxolotlLogger::$WARN, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    public static function w_4c6bf692 ($tag, $tr) // [String tag, Throwable tr]
    {
        self::log(AxolotlLogger::$WARN, $tag, self::getStackTraceString($tr));
    }
    public static function e_79c13ff ($tag, $msg) // [String tag, String msg]
    {
        self::log(AxolotlLogger::$ERROR, $tag, $msg);
    }
    public static function e_5188d4e0 ($tag, $msg, $tr) // [String tag, String msg, Throwable tr]
    {
        self::log(AxolotlLogger::$ERROR, $tag, (($msg . '\n') . self::getStackTraceString($tr)));
    }
    protected static function getStackTraceString ($tr) // [Throwable tr]
    {
        if (($tr == null))
        {
            return "";
        }
        $t = $tr;
        while (($t != null))
        {
            if ($t instanceof UnknownHostException)
            {
                return "";
            }
            $t = $t->getCause();
        }
        $sw = new StringWriter();
        $pw = new PrintWriter($sw);
        $tr->printStackTrace($pw);
        $pw->flush();
        return $sw->toString();
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
Log::__staticinit(); // initialize static vars for this class on load
