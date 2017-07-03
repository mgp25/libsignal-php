<?php
/**
 * Auto generated from LocalStorageProtocol.proto at 2016-04-03 15:59:57
 *
 * localstorage package
 */

namespace Localstorage {
/**
 * SessionStructure message
 */
class SessionStructure extends \ProtobufMessage
{
    /* Field index constants */
    const SESSIONVERSION = 1;
    const LOCALIDENTITYPUBLIC = 2;
    const REMOTEIDENTITYPUBLIC = 3;
    const ROOTKEY = 4;
    const PREVIOUSCOUNTER = 5;
    const SENDERCHAIN = 6;
    const RECEIVERCHAINS = 7;
    const PENDINGKEYEXCHANGE = 8;
    const PENDINGPREKEY = 9;
    const REMOTEREGISTRATIONID = 10;
    const LOCALREGISTRATIONID = 11;
    const NEEDSREFRESH = 12;
    const ALICEBASEKEY = 13;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SESSIONVERSION => array(
            'name' => 'sessionVersion',
            'required' => false,
            'type' => 5,
        ),
        self::LOCALIDENTITYPUBLIC => array(
            'name' => 'localIdentityPublic',
            'required' => false,
            'type' => 7,
        ),
        self::REMOTEIDENTITYPUBLIC => array(
            'name' => 'remoteIdentityPublic',
            'required' => false,
            'type' => 7,
        ),
        self::ROOTKEY => array(
            'name' => 'rootKey',
            'required' => false,
            'type' => 7,
        ),
        self::PREVIOUSCOUNTER => array(
            'name' => 'previousCounter',
            'required' => false,
            'type' => 5,
        ),
        self::SENDERCHAIN => array(
            'name' => 'senderChain',
            'required' => false,
            'type' => '\Localstorage\SessionStructure\Chain'
        ),
        self::RECEIVERCHAINS => array(
            'name' => 'receiverChains',
            'repeated' => true,
            'type' => '\Localstorage\SessionStructure\Chain'
        ),
        self::PENDINGKEYEXCHANGE => array(
            'name' => 'pendingKeyExchange',
            'required' => false,
            'type' => '\Localstorage\SessionStructure\PendingKeyExchange'
        ),
        self::PENDINGPREKEY => array(
            'name' => 'pendingPreKey',
            'required' => false,
            'type' => '\Localstorage\SessionStructure\PendingPreKey'
        ),
        self::REMOTEREGISTRATIONID => array(
            'name' => 'remoteRegistrationId',
            'required' => false,
            'type' => 5,
        ),
        self::LOCALREGISTRATIONID => array(
            'name' => 'localRegistrationId',
            'required' => false,
            'type' => 5,
        ),
        self::NEEDSREFRESH => array(
            'name' => 'needsRefresh',
            'required' => false,
            'type' => 8,
        ),
        self::ALICEBASEKEY => array(
            'name' => 'aliceBaseKey',
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
        $this->values[self::SESSIONVERSION] = null;
        $this->values[self::LOCALIDENTITYPUBLIC] = null;
        $this->values[self::REMOTEIDENTITYPUBLIC] = null;
        $this->values[self::ROOTKEY] = null;
        $this->values[self::PREVIOUSCOUNTER] = null;
        $this->values[self::SENDERCHAIN] = null;
        $this->values[self::RECEIVERCHAINS] = array();
        $this->values[self::PENDINGKEYEXCHANGE] = null;
        $this->values[self::PENDINGPREKEY] = null;
        $this->values[self::REMOTEREGISTRATIONID] = null;
        $this->values[self::LOCALREGISTRATIONID] = null;
        $this->values[self::NEEDSREFRESH] = null;
        $this->values[self::ALICEBASEKEY] = null;
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
     * Sets value of 'sessionVersion' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setSessionVersion($value)
    {
        return $this->set(self::SESSIONVERSION, $value);
    }

    /**
     * Returns value of 'sessionVersion' property
     *
     * @return int
     */
    public function getSessionVersion()
    {
        return $this->get(self::SESSIONVERSION);
    }

    /**
     * Sets value of 'localIdentityPublic' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setLocalIdentityPublic($value)
    {
        return $this->set(self::LOCALIDENTITYPUBLIC, $value);
    }

    /**
     * Returns value of 'localIdentityPublic' property
     *
     * @return string
     */
    public function getLocalIdentityPublic()
    {
        return $this->get(self::LOCALIDENTITYPUBLIC);
    }

    /**
     * Sets value of 'remoteIdentityPublic' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRemoteIdentityPublic($value)
    {
        return $this->set(self::REMOTEIDENTITYPUBLIC, $value);
    }

    /**
     * Returns value of 'remoteIdentityPublic' property
     *
     * @return string
     */
    public function getRemoteIdentityPublic()
    {
        return $this->get(self::REMOTEIDENTITYPUBLIC);
    }

    /**
     * Sets value of 'rootKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRootKey($value)
    {
        return $this->set(self::ROOTKEY, $value);
    }

    /**
     * Returns value of 'rootKey' property
     *
     * @return string
     */
    public function getRootKey()
    {
        return $this->get(self::ROOTKEY);
    }

    /**
     * Sets value of 'previousCounter' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setPreviousCounter($value)
    {
        return $this->set(self::PREVIOUSCOUNTER, $value);
    }

    /**
     * Returns value of 'previousCounter' property
     *
     * @return int
     */
    public function getPreviousCounter()
    {
        return $this->get(self::PREVIOUSCOUNTER);
    }

    /**
     * Sets value of 'senderChain' property
     *
     * @param \Localstorage\SessionStructure\Chain $value Property value
     *
     * @return null
     */
    public function setSenderChain(\Localstorage\SessionStructure\Chain $value)
    {
        return $this->set(self::SENDERCHAIN, $value);
    }

    /**
     * Returns value of 'senderChain' property
     *
     * @return \Localstorage\SessionStructure\Chain
     */
    public function getSenderChain()
    {
        return $this->get(self::SENDERCHAIN);
    }

    /**
     * Appends value to 'receiverChains' list
     *
     * @param \Localstorage\SessionStructure\Chain $value Value to append
     *
     * @return null
     */
    public function appendReceiverChains(\Localstorage\SessionStructure\Chain $value)
    {
        return $this->append(self::RECEIVERCHAINS, $value);
    }

    /**
     * Clears 'receiverChains' list
     *
     * @return null
     */
    public function clearReceiverChains()
    {
        return $this->clear(self::RECEIVERCHAINS);
    }

    /**
     * Returns 'receiverChains' list
     *
     * @return \Localstorage\SessionStructure\Chain[]
     */
    public function getReceiverChains()
    {
        return $this->get(self::RECEIVERCHAINS);
    }

    /**
     * Returns 'receiverChains' iterator
     *
     * @return ArrayIterator
     */
    public function getReceiverChainsIterator()
    {
        return new \ArrayIterator($this->get(self::RECEIVERCHAINS));
    }

    /**
     * Returns element from 'receiverChains' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \Localstorage\SessionStructure\Chain
     */
    public function getReceiverChainsAt($offset)
    {
        return $this->get(self::RECEIVERCHAINS, $offset);
    }

    /**
     * Returns count of 'receiverChains' list
     *
     * @return int
     */
    public function getReceiverChainsCount()
    {
        return $this->count(self::RECEIVERCHAINS);
    }

    /**
     * Sets value of 'pendingKeyExchange' property
     *
     * @param \Localstorage\SessionStructure\PendingKeyExchange $value Property value
     *
     * @return null
     */
    public function setPendingKeyExchange(\Localstorage\SessionStructure\PendingKeyExchange $value)
    {
        return $this->set(self::PENDINGKEYEXCHANGE, $value);
    }

    /**
     * Returns value of 'pendingKeyExchange' property
     *
     * @return \Localstorage\SessionStructure\PendingKeyExchange
     */
    public function getPendingKeyExchange()
    {
        return $this->get(self::PENDINGKEYEXCHANGE);
    }

    /**
     * Sets value of 'pendingPreKey' property
     *
     * @param \Localstorage\SessionStructure\PendingPreKey $value Property value
     *
     * @return null
     */
    public function setPendingPreKey(\Localstorage\SessionStructure\PendingPreKey $value)
    {
        return $this->set(self::PENDINGPREKEY, $value);
    }

    /**
     * Returns value of 'pendingPreKey' property
     *
     * @return \Localstorage\SessionStructure\PendingPreKey
     */
    public function getPendingPreKey()
    {
        return $this->get(self::PENDINGPREKEY);
    }

    /**
     * Sets value of 'remoteRegistrationId' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setRemoteRegistrationId($value)
    {
        return $this->set(self::REMOTEREGISTRATIONID, $value);
    }

    /**
     * Returns value of 'remoteRegistrationId' property
     *
     * @return int
     */
    public function getRemoteRegistrationId()
    {
        return $this->get(self::REMOTEREGISTRATIONID);
    }

    /**
     * Sets value of 'localRegistrationId' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setLocalRegistrationId($value)
    {
        return $this->set(self::LOCALREGISTRATIONID, $value);
    }

    /**
     * Returns value of 'localRegistrationId' property
     *
     * @return int
     */
    public function getLocalRegistrationId()
    {
        return $this->get(self::LOCALREGISTRATIONID);
    }

    /**
     * Sets value of 'needsRefresh' property
     *
     * @param bool $value Property value
     *
     * @return null
     */
    public function setNeedsRefresh($value)
    {
        return $this->set(self::NEEDSREFRESH, $value);
    }

    /**
     * Returns value of 'needsRefresh' property
     *
     * @return bool
     */
    public function getNeedsRefresh()
    {
        return $this->get(self::NEEDSREFRESH);
    }

    /**
     * Sets value of 'aliceBaseKey' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setAliceBaseKey($value)
    {
        return $this->set(self::ALICEBASEKEY, $value);
    }

    /**
     * Returns value of 'aliceBaseKey' property
     *
     * @return string
     */
    public function getAliceBaseKey()
    {
        return $this->get(self::ALICEBASEKEY);
    }

    public function clearPendingPreKey()
    {
        $this->values[self::PENDINGPREKEY] = null;
    }
}
}
