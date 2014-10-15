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
	function post($user_id) {
		$_POST = _set_default('password');
		$old_password 	= sanitize($_POST["old_password"]);
		$email 		= sanitize($_POST["email"]);
		$password 	= sanitize($_POST["password"]);
		if (empty($password)) $password=$old_password;
		$name 		= sanitize($_POST["name"]);
		$gender 	= sanitize($_POST["gender"]);
		$age 		= sanitize($_POST["age"]);
		$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM user WHERE ((`user`.`email` = '$email') AND (`user`.`password` = '$old_password'))";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(array("error"=>"Invalid old password "),404);
				}
			else{
				$sql = "UPDATE `user` SET `user_id`='$user_id',`email`='$email',`password`='$password',`name`='$name',`gender`='$gender', `age`='$age' WHERE `user_id`='$user_id'";
				if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);
				if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
					$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM user WHERE (`user`.`user_id` = '$user_id')";
					if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);
					if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
						$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
						if (empty($resultArray)){ 
							echo _response(array("error"=>"unable to get the updated user, error"),406);
						}
						else{
							echo _response($resultArray[0],201);
							mysqli_free_result($result);
						}
					}
					else{ //SQL (grammar) has error
						echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
					}
				}
				else {
					echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
				}
				//echo _response($resultArray[0],200);
				//old_password is correct
				mysqli_free_result($result);
			}
		}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
		
		
						
	}
	function put($user_id) {
	}
	function delete($user_id) {
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