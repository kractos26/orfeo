<?php
//los comentarios son superfluos!!1  ;-)
require_once("$ruta_raiz/include/db/ConnectionHandler.php"); 
class combo
{	var $row;
	var $respuesta;
	var $cursor;
	

	function combo($cur=null)
	{	
		$this->cursor=$cur;
	}

	function conectar($dbsql,$valu,$tex,$verific,$muestreo,$simple=0)
	{	error_reporting(7);
		//print("PREVIO A LA CONEXION ****************");
		$this->cursor->conn->SetFetchMode(ADODB_FETCH_ASSOC);	 
		//$this->cursor->conn->debug=true;
		$rs=$this->cursor->query($dbsql);
 		//esta opcion permite cargar en un select de html una consulta... tambien
		//se selecciona el campo ke va a actuar como valor y cual desplegado haci como el de verificacion

		if($simple==0)
		{	while(!$rs->EOF)
			{	
				if(strcmp(trim($verific),trim($rs->fields[$valu]))==0)
				{
					$sel="selected";
				}
				else $sel ="";
				
				echo "<option value='".$rs->fields[strtoupper($valu)]."' $sel>".$rs->fields[strtoupper($tex)]."</option>";
				$rs->MoveNext();
			}
		}   
  	}
  	
  	function valueToJsValue($value, $encoding = false)
{	if (!is_numeric($value)) 
	{	$value = str_replace('\\', '\\\\', $value);
		$value = str_replace('"', '\"', $value);
		$value = '"'.$value.'"';
	}
	if ($encoding)
	{	switch ($encoding)
		{	case 'utf8' :	return iconv("ISO-8859-2", "UTF-8", $value);
							break;
		}
	}
	else 
	{	return $value;	}
	return false;
}


/*
*	Funcion que convierte un vector de PHP a un vector Javascript.
*	Utiliza a su vez la funcion valueToJsValue.
*/
function arrayToJsArray( $array, $name, $nl = "\n", $encoding = false ) 
{	if (is_array($array)) 
	{	$jsArray = $name . ' = new Array();'.$nl;
		foreach($array as $key => $value) 
		{	switch (gettype($value)) 
			{	case 'unknown type':
				case 'resource':
				case 'object':	break;
				case 'array':	$jsArray .= $this->arrayToJsArray($value,$name.'['.$this->valueToJsValue($key, $encoding).']', $nl);
								break;
				case 'NULL':	$jsArray .= $name.'['.$this->valueToJsValue($key,$encoding).'] = null;'.$nl;
								break;
				case 'boolean':	$jsArray .= $name.'['.$this->valueToJsValue($key,$encoding).'] = '.($value ? 'true' : 'false').';'.$nl;
								break;
				case 'string':	$jsArray .= $name.'['.$this->valueToJsValue($key,$encoding).'] = '.$this->valueToJsValue($value, $encoding).';'.$nl;
								break;
				case 'double':	
				case 'integer':	$jsArray .= $name.'['.$this->valueToJsValue($key,$encoding).'] = '.$value.';'.$nl;
								break;
				default:	trigger_error('Hoppa, egy j t�us a PHP-ben?'.__CLASS__.'::'.__FUNCTION__.'()!', E_USER_WARNING);
			}
		}
		return $jsArray;
	}
	else 
	{	return false;	}
}
}
?>