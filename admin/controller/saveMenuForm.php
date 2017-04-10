<?php
	include '../model/Model.php';
	include 'uploadFile.php';

	checkConnection();

	$model = new Model();
	$model->loadFromDB();

	updateTopLinksRanks($model);
	updateMiniaturesRanks($model);
	updateSections($model);

	// Generates website
	$model = new Model();
	$model->loadFromDB();
	$model->toWebsite();
	

	// -------------------------------------

	function updateTopLinksRanks($model) {
		if (isset($_POST['toplink'])) {
			$curRank = 0;
			$q = "";
			foreach ($_POST['toplink'] as $t) {
				foreach ($model->sections as $curSection) {
					if ($curSection->toplink != null && $curSection->toplink->id == $t) {
						$curSection->toplink->rank = $curRank ++;
						$q .= $curSection->toplink->rankUpdate();
						break;
					}
				}
			}
			executeQuery($q);
		}
	}

	function updateMiniaturesRanks($model) {
		if (isset($_POST['miniature'])) {
			$curRank = 0;
			$q = "";
			foreach ($_POST['miniature'] as $t) {
				foreach ($model->sections as $curSection) {
					if ($curSection->miniature != null && $curSection->miniature->id == $t) {
						$curSection->miniature->rank = $curRank ++;
						$q .= $curSection->miniature->rankUpdate();
						break;
					}
				}
			}
			executeQuery($q);
		}
	}

	function updateSections($model) {
		$listDeleted = array();
		for ($i = 0; $i < sizeof($model->sections); $i++) {
			array_push($listDeleted, true);
		}

		if (isset($_POST['section'])) {
			$curRank = 0;
			$q = "";
			foreach ($_POST['section'] as $t) {
				$count = 0;
				$curSection = null;
				foreach($model->sections as $e) {
					if ($e->id == $t) {
						$listDeleted[$count] = false;
						$curSection = $e;
						break;
					}
					$count ++;
				}
				if ($curSection == null) { // new section
					$newSection = new Section();
					$newSection->createFromMenu($curRank ++, $t);
					$q .= $newSection->toSQL();
				} else {
					$curSection->rank = $curRank ++;
					$q .= $curSection->rankUpdate();
				}
			}
			executeQuery($q);
		}

		// Remove deleted sections
		$count = 0;
		foreach($listDeleted as $e) {
			if ($e == true) {
				$model->deleteSectionByIndex($count, true);
			}
			$count ++;
		}
	}
?>