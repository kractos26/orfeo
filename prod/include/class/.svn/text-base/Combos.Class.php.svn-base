<?php
/**
 * Esta clase se encrga de devolver los combos de divipola
 */
class Combos{

    var $conn;
    var $db;
    var $ruta_fuente;
    public function Combos($ruta_raiz=".", $ruta_fuente=".")
    {
       include("$ruta_raiz/config.php");
       define('ADODB_ASSOC_CASE', 1);
       include($ADODB_PATH.'/adodb.inc.php');	// $ADODB_PATH configurada en config.php
       $dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$servicio;
       $this->conn = NewADOConnection($dsn);
       include_once("$ruta_raiz/include/db/ConnectionHandler.php");
       $this->db = new ConnectionHandler("$ruta_raiz");
       $this->ruta_fuente=$ruta_fuente;
       //$this->db->conn->debug=true;
    }

    public function getContinentes($selCont)
    {
        $sql="select nombre_cont,id_cont  from sgd_def_continentes order by nombre_cont ";
        $rs=$this->db->conn->Execute($sql);
        return $rs->GetMenu2('selCont',$selCont,"0:&lt;&lt Seleccione &gt;&gt",false,0," id=\"selCont\" onChange=\"pedirCombosDivipola('".$this->ruta_fuente."/cCombos.php', 'DivPais','pais',this.value,0,0)\" class=\"select\" ");
        $this->db->conn->Close();
    }

    public function getPaises($idCont,$selPais=0)
    {   
        $sql="select nombre_pais,id_pais  from sgd_def_paises where id_cont=$idCont order by nombre_pais";
        $rs=$this->db->conn->Execute($sql);
        return $rs->GetMenu2("selPais",$selPais,"0:&lt;&lt Seleccione &gt;&gt",false,0," id=\"selPais\" onChange=\"pedirCombosDivipola('".$this->ruta_fuente."/cCombos.php','DivDepto','depto',document.getElementById('selCont').value,this.value,0)\" class=\"select\" ");
        $this->db->conn->Close();
    }

    public function getDepartamentos($idCont,$idPais,$selDepto=0)
    {
        
        $sql="select dpto_nomb,dpto_codi  from departamento where id_cont=$idCont and id_pais=$idPais order by dpto_nomb";
        $rs=$this->db->conn->Execute($sql);
        return $rs->GetMenu2("selDepto",$selDepto,"0:&lt;&lt Seleccione &gt;&gt",false,0," id=\"selDepto\" onChange=\"pedirCombosDivipola('".$this->ruta_fuente."/cCombos.php', 'DivMnpio','mnpio',document.getElementById('selCont').value,document.getElementById('selPais').value,this.value)\" class=\"select\" ");
        $this->db->conn->Close();
    }

    public function getMunicipios($idCont,$idPais,$idDpto,$selMnpio=0)
    {
        $sql="select muni_nomb,muni_codi  from municipio where id_cont=$idCont and id_pais=$idPais and dpto_codi=$idDpto  order by muni_nomb";
        $rs=$this->db->conn->Execute($sql);
        return $rs->GetMenu2('selMnpio',$selMnpio,"0:&lt;&lt Seleccione &gt;&gt",false,0," id=\"selMnpio\" class=\"select\" ");
        $this->db->conn->Close();
    }

    public function arrayToJsArray( $array, $name, $nl = "\n", $encoding = false )
    {
        if (is_array($array))
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
            return ;
    }


}
?>
