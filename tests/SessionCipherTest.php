<?php
namespace Libsignal\Tests;
/*import unittest
from axolotl.state.sessionrecord import SessionRecord
from axolotl.ecc.curve import Curve
from axolotl.identitykeypair import IdentityKeyPair, IdentityKey
from axolotl.ratchet.aliceaxolotlparameters import AliceAxolotlParameters
from axolotl.ratchet.bobaxolotlparamaters import BobAxolotlParameters
from axolotl.ratchet.ratchetingsession import RatchetingSession
from axolotl.tests.inmemoryaxolotlstore import InMemoryAxolotlStore
from axolotl.sessioncipher import SessionCipher
from axolotl.protocol.whispermessage import WhisperMessage
import time
from random import shuffle*/
use Libsignal\Tests\TestCase;
use Libsignal\ecc\Curve;
use Libsignal\ratchet\RootKey;
use Libsignal\kdf\HKDF;
use Libsignal\ratchet\ChainKey;
use Libsignal\IdentityKey;
use Libsignal\IdentityKeyPair;
use Libsignal\ratchet\AliceAxolotlParameters;
use Libsignal\ratchet\BobAxolotlParameters;
use Libsignal\state\SessionState;
use Libsignal\state\SessionRecord;
use Libsignal\ratchet\RatchetingSession;
use Libsignal\state\SignedPreKeyStore;
use Libsignal\SessionCipher;
use Libsignal\SessionBuilder;
use Libsignal\protocol\WhisperMessage;

class SessionCipherTest extends TestCase
{
    public function testBasicSessionV2()
    {
        $aliceSessionRecord = new SessionRecord();
        $bobSessionRecord = new SessionRecord();
        $this->initializeSessionsV2($aliceSessionRecord->getSessionState(), $bobSessionRecord->getSessionState());
        $this->runInteraction($aliceSessionRecord, $bobSessionRecord);
    }

    public function testBasicSessionV3()
    {
        $aliceSessionRecord = new SessionRecord();
        $bobSessionRecord = new SessionRecord();
        $this->initializeSessionsV3($aliceSessionRecord->getSessionState(), $bobSessionRecord->getSessionState());
        $this->runInteraction($aliceSessionRecord, $bobSessionRecord);
    }

    protected function runInteraction($aliceSessionRecord, $bobSessionRecord)
    {
        $aliceStore = new InMemoryAxolotlStore();
        $bobStore = new InMemoryAxolotlStore();

        $aliceStore->storeSession(2, 1, $aliceSessionRecord);
        $bobStore->storeSession(3, 1, $bobSessionRecord);

        $aliceCipher = new SessionCipher($aliceStore, $aliceStore, $aliceStore, $aliceStore, 2, 1);
        $bobCipher = new SessionCipher($bobStore, $bobStore, $bobStore, $bobStore, 3, 1);

        $alicePlaintext = 'This is a plaintext message.';

        $message = $aliceCipher->encrypt($alicePlaintext);
        $bobPlaintext = $bobCipher->decryptMsg(new WhisperMessage(null, null, null, null, null, null, null, null, $message->serialize()));
        $this->assertEquals($alicePlaintext, $bobPlaintext);

        $bobReply = 'This is a message from Bob.';
        $reply = $bobCipher->encrypt($bobReply);
        $receivedReply = $aliceCipher->decryptMsg(new WhisperMessage(null, null, null, null, null, null, null, null, $reply->serialize()));

        $this->assertEquals($bobReply, $receivedReply);

        $aliceCiphertextMessages = [];
        $alicePlaintextMessages = [];

        for ($i = 0; $i < 50; $i++) {
            $alicePlaintextMessages[] = 'смерть за смерть '.$i;
            $aliceCiphertextMessages[] = $aliceCipher->encrypt("смерть за смерть $i");
        }
        //shuffle(aliceCiphertextMessages)
        //shuffle(alicePlaintextMessages)

        for ($i = 0; $i < count($aliceCiphertextMessages) / 2; $i++) {
            $receivedPlaintext = $bobCipher->decryptMsg(new WhisperMessage(null, null, null, null, null, null, null, null, $aliceCiphertextMessages[$i]->serialize()));
            $this->assertEquals($receivedPlaintext, $alicePlaintextMessages[$i]);
        }
    }

     /*   """

    List<CiphertextMessage> bobCiphertextMessages = new ArrayList<>();
    List<byte[]>            bobPlaintextMessages  = new ArrayList<>();

    for (int i=0;i<20;i++) {
      bobPlaintextMessages.add(("смерть за смерть " + i).getBytes());
      bobCiphertextMessages.add(bobCipher.encrypt(("смерть за смерть " + i).getBytes()));
    }

    seed = System.currentTimeMillis();

    Collections.shuffle(bobCiphertextMessages, new Random(seed));
    Collections.shuffle(bobPlaintextMessages, new Random(seed));

    for (int i=0;i<bobCiphertextMessages.size() / 2;i++) {
      byte[] receivedPlaintext = aliceCipher.decrypt(new WhisperMessage(bobCiphertextMessages.get(i).serialize()));
      assertTrue(Arrays.equals(receivedPlaintext, bobPlaintextMessages.get(i)));
    }

    for (int i=aliceCiphertextMessages.size()/2;i<aliceCiphertextMessages.size();i++) {
      byte[] receivedPlaintext = bobCipher.decrypt(new WhisperMessage(aliceCiphertextMessages.get(i).serialize()));
      assertTrue(Arrays.equals(receivedPlaintext, alicePlaintextMessages.get(i)));
    }

    for (int i=bobCiphertextMessages.size() / 2;i<bobCiphertextMessages.size();i++) {
      byte[] receivedPlaintext = aliceCipher.decrypt(new WhisperMessage(bobCiphertextMessages.get(i).serialize()));
      assertTrue(Arrays.equals(receivedPlaintext, bobPlaintextMessages.get(i)));
    }
        """
*/

    protected function initializeSessionsV2($aliceSessionState, $bobSessionState)
    {
        $aliceIdentityKeyPair = Curve::generateKeyPair();
        $aliceIdentityKey = new IdentityKeyPair(new IdentityKey($aliceIdentityKeyPair->getPublicKey()),
                                                               $aliceIdentityKeyPair->getPrivateKey());
        $aliceBaseKey = Curve::generateKeyPair();
        $aliceEphemeralKey = Curve::generateKeyPair();

        $bobIdentityKeyPair = Curve::generateKeyPair();
        $bobIdentityKey = new IdentityKeyPair(new IdentityKey($bobIdentityKeyPair->getPublicKey()),
                                                               $bobIdentityKeyPair->getPrivateKey());
        $bobBaseKey = Curve::generateKeyPair();
        $bobEphemeralKey = $bobBaseKey;

        $aliceParameters = AliceAxolotlParameters::newBuilder();

        $aliceParameters->setOurIdentityKey($aliceIdentityKey)
        ->setOurBaseKey($aliceBaseKey)
        ->setTheirIdentityKey($bobIdentityKey->getPublicKey())
        ->setTheirSignedPreKey($bobEphemeralKey->getPublicKey())
        ->setTheirRatchetKey($bobEphemeralKey->getPublicKey())
        ->setTheirOneTimePreKey(null);
        $aliceParameters = $aliceParameters->create();

        $bobParameters = BobAxolotlParameters::newBuilder();
        $bobParameters->setOurIdentityKey($bobIdentityKey)
            ->setOurOneTimePreKey(null)
            ->setOurRatchetKey($bobEphemeralKey)
            ->setOurSignedPreKey($bobBaseKey)
            ->setTheirBaseKey($aliceBaseKey->getPublicKey())
            ->setTheirIdentityKey($aliceIdentityKey->getPublicKey());
        $bobParameters = $bobParameters->create();

        RatchetingSession::initializeSessionAsAlice($aliceSessionState, 2, $aliceParameters);
        RatchetingSession::initializeSessionAsBob($bobSessionState, 2, $bobParameters);
    }

    protected function initializeSessionsV3($aliceSessionState, $bobSessionState)
    {
        $aliceIdentityKeyPair = Curve::generateKeyPair();
        $aliceIdentityKey = new IdentityKeyPair(new IdentityKey($aliceIdentityKeyPair->getPublicKey()),
                                                               $aliceIdentityKeyPair->getPrivateKey());
        $aliceBaseKey = Curve::generateKeyPair();
        $aliceEphemeralKey = Curve::generateKeyPair();

        $alicePreKey = $aliceBaseKey;

        $bobIdentityKeyPair = Curve::generateKeyPair();
        $bobIdentityKey = new IdentityKeyPair(new IdentityKey($bobIdentityKeyPair->getPublicKey()),
                                                               $bobIdentityKeyPair->getPrivateKey());
        $bobBaseKey = Curve::generateKeyPair();
        $bobEphemeralKey = $bobBaseKey;

        $bobPreKey = Curve::generateKeyPair();

        $aliceParameters = AliceAxolotlParameters::newBuilder()
            ->setOurBaseKey($aliceBaseKey)
            ->setOurIdentityKey($aliceIdentityKey)
            ->setTheirOneTimePreKey(null)
            ->setTheirRatchetKey($bobEphemeralKey->getPublicKey())
            ->setTheirSignedPreKey($bobBaseKey->getPublicKey())
            ->setTheirIdentityKey($bobIdentityKey->getPublicKey())
            ->create();

        $bobParameters = BobAxolotlParameters::newBuilder()
            ->setOurRatchetKey($bobEphemeralKey)
            ->setOurSignedPreKey($bobBaseKey)
            ->setOurOneTimePreKey(null)
            ->setOurIdentityKey($bobIdentityKey)
            ->setTheirIdentityKey($aliceIdentityKey->getPublicKey())
            ->setTheirBaseKey($aliceBaseKey->getPublicKey())
            ->create();

        RatchetingSession::initializeSessionAsAlice($aliceSessionState, 3, $aliceParameters);
        RatchetingSession::initializeSessionAsBob($bobSessionState, 3, $bobParameters);
    }
}
