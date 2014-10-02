<?php


	function New_Product_Rating_Changer(){ // will do the update of overall rating and counter for product
		//will need to ->>sum_of_rating +=user rating, no_of_raters++;

		//1. need to get the current vaules and store them
		$sql = "SELECT`sum_of_rating`, `no_of_raters` FROM `product` WHERE `product_id`=`$product_id`";
		//store the data into a variable
		//2. update the current data by adding the current entry overall rating in and increase the counter by 1 and store it back
		//$sql="UPDATE `product` SET `sum_of_rating`='',`no_of_raters`='' WHERE `product_id`='$product_id'";

	}

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


$sql_overall_rating_in_product="UPDATE `product` SET `avg_rating`=(SELECT AVG(`entry`.`rating_overall`)
FROM entry
WHERE (`entry`.`product_id` = 1234567890)) WHERE (`product`.`product_id` = 1234567890)";



$sql_total_no_of_rater = "
SELECT COUNT(*) AS cnt FROM `entry` WHERE `product_id`='1234567890'";

		//(if result is null);store '0'it to a set of variable, else store the result into the same set of variable for later use



		if ($result = mysqli_query($GLOBALS['con'], $sql_select)) { //SQL (grammar) is correctly executed
				var_dump($result);
				//$New_sum_of_rating = $result[0] +$sum_of_rating; //current sum_of_rating + new entry rating
				//$New_no_of_raters= $result[1]+1;				//current no_of_rater ++;
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

?>

