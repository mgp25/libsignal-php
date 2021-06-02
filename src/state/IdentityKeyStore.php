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

    /**
     * @return int
     */
    abstract public function getLocalRegistrationId();

    /**
     * @param int $recipientId
     * @param IdentityKey $identityKey
     * @return mixed
     */
    abstract public function saveIdentity($recipientId, $identityKey);

    /**
     * @param int $recipientId
     * @param IdentityKey $identityKey
     * @return mixed
     */
    abstract public function isTrustedIdentity($recipientId, $identityKey);

}
