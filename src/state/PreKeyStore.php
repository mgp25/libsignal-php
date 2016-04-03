<?php
namespace Libaxolotl\state;

use Libaxolotl\exceptions\InvalidKeyIdException;

abstract class PreKeyStore
{
    abstract public function loadPreKey($preKeyId);

 // [int preKeyId]

    abstract public function storePreKey($preKeyId, $record);

 // [int preKeyId, PreKeyRecord record]

    abstract public function containsPreKey($preKeyId);

 // [int preKeyId]

    abstract public function removePreKey($preKeyId);

 // [int preKeyId]
}
