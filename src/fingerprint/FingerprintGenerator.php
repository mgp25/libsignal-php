<?php

require_once __DIR__.'/../IdentityKey.php';

interface FingerprintGenerator
{
    public function createFor($localStableIdentifier, $ocalIdentityKey,
                               $remoteStableIdentifier, $remoteIdentityKey);
}
