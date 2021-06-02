<?php
namespace Libsignal\Tests\groups;

use Libsignal\Tests\TestCase;
use Libsignal\groups\GroupSessionBuilder;
use Libsignal\groups\GroupCipher;
use Libsignal\util\KeyHelper;

class GroupCipherTest extends TestCase
{
    public function testBasicEncryptDecrypt()
    {
        $aliceStore = new InMemorySenderKeyStore;
        $bobStore = new InMemorySenderKeyStore;
        $charlieStore = new InMemorySenderKeyStore;

        $aliceSessionBuilder = new GroupSessionBuilder($aliceStore);
        $bobSessionBuilder = new GroupSessionBuilder($bobStore);
        $charlieSessionBuilder = new GroupSessionBuilder($charlieStore);

        $aliceGroupCipher = new GroupCipher($aliceStore, 'groupWithBobInIt');
        $bobGroupCipher = new GroupCipher($bobStore, 'groupWithBobInIt::aliceUserName');
        $charlieGroupCipher = new GroupCipher($charlieStore, 'groupWithBobInIt::aliceUserName');

        $aliceSenderKey = KeyHelper::generateSenderKey();
        $aliceSenderSigningKey = KeyHelper::generateSenderSigningKey();
        $aliceSenderKeyId = KeyHelper::generateSenderKeyId();

        $aliceDistributionMessage = $aliceSessionBuilder->process('groupWithBobInIt', $aliceSenderKeyId, 0,
                                $aliceSenderKey, $aliceSenderSigningKey);
        echo $this->niceVarDump($aliceDistributionMessage);
        echo $this->niceVarDump($aliceDistributionMessage->serialize());
        echo $aliceDistributionMessage->serialize();
        $bobSessionBuilder->processSender('groupWithBobInIt::aliceUserName', $aliceDistributionMessage);

        $ciphertextFromAlice = $aliceGroupCipher->encrypt('smert ze smert');
        $plaintextFromAlice_Bob = $bobGroupCipher->decrypt($ciphertextFromAlice);
        $ciphertextFromAlice_2 = $aliceGroupCipher->encrypt('smert ze smert');
        echo $this->niceVarDump($aliceDistributionMessage);
        $charlieSessionBuilder->processSender('groupWithBobInIt::aliceUserName', $aliceDistributionMessage);
        $plaintextFromAlice_Charlie = $charlieGroupCipher->decrypt($ciphertextFromAlice_2);

        $this->assertEquals($plaintextFromAlice_Bob, 'smert ze smert');
        $this->assertEquals($plaintextFromAlice_Charlie, 'smert ze smert');
    }

  /*  public function test_basicRatchet()
    {
        $aliceStore = new InMemorySenderKeyStore();
        $bobStore   = new InMemorySenderKeyStore();

        $aliceSessionBuilder = new GroupSessionBuilder($aliceStore);
        $bobSessionBuilder   = new GroupSessionBuilder($bobStore);

        $aliceGroupCipher = new GroupCipher($aliceStore, "groupWithBobInIt");
        $bobGroupCipher   = new GroupCipher($bobStore, "groupWithBobInIt::aliceUserName");

        $aliceSenderKey        = KeyHelper::generateSenderKey();
        $aliceSenderSigningKey = KeyHelper::generateSenderSigningKey();
        $aliceSenderKeyId      = KeyHelper::generateSenderKeyId();

        $aliceDistributionMessage = $aliceSessionBuilder->process("groupWithBobInIt", $aliceSenderKeyId, 0,
                                    $aliceSenderKey, $aliceSenderSigningKey);

        $bobSessionBuilder->processSender("groupWithBobInIt::aliceUserName", $aliceDistributionMessage);

        $ciphertextFromAlice  = $aliceGroupCipher->encrypt("smert ze smert");
        $ciphertextFromAlice2 = $aliceGroupCipher->encrypt("smert ze smert2");
        $ciphertextFromAlice3 = $aliceGroupCipher->encrypt("smert ze smert3");

        $plaintextFromAlice   = $bobGroupCipher->decrypt($ciphertextFromAlice);

        try {
          $bobGroupCipher->decrypt($ciphertextFromAlice);
          throw new AssertionError("Should have ratcheted forward!");
        } catch (DuplicateMessageException $dme) {
            #good
        }

        $plaintextFromAlice2  = $bobGroupCipher->decrypt($ciphertextFromAlice2);
        $plaintextFromAlice3  = $bobGroupCipher->decrypt($ciphertextFromAlice3);

        $this->assertEquals($plaintextFromAlice,"smert ze smert");
        $this->assertEquals($plaintextFromAlice2, "smert ze smert2");
        $this->assertEquals($plaintextFromAlice3, "smert ze smert3");

    }
    public function test_outOfOrder()
    {

        $aliceStore = new InMemorySenderKeyStore();
        $bobStore   = new InMemorySenderKeyStore();

        $aliceSessionBuilder = new GroupSessionBuilder($aliceStore);
        $bobSessionBuilder   = new GroupSessionBuilder($bobStore);

        $aliceGroupCipher = new GroupCipher($aliceStore, "groupWithBobInIt");
        $bobGroupCipher   = new GroupCipher($bobStore, "groupWithBobInIt::aliceUserName");

        $aliceSenderKey        = KeyHelper::generateSenderKey();
        $aliceSenderSigningKey = KeyHelper::generateSenderSigningKey();
        $aliceSenderKeyId      = KeyHelper::generateSenderKeyId();

        $aliceDistributionMessage = $aliceSessionBuilder->process("groupWithBobInIt", $aliceSenderKeyId, 0,
                                    $aliceSenderKey, $aliceSenderSigningKey);

        $bobSessionBuilder->processSender("groupWithBobInIt::aliceUserName", $aliceDistributionMessage);

        $ciphertexts = [];
        for ($i = 0; $i < 100; $i++)
            $ciphertexts[] = $aliceGroupCipher->encrypt("up the punks");
        while (count($ciphertexts) > 0)
        {
            $index = KeyHelper::getRandomSequence(2147483647) % count($ciphertexts);
            $elements = array_splice($ciphertexts,$index,1);
            $ciphertext = $elements[0];
            $plaintext = $bobGroupCipher->decrypt($ciphertext);
            $this->assertEquals($plaintext, "up the punks");
        }
    }

    public function test_encryptNoSession()
    {
        $aliceStore = new InMemorySenderKeyStore();
        $aliceGroupCipher = new GroupCipher($aliceStore, "groupWithBobInIt");
        try
        {
            $aliceGroupCipher->encrypt("up the punks");
            throw new AssertionError("Should have failed!");
        }
        catch (NoSessionException $nse)
        {
            # good
        }
    }*/
}
