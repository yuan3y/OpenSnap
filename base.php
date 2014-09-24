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
//$con=mysqli_connect("$OPENSHIFT_MYSQL_DB_HOST:$OPENSHIFT_MYSQL_DB_PORT","adminstzRqnc","uAs_UVmwpm7p","php54");
$con=mysqli_connect("127.6.113.130:3306","adminstzRqnc","uAs_UVmwpm7p","php54");

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
/*		200 => 'OK',
		404 => 'Not Found',   
		405 => 'Method Not Allowed',
		500 => 'Internal Server Error',*/
		200 =>	'OK',
201 =>	'Created',
202 =>	'Accepted',
203 =>	'Not authoritative',
204 =>	'No content',
//205 =>	'Reset',
//206 =>	'Partial',
//300 =>	'Multiple choices',
//301 =>	'Moved permanently',
//302 =>	'Moved temporarily',
//303 =>	'See other',
//304 =>	'Not modified',
//305 =>	'Use proxy.',
400 =>	'Bad Request',
401 =>	'Unauthorized',
//402 =>	'Payment required',
//403 =>	'Forbidden',
404 =>	'Not found',
405 =>	'Bad Method', //e.g. POST method only, but received an GET method
406 =>	'Not acceptable',
//407 =>	'Proxy authentication required',
408 =>	'Client Timeout',
409 =>	'Conflict',
410 =>	'Gone',
411 =>	'Length required',
412 =>	'Precondition failed',
413 =>	'Entity too large',
414 =>	'Request too long',
415 =>	'Unsupported type',
500 =>	'Internal error',
501 =>	'Not implemented',
502 =>	'Bad Gateway',
503 =>	'Unavailable',
504 =>	'Gateway timeout',
505 =>	'Version not supported'
		); 
	return ($status[$code])?$status[$code]:$status[500]; 
}
?>