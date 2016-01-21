<?
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
?>
<html>
<head>
<title>Ingreso Relacion Dependencia</title>
  <meta http-equiv="Cache-Control" content="cache">
  <meta http-equiv="Pragma" content="public">
<link rel="stylesheet" href="../estilos/orfeo.css">
<script>
function RegresarV(){
	window.location.assign("adminEdificio.php?<?=$encabezado1?>&fechah=$fechah&$orno&adodb_next_page");
}
</script>
<CENTER>
<form name=inDepe method='post' action='inDepe.php?<?=session_name()?>=<?=trim(session_id())?>&krd=<?=$krd?>&edit=<?=$edit?>&cod=<?=$cod?>'>
 <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" class="borde_tab"  >
<TR  class='titulos2'><TD colspan=4>&nbsp;</TD></TR>
<TR  class='titulos2'><TD class=titulosError colspan=4 align=center>RELACI&Oacute;N DEPENDENCIAS CON EDIFICIOS</TD></TR>
<TR  class='titulos2'><TD colspan=4>&nbsp;</TD></TR>
<?
//$db->conn->debug=true;
if($Ingresar or $Modificar){
	if($depe!="" and $exp_edificio!=""){
		if($exp_item=="")$exp_item2=0;
		else $exp_item2=$exp_item;
		if($Ingresar){
			$rp=$db->conn->Execute("select max(sgd_arch_id) AS DEM from sgd_arch_depe");
			$cont=$rp->fields['DEM']+1;
			$sql="insert into sgd_arch_depe (sgd_arch_id,sgd_arch_depe,sgd_arch_edificio,sgd_arch_item) values ($cont,'$depe',$exp_edificio,$exp_item2)";
			//$db->conn->debug=true;
			$rs=$db->conn->Execute($sql);
			if($rs->EOF)echo "El registro fue insertado";
			else echo "El registro no pudo ser ingresado";
		}
		if($Modificar){
			$sqm="update sgd_arch_depe set SGD_ARCH_DEPE='$depe',SGD_ARCH_EDIFICIO=$exp_edificio,SGD_ARCH_ITEM=$exp_item2 where sgd_arch_id=$cod ";
			$rsm=$db->conn->Execute($sqm);
			if($rsm->EOF)echo "El registro fue modificado";
			else echo "El registro no pudo ser modificado";
		}
	}
	elseif($depe=="")echo "Debe seleccionar una Dependencia";
	elseif($exp_edificio=="")echo "Debe seleccionar un Edificio";
	else echo "Debe seleccionar un Edificio y una Dependencia";
}

if($edi==1){
	$sqe="select * from sgd_arch_depe where sgd_arch_id = '$cod'";
	$rse=$db->conn->Execute($sqe);
	if(!$rse->EOF){
		$depe=$rse->fields['SGD_ARCH_DEPE'];
		$exp_edificio=$rse->fields['SGD_ARCH_EDIFICIO'];
		$exp_item=$rse->fields['SGD_ARCH_ITEM'];
		$rsdp=$db->conn->Execute("select codi_dpto,codi_muni from sgd_eit_items where sgd_eit_codigo=$exp_edificio");
		if(!$rsdp->EOF){
			$codDpto=$rsdp->fields['CODI_DPTO'];
			$codMuni=$rsdp->fields['CODI_MUNI'];
		}
	}
	$edit=2;
}
?>
<tr>
<input type="hidden" name="edit" value=<?=$edit?>>
<td class='titulos2'>DEPENDENCIA </td>
<TD class='titulos2' colspan=3>
<? 
	$conD=$db->conn->Concat("D.DEPE_CODI","'-'","D.DEPE_NOMB");
	$sql5="SELECT DISTINCT($conD), D.DEPE_CODI FROM DEPENDENCIA D, USUARIO U WHERE D.DEPE_CODI=U.DEPE_CODI AND U.USUA_ADMIN_ARCHIVO >= 1 ORDER BY D.DEPE_CODI";
	//$sql5="select ($conD) as detalle,DEPE_CODI from DEPENDENCIA order by DEPE_CODI";
	//$db->conn->debug=true;
	$rs=$db->conn->Execute($sql5);
	print $rs->GetMenu2('depe',$depe,true,false,"","class=select");
?>
</td>
</tr>
<tr class="titulos2">
<td  class='titulos2'>EDIFICIO </td>
<TD >
<? 
	$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where sgd_eit_cod_padre is null order by SGD_EIT_NOMBRE";
	$rs=$db->query($sql);
	print $rs->GetMenu2('exp_edificio',$exp_edificio,true,false,""," onChange='submit()' class=select");
	if($exp_edificio!=""){
?>
</td>
<?

	$sql="select SGD_EIT_NOMBRE from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = '$exp_edificio' order by SGD_EIT_NOMBRE ";
	$rs=$db->query($sql);
	if (!$rs->EOF)	$item21=$rs->fields["SGD_EIT_NOMBRE"];
	$item2=explode(' ',$item21);
	
?>
<td class='titulos2'><?=$item2[0]?></td>
<TD >
<? 
	$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE = '$exp_edificio' order by SGD_EIT_NOMBRE";
	$rs=$db->query($sql);
	print $rs->GetMenu2('exp_item',$exp_item,true,false,"","class=select");
	}
?>
</TD>
</tr>
<tr>
<td colspan="4" align="center">
<? if($edit>=1){ ?>
<input type=submit value=Modificar name=Modificar class="botones">
<?}
else{
?>
<input type=submit value=Ingresar name=Ingresar class="botones">
<? }?>
<input name='CERRAR' type="button" class="botones" id="envia22" onClick="opener.regresar();window.close();" value="CERRAR" align="middle" ></td>
</tr>
</table>
</form>
</center>
</html>