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
error_reporting(0);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
include_once "$ruta_raiz/include/tx/Historico.php";
$db->debug = false;
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&dependencia=$dependencia&krd=".$_GET['krd']."&codig=$codig&cod=$cod";
?>
<script>
function regresar()
{
	window.location.reload();
}

function NuevoV(codp)
{	var URL = "relacionTiposAlmac2.php?<?=session_name().'='.session_id().'&krd='.$krd?>&codp="+codp;
	//alert(URL);
	window.open(URL,"Relacion_Tipos_de_Almacenamiento","height=350,width=650,scrollbars=yes");
}

function NuevoT(codp)
{	var URL = "relacionTiposAlmac.php?<?=session_name().'='.session_id().'&krd='.$krd?>&codp="+codp;
	//alert(URL);
	window.open(URL,"Relacion_Tipos_de_Almacenamiento","height=450,width=650,scrollbars=yes");
}

function Editar(code,codp,codig)
{	var URL = "editTiposAlmac.php?<?=session_name().'='.session_id().'&krd='.$krd?>&cod="+code+"&codp="+codp+"&codig="+codig;
	alert(URL);
	window.open(URL, "Edicion_Tipos_de_Almacenamiento","height=150,width=650,scrollbars=yes");
}

function Borrar(cod)
{	var URL = "bortipo.php?<?=session_name().'='.session_id().'&krd='.$krd?>&cod="+cod+"&tipo=2";
	alert(URL);
	window.open(URL,"Borrar_Tipos","height=150,width=150,scrollbars=yes");
}
</script>
<head>
<title>EDICI&Oacute;N DE EDIFICIOS</title>
<link href="../estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>



<form name="ediEdificio" action="<?=$encabezadol?>" method="post" >
<table border="0" width="90%" cellpadding="0"  class="borde_tab">
<tr>
  <td colspan="6" class="titulos2">
  <center>EDICI&Oacute;N DE EDIFICIOS</center>
  </td>
</tr>
<?
$codp=$cod;
?>
<tr><td class="titulos5" colspan="6" align="center"><input type="button" class="botones"  align="middle" name="nuevo" value="NUEVO" onClick="NuevoV(<?=$codp?>);">
<input type="button" class="botones_largo"  align="middle" name="nuevo" value="NUEVO INGRESO GRUPO" onClick="NuevoT(<?=$codp?>);">
<input type="button" name="cerrar" class="botones" value="SALIR" onClick="window.close();"></td></tr>
<tr>
<td class="titulos5" colspan="6" >
<?
$sq="select sgd_eit_nombre from sgd_eit_items where sgd_eit_cod_padre='$cod'";
$rt=$db->conn->Execute($sq);
if(!$rt->EOF)$nop=$rt->fields['SGD_EIT_NOMBRE'];
$nod=explode(' ',$nop);
echo $nod[0]."  ";
$c=0;
$cp=0;
$conD=$db->conn->Concat("sgd_eit_codigo","'-'","sgd_eit_nombre");
//$sqli="select ($conD) as detalle,sgd_eit_codigo from sgd_eit_items where sgd_eit_codigo='$cod'";
$sqli="select ($conD) as detalle,sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre='$cod'";
//$db->conn->debug=true;
$rsi=$db->conn->Execute($sqli);
print $rsi->GetMenu2('codig',$codig,true,false,"","class='select'; onchange=submit();");
/*if(!$rsi->EOF)$nomp[$cp]=$rsi->fields['SGD_EIT_NOMBRE'];
$sql="select * from sgd_eit_items where sgd_eit_cod_padre like '$cod'";
$rs=$db->conn->Execute($sql);
while(!$rs->EOF){
$nom[$c]=$rs->fields['SGD_EIT_NOMBRE'];
$codi[$c]=$rs->fields['SGD_EIT_CODIGO'];
?>
<tr>
<td class="titulos5"><?=$cod?></td>
<td class="titulos5"><?=$nomp[$cp]?></td>
<td class="titulos5"><?=$codi[$c]?></td>
<td class="titulos5"><?=$nom[$c]?></td>
<td class="titulos5"><input type="radio" name="edit" value="1" onClick="Editar(<?=$codi[$c]?>,<?=$codp?>)" <?=$sel?> align="absmiddle"></td>
<td class="titulos5"><input type="radio" name="borr" value="1" onClick="Borrar(<?=$codi[$c]?>)" <?=$sel2?> align="absmiddle"></td></tr>
<?
$c++;
$rs->MoveNext();
}*/
?>
</tr>
<tr>
<td class="titulos2"><b>C&oacute;digo del Padre</b></td>
<td class="titulos2"><B>Nombre del Padre</B></td>
<td class="titulos2"><b>C&oacute;digo del Hijo</b></td>
<td class="titulos2"><B>Nombre del Hijo</B></td>
<td class="titulos2"><B>Editar</B></td>
<td class="titulos2"><B>Borrar</B></td></tr>

<?

$sqt="select count(sgd_eit_codigo) as co from sgd_eit_items where sgd_eit_codigo='$cod'";
$rsty=$db->conn->Execute($sqt);
if(!$rsty->EOF)$c=$rsty->fields['CO'];
$cp++;
$tm=$c;
for($i=0;$i<$tm;$i++){
$sqli="select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codig'";
//$db->conn->debug=true;
$rsi=$db->conn->Execute($sqli);
if(!$rsi->EOF)$nomp[$cp]=$rsi->fields['SGD_EIT_NOMBRE'];
$codigo=$codig;
$sql="select * from sgd_eit_items where sgd_eit_cod_padre = ".$codig;
$rs=$db->conn->Execute($sql);
while(!$rs->EOF){
$nom[$c]=$rs->fields['SGD_EIT_NOMBRE'];
$codi[$c]=$rs->fields['SGD_EIT_CODIGO'];
?>
<tr><td class="titulos5"><?=$codigo?></td>
<td class="titulos5"><?=$nomp[$cp]?></td>
<td class="titulos5"><?=$codi[$c]?></td>
<td class="titulos5"><?=$nom[$c]?></td>
<td class="titulos5"><input type="radio" name="btn_acc1" value="1" onClick="Editar(<?=$codi[$c]?>,<?=$codp?>,<?=$codig?>)" <?=$sel?> align="absmiddle"></td>
<td class="titulos5"><input type="radio" name="btn_acc1" value="2" onClick="Borrar(<?=$codi[$c]?>)" <?=$sel2?> align="absmiddle"></td></tr>
<?
$c++;
$rs->MoveNext();
}
$cp++;
}

$tm1=$c;
for($i=$tm;$i<$tm1;$i++){
$sqli="select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codi[$i]'";
//$db->conn->debug=true;
$rsi=$db->conn->Execute($sqli);
if(!$rsi->EOF)$nomp[$cp]=$rsi->fields['SGD_EIT_NOMBRE'];
$codigo=$codi[$i];
$sql="select * from sgd_eit_items where sgd_eit_cod_padre = '$codi[$i]'";
$rs=$db->conn->Execute($sql);
while(!$rs->EOF){
$nom[$c]=$rs->fields['SGD_EIT_NOMBRE'];
$codi[$c]=$rs->fields['SGD_EIT_CODIGO'];
?>
<tr><td class="titulos5"><?=$codigo?></td>
<td class="titulos5"><?=$nomp[$cp]?></td>
<td class="titulos5"><?=$codi[$c]?></td>
<td class="titulos5"><?=$nom[$c]?></td>
<td class="titulos5"><input type="radio" name="btn_acc2" value="1" onClick="Editar(<?=$codi[$c]?>,<?=$codp?>,<?=$codig?>)" <?=$sel?> align="absmiddle"></td>
<td class="titulos5"><input type="radio" name="btn_acc2" value="2" onClick="Borrar(<?=$codi[$c]?>)" <?=$sel2?> align="absmiddle"></td></tr>
<?
$c++;
$rs->MoveNext();
}
$cp++;
}

$tm2=$c;
for($i=$tm1;$i<$tm2;$i++){
$sqli="select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codi[$i]'";
//$db->conn->debug=true;
$rsi=$db->conn->Execute($sqli);
if(!$rsi->EOF)$nomp[$cp]=$rsi->fields['SGD_EIT_NOMBRE'];
$codigo=$codi[$i];
$sql="select * from sgd_eit_items where sgd_eit_cod_padre = '$codi[$i]'";
$rs=$db->conn->Execute($sql);
while(!$rs->EOF){
$nom[$c]=$rs->fields['SGD_EIT_NOMBRE'];
$codi[$c]=$rs->fields['SGD_EIT_CODIGO'];
?>
<tr><td class="titulos5"><?=$codigo?></td>
<td class="titulos5"><?=$nomp[$cp]?></td>
<td class="titulos5"><?=$codi[$c]?></td>
<td class="titulos5"><?=$nom[$c]?></td>
<td class="titulos5"><input type="radio" name="btn_acc3" value="1" onClick="Editar(<?=$codi[$c]?>,<?=$codp?>,<?=$codig?>)" <?=$sel?> align="absmiddle"></td>
<td class="titulos5"><input type="radio" name="btn_acc3" value="2" onClick="Borrar(<?=$codi[$c]?>)" <?=$sel2?> align="absmiddle"></td></tr>
<?
$c++;
$rs->MoveNext();
}
$cp++;
}

$tm3=$c;
for($i=$tm2;$i<$tm3;$i++){
$sqli="select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codi[$i]'";
//$db->conn->debug=true;
$rsi=$db->conn->Execute($sqli);
if(!$rsi->EOF)$nomp[$cp]=$rsi->fields['SGD_EIT_NOMBRE'];
$codigo=$codi[$i];
$sql="select * from sgd_eit_items where sgd_eit_cod_padre = '$codi[$i]'";
$rs=$db->conn->Execute($sql);
while(!$rs->EOF){
$nom[$c]=$rs->fields['SGD_EIT_NOMBRE'];
$codi[$c]=$rs->fields['SGD_EIT_CODIGO'];
?>
<tr><td class="titulos5"><?=$codigo?></td>
<td class="titulos5"><?=$nomp[$cp]?></td>
<td class="titulos5"><?=$codi[$c]?></td>
<td class="titulos5"><?=$nom[$c]?></td>
<td class="titulos5"><input type="radio" name="edit" value="1" onClick="Editar(<?=$codi[$c]?>,<?=$codp?>,<?=$codig?>)" <?=$sel?> align="absmiddle"></td>
<td class="titulos5"><input type="radio" name="borr" value="1" onClick="Borrar(<?=$codi[$c]?>)" <?=$sel2?> align="absmiddle"></td></tr>
<? 
$c++;
$rs->MoveNext();
}
$cp++;
}

$tm4=$c;
for($i=$tm3;$i<$tm4;$i++){
$sqli="select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codi[$i]'";
//$db->conn->debug=true;
$rsi=$db->conn->Execute($sqli);
if(!$rsi->EOF)$nomp[$cp]=$rsi->fields['SGD_EIT_NOMBRE'];
$codigo=$codi[$i];
$sql="select * from sgd_eit_items where sgd_eit_cod_padre = '$codi[$i]'";
$rs=$db->conn->Execute($sql);
while(!$rs->EOF){
$nom[$c]=$rs->fields['SGD_EIT_NOMBRE'];
$codi[$c]=$rs->fields['SGD_EIT_CODIGO'];
?>
<tr><td class="titulos5"><?=$codigo?></td>
<td class="titulos5"><?=$nomp[$cp]?></td>
<td class="titulos5"><?=$codi[$c]?></td>
<td class="titulos5"><?=$nom[$c]?></td>
<td class="titulos5"><input type="radio" name="edit" value="1" onClick="Editar(<?=$codi[$c]?>,<?=$codp?>,<?=$codig?>)" <?=$sel?> align="absmiddle"></td>
<td class="titulos5"><input type="radio" name="borr" value="1" onClick="Borrar(<?=$codi[$c]?>)" <?=$sel2?> align="absmiddle"></td></tr>
<?
$c++;
$rs->MoveNext();
}
$cp++;
}
?>
</form>