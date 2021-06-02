<?php
namespace Libsignal\ecc;

interface ECPrivateKey{

    public function serialize();

    public function getType();

}