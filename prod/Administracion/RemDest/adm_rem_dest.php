<?php
/*  Administrador de Esp/Entidades (Bodega_Empresas).
 * 	Creado por: Ing. Hollman Ladino Paredes.
 * 	Para el proyecto ORFEO.
 *
 * 	Permite la administraci�n de esp. La inserci�n y modificaci�n hace uso de la funcion
 * 	Replace de ADODB, la eliminaci�n est� sujeta a que �ste NUNCA haya sido referenciado en sgd_dir_drecciones.
 * 
 *  @autor Ing. John Guerrero
 *  05-2012. Se realiza homologacion de este desarrollo para la administracion de ciudadanos
 */
session_start();
$ruta_raiz = "../..";

//if($_SESSION['usua_admin_sistema'] !=1 ) die(include "$ruta_raiz/errorAcceso.php");
if (!isset($krd)) $krd = $_SESSION['krd'];
$ruta_raiz = "../..";
if (!isset($_SESSION['dependencia']))
    include "$ruta_raiz/rec_session.php";
define('ADODB_ASSOC_CASE', 1);
require_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler($ruta_raiz);
$error = 0;

if ($db) {
    include_once($ruta_raiz . "/radicacion/crea_combos_universales.php");
    $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
    //$db->conn->debug=true;
    if (isset($_POST['btn_accion'])) {
        $record = array();
        $record['NUIR'] = $_POST['txt_nuir'];
        $record['NOMBRE_DE_LA_EMPRESA'] = mb_strtoupper(trim($_POST['txt_name']), ini_get('default_charset'));
        echo $_POST['txt_name'];
        $record['NIT_DE_LA_EMPRESA'] = mb_strtoupper(trim($_POST['txt_nit']), ini_get('default_charset'));
        $record['SIGLA_DE_LA_EMPRESA'] = $_POST['txt_sigla'];
        $record['DIRECCION'] = $_POST['txt_dir'];
        
        include_once("$ruta_raiz/class_control/Municipio.php");
        $tmp_mun = new Municipio($db);
        $tmp_mun->municipio_codigo($_POST['codep_us1'], $_POST['muni_us1']);
        $record['ID_CONT'] = $tmp_mun->get_cont_codi();
        $record['ID_PAIS'] = $tmp_mun->get_pais_codi();
        $record['CODIGO_DEL_DEPARTAMENTO'] = $tmp_mun->dpto_codi;
        $record['CODIGO_DEL_MUNICIPIO'] = $tmp_mun->muni_codi;

        $record['TELEFONO_1'] = $_POST['txt_tel1'];
        isset($_POST['txt_tel2']) ? $record['TELEFONO_2'] = $_POST['txt_tel2'] : $record['TELEFONO_2'] = null;
        $record['EMAIL'] = $_POST['txt_mail'];
        ($_POST['Slc_act'] == "S") ? $record['ACTIVA'] = 1 : $record['ACTIVA'] = 0;
        $record['ARE_ESP_SECUE'] = 8;
        $record['NOMBRE_REP_LEGAL'] = mb_strtoupper(trim($_POST['txt_namer']), ini_get('default_charset'));

        if ($_POST['btn_accion'] == 'Agregar')
            $record['IDENTIFICADOR_EMPRESA'] = $db->conn->nextId("SEC_BODEGA_EMPRESAS");
        if ($_POST['btn_accion'] == 'Modificar')
            $record['IDENTIFICADOR_EMPRESA'] = $_POST['sls_idesp'];
        if ($_POST['btn_accion'] == 'Eliminar')
            $record['IDENTIFICADOR_EMPRESA'] = $_POST['sls_idesp'];
        switch ($_POST['btn_accion']) {
            Case 'Agregar':
            Case 'Modificar': {
                echo "hola";
                    $res = $db->conn->Replace('SGD_CIU_CIUDADANO', $record, 'SGD_CIU_CODIGO', $autoquote = true);
                    echo $res;
                    $db->conn->debug =true;
                    ($res) ? ($res == 1 ? $error = 3 : $error = 4 ) : $error = 2;
                }break;
            Case 'Eliminar': {
                    $ADODB_COUNTRECS = true;
                    $sql = "SELECT * FROM SGD_DIR_DRECCIONES WHERE SGD_ESP_CODI = " . $record['IDENTIFICADOR_EMPRESA'];
                    $ok1 = $db->conn->Execute($sql);
                    $sql = "SELECT ctt_id FROM SGD_DEF_CONTACTOS WHERE ctt_id_tipo=0 AND ctt_id_empresa=" . $record['IDENTIFICADOR_EMPRESA'];
                    $ok2 = $db->conn->Execute($sql);
                    //// VALIDAR TAMBIEN CONTACTOS.
                    $ADODB_COUNTRECS = false;
                    if ($ok1->RecordCount() > 0 || $ok2->RecordCount() > 0) {
                        $error = 5;
                    } else {
                        $db->conn->BeginTrans();
                        $ok = $db->conn->Execute('DELETE FROM BODEGA_EMPRESAS WHERE IDENTIFICADOR_EMPRESA=' . $record['IDENTIFICADOR_EMPRESA']);
                        ($ok) ? $db->conn->CommitTrans() : $db->conn->RollbackTrans();
                    }
                }break;
            Default: break;
        }
        unset($record);
    }

    $sql_esp = "SELECT NOMBRE_DE_LA_EMPRESA, IDENTIFICADOR_EMPRESA, NIT_DE_LA_EMPRESA, SIGLA_DE_LA_EMPRESA, DIRECCION,ID_CONT, ID_PAIS, CODIGO_DEL_DEPARTAMENTO, CODIGO_DEL_MUNICIPIO, TELEFONO_1, TELEFONO_2, EMAIL,
				NOMBRE_REP_LEGAL, CARGO_REP_LEGAL, NUIR, ARE_ESP_SECUE, ACTIVA
				FROM BODEGA_EMPRESAS ORDER BY NOMBRE_DE_LA_EMPRESA";
    $sqlCiu = "SELECT
                    case 
                 WHEN sgd_ciu_act=0 THEN '[NoAct]'||' '||sgd_ciu_nombre||' '||sgd_ciu_apell1||' '||sgd_ciu_apell2  ELSE sgd_ciu_nombre||' '||sgd_ciu_apell1||' '||sgd_ciu_apell2 END,
                 sgd_ciu_codigo codigo
                 FROM sgd_ciu_ciudadano ORDER BY sgd_ciu_nombre  ";
    
    
    $sqlEnt = "SELECT 
        
case when sgd_oem_act=0
then '[NoAct]'||sgd_oem_oempresa ELSE sgd_oem_oempresa 
end as nombre, 
sgd_oem_codigo codigo
FROM sgd_oem_oempresas ORDER BY sgd_oem_oempresa  ";
   
   // $db->conn->debug=true;
    $RsCiu = $db->conn->Execute($sqlCiu);
    $RsEnt = $db->conn->Execute($sqlEnt);
    $Rs_esp = $db->conn->Execute($sql_esp);
    if (!($Rs_esp))
        $error = 2;
    else { //Creamos el vector que contiene todas las ESP con su respectiva informaci�n.
        $v_esp = array();
        while ($arr = $Rs_esp->fetchRow()) {
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['nombre'] = trim($arr['NOMBRE_DE_LA_EMPRESA']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['id'] = trim($arr['IDENTIFICADOR_EMPRESA']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['nit'] = trim($arr['NIT_DE_LA_EMPRESA']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['sigla'] = trim($arr['SIGLA_DE_LA_EMPRESA']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['dir'] = trim($arr['DIRECCION']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['activa'] = trim($arr['ACTIVA']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['id_cont'] = trim($arr['ID_CONT']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['id_pais'] = trim($arr['ID_PAIS']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['id_dpto'] = trim($arr['CODIGO_DEL_DEPARTAMENTO']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['id_muni'] = trim($arr['CODIGO_DEL_MUNICIPIO']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['tel1'] = trim($arr['TELEFONO_1']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['tel2'] = trim($arr['TELEFONO_2']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['mail'] = trim($arr['EMAIL']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['nuir'] = trim($arr['NUIR']);
            $v_esp[$arr['IDENTIFICADOR_EMPRESA']]['nombrer'] = trim($arr['NOMBRE_REP_LEGAL']);
        }
        $Rs_esp = $db->conn->Execute($sql_esp);
        reset($v_esp);
    }
} else {
    $error = 1;
}

if ($error) {
    $msg = '<tr bordercolor="#FFFFFF">
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
    switch ($error) {
        case 1: //NO CONECCION A BD
            $msg .= "Error al conectar a BD, comun?quese con el Administrador de sistema !!";
            break;
        case 2: //ERROR EJECUCCI?N SQL
            $msg .= "Error al gestionar datos, comun?quese con el Administrador de sistema !!";
            break;
        case 3: //ACUTALIZACION REALIZADA
            $msg .= "Informaci&oacute;n actualizada!!";
            break;
        case 4: //INSERCION REALIZADA
            $msg .= "Remitente / Tercero creado satisfactoriamente!!";
            break;
        case 5: //IMPOSIBILIDAD DE ELIMINAR ESP, TIENE HISTORIAL, EST? LIGADO CON DIRECCIONES
            $msg .= "No se puede eliminar Remitente / Tercero, se encuentra ligado a un radicado.";
            break;
    }
    $msg .= '</td></tr>';
}
?>
<html>
    <head>
        <script language="JavaScript" src="<?= $ruta_raiz ?>/js/formchek.js"></script>
        <script type="text/javascript" src="../../jquery/jquery-1.7.1.min.js"></script>
        <script language="JavaScript" type="text/JavaScript">
            function ver_listado(que)
            {
                window.open('listados.php?var=bge','','scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,location=no,status=no');
            }

            function validarinfo(form)
            {	for(i=0;i<form.length;i++)
                {	//alert(form.elements[i].name+'\n'+form.elements[i].type);
                    switch (form.elements[i].type)
                    {	case 'text':
                        case 'textarea':
                        case 'select-multiple':
                            {	if (rightTrim(form.elements[i].value) == '' && (form.elements[i].name == 'txt_name' || form.elements[i].name == 'txt_dir' ))
                                {	alert("Por favor complete todos los campos del registro");
                                    form.elements[i].focus();
                                    return false;
                                }
                                if ((form.elements[i].name == 'txt_id') && !(isPositiveInteger(form.elements[i].value, true)))
                                {	alert ("Digite cantidad numerica");
                                    form.elements[i].focus();
                                    return false;
                                }
                                if ((form.elements[i].name == 'txt_mail') && !(isEmail(form.elements[i].value, true)))
                                {	alert ("Digite correctamente el correo electronico");
                                    form.elements[i].focus();
                                    return false;
                                }
                            }break;
                        case 'checkbox':
                            {	alert(form.elements[i].checked);
                            }break;
                        case 'select-one':
                            {  	if (form.elements[i].name =='sls_idesp')
                                {	if ((form.hdBandera.value =='M' || form.hdBandera.value =='E') && (form.elements[i].value == 0))
                                    {
                                        alert('Seleccione primero la ESP');
                                        return false;
                                    }
                                }
                                else if (form.elements[i].value == '0')
                                {	alert("Por favor complete todos los campos del registro");
                                    form.elements[i].focus();
                                    return false;
                                }
                            }break;
                    }
                }
                alert("Listo!");
                //form.submit();
            }

            /*
             *	Funcion que se le envia el id del municipio en el formato general c-ppp-ddd-mmm y lo desgloza
             *	creando las variables en javascript para su uso individual, p.e. para los combos respectivos.
             */
            function crea_var_idlugar_defa(id_mcpio)
            {	if (id_mcpio == 0) return;
                var str = id_mcpio.split('-');
                // To enable
               // $('#idcont1').attr('disabled', false);
                // To enable
               // $('#idpais1').attr('disabled', false);
                // To enable
               // $('#codep_us1').attr('disabled', false);
                // To enable
               // $('#muni_us1').attr('disabled', false);
                
                document.form1.idcont1.value = str[0]*1;
                cambia(form1,'idpais1','idcont1');
                document.form1.idpais1.value = str[1]*1;
                cambia(form1,'codep_us1','idpais1');
                document.form1.codep_us1.value = str[1]*1+'-'+str[2]*1;
                cambia(form1,'muni_us1','codep_us1');
                document.form1.muni_us1.value = str[1]*1+'-'+str[2]*1+'-'+str[3]*1;
                
                // To disable
               // $('#idcont1').attr('disabled', true);
                // To disable
               // $('#idpais1').attr('disabled', true);
                // To disable
                //$('#codep_us1').attr('disabled', true);
                // To disable
               // $('#muni_us1').attr('disabled', true);
                
            }

            //            function actualiza_datos(form)
            //            {	if (form.sls_idesp.value>0)
            //                {	document.getElementById('txt_name').value = ve[form.sls_idesp.value]['nombre'];
            //                    document.getElementById('txt_nuir').value = ve[form.sls_idesp.value]['nuir'];
            //                    document.getElementById('txt_nit').value = ve[form.sls_idesp.value]['nit'];
            //                    document.getElementById('txt_sigla').value = ve[form.sls_idesp.value]['sigla'];
            //                    document.getElementById('txt_mail').value = ve[form.sls_idesp.value]['mail'];
            //                    document.getElementById('txt_tel1').value = ve[form.sls_idesp.value]['tel1'];
            //                    document.getElementById('txt_tel2').value = ve[form.sls_idesp.value]['tel2'];
            //                    document.getElementById('txt_dir').value = ve[form.sls_idesp.value]['dir'];
            //                    document.getElementById('txt_namer').value = ve[form.sls_idesp.value]['nombrer'];
            //                    if (ve[form.sls_idesp.value]['activa'] == 1)
            //                        document.getElementById('Slc_act').value = 'S';
            //                    else
            //                        document.getElementById('Slc_act').value = 'N';
            //                    crea_var_idlugar_defa(ve[form.sls_idesp.value]['id_cont']+'-'+ve[form.sls_idesp.value]['id_pais']+'-'+ve[form.sls_idesp.value]['id_dpto']+'-'+ve[form.sls_idesp.value]['id_muni']);
            //                }
            //                else
            //                {	document.getElementById('txt_name').value = '';
            //                    document.getElementById('txt_nuir').value = '';
            //                    document.getElementById('txt_nit').value = '';
            //                    document.getElementById('txt_sigla').value = '';
            //                    document.getElementById('txt_mail').value = '';
            //                    document.getElementById('txt_tel1').value = '';
            //                    document.getElementById('txt_tel2').value = '';
            //                    document.getElementById('Slc_act').value = '0';
            //                    document.getElementById('txt_dir').value = '';
            //                    document.getElementById('txt_namer').value = '';
            //                    crea_var_idlugar_defa(<?php //echo "'" . ($_SESSION['cod_local']) . "'";         ?>);
            //                }
            //            }

<?php
// Convertimos los vectores de los paises, dptos y municipios creados en crea_combos_universales.php a vectores en JavaScript.
echo arrayToJsArray($vpaisesv, 'vp');
echo arrayToJsArray($vdptosv, 'vd');
echo arrayToJsArray($vmcposv, 'vm');
echo arrayToJsArray($v_esp, 've');
?>
        </script>
        <script language="JavaScript" src="<?= $ruta_raiz ?>/js/crea_combos_2.js"></script>
       <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
        <title>.: ORFEO :. Administraci&oacute;n de ciudadanos y empresas</title>
    </head>
    <body onLoad="crea_var_idlugar_defa(<?php echo "'" . ($_SESSION['cod_local']) . "'"; ?>);">
        <table width="75%" align="center" border="1" cellspacing="0" class="tablas">
                <tr bordercolor="#FFFFFF">
                    <td colspan="6" height="40" class="titulos4" valign="middle" >Administraci&oacute;n de ciudadanos y empresas.</td>
                </tr>
            </table>
        <table border="1" cellpadding="0" cellspacing="0" align="center" width="75%">
                <tr bordercolor = "#FFFFFF">
                    <td width="5%" align="center" valign="middle" class="titulos2">1.</td>
                    <td width="20%" align="left" class="titulos2">Seleccione Ciudadano/Empresa</td>
                    <td class="listado2">&nbsp;
                        <select name="ModType" class="select"  id="ModType">
                            <option value="1">Ciudadanos</option>
                            <option value="2">Empresas</option>
                        </select>
                    </td>
                </tr>
            </table>
        <form name="form1" id="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" id="hdBandera" name="hdBandera" value="">
            <input type="hidden" id="krd" name="krd" value="<?= $krd ?>">
            
            
                <table border="1" cellpadding="0" cellspacing="0" align="center" width="75%">
                <tr bordercolor = "#FFFFFF">
                    <td width="5%" align="center" valign="middle" class="titulos2">2.</td>
                    <td width="20%" align="left" class="titulos2">Seleccione Remitentes / Terceros</td>
                    <td class="listado2">&nbsp;
                        <?php
                        echo $RsCiu->GetMenu2('sl_ciu', 0, "0:&lt;&lt; SELECCIONE &gt;&gt;", false, 0, "id=\"sl_ciu\" class=\"select\" ");
                        echo $RsEnt->GetMenu2('sl_ent', 0, "0:&lt;&lt; SELECCIONE &gt;&gt;", false, 0, "id=\"sl_ent\" class=\"select\" ");
                        /* echo $Rs_esp->GetMenu2('sls_idesp', 0, "0:&lt;&lt; SELECCIONE &gt;&gt;", false, 0, "id=\"sls_idesp\" class=\"select\" onchange=\"actualiza_datos(this.form)\"");
                          $Rs_esp->Close(); */
                        ?>
                    </td>
                </tr>
                <tr bordercolor = "#FFFFFF">
                    <td width="5%" align="center" valign="middle" class="titulos2">3.</td>
                    <td width="20%" align="left" class="titulos2">Mod. o Ingrese datos</td>
                    <td class="listado2">
                        <table border="1" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td colspan="2" align="center" valign="middle" class="titulos2">NOMBRE</td>
                                <td width="34%" align="center" valign="middle" class="titulos2"><div name="typeDoc"></div></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center" valign="middle"><input  class="tex_area" type="text" name="txt_name" id="txt_name" size="60" maxlength="160"></td>
                                <td width="34%" align="center" valign="bottom"><input  class="tex_area" type="text" name="txt_id" id="txt_id" maxlength="13" size="30"></td>
                            </tr>
                            <tr id="CiuSpc">                                
                                <td width="33%" align="center" valign="middle" class="titulos2">PRIMER APELLIDO</td>
                                <td width="33%" align="center" valign="middle" class="titulos2">SEGUNDO APELLIDO</td>
                                <td width="34%" align="center" valign="middle" class="titulos2">CORREO E.</td>
                            </tr>
                            <tr align="center" id="CiuSpc2">
                                <td width="33%"><input  class="tex_area" type="text" name="txt_apell1" id="txt_apell1" maxlength="50"></td>
                                <td width="33%"><input  class="tex_area" type="text" name="txt_apell2" id="txt_apell2" maxlength="50"></td>
                                <td width="34%" align="center" valign="bottom"><input  class="tex_area" type="text" name="txt_mail" id="txt_mail" maxlength="50" size="30"></td>
                            </tr>
                            <tr id="EntSpc">                                
                                <td width="33%" align="center" valign="middle" class="titulos2">SIGLA</td>
                                <td colspan="2" align="center" valign="middle" class="titulos2">REPRESENTANTE LEGAL</td>
                            </tr>
                            <tr id="EntSpc2">
                                <td width="34%" align="center" valign="bottom"><input  class="tex_area" type="text" name="txt_sig" id="txt_sig" maxlength="50" size="30"></td>
                                <td colspan="2" align="center" valign="middle"><input  class="tex_area" type="text" name="txt_rep" id="txt_rep" size="60" maxlength="160"></td>
                            </tr>
                            <tr>
                                <td width="33%" align="center" valign="middle" class="titulos2">TEL&Eacute;FONO</td>
                                <td width="33%" align="center" valign="middle" class="titulos2">Est&aacute; activa ?</td>
                                <td align="center" valign="middle" class="titulos2">C&Oacute;DIGO</td>

                            </tr>
                            <tr align="center">
                                <td width="33%"><input  class="tex_area" type="text" name="txt_tel" id="txt_tel" maxlength="50"></td>
                                <td width="33%">
                                    <select name="Slc_act" id="Slc_act" class="select">
                                        <option value="0">Seleccione</option>
                                        <option value="S"> S  I </option>
                                        <option value="N"> N  O </option>
                                    </select>
                                </td>
                                <td><input type="text" id="Codi" name="Codi" value="" size="20" readonly="readonly" /></td>

                            </tr>
                            <tr>
                                <td colspan="3" align="center" valign="middle" class="titulos2">Direcci&oacute;n Completa</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center" valign="middle">
                                    <input  class="tex_area" type="text" name="txt_dir" id="txt_dir" size="60" maxlength="160">
                                    <?php
                                    echo $Rs_Cont->GetMenu2('idcont1', 0, ":&lt;&lt; SELECCIONE &gt;&gt;", false, 0, "id=\"idcont1\" class=\"select\" onchange=\"cambia(this.form,'idpais1','idcont1')\"");
                                  // $Rs_Cont->Move(0);
                                    ?>
                                    &nbsp;
                                    <select name="idpais1" id="idpais1" class="select" onChange="cambia(this.form, 'codep_us1', 'idpais1')">
                                        <option value="0" selected>&lt;&lt; Seleccione Continente &gt;&gt;</option>
                                    </select>
                                    &nbsp;
                                    <select name='codep_us1' id ="codep_us1" class='select' onChange="cambia(this.form, 'muni_us1', 'codep_us1')" >
                                        <option value='0' selected>&lt;&lt; Seleccione Pa&iacute;s &gt;&gt;</option>
                                    </select>
                                    &nbsp;
                                    <select name='muni_us1' id="muni_us1" class='select' ><option value='0' selected>&lt;&lt; Seleccione Dpto &gt;&gt;</option></select>
                                </td>
                            </tr>
<!--                            <tr>
                                <td colspan="3" align="center" valign="middle" class="titulos2">REPRESENTANTE LEGAL</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center" valign="middle"><input class="tex_area" type="text" name="txt_namer" id="txt_namer" size="100" maxlength="160"></td>
                            </tr>-->
                        </table>
                    </td>
                </tr>
                <?php echo $msg; ?>
            </table>
            <table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" class="tablas">
                <tr bordercolor="#FFFFFF">
                    <td width="10%" class="listado2">&nbsp;</td>
                    <td width="20%"  class="listado2">
                       <span class="celdaGris"><center>
                              <!--  <input name="btn_accion" type="button" class="botones" id="btn_accion" value="Listado" onClick="ver_listado();"> -->
                        </center></span>	
                    </td>
                    <td width="20%" class="listado2">
                      <span class="e_texto1"><center>
                              <input name="btn_acciona" type="button" class="botones" id="btn_acciona" value="Agregar" onclick="PostInsDef()">
                              
                            </center></span>
                    </td>
                    <td width="20%" class="listado2">
                        <span class="e_texto1"><center>
                                <input name="btn_accion" type="button" class="botones" id="btn_accion" value="Modificar" onclick="PostModDef()">
                            </center></span>	
                    </td>
                    <td width="20%" class="listado2">
                       <span class="e_texto1"><center>
                                <input name="btn_accione" type="button" class="botones" id="btn_accione" value="Eliminar" onClick="PostDelDef()" >
                            </center></span>	
                    </td>
                    <td width="10%" class="listado2">&nbsp;</td>
                </tr>
            </table>
            <script type="text/javascript" src="CiuEntFunctions.js"></script>
            <script type="text/javascript">
                $(window).load(checkType());
                $('select[name="ModType"]').change(function(){
                    checkType();
                });
               $("#ModType").change(function(){
                           
                      $('#idcont1 > option[value="1"]').attr('selected', 'selected');
                      var getNuevoCombo2="<option value='170'>COLOMBIA</option>";
                 $("#idpais1").append(getNuevoCombo2);
                
                $('#idpais1 > option[value="170"]').attr('selected', 'selected');
                $('#idpais1 > option[value="170"]').attr('selected', 'selected');
                var getNuevoCombo1="<option value='170-11'>D.C</option>";
                 $("#codep_us1").append(getNuevoCombo1);
                $('#codep_us1 > option[value="170-11"]').attr('selected', 'selected');
                var getNuevoCombo="<option value='170-11-1'>BOGOTA</option>";
                 $("#muni_us1").append(getNuevoCombo);
                 $('#muni_us1 > option[value="170-11-1"]').attr('selected', 'selected');
                });
                $("#sl_ciu").change(function(){
                          
                         PostMod();
                  
                    
                });
                $("#sl_ent").change(function(){
               
                PostMod();
                
                 
                });
                
                function checkType(){
                    $("#txt_name").val('');
                    $("#txt_dir").val('');
                    $("#txt_id").val('');
                    $("#txt_tel").val('');
                    
                    if($('select[name="ModType"]').val()==1){
                        $("#sl_ciu").show();
                        $("#sl_ent").val(0).hide();
                        $('div[name="typeDoc"]').html(" C.C ");
                        $("#txt_sig").val('');
                        $("#txt_rep").val('');
                        $("#CiuSpc").show();
                        $("#CiuSpc2").show();
                        $("#EntSpc").hide();
                        $("#EntSpc2").hide();
                    }else{
                        $("#sl_ent").show(); 
                        $("#sl_ciu").val(0).hide();
                        $('div[name="typeDoc"]').html(" NIT ");
                        $("#txt_apell1").val('');
                        $("#txt_apell2").val('');
                        $("#txt_mail").val('');
                        $("#CiuSpc").hide();
                        $("#CiuSpc2").hide();
                        $("#EntSpc").show();
                        $("#EntSpc2").show();
                    }
                    $("#txt_name").val('');
                    $("#txt_id").val('');
                    $("#Codi").val('');
                    $("#txt_apell1").val('');
                    $("#txt_apell2").val('');
                    $("#txt_mail").val('');
                    $("#txt_tel").val('');
                    $("#txt_dir").val('');
                    $("#Slc_act").val(0);
                }
             
           
            </script>
            <div id="SearchResult">
                
            </div>
        </form>
    </body>
</html>