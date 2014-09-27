<?php
class EntryHandler{
function get() {
		$product_id 		= sanitize($_GET["product_id"]);
		$user_id 		= sanitize($_GET["user_id"]);

		$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `entry_name`,, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(array("error"=>"Entries Not Found , error"),404);
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
		$user_id 		= sanitize($_POST["user_id"]);
		$product_id		= sanitize($_POST["product_id"]);
		//$timestamp 		= sanitize($_POST["timestamp "]);
		//$image 			= sanitize($_POST["image "]);
		$entry_name 	= sanitize($_POST["entry_name"]);
		$rating_ease 	= sanitize($_POST["rating_ease"]);
		$rating_safety 	= sanitize($_POST["rating_safety"]);
		$rating_reseal 	= sanitize($_POST["rating_reseal"]);
		$rating_overall = sanitize($_POST["rating_overall"]);//need to get?
		$comment 		= sanitize($_POST["comment"]);
		if (empty($_POST["entry_id"])) { // handles new entries
			$sql = "SELECT COUNT(*) AS cnt FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
				if ($resultArray[0]['cnt']==0){
					$sql = "INSERT IGNORE INTO `php54`.`entry` ( `user_id`, `product_id`, `entry_name`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment`) VALUES ('$user_id','$product_id','$entry_name','$rating_ease','$rating_safety','$rating_reseal','$rating_overall','$comment')";
					if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
						if ($result){
							$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `entry_name`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
							if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
								$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
								if (empty($resultArray)){ 
									echo _response(array("error"=>"entry_id does not exist, error, please check."),406);
								} 
								else{
									echo _response($resultArray[0],201);
									mysqli_free_result($result);
								}
							}
							else{ //SQL (grammar) has error
								echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
							}
						}
					}
					else{ //SQL (grammar) has error
						echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);

					}
				}
				else {//when entry is duplicate, allow them to overwrite
					//echo _response(array("error"=>"warning overwriting old entries"),200); 
					$sql = "UPDATE `entry` SET `entry_name`='$entry_name',`rating_ease`='$rating_ease',`rating_safety`='$rating_safety',`rating_reseal`='$rating_reseal',`rating_overall`='$rating_overall',`comment`='$comment' WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
						if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
							if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
								if ($result){
									$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`,`entry_name`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
									if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
										$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
										if (empty($resultArray)){ 
											echo _response(array("error"=>"unable to insert the user, error"),406);
										}
										else{
											echo _response($resultArray[0],201);
											mysqli_free_result($result);
										}
									}
									else{ //SQL (grammar) has error
										echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
									}
								}
							}
						}

				}
			}
			else{ //SQL (grammar) has error
				echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
			}
		}
		else {//Handles update entries
			$sql = "UPDATE `entry` SET `entry_name`='$entry_name',`rating_ease`='$rating_ease',`rating_safety`='$rating_safety',`rating_reseal`='$rating_reseal',`rating_overall`='$rating_overall',`comment`='$comment' WHERE `entry_id`='$entry_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				if ($result){
					$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`,`entry_name`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `entry_id`='$entry_id'";
					if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
						$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
						if (empty($resultArray)){ 
							echo _response(array("error"=>"unable to insert the user, error"),406);
						}
						else{
							echo _response($resultArray[0],201);
							mysqli_free_result($result);
						}
					}
					else{ //SQL (grammar) has error
						echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
					}
				}
			}
			else{ //SQL (grammar) has error
				echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
			}
		}
	}
}

?>