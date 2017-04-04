<?php
include 'Elem.php';
include 'Section.php';
include 'Upload.php';
include '../util.php';

class Model {

	var $sections = array();

	function __construct() {
	}

	function loadFromDB() {
		$r = executeQuery("SELECT * FROM adm_section");
		while($d = $r->fetch()) {
			$e = new Section($d);
			$e->loadFromDB($d);
            array_push($this->sections, $e);
		}
        $r->closeCursor();
	}

	function toSectionForm($sectionId) {
		$s = $this->getSection($sectionId);
		if ($s == null) {
			$s = new Section();
			array_push($this->sections, $s);
		}
		return $s->toSectionForm();
	}

	function toMenuForm() {
		$content = file_get_contents('../view/asset/menuSkeleton.html');

		$topLinkContent = "";
		$miniatureContent = "";
		$sectionContent = "";

		$isDone;
		do {
			$isDone = true;
			foreach ($this->sections as $s) {
				if ($s->toplink != null && $s->toplink->rank == -1)
					$topLinkContent .= $s->toplink->toMenuForm($s->title);
				if ($s->miniature != null && $s->miniature->rank == -1)
					$miniatureContent .= $s->miniature->toMenuForm($s->title);
			}
		} while(!$isDone);

		$isDone;
		$rankCounter = 0;
		do {
			$isDone = true;
			foreach ($this->sections as $s) {
				if ($s->toplink != null && $s->toplink->rank == $rankCounter)
					$topLinkContent .= $s->toplink->toMenuForm($s->title);
				if ($s->miniature != null && $s->miniature->rank == $rankCounter)
					$miniatureContent .= $s->miniature->toMenuForm($s->title);
				if ($s->rank == $rankCounter) {
					$sectionContent .= $s->toMenuForm();
					$isDone = false;
				}
			}
			$rankCounter ++;
		} while(!$isDone);

		$content = str_replace('<TOPLINKS>', $topLinkContent, $content);
		$content = str_replace('<MINIATURES>', $miniatureContent, $content);
		$content = str_replace('<SECTIONS>', $sectionContent, $content);

		return $content;
	}

	function toSQL() {
		$q = "";
		foreach($this->sections as $e) {
			$q .= $e->toSQL();
		}
		return $q;
	}

	function deleteSection($sectionIndex) {
		$this->sections[$sectionIndex]->delete();
	}

	function getSection($id) {
		foreach($this->sections as $s) {
			if ($s->id == $id)
				return $s;
		}
	}
}
?>