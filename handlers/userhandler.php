<?php
class UserHandler {
	function get($user_id) {
		$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM `user` WHERE `user_id`='$user_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(array("error"=>"user does not exist , error"),404);
			}
			else{
				echo _response($resultArray[0],200);
				mysqli_free_result($result);
			}
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}
	function put($user_id) {
	}
	function delete() {
		$user_id 	= sanitize($_REQUEST["user_id"]);
		$sql = "DELETE FROM `php54`.`user` WHERE `user`.`user_id` = $user_id;";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			echo _response(array("success"=>"deleted $user_id"),204);
			mysqli_free_result($result);
		}	
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}
}

?>