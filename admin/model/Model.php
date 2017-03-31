<?php
include '../util.php';
include 'Elem.php';
include 'Link.php';
include 'Gallery.php';
include 'Textarea.php';
include 'Section.php';
include 'Miniature.php';
include 'Toplink.php';
include 'Upload.php';
include 'GalleryImage.php';

class Model {

	var $links = array();
	var $galleries = array();
	var $textareas = array();
	var $sections = array();
	var $miniatures = array();
	var $toplinks = array();
	var $uploads = array();
	var $galleryimages = array();

	function __construct() {
	}

	function loadFromDB() {
		$bdd = connectBDD();

		// links
		$r = $bdd->query("SELECT * FROM adm_link");
		while($d = $r->fetch()) {
			$e = new Link($d);
			$e->createFromBdd($d);
            array_push($this->links, $e);
		}
        // galleries
		$r = $bdd->query("SELECT * FROM adm_gallery");
		while($d = $r->fetch()) {
			$e = new Gallery($d);
			$e->createFromBdd($d);
            array_push($this->galleries, $e);
		}
        // textareas
		$r = $bdd->query("SELECT * FROM adm_textarea");
		while($d = $r->fetch()) {
			$e = new Textarea($d);
			$e->createFromBdd($d);
            array_push($this->textareas, $e);
		}
        // sections
		$r = $bdd->query("SELECT * FROM adm_section");
		while($d = $r->fetch()) {
			$e = new Section($d);
			$e->createFromBdd($d);
            array_push($this->sections, $e);
		}
        // miniatures
		$r = $bdd->query("SELECT * FROM adm_miniature");
		while($d = $r->fetch()) {
			$e = new Miniature($d);
			$e->createFromBdd($d);
            array_push($this->miniatures, $e);
		}
        // toplinks
		$r = $bdd->query("SELECT * FROM adm_toplink");
		while($d = $r->fetch()) {
			$e = new Toplink($d);
			$e->createFromBdd($d);
            array_push($this->toplinks, $e);
		}
        // uploads
		$r = $bdd->query("SELECT * FROM adm_upload");
		while($d = $r->fetch()) {
			$e = new Upload($d);
			$e->createFromBdd($d);
            array_push($this->uploads, $e);
		}
        // galleryimages
		$r = $bdd->query("SELECT * FROM adm_galleryimage");
		while($d = $r->fetch()) {
			$e = new Galleryimage($d);
			$e->createFromBdd($d);
            array_push($this->galleryimages, $e);
		}

        $r->closeCursor();
	}

	function toFrontEnd($sectionId) {
		$content = file_get_contents('../view/asset/sectionSkeleton.html');

		// Title
		$content = str_replace('<TITLE>', $this->getById($this->sections, $sectionId)->title, $content);

		// Top link
		$toplink = $this->getBySectionId($this->toplinks, $sectionId);
		if ($toplink) {
			$content = str_replace('<ISTOPLINK>', 'checked', $content);
			$content = str_replace('<TOPLINK>', $toplink->label, $content);
			$content = str_replace('<ISTOPLINKHIDDEN>', '', $content);
		} else {
			$content = str_replace('<ISTOPLINK>', '', $content);
			$content = str_replace('<ISTOPLINKHIDDEN>', 'hidden', $content);
		}

		// Miniature
		$miniature = $this->getBySectionId($this->miniatures, $sectionId);
		if ($miniature) {
			$content = str_replace('<ISMINIATURE>', 'checked', $content);
			$content = str_replace('<ISMINIATUREHIDDEN>', '', $content);
			$tmp = "<p id='curMiniature'>" . $this->getById($this->uploads, $miniature->uploadId)->initialName . "</p>";
			$content = str_replace('<MINIATUREIMAGE>', $tmp, $content);
		} else {
			$content = str_replace('<ISMINIATURE>', '', $content);
			$content = str_replace('<ISMINIATUREHIDDEN>', 'hidden', $content);
		}

		// Background color
		$content = str_replace('<BACKGROUNDCOLOR>', $this->getById($this->sections, $sectionId)->backgroundColor, $content);
		// Font color
		$content = str_replace('<FONTCOLOR>', $this->getById($this->sections, $sectionId)->textColor, $content);
		// Background pattern
		$content = str_replace('<BACKGROUNDPATTERN>', $this->getById($this->sections, $sectionId)->backgroundPattern, $content);

		// Links
		foreach ($this->links as $l) {
			$content = $this->insertElemToFrontContent($content, $l->toFrontEnd($this->uploads));
		}
		// Galleries
		foreach ($this->galleries as $g) {
			$content = $this->insertElemToFrontContent($content, $g->toFrontEnd($this->galleryimages, $this->uploads));
		}
		// Textareas
		foreach ($this->textareas as $t) {
			$content = $this->insertElemToFrontContent($content, $t->toFrontEnd());
		}

		return $content;
	}

	function toBDD() {
		$q = "";

		foreach($this->links as $e) {
			$q .= $e->toBDD();
		}
		foreach($this->galleries as $e) {
			$q .= $e->toBDD();
		}
		foreach($this->textareas as $e) {
			$q .= $e->toBDD();
		}
		foreach($this->sections as $e) {
			$q .= $e->toBDD();
		}
		foreach($this->miniatures as $e) {
			$q .= $e->toBDD();
		}
		foreach($this->toplinks as $e) {
			$q .= $e->toBDD();
		}
		foreach($this->uploads as $e) {
			$q .= $e->toBDD();
		}
		foreach($this->galleryimages as $e) {
			$q .= $e->toBDD();
		}

		return $q;
	}

	function getById($elemArray, $id) {
		foreach($elemArray as $s) {
			if ($s->id == $id) {
				return $s;
			}
		}
	}
	function getBySectionId($elemArray, $id) {
		foreach($elemArray as $s) {
			if ($s->sectionId == $id)
				return $s;
		}
	}

	function insertElemToFrontContent($content, $elem) {
		$pos = strpos($content, '</section></form>');
		$newContent = substr($content, 0, $pos)
			. $elem
			. substr($content, $pos);
		return $newContent;
	}
}
?>