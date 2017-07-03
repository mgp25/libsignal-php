<?php
/**
 * Auto generated from LocalStorageProtocol.proto at 2016-04-03 15:59:57
 *
 * localstorage package
 */

namespace Localstorage\SenderKeyStateStructure {
/**
 * SenderSigningKey message embedded in SenderKeyStateStructure message
 */
class SenderSigningKey extends \ProtobufMessage
{
    /* Field index constants */
    const _PUBLIC = 1;
    const _PRIVATE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::_PUBLIC => array(
            'name' => 'public',
            'required' => false,
            'type' => 7,
        ),
        self::_PRIVATE => array(
            'name' => 'private',
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
        $this->values[self::_PUBLIC] = null;
        $this->values[self::_PRIVATE] = null;
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
     * Sets value of 'public' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPublic($value)
    {
        return $this->set(self::_PUBLIC, $value);
    }

    /**
     * Returns value of 'public' property
     *
     * @return string
     */
    public function getPublic()
    {
        return $this->get(self::_PUBLIC);
    }

    /**
     * Sets value of 'private' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPrivate($value)
    {
        return $this->set(self::_PRIVATE, $value);
    }

    /**
     * Returns value of 'private' property
     *
     * @return string
     */
    public function getPrivate()
    {
        return $this->get(self::_PRIVATE);
    }
}
}
