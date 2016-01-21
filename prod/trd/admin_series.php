<?php
error_reporting(0); 
session_start(); 
error_reporting(7);
$ruta_raiz = ".."; 
if (!$nurad) $nurad= $rad;
if($nurad)
{
	$ent = substr($nurad,-1);
}
if (!$fecha_busq)  $fecha_busq=Date('Y-m-d');
if (!$fecha_busq2)  $fecha_busq2=Date('Y-m-d');
	
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
define('ADODB_FETCH_ASSOC',2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&krd=$krd&nurad=$nurad&fecha_busq=$fecha_busq&fecha_busq2=$fecha_busq2&codserieI=$codserieI&detaserie=$detaserie&codusua=$codusua&depende=$depende&ent=$ent";
?>
<html>
<head>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
<script>
function regresar(){   	
	document.adm_serie.submit();
}

function val_datos()
{
	bandera = true;
	err_msg = '';
	if(!isNonnegativeInteger(document.getElementById('codserieI').value,false))
	{
		err_msg = err_msg+'Digite n\xFAmeros C\xF3digo.\n';
		bandera = false;
	}
	if(isWhitespace(document.getElementById('detaserie').value))
	{
		err_msg = err_msg+'Digite Descripci\xF3n.\n';
		bandera = false;
	}
	if(dateAvailable.getSelectedDate() > dateAvailable2.getSelectedDate())
	{
		err_msg = err_msg+'Escoja correctamente las fechas.\n';
		bandera = false;
	}
	if (!bandera) alert(err_msg);
	return bandera;
}
var nav4 = window.Event ? true : false;
function acceptNum(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
return (key <= 13 || (key >= 48 && key <= 57));
}
</script>
</head>
<body bgcolor="#FFFFFF">
 <div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="JavaScript" src="../js/formchek.js"></script>
<script language="javascript">
<!--
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "adm_serie", "fecha_busq","btnDate1","<?=$fecha_busq?>",scBTNMODE_CUSTOMBLUE);
    var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "adm_serie", "fecha_busq2","btnDate2","<?=$fecha_busq2?>",scBTNMODE_CUSTOMBLUE);
//-->
</script>
<table class=borde_tab width='100%' cellspacing="5"><tr><td class=titulos2><center>SERIES DOCUMENTALES</center></td></tr></table>
<form method="post" action="<?=$encabezadol?>" name="adm_serie"> 
<center>
<table width="550" class="borde_tab" cellspacing="5">
<tr>
	<td width="125" height="21"  class='titulos2'> C&oacute;digo</td>
	<td valign="top" align="left" class='listado2'><input type=text id="codserieI" name=codserieI value='<?=$codserieI?>' size=5  maxlength="3" onKeyPress="return acceptNum(event)" ></td>
</tr>
<tr>
	<td height="26" class='titulos2'> Descripci&oacute;n</td>
	<td valign="top" align="left" class='listado2'><input type=text id="detaserie" name=detaserie value='<?=$detaserie?>' class='tex_area' size=75 maxlength="75" ></td>
</tr>
<tr>
	<td height="26" class='titulos2'>Fecha desde<br></td>
	<td width="225" align="right" valign="top" class='listado2'>
		<script language="javascript">
		dateAvailable.date = "<?=date('Y-m-d');?>";
		dateAvailable.writeControl();
		dateAvailable.dateFormat="yyyy-MM-dd";
		</script>
	</td>
</tr>
<TR>
	<td height="26" class='titulos2'> Fecha Hasta<br></td>
	<td width="225" align="right" valign="top" class='listado2'>
		<script language="javascript">
		dateAvailable2.date = "<?=date('Y-m-d');?>";
		dateAvailable2.writeControl();
		dateAvailable2.dateFormat="yyyy-MM-dd";
		</script>
	</td>
</TR>
<tr>
	<td height="26" colspan="3" valign="top" class='titulos2'>
		<center>
		<input type=submit name=buscar_serie Value='Buscar' class=botones >
		<input type=submit name=insertar_serie Value='Insertar' class=botones onclick="return val_datos();" >
		<input type=submit name=actua_serie Value='Modificar' class=botones onclick="return val_datos();" >
		<a href="javascript:history.back()"><input type="button"  name=aceptar class=botones id=envia22  value='Cancelar'></a>
		</center>
	</td>
</tr>
</table>
</center>
<?PHP
$sqlFechaD=$db->conn->DBDate($fecha_busq);	
$sqlFechaH=$db->conn->DBDate($fecha_busq2);	
$detaserie = strtoupper(trim($detaserie));
//Busca series que cumplen con el detalle
if($buscar_serie && $detaserie !='')
{
	$whereBusqueda = " where upper(sgd_srd_descrip) like '%".strtoupper($detaserie)."%'";
}
if($insertar_serie && $codserieI !=0 && $detaserie !='')
{
	$isqlB = "select * from sgd_srd_seriesrd where sgd_srd_codigo = $codserieI"; 
	# Selecciona el registro a actualizar
	$rs = $db->query($isqlB); # Executa la busqueda y obtiene el registro a actualizar.
	$radiNumero = $rs->fields["SGD_SRD_CODIGO"];
	if ($radiNumero !='')
	{
		$mensaje_err = "<HR><center><B><FONT COLOR=RED>EL CODIGO < $codserieI > YA EXISTE. <BR>  VERIFIQUE LA INFORMACION E INTENTE DE NUEVO</FONT></B></center><HR>";
	} 
	else 
	{
		$isqlB = "select * from sgd_srd_seriesrd where sgd_srd_descrip = '$detaserie'"; 
		$rs = $db->query($isqlB); # Executa la busqueda y obtiene el registro a actualizar.
		$radiNumero = $rs->fields["SGD_SRD_DESCRIP"];
	    if ($radiNumero !='')
	    {
	    	$mensaje_err = "<HR><center><B><FONT COLOR=RED>LA SERIE <$detaserie > YA EXISTE. <BR>  VERIFIQUE LA INFORMACION E INTENTE DE NUEVO</FONT></B></center><HR>";
	    }
	    else
		{
			$query="insert into SGD_SRD_SERIESRD(SGD_SRD_CODIGO   , SGD_SRD_DESCRIP,SGD_SRD_FECHINI,SGD_SRD_FECHFIN )
					VALUES ($codserieI,'$detaserie'    ,".$sqlFechaD.",".$sqlFechaH.")";
			$rsIN = $db->conn->query($query);
			$codserieI = 0 ;
			$detaserie = '';
?>
<script language="javascript">
document.adm_serie.codserieI.value ='';
document.adm_serie.detaserie.value ='';
</script>
<?php
  		}
	}
}
if($actua_serie && $codserieI !=0 && $detaserie !='')
{
	$isqlB = "select * from sgd_srd_seriesrd where sgd_srd_codigo = $codserieI"; 
	# Selecciona el registro a actualizar
	$rs = $db->query($isqlB); # Executa la busqueda y obtiene el registro a actualizar.
	$radiNumero = $rs->fields["SGD_SRD_CODIGO"];
	if ($radiNumero =='')
	{
		$mensaje_err = "<HR><center><B><FONT COLOR=RED>EL CODIGO < $codserieI > NO EXISTE. <BR>  VERIFIQUE LA INFORMACI&Oacute;N E INTENTE DE NUEVO</FONT></B></center><HR>";
	} 
	else 
	{
		$isqlB = "select * from sgd_srd_seriesrd 
				  where sgd_srd_descrip = '$detaserie'
				  and sgd_srd_codigo != $codserieI"; 
		$rs = $db->query($isqlB); # Executa la busqueda y obtiene el registro a actualizar.
		$radiNumero = $rs->fields["SGD_SRD_CODIGO"];
	    if ($radiNumero !='')
	    {
	    	$mensaje_err = "<HR><center><B><FONT COLOR=RED>LA SERIE <$detaserie > YA EXISTE. <BR>  VERIFIQUE LA INFORMACI&Oacute;N E INTENTE DE NUEVO</FONT></B></center><HR>";
		}
		else
		{
			$isqlUp =	"update sgd_srd_seriesrd 
						set SGD_SRD_DESCRIP= '$detaserie',
						SGD_SRD_FECHINI=$sqlFechaD,
						SGD_SRD_FECHFIN =$sqlFechaH
						where sgd_srd_codigo = $codserieI";
			$rsUp= $db->query($isqlUp);
			$codserieI = 0 ;
			$detaserie = '';
			$mensaje_err ="<HR><center><B><FONT COLOR=RED>SE MODIFIC&Oacute; LA SERIE</FONT></B></center><HR>";
?>
			<script language="javascript">
			document.adm_serie.codserieI.value ='';
			document.adm_serie.detaserie.value ='';
			</script>
<?php
		}
	}
}
include_once "$ruta_raiz/trd/lista_series.php";
?>
</form>
<p>
<?=$mensaje_err?>
</p>
</body>
</html>
