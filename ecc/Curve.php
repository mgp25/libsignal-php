<?php
require_once("org/whispersystems/curve25519/Curve25519KeyPair.php");
require_once("InvalidKeyException.php");
require_once("org/whispersystems/curve25519/Curve25519.php");
require_once("java/security/NoSuchAlgorithmException.php");
require_once("java/security/SecureRandom.php");
class Curve {
	public static $DJB_TYPE;	// int
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
		self::$DJB_TYPE = 0x05;
	}
	public static function isNative ()
	{
		return $Curve25519->isNative();
	}
	public static function generateKeyPair ()
	{
		$secureRandom = self::getSecureRandom();
		$keyPair = $Curve25519->generateKeyPair($secureRandom);
		return ECKeyPair::constructor__43f151c1(DjbECPublicKey::constructor__ae1a4a6a($keyPair->getPublicKey()), DjbECPrivateKey::constructor__ae1a4a6a($keyPair->getPrivateKey()));
	}
	public static function decodePoint ($bytes, $offset) // [byte[] bytes, int offset]
	{
		$type = ($bytes[$offset] & 0xFF);
		switch ($type) {
			case Curve::$DJB_TYPE:
				$keyBytes = array();
				foreach (range(0, (count($keyBytes) /*from: keyBytes.length*/ + 0)) as $_upto) $keyBytes[$_upto] = $bytes[$_upto - (0) + ($offset + 1)]; /* from: System.arraycopy(bytes, offset + 1, keyBytes, 0, keyBytes.length) */;
				return DjbECPublicKey::constructor__ae1a4a6a($keyBytes);
			default:
				throw new InvalidKeyException(("Bad key type: " . $type));
		}
	}
	public static function decodePrivatePoint ($bytes) // [byte[] bytes]
	{
		return DjbECPrivateKey::constructor__ae1a4a6a($bytes);
	}
	public static function calculateAgreement ($publicKey, $privateKey) // [ECPublicKey publicKey, ECPrivateKey privateKey]
	{
		if (($publicKey->getType() != $privateKey->getType()))
		{
			throw new InvalidKeyException("Public and private keys must be of the same type!");
		}
		if (($publicKey->getType() == self::$DJB_TYPE))
		{
			return $Curve25519->calculateAgreement(call_user_func (array($publicKey,getPublicKey())) , call_user_func (array($privateKey,getPrivateKey())) );
		}
		else
		{
			throw new InvalidKeyException(("Unknown type: " . $publicKey->getType()));
		}
	}
	public static function verifySignature ($signingKey, $message, $signature) // [ECPublicKey signingKey, byte[] message, byte[] signature]
	{
		if (($signingKey->getType() == self::$DJB_TYPE))
		{
			return $Curve25519->verifySignature(call_user_func (array($signingKey,getPublicKey())), $message, $signature);
		}
		else
		{
			throw new InvalidKeyException(("Unknown type: " . $signingKey->getType()));
		}
	}
	public static function calculateSignature ($signingKey, $message) // [ECPrivateKey signingKey, byte[] message]
	{
		if (($signingKey->getType() == self::$DJB_TYPE))
		{
			return $Curve25519->calculateSignature(self::getSecureRandom(),call_user_func (array($signingKey,getPrivateKey())) , $message);
		}
		else
		{
			throw new InvalidKeyException(("Unknown type: " . $signingKey->getType()));
		}
	}
	protected static function getSecureRandom ()
	{
		try
		{
			return $SecureRandom->getInstance("SHA1PRNG");
		}
		catch (NoSuchAlgorithmException $e)
		{
			throw new AssertionError($e);
		}
	}
}
Curve::__staticinit(); // initialize static vars for this class on load
?>
