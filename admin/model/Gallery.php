<?php

class Gallery extends Elem {

	var $sectionId = NULL;
	
	function __construct() {
		$id = rand(1,1e9);
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