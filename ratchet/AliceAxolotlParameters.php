<?php
require_once("org/whispersystems/libaxolotl/IdentityKey.php");
require_once("org/whispersystems/libaxolotl/IdentityKeyPair.php");
require_once("org/whispersystems/libaxolotl/ecc/ECKeyPair.php");
require_once("org/whispersystems/libaxolotl/ecc/ECPublicKey.php");
require_once("org/whispersystems/libaxolotl/util/guava/Optional.php");
class AliceAxolotlParameters {
	protected $ourIdentityKey;	// IdentityKeyPair
	protected $ourBaseKey;	// ECKeyPair
	protected $theirIdentityKey;	// IdentityKey
	protected $theirSignedPreKey;	// ECPublicKey
	protected $theirOneTimePreKey;	// Optional<ECPublicKey>
	protected $theirRatchetKey;	// ECPublicKey
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	public static function constructor__3d94708e ($ourIdentityKey, $ourBaseKey, $theirIdentityKey, $theirSignedPreKey, $theirRatchetKey, $theirOneTimePreKey) // [IdentityKeyPair ourIdentityKey, ECKeyPair ourBaseKey, IdentityKey theirIdentityKey, ECPublicKey theirSignedPreKey, ECPublicKey theirRatchetKey, Optional<ECPublicKey> theirOneTimePreKey]
	{
		$me = new self();
		$me->__init();
		$me->ourIdentityKey = $ourIdentityKey;
		$me->ourBaseKey = $ourBaseKey;
		$me->theirIdentityKey = $theirIdentityKey;
		$me->theirSignedPreKey = $theirSignedPreKey;
		$me->theirRatchetKey = $theirRatchetKey;
		$me->theirOneTimePreKey = $theirOneTimePreKey;
		if ((((((($ourIdentityKey == null) || ($ourBaseKey == null)) || ($theirIdentityKey == null)) || ($theirSignedPreKey == null)) || ($theirRatchetKey == null)) || ($theirOneTimePreKey == null)))
		{
			throw new IllegalArgumentException("Null values!");
		}
		return $me;
	}
	public function getOurIdentityKey () 
	{
		return $this->ourIdentityKey;
	}
	public function getOurBaseKey () 
	{
		return $this->ourBaseKey;
	}
	public function getTheirIdentityKey () 
	{
		return $this->theirIdentityKey;
	}
	public function getTheirSignedPreKey () 
	{
		return $this->theirSignedPreKey;
	}
	public function getTheirOneTimePreKey () 
	{
		return $this->theirOneTimePreKey;
	}
	public static function newBuilder () 
	{
		return new Builder();
	}
	public function getTheirRatchetKey () 
	{
		return $this->theirRatchetKey;
	}
}
AliceAxolotlParameters::__staticinit(); // initialize static vars for this class on load
?>
