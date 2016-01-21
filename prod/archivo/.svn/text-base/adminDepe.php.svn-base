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
	window.open("inDepe.php?<?=session_name()."=".session_id()?>&krd=<?=$krd?>","Ingresar Relacion Edificio-Dependencia","height=250,width=650,scrollbars=yes");

}
function Borrar(cod)
{
window.open("bortipo.php?<?=session_name()."=".session_id()?>&krd=<?=$krd?>&cod="+cod+"&tipo=5","Borrar Tipos","height=150,width=150,scrollbars=yes");
}
function Edifi(cod)
{
window.open("inDepe.php?<?=session_name()."=".session_id()?>&krd=<?=$krd?>&cod="+cod+"&edi=1","Editar Relacion Edificio-Dependencia","height=250,width=650,scrollbars=yes");
}
</script>
<html>
<head>
<title>ADMINISTRACI&Oacute;N DE RELACION DE EDIFICIOS-DEPENDENCIA</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
<link href="../../../br_3.7/estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<form name="adminEdificio" action="<?=$encabezadol?>" method="post" >
<table border="0" width="50%" align="center" cellpadding="0"  class="borde_tab">
<tr>
  <td colspan="3" class="titulos2">
  <center>ADMINISTRACI&Oacute;N DE RELACI&Oacute;N DE EDIFICIOS-DEPENDENCIA</center>
  </td>
</tr>
<tr>
 <td class="titulos5" colspan="3"><input type="button" name="NUEVO" value="NUEVA RELACI&Oacute;N" onClick="NuevoE();" class="botones_funcion">
 <a href='archivo.php?<?=session_name()?>=<?=trim(session_id())?>krd=<?=$krd?>'><input name='Regresar' align="middle" type="button" class="botones_funcion" id="envia22" value="Regresar" >
    <!--a href="ingEdificio.php?<?=session_name()."=".session_id()."&krd=$krd&fechah=$fechah&$orno&adodb_next_page" ?>' target='mainFrame' class="menu_princ""><b> Nuevo Edificio </b-->
  </td>
   </tr>
<br>
</table>
<table border="0" width="50%" cellpadding="0" align="center"  class="borde_tab">
<tr>
  <td class="titulos2">DEPENDENCIA</td>
  <td class="titulos2">EDIFICIO</td>
  <td class="titulos2">ITEM</td>
  <td class="titulos2">EDITAR</td>
  <td class="titulos2">BORRAR</td>
  </tr>
<?
//$db->conn->debug=true;
$conD=$db->conn->Concat("d.DEPE_CODI","'-'","d.DEPE_NOMB");
$rs=$db->conn->Execute("select $conD AS DEPE, a.sgd_arch_edificio,a.sgd_arch_item,a.sgd_arch_id from dependencia d, sgd_arch_depe a where d.depe_codi=to_number(a.sgd_arch_depe,'99999') ORDER BY a.SGD_ARCH_DEPE");
while(!$rs->EOF){
$nom=$rs->fields['DEPE'];
$cod=$rs->fields['SGD_ARCH_ID'];
$edi=$rs->fields['SGD_ARCH_EDIFICIO'];
$ite=$rs->fields['SGD_ARCH_ITEM'];
$rs2=$db->conn->Execute("select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo=$edi");
if(!$rs2->EOF)$edif=$rs2->fields['SGD_EIT_NOMBRE'];
$rs3=$db->conn->Execute("select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo=$ite");
if(!$rs3->EOF)$item=$rs3->fields['SGD_EIT_NOMBRE'];
else $item="N/A";
if($EDI==1)$sel="checked";
?>
<tr><td class="listado5"><?=$nom?></td>
<td class="listado5"><?=$edif?></td>
<td class="listado5"><?=$item?></td>
<td ><input type="radio" name="EDI" value="1" onClick="Edifi(<?=$cod?>);" <?=$sel?> align="absmiddle"></td>
<td><input type="radio" name="BORR" value="1" onClick="Borrar(<?=$cod?>);" <?=$sel?> align="absmiddle"></td>
</tr>
<?
$rs->MoveNext();
}

?>
</table>
</form>
</body>
</html>