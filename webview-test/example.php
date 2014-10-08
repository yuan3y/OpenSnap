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

$json_string = '{"table":{"border":1},"th":["id","beaver name"],"tr":[[1,"luck"],[2,"first"],[3,"S"]]}';

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
echo '<br>Work with json-file<br>';
	new Table ('data.json', 'json-file'); // work with json-file
echo '<br>Generation time: '.(microtime(true)-$start);
$start = microtime(true);
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
?>