<?php
require_once("ecc/ECKeyPair.php");
require_once("groups/state/SenderKeyRecord.php");
require_once("groups/state/SenderKeyStore.php");
require_once("protocol/SenderKeyDistributionMessage.php");
class GroupSessionBuilder {
    protected $senderKeyStore;    // SenderKeyStore
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__54c7d337 ($senderKeyStore) // [SenderKeyStore senderKeyStore]
    {
        $me = new self();
        $me->__init();
        $me->senderKeyStore = $senderKeyStore;
        return $me;
    }
    public function processSender ($sender, $senderKeyDistributionMessage) // [String sender, SenderKeyDistributionMessage senderKeyDistributionMessage]
    {
        /* !!! synchronized block not supported !!!: ($GroupCipher->LOCK) */
        {
            $senderKeyRecord = $this->senderKeyStore->loadSenderKey($sender);
            $senderKeyRecord->addSenderKeyState($senderKeyDistributionMessage->getId(), $senderKeyDistributionMessage->getIteration(), $senderKeyDistributionMessage->getChainKey(), $senderKeyDistributionMessage->getSignatureKey());
            $this->senderKeyStore->storeSenderKey($sender, $senderKeyRecord);
        }
    }
    public function process ($groupId, $keyId, $iteration, $chainKey, $signatureKey) // [String groupId, int keyId, int iteration, byte[] chainKey, ECKeyPair signatureKey]
    {
        /* !!! synchronized block not supported !!!: ($GroupCipher->LOCK) */
        {
            $senderKeyRecord = $this->senderKeyStore->loadSenderKey($groupId);
            $senderKeyRecord->setSenderKeyState($keyId, $iteration, $chainKey, $signatureKey);
            $this->senderKeyStore->storeSenderKey($groupId, $senderKeyRecord);
            return SenderKeyDistributionMessage::constructor__d8d86e83($keyId, $iteration, $chainKey, $signatureKey->getPublicKey());
        }
    }
}
GroupSessionBuilder::__staticinit(); // initialize static vars for this class on load
