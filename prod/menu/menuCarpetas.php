<?php

error_reporting(0);
session_start();
/**
 * Variables a utilizar en este fuente
 */
$dependencia = $_SESSION['dependencia'];
$codusuario = $_SESSION['codusuario'];
$krd = $_SESSION['krd'];
$usua_doc = $_SESSION['usua_doc'];

include("../config.php");
if (!defined('ADODB_ASSOC_CASE'))
    define('ADODB_ASSOC_CASE', 1);
include($ADODB_PATH . '/adodb.inc.php');  // $ADODB_PATH configurada en config.php
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$ADODB_COUNTRECS = false;

$error = 0;
$dsn = $driver . "://" . $usuario . ":" . $contrasena . "@" . $servidor . "/" . $db;
$ADODB_COUNTRECS = false;
$conn = NewADOConnection($dsn);
//$conn->debug=true;
// Esta consulta selecciona las carpetas Basicas de DocuImage que son extraidas de la tabla Carp_Codi
$isql = "select CARP_CODI,CARP_DESC from carpeta order by carp_codi ";
$rs = $conn->Execute($isql);
$addadm = "";
$menuCarpetas = "<table border='0' cellpadding='0' cellspacing='0' width='160' class=eMenu>
<tr>
	<td colspan='2'><a href='#' onClick='window.location.reload()'><img name='menu_r3_c1' src='imagenes/menu_r5_c1.gif' alt='Presione para actualizar las carpetas.' width='148' height='31' border='0'></a></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td valign='top'>
		<table width='100%' border='0' cellpadding='0' cellspacing='0' class=eMenu>
		<tr>
			<td valign='top'>
			<table width='150'  border='0' cellpadding='0' cellspacing='3' class=eMenu>";
$hayCambiosCarpetas = false;
while (!$rs->EOF) {
    if ($data == "")
        $data = "NULL";
    $numdata = trim($rs->fields["CARP_CODI"]);
    $sqlCarpDep = "select SGD_CARP_DESCR from SGD_CARP_DESCRIPCION where SGD_CARP_DEPECODI = " . $dependencia . " and SGD_CARP_TIPORAD = $numdata";
    $rsCarpDesc = $conn->Execute($sqlCarpDep);
    $descripcionCarpeta = $rsCarpDesc->fields["SGD_CARP_DESCR"];
    $data = (!empty($descripcionCarpeta)) ? $descripcionCarpeta : trim($rs->fields["CARP_DESC"]);

    if ($numdata == 11) {   // Se realiza la cuenta de radicados en Visto Bueno VoBo
        if ($_SESSION["usua_vobo_perm"] == 1) {//$codusuario ==1
            $isql = "select count(*) as CONTADOR from radicado
				where carp_per=0 and carp_codi=$numdata
				and  radi_depe_actu=$dependencia
				and radi_usua_actu=$codusuario";
        } else {
            $isql = "select count(*) as CONTADOR from radicado
				where carp_per=0
				and carp_codi=$numdata
				and radi_depe_actu=$dependencia
				and radi_usu_ante='$krd'";
        }
        $addadm = "&adm=1";
    } else {
        $isql = "select count(*) as CONTADOR from radicado
					where carp_per=0 and carp_codi=$numdata
						and  radi_depe_actu=$dependencia
						and radi_usua_actu=$codusuario and radi_nume_radi is not null  ";
        $addadm = "&adm=0";
    }
    $imagen = ($carpeta == $numdata) ? "folder_open.gif" : "folder_cerrado.gif";
    $flag = 0;
    $rs1 = $conn->Execute($isql);
    $numerot = $rs1->fields["CONTADOR"];
    $_SESSION["cantCarpetasGen"][$data][0] = isset($_SESSION["cantCarpetasGen"][$data][1]) ? $_SESSION["cantCarpetasGen"][$data][1] : $numerot;
    $_SESSION["cantCarpetasGen"][$data][1] = $numerot;
    $hayCambiosCarpetas = ($hayCambiosCarpetas) ? $hayCambiosCarpetas : $numerot > $_SESSION["cantCarpetasGen"][$data][0];
    $menuCarpetas .= "<tr valign='middle'>
    	
		<td width='125'><a onclick='cambioMenu($i);' href='cuerpo.php?$phpsession&krd=$krd&adodb_next_page=1&nomcarpeta=$data&carpeta=$numdata&tipo_carpt=0&adodb_next_page=1' class='menu_princ' target='mainFrame' alt='Seleccione una Carpeta'>
		$data($numerot)
		</a> </td>
	</tr>";
    $i++;
    $rs->MoveNext();
}
/**
 * PARA ARCHIVOS AGENDADOS NO VENCIDOS
 *  (Por. SIXTO 20040302)
 */
$sqlFechaHoy = $conn->DBTimeStamp(time());
$sqlAgendado = " and (agen.SGD_AGEN_FECHPLAZO > " . $sqlFechaHoy . ")";
$isql = "select count(*) as CONTADOR from SGD_AGEN_AGENDADOS agen
		where  usua_doc='$usua_doc' and agen.SGD_AGEN_ACTIVO=1 $sqlAgendado";
$rs = $conn->Execute($isql);
$numerot = $rs->fields["CONTADOR"];
$data = "Agendado";
$i++;
$menuCarpetas .= "<tr valign='middle'>
    
		<td width='125'><a onclick='cambioMenu($i);' href='cuerpoAgenda.php?$phpsession&agendado=1&krd=$krd&nomcarpeta=$data&tipo_carpt=0' class='menu_princ' target='mainFrame' alt='Seleccione una Carpeta'>
		Agendado($numerot)
		</a> </td>
	</tr>";
$_SESSION["cantCarpetasGen"][$data][0] = isset($_SESSION["cantCarpetasGen"][$data][1]) ? $_SESSION["cantCarpetasGen"][$data][1] : $numerot;
$_SESSION["cantCarpetasGen"][$data][1] = $numerot;
$hayCambiosCarpetas = ($hayCambiosCarpetas) ? $hayCambiosCarpetas : $numerot > $_SESSION["cantCarpetasGen"][$data][0];
/**
 * PARA ARCHIVOS AGENDADOS  VENCIDOS
 *  (Por. SIXTO 20040302)
 */
$sqlAgendado = " and (agen.SGD_AGEN_FECHPLAZO <= " . $sqlFechaHoy . ")";
$isql = "select count(*) as CONTADOR from SGD_AGEN_AGENDADOS agen
		where  usua_doc='$usua_doc'
		and agen.SGD_AGEN_ACTIVO=1 $sqlAgendado";
$rs = $conn->Execute($isql);
$numerot = $rs->fields["CONTADOR"];
$data = "Agendados vencidos";
$i++;
$menuCarpetas .= "<tr valign='middle'>
    
		<td width='125'>
			<a onclick='cambioMenu($i);' href='cuerpoAgenda.php?$phpsession&agendado=2&krd=$krd&fechah=$fechah&nomcarpeta=$data&&tipo_carpt=0&adodb_next_page=1' class='menu_princ' target='mainFrame' alt='Seleccione una Carpeta'>
			Agendado vencido(<font color='#990000'>$numerot</font>)
		</a> </td>
	</tr>";

       

$_SESSION["cantCarpetasGen"][$data][0] = isset($_SESSION["cantCarpetasGen"][$data][1]) ? $_SESSION["cantCarpetasGen"][$data][1] : $numerot;
$_SESSION["cantCarpetasGen"][$data][1] = $numerot;
$hayCambiosCarpetas = ($hayCambiosCarpetas) ? $hayCambiosCarpetas : $numerot > $_SESSION["cantCarpetasGen"][$data][0];
// Coloca el mensaje de Informados y cuenta cuantos registros hay en informados
$isql = "select count(*) as CONTADOR from informados where depe_codi=$dependencia and usua_codi=$codusuario ";
$imagen = ($carpeta == $numdata and $tipo_carp = 0) ? "folder_open.gif" : "folder_cerrado.gif";
$rs1 = $conn->Execute($isql);
$numerot = $rs1->fields["CONTADOR"];
$data = "Informados";
$i++;
$menuCarpetas .= "<tr valign='middle'>
    	
		<td width='125'><a onclick='cambioMenu($i);' href='cuerpoinf.php?krd=$krd&mostrar_opc_envio=1&carpeta=8&nomcarpeta=Informados&orderTipo=desc&adodb_next_page=1' class='menu_princ' target='mainFrame' alt='Documentos De Informacion' title='Documentos De Informacion'>
		$data($numerot)
		</a> </td>
	</tr>";
$_SESSION["cantCarpetasGen"][$data][0] = isset($_SESSION["cantCarpetasGen"][$data][1]) ? $_SESSION["cantCarpetasGen"][$data][1] : $numerot;
$_SESSION["cantCarpetasGen"][$data][1] = $numerot;
$hayCambiosCarpetas = ($hayCambiosCarpetas) ? $hayCambiosCarpetas : ($numerot > $_SESSION["cantCarpetasGen"][$data][0]);
$data = "Despliegue de Carpetas Personales";
$i++;
$menuCarpetas .= "<tr valign='middle'>
		
		<td width='125'><a onclick='cambioMenu($i);verPersonales($i);' href='#' class='menu_princ'  alt='Despliegue de Carpetas Personales' title='Despliegue de Carpetas Personales'>
		PERSONALES
		</a> </td>
	</tr>
	</table>
	<table width='100%'  border='0' cellpadding='0' cellspacing='0' bgcolor='cacac9' id=carpersolanes style='display:none'  >
	<tr>
    <td><a class='vinculos' href='crear_carpeta.php?$phpsession&krd=$krd&fechah=$fechah&adodb_next_page=1' class='menu_princ' target='mainFrame' alt='Creacion de Carpetas Personales'  title='Creacion de Carpetas Personales' ><font size=2>Nueva carpeta</font></a> </td>
    </tr>";
// BUSCA LAS CARPETAS PERSONALES DE CADA USUARIO Y LAS COLOCA contando el numero de documentos en cada carpeta.
$isql = "select CODI_CARP,DESC_CARP,NOMB_CARP from carpeta_per where usua_codi=$codusuario and depe_codi=$dependencia order by codi_carp  ";
$rs = $conn->Execute($isql);
while (!$rs->EOF) {
    if ($data == "")
        $data = "NULL";
    $data = trim($rs->fields["NOMB_CARP"]);
    $numdata = trim($rs->fields["CODI_CARP"]);
    $detalle = trim($rs->fields["DESC_CARP"]);
    $data = trim($rs->fields["NOMB_CARP"]);
    $isql = "select count(*) as CONTADOR from radicado where carp_per=1 and carp_codi=$numdata and  radi_depe_actu=$dependencia and radi_usua_actu=$codusuario ";
    $imagen = ($carpeta == $numdata and $tipo_carp == 1) ? "ico_carpeta_personal_abierta.gif" : "ico_carpeta_personal_cerrada.gif";
    $rs1 = $conn->Execute($isql);
    $numerot = $rs1->fields["CONTADOR"];
    $datap = "$data(Personal)";
    $menuCarpetas .="<tr>
		<td height='18'><a href='cuerpo.php?$phpsession&krd=$krd&fechah=$fechah&nomcarpeta=$data(Personal)&tipo_carp=1&carpeta=$numdata&adodb_next_page=1' alt='<?=$detalle?>' title='<?=$detalle?>' class='menu_princ' target='mainFrame'>	$data($numerot)</a> </td>
	</tr>";
    $_SESSION["cantCarpetasGen"][$data . '.'][0] = isset($_SESSION["cantCarpetasGen"][$data . '.'][1]) ? $_SESSION["cantCarpetasGen"][$data . '.'][1] : $numerot;
    $_SESSION["cantCarpetasGen"][$data . '.'][1] = $numerot;
    $hayCambiosCarpetas = ($hayCambiosCarpetas) ? $hayCambiosCarpetas : ($numerot > $_SESSION["cantCarpetasGen"][$data . '.'][0]);
    $rs->MoveNext();
}

$menuCarpetas .= "</table>
	</td>
	</tr>
	</table>
	</td>
</tr>
</table>";
/* * *****Contador Archivo **** */
if ($_SESSION["usua_perm_prestamo"] == 1) {
    $contPrestamo = '0';
    if ($_SESSION["usua_admin_archivo"] == 1)
        $where = " AND d.DEPE_CODI_TERRITORIAL=" . $_SESSION["depe_codi_territorial"];
    $isql = "select count(*) as CONTADOR from PRESTAMO p JOIN DEPENDENCIA d ON p.DEPE_CODI=d.DEPE_CODI where p.PRES_ESTADO=1 and p.SGD_EXP_NUMERO is not null $where";
    $rs = $conn->Execute($isql);
    if ($rs->fields["CONTADOR"])
        $contPrestamo = $rs->fields["CONTADOR"];
    $_SESSION["cantCarpetasGen"]['Solicitud Prestamo'][0] = isset($_SESSION["cantCarpetasGen"]['Solicitud Prestamo'][1]) ? $_SESSION["cantCarpetasGen"]['Solicitud Prestamo'][1] : $contPrestamo;
    $_SESSION["cantCarpetasGen"]['Solicitud Prestamo'][1] = $contPrestamo;
    $hayCambiosCarpetaPrestamo = ($hayCambiosCarpetaPrestamo) ? $hayCambiosCarpetaPrestamo : $contPrestamo > $_SESSION["cantCarpetasGen"]['Solicitud Prestamo'][0];
    $totalPrestamo = $contPrestamo;
    $divPrestamo = "@P<span class='Estilo12'><a href='prestamo/menu_prestamo.php?krd=$krd' target='mainFrame' class='menu_princ'><b>Pr&eacute;stamo($totalPrestamo)</a>";
}
if ($_SESSION["usua_admin_archivo"] >= 1) {
    $contExp = '0';
    $isql = "select count(*) as CONTADOR from SGD_SEXP_SECEXPEDIENTES exp JOIN DEPENDENCIA d ON exp.DEPE_CODI=d.DEPE_CODI where exp.SGD_SEXP_FASEEXP=1  $where";
    $rs = $conn->Execute($isql);
    if ($rs->fields["CONTADOR"])
        $contExp = $rs->fields["CONTADOR"];
    $_SESSION["cantCarpetasGen"]['Solicitud Transferencia'][0] = isset($_SESSION["cantCarpetasGen"]['Solicitud Transferencia'][1]) ? $_SESSION["cantCarpetasGen"]['Solicitud Transferencia'][1] : $contExp;
    $_SESSION["cantCarpetasGen"]['Solicitud Transferencia'][1] = $contExp;
    $hayCambiosCarpetaArchivo = ($hayCambiosCarpetaArchivo) ? $hayCambiosCarpetaArchivo : $contExp > $_SESSION["cantCarpetasGen"]['Solicitud Transferencia'][0];
    $totalArchivo = $contExp;
    $divArchivo = "@A<span class='Estilo12'><a href='archivo/archivo.php?krd=$krd' target='mainFrame' class='menu_princ'><b>Archivo($totalArchivo)</a>";
}

if ($_SESSION['habilita_alertas']) {
    if ($hayCambiosCarpetas or $hayCambiosCarpetaArchivo or $hayCambiosCarpetaPrestamo)
        $menuCarpetas .=$divPrestamo . $divArchivo . "1";
    else
        $menuCarpetas .=$divPrestamo . $divArchivo . '0';
}
else {
    $menuCarpetas .=$divPrestamo . $divArchivo . '0';
}
echo $menuCarpetas;
?>