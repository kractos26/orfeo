<?php
session_start();
$ruta_raiz = "..";
if(!isset($_SESSION['dependencia']))	include "$ruta_raiz/rec_session.php";

$anoActual = date("Y");
$ano_ini = date("Y");
$mes_ini = substr("00".(date("m")-1),-2);
if ($mes_ini==1) {$ano_ini=$ano_ini-1; $mes_ini="12";}
$dia_ini = date("d");
$ano_ini = date("Y");
if(!$fecha_ini) $fecha_ini = "$ano_ini/$mes_ini/$dia_ini";
$fecha_fin = date("Y/m/d") ;
$where_fecha="";
//error_reporting(7);
?>
<html>
<head>
<title>Orfeo. Devolucion de Correspondencia</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF" topmargin="0" onLoad="window_onload();">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="js/spiffyCal/spiffyCal_v2_1.css">
<?php
$ruta_raiz = "..";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug = true;
include_once "$ruta_raiz/include/query/busqueda/busquedaPiloto1.php";
if(!$estado_sal)   {$estado_sal=2;}
if(!$estado_sal_max) $estado_sal_max=3;
if($estado_sal==4)
{
	if($devolucion==1)
	{
		$accion_sal = "Devoluci&oacute;n de Documentos";
		$pagina_sig = "dev_corresp_otras.php";
		$dev_documentos = "";
		$nomcarpeta="Devolucion de Documentos";
	}
	if(!$dep_sel) $dep_sel = $dependencia;
}
if($busq_radicados)
{
	$busq_radicados = trim($busq_radicados);
	$textElements = split (",", $busq_radicados);
	$newText = "";
	$i = 0;
	foreach ($textElements as $item)
	{
		$item = trim ( $item );
		if ( strlen ( $item ) != 0 )
		{
		   $i++;
		   //if ($i != 1) $busq_and = " and "; else $busq_and = " ";
		   $busq_radicados_tmp .= " and $busq_and $radi_nume_sal like '%$item%' ";
		  }
     }
	 $dependencia_busq1 .= " $busq_radicados_tmp ";
	 if(!$dep_sel) $dep_sel = $dependencia;
}else
{
   $sql_masiva = " and a.sgd_renv_planilla != '' ";
   $sql_masiva = "";
}

$tbbordes = "#CEDFC6";
$tbfondo = "#FFFFCC";
if(!$orno){$orno=1;}
$imagen="flechadesc.gif";

switch($db->driver){
    case 'mssql':
        $varBuscada = "convert(char(14),radi_nume_salida)";
        break;
    case 'postgres':
        $varBuscada = "cast(radi_nume_salida as varchar(14))";
        break;
    case 'oci8po':
    case 'oci8':
        $varBuscada = "radi_nume_salida";
        break;
}
$encabezado = "".session_name()."=".session_id()."&krd=$krd&filtroSelect=$filtroSelect&accion_sal=$accion_sal&dependencia=$dependencia&tpAnulacion=$tpAnulacion&orderNo=";
$linkPagina = "$PHP_SELF?$encabezado&accion_sal=$accion_sal&orderTipo=$orderTipo&orderNo=$orderNo";

$swBusqDep = "si";
$pagina_actual = "../devolucion/cuerpoDevOtras.php";
$carpeta = "xx";
include "../envios/paEncabeza.php";
include "../envios/paBuscar.php";
$accion_sal = "Devoluci&oacute;n de Documentos";
$pagina_sig = "../devolucion/dev_corresp_otras.php";
include "../envios/paOpciones.php";
if($busq_radicados_tmp)
{
	$where_fecha=" ";
}
else
{
    $fecha_ini = mktime(00,00,00,substr($fecha_ini,5,2),substr($fecha_ini,8,2),substr($fecha_ini,0,4));
	$fecha_fin = mktime(23,59,59,substr($fecha_fin,5,2),substr($fecha_fin,8,2),substr($fecha_fin,0,4));
    $where_fecha = " (a.SGD_RENV_FECH >= ". $db->conn->DBTimeStamp($fecha_ini) ." and a.SGD_RENV_FECH <= ". $db->conn->DBTimeStamp($fecha_fin).") " ;
    $dependencia_busq1 .= " and $where_fecha  ";
}
/*  GENERACION LISTADO DE RADICADOS
 *  Aqui utilizamos la clase adodb para generar el listado de los radicados
 *  Esta clase cuenta con una adaptacion a las clases utiilzadas de orfeo.
 *  el archivo original es adodb-pager.inc.php la modificada es adodb-paginacion.inc.php
 */
error_reporting(7);
if ($orderNo==98 or $orderNo==99)
{
	$order=1;
	if ($orderNo==98)   $orderTipo=" desc";
	if ($orderNo==99)   $orderTipo="";
}
else
{
	if (!$orderNo)  $orderNo=4;
	$order = $orderNo + 1;
	if($orden_cambio==1)
	{
		(!$orderTipo) ? $orderTipo=" desc" : $orderTipo="";
	}
}
$sqlChar = $db->conn->SQLDate("d-m-Y H:i A","SGD_RENV_FECH");
$valor    = "(a.sgd_renv_cantidad * a.sgd_renv_valor)";
include "$ruta_raiz/include/query/devolucion/querycuerpoDevOtras.php";
?>
<form name=formEnviar action='../devolucion/dev_corresp_otras.php?<?=session_name()."=".session_id()."&krd=$krd" ?>&estado_sal=<?=$estado_sal?>&estado_sal_max=<?=$estado_sal_max?>&pagina_sig=<?=$pagina_sig?>&dep_sel=<?=$dep_sel?>&nomcarpeta=<?=$nomcarpeta?>&orderNo=<?=$orderNo?>' method=post>
<?php
$encabezado = "".session_name()."=".session_id()."&krd=$krd&estado_sal=$estado_sal&estado_sal_max=$estado_sal_max&accion_sal=$accion_sal&dependencia_busq2=$dependencia_busq2&dep_sel=$dep_sel&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&nomcarpeta=$nomcarpeta&orderTipo=$orderTipo&orderNo=";
$linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";

$db->conn->debug = false;
$pager = new ADODB_Pager($db,$isql,'adodb', true,$orderNo,$orderTipo);
$pager->checkAll = false;
$pager->checkTitulo = true;
$pager->toRefLinks = $linkPagina;
$pager->toRefVars = $encabezado;
$pager->Render($rows_per_page=20,$linkPagina,$checkbox=chkEnviar);
?>
</form>
</body>
</html>