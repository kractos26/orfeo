<?php
session_start();
$ruta_raiz = "..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
if($db)
{	//$db->conn->debug=true;
	!$expNum?($expNum= $_GET['expNUM']?$_GET['expNUM']:$_POST['expNUM']):0;
	if($expNum && substr(base64_decode($expNum),-1)==='%')
	{
		$expNum=substr(base64_decode($expNum),0,strlen(base64_decode($expNum))-1);
		include("$ruta_raiz/include/tx/Expediente.php");
                include("$ruta_raiz/include/tx/Historico.php");
		$expediente = new Expediente($db);
		$objHist = new Historico($db);
		if (isset($_POST['btn_accion']))
		{       //$db->conn->debug=true;
			switch($_POST['btn_accion'])
			{
				case 'Grabar':
					$sqlUp="update sgd_sexp_secexpedientes set sgd_sexp_nombre='".$_POST['txtNombreExp']."' ";
					$sqlUp.="where sgd_exp_numero='$expNum'";
					$db->conn->Execute($sqlUp) ? $error = 4 : $error = 5;
					if($error == 4)
					{
						$radicados[] = "NULL";
						$objHist->insertarHistoricoExp($expNum,$radicados,$_SESSION['dependencia'],$_SESSION['codusuario'],"Se modifica nombre del Expediente ",64,'0');
					}
					break;
			}
			$selCarpetas=0;
		}
		$expediente->getExpediente($expNum);
                $nombreExp=$expediente->nombreExp;

        }
}
if ($error)
{	$msg = '<tr bordercolor="#FFFFFF">
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
	switch ($error)
	{	
		case 4:	//
				$msg .=  "Se modific&oacute; con exito el Expediente";
				break;
		case 5:	//IMPOSIBILIDAD DE ELIMINAR REGISTRO
				$msg .=  "Error al modificar el Expediente.";
				break;
	
	}
	$msg .=  '</td></tr>';
}
?>
<html>
<head>
<script language="javascript" src="../js/funciones.js"></script>
<script language="JavaScript">

function validar(obj)
{
	if(obj.value=="Grabar")
	{
		if(document.getElementById('txtNombreExp').value == '')
		{
			alert("Debe diligenciar el campo Nombre");
			return false;
		}
	}
}
</script>
<title>Orfeo - Modificaci&oacute;n Expediente.</title>
<link href="<?=$ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="frmModExp" method="post" action="<?= $_SERVER['PHP_SELF']?>?expNum=<?=base64_encode($expNum.'%')?>&krd=<?=$krd?>">
<input type="hidden" name="hdBandera" value="">
<input type="hidden" name="expNum" id="expNum" value="<?=base64_encode($expNum.'%')?>">
<table width="100%"  align="center" class="borde_tab">
<tr>
    <td colspan="3" height="40" align="center" class="titulos4" valign="middle"><b><span class=etexto>Modificaci&oacute;n de Expediente No.<?=$expNum?></span></b></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>Nombre</b></td>
	<td class="listado2"><input name="txtNombreExp" id="txtNombreExp" value="<?=$nombreExp?>" type="text" size="50" maxlength="500"></td>
        <td width="20%" class="listado2"><center>
		<span class="e_texto1">
		
		</span></center>
	</td>
</tr>
<?php echo $msg;?>
</table>

<table width="100%"  align="center"  class="borde_tab">
<tr bordercolor="#FFFFFF">
	<td width="10%" class="listado2">&nbsp;</td>

	<td width="20%" class="listado2"><center>
		<span class="e_texto1">
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Grabar" onClick=" return validar(this);">
		</span></center>
	</td>
	<td width="20%"  class="listado2"><center>
		 <span class="e_texto1">
		<input name="btn_accion" type="button" class="botones" id="btn_accion" value="Cerrar" onClick="opener.regresar();window.close();"">
		</span></center>
	</td>
	<td width="10%" class="listado2">&nbsp;</td>
</tr>
</table>
</form>
</body>
</html>
