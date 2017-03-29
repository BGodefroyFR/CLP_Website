<?php

class Gallery extends Elem {

	var $sectionId = NULL;
	
	function __construct() {
	}

	function createFromBdd($tuple) {
		parent::createFromBdd($tuple);
		$this->sectionId = $tuple['sectionId'];
	}

	function createFromForm($sectionId, $rank) {
      $this->sectionId = $sectionId;
      $this->rank = $rank;
   }

	function toFrontEnd() {
	}

	function toBDD() {
		//$q = "DELETE FROM adm_gallery WHERE id='" . $this->$id . "'; ";
		//$q += "INSERT INTO adm_gallery(id, sectionId, rank)"
	}
}
?>