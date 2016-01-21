<?php 
$per=1;
if( !isset( $codDpto ) ){$codDpto = 0;}
if( $exp_edificio==""){$exp_edificio = 0;}
if( $exp_piso=="" ){$exp_piso = 0;}
if(  $exp_item11 =="" ){$exp_item11 = 0;}
if(  $entre =="" ){$entre = 0;}
if(  $estan =="" ){$estan = 0;}
if(  $item =="" ){$item = 0;}

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
include_once "$ruta_raiz/include/tx/Historico.php";
include_once "$ruta_raiz/include/tx/Expediente.php";
$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug=true;
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&dependencia=$dependencia&krd=$krd&tipo=$tipo&sel=$sel&ano=$ano";
static $sel;
$numInv=1;
$flds_desde_ano = $s_desde_ano;
function fnc_date_calcm($this_date,$num_month){
	$my_time = strtotime ($this_date); //converts date string to UNIX timestamp
   	$timestamp = $my_time - ($num_month * 2678400 ); //calculates # of days passed ($num_days) * # seconds in a day (86400)
    $return_date = date("Y-m-d",$timestamp);  //puts the UNIX timestamp back into string format
    return $return_date;//exit function and return string
    }
?>
<html>
<head>
<title>REPORTES</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
<script type="text/javascript">
 function CargarCsv() {
  window.open("<?=$ruta_raiz?>/archivo/cargarcsv.php?&krd=<?=$krd?>&coddepe=<?=$coddepe?>&codusua=<?=$codusua?>","Generar CSV","height=150,width=350,scrollbars=yes");
}

function Regresar(tipo_archivo){
	window.location.assign("<?=$ruta_raiz?>/archivo/cuerpo_exp.php?<?=$encabezado1 ?>&krd=<?=$krd?>&fechah=$fechah&$orno&tipo_archivo=$tipo_archivo&carpeta&adodb_next_page&nomcarpeta");
}

function Asignar(){
<?php echo $sell=1;?>
}
function GenerarInv()
{
<?php
$numInv+=1;
?>
window.open("<?=$ruta_raiz?>/archivo/generar.php?krd=<?=$krd?>&dep_sel=<?=$dep_sel?>&expe=<?=$expe?>&fechaInii=<?=$fechaInii?>&$fechaInif=<?=$fechaInif?>&exp=<?=$exp?>&exp2=<?=$exp2?>","height=250,width=750,scrollbars=yes" );

}
</script>
<form name='inventario' method='post' action='inventario.php?<?=session_name()?>=<?=trim(session_id())?>&krd=<?=$krd?>&tipo=<?=$tipo?>&sel=<?=$sel?>'>
<br>
<table border=0 width 100% cellpadding="0"  class="borde_tab" align="center">
<tr>
<?php
$fechah=date("dmy") . "_". time("h_m_s");

$check=1;
$fechaf=date("dmy") . "_" . time("hms");
$numeroa=0;$numero=0;$numeros=0;$numerot=0;$numerop=0;$numeroh=0;
$fecha_hoy = Date("Y-m-d");
$sqlFechaHoy=$db->conn->DBDate($fecha_hoy);

function fnc_date_calc($this_date,$num_years){

   $my_time = strtotime ($this_date); //converts date string to UNIX timestamp
   $timestamp = $my_time + ($num_years * 31557600); //calculates # of days passed ($num_days) * # seconds in a day (86400)
     $return_date = date("Y/m/d",$timestamp);  //puts the UNIX timestamp back into string format

   return $return_date;//exit function and return string
}//end of function
$conD=$db->conn->Concat("DEPE_CODI","'-'","DEPE_NOMB");
//	echo $tipo;
include("$ruta_raiz/include/query/archivo/queryInventario.php");
if($tipo==1)
{
?>
<TD class=titulos2 colspan="2" align="center" >
INVENTARIO CONSOLIDADO CAPACIDAD OCUPADA</td>
<TR>
<td class='titulos5'>EDIFICIO</td>
				<TD>&nbsp;
				<?php
				include("$ruta_raiz/include/query/archivo/queryInventario.php");
				$rs=$db->query($sql7);
				print $rs->GetMenu2('exp_edificio',$exp_edificio,true,false,""," class=select");
				?>				</TD>
</TR>
<TR>
<td class='titulos5'>MINIMA UNIDAD</td>
				<TD>&nbsp;
				<?php
				if($min==1)$sel="checked"; else $sel="";
				?>
				<span class="listado1"> ENTREPA&Ntilde;O:</span>
				<input name="min" type="radio" value="1" " <?=$sel?>>
				<?php
				if($min==2)$sel="checked"; else $sel="";
				?>
				&nbsp; <span class="listado1">CAJA:</span>
				<input name="min" type="radio" value="2" " <?=$sel?>>				</TD>
</TR>
<TR>
<td class="titulos5" align="right">
<input name='Generar' type=submit class="botones_funcion" id="envia22" value="Generar" >
<TD class="titulos5" align="left">
<a href='archivo.php?<?=session_name()?>=<?=trim(session_id())?>krd=<?=$krd?>'><input name='Regresar' align="middle" type="button" class="botones_funcion" id="envia22" value="Regresar" ></td>
</td>
</TR>
</table>
<br>
<br>

<table border=0 width 100% cellpadding="0"  class="borde_tab">
<?

include("$ruta_raiz/include/query/archivo/queryInventario.php");


$TEMP=0;$TE=0;$DE=0;$DE2=0;$ctotal2=0;$cetotal2=0;$mo2=0;$mv2=0;
if($Generar and $min!=0){
	if ($min==1){$tmp="ESTANTE";$IT="ENTREPA&Ntilde;OS";$IT2="ENTREPA";$IT3="ESTANTES";}
	if ($min==2){$tmp="ENTREPA";$IT="CAJAS";$IT2="CAJA";$IT3="ENTREPA&Ntilde;OS";}
include("$ruta_raiz/include/query/archivo/queryInventario.php");
//$db->conn->debug=true;
$rs=$db->query($sqli);
$ip=1;
$p=1;
$q=1;
$r=1;
$l=1;
while (!$rs->EOF){
//if (!$rs->EOF){
$piso1=$rs->fields['SGD_EIT_NOMBRE'];
$piso2=explode("PISO ",$piso1);
$piso=$piso2[1];
$pisocod=$rs->fields['SGD_EIT_CODIGO'];
$tp2=0;
if($pisocod!=0){
	$i=1;
	$sqm1="select * from sgd_eit_items where sgd_eit_cod_padre = '$pisocod'";
	
	$rs1=$db->conn->Execute($sqm1);
	while(!$rs1->EOF){
		$nomb=$rs1->fields['SGD_EIT_NOMBRE'];
		$nob1=explode(' ',$nomb);
		$nom[$i]=$nob1[0];
		$codi[$i]=$rs1->fields['SGD_EIT_CODIGO'];
		$sqm2="select * from sgd_eit_items where sgd_eit_cod_padre = '".$codi[$i]."'";
		$rs2=$db->conn->Execute($sqm2);
		$i++;
		while(!$rs2->EOF){
			$codi[$i]=$rs2->fields['SGD_EIT_CODIGO'];
			$nomb=$rs2->fields['SGD_EIT_NOMBRE'];
			$nob1=explode(' ',$nomb);
			$nom[$i]=$nob1[0];
			$sqm3="select * from sgd_eit_items where sgd_eit_cod_padre = '".$codi[$i]."'";
			$rs3=$db->conn->Execute($sqm3);
			$i++;
			while(!$rs3->EOF){
				$codi[$i]=$rs3->fields['SGD_EIT_CODIGO'];
				$nomb=$rs3->fields['SGD_EIT_NOMBRE'];
				$nob1=explode(' ',$nomb);
				$nom[$i]=$nob1[0];
				$sqm4="select * from sgd_eit_items where sgd_eit_cod_padre = '".$codi[$i]."'";
				$rs4=$db->conn->Execute($sqm4);
				$i++;
				while(!$rs4->EOF){
					$codi[$i]=$rs4->fields['SGD_EIT_CODIGO'];
					$nomb=$rs4->fields['SGD_EIT_NOMBRE'];
					$nob1=explode(' ',$nomb);
					$nom[$i]=$nob1[0];
					$sqm5="select * from sgd_eit_items where sgd_eit_cod_padre = '".$codi[$i]."'";
					$rs5=$db->conn->Execute($sqm5);
					$i++;
					while(!$rs5->EOF){
						$codi[$i]=$rs5->fields['SGD_EIT_CODIGO'];
						$nomb=$rs5->fields['SGD_EIT_NOMBRE'];
						$nob1=explode(' ',$nomb);
						$nom[$i]=$nob1[0];
						$sqm6="select * from sgd_eit_items where sgd_eit_cod_padre = '".$codi[$i]."'";
						$rs6=$db->conn->Execute($sqm6);
						$i++;
						while(!$rs6->EOF){
							$nomb=$rs6->fields['SGD_EIT_NOMBRE'];
							$codi[$i]=$rs6->fields['SGD_EIT_CODIGO'];
							$nob1=explode(' ',$nomb);
							$nom[$i]=$nob1[0];
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
	$cou=$i;
	$TEMP=0;
	$DE=0;
$tmpc=strlen($tmp);
$itc=strlen($IT2);
	for($re=1;$re<$cou;$re++){
		if(strncmp( $nom[$re], $tmp,$tmpc ))$DE++;
		if(strncmp( $nom[$re], $IT2,$itc ))$TEMP++;
	}
	
	$TE+=$TEMP;
	$DE2+=$DE;
	$mt=$DE/4;
	$ctotal=0;
	$cetotal=0;
	
$rsit = $db->query( $sqlo2 );
while( !$rsit->EOF )
{
	if( strncmp( $rsit->fields['NOMBRE'], $tmp,$tmpc ) == 0 )
	{
		$arrEntrepa[ $rsit->fields['CODIGO'] ] = $rsit->fields['CODIGO'];
	}
	else if( strncmp( $rsit->fields['NOMBRE'], $IT2, $itc ) == 0 )
	{
		$arrCaja[ $rsit->fields['CODIGO'] ] = $rsit->fields['CODIGO'];
	}
	$rsit->MoveNext();
	
}
if($min==1 and strlen($arrCaja)!=0){
	foreach($arrCaja as $valor){
		$sett=$db->conn->execute("select sgd_eit_cod_padre from sgd_eit_items where sgd_eit_codigo = '$valor'");
		if(!$sett->EOF){
			$itm=$sett->fields['SGD_EIT_COD_PADRE'];
			$sett1=$db->conn->Execute('select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$itm);
			if( strncmp( $sett1->fields['NOMBRE'], $tmp,$tmpc ) == 0 )
			{
				$arrEstante[ $itm ] = $itm;
			}
		}
	}
}
$cou2=$i;
if(strlen($arrCaja)!=0){
foreach($arrCaja as $valor){
for($k=1;$k<$cou2;$k++){
	if($codi[$k]==$valor)$ctotal+=1;
}
}
}
if($min==1)$arrTem=$arrEstante;
else $arrTem=$arrEntrepa;
if(strlen($arrTem)!=0){
foreach($arrTem as $valor){
for($l=1;$l<$cou2;$l++){
	if($codi[$l]==$valor)$cetotal+=1;
}
}
}
	$ctotal2+=$ctotal;
	$cetotal2+=$cetotal;
	$mo=$cetotal/4;
	$mo2+=$mo;
	if($mt!=0)$mv=$mt-$mo;
	else $mv=0;
	$mv2+=$mv;
	if($mt!=0)$porce=($mv*100)/$mt;
	else $porce=0;
	if($DE==0)$porce=100;
?>

<TR>
<td align="center" class="listado2"><?=$piso1?></td>
<td align="center" class="titulos2">TOTAL CAPACIDAD <?=$IT?> </td>
<td align="center" class="listado2"><?=$DE?></td>
<td align="center" class="titulos2">TOTAL CAPACIDAD <?=$IT3?> </td>
<td align="center" class="listado2"><?=$TEMP?></td>
<td align="center" class="titulos2"><?=$IT?> OCUPADOS </td>
<td align="center" class="listado2"><?=$ctotal?></td>
<td align="center" class="titulos2"><?=$IT3?> OCUPADOS </td>
<td align="center" class="listado2"><?=$cetotal?></td>
<td align="center" class="titulos2">M LIMEALES OCUPADOS </td>
<td align="center" class="listado2"><?=$mo?> </td>
<td align="center" class="titulos2">M LINEALES VACIOS </td>
<td align="center" class="listado2"><?=$mv?>
<td align="center" class="titulos2">% LIBRE </td>
<td align="center" class="listado2"><?=$porce?></td></tr>
<?php
$ip++;
$TEMP=0;
}
$totpor+=$porce;
$TEMP=0;
$DE=0;
$rs->MoveNext();
}
$totalporce=$totpor/($ip-1);
?>
<tr><center>
<td>&nbsp;</td>
<td align="center" class="titulos2">TOTAL </td>
<td align="center" class="listado2"><?=$DE2?></td>
<td align="center" class="titulos2">TOTAL </td>
<td align="center" class="listado2"><?=$TE?></td>
<td align="center" class="titulos2">TOTAL </td>
<td align="center" class="listado2"><?=$ctotal2?></td>
<td align="center" class="titulos2">TOTAL </td>
<td align="center" class="listado2"><?=$cetotal2?></td>
<td align="center" class="titulos2">M OCUPADOS TOTAL &nbsp;&nbsp;&nbsp;&nbsp;
<td align="center" class="listado2"><?=$mo2?> </td>
<td align="center" class="titulos2">M LIBRES TOTAL </td>
<td align="center" class="listado2"><?=$mv2?> </td>
<td align="center" class="titulos2">% TOTAL </td>
<td align="center" class="listado2"><?=$totalporce?> </td>
</tr></center>


<?php
}
}

if($tipo==2){
	//$tp=1;
?>
<TD class=titulos5 >
<BR><BR>
<CENTER><b>MOVIMIENTO DE COLECCION</b><BR><BR>
<?php
if($TIPO1==1)$sel="checked"; else $sel="";
?>
&nbsp; POR CAJAS:
<input name="TIPO1" type="radio" value="1" onClick="submit();" <?=$sel?>>
<?php
if($TIPO1==2)$sel="checked"; else $sel="";
?>
&nbsp; POR EXPEDIENTES:
<input name="TIPO1" type="radio" value="2" onClick="submit();" <?=$sel?>><br><BR>
<table border=0 width 80% cellpadding="1"  class="borde_tab">
<BR><center>DATOS ORIGEN</center><BR>
<?php

if($TIPO1==1){
?>
<tr>
<td class="titulos5">A&Ntilde;O</td>
<td>
<select class="select" name="s_desde_ano">
          <?php
  $agnoactual=Date('Y');
  $i = 1990;
  while($i <= $agnoactual)
  {
    if($ano!=0)$i=$ano;
   	if($i == $flds_desde_ano) $option="<option SELECTED value=\"" . $i . "\">" . $i . "</option>";
    else $option="<option value=\"" . $i . "\">" . $i . "</option>";
    echo $option;
     $i++;
  }

  ?>
        </select>

  </td></tr>
  <tr>
  <td class="titulos5">DEPENDENCIA</td>
  <td>
  <?php
  $query="select $conD,depe_codi from DEPENDENCIA ORDER BY DEPE_CODI";
  $rs1=$db->conn->query($query);
  print $rs1->GetMenu2('dep_sel',$dep_sel,"0:--- TODAS LAS DEPENDENCIAS ---",false,""," onChange='submit()' class=select");
  ?>
  </td>
  </tr>
  <tr>
  <td class="titulos5">SERIE</td>
  <TD>
  <?php
	if(!$tdoc) $tdoc = 0;
	if(!$codserie) $codserie = 0;
	if(!$tsub) $tsub = 0;
	$fechah=date("dmy") . " ". time("h_m_s");
	$fecha_hoy = Date("Y-m-d");
	$sqlFechaHoy=$db->conn->DBDate($fecha_hoy);
	$check=1;
	$fechaf=date("dmy") . "_" . time("hms");
	$num_car = 4;
	$nomb_varc = "s.sgd_srd_codigo";
	$nomb_varde = "s.sgd_srd_descrip";
	include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
	include("$ruta_raiz/include/query/archivo/queryInventario.php");
	$rsD=$db->conn->query($querySerie);
	$comentarioDev = "Muestra las Series Docuementales";
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsD->GetMenu2("codserie", $codserie, "0:-- Seleccione --", false,"","onChange='submit()' class='select'" );
	?>
  </td>
  </tr>
  <tr>
  <td class="titulos5">SUBSERIE</td>
  <td>
  <?php
	$nomb_varc = "su.sgd_sbrd_codigo";
	$nomb_varde = "su.sgd_sbrd_descrip";
	include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
	include("$ruta_raiz/include/query/archivo/queryInventario.php");
	$rsSub=$db->conn->query($querySub);
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsSub->GetMenu2("tsub", $tsub, "0:-- Seleccione --", false,"","onChange='submit()' class='select'" );

	if(!$codiSRD)
	{
		$codiSRD = $codserie;
		$codiSBRD =$tsub;
	}
  if ($codiSRD<10 and $codiSRD!=0)$codiSRD="0".$codiSRD;
  if ($codiSBRD<10 and $codiSBRD!=0)$codiSBRD="0".$codiSBRD;
  $expe=$s_desde_ano.str_pad($dep_sel,3,"0", STR_PAD_LEFT).str_pad($codiSRD,3,"0", STR_PAD_LEFT).str_pad($codiSBRD,2,"0", STR_PAD_LEFT);
  include("$ruta_raiz/include/query/archivo/queryInventario.php");
  $rsc=$db->conn->query($sqlc);
  $cajas2=$rsc->fields['CAJA'];

	?>
  </td>
  </tr>
  <tr><td class=titulos5 >CAJAS </td>
<td class=titulos5>DESDE  <input type=text name=cajas value='<?=$cajas?>' class="tex_area" size="3" maxlength="2">
&nbsp;&nbsp;&nbsp;&nbsp;HASTA  <input type=text name=cajas2 value='<?=$cajas2?>' class="tex_area" size="3" maxlength="2">
</td>
</tr>
<tr><TD class="titulos5" align="center" colspan="2"><br> NUEVA UBICACION <br><BR></td></tr>

<TR>
<td class='titulos5'>EDIFICIO</td>
				<TD>&nbsp;
				<?php
				include("$ruta_raiz/include/query/archivo/queryInventario.php");
				$rs=$db->query($sql7);
				print $rs->GetMenu2('exp_edificio',$exp_edificio,true,false,""," onChange='submit()' class=select");
				?>
				</TD>

</TR>
<tr><td class=titulos5 >PISO </td>
<TD>&nbsp;
<?php
if($exp_edificio){
if(!$exp_piso)$exp_piso="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql3);
print $rs->GetMenu2('exp_piso',$exp_piso,true,false,""," onChange='submit()' class=select ");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql1);
	if (!$rs->EOF){$item61=$rs->fields["SGD_EIT_NOMBRE"];
			$item1=explode(' ',$item61);}
?></td>
</tr>
<tr><td class=titulos5 ><?=$item1[0]?></td>
<TD>&nbsp;
<?php
}
if($exp_piso){
if(!$exp_item11)$exp_item11="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql4);
print $rs->GetMenu2('exp_item11',$exp_item11,true,false,""," onChange='submit()' class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql11);
	if (!$rs->EOF){$item51=$rs->fields["SGD_EIT_NOMBRE"];
			$item8=explode(' ',$item51);
?></td>
</tr>
<tr><td class=titulos5 ><?=$item8[0]?> </td>
<td>
<?php
}
}
if($exp_item11){
if(!$entre)$entre="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql17);
print $rs->GetMenu2('entre',$entre,true,false,"","onChange='submit()'  class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql16);
	if (!$rs->EOF){$item41=$rs->fields["SGD_EIT_NOMBRE"];
			$item7=explode(' ',$item41);
?>
</td>
<tr><td class=titulos5 > <?=$item7[0]?> </td>
<td>
<?php
}}
if($entre){
if(!$estan)$estan="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql18);
print $rs->GetMenu2('estan',$estan,true,false,""," onChange='submit()' class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql10);
	if (!$rs->EOF){$item31=$rs->fields["SGD_EIT_NOMBRE"];
			$item9=explode(' ',$item31);
?>
</td>
<tr><td class=titulos5 > <?=$item9[0]?> </td>
<td>
<?php
}}
if($estan){
if(!$item)$item="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql19);
print $rs->GetMenu2('item',$item,true,false,"","onChange='submit()'  class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql21);
	if (!$rs->EOF){$item71=$rs->fields["SGD_EIT_NOMBRE"];
			$item10=explode(' ',$item71);
			
?>
</td>
<tr><td class=titulos5 > <?=$item10[0]?> </td>
<td>
<?php
}}
if($item){
if(!$item2)$item2="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql20);
print $rs->GetMenu2('item2',$item2,true,false,"","onChange='submit()'   class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql22);
	if (!$rs->EOF){$item81=$rs->fields["SGD_EIT_NOMBRE"];
			$item11=explode(' ',$item81);
?>
</td>
<tr><td class=titulos5 > <?=$item11[0]?> </td>
<td>
<?php
}}
if($item2){
if(!$item3)$item3="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql23);
print $rs->GetMenu2('item3',$item3,true,false,"","  class=select");
}
?>
</td>
<?php
if ($Cambiar) {

	include("$ruta_raiz/include/query/archivo/queryInventario.php");
	$rse=$db->query($sqle);
	$d=1;
	while (!$rse->EOF) {
		$expedientes[$d]=$rse->fields['SGD_EXP_NUMERO'];
		$rse->MoveNext();
		$d++;
	}
	if($cajas=="")$cajas=1;
	$con=0;
	if ($exp_item31!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$exp_item31.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$exp_item31;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$exp_item31;
	}
	if ($exp_item11!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$exp_item11.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$exp_item11;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$exp_item11;
	}
	else $exp_item11=NULL;
	if ($entre!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$entre.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$entre;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$entre;
	}
	else $entre=NULL;
	if ($estan!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$estan.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$estan;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$estan;
	}
	else $estan=NULL;
	if ($item!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$item.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$item;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$item;
	}
	else $item=NULL;
	if ($item2!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$item2.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$item2;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$item2;
	}
	else $item2=NULL;
	if ($item3!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$item3.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$item3;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$item3;
	}
	else $item3=NULL;
	if($cajas2!=0){
		for($t=$cajas;$t<=$cajas2;$t++){
			include("$ruta_raiz/include/query/archivo/queryInventario.php");
			$rs=$db->query($quer);
			if ($rs->EOF)$con+=1;
		}
		if ($con==0)echo "No se pudo realizar el cambio";
		else echo "El cambio se Realizo Correctamente";
		}
	else echo"No se pudo hacer el cambio porque no se encontraron expedientes con estas caracteristicas";
}
?>
</center></table></td>

<tr><TD colspan='2'>
<CENTER><input name='Cambiar' type=submit class="botones_funcion" id="envia22" value="Cambiar" >

<?php
}
if($TIPO1==2){

?>
<tr><td class=titulos5 > EXPEDIENTES </td>
<td class=titulos5><input type=text name=expde value='<?=$expde?>' class="tex_area">
<input type="submit" value=">>" class="botones_2" name="exp"></td>
</tr>
<?php
	if($exp=='>>'){
	include("$ruta_raiz/include/query/archivo/queryInventario.php");
	$rsex=$db->query($sqlex);
	$unidoc2=$rsex->fields['CARP'];
	$rsex2=$db->query($sqlex2);
	if (!$rsex2->EOF){
	$exp_edificio=$rsex2->fields['SGD_EXP_EDIFICIO'];
	$entre=$rsex2->fields['SGD_EXP_ENTREPA'];
	$caj=$rsex2->fields['SGD_EXP_CAJA'];
	}
	include("$ruta_raiz/include/query/archivo/queryInventario.php");
	$rsed = $db->conn->Execute($queryed);
	if (!$rsed->EOF){
		$codDpto=$rsed->fields['SGD_EIT_DPTO'];
		$codMuni=$rsed->fields['SGD_EIT_MUNI'];
	}
}
?>
<tr><td class="titulos5"> CARPETA </td>
<td class=titulos5>DESDE  <input type=text name=unidoc value='<?=$unidoc?>' class="tex_area" size="3" maxlength="2">
&nbsp;&nbsp;&nbsp;&nbsp;HASTA  <input type=text name=unidoc2 value='<?=$unidoc2?>' class="tex_area" size="3" maxlength="2">
</td>
</tr>
<tr><TD class="titulos5" align="center" colspan="2"><br> NUEVA UBICACION <br><BR></td></tr>
<TR>
<td class='titulos5'>EDIFICIO</td>
				<TD>&nbsp;
				<?php
				include("$ruta_raiz/include/query/archivo/queryInventario.php");
				$rs=$db->query($sql7);
				print $rs->GetMenu2('exp_edificio',$exp_edificio,true,false,"","onChange='submit()'  class=select");
				include("$ruta_raiz/include/query/archivo/queryInventario.php");
				$rs=$db->query($sql0);
				if (!$rs->EOF){$item01=$rs->fields["SGD_EIT_NOMBRE"];
				$item0=explode(' ',$item01);}
				?>
				</TD>

</TR>
<tr><td class=titulos5 ><?=$item0[0]?> </td>
<TD>&nbsp;
<?php
if($exp_edificio){
if(!$exp_piso)$exp_piso="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql3);
print $rs->GetMenu2('exp_piso',$exp_piso,true,false,""," onChange='submit()' class=select ");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql1);
	if (!$rs->EOF){$item61=$rs->fields["SGD_EIT_NOMBRE"];
			$item1=explode(' ',$item61);}
?></td>
</tr>
<tr><td class=titulos5 ><?=$item1[0]?></td>
<TD>&nbsp;
<?php
}
if($exp_piso){
if(!$exp_item11)$exp_item11="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql4);
print $rs->GetMenu2('exp_item11',$exp_item11,true,false,""," onChange='submit()' class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql11);
	if (!$rs->EOF){$item51=$rs->fields["SGD_EIT_NOMBRE"];
			$item8=explode(' ',$item51);
?></td>
</tr>
<tr><td class=titulos5 ><?=$item8[0]?> </td>
<td>
<?php
}
}
if($exp_item11){
if(!$entre)$entre="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql17);
print $rs->GetMenu2('entre',$entre,true,false,"","onChange='submit()'  class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql16);
	if (!$rs->EOF){$item41=$rs->fields["SGD_EIT_NOMBRE"];
			$item7=explode(' ',$item41);
?>
</td>
<tr><td class=titulos5 > <?=$item7[0]?> </td>
<td>
<?php
}}
if($entre){
if(!$estan)$estan="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql18);
print $rs->GetMenu2('estan',$estan,true,false,""," onChange='submit()' class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql10);
	if (!$rs->EOF){$item31=$rs->fields["SGD_EIT_NOMBRE"];
			$item9=explode(' ',$item31);
?>
</td>
<tr><td class=titulos5 > <?=$item9[0]?> </td>
<td>
<?php
}}
if($estan){
if(!$item)$item="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql19);
print $rs->GetMenu2('item',$item,true,false,"","onChange='submit()'  class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql21);
	if (!$rs->EOF){$item71=$rs->fields["SGD_EIT_NOMBRE"];
			$item10=explode(' ',$item71);
			
?>
</td>
<tr><td class=titulos5 > <?=$item10[0]?> </td>
<td>
<?php
}}
if($item){
if(!$item2)$item2="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql20);
print $rs->GetMenu2('item2',$item2,true,false,"","onChange='submit()'   class=select");
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql22);
	if (!$rs->EOF){$item81=$rs->fields["SGD_EIT_NOMBRE"];
			$item11=explode(' ',$item81);
?>
</td>
<tr><td class=titulos5 > <?=$item11[0]?> </td>
<td>
<?php
}}
if($item2){
if(!$item3)$item3="";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sql23);
print $rs->GetMenu2('item3',$item3,true,false,"","  class=select");
}
?>
</td>
<?php
if ($Cambiar) {
	$expedientes[1]=$expde;
	$t=1;
	if($unidoc=="")$unidoc=0;
	if ($exp_item31!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$exp_item31.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$exp_item31;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$exp_item31;
	}
	if ($exp_item11!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$exp_item11.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$exp_item11;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$exp_item11;
	}
	if ($entre!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$entre.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$entre;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$entre;
	}
	if ($estan!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$estan.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$estan;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$estan;
	}
	if ($item!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$item.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$item;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$item;
	}
	if ($item2!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$item2.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$item2;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$item2;
	}
	if ($item3!=""){
					$ttp='select SGD_EIT_NOMBRE AS "NOMBRE" from SGD_EIT_ITEMS where SGD_EIT_CODIGO = '.$item3.' order by SGD_EIT_CODIGO';
					$rs=$db->conn->Execute($ttp);
					if(strncmp( $rs->fields['NOMBRE'], "ENTREPA",7) == 0)$entrepano=$item3;
					elseif(strncmp( $rs->fields['NOMBRE'], "CAJA",4) == 0)$caja=$item3;
	}
	include("$ruta_raiz/include/query/archivo/queryInventario.php");
	$rs3=$db->conn->query($query);
	if (!$rs3->EOF)echo "No se pudo realizar el cambio";
	else echo "El cambio se Realizo Correctamente";
	}

?>
</center></table></td>

<tr><TD colspan='2'>
<CENTER><input name='Cambiar' type=submit class="botones_funcion" id="envia22" value="Cambiar" >

<?php
}
}


if($tipo==3){

?>
<TD class=titulos5 >
<BR><BR>
<CENTER><b>INVENTARIO DOCUMENTAL ARCHIVO DE GESTION</b><BR><BR></CENTER>

<table border=0 width="100%" cellpadding="1"  class="borde_tab">
<tr>
<td class="titulos5">A&Ntilde;O</td>
<td>
<select class="select" name="s_desde_ano">
          <?php
  $agnoactual=Date('Y');
  $i = 1990;
  while($i <= $agnoactual)
  {
    if($ano!=0)$i=$ano;
   	if($i == $flds_desde_ano) $option="<option SELECTED value=\"" . $i . "\">" . $i . "</option>";
    else $option="<option value=\"" . $i . "\">" . $i . "</option>";
    echo $option;
     $i++;
  }

  ?>
        </select>

  </td></tr>
<tr>
  <td class="titulos5">DEPENDENCIA</td>
  <td>
  <?php
  $query="select $conD,depe_codi from DEPENDENCIA ORDER BY DEPE_CODI";
  $rs1=$db->conn->query($query);
  print $rs1->GetMenu2('dep_sel',$dep_sel,"0:--- TODAS LAS DEPENDENCIAS ---",false,"","  class=select");
  ?>
  </td><br>
	<span class="titulos5">No se debe hacer cambio de dependencia sino hasta que se desee hacer otro inventario documental
  </tr>
   <tr><td class="titulos5" align="left">FECHA ARCHIVO INICIAL</td>
  <td>

  <script language="javascript">
  	<?php
	 	if(!$fechaInii) $fechaInii=fnc_date_calcm(date('Y-m-d'),'1');
	 	if(!$fechaInif) $fechaInif = date('Y-m-d');
  	?>
   	var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "inventario", "fechaInii","btnDate1","<?=$fechaInii?>",scBTNMODE_CUSTOMBLUE);
	dateAvailable1.date = "<?=date('Y-m-d');?>";
	dateAvailable1.writeControl();
	dateAvailable1.dateFormat="yyyy-MM-dd";
	</script>
</td>
<tr><td class="titulos5" align="right">FINAL </td>
<td>
	<script language="javascript">
	var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "inventario", "fechaInif","btnDate2","<?=$fechaInif?>",scBTNMODE_CUSTOMBLUE);
	dateAvailable2.date = "<?=date('Y-m-d');?>";
	dateAvailable2.writeControl();
	dateAvailable2.dateFormat="yyyy-MM-dd";
	</script>
	</td>
  </tr>
  <tr>
  <td class="titulos5">SERIE</td>
  <TD>
  <?php
	if(!$tdoc) $tdoc = 0;
	if(!$codserie) $codserie = 0;
	if(!$tsub) $tsub = 0;
	$fechah=date("dmy") . " ". time("h_m_s");
	$fecha_hoy = Date("Y-m-d");
	$sqlFechaHoy=$db->conn->DBDate($fecha_hoy);
	$check=1;
	$fechaf=date("dmy") . "_" . time("hms");
	$num_car = 4;
	$nomb_varc = "s.sgd_srd_codigo";
	$nomb_varde = "s.sgd_srd_descrip";
	include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
	include("$ruta_raiz/include/query/archivo/queryInventario.php");
	$rsD=$db->conn->query($querySerie);
	$comentarioDev = "Muestra las Series Docuementales";
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsD->GetMenu2("codserie", $codserie, "0:-- Seleccione --", false,"","onChange='submit()' class='select'" );
	?>
  </td>
  </tr>
  <tr>
  <td class="titulos5">SUBSERIE</td>
  <td>
  <?php
	$nomb_varc = "su.sgd_sbrd_codigo";
	$nomb_varde = "su.sgd_sbrd_descrip";
	include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
	include("$ruta_raiz/include/query/archivo/queryInventario.php");
	$rsSub=$db->conn->query($querySub);
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsSub->GetMenu2("tsub", $tsub, "0:-- Seleccione --", false,"","onChange='submit()' class='select'" );

	if(!$codiSRD)
	{
		$codiSRD = $codserie;
		$codiSBRD =$tsub;
	}
  if ($codiSRD<10 and $codiSRD!=0)$codiSRD="0".$codiSRD;
  if ($codiSBRD<10 and $codiSBRD!=0)$codiSBRD="0".$codiSBRD;
  
  $expe=$s_desde_ano.str_pad($dep_sel,3,"0", STR_PAD_LEFT).str_pad($codiSRD,3,"0", STR_PAD_LEFT).str_pad($codiSBRD,2,"0", STR_PAD_LEFT);
  	?>
  </td>
  </tr>

  <?php
  include("$ruta_raiz/include/query/archivo/queryInventario.php");
  //$db->conn->debug=true;
  $rsc=$db->conn->Execute($bexp);
  $expt2=$rsc->fields['EXPE'];
  $exp21=explode($expe,$expt2);
  $exp2=$exp21[1];
  ?>
  <tr><td class=titulos5 >EXPEDIENTES DESDE</td>

<td class=titulos5>  <input type=text name=cajas value='<?=$exp?>' class="tex_area" size="8" maxlength="7"></td>
<tr><td class=titulos5 align="right">HASTA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><TD class="titulos5">  <input type=text name=cajas2 value='<?=$exp2?>' class="tex_area" size="8" maxlength="7">
</td>
</tr>

<tr><td class="titulos5">OBSERVACIONES</td>
<td class="titulos5"><input type=text name=observa value='<?=$observa?>' class="tex_area"></td></tr>

</TD>
</table>
</TD>
<?php

if($Agregar){
	$p=0;
	if($exp=="")$exp="00000";
	$exp_num=$expe;
if ($dep_sel==0)$depe=substr($exp_num,4,3);
else $depe=$dep_sel;
include("$ruta_raiz/include/query/archivo/queryInventario.php");
if($rs=$db->query($sql5))$depe_nom=$rs->fields['DEPE_NOMB'];$c=1;
$rse=$db->query($sqld);

while(!$rse->EOF){
$radicado=$rse->fields['RADI_NUME_RADI'];
$expediente=$rse->fields['SGD_EXP_NUMERO'];
$Caja=$rse->fields['SGD_EXP_CAJA'];
$Unidad=$rse->fields['SGD_EXP_UNICON'];
$Fini=$rse->fields['SGD_EXP_FECH'];
$Ffin=$rse->fields['SGD_EXP_FECHFIN'];
$Archi=$rse->fiedls['SGD_EXP_ARCHIVO'];
$rete=$rse->fields['SGD_EXP_RETE'];
$nundocus=$rse->fields['SGD_EXP_NREF'];
$edi=$rse->fields['SGD_EXP_EDIFICIO'];
$entre=$rse->fields['SGD_EXP_ENTREPANO'];
$tem=$edi;
include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rstem=$db->query($quernom);
$ubicacion=$rstem->fields['SGD_EIT_SIGLA'];
if(($Caja=="" or $Caja==0) and $entre!="")$bus=$exp_entre;
else $bus=$Caja;
$qpri=$db->conn->Execute("select sgd_eit_cod_padre,sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo = '$bus'");
if(!$qpri->EOF){
	$it1=$qpri->fields['SGD_EIT_COD_PADRE'];
	$si1=$qpri->fields['SGD_EIT_SIGLA'];
	$qsec=$db->conn->Execute("select sgd_eit_cod_padre,sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo = '$it1'");
	if(!$qsec->EOF){
		$it2=$qsec->fields['SGD_EIT_COD_PADRE'];
		$si2=$qsec->fields['SGD_EIT_SIGLA'];
		$qtir=$db->conn->Execute("select sgd_eit_cod_padre,sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo = '$it2'");
		if(!$qtir->EOF){
			$it3=$qtir->fields['SGD_EIT_COD_PADRE'];
			$si3=$qtir->fields['SGD_EIT_SIGLA'];
			$qcua=$db->conn->Execute("select sgd_eit_cod_padre,sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo = '$it3'");
			if(!$qcua->EOF){
				$it4=$qcua->fields['SGD_EIT_COD_PADRE'];
				$si4=$qcua->fields['SGD_EIT_SIGLA'];
				$qqin=$db->conn->Execute("select sgd_eit_cod_padre,sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo = '$it4'");
				if(!$qqin->EOF){
					$it5=$qqin->fields['SGD_EIT_COD_PADRE'];
					$si5=$qqin->fields['SGD_EIT_SIGLA'];
					$qsex=$db->conn->Execute("select sgd_eit_cod_padre,sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo = '$it5'");
					if(!$qsex->EOF){
						$it6=$qsex->fields['SGD_EIT_COD_PADRE'];
						$si6=$qsex->fields['SGD_EIT_SIGLA'];
						$qset=$db->conn->Execute("select sgd_eit_cod_padre,sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo = '$it6'");
						if(!$qset->EOF){
							$it7=$qset->fields['SGD_EIT_COD_PADRE'];
							$si7=$qsec->fields['SGD_EIT_SIGLA'];
						}
					}
				}
			}
		}	
	}
}
$qoc=$db->conn->Execute("select sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo = '$edi'");
if(!$qoc->EOF)$si8=$qoc->fields['SGD_EIT_SIGLA'];
if($it7 and $it7==$edi){$ubicacion=$si8."-".$si7."-".$si6."-".$si5."-".$si4."-".$si3."-".$si2."-".$si1;}
if($it6 and $it6==$edi){$ubicacion=$si8."-".$si6."-".$si5."-".$si4."-".$si3."-".$si2."-".$si1;}
if($it5 and $it5==$edi){$ubicacion=$si8."-".$si5."-".$si4."-".$si3."-".$si2."-".$si1;}		
if($it4 and $it4==$edi){$ubicacion=$si8."-".$si4."-".$si3."-".$si2."-".$si1;}

$p++;

include("$ruta_raiz/include/query/archivo/queryInventario.php");
$rs=$db->query($sqlr);
if(!$rs->EOF){
$srd=$rs->fields['SGD_SRD_CODIGO'];
$sbrd=$rs->fields['SGD_SBRD_CODIGO'];
$Titulo=$rs->fields['SGD_SEXP_PAREXP1'];
}
if($srd!="" or $sbrd!=""){
	include("$ruta_raiz/include/query/archivo/queryInventario.php");
if($rs=$db->query($sqlsr))$srd_desc=$rs->fields['SGD_SRD_DESCRIP'];$c.=4;
if($rs=$db->query($sqltsb)){
$sbrd_desc=$rs->fields['SGD_SBRD_DESCRIP'];
$disfin=$rs->fields['SGD_SBRD_DISPFIN'];
if($disfin==1)$disfinal="CONSERVACION TOTAL";
if($disfin==2)$disfinal="ELIMINACION";
if($disfin==3)$disfinal="MEDIO TECNICO";
if($disfin==4)$disfinal="SELECCION O MUESTREO";

}
}
else echo "NO TIENE CLASIFICACION DE TRD";
include("$ruta_raiz/include/query/archivo/queryInventario.php");
	$rsf=$db->query($sql13);
	$Folio=$rsf->fields['RADI_NUME_HOJA'];
		$sec=$db->conn->nextId('SEC_INV');
		if($Titulo=="")$Titulo=" ";
		if($observa=="")$observa=" ";
		include("$ruta_raiz/include/query/archivo/queryInventario.php");
		$rs = $db->query($sqlInv);






//print ("entro aki".$c);
//if($c=='12345')echo "Datos traidos";


$rse->MoveNext();
}



	?><tr><TD class=titulos5 >
	<?php

	if($cont==1){
	if(!$rs->EOF)echo "No se pudo agregar";
	else echo "La informacion fue agregada al Inventario";
	}
	else {
	if(!$rs->EOF)echo "No se pudo agregar";
	else echo "La informacion fue agregada al Inventario";
	}

}
if($Limpiar){
	//$lim="DELETE FROM SGD_EIT_ITEMS";
	$lim="DELETE FROM SGD_EINV_INVENTARIO";
	$CL=$db->query($lim);
	echo "EL REGISTRO HA SIDO BORRADO";
}
}


if($tipo==3){
	?>
	<tr><TD colspan='2' align="center">
	<?php
	if(!$CargarCSV){
?>
	<input name="CargarCSV" type="button" class="botones_funcion" onClick="CargarCsv();" value=" CargarCSV " >
<?php
}
if(!$Agregar){
?>
	<input name='Agregar' type=submit class="botones_funcion" value="Agregar"  >
<?php
}
if(!$Generar){
?>
	<input name='Generar' type="button" class="botones_funcion" id="envia22" onClick="GenerarInv()" value="Generar" >
<?php
}
if(!$Limpiar){
?>
	<input name='Limpiar' type=submit class="botones_funcion" value="Limpiar"  ><b></b>
<?php
}
}
if ($tipo==3 or $tipo==2){
?>
<a href='archivo.php?<?=session_name()?>=<?=trim(session_id())?>krd=<?=$krd?>'><input name='Regresar' align="middle" type="button" class="botones_funcion" id="envia22"  value="Regresar" >
<?php }?>

	</TD></tr>
</table>