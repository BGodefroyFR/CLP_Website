<?php

class Upload extends Elem {

	var $path;
	var $initialName;
	var $isTextEmbeded;

	function __construct() {
		parent::__construct();
		$this->path = "";
		$this->initialName = "";
		$this->isTextEmbeded = 0;
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->path = $tuple['path'];
		$this->initialName = $tuple['initialName'];
	}

	function createFromForm($path, $initialName) {
	  $this->path = $path;
	  $this->initialName = $initialName;
	}

	function toFrontEnd() {
	}

	function toBDD() {
		$q = "INSERT INTO adm_upload(id, path, initialName, isTextEmbeded)" 
			. "VALUES('" . $this->id . "', '" . $this->path . "', '" . $this->initialName . "', '" . $this->isTextEmbeded . "'); ";
		return $q;
	}
}
?>