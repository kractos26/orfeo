<?php
error_reporting(0); 
session_start(); 
error_reporting(7);
$ruta_raiz = ".."; 
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug=true;
if (!defined('ADODB_FETCH_ASSOC'))	define('ADODB_FETCH_ASSOC',2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
if (!$fecha_busq)  $fecha_busq=Date('Y-m-d');
if (!$fecha_busq2)  $fecha_busq2=Date('Y-m-d');
?>
<html>
<head>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF">
 <div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="JavaScript" src="../js/formchek.js"></script>
<script language="javascript"><!--
    var dateAvailable  = new ctlSpiffyCalendarBox("dateAvailable", "adm_subserie", "fecha_busq","btnDate1","<?=$fecha_busq?>",scBTNMODE_CUSTOMBLUE);
    var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "adm_subserie", "fecha_busq2","btnDate2","<?=$fecha_busq2?>",scBTNMODE_CUSTOMBLUE);
//--></script>
<script>
function val_datos()
{
    bandera = true;
    err_msg = '';
    if( document.getElementById('codserie').value == 0)
    {
        err_msg = err_msg+'Seleccione serie.\n';
	bandera = false;
    }
    if(!isNonnegativeInteger(document.getElementById('tsub').value,false))
    {
        err_msg = err_msg+'Digite n\xFAmeros en el C\xF3digo Subserie\n';
	bandera = false;
    }
    if(isWhitespace(document.getElementById('detasub').value))
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
<span>
<form name="adm_subserie" id='adm_subserie' method='post'  action='admin_subseries.php?<?=session_name()."=".session_id()."&krd=$krd&tiem_ac=$tiem_ac&tiem_ag=$tiem_ag&fecha_busq=$fecha_busq&fecha_busq2=$fecha_busq2&codserie=$codserie&tsub=$tsub&detasub=$detasub"?>'>      
<table class=borde_tab width='100%' cellspacing="5"><tr><td class=titulos2><center>SUBSERIES DOCUMENTALES</center></td></tr></table>
<table><tr><td></td></tr></table>
<center>
<table width="550" class="borde_tab" cellspacing="5">
<TR>
    <td width="95" height="21"  class='titulos2'> C&oacute;digo Serie<br>
    <td colspan="3"  class="listado5">
<?php
if(!$codserie) $codserie = 0;
$fechah=date("dmy") . " ". time("h_m_s");
$fecha_hoy = Date("Y-m-d");
$sqlFechaHoy=$db->conn->DBDate($fecha_hoy);
$check=1;
$fechaf=date("dmy") . "_" . time("hms");
$num_car = 4;
$nomb_varc = "sgd_srd_codigo";
$nomb_varde = "sgd_srd_descrip";
include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
$querySerie = "select distinct ($sqlConcat) as detalle, sgd_srd_codigo 
	         from sgd_srd_seriesrd order by detalle";
$rsD=$db->conn->query($querySerie);
$comentarioDev = "Muestra las Series Documentales";
include("$ruta_raiz/include/class/medioSoporteArchivo.class.php");
include "$ruta_raiz/include/tx/ComentarioTx.php";
print $rsD->GetMenu2("codserie", $codserie, "0:-- Seleccione --", false,"","onChange='submit()' class='select' id='codserie'" );
$obj_tmp = new medioSoporte($db->conn);
$slc_tmp = $obj_tmp->Get_ComboOpc(true,true,$slc_cmb2);
//$db->conn->debug=true;
 ?>
    </td>
<tr>
<?php
if($_POST['actua_subserie'])
{
?>
 <td width="35" height="21"><input type=submit name=modi_subserie Value='Grabar Modificacion' class=botones_largo onclick="return val_datos();" ></td>
<?php
}
?>
    <tr>
	<td width="125" height="21"  class='titulos2'>C&oacute;digo Subserie</td>
	<td width="125" valign="top" align="left" class='listado2'>
            <input name="tsub" id="tsub" type="text" size="5" value="<?=$tsub?>" maxlength="2" onKeyPress="return acceptNum(event)">
	</td>
	<td width="125" height="21"  class='titulos2'>Descripci&oacute;n</td>
	<td valign="top" align="left" class='listado2'>
            <input name="detasub" id="detasub" type="text" size="75" class="tex_area" value="<?=$detasub?>">
	</td>
    </tr>
  <tr> 
  <td height="26" class='titulos2'>Fecha desde<br></td>
   	<td width="225" valign="top" class='listado2'>
	  <script language="javascript">
	  	dateAvailable.dateFormat="yyyy-MM-dd";
	    dateAvailable.date ="<?=$fecha_busq?>";
		dateAvailable.writeControl();
    </script>
     </td>
  <td height="26" class='titulos2'>Fecha Hasta<br></td>
 	<td width="225" align="right" valign="top" class='listado2'>
    <script language="javascript">
		dateAvailable2.dateFormat="yyyy-MM-dd";
		dateAvailable2.date ="<?=$fecha_busq2?>";
		dateAvailable2.writeControl();
    </script>
   </td>
  </tr>
  <tr> 
      <td width="125" height="21"  class='titulos2'> Tiempo Archivo de Gesti&oacute;n</td>
      <td valign="top" align="left" class='listado2'>
	     <input name="tiem_ag" type="text" size="20" class="tex_area" value="<?=$tiem_ag?>"></td>
     <td width="125" height="21"  class='titulos2'> Tiempo Archivo Central</td>
      <td valign="top" align="left" class='listado2'>
	  <input name="tiem_ac" type="text" size="20" class="tex_area" value="<?=$tiem_ac?>"> 
  </td>
  </tr>
  <tr> 
    <td width="125" height="21"  class='titulos2'> Soporte </td>
    <td valign="top" align="left" class='listado2'><?=$slc_tmp?></td>
    <td width="125" height="21"  class='titulos2'>Disposici&oacute;n Final</td>
    <td valign="top" align="left" class='listado2'>
        <select  name='med'  class='select'>
	<?php
	if($med==1){$datosel=" selected ";}else {$datosel=" ";}
		echo "<option value='1' $datosel><font>CONSERVACION TOTAL</font></option>";
	if($med==2){$datosel=" selected ";}else {$datosel=" ";}
		echo "<option value='2' $datosel><font>ELIMINACION</font></option>";
	if($med==3){$datosel=" selected ";}else {$datosel=" ";}
		echo "<option value='3' $datosel><font>MEDIO TECNICO</font></option>";
	if($med==4){$datosel=" selected ";}else {$datosel=" ";}
		echo "<option value='4' $datosel><font>SELECCION O MUESTREO</font></option>";
		?>
        </select>
    </td>
</tr>
<tr>
    <td width="25%" align="left" class='titulos2'>Observaciones</td>
    <td width="75%" class="listado5" colspan="3" >
        <textarea name="asu" cols="70" class="tex_area" rows="2" ><?=trim($asu)?></textarea>
    </td>
</tr>
<tr>
    <td height="26" colspan="4" valign="top" class='titulos2'>
        <center>
        <input type=submit name=buscar_subserie Value='Buscar' class=botones >
        <input type=submit name=insertar_subserie Value='Insertar' class=botones onclick="return val_datos();">
        <input type=submit name=actua_subserie Value='Modificar' class=botones >
        <input type="reset"  name=aceptar class=botones id=envia22  value='Cancelar'>
        </center>
    </td>
</tr>
</table>
</center>
<?PHP
if ($tiem_ag == '') $tiem_ag = 0;
if ($tiem_ac == '') $tiem_ac = 0;
$detasub = strtoupper(trim($detasub));
$sqlFechaD=$db->conn->DBDate($fecha_busq);	
$sqlFechaH=$db->conn->DBDate($fecha_busq2);	
//Buscar detalle subserie
if($buscar_subserie && $detasub !='')
{
    if($codserie != 0)
    {
        $detasub = strtoupper(trim($detasub));
	$whereBusqueda = " and sgd_sbrd_descrip like '%$detasub%'";
    }
}
	   
if($insertar_subserie)
{

    if($tsub !=0 && $codserie !=0 && $detasub !='')
    {
        $isqlB = "select * from sgd_sbrd_subserierd
		  where sgd_srd_codigo = '$codserie'
		  and sgd_sbrd_codigo = '$tsub'
		  ";
	
        # Selecciona el registro a actualizar
	$rs = $db->query($isqlB); # Executa la busqueda y obtiene el registro a actualizar.
	$radiNumero = $rs->fields["SGD_SRD_CODIGO"];
	if ($radiNumero !='') {
            $mensaje_err = "<HR><center><B><FONT COLOR=RED>EL CODIGO < $codserieI > YA EXISTE. <BR>  VERIFIQUE LA INFORMACION E INTENTE DE NUEVO</FONT></B></center><HR>";
	} 
	else 
	{
            $isqlB = "select * from sgd_sbrd_subserierd
                        where sgd_srd_codigo = '$codserie'
			and sgd_sbrd_descrip = '$detasub'
			"; 
            $rs = $db->query($isqlB); # Executa la busqueda y obtiene el registro a actualizar.
            $radiNumero = $rs->fields["SGD_SRD_CODIGO"];
	    if ($radiNumero !='') {
				   $mensaje_err = "<HR><center><B><FONT COLOR=RED>LA SERIE <$detasub > YA EXISTE. <BR>  VERIFIQUE LA INFORMACION E INTENTE DE NUEVO</FONT></B></center><HR>";
				  }
				else
					{
						$query="insert into SGD_SBRD_SUBSERIERD(SGD_SRD_CODIGO   , SGD_SBRD_CODIGO,SGD_SBRD_DESCRIP,SGD_SBRD_FECHINI,SGD_SBRD_FECHFIN,SGD_SBRD_TIEMAG ,SGD_SBRD_TIEMAC,SGD_SBRD_DISPFIN,SGD_SBRD_SOPORTE,SGD_SBRD_PROCEDI)
						VALUES ($codserie,$tsub,'$detasub'    ,".$sqlFechaD.",".$sqlFechaH.",$tiem_ag,$tiem_ac,'$med','$slc_cmb2','$asu')";
						$rsIN = $db->conn->query($query);
						$tsub = '' ;
						$detasub = '';
						$tiem_ag = '';
						$tiem_ac = '';
						$slc_cmb2 = '';
						if(!rsIN) $mensaje_err=" <HR><center><B><FONT COLOR=RED> Verifique todos los datos</FONT></B></center><HR>";
						?>
						<script language="javascript">
						    document.adm_subserie.elements['detasub'].value= '';
							document.adm_subserie.elements['tsub'].value= '';
						    document.adm_subserie.elements['asu'].value= '';
						    document.adm_subserie.elements['soporte'].value= '';
							document.adm_subserie.elements['tiem_ag'].value= '';
							document.adm_subserie.elements['tiem_ac'].value= '';

					</script>
						<?
  					}
			}
			}	 
    }
				
	if($_POST['actua_subserie'] )
	  {  
  		 if ($codserie !=0 && $tsub !=0 )
		   {
			 $isqlB = "select * from sgd_sbrd_subserierd 
					  where sgd_srd_codigo = $codserie
					  and sgd_sbrd_codigo = $tsub
					  "; 
			  # Selecciona el registro a actualizar
			  $rs = $db->query($isqlB); # Executa la busqueda y obtiene el registro a actualizar.
			  $radiNumero = $rs->fields["SGD_SRD_CODIGO"];
	          if ($radiNumero =='') {
			    $mensaje_err = "<HR><center><B><FONT COLOR=RED>EL CODIGO < $codserie >< $tsub > NO EXISTE. <BR>  VERIFIQUE LA INFORMACION E INTENTE DE NUEVO</FONT></B></center><HR>";
			   } 
			   else 
			   {
			   //Carga Valores actuales
			     $detasub   = $rs->fields["SGD_SBRD_DESCRIP"];
				 $sqlFechaD = $rs->fields["SGD_SBRD_FECHINI"];
				 $sqlFechaH = $rs->fields["SGD_SBRD_FECHFIN"];
				 $tiem_ag	= $rs->fields["SGD_SBRD_TIEMAG"];  
 				 $tiem_ac   = $rs->fields["SGD_SBRD_TIEMAC"];  
 				 $med       = $rs->fields["SGD_SBRD_DISPFIN"];
				 $soporte   = $rs->fields["SGD_SBRD_SOPORTE"];
				 $asu      = $rs->fields["SGD_SBRD_PROCEDI"];
				 $fecha_busq = $sqlFechaD;
				 $fecha_busq2 = $sqlFechaH;
				 $varFechaD = $fecha_busq;
			
				 ?>
					<script language="javascript">
					document.adm_subserie.elements['detasub'].value= "<?=$detasub?>";
					document.adm_subserie.elements['tsub'].value= "<?=$tsub?>";
					document.adm_subserie.elements['asu'].value= "<?=$asu?>";
					document.adm_subserie.elements['tiem_ag'].value= "<?=$tiem_ag?>";
					document.adm_subserie.elements['tiem_ac'].value= "<?=$tiem_ac?>";
					document.adm_subserie.elements['slc_cmb2'].value= "<?=$soporte?>";
					document.adm_subserie.elements['med'].value= "<?=$med?>";
					document.adm_subserie.elements['fecha_busq'].value= "<?=$fecha_busq?>";
					document.adm_subserie.elements['fecha_busq2'].value= "<?=$fecha_busq2?>";
					
					</script>
					<?
			   }
	 }
  }
  else
  {
	?>
        <script language="javascript">

        document.adm_subserie.elements['detasub'].value= '';
	document.adm_subserie.elements['tsub'].value= '';
	document.adm_subserie.elements['asu'].value= '';
	document.adm_subserie.elements['soporte'].value= '';
	document.adm_subserie.elements['tiem_ag'].value= '';
	document.adm_subserie.elements['tiem_ac'].value= '';
		
	</script>
	<?php
  }
     
//Selecciono Grabar Cambios
   if($_POST['modi_subserie'] )
     {  
       if ($codserie !=0 && $tsub !=0 && $detasub != '')
	     {
	        $isqlB = "select * from sgd_sbrd_subserierd 
				        where sgd_srd_codigo = $codserie
				        and sgd_sbrd_descrip = '$detasub'
				        and sgd_sbrd_codigo != $tsub
			          "; 
	  		$rs = $db->query($isqlB); # Executa la busqueda y obtiene el registro a actualizar.
	  		$radiNumero = $rs->fields["SGD_SRD_CODIGO"];
	  		if ($radiNumero !='') 
	    		{
		   			$mensaje_err = "<HR><center><B><FONT COLOR=RED>LA SUBSERIE <$detasub > YA EXISTE. <BR>  VERIFIQUE LA INFORMACION E INTENTE DE NUEVO</FONT></B></center><HR>";
	    		}
	  		else  
	    		{		   
	     			$isqlUp = "update sgd_sbrd_subserierd 
					   			set SGD_SBRD_DESCRIP= '$detasub' 
						  			,SGD_SBRD_FECHINI=$sqlFechaD 
						  			,SGD_SBRD_FECHFIN =$sqlFechaH 
						  			,SGD_SBRD_TIEMAG = $tiem_ag
 						  			,SGD_SBRD_TIEMAC = $tiem_ac
 						  			,SGD_SBRD_DISPFIN ='$med'
						  			,SGD_SBRD_SOPORTE ='$slc_cmb2'
						  			,SGD_SBRD_PROCEDI ='$asu'
                        		where sgd_srd_codigo = $codserie
									and sgd_sbrd_codigo = $tsub
								";
            		$rsUp= $db->query($isqlUp); 
					$tsub = '' ;
					$detasub = '';
					$tiem_ag = '';
					$tiem_ac = '';
					$slc_cmb2 = '';
					$mensaje_err ="<HR><center><B><FONT COLOR=RED>SE MODIFICO LA SUBSERIE</FONT></B></center><HR>";
					?>
					<script language="javascript">
				        document.adm_subserie.elements['detasub'].value= '';
						document.adm_subserie.elements['tsub'].value= '';
	    				document.adm_subserie.elements['asu'].value= '';
	    				document.adm_subserie.elements['soporte'].value= '';
						document.adm_subserie.elements['tiem_ag'].value= '';
						document.adm_subserie.elements['tiem_ac'].value= '';
					</script>
					<?
	    		}
   			} 
	}
	include_once "$ruta_raiz/trd/lista_subseries.php";

	?>
	
</form>
</span>
<p>
<?=$mensaje_err?>
</p>
</body>
</html>
