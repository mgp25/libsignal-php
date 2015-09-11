    <?php
require_once("../util/ByteUtil.php");
class DerivedRootSecrets {
    const SIZE = 64;    // int
    protected $rootKey;    // byte[]
    protected $chainKey;    // byte[]
    public function DerivedRootSecrets ($okm) // [byte[] okm]
    {
        $keys = ByteUtil::split($okm, 32, 32);
        $me->rootKey = $keys[0];
        $me->chainKey = $keys[1];
    }
    public function getRootKey ()
    {
        return $this->rootKey;
    }
    public function getChainKey ()
    {
        return $this->chainKey;
    }
}