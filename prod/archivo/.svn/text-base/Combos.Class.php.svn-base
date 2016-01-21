<?php
/**
 * Esta clase se encrga de devolver los combos de divipola
 */
class Combos{

    var $conn;
    var $db;
    public function Combos()
    {
       $ruta_raiz= "..";
       include("$ruta_raiz/config.php");
       define('ADODB_ASSOC_CASE', 1);
       include($ADODB_PATH.'/adodb.inc.php');	// $ADODB_PATH configurada en config.php
       $dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$servicio;
       $this->conn = NewADOConnection($dsn);
       include_once("$ruta_raiz/include/db/ConnectionHandler.php");
       $this->db = new ConnectionHandler("$ruta_raiz");

    }

    public function getContinentes()
    {
        $sql="select nombre_cont,id_cont  from sgd_def_continentes";
        $rs=$this->db->conn->Execute($sql);
        return $rs->GetMenu2('selCont',$selCont,"0:&lt;&lt Seleccione &gt;&gt",false,0," id=\"selCont\" onChange=\"pedirCombosDivipola('cCombos.php', 'DivPais','pais',this,0,0)\" class=\"select\" ");
    }

    public function getPaises($idCont)
    {   
        $sql="select nombre_pais,id_pais  from sgd_def_paises where id_cont=$idCont";
        $rs=$this->db->conn->Execute($sql);
        return $rs->GetMenu2("selPais",$selPais,"0:&lt;&lt Seleccione &gt;&gt",false,0," id=\"selPais\" onChange=\"pedirCombosDivipola('cCombos.php','DivDepto','depto',document.getElementById('selCont'),this,0)\" class=\"select\" ");
    }

    public function getDepartamentos($idCont,$idPais)
    {
        
        $sql="select dpto_nomb,dpto_codi  from departamento where id_cont=$idCont and id_pais=$idPais";
        $rs=$this->db->conn->Execute($sql);
        return $rs->GetMenu2("selDepto",$selDepto,"0:&lt;&lt Seleccione &gt;&gt",false,0," id=\"selDepto\" onChange=\"pedirCombosDivipola('cCombos.php', 'DivMnpio','mnpio',document.getElementById('selCont'),document.getElementById('selPais'),this)\" class=\"select\" ");
    }

    public function getMunicipios($idCont,$idPais,$idDpto)
    {
        $sql="select muni_nomb,muni_codi  from municipio where id_cont=$idCont and id_pais=$idPais and dpto_codi=$idDpto";
        $rs=$this->db->conn->Execute($sql);
        return $rs->GetMenu2('selMnpio',$selMnpio,"0:&lt;&lt Seleccione &gt;&gt",false,0," id=\"selMnpio\" class=\"select\" ");
    }
}
?>
