<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: LocalStorageProtocol.proto

namespace Localstorage\SenderKeyStateStructure;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>localstorage.SenderKeyStateStructure.SenderMessageKey</code>
 */
class SenderMessageKey extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>optional uint32 iteration = 1;</code>
     */
    protected $iteration = null;
    /**
     * Generated from protobuf field <code>optional bytes seed = 2;</code>
     */
    protected $seed = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $iteration
     *     @type string $seed
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\LocalStorageProtocol::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>optional uint32 iteration = 1;</code>
     * @return int
     */
    public function getIteration()
    {
        return isset($this->iteration) ? $this->iteration : 0;
    }

    public function hasIteration()
    {
        return isset($this->iteration);
    }

    public function clearIteration()
    {
        unset($this->iteration);
    }

    /**
     * Generated from protobuf field <code>optional uint32 iteration = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setIteration($var)
    {
        GPBUtil::checkUint32($var);
        $this->iteration = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional bytes seed = 2;</code>
     * @return string
     */
    public function getSeed()
    {
        return isset($this->seed) ? $this->seed : '';
    }

    public function hasSeed()
    {
        return isset($this->seed);
    }

    public function clearSeed()
    {
        unset($this->seed);
    }

    /**
     * Generated from protobuf field <code>optional bytes seed = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setSeed($var)
    {
        GPBUtil::checkString($var, False);
        $this->seed = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(SenderMessageKey::class, \Localstorage\SenderKeyStateStructure_SenderMessageKey::class);

