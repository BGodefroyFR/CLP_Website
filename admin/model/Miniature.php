<?php

class Miniature extends Elem {

	var $sectionId;
	var $upload;

	function __construct() {
		parent::__construct();
		$this->sectionId = -1;
		$this->upload = null;
	}

	function loadFromDB($tuple) {
		parent::loadFromDB($tuple);
		$this->sectionId = $tuple['sectionId'];
		$this->upload = new Upload();
      	$this->upload->loadFromDB($tuple['uploadId']);
	}

	function createFromForm($sectionId, $uploadId) {
	  $this->sectionId = $sectionId;
	  $this->upload = new Upload();
	  $this->upload->loadFromDB($uploadId);
	}

	function toMenuForm($sectionTitle) {
		$content = file_get_contents('../view/asset/miniature.html');
		$content = str_replace('<ID>', $this->id, $content);
		$content = str_replace('<TITLE>', $sectionTitle, $content);
		$content = str_replace('<SECTIONID>', $this->sectionId, $content);
		return $content;
	}

	function toSQL() {
		$q = "";
      	if ($this->upload != null)
			$q .= $this->upload->toSQL();
		$q .= "INSERT INTO adm_miniature(id, sectionId, uploadId, rank)" 
			. "VALUES('" . $this->id . "', '" . $this->sectionId . "', '" . $this->upload->id . "', '" . $this->rank . "'); ";
		return $q;
	}

	function toWebsite() {
		return "";
	}

	function rankUpdate() {
		return "UPDATE adm_miniature SET rank = '" . $this->rank . "' WHERE id = '" . $this->id . "'; ";
	}

	function delete($removeUploads) {
		if ($removeUploads) {
	         $this->upload->delete();
	      }
      	$q = "DELETE FROM adm_miniature WHERE id = '" . $this->id . "'; ";
    	executeQuery($q);
	}
}
?>