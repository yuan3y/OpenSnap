<?php
class EntryHandler{
function get() {
		$product_id 		= sanitize($_GET["product_id"]);
		$user_id 		= sanitize($_GET["user_id"]);
		//$entry_id 	= sanitize($_GET["entry_id"]); 

		$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `entry_name`, `manufacturer`, `packaging_type`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
		//$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `entry_name`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `entry_id`='$entry_id'";
		//var_dump($sql);
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				//echo _response(array("error"=>"Entries Not Found"),404);
				echo _response($resultArray[0],200);
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
		if (empty($_POST["entry_id"])) { // handles new entries
			$sql = "SELECT COUNT(*) AS cnt FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
				if ($resultArray[0]['cnt']==0){
					$sql = "INSERT IGNORE INTO `php54`.`entry` ( `user_id`, `product_id`, `entry_name`, `manufacturer`, `packaging_type`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment`) VALUES ('$user_id','$product_id','$entry_name','$manufacturer','$packaging_type','$rating_ease','$rating_safety','$rating_reseal','$rating_overall','$comment')";
					//var_dump($manufacturer);
					//var_dump($sql);
					//need to create new / update product table and ratings


					if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
						if ($result){
							$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `entry_name`,`manufacturer`,`packaging_type`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
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
					$sql = "UPDATE `entry` SET `entry_name`='$entry_name', `manufacturer`='$manufacturer', `packaging_type`='$packaging_type',`rating_ease`='$rating_ease',`rating_safety`='$rating_safety',`rating_reseal`='$rating_reseal',`rating_overall`='$rating_overall',`comment`='$comment' WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
						//var_dump($sql);
						//neeed to update product table and ratings
						if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
							if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
								if ($result){
									$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`,`entry_name`,`manufacturer`,`packaging_type`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id' AND `product_id`='$product_id'";
									var_dump($sql);
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
			$sql = "UPDATE `entry` SET `entry_name`='$entry_name', `manufacturer`='$manufacturer', `packaging_type`='$packaging_type',`rating_ease`='$rating_ease',`rating_safety`='$rating_safety',`rating_reseal`='$rating_reseal',`rating_overall`='$rating_overall',`comment`='$comment' WHERE `entry_id`='$entry_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				if ($result){
					$sql = "SELECT`entry_id`, `user_id`, `product_id`, `timestamp`, `image`,`entry_name`,`manufacturer`,`packaging_type`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment`  FROM `entry` WHERE `entry_id`='$entry_id'";
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
	function New_Product_Rating_Changer(){ // will do the update of overall rating and counter for product
		//will need to ->>sum_of_rating +=user rating, no_of_raters++;

		//1. need to get the current vaules and store them
		$sql = "SELECT`sum_of_rating`, `no_of_raters` FROM `product` WHERE `product_id`=`$product_id`";
		//store the data into a variable
		//2. update the current data by adding the current entry overall rating in and increase the counter by 1 and store it back
		//$sql="UPDATE `product` SET `sum_of_rating`='',`no_of_raters`='' WHERE `product_id`='$product_id'";

	}*/
/*
		function Update_Product_Table(){ // will do the update of overall rating and counter for product
		//will need to ->>sum_of_rating +=(current)user rating - (prevoious)user_rating, 
		$New_sum_of_rating =0;
		$New_no_of_raters=0;

		$sql_selectAll = "SELECT `product_id`,`name`,`manufacturer`,`packaging_type`,`image`,`sum_of_rating`,`no_of_raters`,`avg_rating`FROM `product` WHERE `product_id`='$product_id'";
		//1. need to get the current vaules and store them
		$sql_select = "SELECT`sum_of_rating`, `no_of_raters` FROM `product` WHERE `product_id`=`$product_id`"
		//store the data into a variable
		//2. update the current data by adding the current entry overall rating in and increase the counter by 1 and store it back
		$sql_update="UPDATE `product` SET UPDATE `product` SET `name`='$entry_name',`manufacturer`='$manufacturer',`packaging_type`='$packaging_type',`sum_of_rating`='$New_sum_of_rating',`no_of_raters`='$New_no_of_raters' WHERE `product_id`='$product_id'";
		//(if result is null);store '0'it to a set of variable, else store the result into the same set of variable for later use



		if ($result = mysqli_query($GLOBALS['con'], $sql_select)) { //SQL (grammar) is correctly executed
				$New_sum_of_rating = $result[0] +$sum_of_rating; //current sum_of_rating + new entry rating
				$New_no_of_raters= $result[1]+1;				//current no_of_rater ++;
				var_dump($New_sum_of_rating);
				var_dump($New_no_of_raters);
				var_dump($result);
				if ($result = mysqli_query($GLOBALS['con'], $sql_update)) {
					$result = mysqli_query($GLOBALS['con'], $sql_selectAll);
					echo _response($resultArray[0],201);
					mysqli_free_result($result);
				}
				else{
					echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
				}
		}
		else{
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}

*/
//below are the overall ending
}

?>