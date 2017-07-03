<?php
namespace Libsignal\ratchet;

class SymmetricBuilder
{
    protected $ourBaseKey;    // ECKeyPair
        protected $ourRatchetKey;    // ECKeyPair
        protected $ourIdentityKey;    // IdentityKeyPair
        protected $theirBaseKey;    // ECPublicKey
        protected $theirRatchetKey;    // ECPublicKey
        protected $theirIdentityKey;    // IdentityKey

        public function __construct()
        {
            $this->ourIdentityKey = null;
            $this->ourBaseKey = null;
            $this->ourRatchetKey = null;
            $this->theirRatchetKey = null;
            $this->theirIdentityKey = null;
            $this->theirBaseKey = null;
        }

    public function setOurIdentityKey($ourIdentityKey)
    {
        $this->ourIdentityKey = $ourIdentityKey;

        return $this;
    }

    public function setOurBaseKey($ourBaseKey)
    {
        $this->ourBaseKey = $ourBaseKey;

        return $this;
    }

    public function setOurRatchetKey($ourRatchetKey)
    {
        $this->ourRatchetKey = $ourRatchetKey;

        return $this;
    }

    public function setTheirRatchetKey($theirRatchetKey)
    {
        $this->theirRatchetKey = $theirRatchetKey;

        return $this;
    }

    public function setTheirIdentityKey($theirIdentityKey)
    {
        $this->theirIdentityKey = $theirIdentityKey;

        return $this;
    }

    public function setTheirBaseKey($theirBaseKey)
    {
        $this->theirBaseKey = $theirBaseKey;

        return $this;
    }

    public function create()
    {
        return new SymmetricAxolotlParameters($this->ourBaseKey, $this->ourRatchetKey, $this->ourIdentityKey,
                                        $this->theirBaseKey, $this->theirRatchetKey, $this->theirIdentityKey);
    }
}
