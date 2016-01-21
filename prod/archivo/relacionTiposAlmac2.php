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
include_once "$ruta_raiz/include/tx/Historico.php";
include_once "$ruta_raiz/include/tx/Expediente.php";

//$db->conn->debug = true;
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&dependencia=$dependencia&krd=$krd&tipo=$tipo&codp=$codp&codig=$codig";

?>
<html>
<head>
<title>RELACI&Oacute;N ENTRE TIPOS DE ALMACENAMIENTO</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF">
<form name="relacionTiposAlmac" action="<?=$encabezadol?>" method="POST" >
<?
if($grabar){
$t=0;
if($tipoAlmacPadre==$codp){
$nom=strtoupper($hijo);
$sig=strtoupper($Shijo);
	$sql="insert into sgd_eit_items (sgd_eit_codigo,sgd_eit_cod_padre,sgd_eit_nombre,sgd_eit_sigla) values ( ".$db->conn->nextId( 'SEC_EDIFICIO' ).",'$tipoAlmacPadre','$nom','$sig')";

$rs=$db->conn->Execute($sql);
}
else
{
for($i=1;$i<=$cantidad;$i++){
$hijoc=$hijo." ".$i;
$Shijoc=$Shijo.$i;
$nomc=strtoupper($hijoc);
$sigc=strtoupper($Shijoc);
$sql="insert into sgd_eit_items (sgd_eit_codigo,sgd_eit_cod_padre,sgd_eit_nombre,sgd_eit_sigla) values ( ".$db->conn->nextId( 'SEC_EDIFICIO' ).",'$tipoAlmacPadre','$nomc','$sigc')";
//$db->conn->debug=true;
$rs=$db->conn->Execute($sql);
}
}
if($rs->EOF)$t+=1;
if($t==0)echo "No se pudo ingresar el registro";
else echo "El registro fue ingresado";
}
?>
<table border="0" width="90%" cellpadding="0" class="borde_tab">
<tr>
  <td height="35" colspan="5" class="titulos2">
  <center>RELACI&Oacute;N ENTRE TIPOS DE ALMACENAMIENTO</center>
  </td>
</tr>
<tr>
<td class="titulos5" colspan="5" >
<?
$sq="select sgd_eit_nombre from sgd_eit_items where sgd_eit_cod_padre=".$_GET['codp'];
$rt=$db->conn->Execute($sq);
if(!$rt->EOF)$nop=$rt->fields['SGD_EIT_NOMBRE'];
$nod=explode(' ',$nop);
echo $nod[0]."  ";
$c=0;
$cp=0;
$conD=$db->conn->Concat("sgd_eit_codigo","'-'","sgd_eit_nombre");
$sqli="select ($conD) as detalle,sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre=".$_GET['codp']." or sgd_eit_codigo= ".$_GET['codp'];
$rsi=$db->conn->Execute($sqli);
print $rsi->GetMenu2('codig',$codig,true,false,"","class='select'; onchange=submit();");
?>
</tr>
<tr>
<td class="titulos2">Nombre Padre:<br>
  Cod_pa-Cod-Nombre

<?php
$i=1;
 	if($codig!=$_POST['codp']){
	$sqm1="select * from sgd_eit_items where sgd_eit_cod_padre = '$codig'";
	
	$rs1=$db->conn->Execute($sqm1);
	while(!$rs1->EOF){
		$cod_p=$rs1->fields['SGD_EIT_CODIGO'];
		$nom[$i]=$codig."-".$cod_p."-".$rs1->fields['SGD_EIT_NOMBRE'];
		$codi[$i]=$rs1->fields['SGD_EIT_CODIGO'];
		$sqm2="select * from sgd_eit_items where sgd_eit_cod_padre = '".$codi[$i]."'";
		$rs2=$db->conn->Execute($sqm2);
		$i++;
		while(!$rs2->EOF){
			$cod_p=$rs2->fields['SGD_EIT_CODIGO'];
			$cod_p2=$rs2->fields['SGD_EIT_COD_PADRE'];
			$codi[$i]=$rs2->fields['SGD_EIT_CODIGO'];
			$nom[$i]=$cod_p2."-".$cod_p."-".$rs2->fields['SGD_EIT_NOMBRE'];
			$sqm3="select * from sgd_eit_items where sgd_eit_cod_padre = '".$codi[$i]."'";
			$rs3=$db->conn->Execute($sqm3);
			$i++;
			while(!$rs3->EOF){
				$cod_p=$rs3->fields['SGD_EIT_CODIGO'];
				$codi[$i]=$rs3->fields['SGD_EIT_CODIGO'];
				$cod_p2=$rs3->fields['SGD_EIT_COD_PADRE'];
				$nom[$i]=$cod_p2."-".$cod_p."-".$rs3->fields['SGD_EIT_NOMBRE'];
				$sqm4="select * from sgd_eit_items where sgd_eit_cod_padre = '".$codi[$i]."'";
				$rs4=$db->conn->Execute($sqm4);
				$i++;
				while(!$rs4->EOF){
					$cod_p=$rs4->fields['SGD_EIT_CODIGO'];
					$codi[$i]=$rs4->fields['SGD_EIT_CODIGO'];
					$cod_p2=$rs4->fields['SGD_EIT_COD_PADRE'];
					$nom[$i]=$cod_p2."-".$cod_p."-".$rs4->fields['SGD_EIT_NOMBRE'];
					$sqm5="select * from sgd_eit_items where sgd_eit_cod_padre = '".$codi[$i]."'";
					$rs5=$db->conn->Execute($sqm5);
					$i++;
					while(!$rs5->EOF){
						$cod_p=$rs5->fields['SGD_EIT_CODIGO'];
						$codi[$i]=$rs5->fields['SGD_EIT_CODIGO'];
						$cod_p2=$rs5->fields['SGD_EIT_COD_PADRE'];
						$nom[$i]=$cod_p2."-".$cod_p."-".$rs5->fields['SGD_EIT_NOMBRE'];
						$sqm6="select * from sgd_eit_items where sgd_eit_cod_padre = ".$codi[$i];
						$rs6=$db->conn->Execute($sqm6);
						$i++;
						while(!$rs6->EOF){
							$cod_p=$rs6->fields['SGD_EIT_CODIGO'];
							$codi[$i]=$rs6->fields['SGD_EIT_CODIGO'];
							$cod_p2=$rs6->fields['SGD_EIT_COD_PADRE'];
							$nom[$i]=$cod_p2."-".$cod_p."-".$rs6->fields['SGD_EIT_NOMBRE'];
							$i++;
							$rs6->MoveNext();
						}
						$rs5->MoveNext();
					}
					$rs4->MoveNext();
				}
				$rs3->Movenext();
			}
			$rs2->MoveNext();
		}
		$rs1->MoveNext();
	}
	$sqlp="select SGD_EIT_NOMBRE,sgd_eit_cod_padre from sgd_eit_items where sgd_eit_codigo = '$codig'";
	$rsp=$db->conn->Execute($sqlp);
	$cpd=$rsp->fields['SGD_EIT_COD_PADRE'];
	$nom_pa=$cpd."-".$codig."-".$rsp->fields['SGD_EIT_NOMBRE'];
	}
	else {
	$sqmpp="select * from sgd_eit_items where sgd_eit_codigo = '$codp'";
	$rs1=$db->conn->Execute($sqmpp);
	$nom_pa="0-".$codp."-".$rs1->fields['SGD_EIT_NOMBRE'];
	}
	
	/*
$q_tiposAlmac  = "SELECT SGD_EIT_CODIGO, SGD_EIT_NOMBRE";
$q_tiposAlmac .= " FROM SGD_EIT_ITEMS2";
$q_tiposAlmac .= " ORDER BY SGD_EIT_COD_PADRE ";
$rs_tiposAlmac = $db->query( $q_tiposAlmac );*/
?>
  <td height="30" class="titulos5">
    <div align="center">
      <select name="tipoAlmacPadre" class="select">
	  <option value="<?=$codig?>" >  <?=$nom_pa?> </option>
	  
	  <?
	  for($p=1;$p<$i;$p++)
{    
    if($nom[$p]!=$nom_pa)print "<option value='".$codi[$p]."'>".$nom[$p]." </font></option>";
}
	  ?>
      </select>
    </div>
<?/*
$conD=$db->conn->Concat("SGD_EIT_COD_PADRE","'-'","SGD_EIT_CODIGO","'-'","SGD_EIT_NOMBRE");
$sqr="select $conD as detalle,SGD_EIT_CODIGO from sgd_eit_items order by sgd_eit_cod_padre";
$rs=$db->conn->Execute($sqr);
print $rs->GetMenu2('tipoAlmacPadre',$tipoAlmacPadre,true,false,"","class=select");*/
?>
  </td>
  
  <td class="titulos5">
    <div align="center">
      <b>Tiene</b>
      <input type="text" name="cantidad" value="<?=$cantidad?>" size="2" maxlength="2">
    </div>
  </td>
  
  <td class="titulos5">Hijo:
    <input type="text" name="hijo" value="<?=$hijo?>" >
  </td>
  <td class="titulos5">Sigla Hijo:
  <input type="text" name="Shijo" value="<?=$Shijo?>" size="4" maxlength="4">
  </td>
</tr>
<tr>
  <td class="titulos5" colspan="5" align="center">
    <input type="submit" name="grabar" class="botones" value="GRABAR" >
    <input type="button" name="cerrar" class="botones" value="SALIR" onClick="window.close();opener.regresar();">
  </td>
</tr>
</table>

</form>
</body>
</html>