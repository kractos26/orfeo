<?php
/*  Administrador de Detalles de Causal.
*   @author Ing. Hollman Ladino Paredes.
*   @copyright  => NADIE is GPL  ;)
*
*   Permite la administración de sub-causaless. La inserción y modificación hace uso de la funcion
*   Replace de ADODB, la eliminacion está sujeta a que éste NUNCA haya sido referenciado en radicados.
*/

include('../../config.php'); 		// incluir configuracion.
if (!defined('ADODB_ASSOC_CASE'))   define('ADODB_ASSOC_CASE', 1);
include($ADODB_PATH.'/adodb.inc.php');	// $ADODB_PATH configurada en config.php
$error = 0;
$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
$conn = NewADOConnection($dsn);


session_start();
$ADODB_COUNTRECS = false;

$ruta_raiz = "../..";
include_once($ruta_raiz.'/config.php'); 			// incluir configuracion.
include_once($ruta_raiz."/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");	
$conn = $db->conn;
if ($conn) {
    $conn->SetFetchMode(ADODB_FETCH_ASSOC);
    if (isset($_POST['btn_accion'])) {
        $record = array();
        $record['SGD_DCAU_CODIGO'] = $_POST['txtIdDcau'];
        $record['SGD_CAU_CODIGO'] = $_POST['idcau'];
        $record['SGD_DCAU_DESCRIP'] = $_POST['txtModelo'];
        $record['SGD_DCAU_ESTADO'] = $_POST['Slc_act'];
        switch($_POST['btn_accion']) {
            Case 'Agregar':
            Case 'Modificar': {
                    $res = $conn->Replace('SGD_DCAU_CAUSAL',$record,array('SGD_CAU_CODIGO','SGD_DCAU_CODIGO'),$autoquote = true);
                    ($res) ? ($res == 1 ? $error = 3 : $error = 4 ) : $error = 2;
                }break;
            Case 'Eliminar': {
                    $ADODB_COUNTRECS = true;
                    $sql = "SELECT * FROM SGD_CAUX_CAUSALES WHERE SGD_DCAU_CODIGO = ".$record['SGD_DCAU_CODIGO'];
                    $rs = $conn->Execute($sql);
                    $ADODB_COUNTRECS = false;
                    if ($rs->RecordCount() > 0) {	$error = 5;	}
                    else {
                        $conn->BeginTrans();
                        $ok = $conn->Execute('DELETE FROM SGD_DCAU_CAUSAL WHERE SGD_DCAU_CODIGO=?',$record['SGD_DCAU_CODIGO']);
                        ($ok) ? $conn->CommitTrans() : $conn->RollbackTrans() ;
                    }
                }break;
            Default: break;
        }
        unset($record);
    }

    $sql_cau = "SELECT SGD_CAU_DESCRIP ,SGD_CAU_CODIGO FROM SGD_CAU_CAUSAL ORDER BY SGD_CAU_DESCRIP";
    $Rs_cau = $conn->Execute($sql_cau); 	//Query en cache por 24 horas.
    if (!($Rs_cau)) $error = 2;

    if (isset($_POST['idcau']) and $_POST['idcau'] >=0) {
        $sql_dcau = "SELECT SGD_DCAU_DESCRIP, SGD_DCAU_CODIGO FROM SGD_DCAU_CAUSAL WHERE SGD_CAU_CODIGO=".$_POST['idcau']." ORDER BY SGD_DCAU_DESCRIP";
        $Rs_dcau = $conn->Execute($sql_dcau);
        if (!($Rs_dcau)) $error = 2;
    }

    if ($_POST['idcau'] >0 and $_POST['iddcau'] >0) {
        $sql_dcau = "SELECT SGD_DCAU_DESCRIP, SGD_DCAU_CODIGO, SGD_DCAU_ESTADO FROM SGD_DCAU_CAUSAL
        			WHERE SGD_CAU_CODIGO=".$_POST['idcau']." AND SGD_DCAU_CODIGO=".$_POST['iddcau'];
        $Rs_dcau2 = $conn->Execute($sql_dcau);
        if (!($Rs_dcau2)) $error = 2;
        $desc_defa = $Rs_dcau2->fields['SGD_DCAU_DESCRIP'];
        $esta_defa = $Rs_dcau2->fields['SGD_DCAU_ESTADO'];
        $id_defa = $Rs_dcau2->fields['SGD_DCAU_CODIGO'];
    }
}
else {
    $error = 1;
}
?>
<html>
    <head>
        <script type="text/JavaScript" language="JavaScript">
            <!--
            function rightTrim(sString)
            {	while (sString.substring(sString.length-1, sString.length) == ' ')
                {	sString = sString.substring(0,sString.length-1);  }
                return sString;
            }

            function ver_listado()
            {
                window.open('listados.php?var=detcau','','scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,location=no,status=no');
            }
            //-->
        </script>

        <title>Orfeo - Admor de Detalles Causal.</title>
        <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
    </head>
    <body>
        <form name="form1" method="post" action="<?= $_SERVER['PHP_SELF']?>">
            <input type="hidden" name="hdBandera" value="">
            <table width="75%" border="1" align="center" cellspacing="0" class="tablas">
                <tr bordercolor="#FFFFFF">
                    <td colspan="3" height="40" align="center" class="titulos4" valign="middle"><b><span class=etexto>ADMINISTRADOR DE DETALLES CAUSAL</span></b></td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td width="3%" align="center" class="titulos2"><b>1.</b></td>
                    <td width="25%" align="left" class="titulos2"><b>&nbsp;Seleccione Causal</b></td>
                    <td width="72%" class="listado2">
                        <?php	// Listamos los causales.
                        echo $Rs_cau->GetMenu2('idcau',$_POST['idcau'],":&lt;&lt;SELECCIONE&gt;&gt;",false,0,"id='idcau' class='select' onChange=\"this.form.submit()\"");
                        $Rs_cau->Close();
                        ?>	</td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td align="center" class="titulos2"><b>2.</b></td>
                    <td align="left" class="titulos2"><b>&nbsp;Seleccione Detalle Causal</b></td>
                    <td align="left" class="listado2">
                        <?php
                        if (isset($_POST['idcau']) and $_POST['idcau'] >= 0) {	// Listamos los paises segun continente.
                            echo $Rs_dcau->GetMenu2('iddcau',$_POST['iddcau'],":&lt;&lt;SELECCIONE&gt;&gt;",false,0,"class='select' id=\"iddcau\" onChange=\"this.form.submit()\" ");
                            $Rs_dcau->Close();
                        }
                        else {	echo "<select name='iddcau' id='iddcau' class='select' ><option value='' selected>&lt;&lt; Seleccione CAUSAL &gt;&gt;</option></select>";
                        }
                        ?></td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td rowspan="3" valign="middle" class="titulos2">3.</td>
                    <td align="left" class="titulos2"><b>&nbsp;Ingrese c&oacute;digo del Detalle</b></td>
                    <td class="listado2"><input name="txtIdDcau" id="txtIdDcau" type="text" size="10" maxlength="3" value="<? echo $id_defa; ?>"></td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td align="left" class="titulos2"><b>&nbsp;Ingrese Descripci&oacute;n</b></td>
                    <td class="listado2"><input name="txtModelo" id="txtModelo" type="text" size="50" maxlength="30" value="<? echo $desc_defa; ?>"></td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td align="left" class="titulos2"><b>&nbsp;Escoja Estado</b></td>
                    <td class="listado2">
                        <select name="Slc_act" id="Slc_act" class="select">
                            <option value="1" <?php echo ($esta_defa==1)? "selected": "" ?>>Activa</option>
                            <option value="0" <?php echo ($esta_defa==0)? "selected": "" ?>>Inactiva</option>
                        </select>
                    </td>
                </tr>
                <tr bordercolor="#FFFFFF">
                    <td width="3%" align="justify" class="info" colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <?php
                if ($error) {	echo '<tr bordercolor="#FFFFFF">
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
                    switch ($error) {	case 1:	//NO CONECCION A BD
                            echo "Error al conectar a BD, comuníquese con el Administrador de sistema !!";
                            break;
                        case 2:	//ERROR EJECUCCI�N SQL
                            echo "Error al gestionar datos, comuníquese con el Administrador de sistema !!";
                            break;
                        case 3:	//ACUTALIZACION REALIZADA
                            echo "Información actualizada!!";break;
                        case 4:	//INSERCION REALIZADA
                            echo "Registro creado satisfactoriamente!!";break;
                        case 5:	//IMPOSIBILIDAD DE ELIMINAR PAIS, EST� LIGADO CON DIRECCIONES
                            echo "No se puede eliminar registro, se encuentra ligado a históricos.";break;
                    }
                    echo '</td></tr>';
                }
                ?>
            </table>
            <table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" class="tablas">
                <tr bordercolor="#FFFFFF">
                    <td width="10%" class="listado2">&nbsp;</td>
                    <td width="20%"  class="listado2">
                        <span class="celdaGris"> <span class="e_texto1">
                                <input name="btn_accion" type="button" class="botones" id="btn_accion" value="Listado" onClick="ver_listado();">
                        </span></span>
                    </td>
                    <td width="20%" class="listado2">
                        <span class="e_texto1">
                            <input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Agregar" onClick="document.form1.hdBandera.value='A'; return ValidarInformacion();">
                        </span>
                    </td>
                    <td width="20%" class="listado2">
                        <span class="e_texto1">
                            <input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Modificar" onClick="document.form1.hdBandera.value='M'; return ValidarInformacion();">
                        </span>
                    </td>
                    <td width="20%" class="listado2">
                        <span class="e_texto1">
                            <input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Eliminar" onClick="document.form1.hdBandera.value='E'; return ValidarInformacion();">
                        </span>
                    </td>
                    <td width="10%" class="listado2">&nbsp;</td>
                </tr>
            </table>
        </form>

        <script ID="clientEventHandlersJS" LANGUAGE="JavaScript">
            <!--
            function ValidarInformacion()
            {	var strMensaje = "Por favor ingrese las datos.";

                if (document.form1.idcau.value == "")
                {	alert("Debe seleccionar el Causal.\n" + strMensaje);
                    document.form1.idcau.focus();
                    return false;
                }

                if ( rightTrim(document.form1.txtIdDcau.value) <= "0")
                {	alert("Debe ingresar el Codigo del Detalle.\n" + strMensaje);
                    document.form1.txtIdDcau.focus();
                    return false;
                }
                else if(isNaN(document.form1.txtIdDcau.value))
                {	alert("El codigo del Detalle debe ser numerico.\n" + strMensaje);
                    document.form1.txtIdDcau.select();
                    document.form1.txtIdDcau.focus();
                    return false;
                }

                if (document.form1.hdBandera.value == "A")
                {	if(rightTrim(document.form1.txtModelo.value) == "")
                    {	alert("Debe ingresar descripcion del Detalle.\n" + strMensaje);
                        document.form1.txtModelo.focus();
                        return false;
                    }
                    else
                    {	document.form1.submit();
                    }
                }
                else if(document.form1.hdBandera.value == "M")
                {	if(rightTrim(document.form1.txtModelo.value) == "")
                    {	alert("Primero debe seleccionar el Detalle a modificar.\n" + strMensaje);
                        return false;
                    }
                    else
                    {	document.form1.submit();
                    }
                }
                else if(document.form1.hdBandera.value == "E")
                {	if(confirm("Esta seguro de borrar el registro ?\n"))
                    {	document.form1.submit();	}
                    else
                    {	return false;	}
                }
            }
            //-->
        </script>
    </body>
</html>