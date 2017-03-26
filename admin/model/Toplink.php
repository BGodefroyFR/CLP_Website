<?php

class Toplink extends Elem {

	var $sectionId = NULL;
	var $label = NULL;

	function __construct() {
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
}
?>