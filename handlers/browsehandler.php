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
table, th, td{
    border : 1px solid black;
}
.alt {
    background-color: #BBC;
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
	col_0: "select",
	col_1: "checklist",
    col_2: "multiple",
    col_3: "multiple",
    display_all_text: "[Show All]",
    col_4: "none",
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