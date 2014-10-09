<?php
class HelloHandler {
	function get() {
		echo <<<STR1
<!DOCTYPE HTML>
<html>
<head>
<title>OpenSnap Live Demo Site</title>
</head>
<body>
<h1>Hello World!!!(get)</h1>
<p>Welcome to OpenSnap live demo site!</p>
<p>For more info please proceed to <a href="https://github.com/yuan3y/OpenSnap">Our Github Page</a><br />
Our API reference: <a href="https://github.com/yuan3y/OpenSnap/blob/master/API%20Usage.md">OpenSnap API Usage</a><br />
<a href="/LICENSE.MD">Our Source Code Licence</a></p>
<p>You are licensed to fork our webend source-code from Github, however, you are <b>NOT</b> allowed to incorporate this live site directly in your project.</p>
<br/>
<p>You can try POST request to this page to test <br />
as well as GET and POST <a href="http://$_SERVER[SERVER_NAME]/test/123">http://$_SERVER[SERVER_NAME]/test/123</a>
</p>
</body>
</html>
STR1;
	}
	function post() {
		echo 'Hello World!!!(post)';
	}
}
?>