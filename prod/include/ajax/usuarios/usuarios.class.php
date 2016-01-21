<?php
require_once 'HTML/AJAX/Action.php';
ini_set("display_errors",1);
/**
 * Clase Usuarios desde AJAX
 *
 * Permite Traer los usuarios de una dependencia a un Select
 * Permite Informar un radicado
 *
 * @autor Jairo Losada 2009 - Correlibre.org, OrfeoGPL.org
 *                          -> Modificacion para DNP 10/2009  Tomada de Version Original
 *                          de Correlibre.org y OrfeoGPL.org
 *                          Basada en Ejemplo de la Libreria HTML_AJAX
 *         
 * @Copyright GNU/GPL v3
 * @param object $db Objeto conexion a la base de Datos de Orfeo
 *
 * @package OrfeoGPL
 * Require the action class
 *
 * * @autor Modificado Jairo Losada Correlibre.org - 2009
 *          Adaptado por  DNP 2010 - jlosada
 */

class usuarios{
	// variable con Conexion de OrfeoGPL
	var $db;
	/*
	 * Esta variable indica en que sitio se encuenta la Raiz de Orfeo, es
	 * Una ruta relativa ... que muestra cuantos directorios debe devolverse para encontrar
	 * la raiz
	 * @var strig $ruta_raiz Esta variable indica en que sitio se encuenta la Raiz de Orfeo, es Una ruta relativa ... que muestra cuantos directorios debe devolverse para encontrar la raiz
	 * @access private
	 */	
	var $ruta_raiz;

	/*
	 * Variable en el cual se almacenan la dependencia y Usuario
	 * @var strig $ruta_raiz Esta variable indica en que sitio se encuenta la Raiz de Orfeo, es Una ruta relativa ... que muestra cuantos directorios debe devolverse para encontrar la raiz
	 * @access private
	 */		
	
	var $depeCodi;
	var $usuaCodi;
  var $usuaDoc;
	/*
	 * Metodo constructor de la Clase
	 *
	 * Metodo que funciona como costructor e inicializa la Clase recibiendo la conexion a Orfeo
	 * en la Variable $db
	 *
	 * @autor Jairo Losada -  2009 - DNP
	 * @Copyright GNU/GPL v3
	 * @param object $db Objeto conexion a la base de Datos de Orfeo
	 * 
	  */


	function usuarios($db,$ruta_raiz)
	{
		$this->db = $db;
		$this->ruta_raiz = $ruta_raiz; 
	}
	/*
	 * Metodo que Carga la Variable $ruta_raiz
	 * @param var $ruta_raiz Esta variable indica en que sitio se encuenta la Raiz de Orfeo, es Una ruta relativa ... que muestra cuantos directorios debe devolverse para encontrar la raiz
	 * @access public
	 * @return string Retorna la Rua raiz de Orfeo
	 */	
	
	function updateClassName() {
		$response = new HTML_AJAX_Action();

		$response->assignAttr('test','className','test');

		return $response;
	}

	function greenText($id) {
		$response = new HTML_AJAX_Action();
		$response->assignAttr($id,'style','color: green');
		return $response;
	}

	function highlight($id) {
		$response = new HTML_AJAX_Action();
		$response->assignAttr($id,'style','background-color: yellow');
		return $response;
	}
  /**
	 *  trae los Usuarios de una dependencia
	 *  @txAccion bool Si es true entonces carga solo los jefe. txAccion es la accion a realizar Informar o reasignar
	 **/

	function getUsuarios($idObjetoHtml,$depeCodi,$txAccion) {
		$response = new HTML_AJAX_Action();
		$indexSelected=0;
	$iSql = "select (CASE u.SGD_ROL_CODIGO WHEN 0 THEN u.USUA_NOMB WHEN 1 THEN u.USUA_NOMB WHEN 2 THEN u.USUA_NOMB||'(Encargado)' END) as USUA_NOMB , u.USUA_CODI, u.SGD_ROL_CODIGO from usuario u where u.depe_codi=$depeCodi AND u.USUA_ESTA='1' ";
		if($txAccion){
			$iSql .= " AND (u.USUA_CODI=1 or u.sgd_rol_codigo=2) ";
		}
		$iSql .= " ORDER BY U.SGD_ROL_CODIGO DESC, u.USUA_NOMB";
		//return $iSql;
		//ECHO "$isql";
		$rsUs = $this->db->conn->Execute($iSql);
		$cadena = ' document.getElementById("'.$idObjetoHtml.'").length=0;';
		$j=0;
		$cadenaX = "";
		while (!$rsUs->EOF)
		{
			$usuaCodi = htmlentities($rsUs->fields["USUA_CODI"]);
			$usuaRolCodi = $rsUs->fields["SGD_ROL_CODIGO"];
			$usuaNomb = strtoupper(($rsUs->fields["USUA_NOMB"]));
			$cadenaX .= ' document.getElementById("'.$idObjetoHtml.'").options['.$j.'] = new Option("'.$usuaNomb.'","'.$usuaCodi.'");';
			if($usuaCodi==1 || $usuaRolCodi==2) $indexSelected = $j;
			$j++;
			$rsUs->moveNext();
		}
		if(!$cadenaX){
		  $cadenaX = ' document.getElementById("'.$idObjetoHtml.'").options[0] = new Option(" -- No hay Usuarios --","0");';	
		}
		  $cadena = $cadena . $cadenaX;	
		  if(!$indexSelected) $indexSelected = "0";
		  $cadena .= ' document.getElementById("'.$idObjetoHtml.'").options['.$indexSelected.'].selected = true;';
	
		// echo "alert(' $cadena ')";
		$response->insertScript($cadena);
		
		return $response;
	}
    function informarUsuario($idObjetoHtml,$radicado,$loginOrigen,$depeCodiOrigen,$usuaCodiOrigen,$depeCodiDestino,$usuaCodiDestino,$observacion,$txInformar,$txReasignar,$infConjunto=false,$usuaDocOrigen=null) {
	
    $response = new HTML_AJAX_Action();
    $iSql = "select * from usuario where depe_codi=$depeCodiDestino and usua_esta='1'"; 
    $this->depeCodi = $depeCodiOrigen;
    $this->usuaCodi = $usuaCodiOrigen;
    //return $isql;
    $rsUs = $this->db->conn->Execute($iSql);
    $radicados = array_filter(explode(",", $radicado));
    //$var1 = "--> $idObjetoHtml+$radicados+$depeCodiOrigen+$usuaCodiOrigen+$depeCodiDestino+$usuaCodiDestino+{$observacion}";
	
    $ruta_raiz = $this->ruta_raiz;
    include "$ruta_raiz/include/tx/Tx.php";
	$tx = new Tx($this->db);
	if($txInformar){
	  if($infConjunto==true)  $infConjunto=1; else $infConjunto=0;
	  $rta = $tx->informar($radicados,$loginOrigen,$depeCodiDestino,$depeCodiOrigen,$usuaCodiDestino,$usuaCodiOrigen,$observacion ,'',"..",$infConjunto);
	}
	$cadena = $this->listaInformados($radicado,$idObjetoHtml,$usuaDocOrigen);
	$response->insertScript($cadena);
	return $response;
	
}
/**
 * Metodo Devuelve Lista de Informados de Un Radicado
 *
 * 
 * @param string $radicado Numero de Radicado o Registro al cual se le buscaran los Usuarios Informados
 * @return string Retorna la cadena con la tabla de los informados.
 * 
 **/
function listaInformados($radicado,$idObjetoHtml,$usuaDocOrigen)
{


	$cadena = "";
	$iSql = "select
		inf.INFO_DESC, dep.DEPE_NOMB, us.USUA_NOMB, inf.DEPE_CODI, inf.USUA_CODI,inf.INFO_FECH
		from informados inf, dependencia dep, usuario us
		where
		dep.depe_codi=inf.DEPE_CODI
		AND inf.usua_doc = us.usua_doc
		AND radi_nume_radi in ($radicado 0)
		AND info_conjunto =0
		AND USUA_DOC_ORIGEN = '$usuaDocOrigen'
		order by info_fech desc";
	$rsUs = $this->db->conn->Execute($iSql);
	
	$cadena .= "seleccion = document.getElementById('$idObjetoHtml'); ";
	$cadena .= "valor = ".'"<span class=titulos5>SE HA INFORMADO A:</span><TABLE class=borde_tab width=100%>';
	while (!$rsUs->EOF) 
	{
	 $infoDesc = htmlentities(strtoupper(trim($rsUs->fields["INFO_DESC"])));
	 $depeCodiBorrar = trim($rsUs->fields["DEPE_CODI"]);
	 $usuaCodiBorrar = trim($rsUs->fields["USUA_CODI"]);
	 $fechaInf = htmlentities(substr(trim($rsUs->fields["INFO_FECH"]),0,16));
	 $depeNomb =  $rsUs->fields["DEPE_NOMB"];
	 $usuaNomb =  strtoupper($rsUs->fields["USUA_NOMB"]);
	 $cadena .= "<tr><td class=listado5>$infoDesc</td><td class=listado5>$fechaInf</td>";
	 $cadena .= "<td class='listado5'> ($depeCodiBorrar) $depeNomb </td>";
	 $cadena .= "<td class='listado5'> $usuaNomb (<a href=\'#informados\'  onClick=".'\"'."remote.borrarInformado('$idObjetoHtml','$radicado',".$this->depeCodi.",".$this->usuaCodi.",$depeCodiBorrar,$usuaCodiBorrar,'Borrado de Informado')".'\"'." href='#reasignado'><span style='color: RED;'>Borrar</ span></a>)</td>";

	 $cadena .= "</tr>";
	 $rsUs->moveNext();
	}
	$cadena .= '</TABLE>  ';
	$iSql = "select
                inf.INFO_DESC, dep.DEPE_NOMB, us.USUA_NOMB, inf.DEPE_CODI, inf.USUA_CODI,inf.INFO_FECH
                from informados inf, dependencia dep, usuario us
                where
                dep.depe_codi=inf.DEPE_CODI
                AND inf.usua_doc = us.usua_doc
                AND radi_nume_radi in ($radicado 0)
		AND info_conjunto>=1
		AND USUA_DOC_ORIGEN = '$usuaDocOrigen'
                order by info_fech desc";
        $rsUs = $this->db->conn->Execute($iSql);
        $cadena .= "<span class=titulos5>TRAMITE EN CONJUNTO:</span><TABLE class=borde_tab width=100%>";
        while (!$rsUs->EOF)
        {
         $infoDesc = htmlentities(strtoupper(trim($rsUs->fields["INFO_DESC"])));
         $depeCodiBorrar = trim($rsUs->fields["DEPE_CODI"]);
         $usuaCodiBorrar = trim($rsUs->fields["USUA_CODI"]);
         $fechaInf = htmlentities(substr(trim($rsUs->fields["INFO_FECH"]),0,16));
         $depeNomb =  $rsUs->fields["DEPE_NOMB"];
         $usuaNomb =  strtoupper($rsUs->fields["USUA_NOMB"]);
         $cadena .= "<tr><td class=listado5>$infoDesc</td><td class=listado5>$fechaInf</td>";
         $cadena .= "<td class='listado5'> ($depeCodiBorrar) $depeNomb </td>";
         $cadena .= "<td class='listado5'> $usuaNomb (<a href=\'#informados\'  onClick=".'\"'."remote.borrarInformado('$idObjetoHtml','$radicado',".$this->depeCodi.",".$this->usuaCodi.",$depeCodiBorrar,$usuaCodiBorrar,'Borrado de Informado')".'\"'." href='#reasignado'><span style='color: RED;'>Borrar</ span></a>)</td>";

         $cadena .= "</tr>";
         $rsUs->moveNext();
        }
        $cadena .= '</TABLE>";  ';


	$cadena .= " seleccion.innerHTML=valor;";
       // echo $cadena;
	return $cadena;
	
}
/**
 * Metodo Devuelve Lista de Derivados de Un Radicado
 *
 * 
 * @param string $radicado Numero de Radicado o Registro al cual se le buscaran los Usuarios Informados
 * @return string Retorna la cadena con la tabla de los informados.
 * 
 **/
function listaDerivados($radicado,$idObjetoHtml)
{
	$cadena = "";
  return $cadena;
	$iSql = "select
		dep.DEPE_NOMB, us.USUA_NOMB, dep.DEPE_CODI, us.USUA_CODI, rg.ID
		from sgd_rg_multiple rg, dependencia dep, usuario us
		where
		dep.depe_codi=rg.area
		AND rg.area = us.depe_codi
		AND rg.usuario = us.usua_codi
		AND rg.radi_nume_radi=$radicado
		order by rg.fechainicio desc";
	$rsUs = $this->db->conn->Execute($iSql);
	
	$cadena = "seleccion = document.getElementById('$idObjetoHtml'); ";
	$cadena .= "valor = ".'"SE HA DERIVADO A:<HR><TABLE class=borde_tab width=85%>';
	while (!$rsUs->EOF) 
	{
	 $infoDesc = $rsUs->fields["INFO_DESC"];
	 $depeCodiBorrar = $rsUs->fields["DEPE_CODI"];
	 $usuaCodiBorrar = $rsUs->fields["USUA_CODI"];
	 $depeNomb = $rsUs->fields["DEPE_NOMB"];
	 $usuaNomb = $rsUs->fields["USUA_NOMB"];
	 $idDerivado = $rsUs->fields["ID"];
	 $cadena .= "<tr><td class=listado5>$infoDesc</td>";
	 $cadena .= "<td class='listado5'> ($depeCodiBorrar) $depeNomb </td>";
	 $cadena .= "<td class='listado5'> $usuaNomb (<a href=\'#Derivados\'  onClick=".'\"'."remote.borrarDerivado('$idObjetoHtml','$radicado',".$this->depeCodi.",".$this->usuaCodi.",$depeCodiBorrar,$usuaCodiBorrar,$idDerivado,'Borrado por Formulario de Radicacion')".'\"'." href='#Derivados'><span style='color: RED;'>Borrar</ span></a>)</td>";
	 $cadena .= "</tr>";
	 $rsUs->moveNext();
	}
	$cadena .= '</TABLE>";  ';
	$cadena .= " seleccion.innerHTML=valor;";
	return $cadena;
	
}
function borrarInformado($idObjetoHtml,$radicado,$depeCodi,$usuaCodi,$depeCodiBorrar,$usuaCodiBorrar,$observacion) {
	$response = new HTML_AJAX_Action();
	$iSql = "select USUA_DOC from usuario where depe_codi=$depeCodi and usua_codi=$usuaCodi ";
	$rsUs = $this->db->conn->Execute($iSql);
	$usuaDoc = $rsUs->fields["USUA_DOC"];	
	$radicados[]=$usuaDoc."-".$radicado;
	$this->depeCodi = $depeCodi;
	$this->usuaCodi = $usuaCodi;	
	$ruta_raiz = $this->ruta_raiz;
	include "$ruta_raiz/include/tx/Tx.php";
	$tx = new Tx($this->db);
	$loginOrigen = "";
	$rta = $tx->borrarInformado($radicados,$loginOrigen,$depeCodi,$depeCodiBorrar,$usuaCodi,$usuaCodiBorrar,$observacion);
	$cadena = $this->listaInformados($radicado,$idObjetoHtml,$usuaDoc );
	$response->insertScript($cadena);
	return $response;
}
/**
 * Metodo que borrar Derivados de Un Radicado
 *
 * 
 * @param string $radicado Numero de Radicado o Registro al cual se le buscaran los Usuarios Informados
 * @return string Retorna la cadena con la tabla de los informados.
 * @autor Jairo Losada 2009 - Correlibre.org
 *        Modificado en DNP 2010 
 * 
 **/
function borrarDerivado($idObjetoHtml,$radicado,$depeCodi,$usuaCodi,$depeCodiBorrar,$usuaCodiBorrar,$idDerivado,$observacion) {
	$response = new HTML_AJAX_Action();
	$iSql = "select * from usuario where depe_codi=$depeCodi";
	$rsUs = $this->db->conn->Execute($iSql);
	$radicados[]=$depeCodiBorrar."-".$radicado;
	$radicados[]=$radicado;
	
	$this->depeCodi = $depeCodi;
	$this->usuaCodi = $usuaCodi;	
	$ruta_raiz = $this->ruta_raiz;
	//$depeCodi = $this->depeCodi;
	//$usuaCodi = $this->usuaCodi;
	$isql = "DELETE FROM SGD_RG_MULTIPLE where ID=$idDerivado AND RADI_NUME_RADI in($radicado)";
	$ruta_raiz = $this->ruta_raiz;
	$this->db->conn->Execute($isql);
	include "$ruta_raiz/include/tx/Tx.php";
	
	$tx = new Tx($this->db);
	$radicados[0] = $radicado;
	$rrr = $tx->insertarHistorico($radicados,
                                $depeCodi,
                                $usuaCodi,
                                $depeCodiBorrar,
                                $usuaCodiBorrar,
                                $observacion,
                                70);
	//echo "alert('Resultado $rrr >".$this->strSql."')";
	$cadena = $this->listaDerivados($radicado,'usuariosReasignados');
	//echo "alert ('".$isql."');" ;
	$response->insertScript($cadena);
	return $response;
}



}
?>
