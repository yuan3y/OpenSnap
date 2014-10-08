<?php
$method = 'POST';
$url = 'http://localhost/users/';
$data = http_build_query(array(
    'email' => 'getpost3@example.com', 
    'password' => 'getpost3', 
    'name' => 'GetPost', 
    'gender' => '0', 
    'age' => '29'
)
);

$response = '';
// Create HTTP stream context
if ($method == 'POST'){
$context = stream_context_create(array(
    'http' => array(
        'method' => "$method",
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $data)
    )
);
$response = file_get_contents($url, false, $context);
}
else {
	$queryString = http_build_query($data, '', '&');
	$response = file_get_contents($url."?".$data, false);
}
// Make POST request
echo $response;
?>