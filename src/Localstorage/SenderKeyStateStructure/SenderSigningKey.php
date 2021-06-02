<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: LocalStorageProtocol.proto

namespace Localstorage\SenderKeyStateStructure;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>localstorage.SenderKeyStateStructure.SenderSigningKey</code>
 */
class SenderSigningKey extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>optional bytes public = 1;</code>
     */
    protected $public = null;
    /**
     * Generated from protobuf field <code>optional bytes private = 2;</code>
     */
    protected $private = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $public
     *     @type string $private
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\LocalStorageProtocol::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>optional bytes public = 1;</code>
     * @return string
     */
    public function getPublic()
    {
        return isset($this->public) ? $this->public : '';
    }

    public function hasPublic()
    {
        return isset($this->public);
    }

    public function clearPublic()
    {
        unset($this->public);
    }

    /**
     * Generated from protobuf field <code>optional bytes public = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setPublic($var)
    {
        GPBUtil::checkString($var, False);
        $this->public = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional bytes private = 2;</code>
     * @return string
     */
    public function getPrivate()
    {
        return isset($this->private) ? $this->private : '';
    }

    public function hasPrivate()
    {
        return isset($this->private);
    }

    public function clearPrivate()
    {
        unset($this->private);
    }

    /**
     * Generated from protobuf field <code>optional bytes private = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setPrivate($var)
    {
        GPBUtil::checkString($var, False);
        $this->private = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(SenderSigningKey::class, \Localstorage\SenderKeyStateStructure_SenderSigningKey::class);

