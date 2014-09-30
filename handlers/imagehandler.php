<?php
//$GLOBALS['DEBUG']=true; //add this line (&uncomment it) to enable debugging.
class ImageHandler {
	function get($entry_id) {
		$sql = "SELECT * FROM `entry` WHERE `entry_id` = '$entry_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(array("error"=>"image based on `entry_id` = $entry_id not found , error"),404);
				}
			else{
				echo _response($resultArray[0],200);
				mysqli_free_result($result);
			}
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}

	function post($entry_id) {
		$fix_path = "upload/";
		//only process under the condition that $entry_id exists in the entry table.
		$sql =  "SELECT `image` FROM `entry` WHERE `entry_id` = '$entry_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(array("error"=>"`entry_id` = $entry_id does not exist"), 404);
				mysqli_free_result($result);
				}
			else{
				$image_path=$resultArray[0]['image'];
				if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($image_path);
				if (is_file($image_path)){ 	//if the file with the recorded path exists,
					unlink($image_path); 	//remove this file.
					if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) echo "exists, but removed now:) <br/>";
				}
				else {
					if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) echo "has record, but no file found. <br/>";
				}
				mysqli_free_result($result);
//------------------------------------------------------------------
				if (isset($_FILES["image_file"]))
				{
					$temp = explode(".", $_FILES["image_file"]["name"]);
					$extension = sanitize(strtolower(end($temp)));
					//var_dump($_ENV('OPENSHIFT_DATA_DIR'));
					$image_path = $fix_path . $entry_id . "_" . time() . "." . $extension;
					if (!self::image_upload($image_path)){
	//------------------------------------------------------------------
						//this query is for there's an existing image.
						$sql = "UPDATE `php54`.`entry` SET `image`='$image_path'  WHERE `entry_id` = '$entry_id'";
						if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
							echo _response(array( "entry_id" => $entry_id , "image"=>$image_path),200);

						}
						else{ //SQL (grammar) has error
							echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
						}
					}
				}
				else {
					echo _response(array("error"=>"no file uploaded"),400);
				}
			}
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}

	function image_upload($image_path){
		function rearrange_files_array(array $array) {
			foreach ($array as &$value) {
				$_array = array();
				foreach ($value as $prop => $propval) {
					if (is_array($propval)) {
						array_walk_recursive($propval, function(&$item, $key, $value) use($prop) {
							$item = array($prop => $item);
						}, $value);
						$_array = array_replace_recursive($_array, $propval);
					} else {
						$_array[$prop] = $propval;
					}
				}
				$value = $_array;
			}
			return $array;
		}
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["image_file"]["name"]);
		$extension = strtolower(end($temp));
		if ($_FILES["image_file"]["size"] < 20000000
			&& $_FILES["image_file"]["size"] > 0
			//&& in_array($extension, $allowedExts)
		){
			if ($_FILES["image_file"]["error"] > 0) {
				echo  _response(array("error"=>"Return Code: " . $_FILES["image_file"]["error"]),404);
			} else {
				if (file_exists($image_path)){
					echo _response(array("error"=>$image_path . " already exists. "),409);
				}else {
					move_uploaded_file($_FILES["image_file"]["tmp_name"],$image_path);
					if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) echo "uploaded to $image_path";
					return 0;
				}
			}
		}else{
			echo _response(array("error"=>"Invalid file"),415);
			if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($_FILES);
			return -1;
		}
	}
}
?>