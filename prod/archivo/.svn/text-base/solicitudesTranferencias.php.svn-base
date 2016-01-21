<?
session_start();
$ruta_raiz = "..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
if(!$fecha_busq)$fecha_busq=date('Y-m-d');
if(!$fecha_busq2)$fecha_busq2=date('Y-m-d');
if($db)
{	
	$tip = (isset($_POST['tip'])) ? $_POST['tip'] : $_GET['tip'];
	if($_SESSION["usua_admin_archivo"]==1)
	{
		$whereSecc="and d.DEPE_CODI_TERRITORIAL=".$_SESSION["depe_codi_territorial"];
		$blank1stItem = "99999:Todas las Dependencias de la Seccional";
	}
	else $blank1stItem = "99999:Todas las Dependencias";
	
	!$accion?($accion= $_GET['accion']?$_GET['accion']:$_POST['accion']):0;
	if($accion)
	{
                //$db->conn->debug=true;
		switch ($accion)
		{
			case 'Buscar':
                            $whereFec = " and ".$db->conn->SQLDate('Y-m-d', 'exp.sgd_fech_soltransferencia')." BETWEEN '$fecha_busq' AND '$fecha_busq2'";
                            if($txtExpediente)$where=" and exp.SGD_EXP_NUMERO='$txtExpediente'";
                            if($dependenciaSel!=99999)$where.=" and exp.DEPE_CODI=$dependenciaSel";
                            $sqlFECH_SOL=$db->conn->SQLDate("Y-m-d H:i A","exp.sgd_fech_soltransferencia");
                            $sSQL="select d.depe_nomb, exp.sgd_fech_soltransferencia as FECHCOMPLETA , count(*) as CANTIDAD , $sqlFECH_SOL AS FECHA_SOL, exp.depe_codi
                                            from sgd_sexp_secexpedientes exp
                                            join dependencia d on d.depe_codi=exp.depe_codi
                                            where exp.sgd_sexp_faseexp=$tip $whereFec
                                                    $where
                                                    $whereSecc
                                        group by d.depe_nomb, exp.sgd_fech_soltransferencia, $sqlFECH_SOL, exp.depe_codi
                                        order by 1";

			     $rs=$db->query($sSQL);
			     if($rs && !$rs->EOF)
			     {
			     	  include("$ruta_raiz/include/class/InventarioFUI.php");
                                  define('FPDF_FONTPATH',"$ruta_raiz/fpdf/font/");
                                  $objFui = new InventarioFUI($db->conn);
                                  $v = "<br><input name='checkAll' value='checkAll' onclick='markAll();' checked='checked' type='checkbox'>";
                                  $tblSolTarns="<table width='100%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'>";
                                  $tblSolTarns.="<tr><td class='titulos2' colspan='11'>EXPEDIENTES</td></tr>";
                                  $tblSolTarns.="<tr class='titulos3' align='center' valign='middle'>";
                                  $tblSolTarns.="<td><font class='titulos3'>Dependencia</font></td>";
                                  $tblSolTarns.="<td><font class=titulos3>Fecha<br>Solicitud</font></td>";
                                  $tblSolTarns.="<td><font class=titulos3>Reporte</font></td>";
                                  $tblSolTarns.="<td><font class='titulos3'>Cantidad</font></td>";
                                  if($tip==1)$tblSolTarns.="<td><font class='titulos3'>$v</font></td></tr>";
                                  $iCounter = 0;
                                  $contArch=0;
                                  while($rs && !$rs->EOF)
                                  {
                                            //--------
                                            $sqlVerifTipo="select sgd_exp_numero from sgd_sexp_secexpedientes where depe_codi=".$rs->fields["DEPE_CODI"]." and ".
                                            		$db->conn->SQLDate('Y-m-d H:i A', 'sgd_fech_soltransferencia')."='".$rs->fields["FECHA_SOL"]."'";
                                            $rsVerifTipo=$db->conn->Execute($sqlVerifTipo);
                                            if($rsVerifTipo && !$rsVerifTipo->EOF)
                                            {
                                                $car='';
                                                $i=0;
                                                $exp='';
                                                $resultadoPdfAdm=$resultadoXmlAdm=$resultadoPdfProc=$resultadoXmlProc='';
                                                while (!$rsVerifTipo->EOF)
                                                {
                                                    if($i>=1)$car=',';
                                                    $exp.= $car."'".$rsVerifTipo->fields['SGD_EXP_NUMERO']."'";
                                                    $i++;
                                                    $rsVerifTipo->MoveNext();
                                                }
                                            }
                                            

                                            $titulosAdm = array('No Correl','CODIGO SERIE'=>array("\nDEP\n ","\nSERIE-SUB"),"NUMERO\nEXP","NOMBRE UNIDAD DE CONSERVACION\n ",'FECHAS EXTREMAS'=>array("INICIAL\n\nDD/MM/AA","FINAL\n\nDD/MM/AA"),'NUMERO'=>array("\nCARPETA\n "),"NOMBRE CARPETA\n\n", "TOTAL FOLIOS");
                                            $widthsAdm  = array(2.8,4.8,7.5,40,8,5,30,5);
                                             $exp = is_null($exp) ? "''" : $exp;
                                             $sqlAdm = "select exp.depe_codi as DEPENDENCIA,  exp.sgd_srd_codigo ".$db->conn->concat_operator."'-'".$db->conn->concat_operator." exp.sgd_sbrd_codigo as SERIE,exp.sgd_exp_numero as NUMERO_EXP, exp.sgd_sexp_nombre as NOMBRE_UNIDAD_DE_CONSERVACION, ".$db->conn->SQLDate('d/m/Y','exp.sgd_sexp_fech')." as FECHA_INICIAL,".$db->conn->SQLDate('d/m/Y','exp.sgd_sexp_fechacierre')." as FECHA_FINAL, carp.sgd_carpeta_numero AS NUMERO_CARPETA, carp.sgd_carpeta_descripcion AS CONTENIDO, carp.sgd_carpeta_nfolios as NFOLIOS
                                                            from sgd_carpeta_expediente carp
                                                            join sgd_sexp_secexpedientes exp on carp.sgd_exp_numero=exp.sgd_exp_numero
                                                        where  exp.sgd_exp_numero in ($exp) order by exp.sgd_exp_numero, carp.sgd_carpeta_csc";
                                            $ADODB_COUNTRECS=true;
                                            $rsAdm=$db->conn->Execute($sqlAdm);
                                            $ADODB_COUNTRECS=false;
                                            $contA=$rsAdm->RecordCount();
                                            if($rsAdm->RecordCount()>0)
                                            {
                                                $objFui->tipoReporte="ARCHIVO CENTRAL";
                                                $objFui->creaFormato($rsAdm,$titulosAdm,$widthsAdm);
                                                $resultadoPdfAdm .= "<a href='".$objFui->enlacePDF($contArch++)."' target='_blank'><img  width='30' height='13' src='../imagenes/pdf.png' border='0' alt='Formato PDF' title='Formato PDF' align='top' /></a> &nbsp;";
                                                $resultadoXmlAdm .= "<a href='".$objFui->enlaceXML($contArch++)."' target='_blank'><img  width='30' height='13' src='../imagenes/xml.png' border='0' alt='Formato XML' title='Formato XML' align='top' /></a>";
                                            }
                                            $v = "<input name='checkValue[]' value='".$rs->fields["FECHCOMPLETA"].",".$rs->fields["DEPE_CODI"]."' checked='checked' type='checkbox'>";
                                            $iCounter++;
                                            if($iCounter%2==0){ $tipoListado="class=\"listado2\""; }
                                            else              { $tipoListado="class=\"listado1\""; }
                                            $tblSolTarns.="<tr $tipoListado align='center'>";
                                            $tblSolTarns.="<td class='leidos'>".$rs->fields["DEPE_NOMB"]."</td>";
                                            $tblSolTarns.="<td class='leidos'>".$rs->fields["FECHA_SOL"]."</td>";
                                            $tblSolTarns.="<td class='leidos'>$resultadoPdfAdm<br>$resultadoPdfProc</td>";
                                            $tblSolTarns.="<td class='leidos'><center>".$rs->fields["CANTIDAD"]."</center></td>";
                                            if($tip==1)$tblSolTarns.="<td class='leidos'><center>".$v."</center></td></tr>";
                                            $rs->MoveNext();
                                         }
                                        if($tip==1)$tblSolTarns.=" <tr  align='center'><td class='titulos3' colspan='11' align='center'><input type='submit' name='accion' class='botones_mediano2' value='Cancelar Solicitud' onClick='return cancelaSol();'></td></tr>";
                                        $tblSolTarns.="</table><br>";
			     }
			     else
                             {
                                     $tblSolTarns="<center><table width='60%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'><tr><td class='listado5' colspan='2'><center><font color=red size=3>No existen Expedientes en solicitud para la transferencia con el criterio de B&uacute;squeda</font></center></td></tr></table></center>";
                             }
                            break;
			case 'Cancelar Solicitud':
				
				if(is_array($_POST['checkValue']))
				{
					include_once "$ruta_raiz/include/tx/Historico.php";
					$objHistorico= new Historico($db);
					foreach ($_POST['checkValue'] as $l=>$value)
					{	
						$dep=substr($value,strpos($value,',')+1);
						$fechaSolicitud=substr($value,0,strpos($value,','));
						$sqlSel="select distinct sgd_exp_numero from sgd_sexp_secexpedientes where sgd_fech_soltransferencia='$fechaSolicitud' and depe_codi=$dep";
						$expsVec=$db->conn->GetArray($sqlSel);
						if($expsVec)
						{
							$sqlUp="update sgd_sexp_secexpedientes set sgd_sexp_faseexp=0, sgd_fech_soltransferencia=null
							  		where sgd_fech_soltransferencia='$fechaSolicitud' and depe_codi=$dep ";
							//$db->conn->debug=true;
							$rsUp=$db->conn->Execute($sqlUp);
							if($rsUp)
							{
								$radicados[0] = "NULL";
								foreach($expsVec as $i=>$valExp)
								{
									$objHistorico->insertarHistoricoExp($valExp["SGD_EXP_NUMERO"],$radicados,$_SESSION['dependencia'],$_SESSION['codusuario'],"Cancelaci&oacute;n de Solicitud de Transferencia Archivo Central. ".$_POST['txtNCarpeta'],67,'0');
								}
							}
						}
						empty($expsVec);
					}
				}
				break;	
			case '':
				break;	
		}
	}
	$sql = "SELECT d.dep_sigla ".$db->conn->concat_operator."'-'".$db->conn->concat_operator." d.DEPE_NOMB, d.DEPE_CODI FROM DEPENDENCIA d where d.depe_estado=1 $whereSecc ORDER BY 1";
	$rs = $db->conn->execute($sql);
	$selDep = $rs->GetMenu2('dependenciaSel', $dependenciaSel,$blank1stItem ,false,0," id='dependenciaSel' class=select onChange='combos(this)'");
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="javascript" src="../js/funciones.js"></script>
<script language="javascript" src="../js/ajax.js"></script>
<script type="text/javascript" language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script type="text/javascript" language="JavaScript">
var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "frmSolTrans", "fecha_busq","btnDate1",<?="'".$fecha_busq."'"?>,scBTNMODE_CUSTOMBLUE);
var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "frmSolTrans", "fecha_busq2","btnDate2",<?="'".$fecha_busq2."'"?>,scBTNMODE_CUSTOMBLUE);
</script>

<script language="JavaScript">
function regresar()
{
	window.document.frmSolTrans.action ='<?=$ruta_raiz?>/archivo/archivo.php?krd=<?=$krd?>';
	window.document.frmSolTrans.submit();
}
function markAll()
{
	if(document.frmSolTrans.elements['checkAll'].checked)
	{
		for(i=1;i<document.frmSolTrans.elements.length;i++)
		{
			if(document.frmSolTrans.elements[i].name.slice(0, 10)=='checkValue')
			{
				document.frmSolTrans.elements[i].checked=true;
			}
		}
	}
	else
		for(i=1;i<document.frmSolTrans.elements.length;i++)
		document.frmSolTrans.elements[i].checked=false;
	
}

function validar()
{
	marcados = 0;
	for(i=0;i<document.frmSolTrans.elements.length;i++)
	{	
		if(document.frmSolTrans.elements[i].checked==true )
		{
			if(document.frmSolTrans.elements[i].name!='checkAll')
			{
				marcados++;
			}
	    }
	}
	if(marcados)return true;
	else 
	{	
		alert('Debe seleccionar un registro')
	    return false;
	}
}
function cancelaSol()
{
	if(validar()) return true;
	else return false;
}
</script>
<title>Orfeo -Solicitudes Transferecnia de Carpetas.</title>
<link href="<?=$ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
<div id="spiffycalendar" class="text"></div>
</head>
<body onload="document.getElementById('txtExpediente').focus();">
<form name="frmSolTrans" method="post" action="<?= $_SERVER['PHP_SELF']?>?expNum=<?=$expNum?>&krd=<?=$krd?>">
<input type="hidden" name="tip" value="<?=$tip?>">
<table width="60%" align="center" border=0 cellpadding=0 cellspacing=2 class='borde_tab'>
		<tbody>
		<tr>
			<td  class="titulos4" colspan="2"><?if($tip==1){?>B&Uacute;SQUEDA: EXPEDIENTES SOLICITADOS PARA TRANSFERIR<?}else{?> B&Uacute;SQUEDA:REPORTE FINAL DE TRANSFERENCIA<? }?></td>
		</tr>
		<tr>
		    <td class='titulos5'>No de Expediente:</TD>
		    <td class='listado5'><input name="txtExpediente" id="txtExpediente" type="text" size="21" class="tex_area" value="" id="txtExpediente"></td>
		</tr>
		<tr>
			<td class="titulos5">Dependecia</td>
			<td class="listado5"><?=$selDep?></td>
		</tr>
		<tr>
	    <td class='titulos5'> Fecha desde</td>
	    <td class='listado5'>
	        <script language="javascript">
	        dateAvailable.date = "<?=date('Y-m-d');?>";
	        dateAvailable.writeControl();
	        dateAvailable.dateFormat="yyyy-MM-dd";
	        </script>
	    </td>
		</tr>
		<tr>
		    <td class='titulos5'> Fecha Hasta</td>
		    <td class='listado5'>
		        <script language="javascript">
		        dateAvailable2.date = "<?=date('Y-m-d');?>";
		        dateAvailable2.writeControl();
		        dateAvailable2.dateFormat="yyyy-MM-dd";
		        </script>
		    </td>
		</tr>
		<tr bordercolor="#FFFFFF">
			<td colspan="2" class="listado2">
				<center><input name="accion" type="submit" class="botones" id="accion" value="Buscar">
				&nbsp;<input name="accion" type="button" class="botones" id="accion" value="Regresar" onClick="regresar();"></center>
			</td>
   		</tr>
		</tbody> 
		</table>
		<?=$tblSolTarns?>
		</form>
</body>
</html>
