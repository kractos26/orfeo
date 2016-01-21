<?php
session_start();
error_reporting(7);
$ruta_raiz = ".";
if (!$_SESSION['dependencia'])
    include_once "./rec_session.php";
$reloadFrame = "";
$ok = false;
if (isset($_POST['grabar_datos_per'])) {
    include("$ruta_raiz/config.php");    // incluir configuracion.
    include($ADODB_PATH . '/adodb.inc.php'); // $ADODB_PATH configurada en config.php
    $error = 0;
    $dsn = $driver . "://" . $usuario . ":" . $contrasena . "@" . $servidor . "/" . $db;
    $conn = NewADOConnection($dsn);

    if ($conn) {
        $conn->SetFetchMode(ADODB_FETCH_ASSOC);

        $tabla = 'usuario';
        $fechaNacimiento = $_POST['usua_ano'] . "-" . str_pad($_POST['usua_mes'], 2, '0', STR_PAD_LEFT) . "-" . str_pad($_POST['usua_dia'], 2, '0', STR_PAD_LEFT);
        $record["USUA_DOC"] = $_POST['usua_doc'];
        $record["USUA_EMAIL"] = $_POST['usua_email'];
        $record["USUA_EXT"] = $_POST['usua_ext'];
        $record["USUA_NACIM"] = $fechaNacimiento;
        $record["USUA_PISO"] = $_POST['usua_piso'];
        $record["USUA_AT"] = $_POST['usua_at'];
        $record["USUA_HABALERTAS"] = $_POST['slc_alertas'];
        $record["USUA_TIMERELOAD"] = $_POST['usua_reload'];
        if ($_POST['emailNotif'] == 1) {
            $record["EMAIL_NOTIF"] = 1;
            $emailNotifs = 1;
        } else {
            $record["EMAIL_NOTIF"] = 0;
            $emailNotifs = 0;
        }
        $conn->AutoExecute(&$tabla, $record, 'UPDATE', "USUA_LOGIN = '$krd'");
        $ok = $conn->CommitTrans();

        $_SESSION['usua_doc'] = $record["USUA_DOC"];
        $_SESSION['usua_ext'] = $record["USUA_EXT"];
        $_SESSION['usua_piso'] = $record["USUA_PISO"];
        $_SESSION['usua_email'] = $record["USUA_EMAIL"];
        $_SESSION['usua_at'] = $record["USUA_AT"];
        $_SESSION['usua_nacim'] = $record["USUA_NACIM"];
        $_SESSION['time_recarga'] = $record["USUA_TIMERELOAD"];
        $_SESSION['habilita_alertas'] = $record["USUA_HABALERTAS"];
        $_SESSION['email_notif'] = $emailNotifs;
    }

    $reloadFrame = "onload='top.frames[1].location.reload()'";
}

if (empty($usua_doc))
    $usua_doc = $_SESSION['usua_doc'];
if (empty($usua_ext))
    $usua_ext = $_SESSION['usua_ext'];
if (empty($usua_piso))
    $usua_piso = $_SESSION['usua_piso'];
if (empty($usua_email))
    $usua_email = $_SESSION['usua_email'];
if (empty($usua_at))
    $usua_at = $_SESSION['usua_at'];
if (empty($emailNotif))
    $emailNotif = $_SESSION['email_notif'];
if (empty($usua_dia)) {
    $usua_ano = empty($_SESSION["usua_nacim"]) ? date('Y') : substr($_SESSION["usua_nacim"], 0, 4);
    $usua_mes = empty($_SESSION["usua_nacim"]) ? date('m') : substr($_SESSION["usua_nacim"], 5, 2);
    $usua_dia = empty($_SESSION["usua_nacim"]) ? date('d') : substr($_SESSION["usua_nacim"], 8, 2);
}
if (empty($usua_reload))
    $usua_reload = $_SESSION['time_recarga'];
if ($_SESSION['habilita_alertas'] == 0) {
    $off = 'selected';
    $on = '';
} else {
    $off = '';
    $on = 'selected';
}
?>
<html>
    <head>
        <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
        <script type="text/javascript" src="js/formchek.js"></script>
        <script type="text/javascript">
            function validar()
            {
                var band = true;
                var msg = '';
                if (!isDate(document.getElementById('usua_ano').value, document.getElementById('usua_mes').value, document.getElementById('usua_dia').value))
                {	msg = msg + '\nFecha nacimiento erronea.';
                    band = false;
                }
                if (!isEmail(document.getElementById('usua_email').value, true))
                {	msg = msg + '\nCorreo electr\xf3nico incorrecto.';
                    band = false;
                }
                if (!isInteger(document.getElementById('usua_ext').value,true))
                {	msg = msg + '\nFormato extensi\xf3n incorrecta.';
                    band = false;
                }
                if (!isInteger(document.getElementById('usua_reload').value,true))
                {	msg = msg + '\nFormato int\xf9rvalo incorrecto.';
                    band = false;
                }
                if (band == false)	alert(msg);
                return band;
            }
        </script>
    </head>
    <body <?= $reloadFrame ?>>
        <form name=datos_personales action='<?php echo $_SERVER['PHP_SELF'] . "?krd=$krd"; ?>' method=post>
            <table WIDTH=98% align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab" >
                <tr valign="bottom">
                    <td class="titulos4" height="54">INFORMACI&Oacute;N GENERAL <br></td>
                </tr>
                <tr align="center">
                    <td class="info" height="40">
                        <b>La informaci&oacute;n aqu&iacute;
                            reportada se considera oficial y es indispensable para iniciar el acceso al Sistema de Gesti&oacute;n Documental ORFEO</b>
                    </td>
                </tr>
            </table>
            <table  WIDTH=98% align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
                <tr>
                    <td height="50" align="right" class="titulos2" width="24%">
                        Documento C.C:<br>(No incluir puntos, comas o caracteres especiales)
                    </td>
                    <td class='listado2' width="17%" >
                        <?php
                        if ($info)
                            $info = "false"; else
                            $info = "true";
                        ?>
                        <input type=text name=usua_doc value='<?= TRIM($usua_doc) ?>' class=tex_area size=15 maxlength="20" readonly="<?= $info ?>">
                    </td>
                    <td align="right"  class="titulos2" width="15%">Fecha Nacimiento<br>(dd-mm-aaaa)<?= $usua_nacim ?> </td>
                    <td class='listado2' width="24%" >
                        <?php
                        $ano_fin = date("Y");
                        $ano_fin++;
                        $ano_fin = $ano_fin - 10;
                        $ano_ini = $ano_fin - 80;
                        ?>
                        <select name=usua_dia id=usua_dia class="select">
                            <?php
                            for ($i = 1; $i <= 31; $i++) {
                                $datoss = ($i == $usua_dia) ? " selected " : $datoss = "";
                                echo "<option value=$i  $datoss>$i</option>";
                            }
                            ?>
                        </select>
                        <select name=usua_mes id=usua_mes class="select">
                            <?
                            if ($usua_mes == 1) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=1  '<?= $datoss ?>'>Ene</option>
                            <?
                            if ($usua_mes == 2) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=2  '<?= $datoss ?>'>Feb</option>
                            <?
                            if ($usua_mes == 3) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=3  '<?= $datoss ?>'>Mar</option>
                            <?
                            if ($usua_mes == 4) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=4  '<?= $datoss ?>'>Abr</option>
                            <?
                            if ($usua_mes == 5) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=5  '<?= $datoss ?>'>May</option>
                            <?
                            if ($usua_mes == 6) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=6  '<?= $datoss ?>'>Jun</option>
                            <?
                            if ($usua_mes == 7) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=7  '<?= $datoss ?>'>Jul</option>
                            <?
                            if ($usua_mes == 8) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=8  '<?= $datoss ?>'>Ago</option>
                            <?
                            if ($usua_mes == 9) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=9  '<?= $datoss ?>'>Sep</option>
                            <?
                            if ($usua_mes == 10) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=10  '<?= $datoss ?>'>Oct</option>
                            <?
                            if ($usua_mes == 11) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=11  '<?= $datoss ?>'>Nov</option>
                            <?
                            if ($usua_mes == 12) {
                                $datoss = " selected ";
                            } else {
                                $datoss = "";
                            }
                            ?>
                            <option value=12  '<?= $datoss ?>'>Dic</option>
                        </select>
                        <select name=usua_ano id=usua_ano class="select">
                            <?php
                            for ($i = 1; $i <= 80; $i++) {
                                $ano = ($ano_fin - $i);
                                if ($ano == $usua_ano) {
                                    $datoss = " selected ";
                                } else {
                                    $datoss = "";
                                }
                                echo "<option value=$ano $datoss>$ano</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td align="right" width="11%" class="titulos2">Extensi&oacute;n</td>
                    <td class='listado2' width="9%">
                        <input type=text name=usua_ext id=usua_ext value='<?= $usua_ext ?>' class=tex_area size=5 maxlength="4">
                    </td>
                </tr>
                <tr>
                    <td align="right"  height="41" width="24%" class="titulos2">Correo Electr&oacute;nico<br></td>
                    <td class='listado2' width="17%" >
                        <input type=text name=usua_email id=usua_email value='<?= trim($usua_email) ?>' class=tex_area size=30 maxlength="50">
                    </td>
                    <td align="right" class="titulos2" width="15%">Identificaci&oacute;n Equipo<br>(ej, at-999)</td>
                    <td class='listado2' width="24%" >
                        <span class="info"> AT-</span>
                        <input type=text name=usua_at  value='<?= $usua_at ?>' class=tex_area size=5 maxlength="5">
                    </td>
                    <td class="titulos2"  align="right" width="11%">Piso</td>
                    <td class='listado2' width="9%">
                        <input type=text name=usua_piso  value='<?= $usua_piso ?>' class=tex_area size=5 maxlength="2">&nbsp;
                    </td>
                </tr>
                <tr>
                    <td align="right"  height="41" width="24%" class="titulos2">Int&eacute;rvalo recarga carpetas<br></td>
                    <td class='listado2' width="17%" >
                        <input type=text name=usua_reload id=usua_reload  value='<?= trim($usua_reload) ?>' class=tex_area size=1 maxlength="1"> minuto(s).
                    </td>
                    <td align="right" class="titulos2" width="15%">Habilita alertas?<br></td>
                    <td class='listado2' width="24%" >
                        <select name="slc_alertas" id="slc_alertas" class='select'>
                            <option value='0' <?= $off ?>>NO</option>
                            <option value='1' <?= $on ?>>SI</option>
                        </select>
                    </td>
                    <td class="titulos2"  align="right" width="11%">Habilitar notificaciones por e-mail</td>
                    <td class='listado2' width="9%"><input type="checkbox" name="emailNotif" value="1" <? if ($emailNotif == 1) echo "checked"; else echo ""; ?>></td>
                </tr>
                <tr align="center">
                    <td colspan="6">
                        <input type=submit name=grabar_datos_per id=grabar_datos_per class=botones_largo Value="Grabar Datos Personales" onclick="return validar();">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if ($ok) {
            ?>
            <TABLE BORDER=0 WIDTH=100%>
                <TR>
                    <TD class="etextomenu">
                <center><b>Los datos han sido guardados, Por favor ingrese de modo normal al sistema.</b></center>
            </TD>
        </TR>
    </TABLE>
    <?php
} else {
    ?>
    <TABLE BORDER=0 WIDTH=100%>
        <TR>
            <TD class="listado2">
        <center><B><span class="alarmas">Todos los datos deben ser grabados correctamente.  De lo contrario no podra seguir navegando por el sistema.</span></B></center>
    </TD>
    </TR>
    </TABLE>
    <?php
}
?>
</body>
</html>