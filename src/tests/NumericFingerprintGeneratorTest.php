<?php

require_once __DIR__.'/../ecc/Curve.php';
require_once __DIR__.'/../fingerprint/FingerprintVersionMismatchException.php';
require_once __DIR__.'/../fingerprint/FingerprintIdentifierMismatchException.php';
require_once __DIR__.'/../fingerprint/FingerprintParsingException.php';
require_once __DIR__.'/../fingerprint/NumericFingerPrintGenerator.php';
require_once __DIR__.'/../fingerprint/FingerprintIdentifierMismatchException.php';
require_once __DIR__.'/../IdentityKey.php';

class NumericFingerprintGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testMatchingFingerprints()
    {
        $aliceKeyPair = Curve::generateKeyPair();
        $bobKeyPair = Curve::generateKeyPair();

        $aliceIdentityKey = new IdentityKey($aliceKeyPair->getPublicKey());
        $bobIdentityKey = new IdentityKey($bobKeyPair->getPublicKey());

        $generator = new NumericFingerprintGenerator(1024);
        $aliceFingerprint = $generator->createFor('+14152222222', $aliceIdentityKey, '+14153333333', $bobIdentityKey);

        $bobFingerprint = $generator->createFor('+14153333333', $bobIdentityKey, '+14152222222', $aliceIdentityKey);

        $this->assertEquals($aliceFingerprint->getDisplayableFingerprint()->getDisplayText(),
                 $bobFingerprint->getDisplayableFingerprint()->getDisplayText());

        $this->assertTrue($aliceFingerprint->getScannableFingerprint() == $bobFingerprint->getScannableFingerprint()->getSerialized());
        $this->assertTrue($bobFingerprint->getScannableFingerprint() == $aliceFingerprint->getScannableFingerprint()->getSerialized());

        $assertEquals(strlen($this->aliceFingerprint->getDisplayableFingerprint()->getDisplayText()), 60);
    }

    public function testMismatchingFingerprints()
    {
        $aliceKeyPair = Curve::generateKeyPair();
        $bobKeyPair = Curve::generateKeyPair();
        $mitmKeyPair = Curve::generateKeyPair();

        $aliceIdentityKey = new IdentityKey($aliceKeyPair->getPublicKey());
        $bobIdentityKey = new IdentityKey($bobKeyPair->getPublicKey());
        $mitmIdentityKey = new IdentityKey($mitmKeyPair->getPublicKey());

        $generator = new NumericFingerprintGenerator(1024);
        $aliceFingerprint = $generator->createFor('+14152222222', $aliceIdentityKey,
                                                                       '+14153333333', $mitmIdentityKey);

        $bobFingerprint = $generator->createFor('+14153333333', $bobIdentityKey,
                                                     '+14152222222', $aliceIdentityKey);

        $this->assertNotSame($aliceFingerprint->getDisplayableFingerprint()->getDisplayText(),
                  $bobFingerprint->getDisplayableFingerprint()->getDisplayText());

        $this->assertFalse($aliceFingerprint->getScannableFingerprint()->getSerialized() == $bobFingerprint->getScannableFingerprint()->getSerialized());
        $this->assertFalse($bobFingerprint->getScannableFingerprint()->getSerialized() == $aliceFingerprint->getScannableFingerprint()->getSerialized());
    }

    public function testMismatchingIdentifiers()
    {
        $aliceKeyPair = Curve::generateKeyPair();
        $bobKeyPair = Curve::generateKeyPair();

        $aliceIdentityKey = new IdentityKey($aliceKeyPair->getPublicKey());
        $bobIdentityKey = new IdentityKey($bobKeyPair->getPublicKey());

        $generator = new NumericFingerprintGenerator(1024);
        $aliceFingerprint = $generator->createFor('+141512222222', $aliceIdentityKey,
                                                                       '+14153333333', $bobIdentityKey);

        $bobFingerprint = $generator->createFor('+14153333333', $bobIdentityKey,
                                                     '+14152222222', $aliceIdentityKey);

        $this->assertNotSame($aliceFingerprint->getDisplayableFingerprint()->getDisplayText(),
                  $bobFingerprint->getDisplayableFingerprint()->getDisplayText());

        try {
            $aliceFingerprint->getScannableFingerprint()->getSerialized() == $bobFingerprint->getScannableFingerprint()->getSerialized();
            throw new Exception('Should mismatch!');
        } catch (FingerprintIdentifierMismatchException $e) {
            // good
        }

        try {
            $bobFingerprint->getScannableFingerprint()->getSerialized() == $aliceFingerprint->getScannableFingerprint()->getSerialized();
            throw new Exception('Should mismatch!');
        } catch (FingerprintIdentifierMismatchException $e) {
            // good
        }
    }
}
