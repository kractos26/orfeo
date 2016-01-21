<?php
require_once 'HTML/AJAX/Action.php';
/**
 * Clase Radicacion desde AJAX
 *
 * Permite generar un numero de radicado
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

include "../../tx/Radicacion.php";

class radicacionAjax extends Radicacion{
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


	function radicacionAjax($db,$ruta_raiz)
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

	function newRadicadoAjax($idObjetoHtml,$asunto,$tipoRadicado,$radiDepeRadi,$radiDepeActu
													 ,$dependenciaSecuencia,$radiUsuaRadi,$radiUsuaActu,$usuaDoc
													 ,$cuentai, $docUs3=0,$mRecCodi=0
													 ,$radiFechOficio, $radicadoPadre,$radPais,$tipoDocumento=0
													 ,$carpetaPer=0, $carpetaCodi,$tDidCodi=0, $tipoRemitente=0
													 ,$ane='',$radiPath=''
													 
													 ) {
		//echo "alert('<!-- $carpetaCodi -- $docUs3 "." -->'); ";
		$response = new HTML_AJAX_Action();
		$this->radiTipoDeri = 0;
		$this->radiCuentai = "".trim($cuentai)."";
		$this->eespCodi =  $docUs3;
		$this->mrecCodi =  $mRecCodi;  
		$fecha_gen_doc_YMD = substr($radiFechOficio,6 ,4)."-".substr($radiFechOficio,3 ,2)."-".substr($radiFechOficio,0 ,2);
		$this->radiFechOfic =  $fecha_gen_doc_YMD;
		if(!$radicadopadre)  $radicadopadre = "'0'";
		$this->radiNumeDeri = trim($radicadopadre);
		$this->radiPais  =  $radPais;
		$this->descAnex  = $ane;
		$this->raAsun    = utf8_decode($asunto);
		$this->radiDepeActu = $radiDepeActu ;
		$this->radiDepeRadi = $radiDepeRadi ;
		$this->radiUsuaActu = $radiUsuaActu;
		$this->radiUsuaRadi = $radiUsuaRadi;
		$this->usuaCodi = $radiUsuaRadi;
		$this->eespCodi = $docUs3;
		$this->trteCodi  =  $tipoRemitente;
		$this->tdocCodi  = $tipoDocumento;
		$this->tdidCodi  = $tDidCodi;
		$this->carpCodi  = $carpetaCodi;
		$this->carPer    = $carpetaPer;
		$this->usuaDoc    = $usuaDoc;
		$this->noDigitosRad = 6;
		$this->dependencia = $radiDepeRadi;
		if($radiPath) $this->radiPath    = $radiPath;
		//$this->trteCodi  = $tip_rem;
		//return "$tipoRadicado,$dependenciaSecuencia";
		$noRad = $this->newRadicado($tipoRadicado,$dependenciaSecuencia);
		if($noRad<=1){
			$errorNewRadicado = "<font size=1 color=red>Error al Generar el Radicado.". $this->errorNewRadicado . "</font>";
		}
		//$rtaDirecciones = $this->insertDireccionAjax($noRad, 1,0);
	//grabarDirecciones(document.getElementById('numeroRadicado').value);
	$cadena = "seleccion = document.getElementById('$idObjetoHtml'); ";
	//if($noRad>=1)
	//{
	 $cadena1 = "document.getElementById('numeroRadicado').value=".$noRad."; grabarDirecciones(document.getElementById('numeroRadicado').value);";
	 $cadena1 .= "document.getElementById('Submit33').style.visibility='hidden'; ";
	 $cadena1 .= "document.getElementById('grabarDir').style.visibility='visible'; ";
	 //$cadena1 .= "verDatosRad(".$noRad."); ";
	 $cadena .= 'valor="<table wdith=50%><tr class=titulos1><td><img src=../imagenes/gnu.png width=50 alt=GNU/GPL title=GNU/GPL></td><td><center><font size=4>Radicado No '.$noRad.' - - '.htmlspecialchars($errorNewRadicado).'</font></center></td></tr></table><SCRIPT>verDatosRad('.$noRad.');</SCRIPT>";';
	 //echo "<!-- alert('<!-- $carpetaCodi -- $noRad "." -->'); -->";
	//}else{
   //$cadena .= 'valor="'.$errorNewRadicado.'";';		
	//}
	
	
	include_once "../../tx/Historico.php";
	$historico = new Historico($this->db);
	$radicados[] = $noRad;
	$resHistorico =$historico->insertarHistorico($radicados, $radiDepeRadi,$radiUsuaRadi,$radiDepeActu,$radiUsuaActu,'',2 );
	$cadena .= " $cadena1 seleccion.innerHTML=valor;";
	//$cadena .= " alert('".$resHistorico."');";
	$response->insertScript($cadena);
	
	 return $response;
	}
	function insertDireccionAjax($radiNumeRadi, $dirTipo, $tipoAccion,	 
												$grbNombresUs, 
												$ccDocumento, 
												$muniCodi, 
												$dpto_tmp1, 
												$idPais, 
												$idCont, 
												$funCodigo, 
												$oemCodigo, 
												$ciuCodigo, 
												$espCodigo, 
												$direccion="", $dirTelefono, $dirMail="", $dirNombre="",
												$asunto="",$cuentai="",$fechaOficio="",$med=0,$ane){
		if($asunto || $mRecCodi || $ane || $cuentai){
			
			if($asunto) $this->raAsun=$asunto;
			$this->mrecCodi =  $mRecCodi;
			$this->descAnex  = $ane;
			$this->radiCuentai = "".trim($cuentai)."";
			if($fechaOficio) { 
			  $fecha_gen_doc_YMD = substr($radiFechOficio,6 ,4)."-".substr($radiFechOficio,3 ,2)."-".substr($radiFechOficio,0 ,2);
			  $this->radiFechOfic =  $fecha_gen_doc_YMD;
			}
			$respuestaUpdate = $this->updateRadicado($radiNumeRadi, $radPathUpdate = null);
			
			//return "Entro.".$respuestaUpdate . ">". $this->db->conn->query;
		}
		
		
		$this->radiNumeRadi 	=	$radiNumeRadi 	;
		$this->dirTipo 	=	$dirTipo 	;
		$this->tipoAccion	=	$tipoAccion	;
		$this->trdCodigo	=	0 	;
		$this->grbNombresUs	=	"'".utf8_decode($grbNombresUs)."'";
		$this->ccDocumento	=	"'".$ccDocumento."'";
		$this->muniCodi	=	$muniCodi 	;
		$this->dpto_tmp1	=	$dpto_tmp1 	;
		$this->idPais	=	$idPais 	;
		$this->idCont	=	$idCont 	;
		$this->funCodigo	=	$funCodigo 	;
		$this->oemCodigo	=	$oemCodigo 	;
		$this->ciuCodigo	=	$ciuCodigo 	;
		$this->espCodigo	=	$espCodigo 	;
		$this->direccion	=	"'". utf8_decode($direccion) ."'" 	;
		$this->dirTelefono	=	"'". $dirTelefono ."'" 	;
		$this->dirMail	=	"'". $dirMail . "'";
		$this->dirNombre	=	"'" . utf8_decode($dirNombre) ."'";

		$respuestaInsert = $this->insertDireccion($radiNumeRadi,$dirTipo,$tipoAccion);
		return  $respuestaInsert;
	}
	
function insertVarsDireccionAjax( $dirTipo,	$trdCodigo, 
												$grbNombresUs, 
												$ccDocumento, 
												$muniCodi, 
												$dpto_tmp1, 
												$idPais, 
												$idCont, 
												$funCodigo, 
												$oemCodigo, 
												$ciuCodigo, 
												$espCodigo, 
												$direccion, $dirTelefono, $dirMail, $dirCodigo, $dirNombre){
		
		$this->dirTipo 	=	$dirTipo 	;
		$this->trdCodigo	=	$trdCodigo 	;
		$this->grbNombresUs	=	utf8_decode($grbNombresUs) 	;
		$this->ccDocumento	=	$ccDocumento 	;
		$this->muniCodi	=	$muniCodi 	;
		$this->dpto_tmp1	=	$dpto_tmp1 	;
		$this->idPais	=	$idPais 	;
		$this->idCont	=	$idCont 	;
		$this->funCodigo	=	$funCodigo 	;
		$this->oemCodigo	=	$oemCodigo 	;
		$this->ciuCodigo	=	$ciuCodigo 	;
		$this->espCodigo	=	$espCodigo 	;
		$this->direccion	=	$direccion 	;
		$this->dirTelefono	=	$dirTelefono 	;
		$this->dirMail	=	$dirMail 	;
		$this->dirCodigo	=	$dirCodigo 	;
		$this->dirNombre	=	utf8_decode($dirNombre)	;
		$respuestaVar = 1;
		return  $respuestaVar;

	}





}
?>
