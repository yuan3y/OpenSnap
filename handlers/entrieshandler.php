<?php
class EntriesHandler{
	function get($user_id) {
		echo "get success";
	}

	function post($user_id) { // for user journal feed
		//$user_id 		= sanitize($_POST["user_id"]);
		if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($user_id);


		//$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id'";
		//$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `entry_name`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id'";
		//$sql ="SELECT * FROM `entry` WHERE `user_id`=`$user_id`";
		//$sql = "SELECT `entry_id`, `user_id`, `product_id`, `timestamp`, `image`, `entry_name`, `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` WHERE `user_id`='$user_id'ORDER BY `entry_id` DESC";
		//$sql="SELECT `entry_id` ,  `user_id` ,  `product_id` ,  `timestamp` ,  `image` ,  `name` ,  `rating_ease` ,  `rating_safety` ,  `rating_reseal` , `rating_overall` ,  `comment` FROM  `entry` WHERE  `user_id` = '2'ORDER BY  `timestamp` DESC ";
		$sql = "SELECT `entry_id`, `user_id`, `entry`.`product_id`, `timestamp`, `entry`.`image`,`entry`.`name`, `manufacturer`, `packaging_type`,  `rating_ease`, `rating_safety`, `rating_reseal`, `rating_overall`, `comment` FROM `entry` INNER JOIN `product` ON `entry`.`product_id` = `product`.`product_id` WHERE `user_id`='$user_id' ";
		if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);

		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response((""),200);
			}
			else{
				echo _response($resultArray,200);
				mysqli_free_result($result);
				}
			}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}
}
?>