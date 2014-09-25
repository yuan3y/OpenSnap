<?php
require 'base.php';
require("toro.php");
require("handlers/imagehandler.php");
require("handlers/entryhandler.php");
require("handlers/entrieshandler.php");
require("handlers/loginhandler.php");
require("handlers/producthandler.php");
require("handlers/userhandler.php");
require("handlers/usershandler.php");
//this is added
 
class HelloHandler {
    function get() {
		echo 'Hello World!!!';
    }
}

class TestHandler {
	function get($id) {
		echo $id;
		echo ' captured';
	}
	function post() {
		echo 'post method';
	}
}

Toro::serve(array(
    "/" => "HelloHandler",
    "/test/" => "TestHandler",
    "/users/" => "UsersHandler",
    "/users/:number" => "UserHandler",
	
	
	//CM ADD LINES FOR additional handlers
	 "/checklogin/" => "LoginHandler",
	 "/products/" => "ProductsHandler",
	 "/products/:number" => "ProductsHandler",
	 "/entries/" => "EntryHandler",
	 "/images/" => "ImageHandler",
	 "/users/:number/entries/" => "TestHandler"
));

?>