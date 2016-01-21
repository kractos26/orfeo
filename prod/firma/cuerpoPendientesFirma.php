<?
session_start();
if (!$ruta_raiz)
	$ruta_raiz = "..";
if (!$dependencia)   include "$ruta_raiz/rec_session.php";

?>
<html>
<head>
<title>Editar Firmantes</title>
<link rel="stylesheet" href="<?=$ruta_raiz?>/estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF" topmargin="0" onLoad="window_onload();">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="js/spiffyCal/spiffyCal_v2_1.css">
<?
 
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
error_reporting(7);
 $db = new ConnectionHandler("$ruta_raiz");	 
// $db->conn->debug = true;
 $accion_sal = "Firmar Documentos";
 $nomcarpeta = "Documentos pendientes de firma digital";
 $pagina_sig = "firmarDocumentos.php";
 

 
 
 
 if ($orden_cambio==1)  {
 	if (!$orderTipo)  {
	   $orderTipo=" DESC";
	}else  {
	   $orderTipo="";
	}
 }
 
 	if (!$orderNo)  {
	   		$orderNo=0;
			$orderTipo=" desc ";
	}

	if($busqRadicados)
	{
   
    $busqRadicados = trim($busqRadicados);
    $textElements = split (",", $busqRadicados);
    $newText = "";
	$dep_sel = $dependencia;
    foreach ($textElements as $item)
    {
         $item = trim ( $item );
         if ( strlen ( $item ) != 0)
		 {
 	        $busqRadicadosTmp .= " fr.radi_nume_radi like '%$item%' or";
		 }
    }
	if(substr($busqRadicadosTmp,-2)=="or")
	{
	 $busqRadicadosTmp = substr($busqRadicadosTmp,0,strlen($busqRadicadosTmp)-2);
	}
	if(trim($busqRadicadosTmp)) 
	{
	 $whereFiltro .= "and ( $busqRadicadosTmp ) ";
	}

	}
	 

 $encabezado = "".session_name()."=".session_id()."&ruta_raiz=$ruta_raiz&krd=$krd&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&orderTipo=$orderTipo&radicado=$radicado&orderNo=";
 $linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";
 $carpeta = "nada";
 include "../envios/paEncabeza.php";
 $pagina_actual = $PHP_SELF;
 include "../envios/paBuscar.php";   

 
 include "../envios/paOpciones.php";   

	/*  GENERACION LISTADO DE RADICADOS
	 *  Aqui utilizamos la clase adodb para generar el listado de los radicados
	 *  Esta clase cuenta con una adaptacion a las clases utiilzadas de orfeo.
	 *  el archivo original es adodb-pager.inc.php la modificada es adodb-paginacion.inc.php
	 */
error_reporting(7);

?>
  <form name=formEnviar action='../firma/<?=$pagina_sig?>?<?=$encabezado?>' method=post>
  
 <?


	include "$ruta_raiz/include/query/firma/queryCuerpoPendientesFirma.php";
	//$db->conn->debug = true;
	$rs=$db->conn->Execute($query);
	
	if (!$rs->EOF)  {
		$pager = new ADODB_Pager($db,$query,'adodb', true,$orderNo,$orderTipo);
		$pager->toRefLinks = $linkPagina;
		$pager->toRefVars = $encabezado;
		$pager->checkTitulo = true; 
		$pager->Render($rows_per_page=20,$linkPagina,$checkbox=chkEnviar);		
	} 
	else{
		echo "<hr><center><b>NO se encontro nada con el criterio de busqueda</center></b></hr>";	
	}
	
 ?>
  </form>

</body>

</html>

