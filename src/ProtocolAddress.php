<?php

class ProtocolAddress
{
    protected $name;
    protected $deviceId;

    public function __construct($name, $deviceId)
    {
        $this->name = $name;
        $this->deviceId = $deviceId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDeviceId()
    {
        return $this->deviceId;
    }

    public function toString()
    {
        return $name.':'.$deviceId;
    }

    public function equals($other)
    {
        if (is_null($other)) {
            return false;
        }
        if (!($other instanceof self)) {
            return false;
        }

        $that = $other;

        return ($this->name == $that->getName()) && ($this->deviceId == $that->getDeviceId());
    }

    public function hashCode()
    {
        return spl_object_hash($this->name) ^ $this->deviceId;
    }
}
