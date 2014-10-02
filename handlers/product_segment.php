<?php

$sql = "SELECT COUNT(*) AS cnt FROM `product` WHERE `product_id`='$product_id'";//>>>check whether existing product exist<<<
if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) echo "product segment started";
if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
	$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
	if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($resultArray[0]['cnt']);
	if ($resultArray[0]['cnt']==0){//>>>insert product<<<
		$sql = "INSERT IGNORE INTO `php54`.`product` (`product_id`,`name`,`manufacturer`,`packaging_type`) VALUES ('$product_id', '$entry_name', '$manufacturer', '$packaging_type')";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			/*if ($result){
				$sql = "SELECT `product_id`,`name`,`manufacturer`,`packaging_type`,`image`,`sum_of_rating`,`no_of_raters`,`avg_rating`FROM `product` WHERE `product_id`='$product_id'";
				if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
					$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
					if (empty($resultArray)){ 
						echo _response(array("error"=>"product does not exist, error, please check."),406);
					} 
					else{
						//echo _response($resultArray[0],201);
						//$responseArray[] = $resultArray[0];
						mysqli_free_result($result);
					}
				}
				else{ //SQL (grammar) has error
					echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
				}*/
			}
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}
	else {//>>>Handles update product<<<
		$sql = "UPDATE `product` SET `name`='$entry_name',`manufacturer`='$manufacturer',`packaging_type`='$packaging_type' WHERE `product_id`='$product_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			if ($result){
				/*$sql = "SELECT `product_id`,`name`,`manufacturer`,`packaging_type`,`image`,`sum_of_rating`,`no_of_raters`,`avg_rating`FROM `product` WHERE `product_id`='$product_id'";
				if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
					$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
					if (empty($resultArray)){ 
						echo _response(array("error"=>"unable to insert the product, error"),406);
					}
					else{
						//echo _response($resultArray[0],201);
						$responseArray[] = $resultArray[0];
						mysqli_free_result($result);
					}
				}
				else{ //SQL (grammar) has error
					echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
				}*/
			}
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}
}
?>

