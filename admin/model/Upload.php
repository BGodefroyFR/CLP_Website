<?php

class Upload extends Elem {

	var $path;

	function __construct() {
		parent::__construct();
		$this->path = "";
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

	function toBDD() {
		$q = "DELETE FROM adm_upload WHERE id='" . $this->id . "'; ";
		$q .= "INSERT INTO adm_upload(id, path)" 
			. "VALUES('" . $this->id . "', '" . $this->path . "'); ";
		return $q;
	}
}
?>