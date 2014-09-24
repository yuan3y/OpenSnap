<?php

class ImageHandler {
	function get($entry_id) {
//SELECT  `image` FROM `entry` WHERE `entry_id`=''
		$sql = "SELECT  `image` FROM `entry` WHERE `entry_id`='$entry_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(array("error"=>"Image Not Found , error"),404);
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

	function post() {
		$entry_id 		= sanitize($_POST["entry_id"]);
		$image = $_FILES["file"];
		$image_name = $_FILES["file"]["name"];

			//INSERT INTO `entry`(`image`) VALUES ('')

		$sql = "INSERT INTO `entry`(`image`) VALUES ('$image_name')"; //$entry_id+'.jpg' or $_FILES["file"]['name'] or a url?
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(array("error"=>"Image Failed to upload , error"),404);
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
/*
	function delete() {
		$user_id 	= sanitize($_REQUEST["user_id"]);
		$sql = "DELETE FROM `php54`.`user` WHERE `user`.`user_id` = $user_id;";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			echo _response(array("success"=>"deleted $user_id"),204);
			mysqli_free_result($result);
			}
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}
	*/

	function Image_upload(){

		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);

		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 20000)
		&& in_array($extension, $allowedExts)) {


		  if ($_FILES["file"]["error"] > 0) {
		    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		  } else {
		    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		    echo "Type: " . $_FILES["file"]["type"] . "<br>";
		    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
		    if (file_exists("upload/" . $_FILES["file"]["name"])) {
		      echo $_FILES["file"]["name"] . " already exists. ";
		    } else {
		      move_uploaded_file($_FILES["file"]["tmp_name"],
		"upload/" . $_FILES["file"]["name"]);
		echo"Stored in: " . "upload/" . $_FILES["file"]["name"];
		}
		}
		}else{
		echo "Invalid file";
}
}


}

?>