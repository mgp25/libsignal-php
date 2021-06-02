<?php
namespace Libsignal;

use Exception;
use Libsignal\ecc\Curve;
use Libsignal\exceptions\DuplicateMessageException;
use Libsignal\exceptions\InvalidMessageException;
use Libsignal\exceptions\NoSessionException;
use Libsignal\protocol\PreKeyWhisperMessage;
use Libsignal\protocol\WhisperMessage;
use Libsignal\ratchet\ChainKey;
use Libsignal\ratchet\MessageKeys;
use Libsignal\state\PreKeyStore;
use Libsignal\state\SessionRecord;
use Libsignal\state\SessionState;
use Libsignal\state\SessionStore;

class SessionCipher{

    /**
     * @var SessionStore $sessionStore
     */
    protected $sessionStore;
    /**
     * @var PreKeyStore $preKeyStore
     */
    protected $preKeyStore;
    /**
     * @var string $recipientId
     */
    protected $recipientId;
    /**
     * @var string $deviceId
     */
    protected $deviceId;
    /**
     * @var SessionBuilder $sessionBuilder
     */
    protected $sessionBuilder;

    public function __construct($sessionStore, $preKeyStore, $signedPreKeyStore, $identityKeyStore, $recepientId, $deviceId)
    {
        $this->sessionStore = $sessionStore;
        $this->preKeyStore = $preKeyStore;
        $this->recipientId = $recepientId;
        $this->deviceId = $deviceId;
        $this->sessionBuilder = new SessionBuilder($sessionStore, $preKeyStore, $signedPreKeyStore,
                                             $identityKeyStore, $recepientId, $deviceId);
    }

    /**
     * @param string $paddedMessage
     * @return PreKeyWhisperMessage|WhisperMessage
     * @throws exceptions\InvalidMessageException
     * @throws exceptions\InvalidVersionException
     * @throws exceptions\LegacyMessageException
     * @throws Exception
     */
    public function encrypt($paddedMessage){
        $sessionRecord = $this->sessionStore->loadSession($this->recipientId, $this->deviceId);
        $sessionState = $sessionRecord->getSessionState();

        $chainKey = $sessionState->getSenderChainKey();
        $messageKeys = $chainKey->getMessageKeys();

        $senderEphemeral = $sessionState->getSenderRatchetKey();
        $previousCounter = $sessionState->getPreviousCounter();
        $sessionVersion = $sessionState->getSessionVersion();

        $ciphertextBody = $this->getCiphertext($sessionVersion, $messageKeys, $paddedMessage);
        $ciphertextMessage = new WhisperMessage($sessionVersion, $messageKeys->getMacKey(),
                                                               $senderEphemeral, $chainKey->getIndex(),
                                                               $previousCounter, $ciphertextBody,
                                                               $sessionState->getLocalIdentityKey(),
                                                               $sessionState->getRemoteIdentityKey());

        if ($sessionState->hasUnacknowledgedPreKeyMessage()) {
            $items = $sessionState->getUnacknowledgedPreKeyMessageItems();
            $localRegistrationid = $sessionState->getLocalRegistrationId();

            $ciphertextMessage = new PreKeyWhisperMessage($sessionVersion, $localRegistrationid, $items->getPreKeyId(),
                                                     $items->getSignedPreKeyId(), $items->getBaseKey(),
                                                     $sessionState->getLocalIdentityKey(),
                                                     $ciphertextMessage);
        }
        $sessionState->setSenderChainKey($chainKey->getNextChainKey());
        $this->sessionStore->storeSession($this->recipientId, $this->deviceId, $sessionRecord);

        return $ciphertextMessage;
    }

    /**
     * @param $ciphertext
     * @return bool|string
     * @throws DuplicateMessageException
     * @throws InvalidMessageException
     * @throws NoSessionException
     */
    public function decryptMsg($ciphertext)
    {
        /*
        :type ciphertext: WhisperMessage
        */
        if (!$this->sessionStore->containsSession($this->recipientId, $this->deviceId)) {
            throw new NoSessionException('No session for: '.$this->recipientId.', '.$this->deviceId);
        }

        $sessionRecord = $this->sessionStore->loadSession($this->recipientId, $this->deviceId);
        $plaintext = $this->decryptWithSessionRecord($sessionRecord, $ciphertext);

        $this->sessionStore->storeSession($this->recipientId, $this->deviceId, $sessionRecord);

        /*if sys.version_info >= (3,0):
            return plaintext.decode()*/
        return $plaintext;
    }

    /**
     * @param PreKeyWhisperMessage $ciphertext
     * @return bool|string
     * @throws DuplicateMessageException
     * @throws InvalidMessageException
     * @throws exceptions\UntrustedIdentityException
     */
    public function decryptPkmsg($ciphertext)
    {
        /*
        :type ciphertext: PreKeyWhisperMessage
        */
        $sessionRecord = $this->sessionStore->loadSession($this->recipientId, $this->deviceId);
        $unsignedPreKeyId = $this->sessionBuilder->process($sessionRecord, $ciphertext);

        $plaintext = $this->decryptWithSessionRecord($sessionRecord, $ciphertext->getWhisperMessage());

        //callback.handlePlaintext(plaintext);
        $this->sessionStore->storeSession($this->recipientId, $this->deviceId, $sessionRecord);

        if ($unsignedPreKeyId != null) {
            $this->preKeyStore->removePreKey($unsignedPreKeyId);
        }
        /*
        if sys.version_info >= (3, 0):
            return plaintext.decode()
        */
        return $plaintext;
    }

    /**
     * @param SessionRecord $sessionRecord
     * @param $cipherText
     * @return bool|string
     * @throws InvalidMessageException
     * @throws DuplicateMessageException
     */
    public function decryptWithSessionRecord($sessionRecord, $cipherText)
    {
        /*
        :type sessionRecord: SessionRecord
        :type cipherText: WhisperMessage
        */

        $previousStates = $sessionRecord->getPreviousSessionStates();
        $exceptions = [];
        try {
            $sessionState = new SessionState($sessionRecord->getSessionState());
            $plaintext = $this->decryptWithSessionState($sessionState, $cipherText);
            $sessionRecord->setState($sessionState);

            return $plaintext;
        } catch (InvalidMessageException $e) {
            echo $e->getMessage()."\n";
            $exceptions[] = $e;
        }

        for ($i = 0; $i < count($previousStates); $i++) {
            $previousState = $previousStates[$i];
            try {
                $promotedState = new SessionState($previousState);
                $plaintext = $this->decryptWithSessionState($promotedState, $cipherText);
                $sessionRecord->removePreviousSessionStateAt($i); // del $previousStates[$i]
              $sessionRecord->promoteState($promotedState);

                return $plaintext;
            } catch (InvalidMessageException $e) {
                echo $e->getMessage()."\n";
                $exceptions[] = $e;
            }
        }

        throw new InvalidMessageException('No valid sessions', $exceptions);
    }

    /**
     * @param SessionState $sessionState
     * @param WhisperMessage $ciphertextMessage
     * @return bool|string
     * @throws InvalidMessageException
     * @throws DuplicateMessageException
     * @throws Exception
     */
    public function decryptWithSessionState($sessionState, $ciphertextMessage)
    {
        if (!$sessionState->hasSenderChain()) {
            throw new InvalidMessageException('Uninitialized session!');
        }

        if ($ciphertextMessage->getMessageVersion() != $sessionState->getSessionVersion()) {
            throw new InvalidMessageException('Message version '.$ciphertextMessage->getMessageVersion().', but session version '.$sessionState->getSessionVersion());
        }

        $messageVersion = $ciphertextMessage->getMessageVersion();
        $theirEphemeral = $ciphertextMessage->getSenderRatchetKey();
        $counter = $ciphertextMessage->getCounter();
        $chainKey = $this->getOrCreateChainKey($sessionState, $theirEphemeral);
        $messageKeys = $this->getOrCreateMessageKeys($sessionState, $theirEphemeral,
                                                              $chainKey, $counter);

        $ciphertextMessage->verifyMac($messageVersion,
                                    $sessionState->getRemoteIdentityKey(),
                                    $sessionState->getLocalIdentityKey(),
                                    $messageKeys->getMacKey());

        $plaintext = $this->getPlaintext($messageVersion, $messageKeys, $ciphertextMessage->getBody());
        $sessionState->clearUnacknowledgedPreKeyMessage();

        return $plaintext;
    }

    /**
     * @param SessionState $sessionState
     * @param $ECPublicKey_theirEphemeral
     * @return mixed
     * @throws \Exception
     */
    public function getOrCreateChainKey($sessionState, $ECPublicKey_theirEphemeral)
    {
        $theirEphemeral = $ECPublicKey_theirEphemeral;
        if ($sessionState->hasReceiverChain($theirEphemeral)) {
            return $sessionState->getReceiverChainKey($theirEphemeral);
        } else {
            $rootKey = $sessionState->getRootKey();

            $ourEphemeral = $sessionState->getSenderRatchetKeyPair();
            $receiverChain = $rootKey->createChain($theirEphemeral, $ourEphemeral);
            $ourNewEphemeral = Curve::generateKeyPair();
            $senderChain = $receiverChain[0]->createChain($theirEphemeral, $ourNewEphemeral);

            $sessionState->setRootKey($senderChain[0]);
            $sessionState->addReceiverChain($theirEphemeral, $receiverChain[1]);
            $sessionState->setPreviousCounter(max($sessionState->getSenderChainKey()->getIndex() - 1, 0));
            $sessionState->setSenderChain($ourNewEphemeral, $senderChain[1]);

            return $receiverChain[1];
        }
    }

    /**
     * @param SessionState $sessionState
     * @param $ECPublicKey_theirEphemeral
     * @param ChainKey $chainKey
     * @param $counter
     * @return mixed
     * @throws InvalidMessageException
     * @throws DuplicateMessageException
     */
    public function getOrCreateMessageKeys($sessionState, $ECPublicKey_theirEphemeral, $chainKey, $counter)
    {
        $theirEphemeral = $ECPublicKey_theirEphemeral;
        if ($chainKey->getIndex() > $counter) {
            if ($sessionState->hasMessageKeys($theirEphemeral, $counter)) {
                return $sessionState->removeMessageKeys($theirEphemeral, $counter);
            } else {
                throw new DuplicateMessageException('Received message '.
                                 'with old counter: '.$chainKey->getIndex().' '.$counter);
            }
        }
        if ($counter - $chainKey->getIndex() > 2000) {
            throw new InvalidMessageException('Over 2000 messages into the future!');
        }

        while ($chainKey->getIndex() < $counter) {
            $messageKeys = $chainKey->getMessageKeys();
            $sessionState->setMessageKeys($theirEphemeral, $messageKeys);
            $chainKey = $chainKey->getNextChainKey();
        }
        $sessionState->setReceiverChainKey($theirEphemeral, $chainKey->getNextChainKey());

        return $chainKey->getMessageKeys();
    }

    /**
     * @param int $version
     * @param MessageKeys $messageKeys
     * @param string $plainText
     * @return string
     * @throws \Exception
     */
    public function getCiphertext($version, $messageKeys, $plainText)
    {
        /*
        :type version: int
        :type messageKeys: MessageKeys
        :type  plainText: bytearray
        */
        $cipher = null;
        if ($version >= 3) {
            $cipher = $this->getCipher($messageKeys->getCipherKey(), $messageKeys->getIv());
        } else {
            $cipher = $this->getCipher_v2($messageKeys->getCipherKey(), $messageKeys->getCounter());
        }

        return $cipher->encrypt($plainText);
    }

    /**
     * @param int $version
     * @param MessageKeys $messageKeys
     * @param string $cipherText
     * @return bool|string
     * @throws \Exception
     */
    public function getPlaintext($version, $messageKeys, $cipherText)
    {
        $cipher = null;
        if ($version >= 3) {
            $cipher = $this->getCipher($messageKeys->getCipherKey(), $messageKeys->getIv());
        } else {
            $cipher = $this->getCipher_v2($messageKeys->getCipherKey(), $messageKeys->getCounter());
        }

        return $cipher->decrypt($cipherText);
    }

    /**
     * @param $key
     * @param $iv
     * @return AESCipher
     * @throws Exception
     */
    public function getCipher($key, $iv)
    {
        //Cipher.getInstance("AES/CBC/PKCS5Padding");
        //cipher = AES.new(key, AES.MODE_CBC, IV = iv)
        //return cipher
        return new AESCipher($key, $iv);
    }

    /**
     * @param $key
     * @param $counter
     * @return AESCipher
     * @throws Exception
     */
    public function getCipher_v2($key, $counter)
    {
        /* #AES/CTR/NoPadding
        #counterbytes = struct.pack('>L', counter) + (b'\x00' * 12)
        #counterint = struct.unpack(">L", counterbytes)[0]
        #counterint = int.from_bytes(counterbytes, byteorder='big')
        ctr=Counter.new(128, initial_value= counter)

        #cipher = AES.new(key, AES.MODE_CTR, counter=ctr)
        ivBytes = bytearray(16)
        ByteUtil.intToByteArray(ivBytes, 0, counter)

        cipher = AES.new(key, AES.MODE_CTR, IV = bytes(ivBytes), counter=ctr)

        return cipher;*/
        return new AESCipher($key, null, 2, new CryptoCounter(128, $counter));
//        throw new Exception('To be implemented.');
    }
}

class CryptoCounter
{
    protected $size;
    protected $val;

    /**
     * CryptoCounter constructor.
     * @param int $size
     * @param int $init_val
     * @throws Exception
     */
    public function __construct($size = 128, $init_val = 0)
    {
        $this->val = $init_val;
        if (!in_array($size, [128, 192, 256])) {
            throw new Exception('Counter size cannot be other than 128,192 or 256 bits');
        }
        $this->size = $size / 8;
    }

    public function Next()
    {
        $b = array_reverse(unpack('C*', pack('L', $this->val)));
        //byte array to string
        $ctr_str = implode(array_map('chr', $b));
        // create 16 byte IV from counter
        $ctrVal = str_repeat("\x0", ($this->size - 4)).$ctr_str;
        $this->val++;

        return $ctrVal;
    }
}
