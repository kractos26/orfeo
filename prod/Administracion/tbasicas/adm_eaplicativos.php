<?php
/* Administrador de Aplicativos que enlazan con Orfeo.
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
$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
$conn = NewADOConnection($dsn);
if ($conn)
{	$conn->SetFetchMode(ADODB_FETCH_ASSOC);
        //$conn->debug=true;
	include($ruta_raiz.'/include/class/enlaceAplicativos.class.php');
	$obj_tmp = new enlaceAplicativos($conn);

	if (isset($_POST['btn_accion']))
	{	switch($_POST['btn_accion'])
		{	Case 'Agregar':
			{
                $ok = $obj_tmp->SetInsDatos(array('txtId'=>$_POST['txtId'], 'txtModelo' => $_POST['txtModelo'], 'slcEstado' => $_POST['slcEstado'],'slcDepe' => $_POST['slcDepe']));
				$ok ? $error = 3 : $error = 2;
			}break;
			Case 'Modificar':
			{
                $ok = $obj_tmp->SetModDatos(array('txtId'=>$_POST['txtId'], 'txtModelo' => $_POST['txtModelo'], 'slcEstado' => $_POST['slcEstado'],'slcDepe' => $_POST['slcDepe']));
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
	$slc_tmp = $obj_tmp->Get_ComboOpc(true,false);
    $sql = "SELECT D.DEPE_NOMB, D.DEPE_CODI FROM DEPENDENCIA D
            INNER JOIN USUARIO U ON D.DEPE_CODI = U.DEPE_CODI 
            WHERE U.USUA_CODI=1";
    $rs_depe = $conn->Execute($sql);
    $slc_depe = $rs_depe->GetMenu2('slcDepe',false,"0:&lt;&lt;SELECCIONE",false,false,'id="slcDepe" class="select"');
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
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
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
        document.getElementById('txtId').value = '';
        document.getElementById('slcEstado').value = '';
        document.getElementById('slcDepe').value = '';
    }
    else
    {   //alert(Obj.value);
        for (x=0; x < vt.length; x++)
        {
            if (vt[x]['ID'] == Obj.value) break;
        }
        document.getElementById('txtModelo').value = vt[x]['NOMBRE'];
        document.getElementById('txtId').value = vt[x]['ID'];
        document.getElementById('slcEstado').value = vt[x]['ESTADO'];
        document.getElementById('slcDepe').value = vt[x]['DEPENDENCIA'];
    }
}

function rightTrim(sString)
{	while (sString.substring(sString.length-1, sString.length) == ' ')
	{	sString = sString.substring(0,sString.length-1);  }
	return sString;
}

function ver_listado()
{
	window.open('listados.php?var=eap','','scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,location=no,status=no');
}

<?php
echo arrayToJsArray($vec_tmp, 'vt');
?>
//-->
</script>

<title>.: Orfeo :. Admor de Aplicativos enlace a Orfeo.</title>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
</head>
<body>
<form name="form1" method="post" action="<?= $_SERVER['PHP_SELF']?>">
<input type="hidden" name="hdBandera" value="">
<table width="75%" border="1" align="center" cellspacing="0" class="tablas">
<tr bordercolor="#FFFFFF">
	<td colspan="3" height="40" align="center" class="titulos4" valign="middle"><b><span class=etexto>ADMINISTRADOR DE APLICATIVOS ENLAZADOS A ORFEO</span></b></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="center" class="titulos2"><b>1.</b></td>
	<td align="left" class="titulos2"><b>&nbsp;Aplicativo: </b></td>
    <td align="left" class="listado2">
		<?=$slc_tmp	?>
	</td>
</tr>
<tr bordercolor="#FFFFFF">
	<td rowspan="4" valign="middle" class="titulos2">2.</td>
	<td align="left" class="titulos2"><b>&nbsp;C&oacute;digo&nbsp;:</b></td>
	<td class="listado2"><input name="txtId" id="txtId" type="text" size="10" maxlength="2"></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>&nbsp;Nombre&nbsp;:</b></td>
	<td class="listado2"><input name="txtModelo" id="txtModelo" type="text" size="50" maxlength="30"></td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>&nbsp;Estado&nbsp;:</b></td>
	<td class="listado2">
        <select class="select" name="slcEstado" id="slcEstado">
        <option value="">&lt;&lt;SELECCIONE&gt;&gt;</option>
        <option value="1">Activa</option>
        <option value="0">Inactiva</option>
        </select>
    </td>
</tr>
<tr bordercolor="#FFFFFF">
	<td align="left" class="titulos2"><b>&nbsp;Dependencia Responsable&nbsp;:</b></td>
	<td class="listado2">
        <?= $slc_depe ?>
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
	if ( rightTrim(document.form1.txtId.value) <= "0")
	{	strMensaje = strMensaje + "\nDebe ingresar el C\xf3digo." ;
		document.form1.txtId.focus();
		bandOK = false;
	}
	else if(isNaN(document.form1.txtId.value))
	{	strMensaje = strMensaje + "\nEl C\xf3digo debe ser num\xe9rico.";
		document.form1.txtId.select();
		document.form1.txtId.focus();
		bandOK = false;
	}

	if (opc == "Agregar")
	{	if(rightTrim(document.form1.txtModelo.value) == "")
		{	strMensaje = strMensaje + "\nDebe ingresar Nombre del aplicativo.";
			document.form1.txtModelo.focus();
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
		{	strMensaje = strMensaje + "\nDebe ingresar Nombre del aplicativo.";
			document.form1.txtModelo.focus();
			bandOK = false;
		}
        if (document.form1.slcEstado.value=='')
        {   strMensaje = strMensaje + "\nDebe seleccionar Estado.";
            document.form1.slcEstado.focus();
            bandOK = false;
        }
		else if(parseInt(document.form1.txtId.value) != parseInt(document.form1.slc_cmb2.value))
		{
			strMensaje = strMensaje + "\nNo se puede modificar el C\xf3digo.'";
			document.form1.txtId.focus();
			bandOK = false;
		}
		else
		{	document.form1.submit();
		}
	}
	else if(opc == "ELiminar")
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
