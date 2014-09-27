<?php
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

	function fakepost(){
		$email 		= sanitize($_POST["email"]);
		$password 	= sanitize($_POST["password"]);
		$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM user WHERE ((`user`.`email` = '$email') AND (`user`.`password` = '$password'))";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(array("error"=>"login does not match , error"),404);
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
		/*
		$fix_path = "$_ENV['OPENSHIFT_DATA_DIR']/upload/";
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
//-------------
				$tmp = explode(".", $_FILES["image_file"]["name"]);
				$tmp = sanitize(end($tmp));
				//var_dump($_ENV('OPENSHIFT_DATA_DIR'));
				$image_path = $fix_path . $entry_id . "_" . time() . "." . $tmp;
				self::image_upload($image_path);
//---------------
				//this query is for there's an existing image.
				$sql = "UPDATE `php54`.`entry` SET `image`='$image_path'  WHERE `entry_id` = '$entry_id'";
				if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
					echo _response(array( "entry_id" => $entry_id , "image"=>$image_path));
				}
				else{ //SQL (grammar) has error
					echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
				}
			}
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
		*/
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
		//var_dump($_FILES);
		//var_dump($_POST);
		//var_dump($image_path);
		$temp = explode(".", $_FILES["image_file"]["name"]);
		$extension = end($temp);

		if ((($_FILES["image_file"]["type"] == "image/gif")
		|| ($_FILES["image_file"]["type"] == "image/jpeg")
		|| ($_FILES["image_file"]["type"] == "image/jpg")
		|| ($_FILES["image_file"]["type"] == "image/pjpeg")
		|| ($_FILES["image_file"]["type"] == "image/x-png")
		|| ($_FILES["image_file"]["type"] == "image/png"))
		&& ($_FILES["image_file"]["size"] < 20000000)
		&& in_array($extension, $allowedExts)) {
			if ($_FILES["image_file"]["error"] > 0) {
				echo  _response(array("error"=>"Return Code: " . $_FILES["image_file"]["error"]),404);
			} else {
				/*echo "Upload: " . $_FILES["image_file"]["name"] . "<br>";
				echo "Type: " . $_FILES["image_file"]["type"] . "<br>";
				echo "Size: " . ($_FILES["image_file"]["size"] / 1024) . " kB<br>";
				echo "Temp file: " . $_FILES["image_file"]["tmp_name"] . "<br>";*/
				if (file_exists($image_path)){
					echo _response(array("error"=>$image_path . " already exists. "),409);
				}else {
					move_uploaded_file($_FILES["image_file"]["tmp_name"],$image_path);
					if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) echo "uploaded to $image_path";
				}
			}
		}else{
			echo _response(array("error"=>"Invalid file"),415);
		}
	}
}
?>