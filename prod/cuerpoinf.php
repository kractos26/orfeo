<?php
error_reporting(0);
$krdOld = $krd;
$carpetaOld = $carpeta;
$tipoCarpOld = $tipo_carp;
session_start();
if(!$krd) $krd=$krdOsld;
$ruta_raiz = ".";
if (!isset($_SESSION['dependencia']))	include "./rec_session.php";
$ADODB_COUNTRECS = false;
require_once("$ruta_raiz/include/db/ConnectionHandler.php");
require_once("$ruta_raiz/include/combos.php");
if(!$carpeta) $carpeta = $carpetaOld;
$ADODB_COUNTRECS = false;
error_reporting(7);
$db = new ConnectionHandler($ruta_raiz);
//$db->conn->debug = true;
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
include_once "./include/query/busqueda/busquedaPiloto1.php";
// Procedimiento para filtro de radicados....
if($busq_radicados)
{
	$busq_radicados = trim($busq_radicados);
	$textElements = split (",", $busq_radicados);
	$newText = "";
	$dep_sel = $dependencia;
	foreach ($textElements as $item)
	{	$item = trim ( $item );
		if ( strlen ( $item ) != 0)
		{	if(strlen($item)<=6)
			{	$sec = str_pad($item,6,"0",STR_PAD_left);
				//$item = date("Y") . $dep_sel . $sec;
			}
			else
			{}
			$busq_radicados_tmp .= " $radi_nume_radi like '%$item%' or";
		}
	}
	if(substr($busq_radicados_tmp,-2)=="or")   $busq_radicados_tmp = substr($busq_radicados_tmp,0,strlen($busq_radicados_tmp)-2);
	if(trim($busq_radicados_tmp))  $where_filtro .= "and ( $busq_radicados_tmp ) ";
}
?>
<html><head><title>.: Modulo total :.</title>
<link rel="stylesheet" href="estilos/orfeo.css">
<style type="text/css">
<!--
.textoOpcion {  font-family: Arial, Helvetica, sans-serif; font-size: 8pt; color: #000000; text-decoration: underline}
-->
</style>
<!-- seleccionar todos los checkboxes-->
<script>
function window_onload()
{
   document.getElementById('depsel8').style.display = 'none';
}

function markAll()
{
	if(document.form1.elements['checkAll'].checked)
		for(i=10;i<document.form1.elements.length;i++)
			document.form1.elements[i].checked=1;
	else
		for(i=10;i<document.form1.elements.length;i++)
			document.form1.elements[i].checked=0;
}

function changedepesel()
{
 	if(document.getElementById('enviara').value==7){
		document.getElementById('depsel8').style.display = 'none';
		document.form1.cambioInf.value = 'B';
 	} else {
		document.getElementById('depsel8').style.display = '';
		document.form1.cambioInf.value = 'I';
	}
}

function enviar()
{
document.form1.codTx.value = document.getElementById('enviara').value;
sw = 0;
cnt_notinf = 0;
cnt_inf = 0;
for(i=3;i<document.form1.elements.length;i++)
	if (document.form1.elements[i].checked)
	{	sw=1;
		if (document.form1.elements[i].name[11] == '0')	cnt_notinf += 1;
		else	cnt_inf += 1;
	}
if (sw==0)
{	alert ("Debe seleccionar uno o mas informados");
	return;
}
if (cnt_inf > 0 && cnt_notinf > 0 && document.getElementById('enviara').value == 7)
{	alert ("Los informados seleccionados ... o todos tienen informador o no tienen informador.");
	return;
}
document.form1.submit();
}
</script>
<?php
$tbbordes = "#CEDFC6";
$tbfondo = "#FFFFCC";
$imagen="flechadesc.gif";
?>
<SCRIPT>
<?
	include "libjs.php";
?>
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" topmargin="0" onLoad="setupDescriptions();window_onload();">
<p>
<?php
$krd=strtoupper($krd);
$check=1;
$numeroa=0;$numero=0;$numeros=0;$numerot=0;$numerop=0;$numeroh=0;
$fechaf=date("dmy") . time("hms");
$fechah=date("dmy") . time("hms");
$encabezado="".session_name()."=".session_id()."&krd=$krd&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta";

?>
<table border=0 width=100% class="t_bordeGris">
<tr>
	<td>
		<!-- Inicia tabla de cabezote -->
		<table BORDER=0  cellpad=2 cellspacing='0' WIDTH=98% class='t_bordeGris' valign='top' align='center' >
		<TR>
			<td width='33%' >
      			<table width='100%' border='0' cellspacing='1' cellpadding='0'>
      			<tr>
      				<td height="20" bgcolor="377584"><div align="left" class="titulo1">LISTADO DE: </div></td>
      			</tr>
      			<tr class="info">
      				<td height="20">Informados</td>
      			</tr>
      			</table>
      		</td>
			<td width='33%' >
      			<table width='100%' border='0' cellspacing='1' cellpadding='0'>
      			<tr>
      				<td height="20" bgcolor="377584"><div align="left" class="titulo1">USUARIO </div></td>
      			</tr>
      			<tr class="info">
      				<td height="20"><?=$_SESSION['usua_nomb'] ?></td>
      			</tr>
      			</table>
      		</td>
      		<td width='34%' >
      			<table width='100%' border='0' cellspacing='1' cellpadding='0'>
      			<tr>
      				<td height="20" bgcolor="377584"><div align="left" class="titulo1">DEPENDENCIA </div></td>
      			</tr>
      			<tr class="info">
      				<td height="20"><?=$_SESSION['depe_nomb'] ?></td>
      			</tr>
      			</table>
      		</td>
      	</TR>
		</table>
		<TABLE width="98%" align="center" cellspacing="0" cellpadding="0">
		<tr class="tablas">
			<TD>
			<FORM name=form_busq_rad action='cuerpoinf.php?krd=<?=$krd?>&<?=session_name()."=".trim(session_id()).$encabezado?>' method=post>
				Buscar radicado(s) informado(s) (Separados por coma)<input name="busq_radicados" type="text" size="70" class="tex_area" value="<?=$busq_radicados?>">
				<input type=submit value='Buscar ' name=Buscar valign='middle' class='botones' onChange="form_busq_rad.submit()";>
			</FORM>
			</td>
		</tr>
 		</table>
		<form name='form1' action='tx/formEnvio.php' method='post'>
		<input name="cambioInf" value="I" type="hidden">
		<br>
		<!-- Finaliza tabla de cabezote --> <!-- Inicia tabla de datos -->
		<?
		$imagen="img_flecha_sort.gif";
		$row = array();
		echo "<input type=hidden name=contra value=$drde> ";
		echo "<input type=hidden name=sesion value=".md5($krd)."> ";
		echo "<input type=hidden name=krd value=$krd>";
		echo "<input type=hidden name=drde value=$drde>";
		echo "<input type=hidden name=carpeta value=$carpeta>";
		?>
		<table width="98%" align="center" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td colspan="2" height="80">
				<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" class="borde_tab">
				<tr>
					<td width="50%"  class="titulos2">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
						<tr class="titulos2">
							<td width="20%" class="titulos2">LISTAR POR:</td>
							<td height="30">
								<a href='cuerpoinf.php?<? echo "$encabezado&orderNo=9&orderTipo=desc"; ?>' alt='Ordenar Por Leidos'><span class='leidos'>Le&iacute;dos</span></a>&nbsp;
								<?=$img7 ?>
								<a href='cuerpoinf.php?<? echo "$encabezado&orderNo=9&orderTipo=asc"; ?>' alt='Ordenar Por Leidos'><span class='no_leidos'>No Le&iacute;dos</span></a>
							</td>
						</tr>
						</table>
					</td>
					<td width="50%" align=right class="titulos2" ><BR>
<?
$ADODB_COUNTRECS = true;
$isql="select depe_codi,depe_nomb from DEPENDENCIA ORDER BY DEPE_NOMB";
$rs = $db->query($isql);
$ADODB_COUNTRECS = false;
$numerot=$rs->RecordCount();
?>
					<span class='etitulos'><b>
						<select name='enviara' id='enviara' class='select'  language='javascript' onchange=changedepesel()>
						<option value=7>Borrar Documento informado</option>
						<option value=8>Informar (Enviar copia de documentos)</option>
						</select><br>
						<select name='depsel8[]' id='depsel8' class='select' multiple size="5">
<?
include "$ruta_raiz/include/query/queryCuerpoinf.php";
$a = new combo($db);
$concatSQL=$db->conn->concat($concatenar,"' '","depe_nomb");
$s = "SELECT DEPE_CODI,$concatSQL as NOMBRE  from dependencia order by depe_nomb asc ";
$r = "DEPE_CODI";
$t = "NOMBRE";
$v = $dependencia;
$sim = 0;
$a->conectar($s,$r,$t,$v,$sim,$sim);
?>
						</select>
						<BR>
						<input type=button value="REALIZAR" name=Enviar valign="middle" class="botones" onClick="enviar();">
						<input type=hidden name=codTx>
					</td>
				</tr>
				<tr>
					<td  colspan="2">
<?
$iusuario = " and us_usuario='$krd'";
$sqlFecha = $db->conn->SQLDate("Y-m-d H:i A","r.RADI_FECH_RADI");
$systemDate = $db->conn->sysTimeStamp;

$sqlOffset = $db->conn->OffsetDate("b.sgd_tpr_termino","radi_fech_radi");
$concatSQL=$db->conn->Concat("r.RADI_NOMB","' '","r.RADI_PRIM_APEL","' '","r.RADI_SEGU_APEL");
if(strlen($orderNo)==0)
{
	$orderNo='0';
	$order = 1;
}
else
	$order = $orderNo +1;

if($orden_cambio==1)
{	if(trim( strtoupper($orderTipo))!="DESC")
		$orderTipo="DESC";
	else
	   $orderTipo="ASC";
}

include "$ruta_raiz/include/query/queryCuerpoinf.php";
$linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";
$encabezado .= "&adodb_next_page=1&orderTipo=$orderTipo&orderNo=";

if($chk_carpeta) $chk_value=" checked "; else  $chk_value=" ";
$pager = new ADODB_Pager($db,$isql,'adodb', true,$orderNo,$orderTipo);
$pager->toRefLinks = $linkPagina;
$pager->toRefVars = $encabezado;
$pager->checkAll = false;
$pager->checkTitulo = true;
$pager->Render($rows_per_page=20,$linkPagina,$checkbox=checkValue);
?>
					</td>
				</tr>
		</table>
		</form>
	</td>
</tr>
</table>
</body>
</html>
