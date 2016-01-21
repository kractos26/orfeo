<?php
/* Administrador de medios de soporte en archivo.
 * 
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.0
 * @author Grupo Iyunxi Ltda.
 *
 */
session_start();
$ruta_raiz = "../..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include($ADODB_PATH.'/adodb.inc.php');	// $ADODB_PATH configurada en config.php
$error = 0;
$conn = &NewADOConnection("$driver");
$conn->charSet = 'utf8';
$conn->Connect($servidor,$usuario,$contrasena,$db);
//$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
//$conn = NewADOConnection($dsn);
if ($conn)
{	$conn->SetFetchMode(ADODB_FETCH_ASSOC);
	//$conn->debug=true;
	include("$ruta_raiz/include/class/medioSoporteArchivo.class.php");
	$obj_tmp = new medioSoporte($conn);

	if (isset($_POST['btn_accion']))
	{	switch($_POST['btn_accion'])
		{	Case 'Agregar':
			{
                $ok = $obj_tmp->SetInsDatos(array('txtCodId'=>$_POST['txtCodId'], 'txtModelo' => $_POST['txtModelo'], 'slcEstado' => $_POST['slcEstado'], 'txtSigla' => $_POST['txtSigla']));
				$ok ? $error = 3 : $error = 2;
			}break;
			Case 'Modificar':
			{
                $ok = $obj_tmp->SetModDatos(array('txtCodId'=>$_POST['txtCodId'], 'txtModelo' => $_POST['txtModelo'], 'slcEstado' => $_POST['slcEstado'], 'txtSigla' => $_POST['txtSigla']));
				$ok ? $error = 4 : $error = 2;
			}break;
			Case 'Eliminar':
			{
				$ok = $obj_tmp->SetDelDatos($_POST['slc_cmb2']);
				($ok == 0) ? $error = 5 : (($ok) ? $error = null : $error = 2);
			}break;
			Default: break;
		}
		unset($record);
	}
    $atributos="Onchange=Actual();";
	$slc_tmp = $obj_tmp->Get_ComboOpc(true,true,false,$atributos);
	$vec_tmp = $obj_tmp->Get_ArrayDatos();
}
else
{	$error = 1;
}

/*
*	Funcion que convierte un valor de PHP a un valor Javascript.
*/
function valueToJsValue($value, $encoding = false)
{	if (!is_numeric($value))
	{	$value = str_replace('\\', '\\\\', $value);
		$value = str_replace('"', '\"', $value);
		$value = '"'.$value.'"';
	}
	if ($encoding)
	{	switch ($encoding)
		{	case 'utf8' :	return iconv("ISO-8859-2", "UTF-8", $value);
							break;
		}
	}
	else
	{	return $value;	}
	return ;
}

/*
*	Funcion que convierte un vector de PHP a un vector Javascript.
*	Utiliza a su vez la funcion valueToJsValue.
*/
function arrayToJsArray( $array, $name, $nl = "\n", $encoding = false )
{	if (is_array($array))
	{	$jsArray = $name . ' = new Array();'.$nl;
		foreach($array as $key => $value)
		{	switch (gettype($value))
			{	case 'unknown type':
				case 'resource':
				case 'object':	break;
				case 'array':	$jsArray .= arrayToJsArray($value,$name.'['.valueToJsValue($key, $encoding).']', $nl);
								break;
				case 'NULL':	$jsArray .= $name.'['.valueToJsValue($key,$encoding).'] = null;'.$nl;
								break;
				case 'boolean':	$jsArray .= $name.'['.valueToJsValue($key,$encoding).'] = '.($value ? 'true' : 'false').';'.$nl;
								break;
				case 'string':	$jsArray .= $name.'['.valueToJsValue($key,$encoding).'] = '.valueToJsValue($value, $encoding).';'.$nl;
								break;
				case 'double':
				case 'integer':	$jsArray .= $name.'['.valueToJsValue($key,$encoding).'] = '.$value.';'.$nl;
								break;
				default:	trigger_error('Hoppa, egy j t�us a PHP-ben?'.__CLASS__.'::'.__FUNCTION__.'()!', E_USER_WARNING);
			}
		}
		return $jsArray;
	}
	else
	{	return false;	}
}
if ($error)
{	$msg = '<tr bordercolor="#FFFFFF">
			<td  align="center" class="titulosError" colspan="5" bgcolor="#FFFFFF">';
	switch ($error)
	{	case 1:	//NO CONECCION A BD
				$msg .= "Error al conectar a BD, comun&iacute;quese con el Administrador de sistema !!";
				break;
		case 2:	//ERROR EJECUCCION SQL
				$msg .=  "Error al gestionar datos, comun&iacute;quese con el Administrador de sistema !!";
				break;
		case 3:	//INSERCION REALIZADA
				$msg .=  "Creaci&oacute;n exitosa!";break;
		case 4:	//MODIFICACION REALIZADA
				$msg .=  "Registro actualizado satisfactoriamente!!";break;
		case 5:	//IMPOSIBILIDAD DE ELIMINAR REGISTRO
				$msg .=  "No se puede eliminar registro, tiene dependencias internas relacionadas.";break;
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
    var Obj = document.getElementById('slc_cmb2');
    var i = Obj.selectedIndex;
    if (parseInt(Obj.value) == 0)
    {
        document.getElementById('txtModelo').value = '';
        document.getElementById('txtCodId').value = '';
        document.getElementById('txtSigla').value = '';
        document.getElementById('slcEstado').value = '';
    }
    else
    {   //alert(Obj.value);
        for (x=0; x < vt.length; x++)
        {
            if (vt[x]['ID'] == Obj.value) break;
        }
        document.getElementById('txtModelo').value = vt[x]['NOMBRE'];
        document.getElementById('txtCodId').value = vt[x]['ID'];
        document.getElementById('txtSigla').value = vt[x]['SIGLA'];
        document.getElementById('slcEstado').value = vt[x]['ESTADO'];
    }
}

function rightTrim(sString)
{	while (sString.substring(sString.length-1, sString.length) == ' ')
	{	sString = sString.substring(0,sString.length-1);  }
	return sString;
}

function ver_listado()
{
	window.open('listados.php?var=msa','','scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,location=no,status=no');
}

<?php
echo arrayToJsArray($vec_tmp, 'vt');
?>
//-->
</script>

<title>.: Orfeo :. Admor de Medios de Soporte en Archivo.</title>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
</head>
<body>
<form name="form1" method="post" action="<?= $_SERVER['PHP_SELF']?>">
<input type="hidden" name="hdBandera" value="">
<table width="75%" border="1" align="center" cellspacing="0" class="tablas">
<tr bordercolor="#FFFFFF">
	<td colspan="5" height="40" align="center" class="titulos4" valign="middle"><b><span class=etexto>ADMINISTRADOR DE MEDIOS SOPORTE</span></b></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="center" class="titulos2"><b>1.</b></td>
	<td align="left" class="titulos2"><b>&nbsp;Soporte: </b></td>
    <td colspan="3" align="left" class="listado2">
		<?=$slc_tmp	?>
	</td>
</tr>
<tr bordercolor="#FFFFFF">
	<td rowspan="3" valign="middle" class="titulos2">2.</td>
	<td align="left" class="titulos2"><b>&nbsp;C&oacute;digo&nbsp;:</b></td>
	<td class="listado2"><input name="txtCodId" id="txtCodId" type="text" size=5" maxlength="2"></td>
    <td align="left" class="titulos2"><b>&nbsp;Sigla&nbsp;:</b></td>
	<td class="listado2"><input name="txtSigla" id="txtSigla" type="text" size="3" maxlength="3"></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>&nbsp;Nombre&nbsp;:</b></td>
	<td colspan="3" class="listado2"><input name="txtModelo" id="txtModelo" type="text" size="50" maxlength="30"></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>&nbsp;Estado&nbsp;:</b></td>
	<td colspan="3" class="listado2">
        <select class="select" name="slcEstado" id="slcEstado">
        <option value="">&lt;&lt;SELECCIONE&gt;&gt;</option>
        <option value="1">Activa</option>
        <option value="0">Inactiva</option>
        </select>
    </td>
</tr>
<?php
	echo $msg;
?>
</table>
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" class="tablas">
<tr bordercolor="#FFFFFF">
	<td width="10%" class="listado2">&nbsp;</td>
	<td width="20%"  class="listado2">
		<span class="e_texto1"><center>
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
function ValidarInformacion(opc)
{	var strMensaje = "Por favor ingrese las datos.";
    var bandOK = true;
	if ( rightTrim(document.form1.txtCodId.value) <= "0")
	{	strMensaje = strMensaje + "\nDebe ingresar el C\xf3digo." ;
		document.form1.txtCodId.focus();
		bandOK = false;
	}
	else if(isNaN(document.form1.txtCodId.value))
	{	strMensaje = strMensaje + "\nEl C\xf3digo debe ser num\xe9rico.";
		document.form1.txtCodId.select();
		document.form1.txtCodId.focus();
		bandOK = false;
	}

	if (opc == "Agregar")
	{	if(rightTrim(document.form1.txtModelo.value) == "")
		{	strMensaje = strMensaje + "\nDebe ingresar Nombre del medio de soporte.";
			document.form1.txtModelo.focus();
			bandOK = false;
		}
        if(rightTrim(document.form1.txtSigla.value) == "")
		{	strMensaje = strMensaje + "\nDebe ingresar Sigla del medio de soporte.";
			document.form1.txtSigla.focus();
			bandOK = false;
		}
		if (document.form1.slcEstado.value=='')
        {   strMensaje = strMensaje + "\nDebe seleccionar Estado.";
            document.form1.slcEstado.focus();
            bandOK = false;
        }
	}
	else if(opc == "Modificar")
	{
        if(rightTrim(document.form1.txtModelo.value) == "")
		{	strMensaje = strMensaje + "\nDebe ingresar Nombre del medio de soporte.";
			document.form1.txtModelo.focus();
			bandOK = false;
		}
        if(rightTrim(document.form1.txtSigla.value) == "")
		{	strMensaje = strMensaje + "\nDebe ingresar Sigla del medio de soporte.";
			document.form1.txtSigla.focus();
			bandOK = false;
		}
        if (document.form1.slcEstado.value=='')
        {   strMensaje = strMensaje + "\nDebe seleccionar Estado.";
            document.form1.slcEstado.focus();
            bandOK = false;
        }
		else if(parseInt(document.form1.txtCodId.value) != parseInt(document.form1.slc_cmb2.value))
		{
			strMensaje = strMensaje + "\nNo se puede modificar el C\xf3digo.'";
			document.form1.txtCodId.focus();
			bandOK = false;
		}
		else
		{	document.form1.submit();
		}
	}
	else if(document.form1.hdBandera.value == "E")
	{	if(confirm("Esta seguro de borrar este registro ?\n"))
		{	document.form1.submit();	}
		else
		{	return false;	}
	}

    if (!bandOK)
    {
        alert(strMensaje);
        return bandOK;
    }
}
//-->
</script>
</body>
</html>
