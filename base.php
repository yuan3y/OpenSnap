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
    /*$data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);*/
    mysqli_real_escape_string($GLOBALS['con'], $data);
    return $data;
}


$con=mysqli_connect("$OPENSHIFT_MYSQL_DB_HOST:$OPENSHIFT_MYSQL_DB_PORT","adminstzRqnc","uAs_UVmwpm7p","php54");
// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>