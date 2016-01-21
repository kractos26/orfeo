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
		include("$ruta_raiz/include/combos.php");
		include("$ruta_raiz/include/tx/Historico.php");
		$cmb = new combo();
		$expediente = new Expediente($db);
		$objHist = new Historico($db);
		if (isset($_POST['btn_accion']))
		{       //$db->conn->debug=true;
			switch($_POST['btn_accion'])
			{
				case 'Crear':
					$idCarpeta=$db->conn->GenID('SEC_IDCARPETA');
					$cscCarpeta = $expediente->getSecCarpeta($expNum)+1;
					$_POST['txtNFolios']?$nfolios=$_POST['txtNFolios']:$nfolios='null';
					$sql = "insert into sgd_carpeta_expediente(sgd_carpeta_id, sgd_carpeta_csc, sgd_carpeta_descripcion, sgd_carpeta_numero,  sgd_exp_numero , sgd_carpeta_nfolios)";
					$sql.= "values ($idCarpeta,$cscCarpeta,'".$_POST['txtDescip']."',".$_POST['txtNCarpeta'].", '$expNum', $nfolios)";
					$db->conn->Execute($sql) ? $error = 1 : $error = 2;
					if($error == 1)
					{
						$radicados[] = "NULL";
						$objHist->insertarHistoricoExp($expNum,$radicados,$_SESSION['dependencia'],$_SESSION['codusuario'],"Se agrega Carpeta No.".$_POST['txtNCarpeta'],61,'0');
					}
					break;
				case 'Modificar':
					$_POST['txtNFolios']?$setNfolios=", sgd_carpeta_nfolios=".$_POST['txtNFolios']:$setNfolios='';
					$sqlUp="update sgd_carpeta_expediente set sgd_carpeta_descripcion='".$_POST['txtDescip']."', sgd_carpeta_numero=".$_POST['txtNCarpeta']." $setNfolios ";
					$sqlUp.="where sgd_carpeta_id=$selCarpetas and sgd_exp_numero='$expNum' ";
					$db->conn->Execute($sqlUp) ? $error = 4 : $error = 5;
					if($error == 4)
					{
						$radicados[] = "NULL";
						$objHist->insertarHistoricoExp($expNum,$radicados,$_SESSION['dependencia'],$_SESSION['codusuario'],"Se modifica Carpeta No. ".$_POST['txtNCarpeta'],62,'0');
					}
					break;
				case 'Eliminar':
					$sqlVerfi="select sgd_carpeta_id from sgd_exp_radcarpeta where sgd_carpeta_id=$selCarpetas";
					$rs=$db->conn->Execute($sqlVerfi);
					if($rs && $rs->EOF)
					{
						$sqlDel="delete from sgd_carpeta_expediente where sgd_carpeta_id=$selCarpetas and sgd_exp_numero='$expNum'";
						$db->conn->Execute($sqlDel) ? $error = 6 : $error = 7;
						if($error == 6)
						{
							$radicados[] = "NULL";
							$objHist->insertarHistoricoExp($expNum,$radicados,$_SESSION['dependencia'],$_SESSION['codusuario'],"Se elimina Carpeta No. ".$_POST['txtNCarpeta'],63,'0');
						}
					}
					else $error = 8;
					break;
			}
			$selCarpetas=0;
		}
		$expediente->getExpediente($expNum);
		
		$sql1  = "select '['".$db->conn->concat_operator."sgd_carpeta_numero".$db->conn->concat_operator."'] '".$db->conn->concat_operator."'-' ".$db->conn->concat_operator."sgd_carpeta_descripcion as ver, ";
		$sql1 .= "sgd_carpeta_id as ID from  sgd_carpeta_expediente where sgd_exp_numero='$expNum' order by 1";
		($rsSel=$db->conn->Execute($sql1)) ? $error = $error : $error = 3;
		$slcCarp=$rsSel->GetMenu( 'selCarpetas', $selCarpetas, '0:&lt;&lt seleccione &gt;&gt;', false, false, " id='selCarpetas' class='select' onChange='actualiza();'", false );
		$sqlTbl="select ce.*
				 from sgd_carpeta_expediente ce
				 join sgd_sexp_secexpedientes exp on exp.sgd_exp_numero=ce.sgd_exp_numero
				 where ce.sgd_exp_numero='$expNum' order by sgd_carpeta_csc";
		($rsTbl=$db->conn->Execute($sqlTbl)) ? $error = $error : $error = 8;
		if($rsTbl && !$rsTbl->EOF)
		{
			$colspan=7;
			if($rsTbl->fields['SGD_SEXP_TIPOEXP']==2)$colspan=8;
			$tblCpr="<br><br><table width='100%'  class='border_tab'><tr><td colspan='$colspan' class='titulos2'><center>Carpetas creadas</center></td></tr>";
			$tblCpr.="<tr><td class='titulos2' align='center'>No. Consecutivo</td>";
			$tblCpr.="<td class='titulos2' align='center'>Nombre</td><td class='titulos2' align='center'>No. Carpeta</td><td class='titulos2' align='center'>No. Folios</td>";
			while(!$rsTbl->EOF)
			{
				$tblCpr.="<tr><td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_CSC']."</center></td>";
				$tblCpr.="<td class='listado2'>".$rsTbl->fields['SGD_CARPETA_DESCRIPCION']."</td>";
				$tblCpr.="<td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_NUMERO']."</center></td>";
				$tblCpr.="<td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_NFOLIOS']."</center></td>";
				$vecCarp[$rsTbl->fields['SGD_CARPETA_ID']]['DESCRIPCION']=$rsTbl->fields['SGD_CARPETA_DESCRIPCION'];
                $vecCarp[$rsTbl->fields['SGD_CARPETA_ID']]['CARCSC']=$rsTbl->fields['SGD_CARPETA_CSC'];
				$vecCarp[$rsTbl->fields['SGD_CARPETA_ID']]['NFOLIOS']=$rsTbl->fields['SGD_CARPETA_NFOLIOS'];
				$vecCarp[$rsTbl->fields['SGD_CARPETA_ID']]['NUMERO']=$rsTbl->fields['SGD_CARPETA_NUMERO'];
				$rsTbl->MoveNext();
			}
			$tblCpr.="</table>";
			$vCarp=$cmb->arrayToJsArray($vecCarp,'vCar');
		}
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
}



if ($error)
{	$msg = '<tr bordercolor="#FFFFFF">
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
	switch ($error)
	{	case 1:	//CREACION DE CARPETA
				$msg .= "Se Cre&oacute; con exito la carpeta ";
				break;
		case 2:	//ERROR EJECUCCION SQL
				$msg .=  "Error al crear la carpeta";
				break;
		case 3:	//
				$msg .=  "Error al traer las carpetas";
				break;
		case 4:	//
				$msg .=  "Se modific&oacute; con exito la carpeta";
				break;
		case 5:	//IMPOSIBILIDAD DE ELIMINAR REGISTRO
				$msg .=  "Error al modificar la carpeta.";
				break;
		case 6:	//
				$msg .=  "Se Elimin&oacute; la carpeta";
				break;
		case 7:	//IMPOSIBILIDAD DE ELIMINAR REGISTRO
				$msg .=  "Error al eliminar la carpeta.";
				break;
		case 8:	//
				$msg .=  "No se puede eliminar la carpeta, contiene radicados archivados.";
				break;
	}
	$msg .=  '</td></tr>';
}
?>
<html>
<head>
<script language="javascript" src="../js/funciones.js"></script>
<script language="JavaScript">
function actualiza()
{
	var Obj = document.getElementById('selCarpetas');
	var i = Obj.value;
	if (i>0)
	{	
		document.getElementById('txtDescip').value = vCar[i]["DESCRIPCION"];
        document.getElementById('carCsc').value = vCar[i]["CARCSC"];
		document.getElementById('txtNCarpeta').value = vCar[i]["NUMERO"];
		document.getElementById('txtNFolios').value = vCar[i]["NFOLIOS"];
	}
	else
	{	
		document.getElementById('txtDescip').value = '';
        document.getElementById('carCsc').value ='';
		document.getElementById('txtNCarpeta').value = '';
		document.getElementById('txtNFolios').value = '';
	}
}
function validar(obj)
{
	if(obj.value=="Crear")
	{
		if(document.getElementById('txtDescip').value == '')
		{
			alert("Debe diligenciar todos los campos");
			return false;
		}
	}
	if(obj.value=="Modificar")
	{
		if(document.getElementById('selCarpetas').selectedIndex==0)
		{
			alert("Debe seleccionar una carpeta");
			return false;
		}
		if(document.getElementById('txtDescip').value == '')
		{
			alert("Debe diligenciar el campo Nombre");
			return false;
		}
		if(document.getElementById('txtDescip').value == '' || document.getElementById('txtNCarpeta').value == '' )
		{
			alert("Debe diligenciar todos los campos");
			return false;
		}
                if(!valMaxChars(document.getElementById('txtObserva'),200,15))
                {
                        return false;
                }
	}
	if(obj.value=="Eliminar")
	{
		if(document.getElementById('selCarpetas').selectedIndex==0)
		{
			alert("Debe seleccionar una carpeta");
			return false;
		}
	}
}
function genEtiqueta(id,tip)
{
    if(tip==1)
    {
	window.open("<?=$ruta_raiz?>/expediente/gen_etiqExp.php?carpetaId="+id,"carPExp","top=100,left=100,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=400,height=240");
    }
    if(tip==2)
    {
	window.open("<?=$ruta_raiz?>/expediente/gen_etiqCaja.php?carpetaId="+id,"carPExp","top=100,left=100,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=400,height=240");
    }
}
<?=$vCarp?>
</script>
<title>Orfeo - Creaci&oacute;n de Carpetas.</title>
<link href="<?=$ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="frmCarpetas" method="post" action="<?= $_SERVER['PHP_SELF']?>?expNum=<?=base64_encode($expNum.'%')?>&krd=<?=$krd?>">
<input type="hidden" name="hdBandera" value="">
<input type="hidden" name="expNum" id="expNum" value="<?=base64_encode($expNum.'%')?>">
<input type="hidden" name="carCsc" id="carCsc" value="<?=$carCsc?>">
<table width="100%"  align="center" class="borde_tab">
<tr>
	<td colspan="3" height="40" align="center" class="titulos4" valign="middle"><b><span class=etexto>CREACION DE CARPETAS</span></b></td>
</tr>
<tr>
	<td width="40%" align="left" class="titulos2"><b>Seleccione Carpeta</b></td>
	<td width="60%" class="listado2">
		<?=$slcCarp ?>	
	</td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>Nombre</b></td>
	<td class="listado2"><input name="txtDescip" id="txtDescip" type="text" size="50" maxlength="500"></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>No. Carpeta</b></td>
	<td class="listado2"><input name="txtNCarpeta" id="txtNCarpeta" type="text" size="10" maxlength="10"></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>No. Folios</b></td>
	<td class="listado2"><input name="txtNFolios" id="txtNFolios" type="text" size="3" maxlength="6"></td>
</tr>
<?php
	echo $msg;
?>
</table>
<table width="100%"  align="center"  class="borde_tab">
<tr bordercolor="#FFFFFF">
	<td width="10%" class="listado2">&nbsp;</td>
	
	<td width="20%" class="listado2"><center>
		<span class="e_texto1">
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Crear" onClick=" return validar(this);">
		</span></center>
	</td>
	<td width="20%" class="listado2"><center>
		<span class="e_texto1">
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Modificar" onClick="return validar(this);">
		</span></center>
	</td>
	<td width="20%" class="listado2"><center>
		<span class="e_texto1">
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Eliminar" onClick="return validar(this);">
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
<?=$tblCpr?>
</form>
</body>
</html>
