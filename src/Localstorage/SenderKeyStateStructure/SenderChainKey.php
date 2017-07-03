<?php
/**
 * Auto generated from LocalStorageProtocol.proto at 2016-04-03 15:59:57
 *
 * localstorage package
 */

namespace Localstorage\SenderKeyStateStructure {
/**
 * SenderChainKey message embedded in SenderKeyStateStructure message
 */
class SenderChainKey extends \ProtobufMessage
{
    /* Field index constants */
    const ITERATION = 1;
    const SEED = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::ITERATION => array(
            'name' => 'iteration',
            'required' => false,
            'type' => 5,
        ),
        self::SEED => array(
            'name' => 'seed',
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
        $this->values[self::ITERATION] = null;
        $this->values[self::SEED] = null;
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
     * Sets value of 'seed' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSeed($value)
    {
        return $this->set(self::SEED, $value);
    }

    /**
     * Returns value of 'seed' property
     *
     * @return string
     */
    public function getSeed()
    {
        return $this->get(self::SEED);
    }
}
}
