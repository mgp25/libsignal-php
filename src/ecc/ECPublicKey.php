<?php
namespace Libsignal\ecc;

interface ECPublicKey{

    public function serialize();

    public function getType();

}