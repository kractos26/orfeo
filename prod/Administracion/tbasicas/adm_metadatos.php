<?php
/* Administrador de Etiquetas que enlazan con Radicados.
 * 
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.0
 * @author Grupo Iyunxi Ltda.
 *
 */
session_start();
if (!($_SESSION['usua_admin_sistema']==1 || $_SESSION['usua_perm_trd']==1 )) {
    die("No tiene permisoso");
}
$ruta_raiz = "../..";
include($ruta_raiz . '/config.php');    // incluir configuracion.
if (!defined('ADODB_ASSOC_CASE'))
    define('ADODB_ASSOC_CASE', 1);
include($ADODB_PATH . '/adodb.inc.php'); // $ADODB_PATH configurada en config.php
$error = 0;
$dsn = $driver . "://" . $usuario . ":" . $contrasena . "@" . $servidor . "/" . $db;
$conn = NewADOConnection($dsn);

if (isset($_POST['rbtn_tipometa'])) {
	$id_srdDefa = ($_POST['slc_srd']) ? $_POST['slc_srd'] : 0;
	$id_sbrdDefa = $_POST['slc_sbrd'];
	$id_tdocDefa = $_POST['slc_tdoc'];
	
	if ($_POST['rbtn_tipometa']=='S'){
		$srdCheck = " checked ";
		$tdoCheck = "";
		$deshab_tdoc = " disabled ";
	} else {
		$srdCheck = "";
		$tdoCheck = " checked ";
	}
} else {
	$id_srdDefa = 0;
	$id_sbrdDefa = 0;
	$id_tdocDefa = '';
	$srdCheck = "";
	$tdoCheck = "";
	$deshab_tdoc = "";
}
$listMetadatos = null;

if ($conn) {
    $conn->SetFetchMode(ADODB_FETCH_ASSOC);
    //$conn->debug=true;
    require("$ruta_raiz/include/class/metadatos.class.php");
    $obj_tmp = new etiquetas($conn);

    if (isset($_POST['btn_accion'])) {
        switch ($_POST['btn_accion']) {
            Case 'Agregar': {
                    $ok = $obj_tmp->SetInsDatos(array('txtId' => $_POST['txtId'], 'txtModelo' => $_POST['txtModelo'],
                                'slcEstado' => $_POST['slcEstado'], 'txtDescrip' => $_POST['txtDescrip'],
                    			'idSerie' => $_POST['slc_srd'], 'idSubserie' => $_POST['slc_sbrd'],
                    			'id_tipodoc' => $_POST['slc_tdoc']));
                    $ok ? $error = 3 : $error = 2;
                }break;
            Case 'Modificar': {
                    $ok = $obj_tmp->SetModDatos(array('txtId' => $_POST['txtId'], 'txtModelo' => $_POST['txtModelo'],
                                'slcEstado' => $_POST['slcEstado'], 'txtDescrip' => $_POST['txtDescrip'],
                                'idSerie' => $_POST['slc_srd'], 'idSubserie' => $_POST['slc_sbrd'],
                    			'id_tipodoc' => $_POST['slc_tdoc']));
                    $ok ? $error = 4 : $error = 2;
                }break;
            Case 'Eliminar': {
                    $ok = $obj_tmp->SetDelDatos($_POST['txtId']);
                    ($ok == 0) ? $error = 5 : (($ok) ? $error = 6 : $error = 2);
                }break;
            Default: break;
        }
        unset($record);
    }
    
    $sql = "SELECT SGD_SRD_DESCRIP, SGD_SRD_CODIGO FROM SGD_SRD_SERIESRD ORDER BY SGD_SRD_DESCRIP";
    $rs = $conn->Execute($sql);
    $slc_srd = $rs->GetMenu2('slc_srd', $id_srdDefa, "0:&gt; Seleccione SERIE &lt;", false, 0, "class='selec' id='slc_srd' onchange='this.form.submit()'");

    $ADODB_COUNTRECS = true;
    $sql = "SELECT SGD_SBRD_DESCRIP, SGD_SBRD_CODIGO FROM SGD_SBRD_SUBSERIERD WHERE SGD_SRD_CODIGO=$id_srdDefa ORDER BY SGD_SBRD_DESCRIP ";
    $rss = $conn->Execute($sql);
    $slc_sbrd = $rss->GetMenu2('slc_sbrd', $id_sbrdDefa, ":", false, 0, "class='selec' id='slc_sbrd' onchange='this.form.submit()'");

    $sql = "SELECT SGD_TPR_DESCRIP, SGD_TPR_CODIGO FROM SGD_TPR_TPDCUMENTO ORDER BY SGD_TPR_DESCRIP";
    $rst = $conn->Execute($sql);
    $slc_tdoc = $rst->GetMenu2('slc_tdoc', $id_tdocDefa, ":", false, 0, " $deshab_tdoc class='selec' id='slc_tdoc' onchange='this.form.submit()'");
    $ADODB_COUNTRECS = false;

    if (isset($_POST['slc_tdoc']) || ((isset($_POST['slc_sbrd']) && (int)($_POST['slc_sbrd'])>0 ))){
    	if (isset($_POST['slc_tdoc'])) {
    		$listMetadatos = $obj_tmp->Get_ArrayDatos(" WHERE SGD_TPR_CODIGO=".$_POST['slc_tdoc']);
    	} else { 
			$listMetadatos = $obj_tmp->Get_ArrayDatos(" WHERE SGD_SRD_CODIGO=".$_POST['slc_srd']." AND SGD_SBRD_CODIGO=".$_POST['slc_sbrd']);
    	}
    	$tabla_mtd = "<br/><table align='center' width='85%' width='1' class='border_tab'>";
    	if (is_null($listMetadatos)) {
    		$tabla_mtd .= "<tr><td>No hay registros coincidentes.</td></tr>";
    	}
    	else {
    			//$tabla_mtd .= "<tr class=titulos3><td>ID</td><td>NOMBRE</td><td>DESCRIPCION</td><td>ESTADO</td><td>OBLIGATIORIO</td><td>OPCIONES</td><tr>";
    			$tabla_mtd .= "<tr class=titulos3><td>ID</td><td>NOMBRE</td><td>DESCRIPCION</td><td>ESTADO</td><td>OPCIONES</td><tr>";
    		foreach ($listMetadatos as $mtd) {
    			$tabla_mtd .= "<tr class='listado1'>";
  				$tabla_mtd .=	"<td width='10%'>".$mtd['ID']."</td>".
  								"<td width='30%'>".$mtd['NOMBRE']."</td>".
    							"<td width='40%'>".$mtd['DESCRIP']."</td>".
    							"<td width='10%'>".$mtd['ESTADO']."</td>".
    							//"<td>".$mtd['OBLIGATORIO']."</td>".
  								"<td width='10%'>&nbsp;<input type='button' onClick='Actual(".$mtd['ID'].")' value='Cargar' class='botones_funcion'>&nbsp;</td>";
    			$tabla_mtd .= "</tr>";
    		}
    	}
    	$tabla_mtd .= "</table>";
    }

    $slc_etq = $obj_tmp->Get_ComboOpc(true, false);
    $vec_tmp = $obj_tmp->Get_ArrayDatos($cond);
    
} else {
    $error = 1;
}

/*
 * 	Funcion que convierte un valor de PHP a un valor Javascript.
 */

function valueToJsValue($value, $encoding = false) {
    if (!is_numeric($value)) {
        $value = str_replace('\\', '\\\\', $value);
        $value = str_replace('"', '\"', $value);
        $value = '"' . $value . '"';
    }
    if ($encoding) {
        switch ($encoding) {
            case 'utf8' : return iconv("ISO-8859-2", "UTF-8", $value);
                break;
        }
    } else {
        return $value;
    }
    return;
}

/*
 * 	Funcion que convierte un vector de PHP a un vector Javascript.
 * 	Utiliza a su vez la funcion valueToJsValue.
 */

function arrayToJsArray($array, $name, $nl = "\n", $encoding = false) {
    if (is_array($array)) {
        $jsArray = $name . ' = new Array();' . $nl;
        foreach ($array as $key => $value) {
            switch (gettype($value)) {
                case 'unknown type':
                case 'resource':
                case 'object': break;
                case 'array': $jsArray .= arrayToJsArray($value, $name . '[' . valueToJsValue($key, $encoding) . ']', $nl);
                    break;
                case 'NULL': $jsArray .= $name . '[' . valueToJsValue($key, $encoding) . '] = null;' . $nl;
                    break;
                case 'boolean': $jsArray .= $name . '[' . valueToJsValue($key, $encoding) . '] = ' . ($value ? 'true' : 'false') . ';' . $nl;
                    break;
                case 'string': $jsArray .= $name . '[' . valueToJsValue($key, $encoding) . '] = ' . valueToJsValue($value, $encoding) . ';' . $nl;
                    break;
                case 'double':
                case 'integer': $jsArray .= $name . '[' . valueToJsValue($key, $encoding) . '] = ' . $value . ';' . $nl;
                    break;
                default: trigger_error('Hoppa, egy j t�us a PHP-ben?' . __CLASS__ . '::' . __FUNCTION__ . '()!', E_USER_WARNING);
            }
        }
        return $jsArray;
    } else {
        return false;
    }
}

if ($error) {
    $msg = '<tr bordercolor="#FFFFFF">
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
    switch ($error) {
        case 1: //NO CONECCION A BD
            $msg .= "Error al conectar a BD, comun&iacute;quese con el Administrador de sistema !!";
            break;
        case 2: //ERROR EJECUCCION SQL
            $msg .= "Error al gestionar datos, comun&iacute;quese con el Administrador de sistema !!";
            break;
        case 3: //INSERCION REALIZADA
            $msg .= "Creaci&oacute;n exitosa!";
            break;
        case 4: //MODIFICACION REALIZADA
            $msg .= "Registro actualizado satisfactoriamente!!";
            break;
        case 5: //IMPOSIBILIDAD DE ELIMINAR REGISTRO
            $msg .= "No se puede eliminar registro, tiene dependencias internas relacionadas.";
            break;
        case 6: //ELIMINAR REGISTRO
            $msg .= "Eliminaci&oacute;n exitosa!";
            break;
    }
    $msg .= '</td></tr>';
}
?>
<html>
    <head>
        <script type="text/javascript" language="JavaScript">
            <!--
            function Actual(val)
            {
                //var Obj = document.getElementById('slc_etq2');
                //var i = Obj.selectedIndex;
                if (val == 0)
                {
                    document.getElementById('txtModelo').value = '';
                    document.getElementById('txtId').value = '';
                    document.getElementById('slcEstado').value = '';
                    document.getElementById('txtDescrip').value = '';
                }
                else
                {   //alert(Obj.value);
                    for (x=0; x < vt.length; x++)
                    {
                        if (vt[x]['ID'] == val) break;
                    }
                    document.getElementById('txtModelo').value = vt[x]['NOMBRE'];
                    document.getElementById('txtId').value = vt[x]['ID'];
                    document.getElementById('slcEstado').value = vt[x]['ESTADO'];
                    document.getElementById('txtDescrip').value = vt[x]['DESCRIP'];
                }
            }

            function rightTrim(sString)
            {	while (sString.substring(sString.length-1, sString.length) == ' ')
                {	sString = sString.substring(0,sString.length-1);  }
                return sString;
            }

            function ver_listado()
            {
                window.open('listados.php?var=mtd','','scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,location=no,status=no');
            }

            function habilita(valor) {
                if (valor=='T') {
                    document.getElementById('slc_srd').disabled = true;
                    document.getElementById('slc_sbrd').disabled = true;
                    document.getElementById('slc_tdoc').disabled = false;
                    document.getElementById('slc_srd').value = 0;
                    document.getElementById('slc_sbrd').value = '';
                } else {
                	document.getElementById('slc_srd').disabled = false;
                    document.getElementById('slc_sbrd').disabled = false;
                    document.getElementById('slc_tdoc').disabled = true;
                    document.getElementById('slc_tdoc').value = '';
                }
            }
<?php
echo arrayToJsArray($vec_tmp, 'vt');
?>
    //-->
        </script>

        <title>.: Orfeo :. Admor de Metadatos.</title>
        <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
    </head>
    <body>
        <form name="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="hdBandera" value="">
            <table width="75%" border="1" align="center" cellspacing="0" class="tablas">
                <tr bordercolor="#FFFFFF">
                    <td colspan="3" height="40" align="center" class="titulos4" valign="middle"><b><span class=etexto>ADMINISTRADOR DE METADATOS</span></b></td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td align="center" class="titulos2"><b>1.</b></td>
                    <td align="left" class="titulos2"><b>&nbsp;Seleccione su aplicabilidad: </b></td>
                    <td align="left" class="listado2">
                        <input type="radio" name="rbtn_tipometa" value="S" <?php echo $srdCheck; ?> onClick="habilita(this.value)"> Subserie.
                        <input type="radio" name="rbtn_tipometa" value="T" <?php echo $tdoCheck; ?> onClick="habilita(this.value)">Tipo Documental.
                    </td>
                </tr>
                <tr bordercolor="#FFFFFF">
                	<td align="center" class="titulos2"><b>2a.</b></td>
                    <td align="left" class="titulos2"><b>&nbsp;Seleccione Serie y Subserie&nbsp;<br>:</b></td>
                    <td class="listado2">
                    	<?php echo $slc_srd . "<BR/>" . $slc_sbrd?>
                    </td>
                </tr>
                <tr bordercolor="#FFFFFF">
                <td align="center" class="titulos2"><b>2b.</b></td>
                    <td align="left" class="titulos2"><b>&nbsp;Seleccione Tipo Documental&nbsp;:</b></td>
                    <td class="listado2">
                    	<?php echo $slc_tdoc ?>
                    </td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td align="left" class="listado2" colspan="3">&nbsp;</td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td rowspan="4" valign="middle" class="titulos2">3.</td>
                    <td align="left" class="titulos2"><b>&nbsp;C&oacute;digo&nbsp;:</b></td>
                    <td class="listado2"><input name="txtId" id="txtId" type="text" size="10" maxlength="2"></td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td align="left" class="titulos2"><b>&nbsp;Nombre&nbsp;:</b></td>
                    <td class="listado2"><input name="txtModelo" id="txtModelo" type="text" size="32" maxlength="32"></td>
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
                    <td align="left" class="titulos2"><b>&nbsp;Descripci&oacute;n&nbsp;:</b></td>
                    <td class="listado2"><input name="txtDescrip" id="txtDescrip" type="text" size="50" maxlength="320"></td>
                </tr>
                <?php
                echo $msg;
                ?>
                <tr>
                    <td colspan="3">
                        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" class="tablas">
                            <tr bordercolor="#FFFFFF">
                                <td width="10%" class="listado2">&nbsp;</td>
                                <td width="20%"  class="listado2">
                                    <span class="e_texto1">
                                        <input name="btn_accion" type="button" class="botones" id="btn_accion" value="Listado" onClick="ver_listado();">
                                    </span>
                                </td>
                                <td width="20%" class="listado2">
                                    <span class="e_texto1">
                                        <input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Agregar" onClick="return ValidarInformacion(this.value);">
                                    </span>
                                </td>
                                <td width="20%" class="listado2">
                                    <span class="e_texto1">
                                        <input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Modificar" onClick="return ValidarInformacion(this.value);">
                                    </span>
                                </td>
                                <td width="20%" class="listado2">
                                    <span class="e_texto1">
                                        <input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Eliminar" onClick="return ValidarInformacion(this.value);">
                                    </span>
                                </td>
                                <td width="10%" class="listado2">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <?php if (!is_null($listMetadatos)) echo $tabla_mtd;?>
        </form>

        <script type="text/javascript" LANGUAGE="JavaScript">
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
                    {	strMensaje = strMensaje + "\nDebe ingresar Nombre del Metadato.";
						document.form1.txtModelo.focus();
						bandOK = false;
                    }
                    if(rightTrim(document.form1.txtDescrip.value) == "")
                    {	strMensaje = strMensaje + "\nDebe ingresar Descripci\xf3n del Metadato.";
						document.form1.txtDescrip.focus();
						bandOK = false;
                    }
                    if (document.form1.slcEstado.value=='')
                    {   strMensaje = strMensaje + "\nDebe seleccionar Estado.";
                        document.form1.slcEstado.focus();
                        bandOK = false;
                    }
                    if ( !(document.form1.rbtn_tipometa[0].checked || document.form1.rbtn_tipometa[1].checked))
                    {
                    	strMensaje = strMensaje + "\nDebe seleccionar Tipo de metadato.";
                        document.form1.rbtn_tipometa[0].focus();
                        bandOK = false;
                    }
                    if ( document.form1.rbtn_tipometa[0].checked && (document.form1.slc_srd.value==0 || document.form1.slc_sbrd.value=='') )
                    {	strMensaje = strMensaje + "\nDebe seleccionar Serie y Subserie." ;
                    	document.form1.rbtn_tipometa[0].focus();
                        bandOK = false;
                    }
                    if ( document.form1.rbtn_tipometa[1].checked && document.form1.slc_tdoc.value=='' )
                    {	strMensaje = strMensaje + "\nDebe seleccionar Tipo Documental." ;
                    	document.form1.slc_tdoc.focus();
                        bandOK = false;
                    }
                }
                else if(opc == "Modificar")
                {
                    if(rightTrim(document.form1.txtModelo.value) == "")
                    {	strMensaje = strMensaje + "\nDebe ingresar Nombre del Metadato.";
						document.form1.txtModelo.focus();
						bandOK = false;
                    }
                    if(rightTrim(document.form1.txtDescrip.value) == "")
                    {	strMensaje = strMensaje + "\nDebe ingresar Descripci\xf3n del Metadato.";
						document.form1.txtDescrip.focus();
						bandOK = false;
                    }
                    if (document.form1.slcEstado.value=='')
                    {   strMensaje = strMensaje + "\nDebe seleccionar Estado.";
                        document.form1.slcEstado.focus();
                        bandOK = false;
                    }
                    if ( !(document.form1.rbtn_tipometa[0].checked || document.form1.rbtn_tipometa[1].checked))
                    {
                    	strMensaje = strMensaje + "\nDebe seleccionar Tipo de metadato.";
                        document.form1.rbtn_tipometa[0].focus();
                        bandOK = false;
                    }
                    if ( document.form1.rbtn_tipometa[0].checked && (document.form1.slc_srd.value==0 || document.form1.slc_sbrd.value=='') )
                    {	strMensaje = strMensaje + "\nDebe seleccionar Serie y Subserie." ;
                    	document.form1.rbtn_tipometa[0].focus();
                        bandOK = false;
                    }
                    if ( document.form1.rbtn_tipometa[1].checked && document.form1.slc_tdoc.value=='' )
                    {	strMensaje = strMensaje + "\nDebe seleccionar Tipo Documental." ;
                    	document.form1.slc_tdoc.focus();
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
                else if(opc == "Eliminar")
                {	if (bandOK) {
                    	if(confirm("Esta seguro de borrar este registro ?\n"))
                    	{	document.form1.submit();	}
                    	else
                    	{	return false;	}
                	}
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
