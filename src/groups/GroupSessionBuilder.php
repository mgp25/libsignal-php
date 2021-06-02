<?php
namespace Libsignal\groups;

use Libsignal\ecc\DjbECPublicKey;
use Libsignal\groups\state\SenderKeyStore;
use Libsignal\protocol\SenderKeyDistributionMessage;

class GroupSessionBuilder{

    /**
     * @var SenderKeyStore $senderKeyStore
     */
    protected $senderKeyStore;

    public function __construct(SenderKeyStore $senderKeyStore)
    {
        $this->senderKeyStore = $senderKeyStore;
    }

    /**
     * @param $sender
     * @param SenderKeyDistributionMessage $senderKeyDistributionMessage
     */
    public function processSender($sender, $senderKeyDistributionMessage)
    {
        $senderKeyRecord = $this->senderKeyStore->loadSenderKey($sender);

        $senderKeyRecord->addSenderKeyState($senderKeyDistributionMessage->getId(),
                                            $senderKeyDistributionMessage->getIteration(),
                                            $senderKeyDistributionMessage->getChainKey(),
                                            $senderKeyDistributionMessage->getSignatureKey());
        $this->senderKeyStore->storeSenderKey($sender, $senderKeyRecord);
    }

    /**
     * @param $groupId
     * @param $keyId
     * @param $iteration
     * @param $chainKey
     * @param DjbECPublicKey $signatureKey
     * @return SenderKeyDistributionMessage
     * @throws \Libsignal\exceptions\InvalidMessageException
     * @throws \Libsignal\exceptions\LegacyMessageException
     */
    public function process($groupId, $keyId, $iteration, $chainKey, $signatureKey)
    {
        $senderKeyRecord = $this->senderKeyStore->loadSenderKey($groupId);

        $senderKeyRecord->setSenderKeyState($keyId, $iteration, $chainKey, $signatureKey);

        $this->senderKeyStore->storeSenderKey($groupId, $senderKeyRecord);

        return new SenderKeyDistributionMessage($keyId, $iteration, $chainKey, $signatureKey->getPublicKey());
    }
}
