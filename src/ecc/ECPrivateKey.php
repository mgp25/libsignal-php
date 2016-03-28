<?php
namespace Libaxolotl\ecc;

interface ECPrivateKey
{
    public function serialize();

    public function getType();
}
