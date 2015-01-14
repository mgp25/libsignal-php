<?php
require_once("org/whispersystems/libaxolotl/InvalidKeyException.php");
require_once("org/whispersystems/libaxolotl/ecc/Curve.php");
require_once("org/whispersystems/libaxolotl/ecc/ECKeyPair.php");
require_once("org/whispersystems/libaxolotl/ecc/ECPublicKey.php");
require_once("org/whispersystems/libaxolotl/kdf/HKDF.php");
require_once("org/whispersystems/libaxolotl/state/SessionState.php");
require_once("org/whispersystems/libaxolotl/util/ByteUtil.php");
require_once("org/whispersystems/libaxolotl/util/Pair.php");
require_once("org/whispersystems/libaxolotl/util/guava/Optional.php");
require_once("java/io/ByteArrayOutputStream.php");
require_once("java/io/IOException.php");
require_once("java/util/Arrays.php");
class RatchetingSession {
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	public static function initializeSession_c6a7d9a ($sessionState, $sessionVersion, $parameters) // [SessionState sessionState, int sessionVersion, SymmetricAxolotlParameters parameters]
	{
		if (self::isAlice($parameters->getOurBaseKey()->getPublicKey(), $parameters->getTheirBaseKey()))
		{
			$aliceParameters = AliceAxolotlParameters::newBuilder();
			$aliceParameters->setOurBaseKey($parameters->getOurBaseKey())->setOurIdentityKey($parameters->getOurIdentityKey())->setTheirRatchetKey($parameters->getTheirRatchetKey())->setTheirIdentityKey($parameters->getTheirIdentityKey())->setTheirSignedPreKey($parameters->getTheirBaseKey())->setTheirOneTimePreKey(Optional::absent());
			RatchetingSession::initializeSession_c6a7d9a($sessionState, $sessionVersion, $aliceParameters->create());
		}
		else
		{
			$bobParameters = BobAxolotlParameters::newBuilder();
			$bobParameters->setOurIdentityKey($parameters->getOurIdentityKey())->setOurRatchetKey($parameters->getOurRatchetKey())->setOurSignedPreKey($parameters->getOurBaseKey())->setOurOneTimePreKey(Optional::absent())->setTheirBaseKey($parameters->getTheirBaseKey())->setTheirIdentityKey($parameters->getTheirIdentityKey());
			RatchetingSession::initializeSession_c6a7d9a($sessionState, $sessionVersion, $bobParameters->create());
		}
	}
	public static function initializeSession_dbd7df71 ($sessionState, $sessionVersion, $parameters) // [SessionState sessionState, int sessionVersion, AliceAxolotlParameters parameters]
	{
		try 
		{
			$sessionState->setSessionVersion($sessionVersion);
			$sessionState->setRemoteIdentityKey($parameters->getTheirIdentityKey());
			$sessionState->setLocalIdentityKey($parameters->getOurIdentityKey()->getPublicKey());
			$sendingRatchetKey = Curve::generateKeyPair();
			$secrets = new ByteArrayOutputStream();
			if (($sessionVersion >= 3))
			{
				$secrets->write(self::getDiscontinuityBytes());
			}
			$secrets->write(Curve::calculateAgreement($parameters->getTheirSignedPreKey(), $parameters->getOurIdentityKey()->getPrivateKey()));
			$secrets->write(Curve::calculateAgreement($parameters->getTheirIdentityKey()->getPublicKey(), $parameters->getOurBaseKey()->getPrivateKey()));
			$secrets->write(Curve::calculateAgreement($parameters->getTheirSignedPreKey(), $parameters->getOurBaseKey()->getPrivateKey()));
			if ((($sessionVersion >= 3) && $parameters->getTheirOneTimePreKey()->isPresent()))
			{
				$secrets->write(Curve::calculateAgreement($parameters->getTheirOneTimePreKey()->get(), $parameters->getOurBaseKey()->getPrivateKey()));
			}
			$derivedKeys = self::calculateDerivedKeys($sessionVersion, $secrets->toByteArray());
			$sendingChain = $derivedKeys->getRootKey()->createChain($parameters->getTheirRatchetKey(), $sendingRatchetKey);
			$sessionState->addReceiverChain($parameters->getTheirRatchetKey(), $derivedKeys->getChainKey());
			$sessionState->setSenderChain($sendingRatchetKey, $sendingChain->second());
			$sessionState->setRootKey($sendingChain->first());
		}
		catch (IOException $e)
		{
			throw new AssertionError($e);
		}
	}
	public static function initializeSession_411f75dc ($sessionState, $sessionVersion, $parameters) // [SessionState sessionState, int sessionVersion, BobAxolotlParameters parameters]
	{
		try 
		{
			$sessionState->setSessionVersion($sessionVersion);
			$sessionState->setRemoteIdentityKey($parameters->getTheirIdentityKey());
			$sessionState->setLocalIdentityKey($parameters->getOurIdentityKey()->getPublicKey());
			$secrets = new ByteArrayOutputStream();
			if (($sessionVersion >= 3))
			{
				$secrets->write(self::getDiscontinuityBytes());
			}
			$secrets->write(Curve::calculateAgreement($parameters->getTheirIdentityKey()->getPublicKey(), $parameters->getOurSignedPreKey()->getPrivateKey()));
			$secrets->write(Curve::calculateAgreement($parameters->getTheirBaseKey(), $parameters->getOurIdentityKey()->getPrivateKey()));
			$secrets->write(Curve::calculateAgreement($parameters->getTheirBaseKey(), $parameters->getOurSignedPreKey()->getPrivateKey()));
			if ((($sessionVersion >= 3) && $parameters->getOurOneTimePreKey()->isPresent()))
			{
				$secrets->write(Curve::calculateAgreement($parameters->getTheirBaseKey(), $parameters->getOurOneTimePreKey()->get()->getPrivateKey()));
			}
			$derivedKeys = self::calculateDerivedKeys($sessionVersion, $secrets->toByteArray());
			$sessionState->setSenderChain($parameters->getOurRatchetKey(), $derivedKeys->getChainKey());
			$sessionState->setRootKey($derivedKeys->getRootKey());
		}
		catch (IOException $e)
		{
			throw new AssertionError($e);
		}
	}
	protected static function getDiscontinuityBytes () 
	{
		$discontinuity = array();
		$Arrays->fill($discontinuity, 0xFF);
		return $discontinuity;
	}
	protected static function calculateDerivedKeys ($sessionVersion, $masterSecret) // [int sessionVersion, byte[] masterSecret]
	{
		$kdf = $HKDF->createFor($sessionVersion);
		$derivedSecretBytes = $kdf->deriveSecrets($masterSecret, "WhisperText" /* from: "WhisperText".getBytes() */, 64);
			/* match: 21c8b6ca */
		$derivedSecrets = ByteUtil::split_21c8b6ca($derivedSecretBytes, 32, 32);
		return new DerivedKeys(new RootKey($kdf, $derivedSecrets[0]), new ChainKey($kdf, $derivedSecrets[1], 0));
	}
	protected static function isAlice ($ourKey, $theirKey) // [ECPublicKey ourKey, ECPublicKey theirKey]
	{
		return ($ourKey->compareTo($theirKey) < 0);
	}
}
RatchetingSession::__staticinit(); // initialize static vars for this class on load
?>
