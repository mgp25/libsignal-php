<?php
require_once("com/google/protobuf/ByteString.php");
require_once("ecc/ECPublicKey.php");
require_once("util/ByteUtil.php");
class SenderKeyDistributionMessage implements CiphertextMessage {
	protected $id;	// int
	protected $iteration;	// int
	protected $chainKey;	// byte[]
	protected $signatureKey;	// ECPublicKey
	protected $serialized;	// byte[]
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	public static function constructor__d8d86e83 ($id, $iteration, $chainKey, $signatureKey) // [int id, int iteration, byte[] chainKey, ECPublicKey signatureKey]
	{
		$me = new self();
		$me->__init();
		$version = [ByteUtil::intsToByteHighAndLow($CURRENT_VERSION, $CURRENT_VERSION)];
		$me->id = $id;
		$me->iteration = $iteration;
		$me->chainKey = $chainKey;
		$me->signatureKey = $signatureKey;
		$me->serialized = WhisperProtos::$SenderKeyDistributionMessage->newBuilder()->setId($id)->setIteration($iteration)->setChainKey($ByteString->copyFrom($chainKey))->setSigningKey($ByteString->copyFrom($signatureKey->serialize()))->build()->toByteArray();
		return $me;
	}
	public function serialize ()
	{
		return $this->serialized;
	}
	public function getType ()
	{
		return $SENDERKEY_DISTRIBUTION_TYPE;
	}
	public function getIteration ()
	{
		return $this->iteration;
	}
	public function getChainKey ()
	{
		return $this->chainKey;
	}
	public function getSignatureKey ()
	{
		return $this->signatureKey;
	}
	public function getId ()
	{
		return $this->id;
	}
}
SenderKeyDistributionMessage::__staticinit(); // initialize static vars for this class on load
?>
