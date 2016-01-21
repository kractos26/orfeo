<?
session_start();

if (!$ruta_raiz) $ruta_raiz = "..";
    if (!$_SESSION['dependencia']) header ("Location: $ruta_raiz/cerrar_session.php");

/**
* Pagina Archivo.php que muestra el contenido de las Carpetas
* Modificado por Correlibre.org en el año 2012
* Se añadio compatibilidad con variables globales en Off
* @autor Jairo Losada 2012-05
* @licencia GNU/GPL V 3
*/

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;

define('ADODB_ASSOC_CASE', 2);

$krd            = $_SESSION["krd"];
$dependencia    = $_SESSION["dependencia"];
$usua_doc       = $_SESSION["usua_doc"];
$codusuario     = $_SESSION["codusuario"];
$usua_perm_archi = $_SESSION["usua_perm_archi"];

include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&num_exp=$num_exp";
?>
<html height=50,width=150>
<head>
<title>Menu Archivo</title>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
<CENTER>
<body bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
 <link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
 <script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js">
 </script>

 <form name=from1 action="<?=$encabezadol?>" method='post' action='archivo.php?<?=session_name()?>=<?=trim(session_id())?>&krd=<?=$krd?>&<?="&num_exp=$num_exp"?>'>
<br>

<table border=0 width 100% cellpadding="0" cellspacing="5" class="borde_tab">
<TD class=titulos2 align="center" >
		Menu de Archivo
</TD>
<tr>
<td class=listado2>
<?
	$phpsession = session_name()."=".session_id();
	?>
<span class="leidos2"><a href='../expediente/cuerpo_exp.php?<?=$phpsession?>&<?="fechaf=$fechah&carpeta=8&nomcarpeta=Expedientes&orno=1&adodb_next_page=1"; ?>' target='mainFrame' class="menu_princ"><b>1. Busqueda Basica </a></span>
	</td>
	</tr>
<tr>
  <td class="listado2">
<span class="leidos2"><a href='../archivo/busqueda_archivo.php?<?=session_name()."=".session_id()."&dep_sel=$dep_sel&fechah=$fechah&$orno&adodb_next_page&nomcarpeta&tipo_archivo=$tipo_archivo&carpeta'" ?>" target='mainFrame' class="menu_princ"><b>2. Busqueda Avanzada </a>
</td>
</tr>
    <tr>
    <td class=listado2>
<span class="leidos2"><a  href='reporte_archivo.php?<?=session_name()."=".session_id()."&adodb_next_page&nomcarpeta&fechah=$fechah&$orno&carpeta&tipo=1'" ?>' target='mainFrame' class="menu_princ"><b>3. Reporte por Radicados Archivados</a>
</td>
</tr>
<tr>
<td class=listado2>

<span class="leidos2"><a href='inventario.php?<?=session_name()."=".session_id()."&fechah=$fechah&$orno&adodb_next_page&nomcarpeta&carpeta&tipo=2'" ?>' target='mainFrame' class="menu_princ"><b> 4.Cambio de Coleccion</a>
</td>
</tr>
<tr>
<td class=listado2>

<span class="leidos2"><a href='inventario.php?<?=session_name()."=".session_id()."&fechah=$fechah&$orno&nomcarpeta&carpeta&tipo=1'" ?>' target='mainFrame' class="menu_princ"><b>5.Inventario Consolidado Capacidad</a>	  </td>
</tr>
<tr>
<td class=listado2>
<span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/formatoUnico.php?<?=session_name()."=".session_id()."&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>6.Formato Unico De Inventario Documental    </a></td>
</tr>
<tr>
<td class=listado2>
<span class="leidos2"><a href='sinexp.php?<?=session_name()."=".session_id()."&fechah=$fechah&$orno&adodb_next_page&nomcarpeta&carpeta&tipo=3'" ?>' target='mainFrame' class="menu_princ"><b>7.Radicados Archivados Sin Expediente</a>	</td>
</tr>
<tr>
	<td class=listado2>
<span class="leidos2"><a href='alerta.php?<?=session_name()."=".session_id()."&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>8.Alerta Expedientes</a>	</td>
	</tr>
<!--
    /**
      * Modificado Supersolidaria 05-Dic-2006
      * Se agreg� la opci�n Administarci�n de Edificios.
      */
-->
<?
if($usua_perm_archi==2){
?>
<tr>
  <td class="listado2">
    <span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/adminEdificio.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>9.Administraci&oacute;n de Edificios</a>  </td>
</tr>
<td class="listado2">
    <span class="leidos2"><a href='<?php print $ruta_raiz; ?>/archivo/adminDepe.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ"><b>10.Administracion de Relaci&oacute;n Dependencia-Edificios</a>  </td>
</tr>
<? }?>
</table>
</form>
</CENTER>
</html>