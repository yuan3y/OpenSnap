<?php
class UsersHandler {
	function get(){
		$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM `user` WHERE 1";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response(array("error"=>"user does not exist , error"),404);
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
	function post() {
		$email 		= sanitize($_POST["email"]);
		$password 	= sanitize($_POST["password"]);
		$name 		= sanitize($_POST["name"]);
		$gender 	= sanitize($_POST["gender"]);
		$age 		= sanitize($_POST["age"]);
		$sql = "INSERT INTO `php54`.`user` (`user_id`, `email`, `password`, `name`, `gender`, `age`) VALUES (NULL, '$email', '$password', '$name', '$gender', '$age');";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM `user` WHERE `email`='$email'";
			if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
				$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
				if (empty($resultArray)){
					echo _response(array("error"=>"user does not exist , error"),404);
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
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}
}
?>