<?php

class SenderKeyName
{
    protected $groupId;
    protected $sender;
    protected $deviceId;

    public function __construct($groupId, $sender, $deviceId)
    {
        if (strpos($groupId, '@broadcast') === false) {
            $groupId = ExtractNumber($groupId);
        }
        $this->groupId = $groupId;
        $this->sender = ExtractNumber($sender);
        $this->deviceId = $deviceId;
    }

    public function getGroupId()
    {
        return $this->groupId;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getDeviceId()
    {
        return $this->deviceId;
    }

    public function __toString()
    {
        return $this->groupId.':'.$this->sender.':'.$this->deviceId;
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

        return ($this->groupId == $that->groupId) && ($this->sender == $that->sender);
    }
}
