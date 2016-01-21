<html>
<head>
<TITLE>SUPERSERVICIOS - CONSULTA WEB - ORFEO</TITLE>
<script>
function loginTrue()
{
	document.formulario.submit();
}
</script>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<BODY >
<table  class=borde_tab cellspacing="5" width=100%>
<tr><td class=titulos5 align="center">INFORMACION DE FACTURACION - INTEGRACION ORFEO-SUI</td></TR>
</table>
<TABLE><TR><TD></TD></TR></TABLE>
<center>
<TABLE>
<?php
error_reporting(0);
define('ADODB_ASSOC_CASE', 1);
/** FORMULARIO DE LOGIN A ORFEO
  * Aqui se inicia session 
	* @PHPSESID		String	Guarda la session del usuario
	* @db 					Objeto  Objeto que guarda la conexion Abierta.
	* @iTpRad				int		Numero de tipos de Radicacion
	* @$tpNumRad	array 	Arreglo que almacena los numeros de tipos de radicacion Existentes
	* @$tpDescRad	array 	Arreglo que almacena la descripcion de tipos de radicacion Existentes
	* @$tpImgRad	array 	Arreglo que almacena los iconos de tipos de radicacion Existentes
	* @query				String	Consulta SQL a ejecutar
	* @rs					Objeto	Almacena Cursor con Consulta realizada.
	* @numRegs		int		Numero de registros de una consulta
	*/
$ruta_raiz = "..";
error_reporting(7);
include_once "$ruta_raiz/include/db/ConnectionHandlerSUI.php";
$db = new ConnectionHandlerSUI($ruta_raiz);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
//$db->conn->debug = true;
$fechah = date("dmy") . "_" . time("hms");
$usua_nuevo=3;
	$numeroRadicado = str_replace("-","",$numeroRadicado);
	$numeroRadicado = str_replace("_","",$numeroRadicado);
	$numeroRadicado = str_replace(".","",$numeroRadicado);
	$numeroRadicado = str_replace(",","",$numeroRadicado);
	$numeroRadicado = str_replace(" ","",$numeroRadicado);
/*
$cuentai="5657119";
$espCodi="3322";
$deptoCodi =11;
$muniCodi = 1; */
$perAnos = "(".date("Y").",".(date("Y")-1).",".(date("Y")-2).",".(date("Y")-3).")";
$isqlFac =
"select rs.are_esp_nombre ESP_NOMBRE,
ca.car_carg_ano agno,
ca.car_carg_periodo periodo,dn.nombre_del_departamento DEPTO_NOMBRE, mn.nombre_del_municipio MUNI_NOMBRE,
t.car_T218_SECUE a1,
t.car_T218_FaCTURa NUMERO_FACTURA,
t.car_T218_NROTEL NUMERO_TELEFONO,
ca.car_carg_periodo PERIODO,
t.car_T218_VLRFaCTURa  VALOR_FACTURA,
t.car_T218_VLRFaCTaNT a53,
t.car_T218_VLRENMORa  AS VALOR_MORA,
t.car_T218_TaSaMORa a55,
t.car_T218_INTERESMORa a56,
t.car_T218_IVaFaC a57,
t.car_T218_IMPUESTOS a58,
t.car_carG_SECUE a59,
t.car_aRCH_SECUE a60,
t.IDENTIFICaDOR_EMPRESa a61,
t.car_T218_aNO PANO,
t.car_T218_MES a63
from carg_tele.car_t218_218 t,carg_arch.car_carg_cargues ca,
renaser.departamentos_dane dn,
renaser.municipios_dane mn,
renaser.are_esp_empresas rs
where
t.car_t218_nrotel =  $cuentai and
ca.car_carg_ano in $perAnos and
(ca.car_carg_periodo between 1 and 12) and
ca.identificador_empresa=$espCodi and
dn.codigo_del_departamento=$deptoCodi and
mn.codigo_del_municipio=$muniCodi and
ca.car_carg_secue=t.car_carg_secue
and ca.identificador_empresa = rs.are_esp_secue
and substr(t.codigo_dane,1,2) = dn.codigo_del_departamento
and substr(t.codigo_dane,3,3) = mn.codigo_del_municipio
and dn.codigo_del_departamento = mn.codigo_del_departamento
order by  ca.car_carg_ano,ca.car_carg_periodo";
$rs = $db->conn->query($isqlFac);
$espNombre = $rs->fields["ESP_NOMBRE"];
$numeroTelefono = $rs->fields["NUMERO_TELEFONO"];
$muniNombre = $rs->fields["MUNI_NOMBRE"];
$deptoNombre = $rs->fields["DEPTO_NOMBRE"];
?>
<table  class=borde_tab cellspacing="5" width=100%>
<TR class=titulos5><td>Empresa</td><TD class=listado2><?=$espNombre?></TD></TR>
<TR class=titulos5><td>Cuenta Interna(Telefono)</td><TD class=listado2><?=$numeroTelefono?></TD></TR>
<TR class=titulos5><td>Municipio/Departamento</td><TD class=listado2><?=$muniNombre." / ".$deptoNombre?></TD></TR>
</table>
<table><TR><TD></TD></TR></table>
<table  class=borde_tab cellspacing="2" width=80%>
<TR class=titulos5><td>PERIODO</td><td>A?O</td><TD>NUMERO DE FACTURA</TD><TD>VALOR FACTURA</TD><TD>VALOR EN MORA</TD></TR>
<?

while(!$rs->EOF)
{
	
	
	$valorFactura = $rs->fields["VALOR_FACTURA"];
	$numeroFactura = $rs->fields["NUMERO_FACTURA"];
	$valorMora = $rs->fields["VALOR_MORA"];
	$periodo = $rs->fields["PERIODO"];
	$periodoAno = $rs->fields["PANO"];
	?>
	<TR class=listado5>
	<td align="CENTER"><?=$periodo?></td><td align="center"><?=$periodoAno?></td><TD><?=$numeroFactura?></TD>
	<TD align="right"><?=number_format($valorFactura, 2, ',', ' ')?></TD>
	<TD align="right"><?=number_format($valorMora, 2, ',', ' ')?></TD></TR>
	<?
	$data1y[]=$valorFactura;
	$nombUs[]=$periodo . "/" . $periodoAno;
	$rs->MoveNext();

}
?>
</TR></table>

<?
error_reporting(0);
//$nombUs[1] = "JHLC";
//$nombUs = array("ddd","kuiyiuiu","kjop99");
//$data1y = array(11,23,45);
//$nombUs = array("ddd","kuiyiuiu","kjop99");
//$data1y = array(11,23,45);
$ruta_raiz="..";
$nombreGraficaTmp = "$ruta_raiz/bodega/tmp/E_$cuentai.png";
$rutaImagen = $nombreGraficaTmp;
$notaSubtitulo = $subtituloE[$tipoEstadistica]."\n";
$tituloGraph = $tituloE[$tipoEstadistica];
?>
<br><center><span class="listado5">
</span>
<?
$_SESSION["data1y"] = $data1y;
$_SESSION["nombUs"] = $nombUs;
include "../estadisticas/genBarras1.php";
?>
	 <br><input type=button class="botones_largo" value="Ver Grafica" onClick='window.open("../estadisticas/image.php?rutaImagen=<?=$rutaImagen."&fechaH=".date("YmdHis")?>" , "Grafica Estadisticas - Orfeo", "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=660,height=720");'>

<table><TR><TD></TD></TR></table>
<table  class=borde_tab cellspacing="5" width=100%>
<tr><td class=titulos5 align="center">DATOS TOMADOS DEL SUI <a href="http://www.sui.gov.co" target="suigovco">www.sui.gov.co</a></td></TR>
</table>
<?
// t.car_t218_factura = '{@tel_com_079.factura}' and
?>