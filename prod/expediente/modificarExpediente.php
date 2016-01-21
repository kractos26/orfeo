<?php
session_start();
//if (!isset($_SESSION['dependencia']))   die("Acceso Incorrecto");
$ruta_raiz = "..";
include("$ruta_raiz/config.php"); 			// incluir configuracion.
include_once "$ruta_raiz/include/tx/Historico.php";
include "$ruta_raiz/include/db/ConnectionHandler.php";

$numExpediente = (isset($_POST['numExpediente'])) ? $_POST['numExpediente'] : $_GET['numExpediente'];
$db = new ConnectionHandler($ruta_raiz);
if ($db)
{   //$db->conn->debug=true;
   include("$ruta_raiz/include/tx/Expediente.php");
   $obj_exp = new Expediente($db);
   if( $numExpediente && substr(base64_decode($numExpediente),-1)==='%')
	{ 
		$numExpediente=substr(base64_decode($numExpediente),0,strlen(base64_decode($numExpediente))-1);
	    if (isset($_POST['Grabar']))
	    {
	    	if($chkCierre)
	    	{
	    		$fechaCerrar=$fechaCierre;
	    		$cerrado=1;
	    		$fase=0;
	    	}
	    	else
	    	{
	    		$cerrado=0;
	    		$fase=0;
	    	}
	    	$band=false;
	    	$obj_exp->getExpediente($numExpediente);
	    	if($nivelExp!=$obj_exp->nivelExp || ($nivelExp==3 and $selUsuPriv))
	    	{
	    		 $band=true;
	    	}
	    	/***************************** MODIFICAR METADATOS ******************/
            $db->conn->StartTrans();
            $tabla = "SGD_MMR_MATRIMETAEXPE";
            $r['SGD_EXP_NUMERO'] = $numExpediente;
            foreach ($_POST as $k => $v) {
            	if (substr($k, 0, 8) == "txt_mtd_") {
                	$idMtd = substr($k, 8);
                    $r['SGD_MTD_CODIGO'] = $idMtd;
                    $r['SGD_MMR_DATO'] = $_POST['txt_mtd_' . $idMtd];
                    $db->conn->Replace(&$tabla, $r, array('SGD_EXP_NUMERO', 'SGD_MTD_CODIGO'), true);
                }
            }
            $okM = $db->conn->CompleteTrans();
            /*********************************************************************/
	        $ok = $obj_exp->modificarExpediente($numExpediente,$usuaDocExp,$fechaInicio, $txtNombre,$txt_asuExp,$nivelExp,$fechaCerrar,$cerrado,$fase);
	        if ($ok && $okM)
	        {
	        	$isEditMTD = 0;
	            $msg = "Actualizaci&oacute;n Realizada.";
	        }
	        else
	        {
	            $msg = "Error al realizar actualizaci&oacute;n.";
	        }
	   		if($band)
	   		{
				if($nivelExp==0)
				{
					$query = "UPDATE SGD_SEXP_SECEXPEDIENTES SET SGD_SEXP_NIVELSEG=$nivelExp where SGD_EXP_NUMERO='$numExpediente'";
					$observa = "Expediente Publico.";
					$borrarTodo=true;
				}
				else
				if($nivelExp==1){
					$query = "UPDATE SGD_SEXP_SECEXPEDIENTES SET SGD_SEXP_NIVELSEG=$nivelExp where SGD_EXP_NUMERO='$numExpediente'";
					$observa = "Expediente Confidencial(Privado: Visible solo Usuario Actual)";
					$borrarTodo=true;
				}
				if($nivelExp==2){
					$query = "UPDATE SGD_SEXP_SECEXPEDIENTES SET SGD_SEXP_NIVELSEG=$nivelExp where SGD_EXP_NUMERO='$numExpediente'";
					$observa = "Expediente Confidencial(Dependencia: Visible solo Usuarios de la dependencia que asign&oacute; confidencialidad)";
					$borrarTodo=true;
				}
				if($nivelExp==3){
					$query = "UPDATE SGD_SEXP_SECEXPEDIENTES SET SGD_SEXP_NIVELSEG=$nivelExp where SGD_EXP_NUMERO='$numExpediente'";
					$observa = "Expediente Confidencial(Visible solo Usuario(s) Espec&iacute;fico(s))";
					if(is_array($selUsuPriv))
					{
						foreach ($selUsuPriv as $login)
						{
							$insertUsuarios="insert into sgd_matriz_nivelexp (sgd_exp_numero, usua_login) values('$numExpediente','$login')";
							$rsIns=$db->conn->Execute($insertUsuarios);
						}
					}
				}
				if($db->conn->Execute($query))
				{
					$mensaje_err= "<span class=leidos>El nivel de seguridad se actualiz&oacute; correctamente.";
					include_once "$ruta_raiz/include/tx/Historico.php";
					$codiRegH = "";
					$Historico = new Historico($db);
					$codiRegE[0] = "null";		  
					$radiModi = $radiModi = $Historico->insertarHistoricoExp($numExpediente,$codiRegE , $dependencia, $codusuario, $observa, 64, 0);
				}else 
				{
					echo "<span class=titulosError> !No se pudo actualizar el nivel de seguridad!";
				}
	   		}
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

	$obj_exp->getExpediente($numExpediente);
	$slcTipo=$obj_exp->tipExp;
	$txtNombre=$obj_exp->nombreExp;
	$txt_asuExp=$obj_exp->asuntoExp;
	$obj_exp->depCodi;
	$usuaDocExp=$obj_exp->responsable;
	$obj_exp->responsableNom;
	$obj_exp->area;
	$fechaInicio=$obj_exp->fecha;
	$nivelExp=$obj_exp->nivelExp;
	if($obj_exp->fechaCierre)
	{
		$fechaCierre=$obj_exp->fechaCierre;
		$chk="checked";
	}
	else $fechaCierre=date('Y-m-d');
	
	//crea combo de tipos de niveles
	$arrNivel=array('0'=>"P&uacute;blico",'1'=>"Privado",'2'=>"Dependencia",'3'=>"Usuario Espec&iacute;fico");
	$slcNivel="<select name='nivelExp' id='nivelExp' class='select' onchange='activa();'>";
	foreach($arrNivel as $j=>$value)
	{
		$nivelExp==$j?$est='selected':$est='';
		$slcNivel.="<option value=$j $est >$value</option>";
	}
	$slcNivel.="</select>";
	
	//crea combo de dependencias
	$cad = $db->conn->Concat("DEP_SIGLA","'-'","DEPE_NOMB");
	$sql = "select $cad , DEPE_CODI from dependencia d ORDER BY 1";
	$rs  = $db->conn->Execute($sql);
	$selectDep= $rs->GetMenu2('selDepPriv[]',$usDefault,false,true,3," id='selDepPriv' class='select' onChange=\"verUsuarios('$numExpediente','3');\" ");
		
	//borra todos los usuarios del radicado
	if($borrarTodo)
	{
		$sqlDel="delete from sgd_matriz_nivelexp where sgd_exp_numero='$numExpediente'";
		$rs1=$db->conn->Execute($sqlDel);
	}
	//crea una tabla con los usuarios que tienes actualmente permiso sobre el radicado.
	if($nivelExp==3)
	{
		$sql="select u.usua_nomb, d.depe_nomb, 
					case u.usua_codi 
					when 1 then 'Jefe' 
					else        'Normal'
					end as \"PERFIL\",
					u.usua_login 
			  from sgd_matriz_nivelexp m
			  join usuario u on u.usua_login=m.usua_login
			  join dependencia d on d.depe_codi=u.depe_codi
			  where m.sgd_exp_numero='$numExpediente'
			  order by 2,1";
		$rs3=$db->conn->Execute($sql);
		if($rs3 && !$rs3->EOF)
		{
			$usuariosNv= "<table width='100%' align='center' class='borde_tab' >
							<tr>
								<td class='titulos2'>Usuario</td>
								<td class='titulos2'>Dependencia</td>
								<td class='titulos2'>Perfil</td>
								<td class='titulos2'>Accion</td>
							</tr>";
			
			while(!$rs3->EOF)
		    {
		    	$usuariosNv .="   <tr>
		        	                  <td  class='listado2'>
		                              <font size=1>".
		                              $rs3->fields["USUA_NOMB"].
		                              "</font>
		                              </td>
		                              <td class='listado2'>&nbsp;
		                              <font size=1>".
		                                $rs3->fields["DEPE_NOMB"]." ".
		                              "</font>
		                             </td>
		                              <td  class='listado2'>&nbsp;
		                              <font size=1>".
		                                 $rs3->fields["PERFIL"]."&nbsp;
		                              </font>
		                              <td  align='center' class='listado2'>&nbsp;
		                              <font size=1>
		                    	   	  <a href=\"javascript:verUsuarios('$numExpediente',4,'".$rs3->fields["USUA_LOGIN"]."')\">Borrar</a>
		                       		  </font>
		                              </td>
		                           </tr>";
				$rs3->MoveNext();
		    }
		    $usuariosNv .="</table>";  
		}      
		
	}
	$queryUs = "select usua_nomb, usua_doc from usuario where depe_codi=$obj_exp->depCodi AND USUA_ESTA='1'	order by usua_nomb";
	$rsUs = $db->conn->Execute($queryUs);
	$slcUsu= $rsUs->GetMenu2("usuaDocExp", "$usuaDocExp", "0:-- Seleccione --", false,""," id='usuaDocExp' class='select'");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<link href="../estilos/orfeo.css" rel="stylesheet" type="text/css">
<!-- Author:  Bazillyo - bazillyo@yahoo.com - http://www.geocities.com/bazillyo/spiffy/calendar/ -->
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="javascript" src="../js/funciones.js"></script>
<script type="text/javascript" language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript" src="<?=$ruta_raiz; ?>/js/ajax.js"></script>
<script type="text/javascript" language="javascript">
var cal1 = new ctlSpiffyCalendarBox("cal1", "formulario", "fechaInicio", "btnDate1", "<?=substr($fechaInicio,0,10)?>", scBTNMODE_CUSTOMBLUE);
var cal2 = new ctlSpiffyCalendarBox("cal2", "formulario", "fechaCierre", "btnDate2", "<?=substr($fechaCierre,0,10)?>", scBTNMODE_CUSTOMBLUE);

function regresar()
{
	window.location.reload();
}

function activa()
{			
	document.getElementById('trDep').style.display='none';
	document.getElementById('trUsu').style.display='none';
	document.getElementById('trTblUsu').style.display='none';
	document.getElementById('tdFecCierre').style.display='none';
	if(document.getElementById('nivelExp').value==0)
	{
		document.getElementById('textos').innerHTML='<center>El Expediente ser&aacute; p&uacute;blico para cualquier usuario.</center>';
	}
	if(document.getElementById('nivelExp').value==1)
	{
		document.getElementById('textos').innerHTML='<center>Si selecciona Privado, La persona responsable del Expediente ser&aacute; la &uacute;nica que lo podr&aacute; ver.</center>';
	}
	if(document.getElementById('nivelExp').value==2)
	{
		document.getElementById('textos').innerHTML='<center>Si selecciona Dependencia, solo los usuarios de su Dependencia podr&aacute;n ver el Expediente.</center>';
	}
	if(document.getElementById('nivelExp').value==3)
	{
		document.getElementById('trDep').style.display='';
		document.getElementById('trTblUsu').style.display='';
		document.getElementById('textos').innerHTML='<center>Solo los usuarios que seleccione podr&aacute;n ver el Expediente.</center>';
	}
	if(document.getElementById('chkCierre').checked)
	{
		document.getElementById('tdFecCierre').style.display='';
	}
}

function valida()
{
	var band=true;
	var msg='';
		
	if(document.getElementById('slcTipo').value==1)
	{
		if(!document.getElementById('txtNombre').value)
		{
			msg +='Debe llenar el campo Nombre!\n';
	    	band =false;
		}
	}
	if(document.getElementById('chkCierre').checked)
	{
		fech1 = document.formulario.fechaInicio.value;
	    fech1 = parseInt(fech1.replace(/\//g, ""));
	    fech2 = document.formulario.fechaCierre.value;
	    fech2 = parseInt(fech2.replace(/\//g, ""));
	    if(fech1 > fech2)
	    {
	        alert("!La fecha inicial debe ser menor que la de Cierre!");
	        return false;
	    }
	}
	if(document.getElementById('nivelExp').value==3)
	{
		if(document.getElementById('selUsuPriv[]').selectedIndex==-1)
		{
			msg +='Debe seleccionar un Usuario especifico para la seguridad';
			band =false;
		}
	}
	if(!valMaxChars(document.getElementById('txt_asuExp'),300,30))
	{
		return false;
	}
	if(!band) alert(msg);
	return band;
}

function mayus(obj)
{
	 obj.value=obj.value.toUpperCase( );
}


/*****************************/

function verUsuarios(numExp,tip,login)
{
	if (xmlHttp)
	{
		obj = document.getElementById('selDepPriv');
  		var num =0;
  		var deps='';
  		var car='';
  		for (i=0; opt=obj.options[i];i++)
  		{
  			car = (num > 0) ? ',' : '';
    		if (opt.selected)
    		{
    			deps += car + obj.options[i].value;
    			num++;
    		}
  		}
		vl2    = encodeURIComponent(deps);
		numExp = encodeURIComponent(numExp);
		login  = encodeURIComponent(login);
		var tipo = "deps="+vl2+"&i="+tip+"&numExp="+numExp+"&login="+login;
		cache.push(tipo);
		// try to connect to the server
		try
		{
			// continue only if the XMLHttpRequest object isn't busy
			// and the cache is not empty
			if ((xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
				&& cache.length>0)
			{
				// get a new set of parameters from the cache
				var cacheEntry = cache.shift();
				// make a server request to validate the extracted data
				xmlHttp.open("POST", "../tx/cTxSeguridad.php", true);
				xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				
				xmlHttp.onreadystatechange = handleRequestStateChange;
				xmlHttp.send(tipo);
			}
		}
		catch (e)
		{
			// display an error when failing to connect to the server
			displayError(e.toString());
		}
	}
}
// function that displays an error message
function displayError($message)
{
	// ignore errors if showErrors is false
	if (showErrors)
	{
		// turn error displaying OffUsuario  	 
		showErrors = false;
		// display error message
		alert("Error encountered: \n" + $message);
		// retry validation after 10 seconds
		setTimeout("actualizarCarpetas();", 10000);
	}
}

// read server's response
function readResponse()
{
	// retrieve the server's response
	var response = xmlHttp.responseText;
	// server error?
	if (response.indexOf("ERRNO") >= 0
	|| response.indexOf("error:") >= 0
	|| response.length == 0)
	throw(response.length == 0 ? "Server error." : response);
	if(response.length>0)
	{
		if(response.substr(-1)=='3')
		{
			document.getElementById('trUsu').style.display='';
			document.getElementById('divUsu').innerHTML=response.substr(0, response.length-1);
		}
		if(response.substr(-1)=='4')
		{
			document.getElementById('divTblUsu').innerHTML=response.substr(0, response.length-1);
		}
	}
	//setTimeout("validate();", 500);
}

/****************************/
</script>
</head>
<body>
<div id="spiffycalendar" class="text"></div>
<script type="text/javascript" language="JavaScript" src="../js/wz_tooltip.js"></script>
<form action="<?php echo $_SERVER['PHP_SELF']."?numExpediente=".base64_encode($numExpediente.'%');?>" name="formulario" id="formulario" method="post">
<table border=1 width=100% align="center" class="borde_tab">
<tr bgcolor="#006699">
    <td class="titulos4" colspan="3">INFORMACI&Oacute;N DEL EXPEDIENTE <?=$numExpediente;?></td>
</tr>
<tr>

    <td class='titulos5' width='15%'>Nombre del Expediente</td>
    <td class='listado2' colspan='2'>
        <input  type="text" name="txtNombre" class="caja_text" id="txtNombre" size="100" maxlength="200" onchange="mayus(this)" onblur="mayus(this)" value="<?=$txtNombre?>">
    </td>
</tr>
<tr>
    <td class=titulos5 colspan="1" >Asunto del Expediente</td>
    <td class=listado2 colspan="2">
        <textarea name="txt_asuExp" id="txt_asuExp" class="tex_area" rows="2" cols="84" onchange="mayus(this)" onblur="mayus(this)"><?=$txt_asuExp?></textarea>
    </td>
</tr>
<tr>
	<td class=titulos5>Fecha de Inicio del Proceso.</TD>
	<td class=listado2>
		<script language="javascript">
			cal1.date = "<?=date('Y-m-d');?>";
			cal1.writeControl();
			cal1.dateFormat="yyyy-MM-dd";
		</script>
  	</td> 	
  	<td class=titulos5>Cerrar Expediente.&nbsp;&nbsp;&nbsp;<input  type='checkbox' name='chkCierre' id='chkCierre' value='on' <?=$chk?> onclick="activa();">
	 <span  id="tdFecCierre">Fecha Cierre
		<script language="javascript">
			cal2.date = "<?=date('Y-m-d');?>";
			cal2.writeControl();
			cal2.dateFormat="yyyy-MM-dd";
		</script> <font color="Red" size="2"><br>Antes de cerrar el Expediente recuerde actualizar  el No. de Folios de las carpetas</font>
		</span>
  	</td>
</tr>
<tr>
	<td class='titulos5'>Usuario Responsable del Proceso</td>
	<td class='listado2' colspan='2'><?=$slcUsu?></td>
</tr>
<tr>
	<td class='titulos5'>Seguridad</td>
	<td class='listado2' colspan="2">
	 <table width="100%">
	 	<tr >
			<td class='titulos5' >Nivel</td>
			<td class='listado5' ><?=$slcNivel?></td>
		</tr>
		<tr id='trDep'>
			<td class='titulos5'>Dependencia</td>
			<td class='listado5'><?=$selectDep?></td>
		</tr>
		<tr id="trUsu" style="display:none">
			<td class="titulos5" >Usuario</td>
			<td class=listado5 >
				<span id="divUsu">..</span>
			</td>
		</tr>
		<tr id="trTblUsu">
			<td class=listado5 colspan="2"><span id="divTblUsu"><?=$usuariosNv?></span></td>
		</tr>
		<tr>
			<td class=listado5 colspan="2"><span id="textos" ></span></td>
		</tr>
	  </table>
	 </td>
</tr>
<tr>
	<td colspan="3">
    <?php
	$idSerie = (int) substr($numExpediente, 7, 3);
    $idSSerie= (int) substr($numExpediente, 10, 2);
    $metadatosAmostrar = 'S';	//Tipo Documental
    $registrosAmostrar = 'E';  //Expedientes
    require "../listado_metadatos.php";
    ?>
    </td>
</tr>
<tr>
    <td class="listado2" height="25" align="center" colspan="3"><center><font size="3" color="Red"> <?=$msg?></font></center><br>
        <center>
        <input type="hidden" name="IdExp" id="IdExp" value="<?php print $txtExpediente; ?>">
        <input name='Grabar' type=submit class="botones_funcion" value="Grabar" onclick="return valida();" >&nbsp;&nbsp;&nbsp;
        <input name="cerrar" type="button" class="botones_funcion" id="envia22" onClick="opener.regresar(); window.close();" value=" Cerrar ">
        </center>
    </td>
</tr>
</table>
</form>
<script>setTimeout("activa()",0);</script>
</body>
</html>
