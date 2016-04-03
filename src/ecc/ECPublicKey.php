<?php
namespace Libaxolotl\ecc;

interface ECPublicKey
{
    public function serialize();

    public function getType();
}
