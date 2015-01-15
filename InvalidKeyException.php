<?php
class InvalidKeyException extends Exception {
	
	public function __construct($detailMessage, $throwable=null){
		if ($throwable ==null){
			parent::constructor__($detailMessage);
		} else {
			parent::constructor__($detailMessage, $throwable);
		}
	}	
}
?>
