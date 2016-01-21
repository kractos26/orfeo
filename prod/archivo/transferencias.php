<?php
session_start();
$ruta_raiz = "..";
include("$ruta_raiz/config.php"); 			// incluir configuracion.
include_once "$ruta_raiz/include/tx/Historico.php";
include "$ruta_raiz/include/db/ConnectionHandler.php";
$txtExpediente = (isset($_POST['txtExpediente'])) ? $_POST['txtExpediente'] : $_GET['txtExpediente'];
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : $_GET['accion'];
$tip = (isset($_POST['tip'])) ? $_POST['tip'] : $_GET['tip'];
$dependenciaSel = (isset($_POST['dependenciaSel'])) ? $_POST['dependenciaSel'] : $_GET['dependenciaSel'];
$db = new ConnectionHandler($ruta_raiz);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
if ($db)
{	//$db->conn->debug=true;
	if($_SESSION["usua_admin_archivo"]==1)
	{
		$whereSecc="and d.DEPE_CODI_TERRITORIAL=".$_SESSION["depe_codi_territorial"];
		$blank1stItem = "99999:Todas las Dependencias de la Seccional";
	}
	else $blank1stItem = "99999:Todas las Dependencias";
	if(isset($accion))
	{
		
		switch ($accion)
		{
			case 'Buscar':
				{
					
					$c_order = " ORDER BY ".($orderNo+1);
					(!$orderTipo) ? $c_order .= $orderTipo = "" : $orderTipo="desc";
					if($txtExpediente)
					{
						$where=" and exp.sgd_exp_numero = '".$txtExpediente."'";
					}
					if($dependenciaSel!='99999')
					{
						if($where)$and=" and ";
						$where .=" and exp.depe_codi=".$dependenciaSel;
					}
					$sql = "select	d.depe_nomb as \"Dependencia\",
							exp.SGD_EXP_NUMERO AS \"No_Expediente\",
							exp.SGD_SEXP_FECH AS \"DEX_Fecha Creacion\",
							case exp.sgd_sexp_faseexp  
							when 2 then 'Si' 
							else  'No' end as \"Transferido\",
							exp.sgd_sexp_nombre AS \"Nombre\",
							u.usua_nomb AS \"Usuario Responsable\"
						from  sgd_sexp_secexpedientes exp
						join usuario u on u.usua_doc=exp.usua_doc_responsable
						join dependencia d on d.depe_codi=exp.depe_codi
						where exp.sgd_sexp_faseexp=$tip $where $whereSecc $c_order";
					
					$rs=$db->conn->Execute($sql);
					if($rs and !$rs->EOF)
					{
						$encabezado1 = $_SERVER['PHP_SELF']."?".session_name()."=".session_id()."&krd=$krd";
						$linkPagina = "$encabezado1&txtExpediente=$txtExpediente&dependenciaSel=$dependenciaSel&accion=$accion&orderNo=$orderNo";
						$encabezado = "".session_name()."=".session_id()."&krd=$krd&txtExpediente=$txtExpediente&dependenciaSel=$dependenciaSel&accion=$accion&orderTipo=$orderTipo&orderNo=";

						$pager = new ADODB_Pager($db,$sql,'adodb', true,$orderNo,$orderTipo);
						$pager->checkAll    = true;
						$pager->checkTitulo = true; 	
						$pager->toRefLinks  = $linkPagina;
						$pager->toRefVars   = $encabezado;
						$pager->btnReg=true;
					    $pager->btnCol=3;
					    $pager->btnRefJS="transferirCarp";// nombre de la funcion java script del boton;
					    $pager->btnRefJSParam=array("2");//numeros de columnas con el valor de los parametros para la funcion del javascript
						//$pager->txtBusqueda = trim($txtExpediente);
						//if($insertaExp)$pager->pasarDatos = true;
						//$btnConfirma="<input type='submit' name='accion' id='accion' value='Confirmar' class='botones_mediano'>";
					}
					else
					{
						$msg="<tr><td class='listado5' colspan='2'><center><font color=red size=3>No existen Expedientes para la transferencia con el criterio de B&uacute;queda</font></center></td></tr>";
					}
				}
				break;
			case 'Confirmar':
				{
					
				}
				break;
		}
		
	}
	$sql =  "SELECT d.dep_sigla ".$db->conn->concat_operator."'-'".$db->conn->concat_operator." d.DEPE_NOMB, d.DEPE_CODI FROM DEPENDENCIA d where d.depe_estado=1 $whereSecc ORDER BY 1";
	$rs = $db->conn->execute($sql);
	$cmb_dep = $rs->GetMenu2('dependenciaSel', $dependenciaSel, $blank1stItem,false,0,' id=dependenciaSel  class=select');
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
function regresarMenu()
{
	window.document.frmTransf.action ='<?=$ruta_raiz?>/archivo/archivo.php?krd=<?=$krd?>';
	window.document.frmTransf.submit();
}

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

function transferirCarp(exp)
{
	windowprops = "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=1100,height=550";
	 window.open( "<?=$ruta_raiz?>/archivo/transferirCarpeta.php?sessid=<?=session_id()?>&expNum="+exp+"&krd=<?=$krd?>&ind_ProcAnex=<?=$ind_ProcAnex?>","HistExp<?=$fechaH?>",windowprops );
}

function regresar(){
	document.getElementById('txtExpediente').value='';
	document.getElementById('dependenciaSel').value='99999';
	//window.location.reload();
	window.document.frmTransf.submit();
	window.close();
}
</script>
<div id="spiffycalendar" class="text"></div>
<form action="<?php echo $_SERVER['PHP_SELF']."?numExpediente=$numExpediente";?>" name="frmTransf" id="frmTransf" method="post">
<input type="hidden" name="tip" value="<?=$tip?>">
<body onload="document.getElementById('txtExpediente').focus();">
<center>
<table  border=0 width=30% cellpadding="0" cellspacing="5" class="borde_tab">
<tr>
     <td  class="titulos4" colspan="13"><?if($tip==1)echo" LEGALIZACI&Oacute;N DE TRANSFERENCIAS A ARCHIVO CENTRAL"; else echo "ADMINISTRACI&Oacute;N DE EXPEDIENTES TRANSFERIDOS"?></td>
</tr>
<tr>
    <td class='titulos5'>No de Expediente:</TD>
    <td class='listado5'><input name="txtExpediente" id="txtExpediente" type="text" size="21" class="tex_area" value="<?=$txtExpediente?>" id="txtExpediente"></td>
</tr>
<tr>
    <td height="26" class='titulos5'>Dependencia</td>
    <td valign="top" class='listado5'><?=$cmb_dep?></td>
</tr>
<tr>
    <td height="26" colspan="2" valign="top" class='titulos5'> 
    	<center>
    		<?=$btnConfirma?>
    		<input type="submit" name="accion" id="accion" value='Buscar' class='botones_mediano'>
    		&nbsp;<input name="accion" type="button" class="botones" id="accion" value="Regresar" onClick="regresarMenu();">
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
</center>
</form>
</body>
</html>

