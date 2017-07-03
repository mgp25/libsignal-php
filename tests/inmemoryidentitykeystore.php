<?php
namespace Libsignal\Tests;
//from axolotl.state.identitykeystore import IdentityKeyStore
//from axolotl.ecc.curve import Curve
//from axolotl.identitykey import IdentityKey
//from axolotl.util.keyhelper import KeyHelper
//from axolotl.identitykeypair import IdentityKeyPair
use Libsignal\state\IdentityKeyStore;
use Libsignal\ecc\Curve;
use Libsignal\util\KeyHelper;
use Libsignal\IdentityKeyPair;
use Libsignal\IdentityKey;

class InMemoryIdentityKeyStore extends IdentityKeyStore
{
    protected $trustedKeys;
    protected $identityKeyPair;
    protected $localRegistrationId;

    public function __construct()
    {
        $this->trustedKeys = [];
        $identityKeyPairKeys = Curve::generateKeyPair();
        $this->identityKeyPair = new IdentityKeyPair(new IdentityKey($identityKeyPairKeys->getPublicKey()),
                                               $identityKeyPairKeys->getPrivateKey());
        $this->localRegistrationId = KeyHelper::generateRegistrationId();
    }

    public function getIdentityKeyPair()
    {
        return $this->identityKeyPair;
    }

    public function getLocalRegistrationId()
    {
        return $this->localRegistrationId;
    }

    public function saveIdentity($recepientId, $identityKey)
    {
        $this->trustedKeys[$recepientId] = $identityKey;
    }

    public function isTrustedIdentity($recepientId, $identityKey)
    {
        if (!isset($this->trustedKeys[$recepientId])) {
            return true;
        }

        return $this->trustedKeys[$recepientId] == $identityKey;
    }
}
