<?php
namespace Libsignal;

class AESCipher
{
    protected $key;
    protected $iv;
    protected $version;
    protected $counter;

    public function __construct($key, $iv, $version = 3, $counter = null)
    {
        $this->key = $key;
        $this->iv = $iv;
        $this->version = $version;
        if ($this->version < 3 && $counter == null) {
            throw new \Exception('Counter is needed for version < 3');
        }
        $this->counter = $counter;
    }

    private function pad($s)
    {
        $BS = 16;

        return $s.str_repeat(chr($BS - (strlen($s) % $BS)), ($BS - (strlen($s) % $BS)));
    }

    private function unpad($s, $diff = 0)
    {
        return substr($s, 0, -1 * (ord($s[strlen($s) - 1]) - $diff));
    }

    public function encrypt($raw)
    {
        // if sys.version_info >= (3,0):
        //     rawPadded = pad(raw.decode()).encode()
        // else:
        if ($this->version >= 3) {
            $rawPadded = $this->pad($raw);

            return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $rawPadded, MCRYPT_MODE_CBC, $this->iv);
        } else {
            return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $raw, 'ctr', $this->counter->Next());
        }
    }

    public function decrypt($enc)
    {
        if ($this->version >= 3) {
            $result = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, $enc, MCRYPT_MODE_CBC, $this->iv);

            $unpaded = $this->unpad($result);
            $last_unpadded = $unpaded[strlen($unpaded) - 1];
            $double_padding = substr($unpaded, -1 * (ord($last_unpadded) - 1));
            if (ord($last_unpadded) - 1 == strlen($double_padding)) {
                $has_dp = true;
                for ($x = 0; $x < strlen($double_padding); $x++) {
                    if ($double_padding[$x] != $last_unpadded) {
                        $has_dp = false;
                        break;
                    }
                }
            } else {
                $has_dp = false;
            }
            if ($has_dp) {
                $unpaded = $this->unpad($unpaded, 1);
            }

            return $unpaded;
        } else {
            return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, $enc, 'ctr', $this->counter->Next());
        }
    }
}
