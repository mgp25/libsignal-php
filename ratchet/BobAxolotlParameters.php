<?php
require_once("org/whispersystems/libaxolotl/IdentityKey.php");
require_once("org/whispersystems/libaxolotl/IdentityKeyPair.php");
require_once("org/whispersystems/libaxolotl/ecc/ECKeyPair.php");
require_once("org/whispersystems/libaxolotl/ecc/ECPublicKey.php");
require_once("org/whispersystems/libaxolotl/util/guava/Optional.php");
class BobAxolotlParameters {
	protected $ourIdentityKey;	// IdentityKeyPair
	protected $ourSignedPreKey;	// ECKeyPair
	protected $ourOneTimePreKey;	// Optional<ECKeyPair>
	protected $ourRatchetKey;	// ECKeyPair
	protected $theirIdentityKey;	// IdentityKey
	protected $theirBaseKey;	// ECPublicKey
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	public static function constructor__da01dd6e ($ourIdentityKey, $ourSignedPreKey, $ourRatchetKey, $ourOneTimePreKey, $theirIdentityKey, $theirBaseKey) // [IdentityKeyPair ourIdentityKey, ECKeyPair ourSignedPreKey, ECKeyPair ourRatchetKey, Optional<ECKeyPair> ourOneTimePreKey, IdentityKey theirIdentityKey, ECPublicKey theirBaseKey]
	{
		$me = new self();
		$me->__init();
		$me->ourIdentityKey = $ourIdentityKey;
		$me->ourSignedPreKey = $ourSignedPreKey;
		$me->ourRatchetKey = $ourRatchetKey;
		$me->ourOneTimePreKey = $ourOneTimePreKey;
		$me->theirIdentityKey = $theirIdentityKey;
		$me->theirBaseKey = $theirBaseKey;
		if ((((((($ourIdentityKey == null) || ($ourSignedPreKey == null)) || ($ourRatchetKey == null)) || ($ourOneTimePreKey == null)) || ($theirIdentityKey == null)) || ($theirBaseKey == null)))
		{
			throw new IllegalArgumentException("Null value!");
		}
		return $me;
	}
	public function getOurIdentityKey () 
	{
		return $this->ourIdentityKey;
	}
	public function getOurSignedPreKey () 
	{
		return $this->ourSignedPreKey;
	}
	public function getOurOneTimePreKey () 
	{
		return $this->ourOneTimePreKey;
	}
	public function getTheirIdentityKey () 
	{
		return $this->theirIdentityKey;
	}
	public function getTheirBaseKey () 
	{
		return $this->theirBaseKey;
	}
	public static function newBuilder () 
	{
		return new Builder();
	}
	public function getOurRatchetKey () 
	{
		return $this->ourRatchetKey;
	}
}
BobAxolotlParameters::__staticinit(); // initialize static vars for this class on load
?>
