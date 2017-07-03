<?php
/**
 * Auto generated from LocalStorageProtocol.proto at 2016-04-03 15:59:57
 *
 * localstorage package
 */

namespace Localstorage\SessionStructure\Chain {
/**
 * MessageKey message embedded in Chain/SessionStructure message
 */
class MessageKey extends \ProtobufMessage
{
    /* Field index constants */
    const INDEX = 1;
    const CIPHERKEY = 2;
    const MACKEY = 3;
    const IV = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::INDEX => array(
            'name' => 'index',
            'required' => false,
            'type' => 5,
        ),
        self::CIPHERKEY => array(
            'name' => 'cipherKey',
            'required' => false,
            'type' => 7,
        ),
        self::MACKEY => array(
            'name' => 'macKey',
            'required' => false,
            'type' => 7,
        ),
        self::IV => array(
            'name' => 'iv',
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
        $this->values[self::INDEX] = null;
        $this->values[self::CIPHERKEY] = null;
        $this->values[self::MACKEY] = null;
        $this->values[self::IV] = null;
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
     * Sets value of 'index' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setIndex($value)
    {
        return $this->set(self::INDEX, $value);
    }

    /**
     * Returns value of 'index' property
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->get(self::INDEX);
    }

    /**
     * Sets value of 'cipherKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCipherKey($value)
    {
        return $this->set(self::CIPHERKEY, $value);
    }

    /**
     * Returns value of 'cipherKey' property
     *
     * @return string
     */
    public function getCipherKey()
    {
        return $this->get(self::CIPHERKEY);
    }

    /**
     * Sets value of 'macKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMacKey($value)
    {
        return $this->set(self::MACKEY, $value);
    }

    /**
     * Returns value of 'macKey' property
     *
     * @return string
     */
    public function getMacKey()
    {
        return $this->get(self::MACKEY);
    }

    /**
     * Sets value of 'iv' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setIv($value)
    {
        return $this->set(self::IV, $value);
    }

    /**
     * Returns value of 'iv' property
     *
     * @return string
     */
    public function getIv()
    {
        return $this->get(self::IV);
    }
}
}
