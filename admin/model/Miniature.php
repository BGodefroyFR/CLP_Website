<?php

class Miniature extends Elem {

	var $sectionId = NULL;
	var $imageId = NULL;

	function __construct() {
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->sectionId = $tuple['sectionId'];
		$this->imageId = $tuple['imageId'];
	}

	function createFromForm($sectionId, $imageId) {
	  $this->sectionId = $sectionId;
	  $this->imageId = $imageId;
	}

	function toFrontEnd() {
	}
}
?>