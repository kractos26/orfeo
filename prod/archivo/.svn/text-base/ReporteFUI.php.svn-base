<?php
session_start();
$ruta_raiz = "..";
include("$ruta_raiz/config.php"); 			// incluir configuracion.
include_once "$ruta_raiz/include/tx/Historico.php";
include "$ruta_raiz/include/db/ConnectionHandler.php";

if(!$fecha_busq)$fecha_busq=date('Y-m-d');
if(!$fecha_busq2)$fecha_busq2=date('Y-m-d');
$txtExpediente = (isset($_POST['txtExpediente'])) ? $_POST['txtExpediente'] : $_GET['txtExpediente'];
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : $_GET['accion'];
$slcTipo = (isset($_POST['slcTipo'])) ? $_POST['slcTipo'] : $_GET['slcTipo'];
$slcTipoReporte = (isset($_POST['slcTipoReporte'])) ? $_POST['slcTipoReporte'] : $_GET['slcTipoReporte'];
$dependenciaSel = (isset($_POST['dependenciaSel'])) ? $_POST['dependenciaSel'] : $_GET['dependenciaSel'];
$db = new ConnectionHandler($ruta_raiz);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
if ($db)
{	//$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
	if(isset($accion))
	{
		switch ($accion)
		{
			case 'Generar Reporte':
				{
					include("$ruta_raiz/include/class/InventarioFUI.php");
					define('FPDF_FONTPATH',"$ruta_raiz/fpdf/font/");
					$objFui = new InventarioFUI($db->conn);
					//$db->conn->debug=true;
					if(is_array($_POST['checkValue']))
					{
						$expBusq=implode("','",array_keys($_POST['checkValue']));
						$exps=implode(",",array_keys($_POST['checkValue']));
					}
					if($_POST['slcTipo']==1 || $_POST['slcTipo']==0)
					{
						$titulosAdm = array('No Correl','CÓDIGO SERIE'=>array("\nDEP\n ","\nSERIE-SUB"),"NÚMERO\nEXP","NOMBRE UNIDAD DE CONSERVACIÓN\n ",
	                    					'FECHAS EXTREMAS'=>array("INICIAL\n\nDD/MM/AA","FINAL\n\nDD/MM/AA"),'NÚMERO'=>array("\nCAJA\n ","\nCARP\n "),
	                    					"CONTENIDO\n ",'TOTAL FOLIOS',"OBSERVACIONES\n ");
	                    $widthsAdm  = array(2.8,4.8,7.5,26,8,5,23,3.3,23);
	                    
	                    $sqlAdm   ="select exp.depe_codi as DEPENDENCIA,  exp.sgd_srd_codigo ".$db->conn->concat_operator."'-'".$db->conn->concat_operator." exp.sgd_sbrd_codigo as SERIE,exp.sgd_exp_numero as NUMERO_EXP, exp.sgd_sexp_nombre as NOMBRE_UNIDAD_DE_CONSERVACION, ".$db->conn->SQLDate('d/m/Y','exp.sgd_sexp_fech')." as FECHA_INICIAL,".$db->conn->SQLDate('d/m/Y','exp.sgd_sexp_fechacierre')." as FECHA_FINAL, carp.sgd_carpeta_caja AS NUMERO_CAJA, carp.sgd_carpeta_numero AS NUMERO_CARPETA, carp.sgd_carpeta_descripcion AS CONTENIDO, carp.sgd_carpeta_nfolios AS TOTAL_FOLIOS, carp.sgd_carpeta_observaciones AS OBSERVACIONES
							        from sgd_carpeta_expediente carp
							        join sgd_sexp_secexpedientes exp on carp.sgd_exp_numero=exp.sgd_exp_numero
									where  exp.sgd_sexp_tipoexp=1 and exp.sgd_exp_numero in ('$expBusq')
									order by exp.sgd_exp_numero, carp.sgd_carpeta_csc";
	                    $ADODB_COUNTRECS=true;
						$rsAdm=$db->conn->Execute($sqlAdm);
						$ADODB_COUNTRECS=false;
						$contA=$rsAdm->RecordCount();
						if($rsAdm->RecordCount()>0)
						{
							$objFui->versionForm="Código: FGN-61100-F-02 \nVersión: 03";
							$objFui->tipo="ADMINISTRATIVO";
							$objFui->tipoReporte=$tipoReporte;
							$objFui->creaFormato($rsAdm,$titulosAdm,$widthsAdm);
				            $resultado  = "<tr><td class='listado5' ><font color=red >(".$rsAdm->RecordCount().") Registros. Descargar Archivo Administrativo</font></td><td class='listado5'>";
				            $resultado .= "<a href='".$objFui->enlacePDF()."' target='_blank'><img  width='30' height='13' src='../imagenes/pdf.png' border='0' alt='Formato PDF' title='Formato PDF' align='top' /></a> &nbsp;";
				            $resultado .= "<a href='".$objFui->enlaceXML()."' target='_blank'><img  width='30' height='13' src='../imagenes/xml.png' border='0' alt='Formato XML' title='Formato XML' align='top' /></a>";
				            if($slcTipoReporte==1)$resultado .= "&nbsp;&nbsp;Solicitar Transferencia <input name='accion' value='&gt;&gt;' class='botones_2' onclick='solicitaTransf(\"$exps\",1)' type='button'>";
				            $resultado .= "</td></tr>";
						}
					}
					if($_POST['slcTipo']==2 || $_POST['slcTipo']==0)
					{
						$titulosProc = array('No Correl','CÓDIGO SERIE'=>array("\nDEP\n ","\nSERIE-SUB"),"NÚMERO EXP\n ","AUTOR\n ",'CONDICIÓN/ESTADO DEL PROCESO',"DENUNCIANTES\n ",'SINDICADOS O INDICIADO',"DELITO\n ","VICTIMA\n ",
	                    					 'CUADERNOS'=>array("\nORIG\n ","\nCOP\n ","\nANEX\n ","\nFLS\n "),"RAD\n ",'FECHAS EXTREMAS'=>array("\nINICIAL\nDD/MM/AA","\nFINAL\nDD/MM/AA"),
	                    					 'NÚMERO'=>array("\nCAJA\n ","\nCARP\n "),'OBSERVACIONES: CUADERNOS ORIGINALES Y ANEXOS');
	                    $widthsProc  = array(2.8,4.8,7.8,7.8,11.5,7.8,7.8,7.8,7.8,8.8,5.3,7,4.6,12.5);
	                    
	                    $sqlProc="select exp.depe_codi AS DEPENDENCIA ,  exp.sgd_srd_codigo ".$db->conn->concat_operator."'-'".$db->conn->concat_operator." exp.sgd_sbrd_codigo as SERIE, exp.sgd_exp_numero AS NUMERO_EXP, exp.sgd_sexp_autordespacho AS AUTOR, exp.sgd_sexp_condicion AS CONDICION, exp.sgd_sexp_denunciante AS DENUNCIANTES, exp.sgd_sexp_sindicado AS SINDICADO, exp.sgd_sexp_delito AS DELITO, exp.sgd_sexp_victima AS VICTIMA,
									 case carp.sgd_tipo_id when 1 then 'X' else '' end as ORIGINAL,
									 case carp.sgd_tipo_id when 2 then 'X' else '' end as COPIA,
									 case carp.sgd_tipo_id when 3 then 'X' else '' end as ANEXO,
									 carp.sgd_carpeta_nfolios as TOTAL_FOLIOS,
									 exp.sgd_sexp_nradicacion as RADICACION,
									 ".$db->conn->SQLDate('d/m/Y','exp.sgd_sexp_fech')." as FECHA_INICIAL,".$db->conn->SQLDate('d/m/Y','exp.sgd_sexp_fechacierre')." as FECHA_FINAL , carp.sgd_carpeta_caja AS NUMERO_CAJA, carp.sgd_carpeta_numero AS NUMERO_CARPETA, carp.sgd_carpeta_observaciones AS OBSERVACIONES
									 from sgd_carpeta_expediente carp
									 join sgd_sexp_secexpedientes exp on carp.sgd_exp_numero=exp.sgd_exp_numero
									 left join sgd_tipo_carpeta tcarp on tcarp.sgd_tipo_id=carp.sgd_tipo_id
									 where  exp.sgd_sexp_tipoexp=2 and exp.sgd_exp_numero in ('$expBusq')
									 order by exp.sgd_exp_numero, carp.sgd_carpeta_csc";
	                    sleep(1);
			            $ADODB_COUNTRECS=true;
			            $rsProc=$db->conn->Execute($sqlProc);
			            $ADODB_COUNTRECS=false;
			            $contP=$rsProc->RecordCount();
			            if($rsProc->RecordCount()>0)
			            {
			            	$objFui->versionForm="Código: FGN-61100-F-03 \nVersión: 03";
			            	$objFui->tipo="EXPEDIENTES PENALES";
			            	$objFui->tipoReporte=$tipoReporte;
				            $objFui->creaFormato($rsProc,$titulosProc,$widthsProc);
				            $resultado  .= "<tr><td class='listado5'><font color=red >(".$rsProc->RecordCount().") Registros. Descargar Archivo Procesos</font></td><td class='listado5'>";
				            $resultado .= "<a href='".$objFui->enlacePDF()."' target='_blank'><img width='30' height='13' src='../imagenes/pdf.png' border='0' alt='Formato PDF' title='Formato PDF' align='top' /></a> &nbsp;";
				            $resultado .= "<a href='".$objFui->enlaceXML()."' target='_blank'><img width='30' height='13' src='../imagenes/xml.png' border='0' alt='Formato XML' title='Formato XML' align='top' /></a>";
				            if($slcTipoReporte==1)$resultado .= "&nbsp;&nbsp;Solicitar Transferencia <input name='accion' value='&gt;&gt;' class='botones_2' onclick='solicitaTransf(\"$exps\",2);' type='button'>";
				            $resultado .= "</td>";//$btnSolicita="";
			            }
					}
					if(($_POST['slcTipo']==0 and $rsProc and !$rsProc->RecordCount() 
						and $rsAdm and !$rsAdm->RecordCount()) or ($_POST['slcTipo']==1 
						and $rsAdm and !$rsAdm->RecordCount()) or ($_POST['slcTipo']==2 
						and $rsProc and !$rsProc->RecordCount()) )
					{
						$msg="<tr><td class='listado5' colspan='2'><center><font color=red size=3>No es posible generar el Reporte, No existen carpetas</font></center></td></tr>";
					}
				}
				break;
		}
	}
}
?>

<html>
<head><title></title>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<script language="javascript" src="../js/funciones.js"></script>
<script type="text/javascript" language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script type="text/javascript" language="JavaScript">
var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "frmTransf", "fecha_busq","btnDate1",<?="'".$fecha_busq."'"?>,scBTNMODE_CUSTOMBLUE);
var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "frmTransf", "fecha_busq2","btnDate2",<?="'".$fecha_busq2."'"?>,scBTNMODE_CUSTOMBLUE);

function markAll()
{
	if(document.frmTransf.elements['checkAll'].checked)
	{
		for(i=3;i<document.frmTransf.elements.length;i++)
		{
			document.frmTransf.elements[i].checked=1;
		}
	}
	else
	{
		for(i=3;i<document.frmTransf.elements.length;i++)
		{
			document.frmTransf.elements[i].checked=0;
		}
	}
}

function solicitaTransf(exps,tip)
{
	var anchoPantalla = 300//screen.availWidth;
  	var altoPantalla  = 300//screen.availHeight;
  	var iniX= (screen.availHeight/2)-150
  	var iniY= (screen.availWidth/2)-150
    window.open("<?=$ruta_raiz?>/expediente/solicitarTransferenciaExp.php?sessid=<?=session_id()?>&exps="+exps+"&tip="+tip+"&krd=<?=$krd?>","modExp","top="+iniX+",left="+iniY+",height="+altoPantalla+",width="+anchoPantalla+",scrollbars=yes");
}

</script>
<div id="spiffycalendar" class="text"></div>
<form action="<?php echo $_SERVER['PHP_SELF']."?numExpediente=$numExpediente";?>" name="frmTransf" id="frmTransf" method="post">
<input type="hidden" name="tipoReporte" id="tipoReporte" value="<?=htmlentities($tipoReporte)?>">
<table class="borde_tab">
<tr>
     <td  class="titulos4" colspan="13">B&Uacute;SQUEDAS POR:</td>
</tr>
<tr>
   <td colspan="3" class="titulos5">
   <table border=0 width=69% cellpadding="0" cellspacing="0">
   <tr>
	 <td width="13%" valign="bottom" class="" ><a class="vinculos" href="../busqueda/busquedaPiloto.php?<?=$phpsession ?>&krd=<?=$krd?>&<? echo "&fechah=$fechah&primera=1&ent=2&s_Listado=VerListado"; ?>"><img src='../imagenes/general.gif' alt='' border=0 width="110" height="25"  ></a></td>
	 <td width="13%" valign="bottom" class="" ><a class="vinculos" href="../busqueda/busquedaHist.php?<?=session_name()."=".session_id()."&fechah=$fechah&krd=$krd" ?>"><img src='../imagenes/historico.gif' alt='' border=0 width="110" height="25" ></a></td>
	 <td width="13%" valign="bottom" class="" ><a class="vinculos" href="../busqueda/busquedaExp.php?<?=$phpsession ?>&krd=<?=$krd?>&<? ECHO "&fechah=$fechah&primera=1&ent=2"; ?>"><img src='../imagenes/expediente.gif' alt='' border=0 width="110" height="25"  ></a></td>
	 <td width="13%" valign="bottom" class="" ><a class="vinculos" href="../expediente/consultaTransferenciaExp.php?<?=$phpsession ?>&krd=<?=$krd?>&<? ECHO "&fechah=$fechah&primera=1&ent=2"; ?>"><img src='../imagenes/transferencia_R.gif' alt='' border=0 width="110" height="25"  ></a></td>
	 <td width="35%" valign="bottom" class="" >&nbsp;</td>
   </tr>
   </table>
   </td>
</tr>
<tr>
    <td class='titulos5'>No de Expediente:</TD>
    <td class='listado5'><input name="txtExpediente" type="text" size="21" class="tex_area" value="" id="txtExpediente"></td>
</tr>
<tr>
    <td class='titulos5'>Tipo de Reporte:</TD>
    <td class='listado5'><?=$slcTpRep?></td>
</tr>
<tr>
    <td class='titulos5'>Tipo de Expediente:</TD>
    <td class='listado5'><?=$slcTpExp?></td>
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
<tr>
    <td height="26" class='titulos5'>Dependencia</td>
    <td valign="top" class='listado5'><?=$cmb_dep?></td>
</tr>
<tr>
    <td height="26" colspan="2" valign="top" class='titulos5'> 
    	<center>
    		<input type="submit" name="accion" id="accion" value='Buscar' class='botones_mediano'>
    		<?=$btnConfirma?>
    	</center>
    </td>
</tr>
<?
if($msg)echo $msg;
echo $resultado;
?>
</table>
<?
if($pager)$pager->Render($rows_per_page=20,$linkPagina,$checkbox=chkAnulados);	
?>
</form>
</body>
</html>