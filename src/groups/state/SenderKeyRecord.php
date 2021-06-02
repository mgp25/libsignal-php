<?php
namespace Libsignal\groups\state;

use Libsignal\exceptions\InvalidKeyIdException;
use Localstorage\SenderKeyRecordStructure;

class SenderKeyRecord{

    protected $senderKeyStates;

    /**
     * SenderKeyRecord constructor.
     * @param null $serialized
     * @throws \Exception
     */
    public function __construct($serialized = null)
    {
        $this->senderKeyStates = [];

        if ($serialized != null) {
            $senderKeyRecordStructure = new SenderKeyRecordStructure();

            $senderKeyRecordStructure->mergeFromString($serialized);

            foreach ($senderKeyRecordStructure->getSenderKeyStates() as $structure) {
                $this->senderKeyStates[] = new SenderKeyState(null, null, null, null, null, null, $structure);
            }
        }
    }

    /**
     * @param null $keyId
     * @return mixed
     * @throws InvalidKeyIdException
     */
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
        $recordStructure = new SenderKeyRecordStructure();

        $states = [];

        foreach ($this->senderKeyStates as $senderKeyState) {
            $states[] = $senderKeyState->getStructure();
        }
        $recordStructure->setSenderKeyStates($states);

        return $recordStructure->serializeToString();
    }
}
