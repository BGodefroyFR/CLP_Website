<?php

class Miniature extends Elem {

	var $sectionId = NULL;
	var $imagePath = NULL;

	function __construct() {
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->sectionId = $tuple['sectionId'];
		$this->imagePath = $tuple['imagePath'];
	}

	function createFromForm($sectionId, $imagePath) {
	  $this->sectionId = $sectionId;
	  $this->imagePath = $imagePath;
	}

	function toFrontEnd() {
	}
}
?>