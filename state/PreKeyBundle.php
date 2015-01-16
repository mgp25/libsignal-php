<?php
require_once("IdentityKey.php");
require_once("ecc/ECPublicKey.php");
class PreKeyBundle {
    protected $registrationId;    // int
    protected $deviceId;    // int
    protected $preKeyId;    // int
    protected $preKeyPublic;    // ECPublicKey
    protected $signedPreKeyId;    // int
    protected $signedPreKeyPublic;    // ECPublicKey
    protected $signedPreKeySignature;    // byte[]
    protected $identityKey;    // IdentityKey
    private function __init() { // default class members
    }
    public static function __staticinit() { // static class members
    }
    public static function constructor__3a05205a ($registrationId, $deviceId, $preKeyId, $preKeyPublic, $signedPreKeyId, $signedPreKeyPublic, $signedPreKeySignature, $identityKey) // [int registrationId, int deviceId, int preKeyId, ECPublicKey preKeyPublic, int signedPreKeyId, ECPublicKey signedPreKeyPublic, byte[] signedPreKeySignature, IdentityKey identityKey]
    {
        $me = new self();
        $me->__init();
        $me->registrationId = $registrationId;
        $me->deviceId = $deviceId;
        $me->preKeyId = $preKeyId;
        $me->preKeyPublic = $preKeyPublic;
        $me->signedPreKeyId = $signedPreKeyId;
        $me->signedPreKeyPublic = $signedPreKeyPublic;
        $me->signedPreKeySignature = $signedPreKeySignature;
        $me->identityKey = $identityKey;
        return $me;
    }
    public function getDeviceId ()
    {
        return $this->deviceId;
    }
    public function getPreKeyId ()
    {
        return $this->preKeyId;
    }
    public function getPreKey ()
    {
        return $this->preKeyPublic;
    }
    public function getSignedPreKeyId ()
    {
        return $this->signedPreKeyId;
    }
    public function getSignedPreKey ()
    {
        return $this->signedPreKeyPublic;
    }
    public function getSignedPreKeySignature ()
    {
        return $this->signedPreKeySignature;
    }
    public function getIdentityKey ()
    {
        return $this->identityKey;
    }
    public function getRegistrationId ()
    {
        return $this->registrationId;
    }
}
PreKeyBundle::__staticinit(); // initialize static vars for this class on load
?>
