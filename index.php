<?php
require 'base.php'; //this has to be the 1st in the list of require/include statements.
require_once "toro.php"; //this has to be the 2nd in the list of require/include statements.
include "handlers/imagehandler.php";
include "handlers/entrieshandler.php";
include "handlers/entryhandler.php";
include "handlers/loginhandler.php";
include "handlers/producthandler.php";
include "handlers/userhandler.php";
include "handlers/usershandler.php";
include "handlers/deletehandler.php";
//include "handlers/entrieshandler1.php"; //<---test class
 
class HelloHandler {
	function get() {
		echo 'Hello World!!!(get)';
	}
	function post() {
		echo 'Hello World!!!(post)';
	}
}

class TestHandler {
	function get($id) {
		echo "get $id successful";
	}
	function post($id) {
		echo "post $id successful";
	}
}

Toro::serve(array(
	"/" => "HelloHandler",
	"/test/" => "HelloHandler",
	"/test/:number" => "TestHandler",
//--------------------------------------
	"/users/" => "UsersHandler",
	"/users/:number" => "UserHandler",
	"/checklogin/" => "LoginHandler",
	"/products/" => "ProductsHandler",
	"/products/:number" => "ProductsHandler",
	"/entries/" => "EntryHandler",
	"/users/:number/entries/" => "EntriesHandler",
	"/entries/:number/image/" => "ImageHandler",
	"/entries/:number/delete/" => "DeleteHandler"


));

mysqli_close($con);
?>