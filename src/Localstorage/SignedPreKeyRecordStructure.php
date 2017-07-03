<?php
/**
 * Auto generated from LocalStorageProtocol.proto at 2016-04-03 15:59:57
 *
 * localstorage package
 */

namespace Localstorage {
/**
 * SignedPreKeyRecordStructure message
 */
class SignedPreKeyRecordStructure extends \ProtobufMessage
{
    /* Field index constants */
    const ID = 1;
    const PUBLICKEY = 2;
    const PRIVATEKEY = 3;
    const SIGNATURE = 4;
    const TIMESTAMP = 5;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ID => array(
            'name' => 'id',
            'required' => false,
            'type' => 5,
        ),
        self::PUBLICKEY => array(
            'name' => 'publicKey',
            'required' => false,
            'type' => 7,
        ),
        self::PRIVATEKEY => array(
            'name' => 'privateKey',
            'required' => false,
            'type' => 7,
        ),
        self::SIGNATURE => array(
            'name' => 'signature',
            'required' => false,
            'type' => 7,
        ),
        self::TIMESTAMP => array(
            'name' => 'timestamp',
            'required' => false,
            'type' => 3,
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
        $this->values[self::PUBLICKEY] = null;
        $this->values[self::PRIVATEKEY] = null;
        $this->values[self::SIGNATURE] = null;
        $this->values[self::TIMESTAMP] = null;
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
     * Sets value of 'publicKey' property
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
     * Returns value of 'publicKey' property
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->get(self::PUBLICKEY);
    }

    /**
     * Sets value of 'privateKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPrivateKey($value)
    {
        return $this->set(self::PRIVATEKEY, $value);
    }

    /**
     * Returns value of 'privateKey' property
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->get(self::PRIVATEKEY);
    }

    /**
     * Sets value of 'signature' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSignature($value)
    {
        return $this->set(self::SIGNATURE, $value);
    }

    /**
     * Returns value of 'signature' property
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->get(self::SIGNATURE);
    }

    /**
     * Sets value of 'timestamp' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setTimestamp($value)
    {
        return $this->set(self::TIMESTAMP, $value);
    }

    /**
     * Returns value of 'timestamp' property
     *
     * @return int
     */
    public function getTimestamp()
    {
        return $this->get(self::TIMESTAMP);
    }
}
}
