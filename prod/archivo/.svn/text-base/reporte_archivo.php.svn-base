<?php
/********************************************************************************/
/*DESCRIPCION: Reporte que muestra los radicados archivados                     */
/*FECHA: 15 Diciembre de 2006*/
/*AUTOR: Supersolidaria*/
/*********************************************************************************/
?>
<?php

$per=1;
session_start();
/**
  * Modificacion Variables Globales Fabian losada 2009-07
  * Licencia GNU/GPL 
  */

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;


$krd = $_SESSION["krd"];
$dependencia = $_SESSION["dependencia"];
$usua_doc = $_SESSION["usua_doc"];
$codusuario = $_SESSION["codusuario"];
$tpNumRad = $_SESSION["tpNumRad"];
$tpPerRad = $_SESSION["tpPerRad"];
$tpDescRad = $_SESSION["tpDescRad"];
$tpDepeRad = $_SESSION["tpDepeRad"];
$ruta_raiz = "..";
include_once("$ruta_raiz/include/db/ConnectionHandler.php");

// Modificado SGD 22-Agosto-2007
require( "./funReporteArchivo.php" );
$db = new ConnectionHandler("$ruta_raiz");

if( trim( $orderTipo ) == "" )
{
    $orderTipo="DESC";
}
if( $orden_cambio == 1 )
{
    if( trim( $orderTipo ) != "DESC" )
    {
       $orderTipo = "DESC";
    }
    else
    {
        $orderTipo = "ASC";
    }
}

if( strlen( $orderNo ) == 0 )
{
    $orderNo = "2";
    $order = 3;
}
else
{
    $order = $orderNo +1;
}

$encabezado = "".session_name()."=".session_id()."&krd=$krd&dep_sel=$dep_sel&codigoUsuario=$codigoUsuario&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&chkCarpeta=$chkCarpeta&busqRadicados=$busqRadicados&nomcarpeta=$nomcarpeta&agendado=$agendado&";
$linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";

if( $_GET['fechaIniSel'] == "" && $_GET['fechaInifSel'] == "" )
{
	// Modificado SGD 21-Agosto-2007
	//$encabezado = "".session_name()."=".session_id()."&fechaIniSel=".$_POST['fechaIni']."&fechaInifSel=".$_POST['fechaInif']."&adodb_next_page=1&krd=$krd&depeBuscada=$dep_sel&codigoUsuario=$codigoUsuario&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&nomcarpeta=$nomcarpeta&agendado=$agendado&orderTipo=$orderTipo&orderNo=";
	$encabezado = "".session_name()."=".session_id()."&fechaIniSel=".$_POST['fechaIni']."&fechaInifSel=".$_POST['fechaInif']."&adodb_next_page=0&krd=$krd&depeBuscada=$dep_sel&codigoUsuario=$codigoUsuario&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&nomcarpeta=$nomcarpeta&agendado=$agendado&orderTipo=$orderTipo&orderNo=";
}
else
{
    // Modificado SGD 21-Agosto-2007
	//$encabezado = "".session_name()."=".session_id()."&fechaIniSel=".$_GET['fechaIniSel']."&fechaInifSel=".$_GET['fechaInifSel']."&adodb_next_page=1&krd=$krd&depeBuscada=$dep_sel&codigoUsuario=$codigoUsuario&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&nomcarpeta=$nomcarpeta&agendado=$agendado&orderTipo=$orderTipo&orderNo=";
    $encabezado = "".session_name()."=".session_id()."&fechaIniSel=".$_GET['fechaIniSel']."&fechaInifSel=".$_GET['fechaInifSel']."&fechaIni=".$_GET['fechaIni']."&fechaInif=".$_GET['fechaInif']."&adodb_next_page=0&krd=$krd&depeBuscada=$dep_sel&codigoUsuario=$codigoUsuario&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&nomcarpeta=$nomcarpeta&agendado=$agendado&orderTipo=$orderTipo&orderNo=";
}
?>
<html>
<head>
<title>REPORTE DE RADICADOS ARCHIVADOS</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
 <link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
 <script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js">
 </script><style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<form name="reporte_archivo" action='<?=$_SERVER['PHP_SELF']?>?<?=$encabezado?>' method="post">
<table border="0" width="90%" cellpadding="0"  class="borde_tab" align="center">
<tr>
  <TD height="35" colspan="2" class="titulos2"><center>
    REPORTE DE RADICADOS ARCHIVADOS
      </div></td>
  </tr>
<tr>
  <TD height="30" class="titulos5">
  <?
        if(!$dep_sel) $dep_sel = 0;
        $fechah=date("dmy") . " ". time("h_m_s");
	$fecha_hoy = Date("Y-m-d");
	$sqlFechaHoy=$db->conn->DBDate($fecha_hoy);
	$check=1;
	$fechaf=date("dmy") . "_" . time("hms");
        $numeroa=0;$numero=0;$numeros=0;$numerot=0;$numerop=0;$numeroh=0;
        
        include("$ruta_raiz/include/query/expediente/queryReporte.php");

	$queryUs = "select depe_codi from usuario where USUA_LOGIN = '$krd' AND USUA_ESTA = '1'";
	//$db->conn->debug=true;
	$rsUs = $db->query($queryUs);
	$depe = $rsUs->fields["DEPE_CODI"];
	if ($dep_sel != 0)  {
			$whereDependencia = " AND DEPE_CODI=$depe";
		}
?>
  <div align="right"><b>Dependencia que Archiva </b></div></td>
  <TD class="titulos5">
  <? $conD=$db->conn->Concat("D.DEPE_CODI","'-'","D.DEPE_NOMB");
  error_reporting(0);
  $query2="SELECT DISTINCT $conD, D.DEPE_CODI FROM DEPENDENCIA D, USUARIO U WHERE D.DEPE_CODI=U.DEPE_CODI AND U.USUA_ADMIN_ARCHIVO >= 1 ORDER BY D.DEPE_CODI";
  $rs1=$db->conn->query($query2);
  print $rs1->GetMenu2('dep_sel',$_POST['dep_sel'],"0:--- TODAS LAS DEPENDENCIAS ---",false,"","  class=select onChange='submit();'");
  ?>
 </td>
<tr>
  <TD height="23" class="titulos5"><div align="right">Tipo de Radicado</div></td>
  <TD class="titulos5">
  <?
	$sql="select sgd_trad_descr,sgd_trad_codigo from sgd_trad_tiporad order by sgd_trad_codigo";
	$rs=$db->query($sql);
	print $rs->GetMenu2("trad", $_POST['trad'], "0:-- Seleccione --", false,"","class='select'" );
  ?>
  </td>
<?php 
if (isset($_POST['dep_sel']) && $_POST['dep_sel'] > 0)
{
?>
<tr>
	<TD height="26" class="titulos5"><div align="right">Usuario que Archiva </div></td>
	<TD class="titulos5">
<?php
$whereUsSelect = "";
if(!$usActivos)
{
	$whereUsua = " u.USUA_ESTA = '1' ";
	$whereUsSelect = " AND u.USUA_ESTA = '1' ";
	$whereActivos = " AND b.USUA_ESTA='1'";
}
if ($_POST['dep_sel'] != 0)
{
	$isqlus = "SELECT u.USUA_NOMB,u.USUA_CODI FROM USUARIO u, DEPENDENCIA D WHERE u.USUA_ESTA = '1' AND D.DEPE_CODI=U.DEPE_CODI AND U.DEPE_CODI='".$_POST['dep_sel']."' ORDER BY u.USUA_NOMB";
	$rs1=$db->conn->Execute($isqlus);
	print $rs1->GetMenu2("codigoUsuario", $_POST['codigoUsuario'], "0:-- AGRUPAR POR TODOS LOS USUARIOS --", false,"","class='select'" );
}
?>
</td>
</tr>
<?php
}
/* Modificado Supersolidaria 05-Dic-2006
 * El rango inicial de fechas se estableci� en 1 mes.
 */
// Fecha inicial
if( $_GET['fechaIniSel'] == "" && $_GET['fechaIni'] == "" )
{
    $fechaIni = date( 'Y-m-d', strtotime( "-1 month" ) );
}
else if( $_GET['fechaIni'] != "" )
{
    $fechaIni = $_GET['fechaIni'];
}
else if(  $_GET['fechaIniSel'] != "" )
{
    $fechaIni = $_GET['fechaIniSel'];
}
// Fecha final
if( $_GET['fechaInifSel'] == "" && $_GET['fechaInif'] == "" )
{
    $fechaInif = date( 'Y-m-d' );
}
else if( $_POST['fechaInif'] != "" )
{
    $fechaInif = $_POST['fechaInif'];
}
else if( $_GET['fechaInifSel'] != "" )
{
    $fechaInif = $_GET['fechaInifSel'];
}
?>
<tr>
  <TD height="23" class="titulos5"><div align="right">
    <div align="right">Fecha Archivados Desde
    </div></td>
  <TD class="titulos5">
	<script language="javascript">
   	var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "reporte_archivo", "fechaIni","btnDate1","<?=$fechaIni?>",scBTNMODE_CUSTOMBLUE);
  				dateAvailable1.date = "<?=date('Y-m-d');?>";
				dateAvailable1.writeControl();
				dateAvailable1.dateFormat="yyyy-MM-dd";
	</script>

  </td>
<tr>
  <TD width="202" height="24" class="titulos5" align="right">&nbsp;Fecha Archivados Hasta</td>
  <TD width="323" class="titulos5">
  	<script language="javascript">
	var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "reporte_archivo", "fechaInif","btnDate2","<?=$fechaInif?>",scBTNMODE_CUSTOMBLUE);
  				dateAvailable2.date = "<?=date('Y-m-d');?>";
				dateAvailable2.writeControl();
				dateAvailable2.dateFormat="yyyy-MM-dd";
	</script>
</td>
<tr>
<TD width="202" height="24" class="titulos5">&nbsp;
    <div align="right">B&uacute;squeda Archivo Central</div></td>
<TD width="323" class="titulos5">
<?
if($arch==1)$set="checked";
?>
<input type="checkbox" name="arch" value="1" <?=$set?>>
</td>
</tr>
<tr>
	<td align="center" colspan="3" class="titulos5"><input type="submit" class="botones" value="Buscar" name="Buscar">
		<input type="hidden" name="tipoEstadistica" id="tipoEstadistica" value=20></input>
		<input type="hidden" name="ordenarPor" id="ordenarPor" value='1'></input>
	  <a href='archivo.php?<?=session_name()?>=<?=trim(session_id())?>&krd=<?=$krd?>'><input type="button" class="botones" value="Cancelar" name="Cancelar">
	</td>
</tr>
</table>
<p>&nbsp;</p>
<!-- Modificado SGD 22-Agosto-2007 --> 
</form>
<?
if($Buscar)
{	$tipoEstadistica =20;
	$reporte = 1;
	include_once( "$ruta_raiz/include/query/archivo/queryReportePorRadicados.php" );
	// Modificado SGD 17-Agosto-2007	
	$queryE = $queryUs;
	if($genDetalle==1) $queryUs = $queryEDetalle;

	if($genTodosDetalle==1) $queryUs = $queryETodosDetalle;
	
	$rsE = $db->conn->Execute($queryUs);
   
	// Modificado SGD 17-Agosto-2007
	$titulos=array("0#USUARIO","1#N&Uacute;MERO FOLIOS","2#RADICADOS");
   
	include "tablaHtml.php";
}
$db->conn->Close();
?>
<p>&nbsp;</p>
</form>
</html>