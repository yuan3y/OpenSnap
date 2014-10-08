<?php
class BrowseHandler{
	function get() {
		$_GET = _set_default_get('manufacturer','packaging_type','view');
		$manufacturer 	= sanitize($_GET["manufacturer"]);
		$packaging_type 	= sanitize($_GET["packaging_type"]);
		$view 	= sanitize($_GET["view"]);

		if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($user_id);
		
		$sql = "SELECT `product_id`, `name`, `manufacturer`, `packaging_type`, `image`, `no_of_raters`, `avg_rating` FROM `product` WHERE ";
		
		if(empty($manufacturer)) {
			if (empty($packaging_type)) {
				$sql .= "1 ORDER BY  `avg_rating` DESC "; // show all product
			}
			else {
				$sql .= "`packaging_type` = '$packaging_type'"; //has packaging type only
			}
		}
		else {
			if (empty($packaging_type)) {
				$sql .= " `manufacturer` = '$manufacturer'";
			}
			else {
				$sql .= " `packaging_type` = '$packaging_type' AND `manufacturer` = '$manufacturer'";
			}
		}

		if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);

		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response((""),200);
			}
			else{
				if (empty($view)) echo _response($resultArray,200);
				else var_dump($resultArray);
				mysqli_free_result($result);
				}
			}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}
}
?>