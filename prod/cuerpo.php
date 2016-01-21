<?php
define('ADODB_ASSOC_CASE', 2);
$krdOld = isset($_GET['krd'])?$_GET['krd']:$krdOld;
$carpetaOld = isset($_GET['carpeta'])?$_GET['carpeta']:$carpetaOld;
$tipoCarpOld = isset($_GET['tipo_carpt'])?$_GET['tipo_carpt']:$tipoCarpOld;
//if(!$tipoCarpOld) $tipoCarpOld= $tipo_carpt;
session_start();
if(!$krd) $krd=$krdOld;
$ruta_raiz = ".";
if(!isset($_SESSION['dependencia'])) include "./rec_session.php";
error_reporting(7);
if(!$carpeta)
{
    $carpeta = $carpetaOld;
    $tipo_carp = $tipoCarpOld;
}
$verrad = "";
$_SESSION['numExpedienteSelected'] = null;
?>
<html>
<head>
<link rel="stylesheet" href="estilos/orfeo38/orfeo.css">
<script language="JavaScript" src="./js/popcalendar.js"></script>
<script language="JavaScript" src="./js/mensajeria.js"></script>
<div id="spiffycalendar" class="text"></div>
</head>
<?
include "./envios/paEncabeza.php";
?>
<body bgcolor="#FFFFFF" topmargin="0" onLoad="window_onload();">
<?
include_once "./include/db/ConnectionHandler.php";
require_once("$ruta_raiz/class_control/Mensaje.php");
if (!$db) $db = new ConnectionHandler($ruta_raiz);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
include_once "./include/query/busqueda/busquedaPiloto1.php";
//$db->conn->debug=true;
$objMensaje= new Mensaje($db);
$mesajes = $objMensaje->getMsgsUsr($_SESSION['usua_doc'],$_SESSION['dependencia']);

if ($swLog==1)  echo ($mesajes);
if(trim($orderTipo)=="")    $orderTipo="DESC";
if($orden_cambio==1)    (trim($orderTipo)!="DESC") ? $orderTipo="DESC" : $orderTipo="ASC";

if(!$carpeta) $carpeta=0;
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
 	        $busqRadicadosTmp .= " $radi_nume_radiCuerpo like '%$item%' or";
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
$encabezado = "".session_name()."=".session_id()."&krd=$krd&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&chkCarpeta=$chkCarpeta&busqRadicados=$busqRadicados&nomcarpeta=$nomcarpeta&agendado=$agendado&";
$linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";
$encabezado = "".session_name()."=".session_id()."&adodb_next_page=1&krd=$krd&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&nomcarpeta=$nomcarpeta&agendado=$agendado&orderTipo=$orderTipo&orderNo=";
?>
<table width="100%" align="center" cellspacing="0" cellpadding="0" class="borde_tab">
<tr class="tablas">
	<td>
	<span class="etextomenu">
	<form name="form_busq_rad" id="form_busq_rad" action='<?=$_SERVER['PHP_SELF']?>?<?=$encabezado?>' method="post">
			Buscar radicado(s) (Separados por coma)<span class="etextomenu">
	   	   <input name="busqRadicados" type="text" size="40" class="tex_area" value="<?=$busqRadicados?>">
	       <input type=submit value='Buscar ' name=Buscar valign='middle' class='botones'>
        </span>
        <?php
		/**
		  * Este if verifica si se debe buscar en los radicados de todas las carpetas.
		  * @$chkCarpeta char  Variable que indica si se busca en todas las carpetas.
		  *
		  */
		if($chkCarpeta)
		{
			$chkValue=" checked ";
			$whereCarpeta = " ";
		}
		else
		{
      $chkValue="";
			if(!$tipo_carp) $tipo_carp = "0";
			$whereCarpeta = " and b.carp_codi=$carpeta  and b.carp_per=$tipo_carp";
		}



	$fecha_hoy = Date("Y-m-d");
	$sqlFechaHoy=$db->conn->DBDate($fecha_hoy);

	//Filtra el query para documentos agendados
	 if ($agendado==1){
	 	$sqlAgendado=" and (radi_agend=1 and radi_fech_agend > $sqlFechaHoy) "; // No vencidos

	 }
	 else  if ($agendado==2){
	   	$sqlAgendado=" and (radi_agend=1 and radi_fech_agend <= $sqlFechaHoy)  "; // vencidos
	 }


	 if ($agendado){
	 	$colAgendado = "," .$db->conn->SQLDate("Y-m-d H:i A","b.RADI_FECH_AGEND").' as "Fecha Agendado"';
	 	$whereCarpeta="";
	 }

	//Filtra teniendo en cienta que se trate de la carpeta Vb.
	 if($carpeta==11 && $_SESSION["usua_vobo_perm"]!=1 && $_GET['tipo_carp']!=1)//$codusuario !=1
	 {	$whereUsuario = " and  b.radi_usu_ante ='$krd' ";
	 }
	 else
	 {	$whereUsuario = " and b.radi_usua_actu='$codusuario' ";
	 }
	?>
   <input type="checkbox" name="chkCarpeta" value=xxx <?=$chkValue?> > Todas las carpetas
	</form>
	</span>
    </td>
</tr>
<tr>
    <td>
<form name="form1" id="form1" action="./tx/formEnvio.php?<?=$encabezado?>" method="POST">
<?php
$controlAgenda=1;
if($carpeta==11 and !$tipo_carp and $_SESSION["usua_vobo_perm"]!=1)//$codusuario!=1
{}
else
{
    include "./tx/txOrfeo.php";
}
/*  GENERACION LISTADO DE RADICADOS
 *  Aqui utilizamos la clase adodb para generar el listado de los radicados
 *  Esta clase cuenta con una adaptacion a las clases utiilzadas de orfeo.
 *  el archivo original es adodb-pager.inc.php la modificada es adodb-paginacion.inc.php
 */
error_reporting(7);

if(strlen($orderNo)==0)
{
    $orderNo="2";
	$order = 3;
}
else
{
	$order = $orderNo +1;
}

$sqlFecha = $db->conn->SQLDate("Y-m-d H:i A","b.RADI_FECH_RADI");
include "$ruta_raiz/include/query/queryCuerpo.php";
	
$rs=$db->conn->Execute($isql);
if ($rs->EOF and $busqRadicados)
{
    echo "<hr><center><b><span class='alarmas'>No se encuentra ning&uacute;n radicado con el criterio de b&uacute;squeda</span></center></b></hr>";
}
else
{
    $pager = new ADODB_Pager($db,$isql,'adodb', true,$orderNo,$orderTipo);
	$pager->checkAll = false;
	$pager->checkTitulo = false;
	$pager->toRefLinks = $linkPagina;
	$pager->toRefVars = $encabezado;
	$pager->descCarpetasGen=$descCarpetasGen;
	$pager->descCarpetasPer=$descCarpetasPer;
	$pager->Render($rows_per_page=20,$linkPagina,$checkbox=chkAnulados);
}
?>
	</form>
</td>
</tr>
</table>
</body>
</html>
