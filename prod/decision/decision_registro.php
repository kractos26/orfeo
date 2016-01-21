<?
$verradOld=$verrad;
session_start();

if (!$ruta_raiz) $ruta_raiz = "..";

require_once("$ruta_raiz/include/db/ConnectionHandler.php");
require_once("$ruta_raiz/class_control/TipoDecision.php");


if (!$db)
		$db = new ConnectionHandler($ruta_raiz);
$db->conn->BeginTrans();

$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);	

if (!$krd or !$dependencia)   include "$ruta_raiz/rec_session.php";
$verrad =$verradOld;

$objTipDec = new TipoDecision($db);
?>
<html>
<head>
<title>Enviar Datos</title>

</head>
<link rel="stylesheet" href="<?=$ruta_raiz?>/estilos/orfeo.css">
<script>
function regresar(){
i=1;	
}
</script>
<style type="text/css">
<!--
.textoOpcion {  font-family: Arial, Helvetica, sans-serif; font-size: 8pt; color: #000000; text-decoration: underline}
-->
</style>
<body bgcolor="#FFFFFF" topmargin="0">

<?
// Programa que actualiza los datos de notificación para un radicado
if  (count($recordSet)>0)
	array_splice($recordSet, 0);  		
if  (count($recordWhere)>0)
	array_splice($recordWhere, 0);
	
$fecha_hoy = Date("Y-m-d");
$sqlFechaHoy=$db->conn->OffsetDate(0,$db->conn->sysTimeStamp);
$values["SGD_TDEC_CODIGO"] = $decis;
$recordWhere["radi_nume_radi"] = $verrad;
$rs=$db->update("radicado", $values, $recordWhere);

if (!$rs){
		$db->conn->RollbackTrans();
		die ("<span class='alarmas'>No se ha podido actualizar la informaci&oacute;n de resoluci&oacute;n"); 
	
}
$objTipDec->tipoDecision_codigo($decis);
$tipDecDesc = $objTipDec->get_sgd_tdec_descrip();
$values2["depe_codi"] = $dependencia;
$values2["hist_fech"] = " $sqlFechaHoy ";
$values2["usua_codi"] = $codusuario;
$values2["radi_nume_radi"]=$verrad;
$values2["hist_obse"] = "'Tipificacion de la decision  a $tipDecDesc '";
$values2["usua_codi_dest"] = $codusuario;
$values2["usua_doc"] = $usua_doc;
//La  transacción 35 es la tipificación de la transacción
$values2["SGD_TTR_CODIGO"] = 35;
$rs=$db->insert("hist_eventos",$values2);
	
if (!$rs){
			 	$db->conn->RollbackTrans();
		 	 	die ("<span class='alarmas'>ERROR TRATANDO DE ESCRIBIR EL HISTORICO");
}
$db->conn->CommitTrans();

?>
<form action='enviardatos.php?PHPSESSID=172o16o0o154oJH&krd=JH' method=post name=formulario>
<br>
<table border=0 cellspace=2 cellpad=2 WIDTH=50%  class="t_bordeGris" id=tb_general align="left">
	<tr>
	<td colspan="2" class="titulos4">ACCION REQUERIDA </td>
	</tr>
	<tr>
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">ACCION REQUERIDA :
	</td>
	<td  width="65%" height="25" class="listado2_no_identa">
	TIPIFICACION DE LA DECISION
	</td>
	</tr>
	<tr>
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">RADICADOS INVOLUCRADOS :
	</td>
	<td  width="65%" height="25" class="listado2_no_identa"><?=$verrad ?>
	</td>
	</tr>
	<tr>
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">USUARIO :
	</td>
	<td  width="65%" height="25" class="listado2_no_identa">
	<?=$usua_nomb?>
	</td>
	</tr>
	<tr>
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">FECHA Y HORA :
	</td>
	<td  width="65%" height="25" class="listado2_no_identa">
	<?=$fecha_hoy?>
	</td>
	</tr>
	</table>
	<BR>
</form>


<BR>
<input name='cancelar' type='button'  class='botones' id='envia22'  onClick='history.go(-1)' value='ACEPTAR'>
</body>
</html>
