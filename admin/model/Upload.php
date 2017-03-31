<?php

class Upload extends Elem {

	var $path;
	var $initialName;

	function __construct() {
		parent::__construct();
		$this->path = "";
		$this->initialName = "";
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
		$q = "INSERT INTO adm_upload(id, path, initialName)" 
			. "VALUES('" . $this->id . "', '" . $this->path . "', '" . $this->initialName . "'); ";
		return $q;
	}
}
?>