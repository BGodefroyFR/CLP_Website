<?php

class Upload extends Elem {

	var $path = NULL;

	function __construct() {
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->path = $tuple['path'];
	}

	function createFromForm($path) {
	  $this->path = $path;
	}

	function toFrontEnd() {
	}
}
?>