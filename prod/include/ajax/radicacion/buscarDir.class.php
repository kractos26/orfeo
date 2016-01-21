<?php
require_once 'HTML/AJAX/Action.php';
/**
 * Clase Usuarios desde AJAX
 *
 * Permite Traer los Datos de Direcciones de las Tablas de OrfeoGPL
 *
 * @autor Jairo Losada 12/2011 - Correlibre.org, OrfeoGPL.org
 *                          Basada en Ejemplo de la Libreria HTML_AJAX
 *         
 * @Copyright GNU/GPL v3
 * @param object $db Objeto conexion a la base de Datos de Orfeo
 *
 * @package OrfeoGPL
 * Require the action class
 *
 */

class buscarDir{
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


	function buscarDir($db,$ruta_raiz)
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
	 *  Metodo que busca los ciudadanos
	 *  @documento string Documento del Ciudadano
	 **/

	function getBuscarCiuDoc($idObjetoHtml,$documento) {
	$response = new HTML_AJAX_Action();
	$iSql = "select tdid_codi,sgd_ciu_codigo,sgd_ciu_nombre,sgd_ciu_direccion,sgd_ciu_apell1,sgd_ciu_apell2,sgd_ciu_telefono,sgd_ciu_email,muni_codi,dpto_codi,sgd_ciu_cedula,id_cont,id_pais from SGD_CIU_CIUDADANO where cast(SGD_CIU_CEDULA as varchar(200)) like '%".$documento."%'";
		$iSql .= " ORDER BY SGD_CIU_CEDULA, SGD_CIU_NOMBRE ";
		//return $iSql;
		//ECHO "$isql";
		$rsUs = $this->db->conn->Execute($iSql);
		$j=0;
    $cadena = 'valor = "<table width=550>";';
		while(!$rsUs->EOF){

		$ciuNomb = utf8_encode  ($rsUs->fields["SGD_CIU_NOMBRE"]);
		$ciuApell1 = utf8_encode  ($rsUs->fields["SGD_CIU_APELL1"]);
		$ciuApell2 = utf8_encode  ($rsUs->fields["SGD_CIU_APELL2"]);
		$ciuDireccion = utf8_encode  ($rsUs->fields["SGD_CIU_DIRECCION"]);
		$ciuMail = utf8_encode  ($rsUs->fields["SGD_CIU_EMAIL"]);
		$ciuDocX = $rsUs->fields["SGD_CIU_CODIGO"];
		$ciuDoc = $rsUs->fields["SGD_CIU_CEDULA"];
    $ciuTelefono = utf8_encode  ($rsUs->fields["SGD_CIU_TELEFONO"]);
    $cadena .= 'valor=  valor + "<tr><td  class=listado1><SPAN onClick=seleccionarDir('.$ciuDocX.');> <label>Seleccionar</label></SPAN> </td><td class=listado1>'.$ciuDoc .'</td><td class=listado1>'. $ciuNomb .' '.$ciuApell1.' </td><td class=listado1>'.$ciuDireccion .'</td></tr>";';
		$rsUs->MoveNext();
		}
		$cadena .= 'valor = valor + "<option value=usNuevo> </table>";';
		$cadena .= 'document.getElementById("dirBusqueda").innerHTML=valor;';
		//echo "alert('$cadena');";
		$response->insertScript($cadena);
		//return $iSql;
		return $response;
        }


}
?>
