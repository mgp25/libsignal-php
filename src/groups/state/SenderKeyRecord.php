<?php
namespace Libsignal\groups\state;

use Localstorage\SenderKeyRecordStructure as TextSecure_SenderKeyRecordStructure;
use Libsignal\exceptions\InvalidKeyIdException;

class SenderKeyRecord
{
    protected $senderKeyStates;

    public function __construct($serialized = null)
    {
        $this->senderKeyStates = [];

        if ($serialized != null) {
            $senderKeyRecordStructure = new TextSecure_SenderKeyRecordStructure();

            $senderKeyRecordStructure->parseFromString($serialized);

            foreach ($senderKeyRecordStructure->getSenderKeyStates() as $structure) {
                $this->senderKeyStates[] = new SenderKeyState(null, null, null, null, null, null, $structure);
            }
        }
    }

    public function getSenderKeyState($keyId = null)
    {
        if (is_null($keyId)) {
            if (count($this->senderKeyStates) > 0) {
                return $this->senderKeyStates[0];
            } else {
                throw new InvalidKeyIdException('No key state in record');
            }
        } else {
            foreach ($this->senderKeyStates as $state) {
                if ($state->getKeyId() == $keyId) {
                    return $state;
                }
            }
            throw new InvalidKeyIdException("No keys for: $keyId");
        }
    }

    public function addSenderKeyState($id, $iteration, $chainKey, $signatureKey)
    {
        $this->senderKeyStates[] = new SenderKeyState($id, $iteration, $chainKey, $signatureKey);
    }

    public function setSenderKeyState($id, $iteration, $chainKey, $signatureKey)
    {
        unset($this->senderKeyStates);
        $this->senderKeyStates = [];
        $this->senderKeyStates[] = new SenderKeyState($id, $iteration, $chainKey, null, null, $signatureKey);
    }

    public function serialize()
    {
        $recordStructure = new TextSecure_SenderKeyRecordStructure();

        foreach ($this->senderKeyStates as $senderKeyState) {
            $recordStructure->appendSenderKeyStates($senderKeyState->getStructure());
        }

        return $recordStructure->serializeToString();
    }
}
