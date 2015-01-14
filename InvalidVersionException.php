<?php
namespace libaxolotl;


class InvalidVersionException extends Exception {
	public function __construct ($s) {
		parent::__construct($s);
	}
}

?>