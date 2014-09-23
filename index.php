<?php
require 'base.php';
require("toro.php");

class UsersHandler {
	function get($user_id) {
		$sql = "SELECT `user_id`, `email`, `name`, `gender`, `age` FROM `user` WHERE `user_id`='$user_id'";
		if ($result = mysqli_query($GLOBALS['con'], $sql)) {
			//echo json_encode(new ArrayValue(mysqli_fetch_all($result)), JSON_PRETTY_PRINT);
			echo _response(new ArrayValue(mysqli_fetch_all($result)));
			mysqli_free_result($result);
		}
	}
	function post() {
		$email 		= sanitize($_POST["email"]);
		$password 	= sanitize($_POST["password"]);
		$name 		= sanitize($_POST["name"]);
		$gender 	= sanitize($_POST["gender"]);
		$age 		= sanitize($_POST["age"]);
		$sql = "INSERT INTO `php54`.`user` (`user_id`, `email`, `password`, `name`, `gender`, `age`) VALUES (NULL, '$email', '$password', '$name', '$gender', '$age');";
		//$sql = "INSERT INTO `php54`.`user` (`email`, `password`, `name`, `gender`, `age`) VALUES ('$email', '$password', '$name', '$gender', '$age');";
		var_dump($sql);
		$result = mysqli_query($GLOBALS['con'], $sql);
		$a = $result;
		//if ($a) {
		//	echo json_encode(new ArrayValue(mysqli_fetch_all($result)), JSON_PRETTY_PRINT);
		//	mysqli_free_result($result);
		//	print("done");
		//} else {
		//	die('Error: ' . mysqli_error($GLOBALS['con']));
		//}
		var_dump($result);
		echo _response(new ArrayValue(mysqli_fetch_all($result)));
	}
	function delete() {
		$user_id 	= sanitize($_REQUEST["user_id"]);
		$sql = "DELETE FROM `php54`.`user` WHERE `user`.`user_id` = $user_id;";
	}
}

class HelloHandler {
    function get() {
		echo 'Hello World!!!';
    }
}

class TestHandler {
	function get() {
		echo '[["11","admin@example.com","admin","Admin Aplus","0","21"],["12","admin@example.com","admin","Admin Aplus","0","21"]]';
	}
	function post() {
		echo '[["11","admin@example.com","admin","Admin Aplus","0","21"],["12","admin@example.com","admin","Admin Aplus","0","21"]]';
	}
}

Toro::serve(array(
    "/" => "HelloHandler",
    "/test/" => "TestHandler",
    "/users/" => "UsersHandler",
    "/users/:number" => "UsersHandler"
));

?>