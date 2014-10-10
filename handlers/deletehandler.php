<?php
class DeleteHandler{
	function get($entry_id) {
		$result_array = null;
		echo _response($result_array,201);
	}


	function post($entry_id) {
		$product_id		= sanitize($_POST["product_id"]);
		$sql = "DELETE FROM `entry` WHERE `entry_id`='$entry_id'";
		//var_dump($sql);
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			//$GLOBALS['DEBUG']=true;
			include "rating_segment.php";
			echo _response(array("success"=>"entry  $entry_id has been successfully deleleted"),202);
			//echo _response(array("error"=>"entry  $entry_id has been successfully deleleted"),204);
			//mysqli_free_result($result);
		}	
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}



}
?>