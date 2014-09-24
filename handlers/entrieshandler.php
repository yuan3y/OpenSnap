<?php
class JournalsHandler {
	function get($entry_id) {//get full product details when productid or barcode is present
		$sql = "SELECT `entry_id`,`user_id`,`product_id`,`timestamp`,`image`,`rating_ease`,`rating_safety`,`rating_reseal`,`rating_overall`,`comment`FROM `journal` WHERE `entry_id`='$entry_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			echo _response(mysqli_fetch_all($result,MYSQLI_ASSOC)[0]);
			mysqli_free_result($result);
		}
		else {
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),404);
		}
	}
	function post() { // 10 colums , get user inputs and insert new product to system
		$entry_id 		= sanitize($_POST["entry_id"]); // journal entries auto generate, need this?
		$user_id 		= sanitize($_POST["user_id "]);
		$product_id		= sanitize($_POST["product_id"]);
		$timestamp 		= sanitize($_POST["timestamp "]);
		$image 			= sanitize($_POST["image "]);
		$rating_ease 	= sanitize($_POST["rating_ease"]);
		$rating_safety 	= sanitize($_POST["rating_safety"]);
		$rating_reseal 	= sanitize($_POST["rating_reseal"]);
		$rating_overall = sanitize($_POST["rating_overall"]);
		$comment 		= sanitize($_POST["comment"]);
	
		
		
		
		
		$sql = "INSERT INTO `php54`.`journal` (`entry_id`,`user_id`,`product_id`,`timestamp`,`image`,`rating_ease`,`rating_safety`,`rating_reseal`,`rating_overall`,`comment`) VALUES (NULL, '$user_id', '$product_id', '$timestamp', '$image', '$rating_ease', '$rating_safety ', '$rating_reseal', '$rating_overall','$comment');";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			$sql = "SELECT `entry_id`,`user_id`,`product_id`,`timestamp`,`image`,`rating_ease`,`rating_safety`,`rating_reseal`,`rating_overall`,`comment`FROM `journal` WHERE `entry_id`='$entry_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) {
				echo _response(mysqli_fetch_all($result,MYSQLI_ASSOC)[0],201);
				mysqli_free_result($result);
			}
		}
		else {
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),422);
		}
	}
	
	/*
	function delete() {
		$user_id 	= sanitize($_REQUEST["user_id"]);
		$sql = "DELETE FROM `php54`.`user` WHERE `user`.`user_id` = $user_id;";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			echo _response("",204);
			mysqli_free_result($result);
		}
	}
	*/
}

?>