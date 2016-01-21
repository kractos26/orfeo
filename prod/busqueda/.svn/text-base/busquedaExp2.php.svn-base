<?php
/**
 *				//// O J O	\\\\\
 * 				\\\\		/////
 * 
 Este módulo de consulta fue codificada su lógica. En las entidades
 donde la búsqueda duplique, triplique, etc el mismo registro se debe
 ejecutar las siguientes sentencias: 
 
UPDATE SGD_DIR_DRECCIONES SET sgd_oem_codigo=null WHERE sgd_oem_codigo=0;
UPDATE SGD_DIR_DRECCIONES SET sgd_ciu_codigo=null WHERE sgd_ciu_codigo=0;
UPDATE SGD_DIR_DRECCIONES SET sgd_esp_codi=null WHERE sgd_esp_codi=0;
UPDATE SGD_DIR_DRECCIONES SET sgd_doc_fun=null WHERE sgd_doc_fun=0;
 */


session_start();
$verrad = "";
$ruta_raiz = "..";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");	

if (!$_SESSION['dependencia'])   include "$ruta_raiz/rec_session.php"; 

//Creamos la columna por el cual ORDENAR los resutado
if($orden_cambio==1)
	(!$orderTipo) ? $orderTipo="desc" : $orderTipo="";
	
if(!$orderNo)  
{
	$orderNo="0";
	$order = 1;
}else
{
	$order = $orderNo +1;
}

if(!isset($fecha_ini)) $fecha_ini = date("Y/m/d");	 
if(!isset($fecha_fin)) $fecha_fin = date("Y/m/d");	

$encabezado1 = "$PHP_SELF?".session_name()."=".session_id()."&krd=$krd";
$linkPagina = "$encabezado1&nume_expe=$nume_expe&nomb_expe=$nomb_expe&fecha_ini=$fecha_ini&fecha_fin=$fecha_fin&dependenciaSel=$dependenciaSel&orderTipo=$orderTipo&orderNo=$orderNo";
$encabezado = "".session_name()."=".session_id()."&krd=$krd&nume_expe=$nume_expe&nomb_expe=$nomb_expe&fecha_ini=$fecha_ini&fecha_fin=$fecha_fin&dependenciaSel=$dependenciaSel&orderTipo=$orderTipo&orderNo=";
$nombreSesion = "".session_name()."=".session_id();
  
/* Se recibe el numero del Expediente a Buscar */
if($nume_expe or $adodb_next_page or $orderNo or $orderTipo or $orden_cambio or $dependenciaSel )
{
	//Se valida rango de fechas
	$sqlFecha = $db->conn->SQLDate('Y/m/d',"SGD_SEXP_FECH"); 
	$where_general = " WHERE ".$sqlFecha . " BETWEEN '$fecha_ini' AND '$fecha_fin'" ;
	
	/* Se recibe la dependencia para bsqueda */
	if ($dependenciaSel == "99999")
		$where_general .= " AND DEPE_CODI IS NOT NULL ";
	else
		$where_general .= " AND DEPE_CODI = ".$dependenciaSel;	
	
	// Se valida el codigo expediente
	if ($nume_expe) $where_general .= " AND SGD_EXP_NUMERO LIKE '%$nume_expe%' ";
	
	// Se valida el nombre expediente
	if ($nomb_expe) $where_general .= " AND SGD_SEXP_NOMBRE LIKE '%$nomb_expe%' ";
	
	/* Busqueda por nivel y usuario
	$where_general .= " AND R.CODI_NIVEL <= ".$nivelus; 
	*/
	include($ruta_raiz."/include/query/busqueda/busquedaPiloto1.php");	
	
	$c_order = " ORDER BY $order ";
	$c_order .= (!$orderTipo) ? "asc" : "desc";

	$sql = "SELECT SGD_EXP_NUMERO as CODIGO, SGD_SEXP_NOMBRE as NOMBRE, SGD_SRD_DESCRIP as SERIE, SGD_SBRD_DESCRIP as SUBSERIE, SGD_SEXP_FECH as FECHA_CREACION 
			FROM SGD_SEXP_SECEXPEDIENTES E LEFT JOIN SGD_SRD_SERIESRD S ON E.SGD_SRD_CODIGO = S.SGD_SRD_CODIGO
				LEFT JOIN SGD_SBRD_SUBSERIERD X ON E.SGD_SBRD_CODIGO = X.SGD_SBRD_CODIGO AND E.SGD_SRD_CODIGO = X.SGD_SRD_CODIGO ";
	$sql .= $where_general . $c_order;

	//echo ($sql);
	$ADODB_COUNTRECS = true;
	$rs = $db->conn->Execute($sql);
	if ($rs)
	{
		$nregis = $rs->recordcount();
		$fldTotal = $nregis;
	}
	else
		$fldTotal = 0;
	$ADODB_COUNTRECS = false;
     
    $pager = new ADODB_Pager($db,$sql,'adodb', true,$orderNo,$orderTipo);
	$pager->checkAll = false;
	$pager->checkTitulo = true; 	
	$pager->toRefLinks = $linkPagina;
	$pager->toRefVars = $encabezado;
}

$sql = "SELECT DEPE_NOMB, DEPE_CODI FROM DEPENDENCIA where depe_estado=1 ORDER BY 1";
$rs = $db->conn->execute($sql);
$cmb_dep = $rs->GetMenu2('dependenciaSel', $dependenciaSel, $blank1stItem = "99999:Todas las Dependencias",false,0,'class=select');
?>
<html>
<head>
<title>Consultas</title>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="cache-control" content="no-cache">
<link rel="stylesheet" href="Site.css" type="text/css">
<link rel="stylesheet" href="../estilos/orfeo.css">
<script>
function limpiar()
{
	document.Search.elements['nume_expe'].value = "";
	document.Search.elements['dependenciaSel'].value = "99999";
}
</script>
</head>
<body class="PageBODY">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript"><!--
var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "Search", "fecha_ini","btnDate1","<?=$fecha_ini?>",scBTNMODE_CUSTOMBLUE);
var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "Search", "fecha_fin","btnDate2","<?=$fecha_fin?>",scBTNMODE_CUSTOMBLUE);
//-->
</script>
<form  name="Search"  action='<?=$_SERVER['PHP_SELF']?>?<?=$encabezado?>' method=post>
<table>
<tbody>
<tr>
	<td valign="top">
		<input type="hidden" name="FormName" value="Search"><input type="hidden" name="FormAction" value="search">
		<table border=0 cellpadding=0 cellspacing=2 class='borde_tab'>
		<tbody>
		<tr>
			<td class="titulos4" colspan="13"><a name="Search">B&uacute;squeda de Expedientes</a></td>
		</tr>
		<tr>
			<td class="titulos5">Expediente</td>
			<td class="listado5">
				<input class="tex_area" type="text" name="nume_expe" maxlength="" value="<?=$nume_expe?>" size="" >
			</td>
		</tr>
		<tr> 
			<td class="titulos5">Nombre</td>
			<td class="listado5">
				<input type="text" name="nomb_expe" id="nomb_expe" value="<?php echo $nomb_expe;?>"></input>
			</td>
		</tr>
		<tr>
			<td class="titulos5">Desde Fecha (yyyy/mm/dd)</td>
			<td class="listado5">
				<script language="javascript">
					dateAvailable.writeControl();
					dateAvailable.dateFormat="yyyy/MM/dd";
				</script>
			</td>
		</tr>
		<tr>
			<td class="titulos5">Hasta Fecha (yyyy/mm/dd)</td>
			<td class="listado5">
				<script language="javascript">
					dateAvailable1.writeControl();
					dateAvailable1.dateFormat="yyyy/MM/dd";
				</script>
			</td>
		</tr>
		<tr> 
			<td class="titulos5">Dependencia Generadora</td>
			<td class="listado5">
				<?php echo $cmb_dep; ?>
			</td>
		</tr>
		<tr> 
			<td colspan="3" align="right">
				<input class="botones" value="Limpiar" onclick="limpiar();" type="button">
				<input name="buscar" class="botones" value="Buscar" type="submit">
			</td>
		</tr>
		</tbody> 
		</table>
	</td>
	<td valign="top">
		<a class="vinculos" href="../busqueda/busquedaHist.php?<?=$phpsession ?>&krd=<?=$krd?>&<? ECHO "&fechah=$fechah&primera=1&ent=2"; ?>">B&uacute;squeda por Hist&oacute;rico</a><br>	
		<a class="vinculos" href="../busqueda/busquedaPiloto.php?<?=$phpsession ?>&krd=<?=$krd?>&<? ECHO "&fechah=$fechah&primera=1&ent=2&s_Listado=VerListado"; ?>">B&uacute;squeda Cl&aacute;sica</a><br>
		<a class="vinculos" href="../busqueda/busquedaUsuActu.php?<?=$phpsession ?>&krd=<?=$krd?>&<? ECHO "&fechah=$fechah&primera=1&ent=2"; ?>">B&uacute;squeda por Usuarios</a>
	</td>
</tr>
</tbody>
</table>
<?php
if($nume_expe or $adodb_next_page or $orderNo or $orderTipo or $orden_cambio or $dependenciaSel )
{
?>
<table>
<tbody>
<tr>
	<td valign="top">
		<table width="100%"" class="FormTABLE">
		<tbody>
		<tr>
			<td colspan="5" class="info"><b>Total Registros Encontrados: <?=$fldTotal?></b></td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td>
<?php
	$pager->Render($rows_per_page=20,$linkPagina,$checkbox=chkAnulados);
?>
	</td>
</tr>
</tbody>
</table>
<?php
}
?>
</form>
</body>
</html>