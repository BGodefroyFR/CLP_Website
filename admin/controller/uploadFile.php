<?php
	function uploadFile ($target_dir, $file) {
		$id = rand(1,1e9) . '.' . pathinfo($file["name"], PATHINFO_EXTENSION);
		$target_file = "../../" . $target_dir . "/" . $id;
		move_uploaded_file($file["tmp_name"], $target_file);
		return array($file["name"], $target_dir . "/" . $id);
	}

	function uploadFiles ($target_dir, $files) {
		$paths = array();
		for ($i = 0; $i < sizeof($files["name"]); $i++) {
			if (!isUploadError($files["error"][$i])) {
				$id = rand(1,1e9) . '.' . pathinfo($files["name"][$i], PATHINFO_EXTENSION);
				$target_file = "../../" . $target_dir . "/" . $id;
				move_uploaded_file($files["tmp_name"][$i], $target_file);
				array_push($paths, array($files["name"][$i], $target_dir . "/" . $id));
			} else {
				array_push($paths, array("", ""));
			}
		}
		return $paths;
	}

	function isUploadError($error) {
	    switch ($error) {
	        case UPLOAD_ERR_NO_FILE:
	            return true;
	        case UPLOAD_ERR_INI_SIZE:
	        	return true;
	        case UPLOAD_ERR_FORM_SIZE:
	            return true;
	        default:
	            return false;
	    }
	}
?>