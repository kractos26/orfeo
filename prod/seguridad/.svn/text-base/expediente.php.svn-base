<?
error_reporting(7); 
$krdold = $krd;
session_start(); 
$ruta_raiz = ".."; 	
if(!$krd) $krd = $krdold;
error_reporting(7);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
include_once "$ruta_raiz/include/tx/Historico.php";
if($grbNivel and $numeroExpediente)
{
	if($nivelExp==0)
	{
		$query = "UPDATE SGD_SEXP_SECEXPEDIENTES SET SGD_SEXP_NIVELSEG=$nivelExp where SGD_EXP_NUMERO='$numeroExpediente'";
		$observa = "Expediente Publico.";
		$borrarTodo=true;
	}
	else
	if($nivelExp==1){
		$query = "UPDATE SGD_SEXP_SECEXPEDIENTES SET SGD_SEXP_NIVELSEG=$nivelExp where SGD_EXP_NUMERO='$numeroExpediente'";
		$observa = "Expediente Confidencial(Privado: Visible solo Usuario Actual)";
		$borrarTodo=true;
	}
	if($nivelExp==2){
		$query = "UPDATE SGD_SEXP_SECEXPEDIENTES SET SGD_SEXP_NIVELSEG=$nivelExp where SGD_EXP_NUMERO='$numeroExpediente'";
		$observa = "Expediente Confidencial(Dependencia: Visible solo Usuarios de la dependencia que asign&oacute; confidencialidad)";
		$borrarTodo=true;
	}
	if($nivelExp==3){
		$query = "UPDATE SGD_SEXP_SECEXPEDIENTES SET SGD_SEXP_NIVELSEG=$nivelExp where SGD_EXP_NUMERO='$numeroExpediente'";
		$observa = "Expediente Confidencial(Visible solo Usuario(s) Espec&iacute;fico(s))";
		foreach ($selUsuPriv as $login)
		{
			$insertUsuarios="insert into sgd_matriz_nivelexp (sgd_exp_numero, usua_login) values('$numeroExpediente','$login')";
			$rsIns=$db->conn->Execute($insertUsuarios);
		}
	}
	if($db->conn->Execute($query))
	{
		$mensaje_err= "<span class=leidos>El nivel de seguridad se actualiz&oacute; correctamente.";
		include_once "$ruta_raiz/include/tx/Historico.php";
		$codiRegH = "";
		$Historico = new Historico($db);
		$codiRegE[0] = "null";		  
		$radiModi = $radiModi = $Historico->insertarHistoricoExp($numeroExpediente,$codiRegE , $dependencia, $codusuario, $observa, 64, 0);
	}else 
	{
		echo "<span class=titulosError> !No se pudo actualizar el nivel de seguridad!";
	}
}

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
$rs = $db->conn->Execute($sql);
$selectDep= $rs->GetMenu2('selDepPriv[]',$usDefault,false,true,3," id='selDepPriv' class='select' onChange=\"verUsuarios('$numeroExpediente');\" ");

//Se borra usuario
if($borrar)
{
	$sqlDel="delete from sgd_matriz_nivelexp where usua_login='$borrar' and sgd_exp_numero='$numeroExpediente'";
	$rs1=$db->conn->Execute($sqlDel);
}

//borra todos los usuarios del radicado
if($borrarTodo)
{
	$sqlDel="delete from sgd_matriz_nivelexp where sgd_exp_numero='$numeroExpediente'";
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
		  where m.sgd_exp_numero='$numeroExpediente'
		  order by 2,1";
	$rs3=$db->conn->Execute($sql);
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
                    	   	  <a href='expediente.php?borrar=".$rs3->fields["USUA_LOGIN"]."&numeroExpediente=$numeroExpediente&nivelExp=$nivelExp'>Borrar</a>
                       		  </font>
                              </td>
                           </tr>";
		$rs3->MoveNext();
    }
    $usuariosNv .="</table>";        
	
}
?>
<html>
<head>
<title>Niveles de Seguridad</title>
<link href="../estilos/orfeo.css" rel="stylesheet" type="text/css">
<script language="javascript" src="<?=$ruta_raiz; ?>/js/ajax.js"></script>
<script>

function regresar(){   	
	document.TipoDocu.submit();
}

function verUsuarios(numExp)
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
		var tipo = "deps="+vl2+"&i=3&numExp="+numExp;
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
		// turn error displaying Off
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
		document.getElementById('trUsu').style.display='';
		document.getElementById('divUsu').innerHTML=response;
	}
	//setTimeout("validate();", 500);
}

function activa()
{
	document.getElementById('trDep').style.display='none';
	document.getElementById('trUsu').style.display='none';
	document.getElementById('trTblUsu').style.display='none';
	if(document.getElementById('nivelExp').value==0)
	{
		document.getElementById('textos').innerHTML='<center>El documento ser&aacute; p&uacute;blico para cualquier usuario.</center>';
	}
	if(document.getElementById('nivelExp').value==1)
	{
		document.getElementById('textos').innerHTML='<center>Si selecciona Privado, La persona que posea en la actualidad el Radicado ser&aacute; la &uacute;nica que lo podr&aacute; ver.</center>';
	}
	if(document.getElementById('nivelExp').value==2)
	{
		document.getElementById('textos').innerHTML='<center>Si selecciona Dependencia, solo los usuarios de su Dependencia podr&aacute;n ver el Radicado.</center>';
	}
	if(document.getElementById('nivelExp').value==3)
	{
		document.getElementById('trDep').style.display='';
		document.getElementById('trTblUsu').style.display='';
		document.getElementById('textos').innerHTML='<center>Solo los usuarios que seleccione podr&aacute;n ver el radicado.</center>';
	}
	
}
function valida()
{
	if(document.getElementById('nivelExp').value==3)
	{
		if(!document.getElementById('selUsuPriv[]'))
		{
			alert('Debe seleccionar un Usuario especifico');
			return false
		}
		else if(document.getElementById('selUsuPriv[]').selectedIndex==-1)
		{
			alert('Debe seleccionar un Usuario especifico');
			return false
		}
	}
}
setTimeout("activa()",0);
</script>
</head>
<body bgcolor="#FFFFFF">
<form method="post" action="expediente.php?krd=<?=$krd?>&numeroExpediente=<?=$numeroExpediente?>" name="TipoDocu">
<table border=0 width=100% align="center" class="borde_tab" cellspacing="0">
<tr align="center" class="titulos2">
	<td height="15" class="titulos2" colspan="2" >NIVEL DE SEGURIDAD DEL EXPEDIENTE No. <?=$numeroExpediente?></td>
</tr>
<tr >
	<td class="titulos5" >Nivel</td>
	<td class=listado5 >
		<?=$slcNivel?>
	</td>
</tr>
<tr id="trDep">
	<td class="titulos5" >Dependencia</td>
	<td class=listado5 >
		<?=$selectDep?>
	</td>
</tr>
<tr id="trUsu" style="display:none">
	<td class="titulos5" >Usuario</td>
	<td class=listado5 >
		<span id="divUsu">..</span>
	</td>
</tr>
<tr id="trTblUsu">
	<td class=listado5 colspan="2">
	<?=$usuariosNv?>	
	</td>
</tr>
<tr>
	<td class=listado5 colspan="2">
	<span id="textos" >
		
	</span>
	</td>
</tr>
<tr  align="center">
	<td class=listado5  align="left" colspan="2">
		<center>
		<input type="submit" class="botones" name=grbNivel onclick="return valida();" value="Grabar Nivel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="Cerrar" type="button" class="botones" id="envia22" onClick="opener.regresar(); window.close();"value="Cerrar">
		</center>
	</td>
</tr>
<tr>
	<td class="titulos5" colspan="2" >
		<center>
			<?=$mensaje_err?>
		</center>
	</td>
</tr>
</table>
</form>
</body>
</html>