<?php
/**
 * Auto generated from LocalStorageProtocol.proto at 2016-04-03 15:59:57
 *
 * localstorage package
 */

namespace Localstorage\SessionStructure {
/**
 * PendingKeyExchange message embedded in SessionStructure message
 */
class PendingKeyExchange extends \ProtobufMessage
{
    /* Field index constants */
    const SEQUENCE = 1;
    const LOCALBASEKEY = 2;
    const LOCALBASEKEYPRIVATE = 3;
    const LOCALRATCHETKEY = 4;
    const LOCALRATCHETKEYPRIVATE = 5;
    const LOCALIDENTITYKEY = 7;
    const LOCALIDENTITYKEYPRIVATE = 8;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SEQUENCE => array(
            'name' => 'sequence',
            'required' => false,
            'type' => 5,
        ),
        self::LOCALBASEKEY => array(
            'name' => 'localBaseKey',
            'required' => false,
            'type' => 7,
        ),
        self::LOCALBASEKEYPRIVATE => array(
            'name' => 'localBaseKeyPrivate',
            'required' => false,
            'type' => 7,
        ),
        self::LOCALRATCHETKEY => array(
            'name' => 'localRatchetKey',
            'required' => false,
            'type' => 7,
        ),
        self::LOCALRATCHETKEYPRIVATE => array(
            'name' => 'localRatchetKeyPrivate',
            'required' => false,
            'type' => 7,
        ),
        self::LOCALIDENTITYKEY => array(
            'name' => 'localIdentityKey',
            'required' => false,
            'type' => 7,
        ),
        self::LOCALIDENTITYKEYPRIVATE => array(
            'name' => 'localIdentityKeyPrivate',
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
        $this->values[self::SEQUENCE] = null;
        $this->values[self::LOCALBASEKEY] = null;
        $this->values[self::LOCALBASEKEYPRIVATE] = null;
        $this->values[self::LOCALRATCHETKEY] = null;
        $this->values[self::LOCALRATCHETKEYPRIVATE] = null;
        $this->values[self::LOCALIDENTITYKEY] = null;
        $this->values[self::LOCALIDENTITYKEYPRIVATE] = null;
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
     * Sets value of 'sequence' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setSequence($value)
    {
        return $this->set(self::SEQUENCE, $value);
    }

    /**
     * Returns value of 'sequence' property
     *
     * @return int
     */
    public function getSequence()
    {
        return $this->get(self::SEQUENCE);
    }

    /**
     * Sets value of 'localBaseKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setLocalBaseKey($value)
    {
        return $this->set(self::LOCALBASEKEY, $value);
    }

    /**
     * Returns value of 'localBaseKey' property
     *
     * @return string
     */
    public function getLocalBaseKey()
    {
        return $this->get(self::LOCALBASEKEY);
    }

    /**
     * Sets value of 'localBaseKeyPrivate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setLocalBaseKeyPrivate($value)
    {
        return $this->set(self::LOCALBASEKEYPRIVATE, $value);
    }

    /**
     * Returns value of 'localBaseKeyPrivate' property
     *
     * @return string
     */
    public function getLocalBaseKeyPrivate()
    {
        return $this->get(self::LOCALBASEKEYPRIVATE);
    }

    /**
     * Sets value of 'localRatchetKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setLocalRatchetKey($value)
    {
        return $this->set(self::LOCALRATCHETKEY, $value);
    }

    /**
     * Returns value of 'localRatchetKey' property
     *
     * @return string
     */
    public function getLocalRatchetKey()
    {
        return $this->get(self::LOCALRATCHETKEY);
    }

    /**
     * Sets value of 'localRatchetKeyPrivate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setLocalRatchetKeyPrivate($value)
    {
        return $this->set(self::LOCALRATCHETKEYPRIVATE, $value);
    }

    /**
     * Returns value of 'localRatchetKeyPrivate' property
     *
     * @return string
     */
    public function getLocalRatchetKeyPrivate()
    {
        return $this->get(self::LOCALRATCHETKEYPRIVATE);
    }

    /**
     * Sets value of 'localIdentityKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setLocalIdentityKey($value)
    {
        return $this->set(self::LOCALIDENTITYKEY, $value);
    }

    /**
     * Returns value of 'localIdentityKey' property
     *
     * @return string
     */
    public function getLocalIdentityKey()
    {
        return $this->get(self::LOCALIDENTITYKEY);
    }

    /**
     * Sets value of 'localIdentityKeyPrivate' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setLocalIdentityKeyPrivate($value)
    {
        return $this->set(self::LOCALIDENTITYKEYPRIVATE, $value);
    }

    /**
     * Returns value of 'localIdentityKeyPrivate' property
     *
     * @return string
     */
    public function getLocalIdentityKeyPrivate()
    {
        return $this->get(self::LOCALIDENTITYKEYPRIVATE);
    }
}
}
