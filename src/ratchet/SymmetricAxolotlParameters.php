<?php
namespace Libsignal\ratchet;

use Exception;
use Libsignal\IdentityKeyPair;

class SymmetricAxolotlParameters
{
    protected $ourBaseKey;    // ECKeyPair
    protected $ourRatchetKey;    // ECKeyPair
    protected $ourIdentityKey;    // IdentityKeyPair
    protected $theirBaseKey;    // ECPublicKey
    protected $theirRatchetKey;    // ECPublicKey
    protected $theirIdentityKey;    // IdentityKey

    /**
     * SymmetricAxolotlParameters constructor.
     * @param $ourBaseKey
     * @param $ourRatchetKey
     * @param $ourIdentityKey
     * @param $theirBaseKey
     * @param $theirRatchetKey
     * @param $theirIdentityKey
     * @throws Exception
     */
    public function __construct($ourBaseKey, $ourRatchetKey, $ourIdentityKey, $theirBaseKey, $theirRatchetKey, $theirIdentityKey) // [ECKeyPair ourBaseKey, ECKeyPair ourRatchetKey, IdentityKeyPair ourIdentityKey, ECPublicKey theirBaseKey, ECPublicKey theirRatchetKey, IdentityKey theirIdentityKey]
    {
        $this->ourBaseKey = $ourBaseKey;
        $this->ourRatchetKey = $ourRatchetKey;
        $this->ourIdentityKey = $ourIdentityKey;
        $this->theirBaseKey = $theirBaseKey;
        $this->theirRatchetKey = $theirRatchetKey;
        $this->theirIdentityKey = $theirIdentityKey;

        if (($ourBaseKey == null) || ($ourRatchetKey == null)
            || ($ourIdentityKey == null) || ($theirBaseKey == null)
            || ($theirRatchetKey == null) || ($theirIdentityKey == null)) {
            throw new Exception('Null values!');
        }
    }

    public function getOurBaseKey()
    {
        return $this->ourBaseKey;
    }

    public function getOurRatchetKey()
    {
        return $this->ourRatchetKey;
    }

    /**
     * @return IdentityKeyPair
     */
    public function getOurIdentityKey()
    {
        return $this->ourIdentityKey;
    }

    public function getTheirBaseKey()
    {
        return $this->theirBaseKey;
    }

    public function getTheirRatchetKey()
    {
        return $this->theirRatchetKey;
    }

    public function getTheirIdentityKey()
    {
        return $this->theirIdentityKey;
    }

    public static function newBuilder()
    {
        return new SymmetricBuilder();
    }
}
