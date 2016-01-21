<?php
session_start();
/**
  * Modificacion Variables Globales Infometrika 2009-05
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
$db = new ConnectionHandler("$ruta_raiz");
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&num_exp=$num_exp&krd=$krd";
?>
<html>
<head>
<title>Menu Archivo</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<form name=from1 action="<?=$encabezadol?>" method='post' action='archivo.php?<?=session_name()?>=<?=trim(session_id())?>&krd=<?=$krd?>&<?="&num_exp=$num_exp"?>'>
<br>
<center>
<table border=0 width=30% cellpadding="0" cellspacing="5" class="borde_tab">
<tr>
        <TD class=titulos2 align="center">Archivo de Gesti&oacute;n Centralizado</TD>
</tr>
<tr>
<td class=listado2><span class="leidos2"></span>
<table>
<tr>
        <td class=listado2>
<?
$phpsession = session_name()."=".session_id();
$sql="select usua_admin_archivo from usuario where usua_login like '$krd'";
$dbg=$db->conn->Execute($sql);
if(!$dbg->EOF)$usua_perm_archi=$dbg->fields['USUA_ADMIN_ARCHIVO'];
if($usua_perm_archi!=3 and $usua_perm_archi!=4){
?>
        <span class="leidos2"><a href='../expediente/cuerpo_exp.php?<?=$phpsession?>&krd=<?=$krd?>&<?="fechaf=$fechah&carpeta=8&nomcarpeta=Expedientes&orno=1&adodb_next_page=1"; ?>' target='mainFrame' class="menu_princ"><b>B&uacute;squeda B&aacute;sica </a></span>
        </td>
</tr>
<tr>
        <td class="listado2">
    <span class="leidos2"><a href='../archivo/busqueda_archivo.php?<?=session_name()."=".session_id()."&dep_sel=$dep_sel&krd=$krd&fechah=$fechah&$orno&adodb_next_page&nomcarpeta&tipo_archivo=$tipo_archivo&carpeta'" ?>" target='mainFrame' class="menu_princ"><b>B&uacute;squeda Avanzada </a>
        </td>
</tr>
<? }?>
<tr>
        <td class=listado2>
        <span class="leidos2"><a  href='reporte_archivo.php?<?=session_name()."=".session_id()."&krd=$krd&adodb_next_page&nomcarpeta&fechah=$fechah&$orno&carpeta&tipo=1'&dep_sel=$dep_sel&adodb_next_page&nomcarpeta&tipo_archivo=$tipo_archivo&carpeta'" ?>' target='mainFrame' class="menu_princ"><b>Reporte por Radicados Archivados</a>
        </td>
</tr>
<?
if($usua_perm_archi!=3 and $usua_perm_archi!=4){
?>
<!--
<tr>
        <td class=listado2>
        <span class="leidos2"><a href='inventario.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page&nomcarpeta&carpeta&tipo=2'" ?>' target='mainFrame' class="menu_princ"><b>Cambio de Colecci&oacute;n</a>
        </td>
</tr>
 -->
 <!--
<tr>
        <td class=listado2>
        <span class="leidos2"><a href='inventario.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&nomcarpeta&carpeta&tipo=1'" ?>' target='mainFrame' class="menu_princ"><b>Inventario Consolidado Capacidad</a>
        </td>
</tr>
 -->
<!--
<tr>
        <td class=listado2>
        <span class="leidos2"><a href='inventario.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page&nomcarpeta&carpeta&tipo=3'" ?>' target='mainFrame' class="menu_princ"><b>Inventario Documental</a>
        </td>
</tr>
 -->
<tr>
        <td class=listado2>
        <span class="leidos2"><a href='sinexp.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page&nomcarpeta&carpeta&tipo=3'" ?>' target='mainFrame' class="menu_princ"><b>Radicados Archivados Sin Expediente</a>
        </td>
</tr>
<!--
<tr>
        <td class=listado2>
        <span class="leidos2"><a href='alerta.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>Alerta Expedientes</a>
        </td>
</tr>
 -->
<? }?>
<!--
<tr>
        <td class="listado2">
    <span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/busqueda_central.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>B&uacute;squeda Archivo Central</a>
    </td>
</tr>
 -->
<!--
<tr>
        <td class="listado2">
    <span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/busqueda_Fondo_Gestion.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>B&uacute;squeda Archivo Fondo Gesti&oacute;n</a>
        </td>
</tr>
 -->
<?
if($usua_perm_archi==3 or $usua_perm_archi==5){
?>
<tr>
        <td class="listado2">
    <span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/insertar_central.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>Insertar Archivo Central</a>
    </td>
</tr>
<?}
if($usua_perm_archi>=4){
?>
<tr>
        <td class="listado2">
    <span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/insertar_Fondo_Gestion.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>Insertar Archivo Fondo Gesti&oacute;n</a>
    </td>
</tr>
<? }
?>
<!--
<tr>
        <td class="listado2">
    <span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/reporte.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>Reporte Dependencia Archivo Central</a>
        </td>
</tr>
 -->
<?
//if($usua_perm_archi==2 or $usua_perm_archi==5){
?>
<tr>
        <td class="listado2">
        <span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/adminEdificio.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>Administraci&oacute;n de Edificios</a>
        </td>
</tr>
<tr>
        <td class="listado2">
        <span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/adminDepe.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>Administraci&oacute;n de Relaci&oacute;n Dependencia-Edificios</a>
        </td>
</tr>
<? //}?>
</table>
</table>
</center>
</form>
</html>