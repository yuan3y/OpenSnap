<?php
class EntriesHandler{


	function post() {
		$entry_id 		= sanitize($_POST["entry_id"]); 
		$user_id 		= sanitize($_POST["user_id"]);
		$product_id		= sanitize($_POST["product_id"]);
		//$timestamp 		= sanitize($_POST["timestamp "]);
		//$image 			= sanitize($_POST["image "]);
		$rating_ease 	= sanitize($_POST["rating_ease"]);
		$rating_safety 	= sanitize($_POST["rating_safety"]);
		$rating_reseal 	= sanitize($_POST["rating_reseal"]);
		$rating_overall = sanitize($_POST["rating_overall"]);//need to get?
		$comment 		= sanitize($_POST["comment"]); 


		$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id'";

		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(""),200);
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
}



/*

		$sql = "SELECT COUNT(*) AS cnt FROM `entry` WHERE `user_id`='$user_id' ";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
				if ($resultArray[0]['cnt']==0){
					$sql = "INSERT IGNORE INTO `php54`.`entry` ( `user_id`, `product_id`,  `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment`) VALUES ('$user_id','$product_id','$rating_ease','$rating_safety','$rating_reseal','$rating_overall','$comment')";
					if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
						if ($result){
							$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id'";
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
				else {
					echo _response(array("error"=>"user duplicated, error"),404);
				}
			}
			else{ //SQL (grammar) has error
				echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
			}


		}

*/



?>