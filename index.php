<?php
require 'base.php';
require("toro.php");
require("handlers/journalhandler.php");
require("handlers/loginhandler.php");
require("handlers/producthandler.php");
require("handlers/userhandler.php");
//this is added

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
    "/users/:number" => "UserHandler",
	
	
	//CM ADD LINES FOR additional handlers
	 "/checklogin/" => "LoginHandler",
	 "/products/" => "ProductsHandler",
	 "/products/:number" => "ProductsHandler",
	 "/journals/" => "JournalsHandler",
	 "/journal/:number" => "JournalsHandler"
));

?>