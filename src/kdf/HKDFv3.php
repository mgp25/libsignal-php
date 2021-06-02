<?php
namespace Libsignal\kdf;

class HKDFv3 extends HKDF{

    protected function getIterationStartOffset()
    {
        return 1;
    }

}