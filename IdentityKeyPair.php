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
	private $privateKey;

	public function __construct($key, $pKey="") {
		if ($key instanceof IdentityKey && $pKey instanceof ECPrivateKey){
			$this->publicKey  = $key;
			$this->privateKey = $pKey;
		}else if (is_array($key)){
			try {
				IdentityKeyPairStructure structure = IdentityKeyPairStructure.parseFrom(serialized);
				$this->publicKey  = new IdentityKey(structure.getPublicKey().toByteArray(), 0);
				$this->privateKey = Curve.decodePrivatePoint(structure.getPrivateKey().toByteArray());
			} catch (Exception $e) {
				throw new Exception($e);
			}
		}
	}

	public IdentityKeyPair(byte[] serialized) throws InvalidKeyException {
		try {
			IdentityKeyPairStructure structure = IdentityKeyPairStructure.parseFrom(serialized);
			$this->publicKey  = new IdentityKey(structure.getPublicKey().toByteArray(), 0);
			$this->privateKey = Curve.decodePrivatePoint(structure.getPrivateKey().toByteArray());
		} catch (InvalidProtocolBufferException e) {
			throw new InvalidKeyException(e);
		}
	}

	public IdentityKey getPublicKey() {
		return publicKey;
	}

	public ECPrivateKey getPrivateKey() {
		return privateKey;
	}

	public byte[] serialize() {
		return IdentityKeyPairStructure.newBuilder()
		.setPublicKey(ByteString.copyFrom(publicKey.serialize()))
		.setPrivateKey(ByteString.copyFrom(privateKey.serialize()))
		.build().toByteArray();
	}
}
?>