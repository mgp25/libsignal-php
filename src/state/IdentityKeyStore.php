<?php
namespace Libsignal\state;

use Libsignal\IdentityKey;
use Libsignal\IdentityKeyPair;

abstract class IdentityKeyStore
{
    /**
     * @return IdentityKeyPair
     */
    abstract public function getIdentityKeyPair();

    abstract public function getLocalRegistrationId();

    abstract public function saveIdentity($recipientId, $identityKey);

 // [long recipientId, IdentityKey identityKey]

    abstract public function isTrustedIdentity($recipientId, $identityKey);

 // [long recipientId, IdentityKey identityKey]
}
