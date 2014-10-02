<?php




			$sql = "UPDATE  `product` SET  `no_of_raters` = ( SELECT COUNT( * ) AS cnt
FROM  `entry` 
WHERE  `product_id` =  '$product_id' ) ,  `avg_rating` = ( 
SELECT AVG(  `entry`.`rating_overall` ) 
FROM entry
WHERE (
`entry`.`product_id` =  '$product_id'
) ) 
WHERE  `product_id` =  '$product_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}










?>

