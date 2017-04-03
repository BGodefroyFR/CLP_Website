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
		return $this->getSection($sectionId)->toSectionForm();
	}

	function toMenuForm() {
		$content = file_get_contents('../view/asset/menuSkeleton.html');

		$topLinkContent = "";
		$miniatureContent = "";
		$sectionContent = "";
		foreach ($this->sections as $s) {
			$topLinkContent .= $s->toTopLinksMenuForm();
			$miniatureContent .= $s->toMiniaturesMenuForm();
			$sectionContent .= $s->toSectionsMenuForm();
		}
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
		if($s = $this->getSection($sectionIndex)) {
			$s->delete();
		}
	}

	function getSection($id) {
		foreach($this->sections as $s) {
			if ($s->id == $id)
				return $s;
		}
	}
}
?>