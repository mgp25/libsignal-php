<?php
/**
 * Auto generated from WhisperTextProtocol.proto at 2016-04-03 15:59:00
 *
 * whispertext package
 */

namespace Whispertext {
/**
 * PreKeyWhisperMessage message
 */
class PreKeyWhisperMessage extends \ProtobufMessage
{
    /* Field index constants */
    const REGISTRATIONID = 5;
    const PREKEYID = 1;
    const SIGNEDPREKEYID = 6;
    const BASEKEY = 2;
    const IDENTITYKEY = 3;
    const MESSAGE = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::REGISTRATIONID => array(
            'name' => 'registrationId',
            'required' => false,
            'type' => 5,
        ),
        self::PREKEYID => array(
            'name' => 'preKeyId',
            'required' => false,
            'type' => 5,
        ),
        self::SIGNEDPREKEYID => array(
            'name' => 'signedPreKeyId',
            'required' => false,
            'type' => 5,
        ),
        self::BASEKEY => array(
            'name' => 'baseKey',
            'required' => false,
            'type' => 7,
        ),
        self::IDENTITYKEY => array(
            'name' => 'identityKey',
            'required' => false,
            'type' => 7,
        ),
        self::MESSAGE => array(
            'name' => 'message',
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
        $this->values[self::REGISTRATIONID] = null;
        $this->values[self::PREKEYID] = null;
        $this->values[self::SIGNEDPREKEYID] = null;
        $this->values[self::BASEKEY] = null;
        $this->values[self::IDENTITYKEY] = null;
        $this->values[self::MESSAGE] = null;
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
     * Sets value of 'registrationId' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setRegistrationId($value)
    {
        return $this->set(self::REGISTRATIONID, $value);
    }

    /**
     * Returns value of 'registrationId' property
     *
     * @return int
     */
    public function getRegistrationId()
    {
        return $this->get(self::REGISTRATIONID);
    }

    /**
     * Sets value of 'preKeyId' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setPreKeyId($value)
    {
        return $this->set(self::PREKEYID, $value);
    }

    /**
     * Returns value of 'preKeyId' property
     *
     * @return int
     */
    public function getPreKeyId()
    {
        return $this->get(self::PREKEYID);
    }

    /**
     * Sets value of 'signedPreKeyId' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setSignedPreKeyId($value)
    {
        return $this->set(self::SIGNEDPREKEYID, $value);
    }

    /**
     * Returns value of 'signedPreKeyId' property
     *
     * @return int
     */
    public function getSignedPreKeyId()
    {
        return $this->get(self::SIGNEDPREKEYID);
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
     * Sets value of 'message' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMessage($value)
    {
        return $this->set(self::MESSAGE, $value);
    }

    /**
     * Returns value of 'message' property
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->get(self::MESSAGE);
    }
}
}
