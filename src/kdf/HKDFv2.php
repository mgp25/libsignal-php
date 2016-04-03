<?php
namespace Libaxolotl\kdf;

class HKDFv2 extends HKDF
{
    protected function getIterationStartOffset()
    {
        return 0;
    }
}
