<?php
/**
 * Auto generated from WhisperTextProtocol.proto at 2016-04-03 15:59:00
 *
 * whispertext package
 */

namespace Whispertext {
/**
 * WhisperMessage message
 */
class WhisperMessage extends \ProtobufMessage
{
    /* Field index constants */
    const RATCHETKEY = 1;
    const COUNTER = 2;
    const PREVIOUSCOUNTER = 3;
    const CIPHERTEXT = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::RATCHETKEY => array(
            'name' => 'ratchetKey',
            'required' => false,
            'type' => 7,
        ),
        self::COUNTER => array(
            'name' => 'counter',
            'required' => false,
            'type' => 5,
        ),
        self::PREVIOUSCOUNTER => array(
            'name' => 'previousCounter',
            'required' => false,
            'type' => 5,
        ),
        self::CIPHERTEXT => array(
            'name' => 'ciphertext',
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
        $this->values[self::RATCHETKEY] = null;
        $this->values[self::COUNTER] = null;
        $this->values[self::PREVIOUSCOUNTER] = null;
        $this->values[self::CIPHERTEXT] = null;
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
     * Sets value of 'counter' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setCounter($value)
    {
        return $this->set(self::COUNTER, $value);
    }

    /**
     * Returns value of 'counter' property
     *
     * @return int
     */
    public function getCounter()
    {
        return $this->get(self::COUNTER);
    }

    /**
     * Sets value of 'previousCounter' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setPreviousCounter($value)
    {
        return $this->set(self::PREVIOUSCOUNTER, $value);
    }

    /**
     * Returns value of 'previousCounter' property
     *
     * @return int
     */
    public function getPreviousCounter()
    {
        return $this->get(self::PREVIOUSCOUNTER);
    }

    /**
     * Sets value of 'ciphertext' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCiphertext($value)
    {
        return $this->set(self::CIPHERTEXT, $value);
    }

    /**
     * Returns value of 'ciphertext' property
     *
     * @return string
     */
    public function getCiphertext()
    {
        return $this->get(self::CIPHERTEXT);
    }
}
}
