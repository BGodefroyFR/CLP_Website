<?php
	include '../model/Model.php';

	function generateMenu() {
		$newModel = new Model();
		$newModel->loadFromDB();
		$content = $newModel->toMenuForm();
		return $content;
	}
?>