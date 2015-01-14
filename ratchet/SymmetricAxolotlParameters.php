<?php
require_once("org/whispersystems/libaxolotl/IdentityKey.php");
require_once("org/whispersystems/libaxolotl/IdentityKeyPair.php");
require_once("org/whispersystems/libaxolotl/ecc/ECKeyPair.php");
require_once("org/whispersystems/libaxolotl/ecc/ECPublicKey.php");
class SymmetricAxolotlParameters {
	protected $ourBaseKey;	// ECKeyPair
	protected $ourRatchetKey;	// ECKeyPair
	protected $ourIdentityKey;	// IdentityKeyPair
	protected $theirBaseKey;	// ECPublicKey
	protected $theirRatchetKey;	// ECPublicKey
	protected $theirIdentityKey;	// IdentityKey
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	public static function constructor__869f1827 ($ourBaseKey, $ourRatchetKey, $ourIdentityKey, $theirBaseKey, $theirRatchetKey, $theirIdentityKey) // [ECKeyPair ourBaseKey, ECKeyPair ourRatchetKey, IdentityKeyPair ourIdentityKey, ECPublicKey theirBaseKey, ECPublicKey theirRatchetKey, IdentityKey theirIdentityKey]
	{
		$me = new self();
		$me->__init();
		$me->ourBaseKey = $ourBaseKey;
		$me->ourRatchetKey = $ourRatchetKey;
		$me->ourIdentityKey = $ourIdentityKey;
		$me->theirBaseKey = $theirBaseKey;
		$me->theirRatchetKey = $theirRatchetKey;
		$me->theirIdentityKey = $theirIdentityKey;
		if ((((((($ourBaseKey == null) || ($ourRatchetKey == null)) || ($ourIdentityKey == null)) || ($theirBaseKey == null)) || ($theirRatchetKey == null)) || ($theirIdentityKey == null)))
		{
			throw new IllegalArgumentException("Null values!");
		}
		return $me;
	}
	public function getOurBaseKey () 
	{
		return $this->ourBaseKey;
	}
	public function getOurRatchetKey () 
	{
		return $this->ourRatchetKey;
	}
	public function getOurIdentityKey () 
	{
		return $this->ourIdentityKey;
	}
	public function getTheirBaseKey () 
	{
		return $this->theirBaseKey;
	}
	public function getTheirRatchetKey () 
	{
		return $this->theirRatchetKey;
	}
	public function getTheirIdentityKey () 
	{
		return $this->theirIdentityKey;
	}
	public static function newBuilder () 
	{
		return new Builder();
	}
}
SymmetricAxolotlParameters::__staticinit(); // initialize static vars for this class on load
?>
