<?php
/**
 * Auto generated from LocalStorageProtocol.proto at 2016-04-03 15:59:57
 *
 * localstorage package
 */

namespace Localstorage\SessionStructure {
/**
 * Chain message embedded in SessionStructure message
 */
class Chain extends \ProtobufMessage
{
    /* Field index constants */
    const SENDERRATCHETKEY = 1;
    const SENDERRATCHETKEYPRIVATE = 2;
    const CHAINKEY = 3;
    const MESSAGEKEYS = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SENDERRATCHETKEY => array(
            'name' => 'senderRatchetKey',
            'required' => false,
            'type' => 7,
        ),
        self::SENDERRATCHETKEYPRIVATE => array(
            'name' => 'senderRatchetKeyPrivate',
            'required' => false,
            'type' => 7,
        ),
        self::CHAINKEY => array(
            'name' => 'chainKey',
            'required' => false,
            'type' => '\Localstorage\SessionStructure\Chain\ChainKey'
        ),
        self::MESSAGEKEYS => array(
            'name' => 'messageKeys',
            'repeated' => true,
            'type' => '\Localstorage\SessionStructure\Chain\MessageKey'
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
        $this->values[self::SENDERRATCHETKEY] = null;
        $this->values[self::SENDERRATCHETKEYPRIVATE] = null;
        $this->values[self::CHAINKEY] = null;
        $this->values[self::MESSAGEKEYS] = array();
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
     * Sets value of 'senderRatchetKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSenderRatchetKey($value)
    {
        return $this->set(self::SENDERRATCHETKEY, $value);
    }

    /**
     * Returns value of 'senderRatchetKey' property
     *
     * @return string
     */
    public function getSenderRatchetKey()
    {
        return $this->get(self::SENDERRATCHETKEY);
    }

    /**
     * Sets value of 'senderRatchetKeyPrivate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSenderRatchetKeyPrivate($value)
    {
        return $this->set(self::SENDERRATCHETKEYPRIVATE, $value);
    }

    /**
     * Returns value of 'senderRatchetKeyPrivate' property
     *
     * @return string
     */
    public function getSenderRatchetKeyPrivate()
    {
        return $this->get(self::SENDERRATCHETKEYPRIVATE);
    }

    /**
     * Sets value of 'chainKey' property
     *
     * @param \Localstorage\SessionStructure\Chain\ChainKey $value Property value
     *
     * @return null
     */
    public function setChainKey(\Localstorage\SessionStructure\Chain\ChainKey $value)
    {
        return $this->set(self::CHAINKEY, $value);
    }

    /**
     * Returns value of 'chainKey' property
     *
     * @return \Localstorage\SessionStructure\Chain\ChainKey
     */
    public function getChainKey()
    {
        return $this->get(self::CHAINKEY);
    }

    /**
     * Appends value to 'messageKeys' list
     *
     * @param \Localstorage\SessionStructure\Chain\MessageKey $value Value to append
     *
     * @return null
     */
    public function appendMessageKeys(\Localstorage\SessionStructure\Chain\MessageKey $value)
    {
        return $this->append(self::MESSAGEKEYS, $value);
    }

    /**
     * Clears 'messageKeys' list
     *
     * @return null
     */
    public function clearMessageKeys()
    {
        return $this->clear(self::MESSAGEKEYS);
    }

    /**
     * Returns 'messageKeys' list
     *
     * @return \Localstorage\SessionStructure\Chain\MessageKey[]
     */
    public function getMessageKeys()
    {
        return $this->get(self::MESSAGEKEYS);
    }

    /**
     * Returns 'messageKeys' iterator
     *
     * @return ArrayIterator
     */
    public function getMessageKeysIterator()
    {
        return new \ArrayIterator($this->get(self::MESSAGEKEYS));
    }

    /**
     * Returns element from 'messageKeys' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \Localstorage\SessionStructure\Chain\MessageKey
     */
    public function getMessageKeysAt($offset)
    {
        return $this->get(self::MESSAGEKEYS, $offset);
    }

    /**
     * Returns count of 'messageKeys' list
     *
     * @return int
     */
    public function getMessageKeysCount()
    {
        return $this->count(self::MESSAGEKEYS);
    }
}
}
