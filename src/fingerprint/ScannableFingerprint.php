<?php

require_once __DIR__.'/../IdentityKey.php';
require_once __DIR__.'/../protobuf/pb_proto_FingerprintProtocol.php';

class ScannableFingerprint
{
    private $combinedFingerprint;

    public function __construct($version,
                              $localStableIdentifier, $localIdentityKey,
                              $remoteStableIdentifier, $remoteIdentityKey)
    {
        $this->combinedFingerprint = new CombinedFingerprint();
        $this->combinedFingerprint->setVersion($version);
        $localFingerPrint = new FingerprintData();
        $localFingerPrint->setIdentifier($localStableIdentifier);
        $publicKey = '';
        foreach (str_split($localIdentityKey->serialize()) as $v) {
            $publicKey .= chr($v);
        }
        $localFingerPrint->setPublicKey($publicKey);
        $this->combinedFingerprint->setLocalFingerprint($localFingerPrint->serializeToString());

        $fingerprintData = new FingerprintData();
        $fingerprintData->setIdentifier($remoteStableIdentifier);
        $remoteKey = '';
        foreach (str_split($remoteIdentityKey->serialize()) as $v) {
            $remoteKey .= chr($v);
        }
        $fingerprintData->setPublicKey($remoteKey);
        $this->combinedFingerprint->setRemoteFingerprint($fingerprintData->serializeToString());
    }

  /**
   * @return A byte string to be displayed in a QR code.
   */
  public function getSerialized()
  {
      return $this->combinedFingerprint;
  }

  /**
   * Compare a scanned QR code with what we expect.
   *
   * @param scannedFingerprintData The scanned data
   *
   * @throws FingerprintVersionMismatchException if the scanned fingerprint is the wrong version.
   * @throws FingerprintIdentifierMismatchException if the scanned fingerprint is for the wrong stable identifier.
   *
   * @return true if matching, otehrwise false.
   */
  public function compareTo($scannedFingerprintData)
  {
      try {
          $scannedFingerprint = new combinedFingerprint();
          $scannedFingerprint->parseFromString($scannedFingerprintData);

          if (!$scannedFingerprint->hasRemoteFingerprint() || !$scannedFingerprint->hasLocalFingerprint() ||
          !$scannedFingerprint->hasVersion() || $scannedFingerprint->getVersion() != $this->combinedFingerprint->getVersion()) {
              throw new FingerprintVersionMismatchException();
          }

          if (!$this->combinedFingerprint->getLocalFingerprint()->getIdentifier() == $scannedFingerprint->getRemoteFingerprint()->getIdentifier() ||
          !$this->combinedFingerprint->getRemoteFingerprint()->getIdentifier() == $scannedFingerprint->getLocalFingerprint()->getIdentifier()) {
              throw new FingerprintIdentifierMismatchException(new String($this->combinedFingerprint->getLocalFingerprint()->getIdentifier()),
                                                         new String($this->combinedFingerprint->getRemoteFingerprint()->getIdentifier()),
                                                         new String($scannedFingerprint->getLocalFingerprint()->getIdentifier()),
                                                         new String($scannedFingerprint->getRemoteFingerprint()->getIdentifier()));
          }

          return hash_equals($this->combinedFingerprint->getLocalFingerprint(), $scannedFingerprint->getRemoteFingerprint()) &&
             hash_equals($this->combinedFingerprint->getRemoteFingerprint(), $scannedFingerprint->getLocalFingerprint());
      } catch (InvalidProtocolBufferException $e) {
          throw new FingerprintParsingException($e);
      }
  }
}
