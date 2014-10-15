<?php
function CreateTableFromJson($objArray) {
    // has passed in array has already been deserialized
    $array = json_decode($objArray);
    //var_dump($array);
    $str = '<table id="browse" class="tableNormal">';
    $str .= '<tr>';
    $header = ["Barcode", "Product Name", "Manufactuer", "Packaging Type", "Image", "Number of Raters", "Average Rating"];
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

function addimghtml($workingArray) {
	for ($i=0;$i<sizeof($workingArray);$i++) {
		if (!empty($workingArray[$i]['image'])) $workingArray[$i]['image'] = "<img class=\"effectfront\" src=\"/".$workingArray[$i]['image']."\" height = \"200px\" width = \"200px\" />";
	}
	return $workingArray;
}

function ratingrounding($workingArray) {
	for ($i=0;$i<sizeof($workingArray);$i++) {
		if (!empty($workingArray[$i]['avg_rating'])) $workingArray[$i]['avg_rating'] = number_format((float)$workingArray[$i]['avg_rating'], 2, '.', '');
	}
	return $workingArray;
}

class BrowseHandler{
	function get() {
		$_GET = _set_default_get('manufacturer','packaging_type','view');
		$manufacturer 	= sanitize($_GET["manufacturer"]);
		$packaging_type 	= sanitize($_GET["packaging_type"]);
		$view 	= sanitize($_GET["view"]);

		if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($user_id);
		
		$sql = "SELECT `product_id`, `name`, `manufacturer`, `packaging_type`, `image`, `no_of_raters`, `avg_rating` FROM `product` WHERE ";
		
		if(empty($manufacturer)) {
			if (empty($packaging_type)) {
				$sql .= "1 ORDER BY  `avg_rating` DESC "; // show all product
			}
			else {
				$sql .= "`packaging_type` = '$packaging_type'"; //has packaging type only
			}
		}
		else {
			if (empty($packaging_type)) {
				$sql .= " `manufacturer` = '$manufacturer'";
			}
			else {
				$sql .= " `packaging_type` = '$packaging_type' AND `manufacturer` = '$manufacturer'";
			}
		}

		if (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG']) var_dump($sql);

		if ($result = mysqli_query($GLOBALS['con'], $sql)) { //SQL (grammar) is correctly executed
			$resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if (empty($resultArray)){
				echo _response((""),200);
			}
			else{
				if (empty($view) || (strtolower($view)=='json')) echo _response($resultArray,200);
				else{
					$resultArray = addimghtml($resultArray);
					$resultArray = ratingrounding($resultArray);
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
<script type='text/javascript' src="/view/tablefilter_all_min.js"></script>
STR1;
echo CreateTableFromJson(json_encode($resultArray));
echo <<<STR2
<script type="text/javascript">
var table3_Props = {
    col_0: "none",
    col_1: "none", //"checklist",
    col_2: "multiple",
    col_3: "multiple",
    display_all_text: "[Show All]",
    col_4: "none",
    col_5: "none", //"select",
    col_6: "none", //"select",
    sort_select: true
};
var tf3 = setFilterGrid("browse", table3_Props);
</script>
</body></html>
STR2;
				}
				mysqli_free_result($result);
				}
			}
		else{ //SQL (grammar) has error
			echo _response(array("error"=>mysqli_error($GLOBALS['con'])),500);
		}
	}
}
?>