<?php

class Miniature extends Elem {

	var $sectionId;
	var $uploadId;

	function __construct() {
		parent::__construct();
		$this->sectionId = -1;
		$this->uploadId = -1;
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->sectionId = $tuple['sectionId'];
		$this->uploadId = $tuple['uploadId'];
	}

	function createFromForm($sectionId, $uploadId) {
	  $this->sectionId = $sectionId;
	  $this->uploadId = $uploadId;
	}

	function toFrontEnd() {
	}

	function toBDD() {
		$q = "DELETE FROM adm_miniature WHERE id='" . $this->id . "'; ";
		$q .= "INSERT INTO adm_miniature(id, sectionId, uploadId, rank)" 
			. "VALUES('" . $this->id . "', '" . $this->sectionId . "', '" . $this->uploadId . "', '" . $this->rank . "'); ";
		return $q;
	}
}
?>