<?php
require 'base.php'; //this has to be the 1st in the list of require/include statements.
require "toro.php"; //this has to be the 2nd in the list of require/include statements.
include "handlers/imagehandler.php";
include "handlers/entrieshandler.php";
include "handlers/entryhandler.php";
include "handlers/loginhandler.php";
include "handlers/producthandler.php";
include "handlers/userhandler.php";
include "handlers/usershandler.php";
//include "handlers/entrieshandler1.php"; //<---test class
 
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
	 "/entries/" => "EntryHandler",
	 "/entries/:number" => "EntriesHandler",
	 "/entries/:number/image/" => "ImageHandler",
	 "/journals/" => "EntriesHandler1" //<-- test handler. same as entries handler BOTH STILL cause the index to go error

));

mysqli_close($con);
?>