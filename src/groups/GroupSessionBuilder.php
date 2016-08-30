<?php

require_once __DIR__.'/../ecc/ECKeyPair.php';
require_once __DIR__.'/state/SenderKeyRecord.php';
require_once __DIR__.'/state/SenderKeyStore.php';
require_once __DIR__.'/../util/KeyHelper.php';
require_once __DIR__.'/../protocol/SenderKeyDistributionMessage.php';
class GroupSessionBuilder
{
    protected $senderKeyStore;

    public function __construct($senderKeyStore)
    {
        $this->senderKeyStore = $senderKeyStore;
    }

    public function process($groupId, $senderKeyDistributionMessage)
    {
        $senderKeyRecord = $this->senderKeyStore->loadSenderKey($groupId);
        $senderKeyRecord->addSenderKeyState($senderKeyDistributionMessage->getId(),
            $senderKeyDistributionMessage->getIteration(),
            $senderKeyDistributionMessage->getChainKey(),
            $senderKeyDistributionMessage->getSignatureKey());
        $this->senderKeyStore->storeSenderKey($groupId, $senderKeyRecord);
    }

    public function create($senderKeyName)
    {
        try {
            $senderKeyRecord = $this->senderKeyStore->loadSenderKey($senderKeyName);
            if ($senderKeyRecord->isEmpty()) {
                $senderKeyRecord->setSenderKeyState(KeyHelper::generateSenderKeyId(),
                                              0,
                                              KeyHelper::generateSenderKey(),
                                              KeyHelper::generateSenderSigningKey());

                $this->senderKeyStore->storeSenderKey($senderKeyName, $senderKeyRecord);
            }
            $state = $senderKeyRecord->getSenderKeyState();

            return new SenderKeyDistributionMessage($state->getKeyId(),
                                                $state->getSenderChainKey()->getIteration(),
                                                $state->getSenderChainKey()->getSeed(),
                                                $state->getSigningKeyPublic());
        } catch (Exception $e) {
            if (($e instanceof InvalidKeyIdException) || ($e instanceof InvalidKeyException)) {
                throw new Exception($e);
            }
        }
    }
}
