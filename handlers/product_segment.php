<?php



$sql = "SELECT COUNT(*) AS cnt FROM `product` WHERE `product_id`='$product_id'";//>>>check whether existing product exist<<<
if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
	$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
	if ($resultArray[0]['cnt']==0){//>>>insert product<<<
		$sql = "INSERT IGNORE INTO `php54`.`product` (`product_id`,`name`,`manufacturer`,`packaging_type`) VALUES ('$product_id', '$name', '$manufacturer', '$packaging_type')";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			if ($result){
				$sql = "SELECT `product_id`,`name`,`manufacturer`,`packaging_type`,`image`,`sum_of_rating`,`no_of_raters`,`avg_rating`FROM `product` WHERE `product_id`='$product_id'";
				if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
					$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
					if (empty($resultArray)){ 
						echo _response(array("error"=>"product does not exist, error, please check."),406);
					} 
					else{
						//echo _response($resultArray[0],201);
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
	else {//>>>Handles update product<<<
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
						//echo _response($resultArray[0],201);
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
}
?>

