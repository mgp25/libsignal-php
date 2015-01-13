<?php

namespace libaxolotl;

/**
 * A class for representing an identity key.
 *
 * @author archergod
 */

class IdentityKey {

	private $publicKey;

	/**
	 * 
	 * @param ECPublicKey/byte[] $publicKey Can be a ECPublicKey object or byte Array. 
	 * @param int $offset needed if $publicKey is byte array 
	 */
	public function __construct($publicKey, $offset=null)
	{
		if ($publicKey instanceof ECPublicKey){
			$this->publicKey = $publicKey;
		} elseif (is_array($publicKey)) {
			$this->publicKey = Curve::decodePoint($publicKey, $offset);
		} else {
			throw new Exception ("Invalid Arguments.");
		}
	}

	/**
	 * Returns the ECPublicKey object from publickey
	 */
	public function getPublicKey() {
		return $this->publicKey;
	}

	/**
	 * Returns serialize object from publickey;
	 */
	public function serialize() {
		return serialize($this->publicKey);
	}

	/**
 	* Incomplete, looking for Hex equivalent in php; 
 	*/	
	public function getFingerprint() {
		//@todo: below is java line need php equivalent
		//return Hex.toString(publicKey.serialize());
	}

	public function equals($other) {
		if ($other == null) return false;
		if (!($other instanceof IdentityKey)) return false;
		return ($this->publicKey=== $other.getPublicKey());
	}

	/**
	 * Incomplete function, PHP doesn't have hashCode??
	 * Currently returns null as replacement.
	 * @return string
	 */
	public function hashCode() {
		//@todo: hashCode is not available. What to do?
		//return $this->publicKey.hashCode();
		return null;
	}
}


?>