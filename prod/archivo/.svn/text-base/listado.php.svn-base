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
//	$db->conn->debug=true;
if (!$depen or intval($depen) == 0) die ("<table class=borde_tab width='100%'><tr><td class=titulosError><center>Debe seleccionar una dependencia</center></td></tr></table>");
if($generar)
{
   	error_reporting(7);
	$ruta_raiz = "..";
	
   	if (!defined('ADODB_FETCH_NUM'))	define('ADODB_FETCH_NUM',1);
	$ADODB_FETCH_MODE = ADODB_FETCH_NUM; 
	
	$fecha_ini = $fecha_busq;
        $fecha_fin = $fecha_busq;
	$fecha_ini = mktime($hora_ini,$minutos_ini,00,substr($fecha_ini,5,2),substr($fecha_ini,8,2),substr($fecha_ini,0,4));
	$fecha_fin = mktime($hora_fin,$minutos_fin,59,substr($fecha_fin,5,2),substr($fecha_fin,8,2),substr($fecha_fin,0,4));
	//$db->conn->debug = 	true;
	
	$fecha_ini1 = "$fecha_busq $hora_ini:$minutos_ini:00";
	$fecha_mes = "'" . substr($fecha_ini1,0,7) . "'";
	$sqlChar = $db->conn->SQLDate("Y-m","SGD_ARCHIVO_FECH");	

// Si la variable $generar_listado_existente viene entonces este if genera la planilla existente
	$order_isql = " ORDER BY SGD_ARCHIVO_CAJA";
	include "oracle_pdf1.php";
	$pdf = new PDF('L','pt','legal');
	$pdf->lmargin = 0.2;
	$pdf->SetFont('helvetica','',8);
	$pdf->AliasNbPages();
	switch($srd){
	case '1':
		$titu2="TITULO";
		$titu3="NRO CONSECUTIVO";
		break;
	case '2':
		$titu2="QUERELLADO";
		$titu3="QUERELLANTE";
		break;
	case '3':
		$titu2="CONTRATISTA";
		$titu3="OBJETO CONTRACTUAL";
		break;
	default:
		$titu2="TITULO";
		$titu3="REMITENTE";
		break;
}
	$head_table = array ("RADICADO","SERIE","TIPO",$titu2,$titu3,"PERIODO","FOLIOS","CAJA");
	$head_table_size = array (70   ,60,170,214,214,70,60 ,40 );
	$attr=array('titleFontSize'=>10,'titleText'=>'');
	//$arpdf_tmp = "../bodega/pdfs/planillas/$dependencia_". date("Ymd_hms") . "_jhlc.pdf"; Comentariada Por HLP.
	$arpdf_tmp = "../bodega/pdfs/reportes/".$dependencia."_".date("Ymd_hms")."_arch.pdf";
	$pdf->SetFont('helvetica','',8);
	$pdf->usuario = $usua_nomb;
	$pdf->dependencia = $dependencianomb;
	$pdf->entidad_largo = $db->entidad_largo;
	$total_registros = 0;
	$pdf->lmargin = 0.2;
	$i_total3 = 0;
	/*
	do
	{  // Amplia
		include "$ruta_raiz/include/query/archivo/queryListado.php";	
		$query_t = $query . $where_isql1 . $order_isql;
	$pdf->oracle_report($db,$query_t,false,$attr,$head_table,$head_table_size,$arpdf_tmp,0,31);
	
	if ($i_total3 == 0)  {
		echo $i_total3 = $pdf->numrows;
		echo"n";
		$total_registros += $i_total3;
	}
	$i_total3 = $i_total3 - 32 ;
	}while ($i_total3>0);
	*/
	include "$ruta_raiz/include/query/archivo/queryListado.php";	
		$query_t = $query . $where_isql1 . $order_isql;
		//$db->conn->debug=true;
	$rsc=$db->conn->Execute("SELECT count(*) AS CO FROM ( ".$query_t." )");
	$numf=$rsc->fields[0];
	$pdf->oracle_report($db,$query_t,false,$attr,$head_table,$head_table_size,$arpdf_tmp,0,$numf);
	$total_registros = $pdf->numrows;
	$pdf->Output($arpdf_tmp);
}
?>
		<TABLE BORDER=0 WIDTH=100% class="borde_tab">
		<TR><TD class="listado2"  align="center"><center>
Se han Generado <b><?=$total_registros?> </b> <br>
<a href='<?=$arpdf_tmp?>' target='<?=date("dmYh").time("his")?>'>Abrir Archivo PDF</a></center>
</td>
</TR>
</TABLE>
</body>