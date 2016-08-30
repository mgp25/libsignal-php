<?php

require_once __DIR__.'/../IdentityKey.php';
require_once __DIR__.'/../util/ByteUtil.php';
require_once __DIR__.'/../fingerprint/Fingerprint.php';
require_once __DIR__.'/../fingerprint/FingerprintGenerator.php';
require_once __DIR__.'/../fingerprint/DisplayableFingerprint.php';
require_once __DIR__.'/../fingerprint/ScannableFingerprint.php';


class NumericFingerPrintGenerator implements FingerprintGenerator
{
    const VERSION = 0;

    private $iterations;

  /**
   * Construct a fingerprint generator for 60 digit numerics.
   *
   * @param iterations The number of internal iterations to perform in the process of
   *                   generating a fingerprint. This needs to be constant, and synchronized
   *                   across all clients.
   *
   *                   The higher the iteration count, the higher the security level:
   *
   *                   - 1024 ~ 109.7 bits
   *                   - 1400 > 110 bits
   *                   - 5200 > 112 bits
   */
  public function __construct($iterations)
  {
      $this->iterations = $iterations;
  }

  /**
   * Generate a scannable and displayble fingerprint.
   *
   * @param localStableIdentifier The client's "stable" identifier.
   * @param localIdentityKey The client's identity key.
   * @param remoteStableIdentifier The remote party's "stable" identifier.
   * @param remoteIdentityKey The remote party's identity key.
   *
   * @return A unique fingerprint for this conversation.
   */
  public function createFor($localStableIdentifier, $localIdentityKey,
                               $remoteStableIdentifier, $remoteIdentityKey)
  {
      $displayableFingerprint = new DisplayableFingerprint($this->getDisplayStringFor($localStableIdentifier, $localIdentityKey),
                                                                               $this->getDisplayStringFor($remoteStableIdentifier, $remoteIdentityKey));
      $scannableFingerprint = new ScannableFingerprint(self::VERSION,
                                                                         $localStableIdentifier, $localIdentityKey,
                                                                         $remoteStableIdentifier, $remoteIdentityKey);

      return new Fingerprint($displayableFingerprint, $scannableFingerprint);
  }

    private function getDisplayStringFor($stableIdentifier, $identityKey)
    {
        $digest = hash_init('sha512');
        $publicKey = $identityKey->getPublicKey()->serialize();
        $hash = ByteUtil::combine([ByteUtil::shortToByteArray(self::VERSION), $publicKey, unpack('C*', $stableIdentifier)]);
        $str = '';
        foreach ($hash as $h) {
            $str .= chr($h);
        }
        $hash = $str;

        $str = '';
        foreach (str_split($publicKey) as $h) {
            $str .= chr($h);
        }
        $publicKey = $str;

        for ($i = 0; $i < $this->iterations; $i++) {
            hash_update($digest, $hash);
            hash_update($digest, $publicKey);
        }
        $hash = hash_final($digest, true);
        $_hash = unpack('C*', $hash);
        $hash = [];
        foreach ($_hash as $i => $v) {
            $hash[$i - 1] = $v;
        }

        return $this->getEncodedChunk($hash, 0).
        $this->getEncodedChunk($hash, 5).
        $this->getEncodedChunk($hash, 10).
        $this->getEncodedChunk($hash, 15).
        $this->getEncodedChunk($hash, 20).
        $this->getEncodedChunk($hash, 25);
    }

    private function getEncodedChunk($hash, $offset)
    {
        $chunk = ByteUtil::byteArray5ToLong($hash, $offset) % 100000;

        return sprintf('%05d', $chunk);
    }
}
