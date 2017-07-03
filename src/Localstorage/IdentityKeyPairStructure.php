<?php
/**
 * Auto generated from LocalStorageProtocol.proto at 2016-04-03 15:59:57
 *
 * localstorage package
 */

namespace Localstorage {
/**
 * IdentityKeyPairStructure message
 */
class IdentityKeyPairStructure extends \ProtobufMessage
{
    /* Field index constants */
    const PUBLICKEY = 1;
    const PRIVATEKEY = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
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
        $this->values[self::PUBLICKEY] = null;
        $this->values[self::PRIVATEKEY] = null;
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
}
}
