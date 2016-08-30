<?php

class Fingerprint
{
    private $displayableFingerprint;
    private $scannableFingerprint;

    public function __construct($displayableFingerprint,
                     $scannableFingerprint)
    {
        $this->displayableFingerprint = $displayableFingerprint;
        $this->scannableFingerprint = $scannableFingerprint;
    }

  /**
   * @return A text fingerprint that can be displayed and compared remotely.
   */
  public function getDisplayableFingerprint()
  {
      return $this->displayableFingerprint;
  }

  /**
   * @return A scannable fingerprint that can be scanned anc compared locally.
   */
  public function getScannableFingerprint()
  {
      return $this->scannableFingerprint;
  }
}
