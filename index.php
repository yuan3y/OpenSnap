<?php
require 'base.php'; //this has to be the 1st in the list of require/include statements.
require_once "toro.php"; //this has to be the 2nd in the list of require/include statements.
include "handlers/imagehandler.php";
include "handlers/entrieshandler.php";
include "handlers/entryhandler.php";
include "handlers/loginhandler.php";
include "handlers/userhandler.php";
include "handlers/usershandler.php";
include "handlers/deletehandler.php";
include "handlers/browsehandler.php";
include "handlers/hellohandler.php"; 
include "handlers/testhandler.php";
include "handlers/aggregatehandler.php";

Toro::serve(array(
	"/" => "HelloHandler",
	"/test/" => "HelloHandler",
	"/test/:number" => "TestHandler",
//--------------------------------------
	"/users/" => "UsersHandler",
	"/users/:number" => "UserHandler",
	"/checklogin/" => "LoginHandler",
	"/entries/" => "EntryHandler",
	"/users/:number/entries/" => "EntriesHandler",
	"/entries/:number/image/" => "ImageHandler",
	"/entries/:number/delete/" => "DeleteHandler",
	"/browse/" => "BrowseHandler",
	"/product/:number" => "AggregateHandler"

));

mysqli_close($con);
?>