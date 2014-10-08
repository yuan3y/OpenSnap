<!DOCTYPE HTML>
<html>
<body>
<!--<script>
var json_string = '[{"entry_id":"2","user_id":"2","product_id":"8801062636358","timestamp":"2014-10-02 03:52:16","image":"upload\/2_1412236336.jpg","name":"Random Alvin","manufacturer":"Kraft","packaging_type":"Bag","rating_ease":"3","rating_safety":"4","rating_reseal":"2","rating_overall":"3","comment":"Alvin very bad!!!"},{"entry_id":"3","user_id":"2","product_id":"8851019110127","timestamp":"2014-10-02 04:22:32","image":"upload\/3_1412238152.jpg","name":"Pocky Biscuit Sticks","manufacturer":"Nestle","packaging_type":"Box","rating_ease":"5","rating_safety":"3","rating_reseal":"2","rating_overall":"3.3333333333333335","comment":"okay la...."},{"entry_id":"7","user_id":"2","product_id":"8885006000016","timestamp":"2014-10-02 10:38:47","image":"upload\/7_1412260727.jpg","name":"Random Merlion","manufacturer":"Quaker","packaging_type":"Box","rating_ease":"3","rating_safety":"1","rating_reseal":"5","rating_overall":"3","comment":"Not bad?? Lol"},{"entry_id":"8","user_id":"2","product_id":"7622300848668","timestamp":"2014-10-02 10:40:26","image":"upload\/8_1412260826.jpg","name":"Cookie Bus","manufacturer":"Marigold","packaging_type":"Can","rating_ease":"2","rating_safety":"3","rating_reseal":"5","rating_overall":"3.3333333333333335","comment":"Bus... good!"},{"entry_id":"9","user_id":"2","product_id":"3088545004445","timestamp":"2014-10-02 10:44:03","image":"upload\/9_1412261043.jpg","name":"Honey Honey :)","manufacturer":"Kraft","packaging_type":"Bottle","rating_ease":"5","rating_safety":"2","rating_reseal":"3","rating_overall":"3.3333333333333335","comment":"Looks good!"},{"entry_id":"10","user_id":"2","product_id":"93716543","timestamp":"2014-10-02 10:46:06","image":"upload\/10_1412261166.jpg","name":"Red Hot PEPPER","manufacturer":"Nestle","packaging_type":"Bottle","rating_ease":"2","rating_safety":"3","rating_reseal":"2","rating_overall":"2.3333333333333335","comment":"Normal, nothing special."},{"entry_id":"15","user_id":"2","product_id":"8801062267699","timestamp":"2014-10-07 23:37:24","image":"upload\/15_1412739444.jpg","name":"Chocolate Pepero","manufacturer":"Nestle","packaging_type":"Box","rating_ease":"3","rating_safety":"3","rating_reseal":"3","rating_overall":"3","comment":"Good!!!"}]';

function CreateTableFromJson(objArray) {
    // has passed in array has already been deserialized
    var array = typeof  objArray != 'object' ? JSON.parse(objArray) : objArray;

    str = '<table class="tableNormal">';
    str += '<tr>';
    for (var index in array[0]) {
        str += '<th scope="col">' + index + '</th>';
    }
    str += '</tr>';
    str += '<tbody>';
    for (var i = 0; i < array.length; i++) {
        str += (i % 2 == 0) ? '<tr class="alt">' : '<tr>';
        for (var index in array[i]) {
            str += '<td>' + array[i][index] + '</td>';
        }
        str += '</tr>';
    }
    str += '</tbody>'
    str += '</table>';
    return str;
}

document.write(CreateTableFromJson(json_string));
</script>-->
<head>
<style>
table, th, td{
    border : 1px solid black;
}
.alt {
    background-color: #BBC;
}
</style>
</head>
<?php
//$json_string = '[{"entry_id":"2","user_id":"2","product_id":"8801062636358","timestamp":"2014-10-02 03:52:16","image":"upload\/2_1412236336.jpg","name":"Random Alvin","manufacturer":"Kraft","packaging_type":"Bag","rating_ease":"3","rating_safety":"4","rating_reseal":"2","rating_overall":"3","comment":"Alvin very bad!!!"},{"entry_id":"3","user_id":"2","product_id":"8851019110127","timestamp":"2014-10-02 04:22:32","image":"upload\/3_1412238152.jpg","name":"Pocky Biscuit Sticks","manufacturer":"Nestle","packaging_type":"Box","rating_ease":"5","rating_safety":"3","rating_reseal":"2","rating_overall":"3.3333333333333335","comment":"okay la...."},{"entry_id":"7","user_id":"2","product_id":"8885006000016","timestamp":"2014-10-02 10:38:47","image":"upload\/7_1412260727.jpg","name":"Random Merlion","manufacturer":"Quaker","packaging_type":"Box","rating_ease":"3","rating_safety":"1","rating_reseal":"5","rating_overall":"3","comment":"Not bad?? Lol"},{"entry_id":"8","user_id":"2","product_id":"7622300848668","timestamp":"2014-10-02 10:40:26","image":"upload\/8_1412260826.jpg","name":"Cookie Bus","manufacturer":"Marigold","packaging_type":"Can","rating_ease":"2","rating_safety":"3","rating_reseal":"5","rating_overall":"3.3333333333333335","comment":"Bus... good!"},{"entry_id":"9","user_id":"2","product_id":"3088545004445","timestamp":"2014-10-02 10:44:03","image":"upload\/9_1412261043.jpg","name":"Honey Honey :)","manufacturer":"Kraft","packaging_type":"Bottle","rating_ease":"5","rating_safety":"2","rating_reseal":"3","rating_overall":"3.3333333333333335","comment":"Looks good!"},{"entry_id":"10","user_id":"2","product_id":"93716543","timestamp":"2014-10-02 10:46:06","image":"upload\/10_1412261166.jpg","name":"Red Hot PEPPER","manufacturer":"Nestle","packaging_type":"Bottle","rating_ease":"2","rating_safety":"3","rating_reseal":"2","rating_overall":"2.3333333333333335","comment":"Normal, nothing special."},{"entry_id":"15","user_id":"2","product_id":"8801062267699","timestamp":"2014-10-07 23:37:24","image":"upload\/15_1412739444.jpg","name":"Chocolate Pepero","manufacturer":"Nestle","packaging_type":"Box","rating_ease":"3","rating_safety":"3","rating_reseal":"3","rating_overall":"3","comment":"Good!!!"}]';


$data = http_build_query(array(
    'manufacturer' => 'Kraft',
    'packaging_type' => 'Bag'
));

// Create HTTP stream context
$context = stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $data
    )
));

// Make POST request
//var_dump($_SERVER);
$serv;
$serv = "http".((!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")?'s':'' )."://".$_SERVER["SERVER_NAME"];
$json_string = file_get_contents($serv.'/browse/', false, $context);


function CreateTableFromJson($objArray) {
    // has passed in array has already been deserialized
    $array = json_decode($objArray);
    //var_dump($array);
    $str = '<table id="browse" class="tableNormal">';
    $str .= '<tr>';
    foreach ($array[0] as $key => $index) {
        $str .= '<th scope="col">' . $index . '</th>';
        //echo "$key => $index \n";
    }
    $str .= '</tr>';
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

echo CreateTableFromJson($json_string);
?>

<script type='text/javascript' src="http://tablefilter.free.fr/TableFilter/tablefilter_all_min.js"></script>
<link rel="stylesheet" type="text/css" href="http://tablefilter.free.fr/TableFilter/filtergrid.css" />
<script type="text/javascript">
var table3_Props = {
    col_2: "select",
    col_3: "select",
    display_all_text: "[Show All]",
    sort_select: true
};
var tf3 = setFilterGrid("browse", table3_Props);
</script>
</body></html>