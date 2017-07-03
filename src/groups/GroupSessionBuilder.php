<?php
namespace Libsignal\groups;

use Libsignal\groups\state\SenderKeyStore;
use Libsignal\protocol\SenderKeyDistributionMessage;

require_once __DIR__.'/../ecc/ECKeyPair.php';
require_once __DIR__.'/state/SenderKeyRecord.php';
//require_once __DIR__.'/../protocol/SenderKeyDistributionMessage.php';

class GroupSessionBuilder
{
    protected $senderKeyStore;

    public function __construct(SenderKeyStore $senderKeyStore)
    {
        $this->senderKeyStore = $senderKeyStore;
    }

    public function processSender($sender, $senderKeyDistributionMessage)
    {
        $senderKeyRecord = $this->senderKeyStore->loadSenderKey($sender);

        $senderKeyRecord->addSenderKeyState($senderKeyDistributionMessage->getId(),
                                            $senderKeyDistributionMessage->getIteration(),
                                            $senderKeyDistributionMessage->getChainKey(),
                                            $senderKeyDistributionMessage->getSignatureKey());
        $this->senderKeyStore->storeSenderKey($sender, $senderKeyRecord);
    }

    public function process($groupId, $keyId, $iteration, $chainKey, $signatureKey)
    {
        $senderKeyRecord = $this->senderKeyStore->loadSenderKey($groupId);

        $senderKeyRecord->setSenderKeyState($keyId, $iteration, $chainKey, $signatureKey);

        $this->senderKeyStore->storeSenderKey($groupId, $senderKeyRecord);

        return new SenderKeyDistributionMessage($keyId, $iteration, $chainKey, $signatureKey->getPublicKey());
    }
}
