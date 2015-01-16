<?php
require_once("ecc/Curve.php");
require_once("ecc/ECKeyPair.php");
require_once("ecc/ECPublicKey.php");
require_once("logging/Log.php");
require_once("protocol/CiphertextMessage.php");
require_once("protocol/KeyExchangeMessage.php");
require_once("protocol/PreKeyWhisperMessage.php");
require_once("ratchet/AliceAxolotlParameters.php");
require_once("ratchet/BobAxolotlParameters.php");
require_once("ratchet/RatchetingSession.php");
require_once("ratchet/SymmetricAxolotlParameters.php");
require_once("state/AxolotlStore.php");
require_once("state/IdentityKeyStore.php");
require_once("state/PreKeyBundle.php");
require_once("state/PreKeyStore.php");
require_once("state/SessionRecord.php");
require_once("state/SessionState.php");
require_once("state/SessionStore.php");
require_once("state/SignedPreKeyStore.php");
require_once("util/KeyHelper.php");
require_once("util/Medium.php");
require_once("util/guava/Optional.php");
class SessionBuilder {
    protected static $TAG;    // String
    protected $sessionStore;    // SessionStore
    protected $preKeyStore;    // PreKeyStore
    protected $signedPreKeyStore;    // SignedPreKeyStore
    protected $identityKeyStore;    // IdentityKeyStore
    protected $recipientId;    // long
    protected $deviceId;    // int
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
        self::$TAG = SessionBuilder::getSimpleName();
    }
    public static function constructor__bc5dd427 ($sessionStore, $preKeyStore, $signedPreKeyStore, $identityKeyStore, $recipientId, $deviceId) // [SessionStore sessionStore, PreKeyStore preKeyStore, SignedPreKeyStore signedPreKeyStore, IdentityKeyStore identityKeyStore, long recipientId, int deviceId]
    {
        $me = new self();
        $me->__init();
        $me->sessionStore = $sessionStore;
        $me->preKeyStore = $preKeyStore;
        $me->signedPreKeyStore = $signedPreKeyStore;
        $me->identityKeyStore = $identityKeyStore;
        $me->recipientId = $recipientId;
        $me->deviceId = $deviceId;
        return $me;
    }
    public static function constructor__d6539a5d ($store, $recipientId, $deviceId) // [AxolotlStore store, long recipientId, int deviceId]
    {
        $me = new self();
        $me->__init();
        /* constructor resolution using types matched overloadcode: bc5dd427*/
        self::constructor__bc5dd427($store, $store, $store, $store, $recipientId, $deviceId);
        return $me;
    }
    protected function process_ffdadcf9 ($sessionRecord, $message) // [SessionRecord sessionRecord, PreKeyWhisperMessage message]
    {
        $messageVersion = $message->getMessageVersion();
        $theirIdentityKey = $message->getIdentityKey();
        $unsignedPreKeyId = null;
        if (!$this->identityKeyStore->isTrustedIdentity($this->recipientId, $theirIdentityKey))
        {
            throw UntrustedIdentityException::constructor__();
        }
        switch ($messageVersion) {
            case 2:
                $unsignedPreKeyId = $this->processV2($sessionRecord, $message);
                break;
            case 3:
                $unsignedPreKeyId = $this->processV3($sessionRecord, $message);
                break;
            default:
                throw new AssertionError(("Unknown version: " . $messageVersion));
        }
        $this->identityKeyStore->saveIdentity($this->recipientId, $theirIdentityKey);
        return $unsignedPreKeyId;
    }
    protected function processV3 ($sessionRecord, $message) // [SessionRecord sessionRecord, PreKeyWhisperMessage message]
    {
        if ($sessionRecord->hasSessionState($message->getMessageVersion(), $message->getBaseKey()->serialize()))
        {
            Log::w_79c13ff(self::$TAG, "We've already setup a session for this V3 message, letting bundled message fall through...");
            return Optional::absent();
        }
        $ourSignedPreKey = $this->signedPreKeyStore->loadSignedPreKey($message->getSignedPreKeyId())->getKeyPair();
        $parameters = BobAxolotlParameters::newBuilder();
        $parameters->setTheirBaseKey($message->getBaseKey())->setTheirIdentityKey($message->getIdentityKey())->setOurIdentityKey($this->identityKeyStore->getIdentityKeyPair())->setOurSignedPreKey($ourSignedPreKey)->setOurRatchetKey($ourSignedPreKey);
        if ($message->getPreKeyId()->isPresent())
        {
            $parameters->setOurOneTimePreKey(Optional::of($this->preKeyStore->loadPreKey($message->getPreKeyId()->get())->getKeyPair()));
        }
        else
        {
            $parameters->setOurOneTimePreKey(Optional::absent());
        }
        if (!$sessionRecord->isFresh())
            $sessionRecord->archiveCurrentState();
        RatchetingSession::initializeSession_c6a7d9a($sessionRecord->getSessionState(), $message->getMessageVersion(), $parameters->create());
        $sessionRecord->getSessionState()->setLocalRegistrationId($this->identityKeyStore->getLocalRegistrationId());
        $sessionRecord->getSessionState()->setRemoteRegistrationId($message->getRegistrationId());
        $sessionRecord->getSessionState()->setAliceBaseKey($message->getBaseKey()->serialize());
        if (($message->getPreKeyId()->isPresent() && ($message->getPreKeyId()->get() != Medium::$MAX_VALUE)))
        {
            return $message->getPreKeyId();
        }
        else
        {
            return Optional::absent();
        }
    }
    protected function processV2 ($sessionRecord, $message) // [SessionRecord sessionRecord, PreKeyWhisperMessage message]
    {
        if (!$message->getPreKeyId()->isPresent())
        {
            throw InvalidKeyIdException::constructor__943a4c31("V2 message requires one time prekey id!");
        }
        if ((!$this->preKeyStore->containsPreKey($message->getPreKeyId()->get()) && $this->sessionStore->containsSession($this->recipientId, $this->deviceId)))
        {
            Log::w_79c13ff(self::$TAG, "We've already processed the prekey part of this V2 session, letting bundled message fall through...");
            return Optional::absent();
        }
        $ourPreKey = $this->preKeyStore->loadPreKey($message->getPreKeyId()->get())->getKeyPair();
        $parameters = BobAxolotlParameters::newBuilder();
        $parameters->setOurIdentityKey($this->identityKeyStore->getIdentityKeyPair())->setOurSignedPreKey($ourPreKey)->setOurRatchetKey($ourPreKey)->setOurOneTimePreKey(Optional::absent())->setTheirIdentityKey($message->getIdentityKey())->setTheirBaseKey($message->getBaseKey());
        if (!$sessionRecord->isFresh())
            $sessionRecord->archiveCurrentState();
        RatchetingSession::initializeSession_c6a7d9a($sessionRecord->getSessionState(), $message->getMessageVersion(), $parameters->create());
        $sessionRecord->getSessionState()->setLocalRegistrationId($this->identityKeyStore->getLocalRegistrationId());
        $sessionRecord->getSessionState()->setRemoteRegistrationId($message->getRegistrationId());
        $sessionRecord->getSessionState()->setAliceBaseKey($message->getBaseKey()->serialize());
        if (($message->getPreKeyId()->get() != Medium::$MAX_VALUE))
        {
            return $message->getPreKeyId();
        }
        else
        {
            return Optional::absent();
        }
    }
    public function process_fa4e407e ($preKey) // [PreKeyBundle preKey]
    {
        /* !!! synchronized block not supported !!!: ($SessionCipher->SESSION_LOCK) */
        {
            if (!$this->identityKeyStore->isTrustedIdentity($this->recipientId, $preKey->getIdentityKey()))
            {
                throw UntrustedIdentityException::constructor__();
            }
            if ((($preKey->getSignedPreKey() != null) && !Curve::verifySignature($preKey->getIdentityKey()->getPublicKey(), $preKey->getSignedPreKey()->serialize(), $preKey->getSignedPreKeySignature())))
            {
                throw InvalidKeyException::constructor__943a4c31("Invalid signature on device key!");
            }
            if ((($preKey->getSignedPreKey() == null) && ($preKey->getPreKey() == null)))
            {
                throw InvalidKeyException::constructor__943a4c31("Both signed and unsigned prekeys are absent!");
            }
            $supportsV3 = ($preKey->getSignedPreKey() != null);
            $sessionRecord = $this->sessionStore->loadSession($this->recipientId, $this->deviceId);
            $ourBaseKey = Curve::generateKeyPair();
            $theirSignedPreKey = ( ($supportsV3) ? $preKey->getSignedPreKey() : $preKey->getPreKey() );
            $theirOneTimePreKey = Optional::fromNullable($preKey->getPreKey());
            $theirOneTimePreKeyId = ( ($theirOneTimePreKey->isPresent()) ? Optional::of($preKey->getPreKeyId()) : Optional::absent() );
            $parameters = AliceAxolotlParameters::newBuilder();
            $parameters->setOurBaseKey($ourBaseKey)->setOurIdentityKey($this->identityKeyStore->getIdentityKeyPair())->setTheirIdentityKey($preKey->getIdentityKey())->setTheirSignedPreKey($theirSignedPreKey)->setTheirRatchetKey($theirSignedPreKey)->setTheirOneTimePreKey(( ($supportsV3) ? $theirOneTimePreKey : Optional::absent() ));
            if (!$sessionRecord->isFresh())
                $sessionRecord->archiveCurrentState();
            RatchetingSession::initializeSession_c6a7d9a($sessionRecord->getSessionState(), ( ($supportsV3) ? 3 : 2 ), $parameters->create());
            $sessionRecord->getSessionState()->setUnacknowledgedPreKeyMessage($theirOneTimePreKeyId, $preKey->getSignedPreKeyId(), $ourBaseKey->getPublicKey());
            $sessionRecord->getSessionState()->setLocalRegistrationId($this->identityKeyStore->getLocalRegistrationId());
            $sessionRecord->getSessionState()->setRemoteRegistrationId($preKey->getRegistrationId());
            $sessionRecord->getSessionState()->setAliceBaseKey($ourBaseKey->getPublicKey()->serialize());
            $this->sessionStore->storeSession($this->recipientId, $this->deviceId, $sessionRecord);
            $this->identityKeyStore->saveIdentity($this->recipientId, $preKey->getIdentityKey());
        }
    }
    public function process_1e5dd825 ($message) // [KeyExchangeMessage message]
    {
        /* !!! synchronized block not supported !!!: ($SessionCipher->SESSION_LOCK) */
        {
            if (!$this->identityKeyStore->isTrustedIdentity($this->recipientId, $message->getIdentityKey()))
            {
                throw UntrustedIdentityException::constructor__();
            }
            $responseMessage = null;
            if ($message->isInitiate())
                $responseMessage = $this->processInitiate($message);
            else
                $this->processResponse($message);
            return $responseMessage;
        }
    }
    protected function processInitiate ($message) // [KeyExchangeMessage message]
    {
        $flags = $KeyExchangeMessage->RESPONSE_FLAG;
        $sessionRecord = $this->sessionStore->loadSession($this->recipientId, $this->deviceId);
        if ((($message->getVersion() >= 3) && !Curve::verifySignature($message->getIdentityKey()->getPublicKey(), $message->getBaseKey()->serialize(), $message->getBaseKeySignature())))
        {
            throw InvalidKeyException::constructor__943a4c31("Bad signature!");
        }
        $builder = SymmetricAxolotlParameters::newBuilder();
        if (!$sessionRecord->getSessionState()->hasPendingKeyExchange())
        {
            $builder->setOurIdentityKey($this->identityKeyStore->getIdentityKeyPair())->setOurBaseKey(Curve::generateKeyPair())->setOurRatchetKey(Curve::generateKeyPair());
        }
        else
        {
            $builder->setOurIdentityKey($sessionRecord->getSessionState()->getPendingKeyExchangeIdentityKey())->setOurBaseKey($sessionRecord->getSessionState()->getPendingKeyExchangeBaseKey())->setOurRatchetKey($sessionRecord->getSessionState()->getPendingKeyExchangeRatchetKey());
            $flags |= $KeyExchangeMessage->SIMULTAENOUS_INITIATE_FLAG;
        }
        $builder->setTheirBaseKey($message->getBaseKey())->setTheirRatchetKey($message->getRatchetKey())->setTheirIdentityKey($message->getIdentityKey());
        $parameters = $builder->create();
        if (!$sessionRecord->isFresh())
            $sessionRecord->archiveCurrentState();
        RatchetingSession::initializeSession_c6a7d9a($sessionRecord->getSessionState(), $Math->min($message->getMaxVersion(), CiphertextMessage::$CURRENT_VERSION), $parameters);
        $this->sessionStore->storeSession($this->recipientId, $this->deviceId, $sessionRecord);
        $this->identityKeyStore->saveIdentity($this->recipientId, $message->getIdentityKey());
        $baseKeySignature = Curve::calculateSignature($parameters->getOurIdentityKey()->getPrivateKey(), $parameters->getOurBaseKey()->getPublicKey()->serialize());
        return new KeyExchangeMessage($sessionRecord->getSessionState()->getSessionVersion(), $message->getSequence(), $flags, $parameters->getOurBaseKey()->getPublicKey(), $baseKeySignature, $parameters->getOurRatchetKey()->getPublicKey(), $parameters->getOurIdentityKey()->getPublicKey());
    }
    protected function processResponse ($message) // [KeyExchangeMessage message]
    {
        $sessionRecord = $this->sessionStore->loadSession($this->recipientId, $this->deviceId);
        $sessionState = $sessionRecord->getSessionState();
        $hasPendingKeyExchange = $sessionState->hasPendingKeyExchange();
        $isSimultaneousInitiateResponse = $message->isResponseForSimultaneousInitiate();
        if ((!$hasPendingKeyExchange || ($sessionState->getPendingKeyExchangeSequence() != $message->getSequence())))
        {
            Log::w_79c13ff(self::$TAG, ("No matching sequence for response. Is simultaneous initiate response: " . $isSimultaneousInitiateResponse));
            if (!$isSimultaneousInitiateResponse)
                throw StaleKeyExchangeException::constructor__();
            else
                return ;
        }
        $parameters = SymmetricAxolotlParameters::newBuilder();
        $parameters->setOurBaseKey($sessionRecord->getSessionState()->getPendingKeyExchangeBaseKey())->setOurRatchetKey($sessionRecord->getSessionState()->getPendingKeyExchangeRatchetKey())->setOurIdentityKey($sessionRecord->getSessionState()->getPendingKeyExchangeIdentityKey())->setTheirBaseKey($message->getBaseKey())->setTheirRatchetKey($message->getRatchetKey())->setTheirIdentityKey($message->getIdentityKey());
        if (!$sessionRecord->isFresh())
            $sessionRecord->archiveCurrentState();
        RatchetingSession::initializeSession_c6a7d9a($sessionRecord->getSessionState(), $Math->min($message->getMaxVersion(), CiphertextMessage::$CURRENT_VERSION), $parameters->create());
        if ((($sessionRecord->getSessionState()->getSessionVersion() >= 3) && !Curve::verifySignature($message->getIdentityKey()->getPublicKey(), $message->getBaseKey()->serialize(), $message->getBaseKeySignature())))
        {
            throw InvalidKeyException::constructor__943a4c31("Base key signature doesn't match!");
        }
        $this->sessionStore->storeSession($this->recipientId, $this->deviceId, $sessionRecord);
        $this->identityKeyStore->saveIdentity($this->recipientId, $message->getIdentityKey());
    }
    public function process ()
    {
        /* !!! synchronized block not supported !!!: ($SessionCipher->SESSION_LOCK) */
        {
            try
            {
                $sequence = ($KeyHelper->getRandomSequence(65534) + 1);
                $flags = $KeyExchangeMessage->INITIATE_FLAG;
                $baseKey = Curve::generateKeyPair();
                $ratchetKey = Curve::generateKeyPair();
                $identityKey = $this->identityKeyStore->getIdentityKeyPair();
                $baseKeySignature = Curve::calculateSignature($identityKey->getPrivateKey(), $baseKey->getPublicKey()->serialize());
                $sessionRecord = $this->sessionStore->loadSession($this->recipientId, $this->deviceId);
                $sessionRecord->getSessionState()->setPendingKeyExchange($sequence, $baseKey, $ratchetKey, $identityKey);
                $this->sessionStore->storeSession($this->recipientId, $this->deviceId, $sessionRecord);
                return new KeyExchangeMessage(2, $sequence, $flags, $baseKey->getPublicKey(), $baseKeySignature, $ratchetKey->getPublicKey(), $identityKey->getPublicKey());
            }
            catch (InvalidKeyException $e)
            {
                throw new AssertionError($e);
            }
        }
    }
}
SessionBuilder::__staticinit(); // initialize static vars for this class on load
