<?php
class UserHandler {
	function get($user_id) {
		if (!empty($user_id)){
			$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM `user` WHERE `user_id`='$user_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) {
				echo _response(mysqli_fetch_all($result,MYSQLI_ASSOC)[0]);
				mysqli_free_result($result);
			}
			else {
				echo _response(array("error"=>mysqli_error($GLOBALS['con'])),404);
			}
		}
	}
	function post() {
		$email 		= sanitize($_POST["email"]);
		$password 	= sanitize($_POST["password"]);
		$name 		= sanitize($_POST["name"]);
		$gender 	= sanitize($_POST["gender"]);
		$age 		= sanitize($_POST["age"]);
		$sql = "INSERT INTO `php54`.`user` (`user_id`, `email`, `password`, `name`, `gender`, `age`) VALUES (NULL, '$email', '$password', '$name', '$gender', '$age');";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM `user` WHERE `email`='$email'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) {
				echo _response(mysqli_fetch_all($result,MYSQLI_ASSOC)[0],201);
				mysqli_free_result($result);
			}
		}
		else {
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),404);
		}
	}
	function put($user_id) {
		/*parse_str(file_get_contents("php://input"),$post_vars);
		var_dump($post_vars);
		$post_vars = (object)$post_vars;
		var_dump($post_vars);
*/
		echo $_SERVER['REQUEST_METHOD'];
		$putdata = fopen("php://input", "r");
		echo fread($putdata,8192);
		/*parse_str(file_get_contents("php://input"),$post_vars);
		$password 	= sanitize($post_vars["password"]);
		$name 		= sanitize($post_vars["name"]);
		$gender 	= sanitize($post_vars["gender"]);
		$age 		= sanitize($post_varsT["age"]);
		$sql = "UPDATE `php54`.`user` (`user_id`, `password`, `name`, `gender`, `age`) VALUES ('$user_id', '$password', '$name', '$gender', '$age') WHERE `user_id`='$user_id';";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM `user` WHERE `user_id`='$user_id'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) {
				echo _response(mysqli_fetch_all($result,MYSQLI_ASSOC)[0],201);
				mysqli_free_result($result);
			}
		}
		else {
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),422);
		}*/
	}
	function delete() {
		$user_id 	= sanitize($_REQUEST["user_id"]);
		$sql = "DELETE FROM `php54`.`user` WHERE `user`.`user_id` = $user_id;";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			echo _response("",204);
			mysqli_free_result($result);
		}
	}
}

?>