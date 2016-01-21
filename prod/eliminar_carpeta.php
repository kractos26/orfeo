<?php
$krdOld = $krd;
$carpetaOld = $carpeta;
$tipoCarpOld = $tipo_carp;
session_start();
if(!$krd) $krd=$krdOsld;
$ruta_raiz = ".";
if(!$_SESSION['dependencia']) include "$ruta_raiz/rec_session.php";
$verrad = "";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler($ruta_raiz);
$ADODB_COUNTRECS= true;

if($BorrarCarp)
{
	$isql=	"select count(*) AS Num from radicado
			where carp_per=1 and carp_codi=$borrcarpeta and
			 	  radi_depe_actu=$dependencia and radi_usua_actu=$codusuario ";
	$rs=$db->conn->Execute($isql);
	$numerot = $rs->fields[0];
	if($rs==-1) die("<center>No se han encontrado carpetas vacias <br> ");
	if($numerot==0)
	{
		$isql = "delete from  carpeta_per where depe_codi=$dependencia and usua_codi=$codusuario and codi_carp=$borrcarpeta ";
		$rs=$db->conn->query($isql);
		if($rs==-1) die("<p align='center' class='alarmas'><center>No se ha podido Borrar la carpeta,<br>");
		$msg = "<span align='center' class='info'>Se ha borrado la Carpeta con &eacute;xito</span>";
	}
	else
	{
		$msg = "<br><span class='alarmas'>La carpeta no se ha podido borrar por que contiene $numerot documentos,<br> La carpeta debe estar vacia para poder ser borrada </span>";
	}
}

$descripcionSql = $db->conn->concat('NOMB_CARP',"' - '", 'DESC_CARP');
$isql ="select $descripcionSql , CODI_CARP from carpeta_per
		where usua_codi=$codusuario and depe_codi=$dependencia order by codi_carp  ";

$rs = $db->conn->Execute($isql);
$ADODB_COUNTRECS= false;
if ($rs->RecordCount() > 0)
$msg .= "<br>Solo se pueden eliminar las carpertas que se encuentren vacias</p>
		<p align='center' class='etextomenu'>Usted tiene estas carpetas vacias:</p>".
        $rs->GetMenu2("borrcarpeta", "$borrcarpeta", "0:-- Seleccione la carpeta Personal--", false,"","onChange='procEst(formulario,18,$i )' class='select'").
        "<BR><input type=submit name='BorrarCarp' Value= 'Borrar Carpeta' class='botones'>";
else
$msg .= "<BR>Ud. NO posee carpetas personales vacias.";
?>
<html>
<head>
<title>Eliminar Carpetas</title>
<link rel="stylesheet" href="estilos/orfeo.css">
</head>
<body>
<table width="98%" border="0" cellpadding="0" cellspacing="5" class="borde_tab" align="center">
<tr>
	<TD width='97%' class="titulos4" align="center">ELIMINAR CARPETAS PERSONALES</TD>
</tr>
</table>
<BR>
<form name='form1' method='post' action='eliminar_carpeta.php?=<?=session_name."=".session_id?>&krd=<?=$krd?>'>
<table width="98%" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
<tr>
	<TD width='97%' class="listado2_center" ALIGN="center">
		<?php echo $msg; ?>
	</TD>
</tr>
</table>
</form>
</body>
</html>
