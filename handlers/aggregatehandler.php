<?php 
class AggregateHandler{
	function CreateTableJson($objArray) {
    // has passed in array has already been deserialized
    $array = json_decode($objArray);
    //var_dump($array);
    $str = '<table id="browse" class="tableNormal">';
    $str .= '<tr>';
    $header = array('Age Group','Ease of Opening','Safety of Packaging','Resealability of Packaging','Overall Rating');
    foreach ($header as $title) {
    	$str.= '<th scope="col">'.$title.'</th>';
    }
    $str.='</tr>';
    /*foreach ($array[0] as $key => $index) {
        $str .= '<th scope="col">' . $index . '</th>';
        //echo "$key => $index \n";
    }
    $str .= '</tr>';*/
    $str .= '<tbody>';
    for ($i = 0; $i < sizeof($array); $i++) {
        $str .= ($i % 2 == 0) ? '<tr class="alt">' : '<tr>';
        foreach ($array[$i] as $key => $index) {
            $str .= '<td>' . $index . '</td>';
        }
        $str .= '</tr>';
    }
    $str .= '</tbody>';
    $str .= '</table>';
    return $str;
	}
	function get($product_id) {
		$_GET = _set_default_get('view');
		$view = sanitize($_GET["view"]);
		if (strtolower($view)=="json")
			$viewInJSON  = true;
		else $viewInJSON = false;
		$responseArray = array();
		$subnull="N/A";
		$titles=array('Age Group','Ease of Opening','Safety of Packaging','Resealability of Packaging','Overall Rating');
		$sql = "SELECT AVG(`entry`.`rating_ease`), AVG(`entry`.`rating_safety`), AVG(`entry`.`rating_reseal`), AVG(`entry`.`rating_overall`) 
		FROM `entry` INNER JOIN `user` ON (`user`.`user_id` = `entry`.`user_id`) WHERE (`entry`.`product_id` = '$product_id' ";
		$result  = mysqli_query($GLOBALS['con'], $sql." AND `user`.`age` <13)");
		//var_dump($result);
		if ($result) {
			$resultArray = mysqli_fetch_all($result, MYSQLI_NUM);
			//var_dump($resultArray[0]);
			$ratings = $resultArray[0];
			if (!$viewInJSON)
				for ($i=0; $i<4; $i++) {
					if (!$ratings[$i]) $ratings[$i]=$subnull;
					else $ratings[$i]=round($ratings[$i] * 1e2)/1e2;
				}
			array_unshift($ratings, "<=12");
			//var_dump($ratings);
			$responseArray[] = array_combine($titles, $ratings);
		}
		else {
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
		$result  = mysqli_query($GLOBALS['con'], $sql." AND `user`.`age` >=13 AND  `user`.`age` <50)");
		//var_dump($result);
		if ($result) {
			$resultArray = mysqli_fetch_all($result, MYSQLI_NUM);
			//var_dump($resultArray[0]);
			$ratings = $resultArray[0];
			if (!$viewInJSON)
			for ($i=0; $i<4; $i++) {
				if (!$ratings[$i]) $ratings[$i]=$subnull;
				else $ratings[$i]=round($ratings[$i] * 1e2)/1e2;
			}
			array_unshift($ratings, "13-49");
			$responseArray[] = array_combine($titles, $ratings);
		}
		else {
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
		$result  = mysqli_query($GLOBALS['con'], $sql." AND `user`.`age` >=50)");
		//var_dump($result);
		if ($result) {
			$resultArray = mysqli_fetch_all($result, MYSQLI_NUM);
			//var_dump($resultArray[0]);
			$ratings = $resultArray[0];
			if (!$viewInJSON)
			for ($i=0; $i<4; $i++) {
				if (!$ratings[$i]) $ratings[$i]=$subnull;
				else $ratings[$i]=round($ratings[$i] * 1e2)/1e2;
			}
			array_unshift($ratings, ">=50");
			$responseArray[] = array_combine($titles, $ratings);
		}
		else {
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}

		if ($viewInJSON)
			echo _response($responseArray,200);
		else {
			echo <<<STR1
<!DOCTYPE HTML>
<html>
<head>
<style>
table a:link {
	color: #666;
	font-weight: bold;
	text-decoration:none;
}
table a:visited {
	color: #999999;
	font-weight:bold;
	text-decoration:none;
}
table a:active,
table a:hover {
	color: #bd5a35;
	text-decoration:underline;
}
table {
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:12px;
	text-shadow: 1px 1px 0px #fff;
	background:#eaebec;
	margin:20px;
	border:#ccc 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
table th {
	padding:21px 25px 22px 25px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;

	background: #ededed;
	background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
	background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
}
table th:first-child {
	text-align: left;
	padding-left:20px;
}
table tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
table tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
table tr {
	text-align: center;
	padding-left:20px;
}
table td:first-child {
	text-align: left;
	padding-left:20px;
	border-left: 0;
}
table td {
	padding:18px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;

	background: #fafafa;
	background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
	background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
}
table tr.even td {
	background: #f6f6f6;
	background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
	background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
}
table tr:last-child td {
	border-bottom:0;
}
table tr:last-child td:first-child {
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;
	border-bottom-left-radius:3px;
}
table tr:last-child td:last-child {
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;
	border-bottom-right-radius:3px;
}
table tr:hover td {
	background: #f2f2f2;
	background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
	background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
}
.effectfront {
  border: none;
  margin: 0 auto;
}
.effectfront:hover {
  -webkit-transform: scale(2);
  -moz-transform: scale(2);
  -o-transform: scale(2);
  transform: scale(2);
  transition: all 0.2s;
  -webkit-transition: all 0.2s;
}
</style>
<link rel="stylesheet" type="text/css" href="/view/filtergrid.css" />
</head>
<body>
STR1;
echo AggregateHandler::CreateTableJson(json_encode($responseArray));
echo <<<STR2

</body></html>
STR2;
		}
	}

}

?>	