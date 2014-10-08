<?php
require 'table.class.php';

/*
You can use:
'table'=>'border = "0" height="200" width="300"',
or
'table'=>array ('border'=>0, 'height'=>200, 'width'=>300),
*/

$start = microtime(true);

$data = array ('table'=>array ('border'=>1),
'th'=>array ('id', 'beaver name'),
'tr'=>array (array (1, 'luck'),array (2, 'first'),array (3, 'S'))
);

$json_string = '[{"entry_id":"2","user_id":"2","product_id":"8801062636358","timestamp":"2014-10-02 03:52:16","image":"upload\/2_1412236336.jpg","name":"Random Alvin","manufacturer":"Kraft","packaging_type":"Bag","rating_ease":"3","rating_safety":"4","rating_reseal":"2","rating_overall":"3","comment":"Alvin very bad!!!"},{"entry_id":"3","user_id":"2","product_id":"8851019110127","timestamp":"2014-10-02 04:22:32","image":"upload\/3_1412238152.jpg","name":"Pocky Biscuit Sticks","manufacturer":"Nestle","packaging_type":"Box","rating_ease":"5","rating_safety":"3","rating_reseal":"2","rating_overall":"3.3333333333333335","comment":"okay la...."},{"entry_id":"7","user_id":"2","product_id":"8885006000016","timestamp":"2014-10-02 10:38:47","image":"upload\/7_1412260727.jpg","name":"Random Merlion","manufacturer":"Quaker","packaging_type":"Box","rating_ease":"3","rating_safety":"1","rating_reseal":"5","rating_overall":"3","comment":"Not bad?? Lol"},{"entry_id":"8","user_id":"2","product_id":"7622300848668","timestamp":"2014-10-02 10:40:26","image":"upload\/8_1412260826.jpg","name":"Cookie Bus","manufacturer":"Marigold","packaging_type":"Can","rating_ease":"2","rating_safety":"3","rating_reseal":"5","rating_overall":"3.3333333333333335","comment":"Bus... good!"},{"entry_id":"9","user_id":"2","product_id":"3088545004445","timestamp":"2014-10-02 10:44:03","image":"upload\/9_1412261043.jpg","name":"Honey Honey :)","manufacturer":"Kraft","packaging_type":"Bottle","rating_ease":"5","rating_safety":"2","rating_reseal":"3","rating_overall":"3.3333333333333335","comment":"Looks good!"},{"entry_id":"10","user_id":"2","product_id":"93716543","timestamp":"2014-10-02 10:46:06","image":"upload\/10_1412261166.jpg","name":"Red Hot PEPPER","manufacturer":"Nestle","packaging_type":"Bottle","rating_ease":"2","rating_safety":"3","rating_reseal":"2","rating_overall":"2.3333333333333335","comment":"Normal, nothing special."},{"entry_id":"15","user_id":"2","product_id":"8801062267699","timestamp":"2014-10-07 23:37:24","image":"upload\/15_1412739444.jpg","name":"Chocolate Pepero","manufacturer":"Nestle","packaging_type":"Box","rating_ease":"3","rating_safety":"3","rating_reseal":"3","rating_overall":"3","comment":"Good!!!"}]';

$xml_string = <<<END
<?xml version="1.0" encoding="utf-8"?>
<data>
	<table>
		<border>1</border>
	</table>
	<th>
		<item1>id</item1>
		<item2>beaver name</item2>
	</th>
	<tr>
		<item1>
			<item1>1</item1>
			<item2>luck</item2>
		</item1>
		<item2>
			<item1>2</item1>
			<item2>first</item2>
		</item2>
		<item3>
			<item1>3</item1>
			<item2>S</item2>
		</item3>
	</tr>
</data>
END;

echo 'Work with array<br>';
	new Table ($data); // work with array
echo '<br>Generation time: '.(microtime(true)-$start);
$start = microtime(true);
/*echo '<br>Work with json-file<br>';
	new Table ('data.json', 'json-file'); // work with json-file
echo '<br>Generation time: '.(microtime(true)-$start);
$start = microtime(true);*/
echo '<br>Work with json-string<br>';
	new Table ($json_string, 'json'); // work with json-string
echo '<br>Generation time: '.(microtime(true)-$start);
$start = microtime(true);
echo '<br>Work with xml-file<br>';
	new Table ('data.xml', 'xml-file'); // work with xml-file
echo '<br>Generation time: '.(microtime(true)-$start);
$start = microtime(true);
echo '<br>Work with xml-string<br>';
	new Table ($xml_string, 'xml'); // work with xml-string
echo '<br>Generation time: '.(microtime(true)-$start);
$start = microtime(true);