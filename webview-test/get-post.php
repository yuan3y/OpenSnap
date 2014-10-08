<?php
$data = http_build_query(array(
    'param1' => 'data1',
    'param2' => 'data2'
));

// Create HTTP stream context
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $data
    )
));

// Make POST request
$response = file_get_contents('http://example.com', false, $context);
?>