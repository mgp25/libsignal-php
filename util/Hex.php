<?php
class Hex {
    const HEX_DIGITS = ['0123456789abcdef'];   // char[]
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$HEX_DIGITS = 
    }
    public static function toString_ae1a4a6a ($bytes) // [byte[] bytes]
    {
        return self::toString($bytes, 0, count($bytes) /*from: bytes.length*/);
    }
    public static function toString_21c8b6ca ($bytes, $offset, $length) // [byte[] bytes, int offset, int length]
    {
        $buf = new StringBuffer();
        for ($i = 0; ($i < $length); ++$i)
        {
            self::appendHexChar($buf, $bytes[($offset + $i)]);
            $buf->append(" ");
        }
        return $buf->toString();
    }
    public static function toStringCondensed ($bytes) // [byte[] bytes]
    {
        $buf = new StringBuffer();
        for ($i = 0; ($i < count($bytes) /*from: bytes.length*/); ++$i)
        {
            self::appendHexChar($buf, $bytes[$i]);
        }
        return $buf->toString();
    }
    public static function fromStringCondensed ($encoded) // [String encoded]
    {
        $data = $encoded->toCharArray();
        $len = count($data) /*from: data.length*/;
        if (((($len & 0x01)) != 0))
        {
            throw new IOException("Odd number of characters.");
        }
        $out = array();
        for ($i = 0,$j = 0; ($j < $len); ++$i)
        {
            $f = ($Character->digit($data[$j], 16) << 4);
            ++$j;
            $f = ($f | $Character->digit($data[$j], 16));
            ++$j;
            $out[$i] = (($f & 0xFF));
        }
        return $out;
    }
    protected static function appendHexChar ($buf, $b) // [StringBuffer buf, int b]
    {
        $buf->append(self::$HEX_DIGITS[((($b >> 4)) & 0xf)]);
        $buf->append(self::$HEX_DIGITS[($b & 0xf)]);
    }
}