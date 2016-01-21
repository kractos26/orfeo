<?
/*************************************************************************************/
/* ORFEO GPL:Sistema de Gestion Documental		http://www.orfeogpl.org	     */
/*	Idea Original de la SUPERINTENDENCIA DE SERVICIOS PUBLICOS DOMICILIARIOS     */
/*				COLOMBIA TEL. (57) (1) 6913005  orfeogpl@gmail.com   */
/* ===========================                                                       */
/*                                                                                   */
/* Este programa es software libre. usted puede redistribuirlo y/o modificarlo       */
/* bajo los terminos de la licencia GNU General Public publicada por                 */
/* la "Free Software Foundation"; Licencia version 2. 			             */
/*                                                                                   */
/* Copyright (c) 2005 por :	  	  	                                     */
/* SSPS "Superintendencia de Servicios Publicos Domiciliarios"                       */
/*   Jairo Hernan Losada  jlosada@gmail.com                Desarrollador             */
/*   Sixto Angel Pinzón López --- angel.pinzon@gmail.com   Desarrollador             */
/* C.R.A.  "COMISION DE REGULACION DE AGUAS Y SANEAMIENTO AMBIENTAL"                 */ 
/*   Liliana Gomez        lgomezv@gmail.com                Desarrolladora            */
/*   Lucia Ojeda          lojedaster@gmail.com             Desarrolladora            */
/* D.N.P. "Departamento Nacional de Planeación"                                      */
/*   Hollman Ladino       hladino@gmail.com                Desarrollador             */
/*                                                                                   */
/* Colocar desde esta lInea las Modificaciones Realizadas Luego de la Version 3.5    */
/*  Nombre Desarrollador   Correo     Fecha   Modificacion                           */
/*************************************************************************************/
?>
<?
$krdOld = $_GET['krd'];
$carpetaOld = $carpeta;
$tipoCarpOld = $tipo_carp;
if(!$tipoCarpOld) $tipoCarpOld= $tipo_carpt;
session_start();
$krd=(!isset($_SESSION['krd']))?$krdOsld:$_SESSION['krd'];
$ruta_raiz = "..";

include "$ruta_raiz/rec_session.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
include("$ruta_raiz/class_control/usuario.php");

error_reporting(7);
if(!$tipoEstadistica) $tipoEstadistica =1;
if(!$dependencia_busq) $dependencia_busq =$dependencia;

/** DEFINICION DE VARIABLES ESTADISTICA
	*	var $tituloE String array  Almacena el titulo de la Estadistica Actual
	* var $subtituloE String array  Contiene el subtitulo de la estadistica
	* var $helpE String Almacena array Almacena la descripcion de la Estadistica.
	*/

$tituloE[1] = "PROCESOS - ESTADO GENERAL DE PROCESOS";
//$tituloE[2] = "PROCESOS DETALLE FLUJO RADICADOS (INSTRUCTIVO 42)";
$subtituloE[1] = "ORFEO - Generada el: " . date("Y/m/d H:i:s"). "\n Parametros de Fecha: Entre $fecha_ini y $fecha_fin";
	
$helpE[1] = "Este reporte genera la cantidad de procesos asignados a cada usuario.  Ademas muestas una discriminaci&oacute;n por estado de los radicados." ;
//$helpE[2] = "" ;

	
$db = new ConnectionHandler($ruta_raiz);	
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
$objUsuario = new Usuario($db);



$ano_ini = date("Y");
$mes_ini = substr("00".(date("m")-1),-2);
 if ($mes_ini==0) {$ano_ini==$ano_ini-1; $mes_ini="12";}
$dia_ini = date("d");
if(!$fecha_ini) $fecha_ini = "$ano_ini/$mes_ini/$dia_ini";
	$fecha_busq = date("Y/m/d") ;
if(!$fecha_fin) $fecha_fin = $fecha_busq;


?>	  
<html>
<head>
<title>principal</title>
<link rel="stylesheet" href="../estilos/orfeo.css" type="text/css">
<link rel="stylesheet" type="text/css" href="<?=$ruta_raiz?>/js/spiffyCal/spiffyCal_v2_1.css">
<script type="text/javascript" src="<?=$ruta_raiz?>/js/spiffyCal/spiffyCal_v2_1.js"></script>
<script type="text/javascript" language="javascript">
<!--

	 function adicionarOp (forma,combo,desc,val,posicion){
		o = new Array;
		o[0]=new Option(desc,val );
		eval(forma.elements[combo].options[posicion]=o[0]);
		//alert ("Adiciona " +val+"-"+desc );
		
	}
		  
	   var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "formulario", "fecha_ini","btnDate1","<?=$fecha_ini?>",scBTNMODE_CUSTOMBLUE);
	   var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "formulario", "fecha_fin","btnDate2","<?=$fecha_fin?>",scBTNMODE_CUSTOMBLUE);

--></script>
</head>
<?
include "$ruta_raiz/envios/paEncabeza.php";
?>
<br />
<body bgcolor="#ffffff"  topmargin="0">
<div id="spiffycalendar" class="text"></div>
<form name="formulario"  method=post action='vistaFormProc.php?<?=session_name()."=".trim(session_id())."&krd=$krd&fechah=$fechah"?>'>

<table width="100%"  border="0" cellpadding="0" cellspacing="5" class="borde_tab">
  <tr>
    <td colspan="2" class="titulos4"><A href='vistaFormConsulta.php?<?=session_name()."=".trim(session_id())."&krd=$krd&fechah=$fechah"?>' style="color: #FFFFCC;">Estadisticas </A> - <center>PROCESOS </center> </td>
  </tr>
  <tr>
    <td colspan="2" class="titulos3"><span class="cal-TextBox"><?=$helpE[$tipoEstadistica]?></span></td>
  </tr>
  <tr>
    <td width="30%" class="titulos2">Tipo de Consulta / Estadistica</td>
    <td class="listado2" align="left">
	   <select name="tipoEstadistica"  class="select" onChange="formulario.submit();">
		<?	
		foreach($tituloE as $key=>$value){
			     $selectE =$tipoEstadistica==$key? " selected ": $selectE = ""; ?>
			<option value=<?=$key?> <?=$selectE?>><?=$tituloE[$key]?></option>
		<?	} ?>
		</select>
	</td>
	</tr>
	<tr>
    <td width="30%" class="titulos2">Dependencia</td>
    <td class="listado2">
	<select name="dependencia_busq"  class="select"  onChange="formulario.submit();">
	<?
	if($usua_perm_estadistica>1){
		$datoss=($dependencia_busq==99999)? " selected ":"";
		?>
			<option value=99999  <?=$datoss?>>-- Todas las Dependencias --</option>
		<?
	}

	$whereDepSelect=" DEPE_CODI = $dependencia ";
	if ($usua_perm_estadistica==1){
		$whereDepSelect=" $whereDepSelect or depe_codi_padre = $dependencia ";	
	}
	if ($usua_perm_estadistica==2) {
		$isqlus = "select a.DEPE_CODI,a.DEPE_NOMB,a.DEPE_CODI_PADRE from DEPENDENCIA a ORDER BY a.DEPE_NOMB";
	}
	else {
	//$whereDepSelect=
		$isqlus = "select a.DEPE_CODI,a.DEPE_NOMB,a.DEPE_CODI_PADRE from DEPENDENCIA a 
							where $whereDepSelect ";
	}
	//if($codusuario!=1) $isqlus .= " and a.usua_codi=$codusuario "; 
    //echo "--->".$isqlus;

$rs1=$db->query($isqlus);

do{
	$codigo = $rs1->fields["DEPE_CODI"]; 
	$vecDeps[]=$codigo;
	$depnombre = $rs1->fields["DEPE_NOMB"];
	$datoss=($dependencia_busq==$codigo)?$datoss= " selected ":"";
	echo "<option value=$codigo  $datoss>$depnombre</option>";		
	$rs1->MoveNext();
}while(!$rs1->EOF);
	?>
	</select>
</td>
</tr>
<?
		if ($dependencia_busq != 99999)  {
			$whereDependencia = " AND b.DEPE_CODI=$dependencia_busq ";
			$whereDependenciaU = " AND u.DEPE_CODI=$dependencia_busq ";
		}

/*if($tipoEstadistica==1 or $tipoEstadistica==2 or $tipoEstadistica==3 or $tipoEstadistica==4 or $tipoEstadistica==5 or $tipoEstadistica==6 or $tipoEstadistica==7)*/

if($tipoEstadistica >=1 && $tipoEstadistica<=7 )
{
?>
<tr id="cUsuario">
	<td width="30%" class="titulos2">Usuario
		<br />
	<?	$datoss = isset($usActivos) && ($usActivos) ?" checked ":"";	?>
	<input name="usActivos" type="checkbox" class="select" <?=$datoss?> onChange="formulario.submit();">
	Incluir Usuarios Inactivos  </td>
	<td class="listado2">
	<select name="codus"  class="select"  onChange="formulario.submit();">
	<? 	if ($usua_perm_estadistica > 0){	?>
			<option value=0> -- AGRUPAR POR TODOS LOS USUARIOS --</option>
	<?	}
		$whereUsSelect=(!isset($_POST['usActivos']))?" u.USUA_ESTA = '1' ":"";
		$whereUsSelect=($usua_perm_estadistica < 1)?
					(($whereUsSelect!="")?$whereUsSelect." AND u.USUA_LOGIN='$krd' ":" u.USUA_LOGIN='$krd' "):$whereUsSelect;	
        
		if($dependencia_busq != 99999)  {
 			
			$whereUsSelect=($whereUsSelect=="")? substr($whereDependenciaU,4):$whereUsSelect.$whereDependenciaU;
			$isqlus = "select u.USUA_NOMB,u.USUA_CODI,u.USUA_ESTA from USUARIO u 
					   where  $whereUsSelect 
					   order by u.USUA_NOMB";
			//if($codusuario!=1) $isqlus .= " and a.usua_codi=$codusuario "; 
			//echo "--->".$isqlus;
			$rs1=$db->query($isqlus);
			while(!$rs1->EOF)  {
				$codigo = $rs1->fields["USUA_CODI"]; 
				$vecDeps[]=$codigo;
				$usNombre = $rs1->fields["USUA_NOMB"];
				$datoss=($codus==$codigo)?$datoss= " selected ":"";
				echo "<option value=$codigo  $datoss>$usNombre</option>";		
				$rs1->MoveNext();
			}
		}
		?>
		</select>
	&nbsp;</td>
  </tr>
  <tr id="cPFecha">
	<td width="30%" class="titulos2">A&ntilde;o de Creado el Expediente
		<BR>
	</td>
	<td class="listado2">
	<select name=codAno  class="select"  onChange="formulario.submit();">
		<option value='0'> -- MOSTRAR CONSOLIDADOS LOS A&Ntilde;OS --</option>
		<?
		for($iAno=$ano_ini;($iAno>=($ano_ini-10));$iAno--){
			if($codAno==$iAno) $datoss = " selected "; else $datoss = "";
		?>
					<option value=<?=$iAno?>  <?=$datoss?> ><?=$iAno?></option>		
		<?	} ?>
		</select>
	&nbsp;</td>
  </tr>
  <?
  }
  ?>
  <tr id="cPFecha">
	<td width="30%" class="titulos2">Tipo Proceso
		<BR>
	</td>
	<td class="listado2">
	<?php
  		// Muestra todos los procesos
  		$sqlprocesos = "SELECT SGD_PEXP_DESCRIP,SGD_PEXP_CODIGO FROM SGD_PEXP_PROCEXPEDIENTES";
  		$rs1 = $db->query($sqlprocesos);
		$valor = "";
		$default_str=isset($_POST['codProceso'])?$_POST['codProceso']:"";
		$nmenu = "codProceso";
		$itemBlanco = " -- Agrupar por Todos los Procesos -- ";
		echo $rs1->GetMenu2($nmenu, $default_str, $blank1stItem = "$valor:$itemBlanco",false,'0',' class=select');
		$codAno = isset($_POST['codAno'])&&($_POST['codAno']!= '0') ? $_POST['codAno']: ""	;
  	?>
	&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="titulos2">
	<center>
	<input name="Submit" type="submit" class="botones_funcion" value="Limpiar"> 
	<input type="submit" class="botones_funcion" value="Generar" name="generarOrfeo">
	</center>
	</td>
  </tr>
</table>
</form>
<?
$fecha_ini=isset($fecha_ini)?$fecha_ini:"";
$fecha_fin=isset($fecha_fin)?$fecha_fin:"";
$tipoDocumento=isset($tipoDocumento)?$tipoDocumento:"";
$codus=isset($codus)?$codus:"";
$tipoRadicado=isset($tipoRadicado)?$tipoRadicado:"";
$fechaf=isset($fechaf)?$fechaf:"";
$datosaenviar = urlencode("fechaf=$fechaf&tipoEstadistica=$tipoEstadistica&codus=$codus&krd=$krd&dependencia_busq=$dependencia_busq&ruta_raiz=$ruta_raiz&fecha_ini=$fecha_ini&fecha_fin=$fecha_fin&tipoRadicado=$tipoRadicado&tipoDocumento=$tipoDocumento&fechaano=$codAno");
if(isset($_POST['generarOrfeo']) && $_POST['generarOrfeo']==='Generar'){
   include "genEstadisticaProc.php";
}
?>
</body>
</html>
