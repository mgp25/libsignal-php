<?php

class DisplayableFingerprint
{
    private $localFingerprint;
    private $remoteFingerprint;

    public function __construct($localFingerprint, $remoteFingerprint)
    {
        $this->localFingerprint = $localFingerprint;
        $this->remoteFingerprint = $remoteFingerprint;
    }

    public function getDisplayText()
    {
        if ($this->localFingerprint != $this->remoteFingerprint) {
            return $this->localFingerprint.$this->remoteFingerprint;
        } else {
            return $this->remoteFingerprint.$this->localFingerprint;
        }
    }

    public function __toString()
    {
        return $this->getDisplayText();
    }
}
