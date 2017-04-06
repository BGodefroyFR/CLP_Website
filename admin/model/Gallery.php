<?php
include 'GalleryImage.php';

class Gallery extends Elem {

	var $sectionId;
	var $galleryimages = array();
	
	function __construct() {
		parent::__construct();
		$this->sectionId = -1;
	}

	function loadFromDB($tuple) {
		parent::loadFromDB($tuple);
		$this->sectionId = $tuple['sectionId'];

		// galleryimages
		$r = executeQuery("SELECT * FROM adm_galleryimage WHERE galleryId = '" . $this->id . "' ORDER BY rank ASC");
		while($d = $r->fetch()) {
			$e = new Galleryimage($d);
			$e->loadFromDB($d);
            array_push($this->galleryimages, $e);
		}
	}

	function createFromForm($sectionId, $rank) {
      $this->sectionId = $sectionId;
      $this->rank = $rank;
   }

	function toSectionForm() {
		$content = file_get_contents('../view/asset/curGalery.html');
		$content = str_replace("name=\"rankMarker\"", "name=\"gallery_rankMarker" . rand(1, 1e9) . "\"", $content);
		$galleryContent = "";
		foreach ($this->galleryimages as $g) {
			$galleryContent .= $g->toSectionForm();
		}
		$content = str_replace("<CONTENT>", $galleryContent, $content);
		return $content;
	}

	function toSQL() {
		$q = "INSERT INTO adm_gallery(id, sectionId, rank)" 
			. "VALUES('" . $this->id . "', '" . $this->sectionId . "', '" . $this->rank . "'); ";
		foreach ($this->galleryimages as $i) {
			$q .= $i->toSQL();
		}
		return $q;
	}

	function delete($removeUploads) {
		foreach($this->galleryimages as $g) {
			$g->delete($removeUploads);
		}
      	$q = "DELETE FROM adm_gallery WHERE id = '" . $this->id . "'; ";
		executeQuery($q);
   }
}
?>