<?php
class EntryHandler{
	//echo"ENTERING ENTRIES HANDLER main";

	//SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='' AND `product_id`=''
	function get() {
		$product_id 		= sanitize($_GET["product_id"]);
		$user_id 		= sanitize($_GET["user_id"]);


		$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
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
		//echo"ENTERING ENTRIES HANDLER post";
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
		var_dump(empty($_POST["entry_id"]));
		if (empty($_POST["entry_id"])) { // handles new entries
			$sql = "SELECT COUNT(*) AS cnt FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
				if ($resultArray[0]['cnt']==0){
					$sql = "INSERT IGNORE INTO `php54`.`entry` ( `user_id`, `product_id`,  `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment`) VALUES ('$user_id','$product_id','$rating_ease','$rating_safety','$rating_reseal','$rating_overall','$comment')";
					if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
						if ($result){
							$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
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
				else {
					var_dump($resultArray);
					echo "test";
					echo _response(array("error"=>"user duplicated, error"),404);
				}
			}
			else{ //SQL (grammar) has error
				echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
			}
		}
		else {//Handles update entries
			var_dump($entry_id);var_dump($rating_ease);var_dump($rating_ease);
			$sql = "UPDATE `entry` SET `rating_ease`='$rating_ease',`rating_safety`='$rating_safety',`rating_reseal`='$rating_reseal',`rating_overall`='$rating_overall',`comment`='$comment' WHERE `entry_id`='$enrty_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				var_dump($result);
				if ($result){
					$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `entry_id`='$entry_id'";
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


		/*
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response($resultArray[0],200);

				mysqli_free_result($result);
				//echo _response(array("error"=>"Insert Entries Failed , error"),404);
				}
			else{
				echo _response(array("error"=>"Insert Entries Failed , error"),404);
				//echo _response($resultArray[0],200);
				//mysqli_free_result($result);
			}
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}*/
	
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