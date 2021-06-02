<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: WhisperTextProtocol.proto

namespace Whispertext;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>whispertext.WhisperMessage</code>
 */
class WhisperMessage extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>optional bytes ratchetKey = 1;</code>
     */
    protected $ratchetKey = null;
    /**
     * Generated from protobuf field <code>optional uint32 counter = 2;</code>
     */
    protected $counter = null;
    /**
     * Generated from protobuf field <code>optional uint32 previousCounter = 3;</code>
     */
    protected $previousCounter = null;
    /**
     * Generated from protobuf field <code>optional bytes ciphertext = 4;</code>
     */
    protected $ciphertext = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $ratchetKey
     *     @type int $counter
     *     @type int $previousCounter
     *     @type string $ciphertext
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\WhisperTextProtocol::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>optional bytes ratchetKey = 1;</code>
     * @return string
     */
    public function getRatchetKey()
    {
        return isset($this->ratchetKey) ? $this->ratchetKey : '';
    }

    public function hasRatchetKey()
    {
        return isset($this->ratchetKey);
    }

    public function clearRatchetKey()
    {
        unset($this->ratchetKey);
    }

    /**
     * Generated from protobuf field <code>optional bytes ratchetKey = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setRatchetKey($var)
    {
        GPBUtil::checkString($var, False);
        $this->ratchetKey = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional uint32 counter = 2;</code>
     * @return int
     */
    public function getCounter()
    {
        return isset($this->counter) ? $this->counter : 0;
    }

    public function hasCounter()
    {
        return isset($this->counter);
    }

    public function clearCounter()
    {
        unset($this->counter);
    }

    /**
     * Generated from protobuf field <code>optional uint32 counter = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setCounter($var)
    {
        GPBUtil::checkUint32($var);
        $this->counter = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional uint32 previousCounter = 3;</code>
     * @return int
     */
    public function getPreviousCounter()
    {
        return isset($this->previousCounter) ? $this->previousCounter : 0;
    }

    public function hasPreviousCounter()
    {
        return isset($this->previousCounter);
    }

    public function clearPreviousCounter()
    {
        unset($this->previousCounter);
    }

    /**
     * Generated from protobuf field <code>optional uint32 previousCounter = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setPreviousCounter($var)
    {
        GPBUtil::checkUint32($var);
        $this->previousCounter = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional bytes ciphertext = 4;</code>
     * @return string
     */
    public function getCiphertext()
    {
        return isset($this->ciphertext) ? $this->ciphertext : '';
    }

    public function hasCiphertext()
    {
        return isset($this->ciphertext);
    }

    public function clearCiphertext()
    {
        unset($this->ciphertext);
    }

    /**
     * Generated from protobuf field <code>optional bytes ciphertext = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setCiphertext($var)
    {
        GPBUtil::checkString($var, False);
        $this->ciphertext = $var;

        return $this;
    }

}

