<?php
class EntryHandler{
function get() {
		$product_id 		= sanitize($_GET["product_id"]);
		$user_id 		= sanitize($_GET["user_id"]);
		//$entry_id 	= sanitize($_GET["entry_id"]); 

		$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
		//$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `entry_name`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `entry_id`='$entry_id'";
		//var_dump($sql);
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				//echo _response(array("error"=>"Entries Not Found"),404);
				echo _response(array("entry_id"=>""),200);
				mysqli_free_result($result);
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
		//--------set default;
		$_POST = _set_default('entry_id','user_id','product_id');
		//--------end of set default

		//$responseArray = null;
		$entry_id 		= sanitize($_POST["entry_id"]); 
		$user_id 		= sanitize($_POST["user_id"]);
		$product_id		= sanitize($_POST["product_id"]);
		//$timestamp 		= sanitize($_POST["timestamp "]);
		//$image 			= sanitize($_POST["image "]);
		$entry_name 	= sanitize($_POST["entry_name"]);
		$manufacturer 	= sanitize($_POST["manufacturer"]);
		$packaging_type 	= sanitize($_POST["packaging_type"]);
		$rating_ease 	= sanitize($_POST["rating_ease"]);
		$rating_safety 	= sanitize($_POST["rating_safety"]);
		$rating_reseal 	= sanitize($_POST["rating_reseal"]);
		$rating_overall = sanitize($_POST["rating_overall"]);//need to get?
		$comment 		= sanitize($_POST["comment"]);
		include "product_segment.php";
		if (empty($_POST["entry_id"])) { // handles new entries
			$sql = "SELECT COUNT(*) AS cnt FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
			if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
				if ($resultArray[0]['cnt']==0){
					//need to create new / update product table and ratings
					
					$sql = "INSERT IGNORE INTO `php54`.`entry` ( `user_id`, `product_id`,`name`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment`) VALUES ('$user_id','$product_id','$entry_name','$rating_ease','$rating_safety','$rating_reseal','$rating_overall','$comment')";
					if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);
					if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
						if ($result){
							$sql = "SELECT `entry_id`, `user_id`, `entry`.`product_id`, `timestamp`, `product`.`image`, `name`, `manufacturer`, `packaging_type`,  `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` INNER JOIN `product` ON `entry`.`product_id` = `product`.`product_id` WHERE `user_id`='$user_id' AND `entry`.`product_id`='$product_id'";
							if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);
							if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
								$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
								if (empty($resultArray)){ 
									echo _response(array("error"=>"entry_id does not exist, error, please check."),406);
								} 
								else{
									echo _response($resultArray[0],201);
									$responseArray[] = $resultArray[0];
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
					$sql = "UPDATE `entry` SET `name`='$entry_name',`rating_ease`='$rating_ease',`rating_safety`='$rating_safety',`rating_reseal`='$rating_reseal',`rating_overall`='$rating_overall',`comment`='$comment' WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
						if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);
						//neeed to update product table and ratings
						if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
							$sql = "SELECT `entry_id`, `user_id`, `entry`.`product_id`, `timestamp`, `product`.`image`, `entry`.`name`, `manufacturer`, `packaging_type`,  `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` INNER JOIN `product` ON `entry`.`product_id` = `product`.`product_id` WHERE `user_id`='$user_id' AND `entry`.`product_id`='$product_id'";
							if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);
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
						else {
							echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
						}

				}
			}
			else{ //SQL (grammar) has error
				echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
			}
		}
		else {//Handles update entries
			$sql = "UPDATE `entry` SET `name`='$entry_name',`rating_ease`='$rating_ease',`rating_safety`='$rating_safety',`rating_reseal`='$rating_reseal',`rating_overall`='$rating_overall',`comment`='$comment' WHERE `entry_id`='$entry_id'";
			if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				if ($result){
					$sql = "SELECT `entry_id`, `user_id`, `entry`.`product_id`, `timestamp`, `product`.`image`, `entry`.`name`, `manufacturer`, `packaging_type`,  `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` INNER JOIN `product` ON `entry`.`product_id` = `product`.`product_id` WHERE `entry_id`='$entry_id'";
					if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);
					if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
						$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
						if (empty($resultArray)){ 
							echo _response(array("error"=>"unable to insert the user, error"),406);
						}
						else{
							echo _response($resultArray[0],201);
							$responseArray[] = $resultArray[0];
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
		include "rating_segment.php";
	}


//below are the overall ending
}

?>