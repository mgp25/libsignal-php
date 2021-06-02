<?php
namespace Libsignal\ratchet;

use Libsignal\ecc\Curve;
use Libsignal\util\ByteUtil;
use Libsignal\kdf\HKDF;
use Libsignal\exceptions\InvalidKeyException;
use Libsignal\state\SessionState;

class RatchetingSession{

    /**
     * @param SessionState $sessionState
     * @param $sessionVersion
     * @param SymmetricAxolotlParameters $parameters
     * @throws \Exception
     */
    public static function initializeSession(SessionState $sessionState, $sessionVersion, $parameters)
    {
        /*
        :type sessionState: SessionState
        :type sessionVersion: int
        :type parameters: SymmetricAxolotlParameters
        */

        if (self::isAlice($parameters->getOurBaseKey()->getPublicKey(), $parameters->getTheirBaseKey())) {
            $aliceParameters = AliceAxolotlParameters::newBuilder();
            $aliceParameters->setOurBaseKey($parameters->getOurBaseKey())
                     ->setOurIdentityKey($parameters->getOurIdentityKey())
                     ->setTheirRatchetKey($parameters->getTheirRatchetKey())
                     ->setTheirIdentityKey($parameters->getTheirIdentityKey())
                     ->setTheirSignedPreKey($parameters->getTheirBaseKey())
                     ->setTheirOneTimePreKey(null);
            self::initializeSessionAsAlice($sessionState, $sessionVersion, $aliceParameters->create());
        } else {
            $bobParameters = BobAxolotlParameters::newBuilder();
            $bobParameters->setOurIdentityKey($parameters->getOurIdentityKey())
                   ->setOurRatchetKey($parameters->getOurRatchetKey())
                   ->setOurSignedPreKey($parameters->getOurBaseKey())
                   ->setOurOneTimePreKey(null)
                   ->setTheirBaseKey($parameters->getTheirBaseKey())
                   ->setTheirIdentityKey($parameters->getTheirIdentityKey());
            self::initializeSessionAsBob($sessionState, $sessionVersion, $bobParameters->create());
        }
    }

    /**
     * @param SessionState $sessionState
     * @param $sessionVersion
     * @param AliceAxolotlParameters $parameters
     * @throws InvalidKeyException
     * @throws \Exception
     */
    public static function initializeSessionAsAlice($sessionState, $sessionVersion, $parameters)
    {
        /*
        :type sessionState: SessionState
        :type sessionVersion: int
        :type parameters: AliceAxolotlParameters
        */
        $sessionState->setSessionVersion($sessionVersion);
        $sessionState->setRemoteIdentityKey($parameters->getTheirIdentityKey());
        $sessionState->setLocalIdentityKey($parameters->getOurIdentityKey()->getPublicKey());

        $sendingRatchetKey = Curve::generateKeyPair();
        $secrets = '';

        if ($sessionVersion >= 3) {
            $secrets .= self::getDiscontinuityBytes();
        }

        $secrets .= Curve::calculateAgreement($parameters->getTheirSignedPreKey(),
                                             $parameters->getOurIdentityKey()->getPrivateKey());
        $secrets .= Curve::calculateAgreement($parameters->getTheirIdentityKey()->getPublicKey(),
                                             $parameters->getOurBaseKey()->getPrivateKey());
        $secrets .= Curve::calculateAgreement($parameters->getTheirSignedPreKey(),
                                             $parameters->getOurBaseKey()->getPrivateKey());

        if ($sessionVersion >= 3 && $parameters->getTheirOneTimePreKey() != null) {
            $secrets .= Curve::calculateAgreement($parameters->getTheirOneTimePreKey(), $parameters->getOurBaseKey()->getPrivateKey());
        }

        $derivedKeys = self::calculateDerivedKeys($sessionVersion, $secrets);
        $sendingChain = $derivedKeys->getRootKey()->createChain($parameters->getTheirRatchetKey(), $sendingRatchetKey);

        $sessionState->addReceiverChain($parameters->getTheirRatchetKey(), $derivedKeys->getChainKey());
        $sessionState->setSenderChain($sendingRatchetKey, $sendingChain[1]);
        $sessionState->setRootKey($sendingChain[0]);
    }

    /**
     * @param SessionState $sessionState
     * @param $sessionVersion
     * @param BobAxolotlParameters $parameters
     * @throws InvalidKeyException
     */
    public static function initializeSessionAsBob($sessionState, $sessionVersion, $parameters)
    {
        /*
        :type sessionState: SessionState
        :type sessionVersion: int
        :type parameters: BobAxolotlParameters
        */

        $sessionState->setSessionVersion($sessionVersion);
        $sessionState->setRemoteIdentityKey($parameters->getTheirIdentityKey());
        $sessionState->setLocalIdentityKey($parameters->getOurIdentityKey()->getPublicKey());

        $secrets = '';

        if ($sessionVersion >= 3) {
            $secrets .= self::getDiscontinuityBytes();
        }

        $secrets .= Curve::calculateAgreement($parameters->getTheirIdentityKey()->getPublicKey(),
                                                $parameters->getOurSignedPreKey()->getPrivateKey());
        $secrets .= Curve::calculateAgreement($parameters->getTheirBaseKey(),
                                                $parameters->getOurIdentityKey()->getPrivateKey());

        $secrets .= Curve::calculateAgreement($parameters->getTheirBaseKey(),
                                               $parameters->getOurSignedPreKey()->getPrivateKey());

        if ($sessionVersion >= 3 && $parameters->getOurOneTimePreKey() != null) {
            $secrets .= Curve::calculateAgreement($parameters->getTheirBaseKey(),
                                                   $parameters->getOurOneTimePreKey()->getPrivateKey());
        }

        $derivedKeys = self::calculateDerivedKeys($sessionVersion, $secrets);
        $sessionState->setSenderChain($parameters->getOurRatchetKey(), $derivedKeys->getChainKey());
        $sessionState->setRootKey($derivedKeys->getRootKey());
    }

    public static function getDiscontinuityBytes()
    {
        return str_repeat("\xFF", 32);
    }

    public static function calculateDerivedKeys($sessionVersion, $masterSecret)
    {
        $kdf = HKDF::createFor($sessionVersion);
        $derivedSecretBytes = $kdf->deriveSecrets($masterSecret, 'WhisperText', 64);
        $derivedSecrets = ByteUtil::split($derivedSecretBytes, 32, 32);

        return new DerivedKeys(new RootKey($kdf, $derivedSecrets[0]),
                                             new ChainKey($kdf, $derivedSecrets[1], 0));
    }

    public static function isAlice($ourKey, $theirKey)
    {
        /*
        :type ourKey: ECPublicKey
        :type theirKey: ECPublicKey
        */
        return $ourKey->compareTo($theirKey)  == -1;
    }
}

class DerivedKeys
{
    protected $rootKey;
    protected $chainKey;

    public function __construct($rootKey, $chainKey)
    {
        /*
        :type rootKey: RootKey
        :type  chainKey: ChainKey
        */
        $this->rootKey = $rootKey;
        $this->chainKey = $chainKey;
    }

    public function getRootKey()
    {
        return $this->rootKey;
    }

    public function getChainKey()
    {
        return $this->chainKey;
    }
}
