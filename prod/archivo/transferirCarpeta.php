<?php
session_start();
$ruta_raiz = "..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
if($db)
{	!$expNum?($expNum= $_GET['expNum']?$_GET['expNum']:$_POST['expNum']):0;
	include("$ruta_raiz/include/tx/Expediente.php");
	include("$ruta_raiz/include/combos.php");
	include("$ruta_raiz/include/tx/Historico.php");
	$cmb = new combo();
	$expediente = new Expediente($db);
	$objHist = new Historico($db);
	//$db->conn->debug=true;
	if (isset($_POST['btn_accion']))
	{   
		
		switch($_POST['btn_accion'])
		{
			case 'Transferir':
                                if(isset ($_POST['checkValue']) && is_array($_POST['checkValue']))
                                {
                                    $selCarpetas=implode(',',$_POST['checkValue']);
                                    $where=" and sgd_carpeta_id in ($selCarpetas)";
                                    $sqlUp="update sgd_carpeta_expediente set SGD_CARPETA_NUMERO='".$_POST['txtNCarp']."'";
                                    $sqlUp.="where sgd_exp_numero='$expNum' $where";
                                    //$db->conn->debug=true;
                                    $db->conn->StartTrans();
                                    $db->conn->Execute($sqlUp) ? $error = 4 : $error = 5;
                                    if($error == 4)
                                    {
                                            $sqlSel="select SGD_CARPETA_CSC from sgd_carpeta_expediente where sgd_exp_numero='$expNum' $where";
                                            $carpsVec=$db->conn->GetArray($sqlSel);
                                            $radicados[] = "NULL";
                                            foreach($carpsVec as $i=>$valCar)
                                            {
                                                    $objHist->insertarHistoricoExp($expNum,$radicados,$_SESSION['dependencia'],$_SESSION['codusuario'],"Cambio de Carpeta en Archivo Central para la carpeta No. ".$valCar['SGD_CARPETA_CSC'],62,'0');
                                            }
                                            $sqlUp="update sgd_sexp_secexpedientes set sgd_sexp_faseexp=2";
                                            $sqlUp.="where sgd_exp_numero='$expNum'";
                                            if($db->conn->Execute($sqlUp))$db->conn->CompleteTrans();
                                            else $db->conn->RollbackTrans();
                                    }
				}
				break;
		}
		$selCarpetas=0;
	}
	$expediente->getExpediente($expNum);
	$sql1  = "select '['".$db->conn->concat_operator."sgd_carpeta_numero".$db->conn->concat_operator."'] '".$db->conn->concat_operator."'-' ".$db->conn->concat_operator."sgd_carpeta_descripcion as ver, ";
	$sql1 .= "sgd_carpeta_id as ID from  sgd_carpeta_expediente where sgd_exp_numero='$expNum' order by 1";
	($rsSel=$db->conn->Execute($sql1)) ? $error = $error : $error = 3;
	$slcCarp=$rsSel->GetMenu( 'selCarpetas', $selCarpetas, '0:&lt;&lt Todas las Carpetas &gt;&gt;', false, false, " id='selCarpetas' class='select' onChange='actualiza();'", false );
	
	$sqlTbl="select ce.*
			 from sgd_carpeta_expediente ce
			 join sgd_sexp_secexpedientes exp on exp.sgd_exp_numero=ce.sgd_exp_numero
			 where ce.sgd_exp_numero='$expNum' order by sgd_carpeta_csc";
	($rsTbl=$db->conn->Execute($sqlTbl)) ? $error = $error : $error = 8;
	if($rsTbl && !$rsTbl->EOF)
	{
		$colspan=6;
		$v = "<input name='checkAll' value='checkAll' onclick='markAll();' checked='checked' type='checkbox'>";
		if($rsTbl->fields['SGD_SEXP_TIPOEXP']==2)$colspan=7;
		$tblCpr="<br><br><table width='100%'  class='border_tab'><tr><td colspan='$colspan' class='titulos2'><center>Carpetas creadas</center></td></tr>";
		$tblCpr.="<tr><td class='titulos2' align='center'>No. Consecutivo</td>";
		if($rsTbl->fields['SGD_SEXP_TIPOEXP']==2)$tblCpr.="<td class='titulos2' align='center'>Tipo Carpeta</td>";
		$tblCpr.="<td class='titulos2' align='center'>Descripci&oacute;n y/o Contenido</td><td class='titulos2' align='center'>No. Carpeta</td><td class='titulos2' align='center'>No. Folios</td><td class='titulos2'>$v</td>";
		while(!$rsTbl->EOF)
		{
			$v = "<input name='checkValue[".$rsTbl->fields['SGD_CARPETA_ID']."]' value='".$rsTbl->fields['SGD_CARPETA_ID']."' checked='checked' type='checkbox'>";
			$tblCpr.="<tr><td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_CSC']."</center></td>";
			if($rsTbl->fields['SGD_SEXP_TIPOEXP']==2)$tblCpr.="<td class='listado2'>".$rsTbl->fields['SGD_TIPO_CARPDESCRIP']."</td>";
			$tblCpr.="<td class='listado2'>".$rsTbl->fields['SGD_CARPETA_DESCRIPCION']."</td>";
			$tblCpr.="<td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_NUMERO']."</center></td>";
			$tblCpr.="<td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_NFOLIOS']."</center></td>";
			//$tblCpr.="<td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_CAJA']."</center></td>";
			//$tblCpr.="<td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_OBSERVACIONES']."</center></td>";
                        $tblCpr.="<td class='listado2'>$v</td></tr>";
			 $vecCarp[$rsTbl->fields['SGD_CARPETA_ID']]['NCAJA']=$rsTbl->fields['SGD_CARPETA_CAJA'];
			 $rsTbl->MoveNext();
		}
		$tblCpr.="</table>";
		$vCarp=$cmb->arrayToJsArray($vecCarp,'vCar');
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
				$msg .=  "Se realiz&oacute; con exito la Transferencia";
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
		document.getElementById('txtNCaja').value = vCar[i]["NCAJA"];
	}
	else
	{	
		document.getElementById('txtNCaja').value = '';
	}
	
}
function validar(obj)
{
	if(obj.value=="Transferir")
	{
		if(document.getElementById('txtNCaja').value == '')
		{
			alert("Debe digitar n\xFAmero de caja definitiva");
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
function Actual(){}

function markAll()
{
	if(document.frmCarpetas.elements['checkAll'].checked)
	{
		for(i=3;i<document.frmCarpetas.elements.length;i++)
		{
			document.frmCarpetas.elements[i].checked=1;
		}
	}
	else
	{
		for(i=3;i<document.frmCarpetas.elements.length;i++)
		{
			document.frmCarpetas.elements[i].checked=0;
		}
	}
}
<?=$vCarp?>
</script>
<title>Orfeo - Transferencia de Carpetas.</title>
<link href="<?=$ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="frmCarpetas" method="post" action="<?= $_SERVER['PHP_SELF']?>?expNum=<?=$expNum?>&krd=<?=$krd?>">
<input type="hidden" name="hdBandera" value="">
<input type="hidden" name="expNum" id="expNum" value="<?=$expNum?>">
<table width="100%"  align="center" class="borde_tab">
<tr>
	<td colspan="3" height="40" align="center" class="titulos4" valign="middle"><b><span class=etexto>TRANSFERENCIA DE CARPETAS</span></b></td>
</tr>
<!--<tr>
	<td width="40%" align="left" class="titulos2"><b>Seleccione Carpeta</b></td>
	<td width="60%" class="listado2">
		<?=$slcCarp ?>	
	</td>
</tr>-->
<tr bordercolor="#FFFFFF">
	
</tr>
<?php
	echo $msg;
?>
</table>
<table width="100%"  align="center"  class="borde_tab">
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>No. Carpeta</b></td>
	<td class="listado2"><input name="txtNCarp" id="txtNCarp" type="text" size="10" maxlength="10"></td>
	<td  class="listado2"><center>
		<span class="e_texto1">
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Transferir" onClick="return validar(this);">
		</span></center>
	</td>
	<td  class="listado2"><center>
		 <span class="e_texto1">
		<input name="btn_accion" type="button" class="botones" id="btn_accion" value="Cerrar" onClick="opener.regresar();window.close();"">
		</span></center>
	</td>
</tr>
</table>
<?=$tblCpr?>
</form>
</body>
</html>
