<?php

/**
 * FingerprintData.
 */
class FingerprintData extends \ProtobufMessage
{
    /* Field index constants */
    const PUBLICKEY = 1;
    const IDENTIFIER = 2;

    /* @var array Field descriptors */
    protected static $fields = [
        self::PUBLICKEY => [
            'name'     => 'publicKey',
            'required' => false,
            'type'     => 7,
        ],
        self::IDENTIFIER => [
            'name'     => 'identifier',
            'required' => false,
            'type'     => 7,
        ],
    ];

    /**
     * Constructs new message container and clears its internal state.
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones.
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::PUBLICKEY] = null;
        $this->values[self::IDENTIFIER] = null;
    }

    /**
     * Returns field descriptors.
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'publicKey' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPublicKey($value)
    {
        return $this->set(self::PUBLICKEY, $value);
    }

    /**
     * Returns value of 'publicKey' property.
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->get(self::PUBLICKEY);
    }

    /**
     * Sets value of 'identifier' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setIdentifier($value)
    {
        return $this->set(self::IDENTIFIER, $value);
    }

    /**
     * Returns value of 'identifier' property.
     *
     * @return int
     */
    public function getIdentifier()
    {
        return $this->get(self::IDENTIFIER);
    }
}

/**
 * CombinedFingerprint.
 */
class CombinedFingerprint extends \ProtobufMessage
{
    /* Field index constants */
    const VERSION = 1;
    const LOCALFINGERPRINT = 2;
    const REMOTEFINGERPRINT = 3;

    /* @var array Field descriptors */
    protected static $fields = [
        self::VERSION => [
            'name'     => 'version',
            'required' => false,
            'type'     => 5,
        ],
        self::LOCALFINGERPRINT => [
            'name'     => 'localfingerprint',
            'required' => false,
            'type'     => 7,
        ],
        self::REMOTEFINGERPRINT => [
            'name'     => 'remotefingerprint',
            'required' => false,
            'type'     => 7,
        ],
    ];

    /**
     * Constructs new message container and clears its internal state.
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones.
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::VERSION] = null;
        $this->values[self::LOCALFINGERPRINT] = null;
        $this->values[self::REMOTEFINGERPRINT] = null;
    }

    /**
     * Returns field descriptors.
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'version' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setVersion($value)
    {
        return $this->set(self::VERSION, $value);
    }

    /**
     * Returns value of 'version' property.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->get(self::VERSION);
    }

    /**
     * Sets value of 'localfingerprint' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setLocalFingerprint($value)
    {
        return $this->set(self::LOCALFINGERPRINT, $value);
    }

    /**
     * Returns value of 'localfingerprint' property.
     *
     * @return int
     */
    public function getLocalFingerprint()
    {
        return $this->get(self::LOCALFINGERPRINT);
    }

    /**
     * Sets value of 'remotefingerprint' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setRemoteFingerprint($value)
    {
        return $this->set(self::REMOTEFINGERPRINT, $value);
    }

    /**
     * Returns value of 'remotefingerprint' property.
     *
     * @return int
     */
    public function getRemoteFingerprint()
    {
        return $this->get(self::REMOTEFINGERPRINT);
    }

    /**
     * Returns value of 'remotefingerprint' property.
     *
     * @return int
     */
    public function hasVersion()
    {
        return is_null($this->get(self::VERSION)) ? false : true;
    }

    /**
     * Returns value of 'remotefingerprint' property.
     *
     * @return int
     */
    public function hasLocalFingerprint()
    {
        return is_null($this->get(self::LOCALFINGERPRINT)) ? false : true;
    }

    /**
     * Returns value of 'remotefingerprint' property.
     *
     * @return int
     */
    public function hasRemoteFingerprint()
    {
        return is_null($this->get(self::REMOTEFINGERPRINT)) ? false : true;
    }
}
