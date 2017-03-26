<?php

class Gallery extends Elem {

	var $sectionId = NULL;
	
	function __construct() {
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->sectionId = $tuple['sectionId'];
	}

	function createFromForm($sectionId) {
      $this->sectionId = $sectionId;
   }

	function toFrontEnd() {
	}
}
?>