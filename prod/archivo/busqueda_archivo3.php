<? $krdOld = $krd;
// Modificado SGD 10-Septiembre-2007
if( !isset( $codDpto ) )
{
	$codDpto = 0;
}
session_start();

if(!$krd) $krd = $krdOld;
if (!$ruta_raiz) $ruta_raiz = "..";
include "$ruta_raiz/rec_session.php";
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
	$db = new ConnectionHandler("$ruta_raiz");
	$db2 = new ConnectionHandler("$ruta_raiz");
	$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&dependencia=$dependencia&krd=$krd&sel=$sel";
	$encabezado = session_name()."=".session_id()."&krd=$krd&tipo_archivo=1&nomcarpeta=$nomcarpeta";

	function fnc_date_calcy($this_date,$num_years){
	$my_time = strtotime ($this_date); //converts date string to UNIX timestamp
   	$timestamp = $my_time + ($num_years * 86400); //calculates # of days passed ($num_days) * # seconds in a day (86400)
    $return_date = date("Y-m-d",$timestamp);  //puts the UNIX timestamp back into string format
    return $return_date;//exit function and return string
   }
    function fnc_date_calcm($this_date,$num_month){
	$my_time = strtotime ($this_date); //converts date string to UNIX timestamp
   	$timestamp = $my_time - ($num_month * 2678400 ); //calculates # of days passed ($num_days) * # seconds in a day (86400)
    $return_date = date("Y-m-d",$timestamp);  //puts the UNIX timestamp back into string format
    return $return_date;//exit function and return string
    }
?>
<html height=50,width=150>
<head>
<title>Busqueda Avanzada en Archivo</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
<CENTER>
<body bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
 <link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
 <script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js">


 </script>



<form name=busqueda_archivo action="<?=$encabezadol?>" method='post' action='busqueda_archivo.php?<?=session_name()?>=<?=trim(session_id())?>krd=<?=$krd?>'>
<br>

<? // parametrizacion de items
$db->conn->debug=true;
	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	$rs=$db->query($sql1);
	$item11=$rs->fields["SGD_EIT_NOMBRE"];
	$tm=explode(' ',$item11);
	$item1=$tm[0];
	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	$rs=$db->query($sql12);
	$item21=$rs->fields["SGD_EIT_NOMBRE"];
	$tm=explode(' ',$item21);
	$item2=$tm[0];
	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	$rs=$db->query($sql6);
	$item31=$rs->fields["SGD_EIT_NOMBRE"];
	$tm=explode(' ',$item31);
	$item3=$tm[0];
	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	$rs=$db->query($sql7);
	$item41=$rs->fields["SGD_EIT_NOMBRE"];
	$tm=explode(' ',$item41);
	$item4=$tm[0];
	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	$rs=$db->query($sql8);
	$item51=$rs->fields["SGD_EIT_NOMBRE"];
	$tm=explode(' ',$item51);
	$item5=$tm[0];
	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	$rs=$db->query($sql9);
	$item61=$rs->fields["SGD_EIT_NOMBRE"];
	$tm=explode(' ',$item61);
	$item6=$tm[0];

/*
	$item1="Archivador";
	$item2="Consecutivo";
	$item3="Piso";*/
 ?>

<table border=0 width="90%" cellpadding="0"  class="borde_tab">
  <td class=titulosError  width="80%" colspan="4" align="center">BUSQUEDA AVANZADA (SOLO PARA RADICADOS ARCHIVADOS) </td>

<tr><td width="20%" class='titulos2' align="left">
&nbsp;SERIE </td>
<td width="20%" class='titulos2'>
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
	$querySerie = "select distinct ($sqlConcat) as detalle, s.sgd_srd_codigo from sgd_mrd_matrird m,
 	sgd_srd_seriesrd s where s.sgd_srd_codigo = m.sgd_srd_codigo and ".$sqlFechaHoy." between s.sgd_srd_fechini
 	and s.sgd_srd_fechfin order by detalle ";
	$rsD=$db->conn->query($querySerie);
	$comentarioDev = "Muestra las Series Docuementales";
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsD->GetMenu2("codserie", $codserie, "0:-- Seleccione --", false,"","onChange='submit()' class='select'" );
	?>
	<td width="20%" class='titulos2' align="left">EXPEDIENTE</td>
	<td width="20%" class='titulos2'><input type=text name=buscar_exp value='<?=$buscar_exp?>' class="tex_area">
	</td></tr>
	<tr><td width="20%" class='titulos2' align="left"> SUBSERIE </td>
	<td width="20%" class='titulos2'>
	<?
	$nomb_varc = "su.sgd_sbrd_codigo";
	$nomb_varde = "su.sgd_sbrd_descrip";
	include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
	$querySub = "select distinct ($sqlConcat) as detalle, su.sgd_sbrd_codigo from sgd_mrd_matrird m,
 	sgd_sbrd_subserierd su where m.sgd_srd_codigo = '$codserie' and su.sgd_srd_codigo = '$codserie'
			and su.sgd_sbrd_codigo = m.sgd_sbrd_codigo and ".$sqlFechaHoy." between su.sgd_sbrd_fechini
			and su.sgd_sbrd_fechfin order by detalle ";
	$rsSub=$db->conn->query($querySub);
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsSub->GetMenu2("tsub", $tsub, "0:-- Seleccione --", false,"","onChange='submit()' class='select'" );

	if(!$codiSRD)
	{
		$codiSRD = $codserie;
		$codiSBRD =$tsub;
	}

	?>
	<td width="20%" class='titulos2' align="left"> RADICADO </td>
	<td width="20%" class='titulos2'><input type=text name=buscar_rad value='<?=$buscar_rad?>' class="tex_area">
	</td></tr>
	<tr><td width="20%" class='titulos2' align="left">PROCESO </td>
	<td width="20%" class='titulos2'>
          <?
          $queryPEXP = "select SGD_PEXP_DESCRIP,SGD_PEXP_CODIGO FROM SGD_PEXP_PROCEXPEDIENTES WHERE
				SGD_SRD_CODIGO=$codiSRD AND SGD_SBRD_CODIGO=$codiSBRD
			";
          	$rsP=$db->conn->query($queryPEXP);
			$texp = $rsP->fields["SGD_PEXP_CODIGO"];
            $comentarioDev = "Muestra los procesos segun la combinacion Serie-Subserie";
            include "$ruta_raiz/include/tx/ComentarioTx.php";

            print $rsP->GetMenu2("codProc", $codProc, "0:-- Seleccione --", false,"","class='select'" );
            ?>
	<td width="20%" class='titulos2' align="left">PARAMETROS </td>
	<td width="20%" class='titulos2'><input type=text name=buscar_parametros value='<?=$buscar_parametros?>' class="tex_area">
    </td></tr>
    <?
	if($docu1 == 1) $datoss = "checked"; else $datoss= "";
	?>
	<tr> <td width="20%" class='titulos2' align="left">
	NIT
   <input name="docu1" type="checkbox" class="select" value="1" <?=$datoss?>>
	&nbsp;&nbsp;No DE CEDULA
   <?
	if($docu1 == 2) $datoss = "checked"; else $datoss= "";
	?>
	<input name="docu1" type="checkbox" class="select" value="2" <?=$datoss?>>
	<br>No DE REFERENCIA
   <?
	if($docu1 == 3) $datoss = "checked"; else $datoss= "";
	?>
	<input name="docu1" type="checkbox" class="select" value="3" <?=$datoss?>></td>
   <td width="20%" class='titulos2'><input type=text name=buscar_docu value='<?=$buscar_docu?>' size="11"  maxlength="9" class="tex_area">
   &nbsp;&nbsp;Para cedula: xx.xxx.xxx
    <?

   ?>
<td width="20%" class='titulos2'>EDIFICIO </td>
<TD width="20%" class='titulos2' >
				<? 
				$sql5="select SGD_EIT_SIGLA,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE='0' ";
				$rs=$db->query($sql5);
				print $rs->GetMenu2('exp_edificio',$exp_edificio,true,false,"","onChange='submit()'  class=select");
				?>
</td></td></tr>
<tr><td width="20%" class='titulos2' align="left"><?=$item1?> </td>
<td width="20%" class='titulos2'><!--input type=text name=buscar_isla value='<?=$buscar_piso?>' class="tex_area" size=3 maxlength="2"></td-->
<?

  $query="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE LIKE '$exp_edificio'";
  $rs1=$db->conn->query($query);
  print $rs1->GetMenu2('buscar_piso',$buscar_piso,true,false,"","onChange='submit()' class=select");
  ?>

<td width="20%" class='titulos2'><?=$item2?> </td>
<td width="20%" class='titulos2'>
<?
				$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE LIKE '$buscar_piso'";
				$rs=$db->query($sql);
				print $rs->GetMenu2('buscar_ufisica',$buscar_ufisica,true,false,"","onChange='submit()'  class=select");
   		    	?>
</td></tr>

<tr><td width="20%" class='titulos2' align="left"><?=$item3?> </td>
<td width="20%" class='titulos2'>
<?

  $query="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE LIKE '$buscar_ufisica'";
  $rs1=$db->conn->query($query);
  print $rs1->GetMenu2('buscar_estan',$buscar_estan,true,false,"","onChange='submit()' class=select");
  ?>

<td width="20%" class='titulos2'><?=$item4?> </td>
<td width="20%" class='titulos2'>
<?
				$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE LIKE '$buscar_estan'";
				$rs=$db->query($sql);
				print $rs->GetMenu2('buscar_entre',$buscar_entre,true,false,"","onChange='submit()' class=select");
   		    	?>
</td></tr>
<tr><td width="20%" class='titulos2' align="left"><?=$item5?> </td>
<td width="20%" class='titulos2'>
<?

  $query="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE LIKE '$buscar_entre'";
  $rs1=$db->conn->query($query);
  print $rs1->GetMenu2('buscar_caja',$buscar_caja,true,false,"","onChange='submit()' class=select");
  ?>

<td width="20%" class='titulos2'><?=$item6?> </td>
<td width="20%" class='titulos2'>
<?
				$sql="select SGD_EIT_NOMBRE,SGD_EIT_CODIGO from SGD_EIT_ITEMS where SGD_EIT_COD_PADRE LIKE '$buscar_caja'";
				$rs=$db->query($sql);
				print $rs->GetMenu2('buscar_caja2',$buscar_caja2,true,false,""," class=select");
   		    	?>
</td></tr>
<tr><td width="20%" class='titulos2' align="left">DEPARTAMENTO </td>
<td width="20%" class='titulos2'>
          <?

			$rsPE=$db->conn->query($queryDpto);
			if( $rsPE )
            print $rsPE->GetMenu2("codDpto", $codDpto, "0:-- Seleccione --", false,""," onChange='submit()' class='select'" );
            ?>
            <td width="20%" class='titulos2' align="left"> FECHA ARCHIVO &nbsp;&nbsp;&nbsp;&nbsp;  Desde  <br>&nbsp;&nbsp;&nbsp;
            <?
			if($sep == 1) $datoss = "checked"; else $datoss= "";
			?>
            <input name="sep" type="checkbox" class="select" value="1" <?=$datoss?>>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta
            </td>
	<td width="20%" class='titulos2'>
	<script language="javascript">
  	<?
	 	if(!$fechaInii) $fechaInii=fnc_date_calcm(date('Y-m-d'),'1');
	 	if(!$fechaInif) $fechaInif = date('Y-m-d');
  	?>
   	var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "busqueda_archivo", "fechaInii","btnDate1","<?=$fechaInii?>",scBTNMODE_CUSTOMBLUE);
	dateAvailable1.date = "<?=date('Y-m-d');?>";
	dateAvailable1.writeControl();
	dateAvailable1.dateFormat="yyyy-MM-dd";
	</script>
	<br>&nbsp;
	<script language="javascript">
	var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "busqueda_archivo", "fechaInif","btnDate1","<?=$fechaInif?>",scBTNMODE_CUSTOMBLUE);
	dateAvailable2.date = "<?=date('Y-m-d');?>";
	dateAvailable2.writeControl();
	dateAvailable2.dateFormat="yyyy-MM-dd";
	</script>

            </td></tr>
 <tr><td width="20%" class='titulos2' align="left">MUNICIPIO </td>
 <td width="20%" class='titulos2'>
          <?
          	$rsPX=$db->conn->query($queryMuni);
			print $rsPX->GetMenu2("codMuni", $codMuni, "0:-- Seleccione --", false,"","class='select'" );

            ?>
	<td width="20%" class='titulos2'>FECHA FINAL  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Desde <br>&nbsp;&nbsp;&nbsp;
	<?
			if($sel1 == 1) $datoss = "checked"; else $datoss= "";
			?>
            <input name="sel1" type="checkbox" class="select" value="1" <?=$datoss?>>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;Hasta
	</td>

	<td width="20%" class='titulos2'>
	<script language="javascript">
  	<?
  	 	if(!$fechaFini) $fechaFini=fnc_date_calcm(date('Y-m-d'),'1');
	 	if(!$fechaFinf) $fechaFinf = date('Y-m-d');
  	?>
   	var dateAvailable3 = new ctlSpiffyCalendarBox("dateAvailable3", "busqueda_archivo", "fechaFini","btnDate1","<?=$fechaFini?>",scBTNMODE_CUSTOMBLUE);
  				dateAvailable3.date = "<?=date('Y-m-d');?>";
				dateAvailable3.writeControl();
				dateAvailable3.dateFormat="yyyy-MM-dd";
			</script>
			<br>&nbsp;
	<script language="javascript">
	var dateAvailable4 = new ctlSpiffyCalendarBox("dateAvailable4", "busqueda_archivo", "fechaFinf","btnDate1","<?=$fechaFinf?>",scBTNMODE_CUSTOMBLUE);
  				dateAvailable4.date = "<?=date('Y-m-d');?>";
				dateAvailable4.writeControl();
				dateAvailable4.dateFormat="yyyy-MM-dd";
			</script>
			</td></tr>

<tr><td width="20%" class='titulos2' align="left">RETENCION </td>
<?
	if($buscar_rete == 1) $datoss = "checked"; else $datoss= "";
?>
<td width="20%" class='titulos2'> AG <input name="buscar_rete" type="checkbox" class="select" value="1" <?=$datoss?>> &nbsp;&nbsp;
<?
	if($buscar_rete == 2) $datoss = "checked"; else $datoss= "";
?>
AC <input name="buscar_rete" type="checkbox" class="select" value="2" <?=$datoss?>>
<!--input type=text name=buscar_rete value='<?=$buscar_rete?>' class="tex_area" size=3 maxlength="2"></td-->
<!--td width="20%" class='titulos2'>CAJA </td>
<td width="20%" class='titulos2'><input type=text name=buscar_caja value='<?=$buscar_caja?>' class="tex_area" size=3 maxlength="2"></td-->
</tr>
<tr><td colspan="2" align="right"><input type=submit value=Buscar name=Buscar class="botones">&nbsp;</td>
<td colspan="2" align="left"><a href='archivo.php?<?=session_name()?>=<?=trim(session_id())?>krd=<?=$krd?>'><input name='Regresar' align="middle" type="button" class="botones" id="envia22" value="Regresar" ></td>
</table>
<br>
<?
if($Buscar){

?>
<table border=0 width 100% cellpadding="1"  class="borde_tab">
<TD class=titulos5 >RADICADO
<TD class=titulos5 >FECHA RADICADO
<TD class=titulos5 >EXPEDIENTE
<TD class=titulos5 >DOCUMENTO
<TD class=titulos5 >SERIE
<TD class=titulos5 >SUBSERIE
<TD class=titulos5 >PROCESO
<TD class=titulos5 >PARAMETRO 1
<TD class=titulos5 >PARAMETRO 2
<TD class=titulos5 >PARAMETRO 3
<TD class=titulos5 >PARAMETRO 5
<TD class=titulos5 >FOLIOS
<TD class=titulos5 >PISO O ZONA
<TD class=titulos5 ><?=$item1?>
<TD class=titulos5 ><?=$item3?>
<TD class=titulos5 >ESTANTE
<TD class=titulos5 >ENTREPANO
<TD class=titulos5 >CAJA
<TD class=titulos5 >UNIDAD DOCUMENTAL
<TD class=titulos5 >FECHA ARCHIVO
<TD class=titulos5 >FECHA FINAL
</tr>

<?
if($buscar_exp!=""){$x="e.SGD_EXP_NUMERO LIKE '%$buscar_exp%'";$a="and";}
else {$x="";$a="";}
if($buscar_rad!=""){$r="e.RADI_NUME_RADI LIKE '%$buscar_rad%'";$b="and";}
else {$r="";$b="";}
if($codserie!='0'){$srds="s.SGD_SRD_CODIGO LIKE '$codserie'";$c="and";}
else {$srds="";$c="";}
if($codiSBRD!='0'){$sbrds="s.SGD_SBRD_CODIGO LIKE '$codiSBRD'";$d="and";}
else {$sbrds="";$d="";}
if($codProc!='0'){$pross="s.SGD_PEXP_CODIGO LIKE '$codProc'";$ef="and";}
else{$pross="";$ef="";}
if($buscar_piso!=""){$pis="e.SGD_EXP_ISLA LIKE '$buscar_piso'";$f="and";}
else {$pis="";$f="";}
if($buscar_estan!=""){
if($item3=="ESTANTE")$estan="e.SGD_EXP_ESTANTE LIKE '$buscar_estan'";
elseif($item3=="CARRO")$estan="e.SGD_EXP_CARRO LIKE '$buscar_estan'";
elseif($item3=="ENTREPANO")$estan="e.SGD_EXP_ENTREPA LIKE '$buscar_estan'";
elseif($item3=="CARA" )$estan="e.SGD_EXP_UFISICA LIKE '$buscar_estan'";
$h="and";}
else {$estan="";$h="";}
if($buscar_entre!=""){
if($item4=="ENTREPANO")$entre="e.SGD_EXP_ENTREPA LIKE '$buscar_entre'";
elseif($item4=="ESTANTE")$entre="e.SGD_EXP_ESTANTE LIKE '$buscar_entre'";
$v="and";}
else {$entre="";$v="";}
if($buscar_caja!=""){
if($item5=="ENTREPANO")$caja="e.SGD_EXP_ENTREPA LIKE '$buscar_caja'";
elseif($item5=="CAJA")$caja="e.SGD_EXP_CAJA LIKE '$buscar_caja'";
$t="and";}
else {$caja="";$s="";}
if($buscar_caja2!=""){
$caja2="e.SGD_EXP_CAJA LIKE '$buscar_caja2'";
$u="and";}
else {$caja2="";$s="";}
if ($sep=='1'){
	if($fechaInii==$fechaInif)$fecha="e.SGD_EXP_FECH_ARCH like '$fechaInii'";
	else{
	$time=fnc_date_calcy($fechaInif,'1');
	$fecha="e.SGD_EXP_FECH_ARCH <= '$time' and e.SGD_EXP_FECH_ARCH >= '$fechaInii'";
	}
	$i="and";
}
else {$fecha="";$fech="";$i="";}
if ($sel1=='1'){
	if($fechaFini==$fechaFinf)$fecha="e.SGD_EXP_FECHFIN like '$fechaFini'";
	else{
		$time2=fnc_date_calcy($fechaFinf,'1');
		$fechafin="e.SGD_EXP_FECHFIN <= '$time2' and e.SGD_EXP_FECHFIN >= '$fechaFini'";

	}
	$j="and";
}
else {$fechafin="";$fechfin="";$j="";}
if($buscar_rete!=""){$foli="e.SGD_EXP_RETE LIKE '$buscar_rete'";$k="and";}
else {$foli="";$k="";}
if($buscar_parametros!=""){$param="s.SGD_SEXP_PAREXP1 LIKE '%$buscar_parametros%' OR s.SGD_SEXP_PAREXP2 LIKE
'%$buscar_parametros%' OR s.SGD_SEXP_PAREXP3 LIKE '%$buscar_parametros%' OR s.SGD_SEXP_PAREXP4 LIKE '%$buscar_parametros%'
OR s.SGD_SEXP_PAREXP5 LIKE '%$buscar_parametros%'";$l="and";}
else {$param="";$l="";}
if($buscar_consecutivo!=""){$conse="e.SGD_EXP_CARPETA LIKE '$buscar_consecutivo'";$n="and";}
else {$conse="";$n="";}
if($buscar_ufisica!=""){
if($item2=="AREA" or $item2=="CARA" )$archi="e.SGD_EXP_UFISICA LIKE '$buscar_ufisica'";
if($item2=="ESTANTE")$archi="e.SGD_EXP_ESTANTE LIKE '$buscar_ufisica'";
elseif($item2=="CARRO")$archi="e.SGD_EXP_CARRO LIKE '$buscar_ufisica'";
$o="and";}
else {$archi="";$o="";}
if($codMuni!='0'){
		$queryMuni = "select MUNI_NOMB FROM MUNICIPIO WHERE MUNI_CODI= '$codMuni' and DPTO_CODI= '$codDpto'";
		$rsm=$db->query($queryMuni);
 		$munici=$rsm->fields['MUNI_NOMB'];
	$muni="(s.SGD_SEXP_PAREXP1 LIKE '%$munici%' OR s.SGD_SEXP_PAREXP2 LIKE '%$munici%' OR s.SGD_SEXP_PAREXP3
	LIKE '%$munici%' OR s.SGD_SEXP_PAREXP4 LIKE '%$munici%' OR s.SGD_SEXP_PAREXP5 LIKE '%$munici%')";$q="and";
}
else {$muni="";$p="";}
if($codDpto!='0'){
	$queryDpto = "select DPTO_NOMB FROM DEPARTAMENTO WHERE DPTO_CODI= '$codDpto'";
 		$rsD=$db->query($queryDpto);
		$departa=$rsD->fields['DPTO_NOMB'];
	$depa="(s.SGD_SEXP_PAREXP1 LIKE '%$departa%' OR s.SGD_SEXP_PAREXP2 LIKE '%$departa%' OR s.SGD_SEXP_PAREXP3
	LIKE '%$departa%' OR s.SGD_SEXP_PAREXP4 LIKE '%$departa%' OR s.SGD_SEXP_PAREXP5 LIKE '%$departa%')";$p="and";}
else {$depa="";$q="";}
if ($fecha!="" or $fechafin!="")$orde=" order by 2";
else $orde=" order by 1";

$at=$buscar_exp.$buscar_rad.$buscar_piso.$buscar_caja.$buscar_estante.$buscar_caja.$buscar_caja2.$buscar_rete.$fecha.$fechafin.$buscar_parametros.
$buscar_consecutivo.$buscar_ufisica.$codserie.$codiSBRD.$codProc;
$bt=$buscar_exp.$buscar_rad.$buscar_piso.$buscar_caja.$buscar_estante.$buscar_caja.$buscar_caja2.$buscar_rete.$fecha.$fechafin.$buscar_parametros.
$buscar_consecutivo.$buscar_ufisica.$codMuni.$codDpto;
$cont=0;


if(($buscar_docu!="" and $at=='000')){
	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	$rs=$db->query($sqlca);
	while (!$rs->EOF){
		$radi=$rs->fields["RADI_NUME_RADI"];
	 	$fechrad=$rs->fields['FECH'];
	 	$path=$rs->fields['RADI_PATH'];
		$folios=$rs->fields['RADI_NUME_HOJA'];

	 	if($docu1==3)$documento=$rs->fields['RADI_CUENTAI'];
	 	if ($docu1==1)$documento=$rs->fields['NIT_DE_LA_EMPRESA'];
 		else $documento=$rs->fields['SGD_DIR_DOC'];
 	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	$rsr=$db->query($sqlmin);
	while (!$rsr->EOF){
	$expnum=$rsr->fields['SGD_EXP_NUMERO'];
	$parametro1=$rsr->fields['SGD_SEXP_PAREXP1'];
	$parametro2=$rsr->fields['SGD_SEXP_PAREXP2'];
	$parametro3=$rsr->fields['SGD_SEXP_PAREXP3'];
	$parametro4=$rsr->fields['SGD_SEXP_PAREXP5'];
	$fech=$rsr->fields['SGD_EXP_FECH_ARCH'];
	$fechfin=$rsr->fields['SGD_EXP_FECHFIN'];
	$caja1=$rsr->fields['SGD_EXP_CAJA'];
	$archiva1=$rsr->fields['SGD_EXP_UFISICA'];
	$piso1=$rsr->fields['SGD_EXP_ISLA'];
	$consecu=$rsr->fields['SGD_EXP_CARPETA'];
	$carro1=$rsr->fields['SGD_EXP_CARRO'];
	$entrepa1=$rsr->fields['SGD_EXP_ENTREPA'];
	$estante1=$rsr->fields['SGD_EXP_ESTANTE'];
	$srd=$rsr->fields['SGD_SRD_CODIGO'];
	$sbrd=$rsr->fields['SGD_SBRD_CODIGO'];
	$proceso=$rsr->fields['SGD_PEXP_CODIGO'];
	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	$rst=$db->query($sql2);
	if(!$rst->EOF)$caja=$rst->fields["SGD_EIT_SIGLA"];
	$rst=$db->query($sql3);
	if(!$rst->EOF)$estante=$rst->fields["SGD_EIT_SIGLA"];
	$rst=$db->query($sql4);
	if(!$rst->EOF)$piso=$rst->fields["SGD_EIT_SIGLA"];
	$rst=$db->query($sql5);
	if(!$rst->EOF)$archiva=$rst->fields["SGD_EIT_SIGLA"];
	$rst=$db->query($sql10);
	if(!$rst->EOF)$carro=$rst->fields["SGD_EIT_SIGLA"];
	$rst=$db->query($sql11);
	if(!$rst->EOF)$entrepa=$rst->fields["SGD_EIT_SIGLA"];
?>
<tr>

<td class=leidos2 align="center"><a href='../bodega<?=$path?>' > <?=$radi?></b></td>
<td class=leidos2 align="center"><a href='../verradicado.php?<?=$encabezado."&num_expediente=$expnum&verrad=$radi&carpeta_per=0&carpeta=8&nombcarpeta=Expedientes"?>' > <? echo $fechrad;?></a></td>
<td class=leidos2 align="center"><a href='datos_expediente.php?<?=$encabezado."&num_expediente=$expnum&ent=1&nurad=$radi"?>' class='vinculos'><?=$expnum?></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$documento?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$srd?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$sbrd?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$proceso?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$parametro1?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$parametro2?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$parametro3?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$parametro4?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$folios?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$piso?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$archiva?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$carro?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$estante?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$entrepa?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$caja?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$consecu?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$fech?></b></td>
<td class=leidos2 align="center"><b><span class=leidos2><?=$fechfin?></b></td>

</tr>
<?
$cont++;
$rsr->MoveNext();
	}
		$rs->MoveNext();

	}
}

else{

	include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
	/*$linkPagina = "$PHP_SELF?$encabezadol&orde=$orde&orderNo=$orderNo";
$orderNo=1;
$orderTipo="";
	 $pager = new ADODB_Pager( $db, $sql, 'adodb', true, $orderNo, $orderTipo );
    $pager->checkAll = false;
    $pager->checkTitulo = true;
    $pager->toRefLinks = $linkPagina;
    $pager->toRefVars = $encabezadol;
    $pager->descCarpetasGen = $descCarpetasGen;
    $pager->descCarpetasPer = $descCarpetasPer;
    $pager->Render( $rows_per_page = 20, $linkPagina, $checkbox = chkAnulados );
	*/$rs=$db->query($sql);
	while(!$rs->EOF){
		$expnum=$rs->fields['SGD_EXP_NUMERO'];
		$sbrd=$rs->fields['SGD_SBRD_CODIGO'];
		$srd=$rs->fields['SGD_SRD_CODIGO'];
		$proceso=$rs->fields['SGD_PEXP_CODIGO'];
		$parametro1=$rs->fields['SGD_SEXP_PAREXP1'];
		$parametro2=$rs->fields['SGD_SEXP_PAREXP2'];
		$parametro3=$rs->fields['SGD_SEXP_PAREXP3'];
		$parametro4=$rs->fields['SGD_SEXP_PAREXP5'];
		$fech=$rs->fields['SGD_EXP_FECH_ARCH'];
		$fechfin=$rs->fields['SGD_EXP_FECHFIN'];
		$folios=$rs->fields['RADI_NUME_HOJA'];
		$caja1=$rs->fields['SGD_EXP_CAJA'];
		$archiva1=$rs->fields['SGD_EXP_UFISICA'];
		$piso1=$rs->fields['SGD_EXP_ISLA'];
		$radi=$rs->fields["RADI_NUME_RADI"];
		$estante1=$rs->fields['SGD_EXP_ESTANTE'];
		$consecu=$rs->fields['SGD_EXP_CARPETA'];
		$carro1=$rs->fields['SGD_EXP_CARRO'];
		$entrepa1=$rs->fields['SGD_EXP_ENTREPA'];
		$fechrad=$rs->fields['FECH'];
		$path=$rs->fields['RADI_PATH'];
		$eesp=$rs->fields['EESP_CODI'];
		include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
		if($docu1==1){
			$rsm=$db->query($sqld);
			$documento=$rsm->fields['NIT_DE_LA_EMPRESA'];
		}
		if($docu1==3)$documento=$rs->fields['RADI_CUENTAI'];
		else $documento=$rs->fields['SGD_DIR_DOC'];

		include("$ruta_raiz/include/query/archivo/queryBusqueda_exp.php");
		$rsr=$db->query($sql2);
		if(!$rsr->EOF)$caja=$rsr->fields["SGD_EIT_SIGLA"];
		$rsr=$db->query($sql3);
		if(!$rsr->EOF)$estante=$rsr->fields["SGD_EIT_SIGLA"];
		$rsr=$db->query($sql4);
		if(!$rsr->EOF)$piso=$rsr->fields["SGD_EIT_SIGLA"];
		$rsr=$db->query($sql5);
		if(!$rsr->EOF)$archiva=$rsr->fields["SGD_EIT_SIGLA"];
		$rsr=$db->query($sql10);
		if(!$rsr->EOF)$carro=$rsr->fields["SGD_EIT_SIGLA"];
		$rsr=$db->query($sql11);
		if(!$rsr->EOF)$entrepa=$rsr->fields["SGD_EIT_SIGLA"];
		?>
		<tr>

		<td class=leidos2 align="center"><a href='../bodega<?=$path?>' > <?=$radi?></b></td>
		<td class=leidos2 align="center"><a href='../verradicado.php?<?=$encabezado."&num_expediente=$expnum&verrad=$radi&carpeta_per=0&carpeta=8&nombcarpeta=Expedientes"?>' > <? echo $fechrad;?></a></td>
	<td class=leidos2 align="center"><a href='datos_expediente.php?<?=$encabezado."&num_expediente=$expnum&ent=1
			&nurad=$radi"?>' class='vinculos'><?=$expnum?></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$documento?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$srd?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$sbrd?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$proceso?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$parametro1?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$parametro2?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$parametro3?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$parametro4?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$folios?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$piso?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$archiva?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$carro?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$estante?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$entrepa?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$caja?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$consecu?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$fech?></b></td>
		<td class=leidos2 align="center"><b><span class=leidos2><?=$fechfin?></b></td>
		</tr>

		<?
		//$rsm->MoveNext();
		$cont++;
		//}
	$rs->MoveNext();

	}
}
}?>
</table>
<br>
<center><?=$cont?> Archivos Encontrados</center>