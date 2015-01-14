<?php

namespace libaxolotl;

/**
 * Holder for public and private identity key pair.
 *
 * @author archergod
 */
class IdentityKeyPair {

	/**
	 * @param IdentityKey publicKey 
	 */
	private $publicKey;
	/**
	 * 
	 * @var ECPrivateKey
	 */
	private $privateKey;

	public function __construct($key, $pKey="") {
		if ($key instanceof IdentityKey && $pKey instanceof ECPrivateKey){
			$this->publicKey  = $key;
			$this->privateKey = $pKey;
		}else if (is_array($key)){
			try {
				$structure = IdentityKeyPairStructure::parseFrom($key);
				$this->publicKey  = new IdentityKey($structure->getPublicKey()->toByteArray(), 0);
				$this->privateKey = Curve.decodePrivatePoint($structure->getPrivateKey()->toByteArray());
			} catch (Exception $e) {
				throw new Exception($e);
			}
		}
	}

	/**
	 * 
	 * @return \libaxolotl\IdentityKey
	 */
	public function getPublicKey() {
		return $this->publicKey;
	}

	/**
	 * 
	 * @return \libaxolotl\ECPrivateKey
	 */
	public function getPrivateKey() {
		return $this->privateKey;
	}

	/**
	 * Returns byte array
	 */
	public function serialize() {
		return IdentityKeyPairStructure::newBuilder()->setPublicKey(ByteString.copyFrom($this->publicKey->serialize()))
		->setPrivateKey(ByteString::copyFrom($this->privateKey->serialize()))
		->build()->toByteArray();
	}
}
?>