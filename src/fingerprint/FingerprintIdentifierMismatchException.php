<?php

class FingerprintIdentifierMismatchException extends Exception
{
    private $localIdentifier;
    private $remoteIdentifier;
    private $scannedLocalIdentifier;
    private $scannedRemoteIdentifier;

    public function __construct($localIdentifier, $remoteIdentifier,
                                                $scannedLocalIdentifier, $scannedRemoteIdentifier)
    {
        $this->localIdentifier = $localIdentifier;
        $this->remoteIdentifier = $remoteIdentifier;
        $this->scannedLocalIdentifier = $scannedLocalIdentifier;
        $this->scannedRemoteIdentifier = $scannedRemoteIdentifier;
    }

    public function getScannedRemoteIdentifier()
    {
        return $this->scannedRemoteIdentifier;
    }

    public function getScannedLocalIdentifier()
    {
        return $this->scannedLocalIdentifier;
    }

    public function getRemoteIdentifier()
    {
        return $this->remoteIdentifier;
    }

    public function getLocalIdentifier()
    {
        return $this->localIdentifier;
    }
}
