<?php
class ProductsHandler {
	function get($product_id) {
		
		$sql = "SELECT `product_id`,`name`,`manufacturer`,`packaging_type`,`image`,`sum_of_rating`,`no_of_raters`,`avg_rating`FROM `product` WHERE `product_id`='$product_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			echo _response(mysqli_fetch_all($result,MYSQLI_ASSOC)[0]);
			mysqli_free_result($result);
		}
		else {
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),404);
		}
	}
	function post() {
		$product_id			= sanitize($_POST["product_id"]);
		$name        		= sanitize($_POST["name"]);
		$manufacturer		= sanitize($_POST["manufacturer"]);
		$packaging_type 	= sanitize($_POST["packaging_type"]);
		//$image 				= sanitize($_POST["image"]);                //<--- might have error as it is in blob format
		$sum_of_rating 		= sanitize($_POST["sum_of_rating"]);
		$no_of_raters 		= sanitize($_POST["no_of_raters"]);
		//avg_rating need to be calculated here? or system output
		//$avg_rating   		= $sum_of_rating / $no_of_raters;

		$sql = "SELECT COUNT(*) AS cnt FROM `product` WHERE `product_id`='$product_id'";
				if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
					$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
					if ($resultArray[0]['cnt']==0){//insert product
						$sql = "INSERT IGNORE INTO `php54`.`product` (`product_id`,`name`,`manufacturer`,`packaging_type`,`sum_of_rating`,`no_of_raters`) VALUES ('$product_id', '$name', '$manufacturer', '$packaging_type', '$sum_of_rating','$no_of_raters')";
						if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
							if ($result){
								$sql = "SELECT `product_id`,`name`,`manufacturer`,`packaging_type`,`image`,`sum_of_rating`,`no_of_raters`,`avg_rating`FROM `product` WHERE `product_id`='$product_id'";
								if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
									$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
									if (empty($resultArray)){ 
										echo _response(array("error"=>"product does not exist, error, please check."),406);
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
					else {//Handles update product
						$sql = "UPDATE `product` SET `name`='$name',`manufacturer`='$manufacturer',`packaging_type`='$packaging_type',`sum_of_rating`='$sum_of_rating',`no_of_raters`='$no_of_raters' WHERE `product_id`='$product_id'";
						if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
							if ($result){
								$sql = "SELECT `product_id`,`name`,`manufacturer`,`packaging_type`,`image`,`sum_of_rating`,`no_of_raters`,`avg_rating`FROM `product` WHERE `product_id`='$product_id'";
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
		}

		//`avg_rating` not added in the follwoing SQL
		/*
		$sql = "INSERT IGNORE INTO `php54`.`product` (`product_id`,`name`,`manufacturer`,`packaging_type`,`sum_of_rating`,`no_of_raters`) VALUES ('$product_id', '$name', '$manufacturer', '$packaging_type', '$sum_of_rating','$no_of_raters')";
		
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			$sql = $sql = "SELECT `product_id`,`name`,`manufacturer`,`packaging_type`,`image`,`sum_of_rating`,`no_of_raters`,`avg_rating`FROM `product` WHERE `product_id`='$product_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) {
				echo _response(mysqli_fetch_all($result,MYSQLI_ASSOC)[0],201);
				mysqli_free_result($result);
			}
		}
		else {
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),422);
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


?>

