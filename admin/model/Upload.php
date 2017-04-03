<?php

class Upload extends Elem {

	var $path;
	var $initialName;
	var $isTextEmbeded;
	var $isNew;

	function __construct() {
		parent::__construct();
		$this->path = "";
		$this->initialName = "";
		$this->isTextEmbeded = 0;
		$this->isNew = false;
	}

	function loadFromDB($uploadId) {
		$r = executeQuery("SELECT * FROM adm_upload WHERE id='" . $uploadId . "'");
		if($d = $r->fetch()) {
			parent::loadFromDB($d);
			$this->path = $d['path'];
			$this->initialName = $d['initialName'];
		}
		$this->isNew = false;
	}

	function createFromForm($path, $initialName) {
	  $this->path = $path;
	  $this->initialName = $initialName;
	  $this->isNew = true;
	}

	function toSQL() {
		if (!$this->isNew || strcmp($this->path, "") == 0)
			return "";
		$q = "INSERT INTO adm_upload(id, path, initialName, isTextEmbeded)" 
			. "VALUES('" . $this->id . "', '" . $this->path . "', '" . $this->initialName . "', '" . $this->isTextEmbeded . "'); ";
		return $q;
	}

	function delete() {
		$q = "DELETE FROM adm_upload WHERE id = '" . $this->id . "'; ";
    	executeQuery($q);
	}
}
?>