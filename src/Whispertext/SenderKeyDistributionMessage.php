<?php
/**
 * Auto generated from WhisperTextProtocol.proto at 2016-04-03 15:59:00
 *
 * whispertext package
 */

namespace Whispertext {
/**
 * SenderKeyDistributionMessage message
 */
class SenderKeyDistributionMessage extends \ProtobufMessage
{
    /* Field index constants */
    const ID = 1;
    const ITERATION = 2;
    const CHAINKEY = 3;
    const SIGNINGKEY = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ID => array(
            'name' => 'id',
            'required' => false,
            'type' => 5,
        ),
        self::ITERATION => array(
            'name' => 'iteration',
            'required' => false,
            'type' => 5,
        ),
        self::CHAINKEY => array(
            'name' => 'chainKey',
            'required' => false,
            'type' => 7,
        ),
        self::SIGNINGKEY => array(
            'name' => 'signingKey',
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
        $this->values[self::ITERATION] = null;
        $this->values[self::CHAINKEY] = null;
        $this->values[self::SIGNINGKEY] = null;
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
     * Sets value of 'iteration' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setIteration($value)
    {
        return $this->set(self::ITERATION, $value);
    }

    /**
     * Returns value of 'iteration' property
     *
     * @return int
     */
    public function getIteration()
    {
        return $this->get(self::ITERATION);
    }

    /**
     * Sets value of 'chainKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setChainKey($value)
    {
        return $this->set(self::CHAINKEY, $value);
    }

    /**
     * Returns value of 'chainKey' property
     *
     * @return string
     */
    public function getChainKey()
    {
        return $this->get(self::CHAINKEY);
    }

    /**
     * Sets value of 'signingKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSigningKey($value)
    {
        return $this->set(self::SIGNINGKEY, $value);
    }

    /**
     * Returns value of 'signingKey' property
     *
     * @return string
     */
    public function getSigningKey()
    {
        return $this->get(self::SIGNINGKEY);
    }
}
}
