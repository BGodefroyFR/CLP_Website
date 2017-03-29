<?php

class Miniature extends Elem {

	var $sectionId = NULL;
	var $uploadId = NULL;

	function __construct() {
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
}
?>