<? $krdOld = $krd;
$per=1;
session_start();

if($numeroExpediente  && substr(base64_decode($numeroExpediente),-1)==='%')
{
	$numeroExpediente=substr(base64_decode($numeroExpediente),0,strlen(base64_decode($numeroExpediente))-1);
	if(!$krd) $krd = $krdOld;
	if (!$ruta_raiz) $ruta_raiz = "..";
	include "$ruta_raiz/rec_session.php";    
	include_once("$ruta_raiz/include/db/ConnectionHandler.php");
	include_once "$ruta_raiz/include/tx/Historico.php";
	include_once "$ruta_raiz/include/tx/Expediente.php";
		//$db->conn->debug=true;
	$db = new ConnectionHandler("$ruta_raiz");
	$objHistorico= new Historico($db); 
	$expediente = new Expediente($db);
	$expediente->getExpediente($numeroExpediente);
	$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&numeroExpediente=".base64_encode($numeroExpediente.'%')."&dependencia=$dependencia&krd=$krd&numRad=$numRad&coddepe=$coddepe&codusua=$codusua&depende=$depende&codserie=$codserie";
	!$numRad?$numRad="null":0;
}
else 
{
		$tblSinPermiso="<html>
                                    <head><title>Seguridad Expediente</title><link href='../estilos/orfeo.css' rel='stylesheet' type='text/css'></head>
                                    <body>
                                    <table border=0 width=100% align='center' class='borde_tab' cellspacing='0'>
                                    <tr align='center' class='titulos2'>
                                         <td height='15' class='titulos2'>!! SEGURIDAD !!</td>
                                    </tr>
                                    <tr >
                                         <td width='38%' class=listado5 ><center><p><font class='no_leidos'>ACCESO INCORRECTO.</font></p></center></td>
                                    </tr>
                                    </table>
                                    </body>
                                    </html>";
		die($tblSinPermiso);
}

?>
<html height=50,width=150>
<head>
<title>Cambiar Responsable</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
<CENTER>
<body bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
 <link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
 <script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js">


 </script>

<form name=responsable action="<?=$encabezadol?>" method='post' action='responsable.php?<?=session_name()?>=<?=trim(session_id())?>&numeroExpediente=<?=$numeroExpediente?>&krd=<?=$krd?>&texp=<?=$texp?>&numRad=<?=$numRad?>&<?="&mostrar_opc_envio=$mostrar_opc_envio&nomcarpeta=$nomcarpeta&carpeta=$carpeta&leido=$leido"?>'>
<br>

<table border=0 width 100% cellpadding="0" cellspacing="5" class="borde_tab">
<TD class=titulos5 >
		Usuario Responsable del Proceso
	</TD>
	<td class=listado2>
<?

$depe=substr($numeroExpediente,4,3);

	$queryUs = "select usua_nomb, usua_doc from usuario where depe_codi=$depe AND USUA_ESTA='1'
							order by usua_nomb";
	$rsUs = $db->conn->Execute($queryUs);
	print $rsUs->GetMenu2("usuaDocExp", "$usuaDocExp", "0:-- Seleccione --", false,""," class='select' ");
		$observa = "Se modifico el responsable  ";
		$arrayRad[0]=$numRad;

	if($Grabar){
	if($usuaDocExp!=0 ){
	$query="update sgd_sexp_secexpedientes set USUA_DOC_RESPONSABLE='$usuaDocExp' 
							WHERE SGD_EXP_NUMERO = '$numeroExpediente' and depe_codi=$expediente->depCodi";
	$rsUs = $db->conn->Execute($query);
		
}
}
	if(!$Grabar){
?>
</td>
<tr><TD colspan='2'>
<CENTER><input name='Grabar' type=submit class="botones_funcion" value="Grabar" >

<?
}
?>
	
	<input name="Cerrar" type="button" class="botones_funcion" id="envia22" onClick="opener.regresar();window.close();" value=" Cerrar " >

	</TD></tr>
</table>
<?
if($Grabar){
if($usuaDocExp!=0){
	$isqlDepR = "SELECT USUA_CODI 
			FROM usuario 
			WHERE USUA_LOGIN = '$krd'";
	$rsDepR = $db->conn->Execute($isqlDepR);
	$codusua = $rsDepR->fields['USUA_CODI'];

$objHistorico->insertarHistoricoExp($numeroExpediente,$arrayRad,$dependencia, $codusua,$observa,56,1);

//$objHistorico->insertarHistoricoExp($numeroExpediente,$arrayRad,$coddepe ,$codusua, $observa, 56,0);
//print $numeroExpediente.$arrayRad.$coddepe.$codusua.$observa;
echo "<CENTER><table><tr><td class=titulosError>EL RESPONSABLE HA SIDO MODIFICADO.</td></tr></table>";
}
else{
echo "<CENTER><table><tr><td class=titulosError>NO HA SELECCIONADO NINGUN RESPONSABLE.</td></tr></table>";
}
}

?>

</form>
</CENTER>
</html>