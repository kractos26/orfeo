<?php
session_start();
$ruta_raiz = "..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include($ADODB_PATH.'/adodb.inc.php');	// $ADODB_PATH configurada en config.php
$error = 0;
$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
$conn = NewADOConnection($dsn);
if ($conn)
{	$conn->SetFetchMode(ADODB_FETCH_ASSOC);
	//$conn->debug=true;
	include($ruta_raiz.'/include/class/tipEnvio.class.php');
	$obj_tmp = new tipEnvio($conn);
	if (isset($_POST['btn_accion']))
	{	
		$numRad=  $_POST['numRad']?$_POST['numRad']:$_GET['numRad'];
		$tip=  $_POST['tip']?$_POST['tip']:$_GET['tip'];
                $anex_codi=$_POST['anex_codi']?$_POST['anex_codi']:$_GET['anex_codi'];
		if(((int)$tip===1 or !$tip) and $tip!='01')$tip=1;
                else if(strlen($tip)==2)$tip='7'.$tip;
		switch($_POST['btn_accion'])
		{	
			Case 'Modificar':
			{  
                            if ($anex_codi)$where="sgd_anex_codigo='$anex_codi'";
                            else if($numRad)$where="radi_nume_radi=$numRad";
				$sql = "update SGD_DIR_DRECCIONES set MREC_CODI = ".$_POST['slc_cmb2']." where $where  and sgd_dir_tipo=$tip ";
				$conn->Execute($sql) ? $error = 4 : $error = 2;
			}
			break;
		}
	}
	$slc_tmp = $obj_tmp->Get_ComboOpc(true,true,$slc_cmb2,1,1,0);
}
else
{	$error = 1;
}


if ($error)
{	$msg = '<tr bordercolor="#FFFFFF">
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
	switch ($error)
	{	case 1:	//NO CONECCION A BD
				$msg .= "Error al conectar a BD, comun&iacute;quese con el Administrador de sistema !!";
				break;
		case 2:	//ERROR EJECUCCION SQL
				$msg .=  "Error al gestionar datos, comun&iacute;quese con el Administrador de sistema !!";
				break;
		case 4:	//MODIFICACION REALIZADA
				$msg .=  "Registro actualizado satisfactoriamente!!";
				break;
	}
	$msg .=  '</td></tr>';
}
?>
<html>
<head>
<title>Orfeo - Cambio Medio Envio</title>
<link href="<?=$ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="frmCME" method="post" action="<?= $_SERVER['PHP_SELF']?>">
<input type="hidden" name="numRad" value="<?=$numRad?>">
<input type="hidden" name="tip" value="<?=$tip?>">
<input type="hidden" name="anex_codi" value="<?=$anex_codi?>">
<table width="100%" border="1" align="center" cellspacing="0" class="tablas">
<tr bordercolor="#FFFFFF">
	<td colspan="2" height="40" align="center" class="titulos4" valign="middle"><b><span class=etexto>Modificaci&oacute;n Medio Env&iacute;o</span></b></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>&nbsp;Seleccione registro</b></td>
    <td align="left" class="listado2">
		<?=$slc_tmp	?>
	</td>
</tr>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" class="tablas">
<tr bordercolor="#FFFFFF">
	<td class="listado2">
		<span class="e_texto1"><center>
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Modificar" >
		</center></span>
	</td>
	<td class="listado2">
		<span class="e_texto1"><center>
		<input name="Cerrar" type="button" class="botones" id="envia22" onClick="opener.regresar();window.close();"value="Cerrar">
		</center></span>
	</td>
</tr>

</table><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" class="tablas"><?php echo $msg ?></table>
</form>
</body>
</html>
