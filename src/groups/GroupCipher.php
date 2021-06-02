<?php
namespace Libsignal\groups;

use Exception;
use Libsignal\exceptions\InvalidKeyException;
use Libsignal\exceptions\InvalidMessageException;
use Libsignal\exceptions\DuplicateMessageException;
use Libsignal\exceptions\NoSessionException;
use Libsignal\groups\state\SenderKeyState;
use Libsignal\groups\state\SenderKeyStore;
use Libsignal\protocol\SenderKeyMessage;
use Libsignal\AESCipher;

class GroupCipher{

    /**
     * @var SenderKeyStore $senderKeyStore
     */
    protected $senderKeyStore;
    /**
     * @var string $senderKeyId
     */
    protected $senderKeyId;

    public function __construct($senderKeyStore, $senderKeyId)
    {
        $this->senderKeyStore = $senderKeyStore;
        $this->senderKeyId = $senderKeyId;
    }

    /**
     * @param $paddedPlaintext
     * @return null
     * @throws InvalidMessageException
     * @throws NoSessionException
     * @throws \Libsignal\exceptions\LegacyMessageException
     */
    public function encrypt($paddedPlaintext)
    {
        try {
            $record = $this->senderKeyStore->loadSenderKey($this->senderKeyId);
            $senderKeyState = $record->getSenderKeyState();
            $senderKey = $senderKeyState->getSenderChainKey()->getSenderMessageKey();
            $ciphertext = $this->getCipherText($senderKey->getIv(), $senderKey->getCipherKey(), $paddedPlaintext);

            $senderKeyMessage = new SenderKeyMessage($senderKeyState->getKeyId(),
                                                                 $senderKey->getIteration(),
                                                                 $ciphertext,
                                                                 $senderKeyState->getSigningKeyPrivate());

            $senderKeyState->setSenderChainKey($senderKeyState->getSenderChainKey()->getNext());
            $this->senderKeyStore->storeSenderKey($this->senderKeyId, $record);

            return $senderKeyMessage->serialize();
        } catch (InvalidKeyIdException $e) {
            throw new NoSessionException($e->getMessage());
        }
    }

    /**
     * @param string $senderKeyMessageBytes
     * @return bool|string
     * @throws DuplicateMessageException
     * @throws InvalidKeyException
     * @throws InvalidMessageException
     * @throws \Libsignal\exceptions\LegacyMessageException
     */
    public function decrypt($senderKeyMessageBytes)
    {
        try {
            $record = $this->senderKeyStore->loadSenderKey($this->senderKeyId);
            $senderKeyMessage = new SenderKeyMessage(null, null, null, null, $senderKeyMessageBytes);

            $senderKeyState = $record->getSenderKeyState($senderKeyMessage->getKeyId());
            $senderKeyMessage->verifySignature($senderKeyState->getSigningKeyPublic());
            $senderKey = $this->getSenderKey($senderKeyState, $senderKeyMessage->getIteration());

            $plaintext = $this->getPlainText($senderKey->getIv(), $senderKey->getCipherKey(), $senderKeyMessage->getCipherText());

            $this->senderKeyStore->storeSenderKey($this->senderKeyId, $record);

            return $plaintext;
        } catch (InvalidKeyException $e) {
            throw new InvalidKeyException($e->getMessage());
        }
    }

    /**
     * @param SenderKeyState $senderKeyState
     * @param $iteration
     * @return mixed
     * @throws DuplicateMessageException
     * @throws InvalidMessageException
     */
    public function getSenderKey($senderKeyState, $iteration){
        $senderChainKey = $senderKeyState->getSenderChainKey();

        if ($senderChainKey->getIteration() > $iteration) {
            if ($senderKeyState->hasSenderMessageKey($iteration)) {
                return $senderKeyState->removeSenderMessageKey($iteration);
            } else {
                throw new DuplicateMessageException('Received message with old counter: '.
                                              $senderChainKey->getIteration().' '.
                                              $iteration);
            }
        }

        if ($senderChainKey->getIteration() - $iteration > 2000) {
            throw new InvalidMessageException('Over 2000 messages into the future!');
        }

        while ($senderChainKey->getIteration() < $iteration) {
            $senderKeyState->addSenderMessageKey($senderChainKey->getSenderMessageKey());
            $senderChainKey = $senderChainKey->getNext();
        }

        $senderKeyState->setSenderChainKey($senderChainKey->getNext());

        return $senderChainKey->getSenderMessageKey();
    }

    /**
     * @param $iv
     * @param $key
     * @param $ciphertext
     * @return bool|string
     * @throws InvalidMessageException
     */
    public function getPlainText($iv, $key, $ciphertext)
    {
        try {
            $cipher = new AESCipher($key, $iv);
            $plaintext = $cipher->decrypt($ciphertext);

            return $plaintext;
        } catch (Exception $e) {
            throw new InvalidMessageException($e->getMessage());
        }
    }

    /**
     * @param $iv
     * @param $key
     * @param $plaintext
     * @return string
     * @throws \Exception
     */
    public function getCipherText($iv, $key, $plaintext)
    {
        $cipher = new AESCipher($key, $iv);

        return $cipher->encrypt($plaintext);
    }
}
