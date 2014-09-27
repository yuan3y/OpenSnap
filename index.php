<?php
require 'base.php'; //this has to be the 1st in the list of require/include statements.
require "toro.php"; //this has to be the 2nd in the list of require/include statements.
//include "handlers/imagehandler.php";
include "handlers/entrieshandler.php";
include "handlers/entryhandler.php";
include "handlers/loginhandler.php";
include "handlers/producthandler.php";
include "handlers/userhandler.php";
include "handlers/usershandler.php";
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
	"/entries/:number" => "EntriesHandler", //<--CM, pls remove this line --YY>
	"/users/:number/entries/" = > "EntriesHandler", //<-- this is what u meant to have get($user_id) in EntriesHandler class
	"/entries/:number/image/" => "ImageHandler",
	"/journals/" => "EntriesHandler1" //<-- test handler. same as entries handler BOTH STILL cause the index to go error

));

mysqli_close($con);
?>