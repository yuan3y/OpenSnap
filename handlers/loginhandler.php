<?php
class LoginHandler {
	function get() {
		echo "hereGet";
		$email 		= sanitize($_GET["email"]);
		$password 	= sanitize($_GET["password"]);// no password
		$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM user WHERE ((`user`.`email` = '$email') AND (`user`.`password` = '$password'))";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			//add if result = null
			if (!empty($result)){
				echo _response(array("error"=>"login does not match , error"),404);
				}
			else{
				echo _response(mysqli_fetch_all($result,MYSQLI_ASSOC)[0],200);
				mysqli_free_result($result);
			}
		}
	}
	
	
	
	function post() {
		echo "herePost";
		$email 		= sanitize($_POST["email"]);
		$password 	= sanitize($_POST["password"]);// no password
		$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM user WHERE ((`user`.`email` = '$email') AND (`user`.`password` = '$password'))";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			//add if result = null
			echo "here1";
			if (!empty($result)){
				echo "here2";
				echo _response(array("error"=>"login does not match , error"),404);
				}
			else{
				echo "here2 else";
				echo _response(mysqli_fetch_all($result,MYSQLI_ASSOC)[0],200);
				mysqli_free_result($result);
			}
		}
		else{
			echo "here else1";
		}/*
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
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),422);
		}*/
	}
	/*
	function delete() {
		$user_id 	= sanitize($_REQUEST["user_id"]);
		$sql = "DELETE FROM `php54`.`user` WHERE `user`.`user_id` = $user_id;";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			echo _response("",204);
			mysqli_free_result($result);
		}
	}
	*/
}

?>