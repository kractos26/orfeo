<?php
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
	$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug = true;
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&dependencia=$dependencia&krd=$krd";
?>
<script>
function regresar(){
	window.location.reload();
}
function NuevoE(){
	window.open("ingEdificio.php?<?=session_name()."=".session_id()?>&krd=<?=$_GET['krd']?>","Ingresar_Edificios","height=250,width=700,scrollbars=yes");

}

function Borrar(cod)
{
	var width  = 200;
	var height = 150;
	var left   = (screen.width  - width)/2;
	var top    = (screen.height - height)/2;
	var params = 'width='+width+', height='+height+ ', top='+top+', left='+left;
	newwin=window.open("bortipo.php?<?=session_name()."=".session_id()?>&krd=<?=$_GET['krd']?>&cod="+cod+"&tipo=1","Borrar_Tipos",params);
	if (window.focus) {newwin.focus()}
	return false;
}

function Edifi(cod)
{
window.open("ediEdificio.php?<?=session_name()."=".session_id()?>&krd=<?=$_GET['krd']?>&cod="+cod+"","Editar_Edificios","height=750,width=650,scrollbars=yes");
}
</script>
<html>
<head>
<title>ADMINISTRACI&Oacute;N DE EDIFICIOS</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF">
<form name="adminEdificio" action="<?=$encabezadol?>" method="post" >
<table border="0" width="50%" align="center" cellpadding="0"  class="borde_tab">
<tr>
  <td colspan="3" class="titulos2">
  <center>ADMINISTRACI&Oacute;N DE EDIFICIOS</center>
  </td>
</tr>
<tr>
 <td class="titulos5"><input type="button" name="NUEVO" value="NUEVO EDIFICIO" onClick="NuevoE();" class="botones_funcion">
 <a href='archivo.php?<?=session_name()?>=<?=trim(session_id())?>krd=<?=$_GET['krd']?>'><input name='Regresar' align="middle" type="button" class="botones_funcion" id="envia22" value="Regresar" >
    <!--a href="ingEdificio.php?<?=session_name()."=".session_id()."&krd=".$_GET['krd']."&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ""><b> Nuevo Edificio </b-->
  </td>
   </tr>
<br>
</table>
<table border="0" width="50%" cellpadding="0" align="center"  class="borde_tab">
<tr>
  <td class="titulos2">EDIFICIO</td>
  <td class="titulos2">EDITAR</td>
  <td class="titulos2">BORRAR</td>
  </tr>
<?
$sqlp="select sgd_eit_nombre,sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre =0 or sgd_eit_cod_padre is null";
$rs=$db->conn->Execute($sqlp);
while(!$rs->EOF){
$nom=$rs->fields['SGD_EIT_NOMBRE'];
$cod=$rs->fields['SGD_EIT_CODIGO'];
if($EDI==1)$sel="checked";
?>
<tr><td class="listado5"><?=$nom?></td>
<td ><input type="radio" name="btn_acc1" value="1" onClick="Edifi(<?=$cod?>);" <?=$sel?> align="absmiddle"></td>
<td><input type="radio" name="btn_acc1" value="2" onClick="Borrar(<?=$cod?>);" <?=$sel?> align="absmiddle"></td>
</tr>
<?
$rs->MoveNext();
}

?>
</table>
</form>
</body>
</html>