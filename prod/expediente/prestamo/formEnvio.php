<?
session_start();
$ruta_raiz = "../..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
if($db)
{       //$db->conn->debug=true;
        $sqlDiasPrest="select param_valor from sgd_parametro  where  param_nomb='PRESTAMO_DIAS_PREST'";
        $rsDias=$db->conn->Execute($sqlDiasPrest);
        $DIASVENC=$rsDias->fields['PARAM_VALOR'];
	function verMensaje($accion,$lst) 
	{    
	   global $usua_nomb;
	   global $depe_nomb; 
	   $tblMsg="
			<table border=0 cellspace=2 cellpad=2 WIDTH=50%  class='t_bordeGris' id=tb_general align='left'>
			  <tr>
			  	<td colspan='2' class='titulos4'>ACCION REQUERIDA COMPLETADA</td>
			  </tr>
			  <tr>
			  	<td align='right' bgcolor='#CCCCCC' height='25' class='titulos2'>ACCION REQUERIDA:</td>
			    <td  width='65%' height='25' class='listado2_no_identa'>$accion</td>
			  </tr>
			  <tr>
			  	<td align='right' bgcolor='#CCCCCC' height='25' class='titulos2'>EXPEDIENTES INVOLUCRADOS:</td>
			    <td  width='65%' height='25' class='listado2_no_identa'>$lst</td>
			  </tr>
			  <tr>
			    <td align='right' bgcolor='#CCCCCC' height=25 class='titulos2'>FECHA:</td>
			    <td  width=65% height='25' class='listado2_no_identa'>".date('Y-m-d h:i:s a')."</td>
			  </tr>	  
			  <tr>
			     <td align='right' bgcolor='#CCCCCC' height='25' class='titulos2'>USUARIO ORIGEN:</td>
			     <td  width='65%' height='25' class='listado2_no_identa'>$usua_nomb</td>
			   </tr>
			   <tr>
			     <td align='right' bgcolor='#CCCCCC' height='25' class='titulos2'>DEPENDENCIA ORIGEN:</td>
			     <td  width='65%' height='25' class='listado2_no_identa'>$depe_nomb</td>
			   </tr>	
			</table>";
		return $tblMsg;
	
	}		
	!$accion?($accion= $_GET['accion']?$_GET['accion']:$_POST['accion']):0;
	!$tipoEnvio?($tipoEnvio= $_GET['tipoEnvio']?$_GET['tipoEnvio']:$_POST['tipoEnvio']):0;
	if($accion)
	{
		switch ($accion)
		{
			
			case 'Prestar':
					$lst=implode(',',array_keys($_POST['checkValue']));
					$setFecha="PRES_FECH_PRES=".$db->conn->OffsetDate(0,$db->conn->sysTimeStamp).", PRES_DESC='".$observa."', USUA_LOGIN_PRES='".$krd."',PRES_FECH_VENC= ".$db->conn->OffsetDate($DIASVENC,$db->conn->sysTimeStamp);
					$sqlUp = "update PRESTAMO set ".$setFecha.",PRES_ESTADO=2 
			   		where PRES_ID in (".$lst.")";
			        if($db->conn->query($sqlUp))
			        { 
			        	$sql="select distinct sgd_exp_numero from prestamo where pres_id in ($lst)";
			        	$rsLst=$db->conn->GetArray($sql);
			        	
			        	foreach ($rsLst as $i=>$val)
			        	{	
			        		
			        		$regs .=$val[0].',';
			        	}
			        	$tblConfirma=verMensaje('PRESTAMO',$regs);
			        }
				break;
			case 'Devolver':
				
					$lst=implode(',',array_keys($_POST['checkValue']));
					$setFecha="PRES_FECH_DEVO=".$db->conn->OffsetDate(0,$db->conn->sysTimeStamp).", DEV_DESC='".$observa."', USUA_LOGIN_RX='".$krd."' ";
					$sqlUp = "update PRESTAMO set ".$setFecha.",PRES_ESTADO=3 
			   		where PRES_ID in (".$lst.")";
			        if($db->conn->query($sqlUp))
			        { 
			        	$sql="select distinct sgd_exp_numero from prestamo where pres_id in ($lst)";
			        	$rsLst=$db->conn->GetArray($sql);
			        	
			        	foreach ($rsLst as $i=>$val)
			        	{	
			        		
			        		$regs .=$val[0].',';
			        	}
			        	$tblConfirma=verMensaje('DEVOLUCI&Oacute;N',$regs);
			        }
				break;	
			case 'contrasena':
				include "$ruta_raiz/class_control/usuario.php";
				$objUsu = new Usuario($db);
				$retorno=$objUsu->validaUsuario($txtLogin,$txtContrasena);
				die($retorno);
				break;	
		}
	}
	
	$verClave=0;
    $query="select PARAM_VALOR from SGD_PARAMETRO where PARAM_NOMB='PRESTAMO_PASW'"; 
    $rs = $db->conn->query($query);
    if ($rs && !$rs->EOF) 
    { 
    	$verClave = $rs->fields("PARAM_VALOR"); 
    }       
	if($tipoEnvio=='prestar')
	{
		include "$ruta_raiz/class_control/class_gen.php";
		$objFec=new CLASS_GEN();
		$fechaVenc=$objFec->suma_fechas(date('d/m/y'),$DIASVENC);
		$accion='Prestar';
		$titulo='Prestamo de Documentos';
	}
	else if($tipoEnvio=='devolver')
	{
		$accion='Devolver';
		$titulo='Devoluci&oacute;n de Documentos';
	}
	if($checkValue)
	{
		$regList=implode(',',array_keys($checkValue));
		$txtLogin=$checkValue[key($checkValue)];
		$sqlPRES_FECH_PEDI=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PEDI");
		$sqlPRES_FECH_CANC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_CANC");
		$sqlPRES_FECH_DEVO=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_DEVO");
		$sqlPRES_FECH_PRES=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PRES");
		$sqlPRES_FECH_VENC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_VENC");
                switch($db->driver)
                {
                    case 'postgres':
                                    $diasEspera=" date_part('days', ".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI)";
                            break;
                    case 'oci8':
                    case 'oci8po':
                                    $diasEspera= " cast((".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI)as number(3)) ";
                            break;
                    default:

                }
		$sSQL="select p.PRES_ID as PRESTAMO_ID, p.SGD_EXP_NUMERO as EXPEDIENTE, carp.sgd_carpeta_numero as CARPETA,
					  p.USUA_LOGIN_ACTU as LOGIN, D.DEPE_NOMB as DEPENDENCIA,".$sqlPRES_FECH_PEDI." as F_SOLICITUD,".$sqlPRES_FECH_VENC." as F_VENCIMIENTO,".
				      $sqlPRES_FECH_CANC." as F_CANCELACION,".$sqlPRES_FECH_PRES." as F_PRESTAMO,".$sqlPRES_FECH_DEVO." as F_DEVOLUCION,
		      	      G.PARAM_VALOR as REQUERIMIENTO, E.PARAM_VALOR as ESTADO,p.PRES_ESTADO as ID_ESTADO,p.PRES_REQUERIMIENTO, $diasEspera as DIASSOL
		      	      ,ncar.cantidad as cantidadCarpetas
				from
					  PRESTAMO p
					  join DEPENDENCIA D on D.DEPE_CODI=p.DEPE_CODI
					  join SGD_PARAMETRO E on E.PARAM_CODI=p.PRES_ESTADO
					  join SGD_PARAMETRO G on G.PARAM_CODI=p.PRES_REQUERIMIENTO
					  left join SGD_CARPETA_EXPEDIENTE carp on carp.SGD_CARPETA_ID=p.SGD_CARPETA_ID
					  join (select sgd_exp_numero, count(*) as cantidad from sgd_carpeta_expediente  group by sgd_exp_numero) ncar on ncar.sgd_exp_numero=p.sgd_exp_numero
				where
				   	  E.PARAM_NOMB='PRESTAMO_ESTADO' and 
					  G.PARAM_NOMB='PRESTAMO_REQUERIMIENTO'
					  and p.SGD_EXP_NUMERO is not null
					  and p.PRES_ID in ($regList)";
		//$db->conn->debug=true;
		$rs=$db->query($sSQL);
		if($rs && !$rs->EOF)
		{
			$v = "<br><input name='checkAll' value='checkAll' onclick='markAll();' checked='checked' type='checkbox'>";
			$tblList="<table width='100%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'>";
			$tblList.="<tr class='titulos3' align='center' valign='middle'>";
			$tblList.="<td><font class='titulos3'>Expediente</font></td>";	 
			$tblList.="<td><font class=titulos3'>Login</font></td>";	 
			$tblList.="<td><font class='titulos3'>Dependencia</font></td>";		 
			$tblList.="<td><font class=titulos3>Fecha<br>Solicitud</font></td>";	 
			$tblList.="<td><font class='titulos3'>Tiempo<br>Espera</font></td>";
			$tblList.="<td><font class='titulos3'>Fecha<br>Prestamo</font></td>";	
			$tblList.="<td><font class='titulos3'>Fecha<br>Vencimiento</font></td>";		 
			$tblList.="<td><font class='titulos3'>Requerimiento</font></td>";	
			$tblList.="<td><font class='titulos3'>No. Carpeta</font></td>"; 						
			$tblList.="<td><font class='titulos3'>$v</font></td></tr>";		 
			$iCounter = 0;
			while($rs && !$rs->EOF) 
			{
				$ncar="";
				$v = "<input name='checkValue[".$rs->fields['PRESTAMO_ID']."]' value='".$rs->fields['LOGIN']."' checked='checked' type='checkbox'>";
				$iCounter++;		 
				if($iCounter%2==0){ $tipoListado="class=\"listado2\""; }
				else              { $tipoListado="class=\"listado1\""; }
				if($rs->fields["CARPETA"])$ncar=" No. ".$rs->fields["CARPETA"];
				else $ncar=" con ".$rs->fields["CANTIDADCARPETAS"]." Carpetas";
				$tblList.="<tr $tipoListado align='center'>";
				$tblList.="<td class='leidos'>".$rs->fields["EXPEDIENTE"]."</td>"; 
				$tblList.="<td class='leidos'>".$rs->fields["LOGIN"]."</td>";	 
				$tblList.="<td class='leidos'>".$rs->fields["DEPENDENCIA"]."</td>"; 
				$tblList.="<td class='leidos'>".$rs->fields["F_SOLICITUD"]."</td>";
				$tblList.="<td class='leidos'>".$rs->fields["DIASSOL"]."</td>";
				$tblList.="<td class='leidos'>".$rs->fields["F_PRESTAMO"]."</td>";
				$tblList.="<td class='leidos'>".$rs->fields["F_VENCIMIENTO"]."</td>";	 
				$tblList.="<td class='leidos'>".$rs->fields["REQUERIMIENTO"].$ncar."</td>";
				$tblList.="<td class='leidos'>".$rs->fields["CARPETA"]."</td>";					
				$tblList.="<td class='leidos'>".$v."</td></tr>";	 
				$tipoReq=$rs->fields["PRES_REQUERIMIENTO"];
				$rs->MoveNext();   
			}	
			$tblPrestados.="</table><br>";
		}
	}


	
}
?>
<html>
<head>
<script language="javascript" src="../../js/funciones.js"></script>
<script language="javascript" src="../../js/ajax.js"></script>
<script language="JavaScript">
function regresar()
{
	window.document.frmSolPrest.action = window.document.frmSolPrest.frmAnt.value+'?numExpediente=<?=$expNum?>&numExpActual=<?=$expNum?>&verrad=<?=$verrad?>';
	window.document.frmSolPrest.submit();
}
function markAll()
{
	if(document.frmEnvio.elements['checkAll'].checked)
	for(i=1;i<document.frmEnvio.elements.length;i++)
	document.frmEnvio.elements[i].checked=1;
	else
		for(i=1;i<document.frmEnvio.elements.length;i++)
		document.frmEnvio.elements[i].checked=0;
}

function muestra()
{
	if( document.getElementById("tblCarp"))
	{   
	      ver = document.getElementById("tblCarp");
	      ver.style.display = "none";
	      if(document.getElementById("slcTipo").value==5){ 
	         ver.style.display = "";
	          
	      }
	} 
}
function validar()
{
	marcados = 0;
	var band=true;
	var msg='';
	for(i=0;i<document.frmEnvio.elements.length;i++)
	{	
		if(document.frmEnvio.elements[i].checked==1 )
		{
			if(document.frmEnvio.elements[i].name!='checkAll')marcados++;
	     }
	}
	if(!marcados)
	{	
		msg='-Debe seleccionar un registro\n';
	    band=false;
	}
	if(document.getElementById('observa').value.length<6)
	{
		msg+='-Debe Digitar una observaci\xF3n mayor a 6 digitos\n';
	    band=false;
	}
	if(!valMaxChars(document.getElementById('observa'),200,10))
	{
		return false;
	}	
	if(msg)alert("Debe diligenciar correctamente el formulario:\n"+msg);
	return band;
}
<?if($verClave){?>
function contrasena()
{	
	
	var objLogin = document.getElementById('txtLogin');
	var objContrasena = document.getElementById('txtContrasena');
	if(xmlHttp) 
	{

		xmlHttp.open("GET", "./formEnvio.php?accion=contrasena&txtLogin="+objLogin.value+"&txtContrasena="+objContrasena.value);
		xmlHttp.onreadystatechange = function()
		{
			if (xmlHttp.readyState == 4 && xmlHttp.status == 200) 
			{
                            if(xmlHttp.responseText==1)
                             {
                                 if(validar())
                                 {
                                     if(confirm("Datos ok.\nEst\xE1 seguro de realizar la acci\xF3n"))
                                        {
                                                window.document.frmEnvio.action='<?= $_SERVER['PHP_SELF']?>?krd=<?=$krd?>&accion=<?=$accion?>';
                                                window.document.frmEnvio.submit();
                                        }
                                 }
                             }
                             else
                             {
                                 alert('la contrase\xF1a no es correcta.');
                                 return false;
                             }
			}
		};
		xmlHttp.send(null);
	}
        
	
}
<?}?>
function enviar()
{   
       <?if($verClave){?>
         contrasena();
       <?}else{?>
	 if(validar())
         {
              if(confirm("Datos ok.\nEst\xE1 seguro de realizar la acci\xF3n"))
              {
                window.document.frmEnvio.action='<?= $_SERVER['PHP_SELF']?>?krd=<?=$krd?>&accion=<?=$accion?>';
                window.document.frmEnvio.submit();
              }
          }
         <?}?>
}
</script>
<title>Orfeo - Transferecnia de Carpetas.</title>
<link href="<?=$ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="frmEnvio" method="post" action="<?= $_SERVER['PHP_SELF']?>?krd=<?=$krd?>">
<input type="hidden" name="tipoEnvio"  id="tipoEnvio" value="<?=$tipoEnvio?>"> 
<input type="hidden" name="txtLogin" id="txtLogin" value="<?=$txtLogin?>"> 
<input type="hidden" name="fechaVenc" id="fechaVenc" value="<?=$fechaVenc?>"> 
<input type="hidden" name="band" id="band"> 
<?if($tblConfirma)die($tblConfirma);?>
<table  border=0 width=100% cellpadding="0" cellspacing="0" class="borde_tab">
<tr>
	<td>
		<table width="100%" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
 	    <tr>
 	    	<td width=30% class="titulos4">USUARIO:<br><br><?=$usua_nomb?><br></td>
	   	    <td width='30%' class="titulos4">DEPENDENCIA:<br><br><?=$depe_nomb?><br></td>
		    <td width="35%" class="titulos4"><?=$titulo?><BR></td>
                    <td width='5' class="gris"><input type="button" value='<?=$accion?>' onclick="enviar();" name="accion" class=botones ></td>
	     </tr>
	     </table>
	</td>
</tr>

<tr align="center">
	<td colspan="4" class="celdaGris" align=center>
		<br><center>
		<table width="100%" class="borde_tab" border=0 align="center" bgcolor="White">
		<tr bgcolor="White">
			<td width="100"><center><img src="<?=$ruta_raiz?>/iconos/tuxTx.gif" alt="Tux Transaccion" title="Tux Transaccion"></center></td>
			<td align="left"><textarea name=observa id=observa cols=70 rows=3 class=ecajasfecha><?=$observa?></textarea></TD>
		</tr>  			             
        <tr bgcolor="White">
 	    	<td align="right" class="titulos2">USUARIO:</td>
			<td align="left" class="titulos2"><?=$txtLogin?></td>
		<?if($verClave){?>	
        <tr bgcolor="White">
        	<td align="right" class="titulos2">CONTRASE&Ntilde;A:</td>
         	<td align="left" class="titulos2"><input type="password" name="txtContrasena" id="txtContrasena" value="<?=$txtContrasena?>"></td>
        </tr>
        <?}?>
        <?if($fechaVenc){?>	
        <tr bgcolor="White">
        	<td align="right" class="titulos2">FECHA DE VENCIMIENTO</td>
         	<td align="left" class="titulos2"><font color="red"><?=$fechaVenc?></font></td>
        </tr>
        <?}?>
 		</table></center>
 	</td>
</tr>
<tr>
	<td>
		<?=$tblList?>
	</td>
</tr>
</table>
</form>
</body>
</html>
