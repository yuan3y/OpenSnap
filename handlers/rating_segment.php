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


$sql_delete = "DELETE FROM  `product` WHERE  `no_of_raters` =0 AND  `avg_rating` =0";


		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			
			mysqli_query($GLOBALS['con'], $sql_delete);// do system clean up, delete product that have 0 raters and 0 rating.

		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}










?>

