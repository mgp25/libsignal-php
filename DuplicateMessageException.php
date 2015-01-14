<?php
namespace libaxolotl;


class DuplicateMessageException extends Exception {
	public function __construct ($s) {
		parent::__construct($s);
	}
}

?>