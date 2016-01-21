<?
session_start();
/**
  * Modificacion Variables Globales Fabian losada 2009-07
  * Licencia GNU/GPL 
  */

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;
error_reporting(0);

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
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&dependencia=$dependencia&krd=$krd&cod=$cod&tipo=3";
$encabezado2 = "$PHP_SELF?".session_name()."=".session_id()."&dependencia=$dependencia&krd=$krd&cod=$cod&tipo=4";
$encabezado3 = "$PHP_SELF?".session_name()."=".session_id()."&dependencia=$dependencia&krd=$krd&cod=$cod&tipo=6";
?>
<html>
<head>
<title>BORRAR TIPOS</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF">
<?
if($tipo==1){
?>
<form name="borrar" action="<?=$encabezadol?>" method="POST" >
<table width="90%" align="center" >
<tr><td class="titulos5">Esta seguro de borrar este edificio, con toda su informaci%oacute;n?</td></tr>
<tr><td><input type="submit" name="borrar" value="Borrar" align="middle" class="botones">
</td></tr>
</table>
<?
}
if($tipo==3){
$pru=$db->conn->Execute("select sgd_exp_edificio from sgd_exp_expediente where sgd_exp_edificio = '$cod'");
if($pru->RecordCount()==0){

$sqli="select sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre = '$cod'";
$rsi=$db->conn->Execute($sqli);
while(!$rsi->EOF){
$codi=$rsi->fields['SGD_EIT_CODIGO'];

$sqli2="select sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre = '$codi'";
$rsi2=$db->conn->Execute($sqli2);
while(!$rsi2->EOF){
$codi2=$rsi2->fields['SGD_EIT_CODIGO'];

$sqli3="select sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre = '$codi2'";
$rsi3=$db->conn->Execute($sqli3);
while(!$rsi3->EOF){
$codi3=$rsi3->fields['SGD_EIT_CODIGO'];

$sqli4="select sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre = '$codi3'";
$rsi4=$db->conn->Execute($sqli4);
while(!$rsi4->EOF){
$codi4=$rsi4->fields['SGD_EIT_CODIGO'];

$sqli5="select sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre = '$codi4'";
$rsi5=$db->conn->Execute($sqli5);
while(!$rsi5->EOF){
$codi5=$rsi5->fields['SGD_EIT_CODIGO'];

$sqli6="select sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre = '$codi5'";
$rsi6=$db->conn->Execute($sqli6);
while(!$rsi6->EOF){
$codi6=$rsi6->fields['SGD_EIT_CODIGO'];

$sqli7="select sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre = '$codi6'";
$rsi6=$db->conn->Execute($sqli7);
while(!$rsi7->EOF){
$codi7=$rsi7->fields['SGD_EIT_CODIGO'];
$sql="delete from sgd_eit_items where sgd_eit_codigo = '$codi7'";
$rs=$db->conn->Execute($sql);
$rsi7->MoveNext();
}
$sql="delete from sgd_eit_items where sgd_eit_codigo = '$codi6'";
$rs=$db->conn->Execute($sql);
$rsi6->MoveNext();
}
$sql="delete from sgd_eit_items where sgd_eit_codigo = '$codi5'";
$rs=$db->conn->Execute($sql);
$rsi5->MoveNext();
}
$sql="delete from sgd_eit_items where sgd_eit_codigo = '$codi4'";
$rs=$db->conn->Execute($sql);
$rsi4->MoveNext();
}
$sql="delete from sgd_eit_items where sgd_eit_codigo = '$codi3'";
$rs=$db->conn->Execute($sql);
$rsi3->MoveNext();
}
$sql="delete from sgd_eit_items where sgd_eit_codigo = '$codi2'";
$rs=$db->conn->Execute($sql);
$rsi2->MoveNext();
}
$sql="delete from sgd_eit_items where sgd_eit_codigo = '$codi'";
$rs=$db->conn->Execute($sql);
$rsi->MoveNext();
}
$sql="delete from sgd_eit_items where sgd_eit_codigo = '$cod'";
//$db->conn->debug=true;
$rs=$db->conn->Execute($sql);

echo "<p class='titulos5'>Edificio y subsecuente informaci&oacute;n eliminado</p>";
}
else echo "<p class='titulos5'>Error. Existe hist&oacute;rico con este edificio.</p>";
?>
<input name="Cerrar" type="button" class="botones" id="envia22" onClick="opener.regresar();window.close();" value=" Cerrar " >
<?
}
?>
</form>
<?
if($tipo==2){
?>
<form name="borrar2" action="<?=$encabezado2?>" method="POST" >
<table width="90%" align="center" >
<tr><td class="titulos5">Esta seguro de borrar este tipo?</td></tr>
<tr><td><input type="submit" name="borrar" value="Borrar" align="middle" class="botones">
</td></tr>
</table>
<?
}
if($tipo==4){
$pru=$db->conn->Execute("select sgd_exp_edificio from sgd_exp_expediente where sgd_exp_entrepa = '$cod' or sgd_exp_caja = '$cod'");
if($pru->RecordCount()==0){
$sql="delete from sgd_eit_items where sgd_eit_codigo = '$cod'";
$rs=$db->conn->Execute($sql);
echo "Registro borrado";
}
else echo "Existe hist&oacute;rico para esta clasificaci&oacute;n en el sistema. No se puede borrar este item.<BR>";
?>
<input name="Cerrar" type="button" class="botones" id="envia22" onClick="opener.regresar();window.close();" value=" Cerrar " >
<?
}
if($_GET['tipo']==5){
?>
<form name="borrar2" action="<?=$encabezado3?>" method="POST" >
<table width="90%" align="center" >
<tr><td class="titulos5">Esta seguro de borrar esta relaci&oacute;n?</td></tr>
<tr><td><input type="submit" name="borrar" value="Borrar" align="middle" class="botones">
</td></tr>
</table>
<?
}
if($tipo==6){
$sql="delete from sgd_arch_depe where sgd_arch_id = '$cod'";
$rs=$db->conn->Execute($sql);
echo "Registro borrado";
?>
<input name="Cerrar" type="button" class="botones" id="envia22" onClick="opener.regresar();window.close();" value=" Cerrar " >
<?
}
?>
</form>