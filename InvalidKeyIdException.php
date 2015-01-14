<?php
namespace libaxolotl;


class InvalidKeyIdException extends Exception {
	public function __construct ($s) {
		parent::__construct($s);
	}
}

?>