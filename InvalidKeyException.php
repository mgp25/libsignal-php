<?php
namespace libaxolotl;


class InvalidKeyException extends Exception {

	public function __construct ($detailMessage) {
		parent::__construct($detailMessage);
	}
/*
	public InvalidKeyException(String detailMessage) {
		super(detailMessage);
	}

	public InvalidKeyException(Throwable throwable) {
		super(throwable);
	}

	public InvalidKeyException(String detailMessage, Throwable throwable) {
		super(detailMessage, throwable);
	}*/
}

?>