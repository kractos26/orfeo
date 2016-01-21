<?php
/**
 * Modulo que grafica una equiqueta.
 * Desarollo: Grupo Iyunxi Ltda.
 * Autoría: Fiscalía General de la Nación.
 * Julio de 2008.
 */

//Seguridad
session_start();
//if (!$_SESSION["usua_perm_tpx"]) die("Error accesando la p&aacute;gina. No tiene Privilegios.");

$ruta_raiz="..";
include "$ruta_raiz/config.php";		// incluir configuracion.

define('ADODB_ASSOC_CASE', 1);
include "$ADODB_PATH/adodb.inc.php";	// $ADODB_PATH configurada en config.php
$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
$conn = NewADOConnection($dsn);
if ($conn)
{	//$conn->debug=true;
	
	if (isset($_GET['r']) && substr(base64_decode($_GET['r']),-1)==='%')
	{
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$sqlfn = $conn->SQLDate('Y-m-d H:i:s','r.RADI_FECH_RADI');
		$sql = "SELECT r.RADI_NUME_RADI, $sqlfn as RADI_FECH_RADI, r.RADI_DESC_ANEX, d.DEP_SIGLA, d.DEPE_NOMB
                FROM RADICADO r
                left join DEPENDENCIA  d  on d.depe_codi=r.radi_depe_actu
                WHERE RADI_NUME_RADI=".substr(base64_decode($_GET['r']),0,strlen(base64_decode($_GET['r']))-1)." ";
		$vct = $conn->GetRow($sql);
		/*
		if (!defined('RELATIVE_PATH')) define('RELATIVE_PATH',$_SERVER['DOCUMENT_ROOT']."html2fpdf-3.0.2b/");
		if (!defined('FPDF_FONTPATH')) define('FPDF_FONTPATH',RELATIVE_PATH.'font/');
		require_once($_SERVER['DOCUMENT_ROOT']."html2fpdf-3.0.2b/html2fpdf.php");
		// activate Output-Buffer:
		ob_start();
		$pdf = new HTML2FPDF('P','cm','5x3');
		$pdf->DisableTags();
		$pdf->DisplayPreferences('FullScreen');
		*/
	}
	else 
	{
		$tblSinPermiso="<html>
                                    <head><title>Seguridad Radicado</title><link href='../estilos/orfeo.css' rel='stylesheet' type='text/css'></head>
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
}
?>
<html>
<head></head>
<body marginheight="0" marginwidth="0">
<table align="left" height="60" border="0">
<tr>
	<td colspan="2"> 
		<FONT FACE="Arial" size="1">Destino: <?=$vct["DEPE_NOMB"]?></font>
	</td>
</tr>
<tr>
	<td align="center" >	
		<FONT FACE="Code3of9" size="5">*<?=$vct['RADI_NUME_RADI']?>*</FONT><br>
		<FONT FACE="Arial" size="2">No. <?=$vct['RADI_NUME_RADI']?><br></font>
		<FONT FACE="Arial" size="1">Fecha Radicado: <?=$vct['RADI_FECH_RADI']?><br>
		Anexos: <?=$vct['RADI_DESC_ANEX']?>.</font>
	</td>
	<td valign="center"><img width="80" height="25" src="../logoEntidad.gif"></td>
</tr>
</table>
</body>
</html>
<?php

/*
// Output-Buffer in variable:
$html=ob_get_contents();
// delete Output-Buffer
ob_end_clean();
$pdf->AddPage();
$pdf->WriteHTML($html);
$pdf->Output($vct['RADI_NUME_RADI'].'pdf','I');
*/
?>
