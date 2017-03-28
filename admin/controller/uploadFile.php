<?php
	function uploadFile ($target_dir, $file) {
		$id = rand(1,1e9) . '.' . pathinfo($file["name"], PATHINFO_EXTENSION);
		$target_file = $target_dir . "/" . $id;
		move_uploaded_file($file["tmp_name"], $target_file);
		return $target_file;
	}

	function uploadFiles ($target_dir, $files) {
		$paths = array();
		for ($i = 0; $i < sizeof($files["name"]); $i++) {
			$id = rand(1,1e9) . '.' . pathinfo($files["name"][$i], PATHINFO_EXTENSION);
			$target_file = $target_dir . "/" . $id;
			move_uploaded_file($files["tmp_name"][$i], $target_file);
			array_push($paths, $target_file);
		}
		return $paths;
	}
?>