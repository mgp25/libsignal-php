<?php
namespace Libsignal\ecc;

use Curve25519\Curve25519;
use Exception;
use Libsignal\exceptions\InvalidKeyException;

class Curve{

    const DJB_TYPE = 0x05;

    /**
     * @return ECKeyPair
     * @throws Exception
     */
    public static function generateKeyPair(){
        $secureRandom = self::getSecureRandom();
        $private = $secureRandom;
        $public = (new Curve25519())->publicKey($private);

        return new ECKeyPair(new DjbECPublicKey($public), new DjbECPrivateKey($private));
    }

    /**
     * @param string $bytes
     * @param int $offset
     * @return DjbECPublicKey
     * @throws InvalidKeyException
     */
    public static function decodePoint($bytes, $offset){
        $type = ((ord($bytes[$offset]) & 0xFF));
        switch ($type) {
            case self::DJB_TYPE:
                $keyBytes = substr($bytes, $offset + 1); /* from: System.arraycopy(bytes, offset + 1, keyBytes, 0, keyBytes.length) -> php string == java byte array*/;
                //foreach (range(0, (count($keyBytes) /*from: keyBytes.length*/ + 0)) as $_upto) $keyBytes[$_upto] = $bytes[$_upto - (0) + ($offset + 1)]; /* from: System.arraycopy(bytes, offset + 1, keyBytes, 0, keyBytes.length) */;
                return new DjbECPublicKey($keyBytes);
            default:
                throw new InvalidKeyException('Bad key type: '.$type);
        }
    }

    /**
     * @param string $bytes
     * @return DjbECPrivateKey
     */
    public static function decodePrivatePoint($bytes){
        return new DjbECPrivateKey($bytes);
    }

    /**
     * @param DjbECPublicKey $publicKey
     * @param DjbECPrivateKey $privateKey
     * @return mixed
     * @throws InvalidKeyException
     */
    public static function calculateAgreement($publicKey, $privateKey){
        if (($publicKey->getType() != $privateKey->getType())) {
            throw new InvalidKeyException('Public and private keys must be of the same type!');
        }
        if (($publicKey->getType() == self::DJB_TYPE)) {
            return (new Curve25519())->sharedKey($privateKey->getPrivateKey(), $publicKey->getPublicKey());
        } else {
            throw new InvalidKeyException('Unknown type: '.$publicKey->getType());
        }
    }

    /**
     * @param DjbECPublicKey $signingKey
     * @param string $message
     * @param string $signature
     * @return bool
     * @throws InvalidKeyException
     */
    public static function verifySignature($signingKey, $message, $signature){
        if (($signingKey->getType() == self::DJB_TYPE)) {
            return (new \deemru\Curve25519())->verify($signature,$message,$signingKey->getPublicKey());
        } else {
            throw new InvalidKeyException('Unknown type: '.$signingKey->getType());
        }
    }

    /**
     * @param DjbECPrivateKey $signingKey
     * @param string $message
     * @return mixed
     * @throws InvalidKeyException
     * @throws Exception
     */
    public static function calculateSignature($signingKey, $message){
        if (($signingKey->getType() == self::DJB_TYPE)) {
            return (new \deemru\Curve25519())->sign($message,$signingKey->getPrivateKey(),self::getSecureRandom(64));
        } else {
            throw new InvalidKeyException('Unknown type: '.$signingKey->getType());
        }
    }

    /**
     * @param int $len
     * @return string
     * @throws Exception
     */
    protected static function getSecureRandom($len = 32){
        $rand = openssl_random_pseudo_bytes($len, $strong);
        if ($strong) {
            return $rand;
        } else {
            throw new Exception('Cannot generate secure random bytes');
        }
    }

}