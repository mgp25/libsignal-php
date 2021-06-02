<?php
namespace Libsignal\protocol;

use Exception;
use Libsignal\ecc\Curve;
use Libsignal\ecc\ECPublicKey;
use Libsignal\util\ByteUtil;
use Libsignal\exceptions\InvalidMessageException;
use Libsignal\exceptions\InvalidVersionException;
use Libsignal\exceptions\LegacyMessageException;
use Libsignal\IdentityKey;

class PreKeyWhisperMessage extends CiphertextMessage
{
    protected $version;
    protected $registrationId;
    protected $preKeyId;
    protected $signedPreKeyId;
    protected $baseKey;
    protected $identityKey;
    protected $message;
    protected $serialized;

    /**
     * PreKeyWhisperMessage constructor.
     * @param string $messageVersion
     * @param string $registrationId
     * @param string $preKeyId
     * @param string $signedPreKeyId
     * @param ECPublicKey $ecPublicBaseKey
     * @param IdentityKey $identityKey
     * @param WhisperMessage $whisperMessage
     * @param string $serialized
     * @throws InvalidMessageException
     * @throws InvalidVersionException
     * @throws LegacyMessageException
     * @throws Exception
     */
    public function __construct($messageVersion = null,
                                         $registrationId = null,
                                         $preKeyId = null,
                                         $signedPreKeyId = null,
                                         $ecPublicBaseKey = null,
                                         $identityKey = null,
                                         $whisperMessage = null,
                                         $serialized = null)
    {
        if ($serialized != null) {
            $this->version = ByteUtil::highBitsToInt($serialized[0]);
            if ($this->version  > self::CURRENT_VERSION) {
                throw new InvalidVersionException('Unknown version '.$this->version);
            }
            $preKeyWhisperMessage = new \Whispertext\PreKeyWhisperMessage();

            $preKeyWhisperMessage->mergeFromString(substr($serialized, 1));
            if (($this->version == 2 && $preKeyWhisperMessage->getPreKeyId() == null) ||
                ($this->version == 3 && $preKeyWhisperMessage->getSignedPreKeyId() == null) ||
                $preKeyWhisperMessage->getBaseKey() == null ||
                $preKeyWhisperMessage->getIdentityKey() == null ||
                $preKeyWhisperMessage->getMessage() == null) {
                throw new InvalidMessageException('Incomplete message');
            }

            $this->serialized = $serialized;
            $this->registrationId = $preKeyWhisperMessage->getRegistrationId();
            $this->preKeyId = $preKeyWhisperMessage->getPreKeyId();
            $this->signedPreKeyId = $preKeyWhisperMessage->getSignedPreKeyId();
            $this->baseKey = Curve::decodePoint((string) $preKeyWhisperMessage->getBaseKey(), 0);
            $this->identityKey = new IdentityKey(Curve::decodePoint((string) $preKeyWhisperMessage->getIdentityKey(), 0));
            $this->message = new WhisperMessage(null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    $preKeyWhisperMessage->getMessage());
        } else {
            try {
                $this->version = $messageVersion;
                $this->registrationId = $registrationId;
                $this->preKeyId = $preKeyId;
                $this->signedPreKeyId = $signedPreKeyId;
                $this->baseKey = $ecPublicBaseKey;
                $this->identityKey = $identityKey;
                $this->message = $whisperMessage;

                $builder = new \Whispertext\PreKeyWhisperMessage();
                $builder->setSignedPreKeyId($this->signedPreKeyId);
                $builder->setBaseKey($this->baseKey->serialize());
                $builder->setIdentityKey($this->identityKey->serialize());
                $builder->setMessage($whisperMessage->serialize());
                $builder->setRegistrationId($this->registrationId);
                if ($preKeyId != null) {
                    $builder->setPreKeyId($preKeyId);
                }
                $versionBytes = ByteUtil::intsToByteHighAndLow($this->version, self::CURRENT_VERSION);
                $messageBytes = $builder->serializeToString();
                $this->serialized = ByteUtil::combine([chr($versionBytes), $messageBytes]);
            } catch (Exception $ex) {
                throw new InvalidMessageException($ex->getMessage().' - '.$ex->getLine().' - '.$ex->getFile());
            }
        }
    }

    public function getMessageVersion()
    {
        return $this->version;
    }

    public function getIdentityKey()
    {
        return $this->identityKey;
    }

    public function getRegistrationId()
    {
        return $this->registrationId;
    }

    public function getPreKeyId()
    {
        return $this->preKeyId;
    }

    /**
     * @return null|string
     */
    public function getSignedPreKeyId()
    {
        return $this->signedPreKeyId;
    }

    public function getBaseKey()
    {
        return $this->baseKey;
    }

    public function getWhisperMessage()
    {
        return $this->message;
    }

    public function serialize()
    {
        return $this->serialized;
    }

    public function getType()
    {
        return self::PREKEY_TYPE;
    }
}
