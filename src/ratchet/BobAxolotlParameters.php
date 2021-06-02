<?php
namespace Libsignal\ratchet;

use Exception;

class BobAxolotlParameters
{
    protected $ourIdentityKey;
    protected $ourSignedPreKey;
    protected $ourRatchetKey;
    protected $ourOneTimePreKey;
    protected $theirIdentityKey;
    protected $theirBaseKey;

    /**
     * BobAxolotlParameters constructor.
     * @param $ourIdentityKey
     * @param $ourSignedPreKey
     * @param $ourRatchetKey
     * @param $ourOneTimePreKey
     * @param $theirIdentityKey
     * @param $theirBaseKey
     * @throws Exception
     */
    public function __construct($ourIdentityKey, $ourSignedPreKey,
                 $ourRatchetKey, $ourOneTimePreKey,
                 $theirIdentityKey, $theirBaseKey) // [IdentityKeyPair ourIdentityKey, ECKeyPair ourSignedPreKey, IdentityKey theirIdentityKey, ECPublicKey ourRatchetKey, ECPublicKey ourOneTimePreKey, Optional<ECPublicKey> theirBaseKey]
    {
        $this->ourIdentityKey = $ourIdentityKey;
        $this->ourSignedPreKey = $ourSignedPreKey;
        $this->ourRatchetKey = $ourRatchetKey;
        $this->ourOneTimePreKey = $ourOneTimePreKey;
        $this->theirIdentityKey = $theirIdentityKey;
        $this->theirBaseKey = $theirBaseKey;
        if (($ourIdentityKey == null) || ($ourSignedPreKey == null)
             || ($ourRatchetKey == null)
             || ($theirIdentityKey == null) ||  ($theirBaseKey == null)) {
            throw new Exception('Null values!');
        }
    }

    public function getOurIdentityKey()
    {
        return $this->ourIdentityKey;
    }

    public function getOurSignedPreKey()
    {
        return $this->ourSignedPreKey;
    }

    public function getTheirIdentityKey()
    {
        return $this->theirIdentityKey;
    }

    public function getOurRatchetKey()
    {
        return $this->ourRatchetKey;
    }

    public function getTheirBaseKey()
    {
        return $this->theirBaseKey;
    }

    public static function newBuilder()
    {
        return new BobBuilder();
    }

    public function getOurOneTimePreKey()
    {
        return $this->ourOneTimePreKey;
    }
}

class BobBuilder
{
    protected $ourIdentityKey;
    protected $ourSignedPreKey;
    protected $ourRatchetKey;
    protected $ourOneTimePreKey;
    protected $theirIdentityKey;
    protected $theirBaseKey;

    public function __construct()
    {
        $this->ourIdentityKey = null;
        $this->ourSignedPreKey = null;
        $this->ourRatchetKey = null;
        $this->ourOneTimePreKey = null;
        $this->theirIdentityKey = null;
        $this->theirBaseKey = null;
    }

    public function setOurIdentityKey($ourIdentityKey)
    {
        $this->ourIdentityKey = $ourIdentityKey;

        return $this;
    }

    public function setOurSignedPreKey($ourSignedPreKey)
    {
        $this->ourSignedPreKey = $ourSignedPreKey;

        return $this;
    }

    public function setOurOneTimePreKey($ourOneTimePreKey)
    {
        $this->ourOneTimePreKey = $ourOneTimePreKey;

        return $this;
    }

    public function setTheirIdentityKey($theirIdentityKey)
    {
        $this->theirIdentityKey = $theirIdentityKey;

        return $this;
    }

    public function setOurRatchetKey($ourRatchetKey)
    {
        $this->ourRatchetKey = $ourRatchetKey;

        return $this;
    }

    public function setTheirBaseKey($theirBaseKey)
    {
        $this->theirBaseKey = $theirBaseKey;

        return $this;
    }

    public function create()
    {
        return new BobAxolotlParameters($this->ourIdentityKey, $this->ourSignedPreKey, $this->ourRatchetKey, $this->ourOneTimePreKey,
                                        $this->theirIdentityKey,
                                        $this->theirBaseKey);
    }
}
