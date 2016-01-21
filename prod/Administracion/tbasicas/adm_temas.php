<?php
/*  Administrador de Tablas sencillas.
*	Son tablas que tienen un codigo (digitado) y una descripción. P.E. : Tema, Resolución.
*	Creado por: Ing. Hollman Ladino Paredes.
*	Para el proyecto ORFEO.
*
*	Permite la administración de paises. La inserción y modificación hace uso de la funcion
*	Replace de ADODB, la eliminación está sujeta a que éste NUNCA haya sido referenciado en radicados.
*/
session_start();
$ruta_raiz="../..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
include($ADODB_PATH.'/adodb.inc.php');	// $ADODB_PATH configurada en config.php
$error = 0;
$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
$conn = NewADOConnection($dsn);
//$conn->debug=true;
if ($conn)
{	$conn->SetFetchMode(ADODB_FETCH_ASSOC);

	if (isset($_POST['btn_accion']))
	{	$record = array();
		switch($_POST['btn_accion'])
		{	Case 'Agregar':
				{
					
					$record['SGD_TMA_DESCRIP'] = $_POST['txtModelo'];
					$record['SGD_TMA_CODIGO'] = $conn->GenId('SEC_TMA_CODIGO');
                    $sec_tmd_temadepe=$conn->GenId('SEC_TMD_TEMADEPE');
                    $cnt=0;
                    $conn->BeginTrans();
					$ok = $conn->Replace('SGD_TMA_TEMAS',$record,'SGD_TMA_CODIGO',$autoquote = true);
					foreach ($_POST['slc_idep'] as $dep)
					{   if($cnt >0)$sec_tmd_temadepe=$conn->GenId('SEC_TMD_TEMADEPE');
						$ok2 = $conn->Replace('SGD_TMD_TEMADEPE',
												array(  'ID'=>$sec_tmd_temadepe,
														'SGD_TMA_CODIGO'=>$record['SGD_TMA_CODIGO'],
														'DEPE_CODI'=>$dep),
												array('SGD_TMA_CODIGO','DEPE_CODI'),$autoquote = true);
						if ($ok2 === false) break;
                        $cnt++;
					}
					if ($ok && $ok2)
					{	
						($ok == 1 ? $error = 3 : $error = 4 );
						$conn->CommitTrans();
					}
					else 
					{
						$error = 2;
						$conn->RollbackTrans();
					}
				}break;
			Case 'Modificar':
				{	$conn->BeginTrans();
																			
					//Buscamos las que existen y con esas validamos, las que falten las insertamos y las que sobren las borramos.
					$sql="DELETE FROM SGD_TMD_TEMADEPE WHERE SGD_TMA_CODIGO=".$_POST['idt'];
					$ok = $conn->Execute($sql);
					foreach ($_POST['slc_idep'] as $dep)
					{
						$id_tmp = $conn->GenId('SEC_TMD_TEMADEPE');
						$ok2 = $conn->Execute('INSERT INTO SGD_TMD_TEMADEPE (ID,SGD_TMA_CODIGO,DEPE_CODI) VALUES ('.$id_tmp.','.$_POST['idt'].','.$dep.')');
						if ($ok2 === false) break;
					}
					//unset($record_tmp);
					
					$record['SGD_TMA_CODIGO'] = $_POST['idt'];
					$record['SGD_TMA_DESCRIP'] = $_POST['txtModelo'];
					$ok3 = $conn->Replace('SGD_TMA_TEMAS',$record,'SGD_TMA_CODIGO',$autoquote = true);
					
					if ($ok && $ok2 && $ok3)
					{	
						$error = 3;
						$conn->CommitTrans();
					}
					else
					{
						$error = 2;
						$conn->RollbackTrans();
					}
				}break;
			Case 'Eliminar':
				{	$ADODB_COUNTRECS = true;
					$sql = "SELECT * FROM RADICADO WHERE SGD_TMA_CODIGO = ".$_POST['idt'];
					$rs = $conn->Execute($sql);
					$ADODB_COUNTRECS = false;
					if ($rs->RecordCount() > 0)
					{	$error = 5;	}
					else 
					{	$conn->BeginTrans();
						$ok = $conn->Execute('DELETE FROM SGD_TMD_TEMADEPE WHERE SGD_TMA_CODIGO='.$_POST['idt']);
						if ($ok)
						{	$ok = $conn->Execute('DELETE FROM SGD_TMA_TEMAS WHERE SGD_TMA_CODIGO='.$_POST['idt']);
						}
						if ($ok)
						{	$conn->CommitTrans();
							unset($_POST['idt']);
						}
						else
						{
							$error = 2;
							$conn->RollbackTrans() ;
				}	}	}break;
			Default: break;
		}
		unset($record);
	}
	
	if ($_POST['idt']>0)
	{	$sql = "SELECT DEPE_CODI FROM SGD_TMD_TEMADEPE WHERE SGD_TMA_CODIGO=".$_POST['idt'];
		$vec_dep = $conn->GetCol($sql);
		if ($vec_dep === false) $error = 2;
		else
		{
			$sql="SELECT SGD_TMA_DESCRIP FROM SGD_TMA_TEMAS WHERE SGD_TMA_CODIGO=".$_POST['idt'];
			$descr = $conn->GetOne($sql);
			if ($descr === false) $error = 2;
		}
	}
	
	$sql = "SELECT SGD_TMA_DESCRIP as DESCR, SGD_TMA_CODIGO as Id FROM SGD_TMA_TEMAS ORDER BY SGD_TMA_DESCRIP";
	$Rs_tma1 = $conn->Execute($sql);
	if (!($Rs_tma1)) $error = 2;
	else
	{
		$slc_tma = $Rs_tma1->GetMenu2('idt',$_POST['idt'],":&lt;&lt;SELECCIONE&gt;&gt;",false,0,"class='select' onChange=\"this.form.submit()\"");
	    $Rs_tma1->Close();
	    unset($Rs_tma1);
	}
	
	$sql = "SELECT DEPE_NOMB, DEPE_CODI FROM DEPENDENCIA WHERE DEPE_ESTADO=1 ORDER BY DEPE_NOMB ";
	$Rs_dep = $conn->Execute($sql);
	if (!($Rs_dep)) $error = 2;
	else 
	{
		$slc_dep = $Rs_dep->GetMenu2('slc_idep[]',$vec_dep,false,true,25,"id='slc_idep'");
	}
}
else
{	$error = 1;
}

if ($error)
{	$msg = '<tr bordercolor="#FFFFFF"> 
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
	switch ($error)
	{	case 1:	//NO CONECCION A BD
				$msg .= "Error al conectar a BD, comun&iacute;quese con el Administrador de sistema !!";
				break;
		case 2:	//ERROR EJECUCCI�N SQL
				$msg .=  "Error al gestionar datos, comun&iacute;quese con el Administrador de sistema !!";
				break;
		case 3:	//ACUTALIZACION REALIZADA
				$msg .=  "Informaci&oacute;n actualizada!!";break;
		case 4:	//INSERCION REALIZADA
				$msg .=  "Tema creado satisfactoriamente!!";break;
		case 5:	//IMPOSIBILIDAD DE ELIMINAR PAIS, EST� LIGADO CON DIRECCIONES
				$msg .=  "No se puede eliminar Tema, se encuentra ligado a regitros.";break;
	}
	$msg .=  '</td></tr>';
}
?>
<html>
<head>
<script language="JavaScript">
<!--
function Actual()
{
var Obj = document.getElementById('idpais');
var i = Obj.selectedIndex;
document.getElementById('txtModelo').value = Obj.options[i].text;
document.getElementById('txtIdPais').value = Obj.value;
}

function rightTrim(sString)
{	while (sString.substring(sString.length-1, sString.length) == ' ')
	{	sString = sString.substring(0,sString.length-1);  }
	return sString;
}

function ver_listado()
{
	window.open('listados.php?var=tma','','scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,location=no,status=no');
}
//-->
</script>

<title>Orfeo - Admor de Tablas Tem&aacute;ticas.</title>
<script language="JavaScript" src="<?=$ruta_raiz ?>/js/formchek.js"></script>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
<form name="formSeleccion" id="formSeleccion" method="post" action="<?= $_SERVER['PHP_SELF']?>">  
<input type="hidden" name="hdBandera" value="">
<table width="75%" border="1" align="center" cellspacing="0" class="tablas">
<tr bordercolor="#FFFFFF">
	<td colspan="3" height="40" align="center" class="titulos4" valign="middle"><b><span class=etexto>ADMINISTRADOR DE TABLAS TEM&Aacute;TICAS</span></b></td>
</tr>
<tr bordercolor="#FFFFFF"> 
	<td width="3%" align="center" class="titulos2"><b>1.</b></td>
	<td width="25%" align="left" class="titulos2"><b>&nbsp;Seleccione Tema</b>
	</td>
	<td width="72%" class="listado2" colspan="3">
	<?=$slc_tma	?>
	</td>
</tr>
<tr bordercolor="#FFFFFF"> 
	<td rowspan="2" valign="middle" class="titulos2">2.</td>
	<td align="left" class="titulos2"><b>&nbsp;Ingrese Nombre</b></td>
	<td class="listado2">
		<input name="txtModelo" id="txtModelo" type="text" size="50" maxlength="30" value="<?=$descr?>">
	</td>
</tr>
<tr bordercolor="#FFFFFF"> 
	<td align="left" class="titulos2">
		<b>&nbsp;Seleccione dependencias</b><br />
		<font color="White"> Para seleccionar varias presione la tecla &lt;CTRL&gt; y seleccione las dependencias</font>
	</td>
	<td class="listado2" colspan="3"><?=$slc_dep?></td>
</tr>
<?=$msg?>
</table>
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" class="tablas">
<tr bordercolor="#FFFFFF">
	<td width="10%" class="listado2">&nbsp;</td>
	<td width="20%"  class="listado2">
		<span class="celdaGris"> <span class="e_texto1"><center>
		<input name="btn_accion" type="button" class="botones" id="btn_accion" value="Listado" onClick="ver_listado();">
		</center></span>
	</td>
	<td width="20%" class="listado2">
		<span class="e_texto1"><center>
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Agregar" onClick="return ValidarInformacion(this.value);">
		</center></span>
	</td>
	<td width="20%" class="listado2">
		<span class="e_texto1"><center>
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Modificar" onClick="return ValidarInformacion(this.value);">
		</center></span>
	</td>
	<td width="20%" class="listado2">
		<span class="e_texto1"><center>
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Eliminar" onClick="return ValidarInformacion(this.value);">
		</center></span>
	</td>
	<td width="10%" class="listado2">&nbsp;</td>
</tr>
</table>
</form>

<script ID="clientEventHandlersJS" LANGUAGE="JavaScript">
<!--
function ValidarInformacion(accion)
{		
	if ((accion == 'Agregar') || (accion =='Modificar'))
	{	if (stripWhitespace(document.formSeleccion.txtModelo.value) == '')
		{
			alert('Digite el nombre del Tema');
			document.formSeleccion.txtModelo.focus();
			return false;
		}
		
		var resultado = ""
		for (var i = 0; i < document.formSeleccion.slc_idep.length; i++)
		{	// un for para recorrer todo la lista
			if (document.formSeleccion.slc_idep.options[i].selected)
			{	// nos fijamos si cada elemento está seleccionado
				//resultado = resultado + "\n - " + form.lista.options[i].text // armamos una variable que le vamos agregando los elementos seleccionados
				resultado += 1;
			}
		}
		if (resultado==0)
		{	alert("Debe seleccionar por lo menos una dependencia"); // mostramos todos los ídem seleccionados
			return false;
		}
	}

	if (accion =='Eliminar')
	{
		if (document.formSeleccion.idt.value == '')
		{
			alert("Debe seleccionar el tema a eliminar");
			return false;
		}
		else
		{
			a = window.confirm('Está seguro de eliminar el registro ?');
			if (a==true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
}
//-->
</script>
</body>
</html>