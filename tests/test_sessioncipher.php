<?php

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
require_once __DIR__. "/../ecc/Curve.php";
require_once __DIR__."/../ratchet/RootKey.php";
require_once __DIR__."/../kdf/HKDF.php";
require_once __DIR__."/../ratchet/ChainKey.php";
require_once __DIR__."/../IdentityKey.php";
require_once __DIR__."/../IdentityKeyPair.php";
require_once __DIR__."/../ratchet/AliceAxolotlParameters.php";
require_once __DIR__."/../ratchet/BobAxolotlParameters.php";
require_once __DIR__."/../state/SessionState.php";
require_once __DIR__."/../state/SessionRecord.php";
require_once __DIR__."/../ratchet/RatchetingSession.php";
require_once __DIR__ ."/../state/SignedPreKeyStore.php";
require_once __DIR__ ."/../SessionCipher.php";
require_once __DIR__ ."/../SessionBuilder.php";
require_once __DIR__ ."/inmemoryidentitykeystore.php";
require_once __DIR__ ."/inmemorysessionstore.php";
require_once __DIR__ ."/inmemorysignedprekeystore.php";

require_once __DIR__ ."/inmemoryaxolotlstore.php";
function parseText($txt){
    for($x=0;$x<strlen($txt);$x++){
        if(ord($txt[$x]) < 20 || ord($txt[$x]) > 230)
        {
            $txt = "HEX:".bin2hex($txt);
            return $txt;
        }
    }
    return $txt;
}
class SessionCipherTest extends PHPUnit_Framework_TestCase{

    public function test_basicSessionV2(){
        $aliceSessionRecord = new SessionRecord();
        $bobSessionRecord = new SessionRecord();
        $this->initializeSessionsV2($aliceSessionRecord->getSessionState(), $bobSessionRecord->getSessionState());
        $this->runInteraction($aliceSessionRecord, $bobSessionRecord);
    }

    public function test_basicSessionV3(){
        $aliceSessionRecord = new SessionRecord();
        $bobSessionRecord = new SessionRecord();
        $this->initializeSessionsV3($aliceSessionRecord->getSessionState(), $bobSessionRecord->getSessionState());
        $this->runInteraction($aliceSessionRecord, $bobSessionRecord);
    }
    protected function runInteraction($aliceSessionRecord, $bobSessionRecord){
        $aliceStore = new InMemoryAxolotlStore();
        $bobStore   = new InMemoryAxolotlStore();

        $aliceStore->storeSession(2, 1, $aliceSessionRecord);
        $bobStore->storeSession(3, 1, $bobSessionRecord);

        $aliceCipher    = new SessionCipher($aliceStore, $aliceStore, $aliceStore, $aliceStore, 2, 1);
        $bobCipher      = new SessionCipher($bobStore, $bobStore, $bobStore, $bobStore, 3, 1);

        $alicePlaintext = "This is a plaintext message.";

        $message        = $aliceCipher->encrypt($alicePlaintext);
        $bobPlaintext   = $bobCipher->decryptMsg(new WhisperMessage(null,null, null, null, null, null, null, null, $message->serialize()));
        $this->assertEquals($alicePlaintext, $bobPlaintext);

        $bobReply      = "This is a message from Bob.";
        $reply         = $bobCipher->encrypt($bobReply);
        $receivedReply = $aliceCipher->decryptMsg(new WhisperMessage(null,null, null, null, null, null, null, null, $reply->serialize()));

        $this->assertEquals($bobReply, $receivedReply);

        $aliceCiphertextMessages = [];
        $alicePlaintextMessages = [];

        for($i=0;$i<50;$i++){
            $alicePlaintextMessages[] = "смерть за смерть ".$i;
            $aliceCiphertextMessages[] = $aliceCipher->encrypt("смерть за смерть $i");
        }
        #shuffle(aliceCiphertextMessages)
        #shuffle(alicePlaintextMessages)


        for($i = 0;$i<count($aliceCiphertextMessages)/2;$i++){
            $receivedPlaintext = $bobCipher->decryptMsg(new WhisperMessage(null,null, null, null, null, null, null, null, $aliceCiphertextMessages[$i]->serialize()));
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



    protected function initializeSessionsV2($aliceSessionState, $bobSessionState){
        $aliceIdentityKeyPair = Curve::generateKeyPair();
        $aliceIdentityKey     = new IdentityKeyPair(new IdentityKey($aliceIdentityKeyPair->getPublicKey()),
                                                               $aliceIdentityKeyPair->getPrivateKey());
        $aliceBaseKey         = Curve::generateKeyPair();
        $aliceEphemeralKey    = Curve::generateKeyPair();

        $bobIdentityKeyPair   = Curve::generateKeyPair();
        $bobIdentityKey       = new IdentityKeyPair(new IdentityKey($bobIdentityKeyPair->getPublicKey()),
                                                               $bobIdentityKeyPair->getPrivateKey());
        $bobBaseKey           = Curve::generateKeyPair();
        $bobEphemeralKey      = $bobBaseKey;

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

    protected function initializeSessionsV3($aliceSessionState, $bobSessionState){
        $aliceIdentityKeyPair = Curve::generateKeyPair();
        $aliceIdentityKey     = new IdentityKeyPair(new IdentityKey($aliceIdentityKeyPair->getPublicKey()),
                                                               $aliceIdentityKeyPair->getPrivateKey());
        $aliceBaseKey         = Curve::generateKeyPair();
        $aliceEphemeralKey    = Curve::generateKeyPair();

        $alicePreKey          = $aliceBaseKey;

        $bobIdentityKeyPair   = Curve::generateKeyPair();
        $bobIdentityKey       = new IdentityKeyPair(new IdentityKey($bobIdentityKeyPair->getPublicKey()),
                                                               $bobIdentityKeyPair->getPrivateKey());
        $bobBaseKey           = Curve::generateKeyPair();
        $bobEphemeralKey      = $bobBaseKey;

        $bobPreKey            = Curve::generateKeyPair();

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
?>
