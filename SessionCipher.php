<?php

/**
 * Copyright (C) 2013 Open Whisper Systems
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace libaxolotl;

require "/ecc.Curve.php";
require "/ecc/ECKeyPair.php";
require "/ecc/ECPublicKey.php";
require "/protocol/CiphertextMessage.php";
require "/protocol/PreKeyWhisperMessage.php";
require "/protocol/WhisperMessage.php";
require "/ratchet/ChainKey.php";
require "/ratchet/MessageKeys.php";
require "/ratchet/RootKey.php";
require "/state/AxolotlStore.php";
require "/state/IdentityKeyStore.php";
require "/state/PreKeyStore.php";
require "/state/SessionRecord.php";
require "/state/SessionState.php";
require "/state/SessionStore.php";
require "/state/SignedPreKeyStore.php";
require "/util/ByteUtil.php";
require "/util/Pair.php";
require "/util/guava/Optional.php";

require "/state/SessionState/UnacknowledgedPreKeyMessageItems.php";

class SessionCipher {

  public static $SESION_LOCK; // Object
  protected $sessionStore;    // SessionStore
  protected $sessionBuilder;  // SessionBuilder
  protected $preKeyStore;     // PreKeyStore
  protected $recipientId;     // long
  protected $deviceId;        // int

  public static function __statucinit() {
    self::$SESSION_LOCK = new Object();
  }

  function SessionCipher_construct ($sessionStire, $preKeyStore, $signedPreKey, $identityKeyStore, $recipientId, $deviceId)
  {
    $this->sessionStore =   $sessionStore;
    $this->preKeyStore =    $preKeyStore;
    $this->recipientId =    $recipientId;
    $this->deviceId =       $deviceId;
    $this->sessionBuilder = SessionBuilder($sessionStore, $preKeyStore, $signedPreKeyStore, $identityKeyStore, $recipientId, $deviceId);
  }

  function SessionCipher($store, $recipientId, $deviceId)
  {
    SessionCipher_construct($store, $store, $store, $store, $recipientId, $deviceId);
  }
 }
 ?>
