<?php

class Toplink extends Elem {

	var $sectionId;
	var $label;

	function __construct() {
		parent::__construct();
		$this->sectionId = -1;
		$this->label = "";
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->sectionId = $tuple['sectionId'];
		$this->label = $tuple['label'];
	}

	function createFromForm($sectionId, $label) {
	  $this->sectionId = $sectionId;
	  $this->label = $label;
	}

	function toFrontEnd() {
	}

	function toBDD() {
		$q = "INSERT INTO adm_toplink(id, sectionId, label, rank)" 
			. "VALUES('" . $this->id . "', '" . $this->sectionId . "', '" . $this->label . "', '" . $this->rank . "'); ";
		return $q;
	}
}
?>