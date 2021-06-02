<?php
namespace Libsignal\logging;

class AxolotlLoggerProvider{

    /**
     * @var AxolotlLogger
     */
    protected static $provider;    // AxolotlLogger

    /**
     * @return AxolotlLogger
     */
    public static function getProvider()
    {
        return self::$provider;
    }

    /**
     * @param AxolotlLogger $provider
     */
    public static function setProvider($provider) // [AxolotlLogger provider]
    {
        self::$provider = $provider;
    }
}
