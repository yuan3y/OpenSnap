<?php
class BrowseHandler{
	function get() {
		$_GET = _set_default('manufacturer','packaging_type');
		$manufacturer 	= sanitize($_GET["manufacturer"]);
		$packaging_type 	= sanitize($_GET["packaging_type"]);

		if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($user_id);
		
		$sql = "SELECT `product_id`, `name`, `manufacturer`, `packaging_type`, `image`, `no_of_raters`, `avg_rating` FROM `product` WHERE";
		
		if(empty($manufacturer) && empty($packaging_type)) {
			echo "we are here";
			$sql .= " 1 ORDER BY `product_id`"; // show all product
		}
		else
		{
			echo "we are not here";
			var_dump($manufacturer);
			var_dump($packaging_type);
		}

		/* if ($manufacturer=="" && $packaging_type!=""){
			$sql += " ";
		}*/









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