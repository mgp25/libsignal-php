<?php
/**
 * Auto generated from LocalStorageProtocol.proto at 2016-04-03 15:59:57
 *
 * localstorage package
 */

namespace Localstorage {
/**
 * SenderKeyRecordStructure message
 */
class SenderKeyRecordStructure extends \ProtobufMessage
{
    /* Field index constants */
    const SENDERKEYSTATES = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SENDERKEYSTATES => array(
            'name' => 'senderKeyStates',
            'repeated' => true,
            'type' => '\Localstorage\SenderKeyStateStructure'
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
        $this->values[self::SENDERKEYSTATES] = array();
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
     * Appends value to 'senderKeyStates' list
     *
     * @param \Localstorage\SenderKeyStateStructure $value Value to append
     *
     * @return null
     */
    public function appendSenderKeyStates(\Localstorage\SenderKeyStateStructure $value)
    {
        return $this->append(self::SENDERKEYSTATES, $value);
    }

    /**
     * Clears 'senderKeyStates' list
     *
     * @return null
     */
    public function clearSenderKeyStates()
    {
        return $this->clear(self::SENDERKEYSTATES);
    }

    /**
     * Returns 'senderKeyStates' list
     *
     * @return \Localstorage\SenderKeyStateStructure[]
     */
    public function getSenderKeyStates()
    {
        return $this->get(self::SENDERKEYSTATES);
    }

    /**
     * Returns 'senderKeyStates' iterator
     *
     * @return ArrayIterator
     */
    public function getSenderKeyStatesIterator()
    {
        return new \ArrayIterator($this->get(self::SENDERKEYSTATES));
    }

    /**
     * Returns element from 'senderKeyStates' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \Localstorage\SenderKeyStateStructure
     */
    public function getSenderKeyStatesAt($offset)
    {
        return $this->get(self::SENDERKEYSTATES, $offset);
    }

    /**
     * Returns count of 'senderKeyStates' list
     *
     * @return int
     */
    public function getSenderKeyStatesCount()
    {
        return $this->count(self::SENDERKEYSTATES);
    }
}
}
