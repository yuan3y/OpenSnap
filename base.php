<?php

$DEBUG=false;

class ArrayValue implements JsonSerializable {
	public function __construct(array $array) {
		$this->array = $array;
	}
	public function jsonSerialize() {
		return $this->array;
	}
}

function sanitize($data)
{
    mysqli_real_escape_string($GLOBALS['con'], $data);
    return $data;
}

//$GLOBALS['con']=mysqli_connect("localhost","root","","php54");
$con=mysqli_connect("$OPENSHIFT_MYSQL_DB_HOST:$OPENSHIFT_MYSQL_DB_PORT","adminstzRqnc","uAs_UVmwpm7p","php54");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


function _response($data, $status = 200) {
	header("HTTP/1.1 " . $status . " " . _requestStatus($status));
	return json_encode($data);
}

function _cleanInputs($data) {
	$clean_input = Array();
	if (is_array($data)) {
		foreach ($data as $k => $v) {
			$clean_input[$k] = _cleanInputs($v);
		}
	} else {
		$clean_input = trim(strip_tags($data));
	}
	return $clean_input;
}

function _requestStatus($code) {
	$status = array(  
		200 => 'OK',
		404 => 'Not Found',   
		405 => 'Method Not Allowed',
		500 => 'Internal Server Error',
		); 
	return ($status[$code])?$status[$code]:$status[500]; 
}
?>