<?php

require_once __DIR__."/pb_proto_WhisperTextProtocol.php"
class WhisperProtos {

    protected static $internal_static_textsecure_WhisperMessage_descriptor;    // com.google.protobuf.Descriptors.Descriptor
    protected static $internal_static_textsecure_WhisperMessage_fieldAccessorTable;    // com.google.protobuf.GeneratedMessage.FieldAccessorTable
    protected static $internal_static_textsecure_PreKeyWhisperMessage_descriptor;    // com.google.protobuf.Descriptors.Descriptor
    protected static $internal_static_textsecure_PreKeyWhisperMessage_fieldAccessorTable;    // com.google.protobuf.GeneratedMessage.FieldAccessorTable
    protected static $internal_static_textsecure_KeyExchangeMessage_descriptor;    // com.google.protobuf.Descriptors.Descriptor
    protected static $internal_static_textsecure_KeyExchangeMessage_fieldAccessorTable;    // com.google.protobuf.GeneratedMessage.FieldAccessorTable
    protected static $internal_static_textsecure_SenderKeyMessage_descriptor;    // com.google.protobuf.Descriptors.Descriptor
    protected static $internal_static_textsecure_SenderKeyMessage_fieldAccessorTable;    // com.google.protobuf.GeneratedMessage.FieldAccessorTable
    protected static $internal_static_textsecure_SenderKeyDistributionMessage_descriptor;    // com.google.protobuf.Descriptors.Descriptor
    protected static $internal_static_textsecure_SenderKeyDistributionMessage_fieldAccessorTable;    // com.google.protobuf.GeneratedMessage.FieldAccessorTable
    protected static $descriptor;    // com.google.protobuf.Descriptors.FileDescriptor
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__ ()
    {
        $me = new self         $me->__init();
        return $me;
    }
    abstract static function registerAllExtensions ($registry); // [com.google.protobuf.ExtensionRegistry registry]
    public static function getDescriptor ()
    {
        return self::$descriptor;
    }
}
WhisperProtos::__staticinit(); // initialize static vars for this class on load
