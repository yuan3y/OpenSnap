<?
/* 
Copyright: 2009 кот, админ, шредер. 
Author: Я ацкий одмин, йа счас в серверной кота через шредер за 25 секнд пропустил o_0 
*/ 

class Table
{
	private $table;
	private $th;
	private $tr;

	function __construct ($data, $type = null)
	{
		switch ($type)
		{
		case 'json-file':
			if(file_exists ($data))
			{
			$data = json_decode (file_get_contents ($data), true);
			}
			else
			{
			throw new Exception ('File $data not found');
			}
			break;
		case 'json':
		$data = json_decode ($data, true);
			break;

		case 'xml-file':
			if(file_exists ($data))
			{
				$xml = new XmlToArray (file_get_contents ('data.xml'));
				$data = $xml->start ();
			}
			else
			{
			throw new Exception ('File $data not found');
			}
			break;

		case 'xml':
		$xml = new XmlToArray ($data);
		$data = $xml->start ();
			break;

		default:
			if (!(is_array ($data) && count ($data['tr']) > 0))
			{
			throw new Exception ('Invalid array');
			}
		}
	$this->parse_input ($data);
	$this->compile ();
	}

	private function parse_input ($data)
	{
	$this->table = $this->parse_parameters ($data ['table']);
	$this->th = $data ['th'];
	$this->tr = $data ['tr'];
	}

	private function parse_parameters ($data)
	{
		if (is_array ($data))
		{
			foreach ($data as $key=>$value)
			{
			$str .= ' '.trim ($key).'="'.trim ($value).'"';
			}
			return $str;
		}
		else
		{
			return $data;
		}
	}

	private function padding ($n = 1)
	{
		return str_repeat ('	', $n);
	}

	private function compile ()
	{
	echo '<table'.$this->table.'>';
		if (is_array ($this->th) && count ($this->th) > 0)
		{
		echo $this->padding ()."<thead>\n";
			foreach ($this->th as $value)
			{
			echo $this->padding (2)."<th>$value</th>\n";
			}
		echo $this->padding ()."</thead>\n";
		}
	echo $this->padding ()."<tbody>\n";
		foreach ($this->tr as $value)
		{
		echo $this->padding (2)."<tr>\n";
			foreach ($value as $val)
			{
			echo $this->padding (3)."<td>$val</td>\n";
			}
		echo $this->padding (2)."</tr>\n";
		}
	echo $this->padding ()."</tbody>\n</table>";
	}
}

/**
* Author   : MA Razzaque Rupom (rupom_315@yahoo.com, rupom.bd@gmail.com)
* Version  : 1.0
* Modification: Ewg
* Date     : 02 March, 2006
* Purpose  : Creating Hierarchical Array from XML Data
* Released : Under GPL
*/

class XmlToArray
{
	var $xml='';
	private $temp;

	function __construct ($xml)
	{
	$this->xml = $xml;
	$this->temp = $this->createArray ();	
	}

	public function start ()
	{
		foreach ($this->temp['data']['tr']['0'] as $value)
		{
		$tr[] = $value['0'];
		}
	$data = array ('table'=>$this->temp['data']['table']['0'], 'th'=>$this->temp['data']['th']['0'], 'tr'=>$tr);
		return $data;
	}
	/**
	* _struct_to_array($values, &$i)
	*
	* This is adds the contents of the return xml into the array for easier processing.
	* Recursive, Static
	*
	* @access    private
	* @param    array  $values this is the xml data in an array
	* @param    int    $i  this is the current location in the array
	* @return    Array
	*/

	function _struct_to_array($values, &$i)
	{
		$child = array();
		if (isset($values[$i]['value'])) array_push($child, $values[$i]['value']);

		while ($i++ < count($values)) {
			switch ($values[$i]['type']) {
				case 'cdata':
            	array_push($child, $values[$i]['value']);
				break;

				case 'complete':
					$name = $values[$i]['tag'];
					if(!empty($name)){
					$child[$name]= ($values[$i]['value'])?($values[$i]['value']):'';
					if(isset($values[$i]['attributes'])) {
						$child[$name] = $values[$i]['attributes'];
					}
				}
          	break;

				case 'open':
					$name = $values[$i]['tag'];
					$size = isset($child[$name]) ? sizeof($child[$name]) : 0;
					$child[$name][$size] = $this->_struct_to_array($values, $i);
				break;

				case 'close':
            	return $child;
				break;
			}
		}
		return $child;
	}//_struct_to_array

	/**
	* createArray($data)
	*
	* This is adds the contents of the return xml into the array for easier processing.
	*
	* @access    public
	* @param    string    $data this is the string of the xml data
	* @return    Array
	*/
	function createArray()
	{
		$xml    = $this->xml;
		$values = array();
		$index  = array();
		$array  = array();
		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parse_into_struct($parser, $xml, $values, $index);
		xml_parser_free($parser);
		$i = 0;
		$name = $values[$i]['tag'];
		$array[$name] = isset($values[$i]['attributes']) ? $values[$i]['attributes'] : '';
		$array[$name] = $this->_struct_to_array($values, $i);
		return $array;
	}//createArray


}//XmlToArray