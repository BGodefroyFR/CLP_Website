<?php
	include '../model/Model.php';

	checkConnection();

	function generateMenu() {
		$newModel = new Model();
		$newModel->loadFromDB();
		$content = $newModel->toMenuForm();
		return $content;
	}
?>