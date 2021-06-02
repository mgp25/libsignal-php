<?php
namespace Libsignal\ecc;

class DjbECPublicKey implements ECPublicKey{

    const KEY_SIZE = 33;

    /**
     * @var string $publicKey
     */
    protected $publicKey;

    /**
     * DjbECPublicKey constructor.
     * @param string $publicKey
     */
    public function __construct($publicKey){
        $this->publicKey = $publicKey;
    }

    public function serialize()
    {
        return chr(Curve::DJB_TYPE).$this->publicKey;
    }

    public function getType()
    {
        return Curve::DJB_TYPE;
    }

    /**
     * @param mixed $other
     * @return bool
     */
    public function equals($other){
        if (($other == null)) {
            return  false;
        }
        if (!($other instanceof self)) {
            return  false;
        }
        $that = $other;

        return $this->publicKey == $that->publicKey;
    }

    /**
     * @param DjbECPublicKey $another
     * @return int
     */
    public function compareTo($another){
        for ($x = 0; $x < strlen($this->publicKey); $x++) {
            if (ord($this->publicKey[$x]) > ord($another->publicKey[$x])) {
                return 1;
            } elseif (ord($this->publicKey[$x]) > ord($another->publicKey[$x])) {
                return -1;
            }
        }
        return 0;
    }

    public function getPublicKey(){
        return $this->publicKey;
    }

}