<?php
/**
 * Auto generated from WhisperTextProtocol.proto at 2016-04-03 15:59:00
 *
 * whispertext package
 */

namespace Whispertext {
/**
 * KeyExchangeMessage message
 */
class KeyExchangeMessage extends \ProtobufMessage
{
    /* Field index constants */
    const ID = 1;
    const BASEKEY = 2;
    const RATCHETKEY = 3;
    const IDENTITYKEY = 4;
    const BASEKEYSIGNATURE = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ID => array(
            'name' => 'id',
            'required' => false,
            'type' => 5,
        ),
        self::BASEKEY => array(
            'name' => 'baseKey',
            'required' => false,
            'type' => 7,
        ),
        self::RATCHETKEY => array(
            'name' => 'ratchetKey',
            'required' => false,
            'type' => 7,
        ),
        self::IDENTITYKEY => array(
            'name' => 'identityKey',
            'required' => false,
            'type' => 7,
        ),
        self::BASEKEYSIGNATURE => array(
            'name' => 'baseKeySignature',
            'required' => false,
            'type' => 7,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::ID] = null;
        $this->values[self::BASEKEY] = null;
        $this->values[self::RATCHETKEY] = null;
        $this->values[self::IDENTITYKEY] = null;
        $this->values[self::BASEKEYSIGNATURE] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'id' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setId($value)
    {
        return $this->set(self::ID, $value);
    }

    /**
     * Returns value of 'id' property
     *
     * @return int
     */
    public function getId()
    {
        return $this->get(self::ID);
    }

    /**
     * Sets value of 'baseKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setBaseKey($value)
    {
        return $this->set(self::BASEKEY, $value);
    }

    /**
     * Returns value of 'baseKey' property
     *
     * @return string
     */
    public function getBaseKey()
    {
        return $this->get(self::BASEKEY);
    }

    /**
     * Sets value of 'ratchetKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRatchetKey($value)
    {
        return $this->set(self::RATCHETKEY, $value);
    }

    /**
     * Returns value of 'ratchetKey' property
     *
     * @return string
     */
    public function getRatchetKey()
    {
        return $this->get(self::RATCHETKEY);
    }

    /**
     * Sets value of 'identityKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIdentityKey($value)
    {
        return $this->set(self::IDENTITYKEY, $value);
    }

    /**
     * Returns value of 'identityKey' property
     *
     * @return string
     */
    public function getIdentityKey()
    {
        return $this->get(self::IDENTITYKEY);
    }

    /**
     * Sets value of 'baseKeySignature' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setBaseKeySignature($value)
    {
        return $this->set(self::BASEKEYSIGNATURE, $value);
    }

    /**
     * Returns value of 'baseKeySignature' property
     *
     * @return string
     */
    public function getBaseKeySignature()
    {
        return $this->get(self::BASEKEYSIGNATURE);
    }
}
}
