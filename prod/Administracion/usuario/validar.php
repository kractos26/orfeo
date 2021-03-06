<?
/* * ********************************************************************************** */
/* ORFEO GPL:Sistema de Gestion Documental		http://www.orfeogpl.org	     */
/* 	Idea Original de la SUPERINTENDENCIA DE SERVICIOS PUBLICOS DOMICILIARIOS     */
/* 				COLOMBIA TEL. (57) (1) 6913005  orfeogpl@gmail.com   */
/* ===========================                                                       */
/*                                                                                   */
/* Este programa es software libre. usted puede redistribuirlo y/o modificarlo       */
/* bajo los terminos de la licencia GNU General Public publicada por                 */
/* la "Free Software Foundation"; Licencia version 2. 			             */
/*                                                                                   */
/* Copyright (c) 2005 por :	  	  	                                     */
/* SSPS "Superintendencia de Servicios Publicos Domiciliarios"                       */
/*   Jairo Hernan Losada  jlosada@gmail.com                Desarrollador             */
/* C.R.A.  "COMISION DE REGULACION DE AGUAS Y SANEAMIENTO AMBIENTAL"                 */
/*   Lucia Ojeda          lojedaster@gmail.com             Desarrolladora            */
/* D.N.P. "Departamento Nacional de Planeaci�n"                                      */
/*   Hollman Ladino       hollmanlp@gmail.com                Desarrollador             */
/*                                                                                   */
/* Colocar desde esta lInea las Modificaciones Realizadas Luego de la Version 3.5    */
/*  Nombre Desarrollador   Correo     Fecha   Modificacion                           */
/* * ********************************************************************************** */

$krdOld = $krd;
session_start();
error_reporting(0);
$ruta_raiz = "../..";
$carpetaOld = $carpeta;
$tipoCarpOld = $tipo_carp;
if (!$tipoCarpOld)
    $tipoCarpOld = $tipo_carpt;
if (!$krd)
    $krd = $krdOld;
if (!isset($_SESSION['dependencia']))
    include "$ruta_raiz/rec_session.php";
$errorValida = "";
include "$ruta_raiz/config.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
include "ImpUsrClass.php";
include "SecSuperClass.php";
$db = new ConnectionHandler("$ruta_raiz");
if (!defined('ADODB_FETCH_ASSOC'))
    define('ADODB_FETCH_ASSOC', 2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
//	$db->conn->debug = false;
$rs_dep = $db->conn->Execute("SELECT DEPE_NOMB, DEPE_CODI FROM DEPENDENCIA ORDER BY DEPE_NOMB");
//consultamos el valor del notificacion email
$query="SELECT * FROM USUARIO WHERE USUA_LOGIN='$krd'";
$rsemail=$db->conn->Execute($query);  
$emailNotif= $rsemail->fields['EMAIL_NOTIF'];
// CREAMOS LA VARIABLE $ARRDEPSEL QUE CONTINE LAS DEPENDECIAS QUE PUEDEN VER A LA DEPENDENCIA DEL USUARIO ACTUAL.
$rs_depvis = $db->conn->Execute("SELECT DEPENDENCIA_OBSERVA FROM DEPENDENCIA_VISIBILIDAD WHERE DEPENDENCIA_VISIBLE=$dep_sel");
$arrDepSel = array();
$i = 0;
while ($tmp = $rs_depvis->FetchRow()) {
    $arrDepSel[$i] = $tmp['DEPENDENCIA_OBSERVA'];
    $i += 1;
}
($usModo == 1) ? $tPermis = "Asignar Permisos" : $tPermis = "Editar Permisos";

?>
<html>
    <head>
        <script type="text/javascript" src="../../jquery/jquery-1.7.1.min.js"></script>
        <SCRIPT language="Javascript">
            function mensaje(vari)
            {
                alert("evento lanzado: " + vari);
            }
        </SCRIPT>
        <title>Untitled Document</title>
                          <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">


    </head>
    <body>
        <?
        /** Valida que la dependencia no tenga ya JEFE * */
        $isql = "SELECT USUA_NOMB, USUA_LOGIN FROM USUARIO WHERE DEPE_CODI=$dep_sel AND USUA_CODI = 1";
        $rs = $db->query($isql);
        $nombreJefe = $rs->fields["USUA_NOMB"];

        if ($nombreJefe && $perfil == "Jefe") {
            if ($usuLogin != $rs->fields["USUA_LOGIN"]) {
                $errorValida = "SI";
                ?> <center><p><span class=etexto><B><?= "En la dependencia " . $dep_sel . ", ya existe un usuario jefe, " . $nombreJefe . ", por favor verifique o realice los cambios necesarios para poder continuar con este proceso" ?></B> </p>
                <?
            }
        }

        /** Valida que la cedula NO EXISTA ya en la base de usuario * */
        if (($usuDocSel != $cedula && $usModo == 2) || $usModo == 1) {
            $isql = "SELECT USUA_DOC FROM USUARIO WHERE USUA_DOC = " . "'" . $cedula . "'";
            $rsCedula = $db->query($isql);
            $cedulaEncon = $rsCedula->fields["USUA_DOC"];
            if ($cedulaEncon) {
                $errorValida = "SI";
                ?> <center><p><span class=etexto><B>El numero de cedula ya existe en la tabla de usuario, por favor verifique</B> </p>
                <?
            }
        }
        /** Valida que el LOGIN NO EXISTA ya en la base de usuario * */
        if (($usuLoginSel != $usuLogin && $usModo == 2) || $usModo == 1) {
            $isql = "SELECT usua_login FROM USUARIO WHERE usua_login = " . "'" . $usuLogin . "'";
            $rsLogin = $db->query($isql);
            $LoginEncon = $rsLogin->fields["USUA_LOGIN"];
            if ($LoginEncon) {
                $errorValida = "SI";
                ?> <center><p><span class=etexto><B>El Login que desea asignar ya existe, por favor verifique.</B> </p>
                    <?
                }
            }
            $encabezado = "krd=$krd&usModo=$usModo&perfil=$perfil&dep_sel=$dep_sel&cedula=$cedula&usuLogin=$usuLogin&nombre=$nombre&dia=$dia&mes=$mes&ano=$ano&ubicacion=$ubicacion&piso=$piso&extension=$extension&email=$email&usuDocSel=$usuDocSel&usuLoginSel=$usuLoginSel";
            if ($errorValida == "SI") {
                ?>
                    <span class=etexto><center>
                            <a href='crear.php?<?= session_name() . "=" . session_id() . "&$encabezado" ?>'>Volver a Formulario Anterior</a>
                        </center></span>
                    <?
                } else {
                    $encabezado = "krd=$krd&usModo=$usModo&perfil=$perfil&perfilOrig=$perfilOrig&dep_sel=$dep_sel&cedula=$cedula&usuLogin=$usuLogin&nombre=$nombre&dia=$dia&mes=$mes&ano=$ano&ubicacion=$ubicacion&piso=$piso&extension=$extension&email=$email&usuDocSel=$usuDocSel&usuLoginSel=$usuLoginSel";
                    ?>
                    <center>
                        <form name="frmPermisos" action='grabar.php?<?= session_name() . "=" . session_id() . "&$encabezado" ?>' method="post">
                            <tr>
                                <td>
                                    <table border=1 width=80% class=t_bordeGris>
                                        <tr>
                                            <td colspan="2" class="titulos4">
                                        <center>
                                            <p><B><span class=etexto>ADMINISTRACI&Oacute;N DE USUARIOS Y PERFILES</span></B> </p>
                                            <?php
                                            echo $tPermis;                                           
                                            ?>
                                        </center>
                                </td>
                            </tr>
                            <?
                            if ($usModo == 2) {
                                include "traePermisos.php";
                            } else {
                                $usua_activo = 1;
                                $usua_nuevoM = 0;
                                $perm_tpx = 0;
                                $usua_perm_tpx = 0;
                                $usua_perm_reprad = 0;
                                $usua_super = 0;
                                $nivel = 1;
                            }
                            ?>
                            <tr>
                                <td width="40%" height="26" class="listado2">Digitalizaci&oacute;n de Documentos
                                    <?
                                    $contador = 0;
                                    while ($contador <= 2) {
                                        echo "<input name='digitaliza' type='radio' value=$contador ";
                                        if ($digitaliza == $contador)
                                            echo "checked"; else
                                            echo "";
                                        echo " >" . $contador;
                                        $contador = $contador + 1;
                                    }
                                    ?>
                                </td>
                                <td width="40%" height="26" class="listado2"> <input type="checkbox" name="tablas" value="$tablas" <? if ($tablas) echo "checked"; else echo ""; ?>>
                                    Tablas de Retenci&oacute;n Documental</td>
                            </tr>

                            <tr>

                                <td width="40%" height="26" class="listado2">
                                    <input name="modificaciones" type="checkbox" value="$modificaciones" <? if ($modificaciones) echo "checked"; else echo ""; ?>>
                                    Modificaciones
                                </td>
                                <td width="40%" height="26" class="listado2">
                                    <input type="checkbox" name="masiva" value="$masiva" <? if ($masiva) echo "checked"; else echo ""; ?>>
                                    Radicaci&oacute;n Masiva
                                </td>
                            </tr>

                            <tr>
                                <td width="40%" height="26" class="listado2"> Impresi&oacute;n
                                    <?
                                    $contador = 0;
                                    while ($contador <= 2) {
                                        echo "<input name='impresion' type='radio' value=$contador ";
                                        if ($impresion == $contador)
                                            echo "checked"; else
                                            echo "";
                                        echo " >" . $contador;
                                        $contador = $contador + 1;
                                    }
                                    ?>
                                    <div id="ImpDepMenu"></div>
                                    <div id="ImpAux"></div>
                                </td>

                                <td width="40%" height="26" class="listado2"><input type="checkbox" name="prestamo" value="$prestamo" <? if ($prestamo) echo "checked"; else echo ""; ?>>
                                    Pr&eacute;stamo de Documentos.</td>
                            </tr>

                            <tr>
                                <td width="40%" height="26" class="listado2"> <input type="checkbox" name="s_anulaciones" value="$s_anulaciones" <? if ($s_anulaciones) echo "checked"; else echo ""; ?>>
                                    Solicitud de Anulaciones.</td>
                                <td width="40%" height="26" class="listado2"> <input type="checkbox" name="anulaciones" value="$anulaciones" <? if ($anulaciones) echo "checked"; else echo ""; ?>>
                                    Anulaciones.</td>
                            </tr>

                            <tr>
                                <td width="40%" height="26" class="listado2"> <!--input type="checkbox" name="adm_archivo" value="$adm_archivo" <? if ($adm_archivo) echo "checked"; else echo ""; ?>-->
                                    Administrador de Archivo. 
                                    <?
                                    $contador = 0;
                                    while ($contador <= 2) {
                                        echo "<input name='adm_archivo' type='radio' value=$contador ";
                                        if ($adm_archivo == $contador)
                                            echo "checked"; else
                                            echo "";
                                        echo " >" . $contador;
                                        $contador = $contador + 1;
                                    }
                                    ?>
                                </td>
                                <td width="40%" height="26" class="listado2"> <input type="checkbox" name="dev_correo" value="$dev_correo" <? if ($dev_correo) echo "checked"; else echo ""; ?>>
                                    Devoluciones de Correo.</td>
                            </tr>

                            <tr>
                                <td width="40%" height="26" class="listado2"> <input type="checkbox" name="adm_sistema" value="$adm_sistema" <? if ($adm_sistema) echo "checked"; else echo ""; ?>>
                                    Administrador del Sistema.</td>
                                <td width="40%" height="26" class="listado2"> <input type="checkbox" name="env_correo" value="$env_correo" <? if ($env_correo) echo "checked"; else echo ""; ?>>
                                    Env&iacute;os de Correo.</td>
                            </tr>
                            <tr>
                                <td width="40%" height="26" class="listado2"> <input type="checkbox" name="reasigna" value="$reasigna" <? if ($reasigna) echo "checked"; else echo ""; ?>>
                                    Usuario Reasigna.</td>
                                <td width="40%" height="26" class="listado2"> Estad&iacute;sticas.
                                    <?
                                    $contador = 0;
                                    while ($contador <= 2) {
                                        echo "<input name='estadisticas' type='radio' value=$contador ";
                                        if ($estadisticas == $contador)
                                            echo "checked"; else
                                            echo "";
                                        echo " >" . $contador;
                                        $contador = $contador + 1;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%" height="26" class="listado2"> <input type="checkbox" name="usua_activo" value="$usua_activo" <? if ($usua_activo == 1) echo "checked"; else echo ""; ?>>
                                    Usuario Activo.
                                </td>
                                <td width="40%" height="26" class="listado2">Nivel de Seguridad.
                                    <?
                                    $contador = 1;
                                    while ($contador <= 5) {
                                        echo "<input name='nivel' type='radio' value=$contador ";
                                        if ($nivel == $contador)
                                            echo "checked"; else
                                            echo "";
                                        echo " >" . $contador;
                                        $contador = $contador + 1;
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="40%" height="26" class="listado2"> <input type="checkbox" name="usua_nuevoM" value="$usua_nuevoM" <? if ($usua_nuevoM == '0') echo "checked"; else echo ""; ?>>
                                    Usuario Nuevo.</td>
                                <td width="40%" height="26" class="listado2">Firma Digital.
                                    <?
                                    $contador = 0;
                                    while ($contador <= 3) {
                                        echo "<input name='firma' type='radio' value=$contador ";
                                        if ($firma == $contador)
                                            echo "checked"; else
                                            echo "";
                                        echo " >" . $contador;
                                        $contador = $contador + 1;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td height='26' width='40%' class='listado2'>
                                    <input type="checkbox" name="permArchivar" value="$permArchivar" <? if ($permArchivar) echo "checked"; else echo ""; ?>>
                                    Puede Archivar Documentos
                                </td>
                                <td height='26' width='40%' class='listado2'>
                                    <input type="checkbox" name="usua_publico" value="$usua_publico" <? if ($usua_publico) echo "checked"; else echo ""; ?> >
                                    Usuario P&uacute;blico.
                                </td>
                            </tr>
                            <tr>
                                <td width="40%" height="26" class="listado2">
                                    Creaci&oacute;n de expedientes.
                                    <?
                                    $contador = 0;
                                    while ($contador <= 2) {
                                        echo "<input name='usua_permexp' type='radio' value=$contador ";
                                        if ($usua_permexp == $contador)
                                            echo "checked"; else
                                            echo "";
                                        echo " >" . $contador;
                                        $contador = $contador + 1;
                                    }
                                    ?>
                                </td>
                                <td width="40%" height="26" class="listado2">
                                    <input type="checkbox" name="notifica" value="$notifica" <? if ($notifica) echo "checked"; else echo ""; ?>>
                                    Notificaci&oacute;n de Resoluciones.
                                </td>
                            </tr>

                            <?php
                            //creacion del espacio para Seleccionar el permiso para Remitemtes y Terceros
                            ?>
                            <tr>
                                <td width="40%" height="26" class="listado2">
                                    <input type="checkbox" name="remitenteTerceros" value="1" <? if ($remitenteTerceros) echo "checked"; else echo ""; ?>>
                                    Remitentes / Terceros
                                   
                                </td>

                                <td width="40%" height="26" class="listado2">
                                    Superusuario Consulta.
                                    <?
                                    $contador = 0;
                                    while ($contador <= 2) {
                                        echo "<input name='usua_super' type='radio' value=$contador ";
                                        if ($usua_super == $contador)
                                            echo "checked"; else
                                            echo "";
                                        echo " >" . $contador;
                                        $contador = $contador + 1;
                                    }
                                    ?> 
                                    <div id="DepMenu"></div>
                                    <div id="SuperDep"></div>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%" height="26" class="listado2">
                                    <input type="checkbox" name="emailNotif" value="1" <? if($emailNotif == 1) echo "checked"; else echo ""; ?>>
                                    Recibir notificaciones por correo
                                </td>

                                <td width="40%" height="26" class="listado2">
                                  <input type="checkbox" name="ciudadanosempresas" value="1" <? if ($ciudadanosempresas) echo "checked"; else echo ""; ?>>
                                    Ciudadanos / Empresas
                                </td>
                                
                            </tr>
                            <tr>
                                  <td width="40%" height="26" class="listado2">
                                    <input type="checkbox" name="adminispqrs" value="1" <? if($administracionpqr == 1) echo "checked"; else echo ""; ?>>
                                       Administraci&oacute;n PQR's
                                  </td>

                                <td width="40%" height="26" class="listado2">
                                    <input type="checkbox" name="usua_radmail" value="$usua_radmail">
                                    Radicaci&oacute;n correos electr&oacute;nicos
                                </td>
                            </tr>
                            <tr>
                                  <td width="40%" height="26" class="listado2">
                                     <input type="checkbox" name="respuesta" value="$respuesta">
                                        Puede Enviar Respuesta Rapida
                                <td width="40%" height="26" class="listado2">
                                   
                                </td>
                            </tr>
                            
                            </table>
                            <table border=1 width=80% class=t_bordeGris>
                                <tr>
                                    <td colspan="2" class="titulos4" align="center">
                                        <p><B><span class=etexto>Permisos Tipos de Radicados</span></B></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40%" height="26" class="listado2">Radicaci&oacute;n Express
                                        <?php
                                        for ($i = 0; $i <= 3; $i++) {
                                            echo "<input name='perm_tpx' type='radio' value=$i ";
                                            if ($usua_perm_tpx == $i)
                                                echo "checked>$i"; else
                                                echo ">$i";
                                        }
                                        ?>
                                    </td>
                                    <td width="40%" height="26" class="listado2"> <input type="checkbox" name="perm_reprad" value="1" <? if ($usua_perm_reprad) echo "checked"; else echo ""; ?>>
                                        Reporte Radicaci&oacute;n</td>
                                </tr>
                                <?php
                                $sql = "SELECT SGD_TRAD_CODIGO,SGD_TRAD_DESCR FROM SGD_TRAD_TIPORAD ORDER BY SGD_TRAD_CODIGO";
                                $ADODB_COUNTRECS = true;
                                $rs_trad = $db->query($sql);
                                if ($rs_trad->RecordCount() >= 0) {
                                    $i = 1;
                                    $cad = "perm_tp";
                                    while ($arr = $rs_trad->FetchRow()) {
                                        (is_int($i / 2)) ? print ""  : print "<TR align='left'>";
                                        echo "<td height='26' width='40%' class='listado2'>";
                                        $x = 0;
                                        echo "&nbsp;" . "(" . $arr['SGD_TRAD_CODIGO'] . ")&nbsp;" . $arr['SGD_TRAD_DESCR'] . "&nbsp;&nbsp;";
                                        while ($x < 4) {
                                            ($x == ${$cad . $arr['SGD_TRAD_CODIGO']}) ? $chk = "checked" : $chk = "";
                                            echo "<input type='radio' name='" . $cad . $arr['SGD_TRAD_CODIGO'] . "' id='" . $cad . $arr['SGD_TRAD_CODIGO'] . "' value='$x' $chk>" . $x;
                                            if ($arr['SGD_TRAD_CODIGO'] == 2 and $x == 1)
                                                $x = 5;$x++;
                                        }
                                        echo "</td>";
                                        (is_int($i / 2)) ? print "</TR>"  : print "";
                                        $i += 1;
                                    }
                                }
                                else
                                    echo "<tr><td align='center'> NO SE HAN GESTIONADO TIPOS DE RADICADOS</td></tr>";
                                $ADODB_COUNTRECS = false;
                                ?>
                            </table>

                            <?php
                            /* Empieza sección permisos login
                             */
                            ?>
                            <table border=1 width=80% class=t_bordeGris>
                                <tr>
                                    <td colspan="2" class="titulos4" align="center">
                                        <p><B><span class=etexto>Otros Permisos Especiales</span></B></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td height='26' width='40%' class='listado2'>
                                        <input type="checkbox" name="permBorraAnexos" value="$permBorraAnexos" <? if ($permBorraAnexos) echo "checked"; else echo ""; ?>>
                                        Puede borrar Anexos .tif
                                    </td>
                                    <td height='26' width='40%' class='listado2'>
                                        <input type="checkbox" name="permTipificaAnexos" value="$permTipificaAnexos" <? if ($permTipificaAnexos) echo "checked"; else echo ""; ?>>
                                        Puede Tipificar Anexos .tif
                                    </td>
                                </tr>
                                <tr>
                                    <td height='26' width='40%' class='listado2'>
                                        <input type="checkbox" name="autenticaLDAP" value="$autenticaLDAP" <? if ($autenticaLDAP) echo "checked"; else echo ""; ?>>
                                        Se autentica por medio de LDAP
                                    </td>
                                    <td height='26' width='40%' class='listado2'>
                                        <input type="checkbox" name="perm_adminflujos" value="$$perm_adminflujos" <? if ($perm_adminflujos) echo "checked"; else echo ""; ?>>
                                        Puede utilizar el editor de Flujos
                                    </td>
                                </tr>
                            </table>
                            <table border=1 width=80% class=t_bordeGris>
                                <td height="30" colspan="2" class="listado2">
                                    <input name="login" type="hidden" value='<?= $usuLogin ?>'>
                                    <input name="PHPSESSID" type="hidden" value='<?= session_id() ?>'>
                                    <input name="krd" type="hidden" value='<?= $krd ?>'>
                                    <input name="nusua_codi" type="hidden" value='<?= $nusua_codi ?>'>
                                    <input name="cedula" type="hidden" value='<?= $cedula ?>'>
                                <center><input class="botones" type="button" name="Submit3" value="Grabar"></center>
                                </td>
                                <td height="30" colspan="2" class="listado2">
                                <center>
                                    <a href='../formAdministracion.php?<?= session_name() . "=" . session_id() . "&$encabezado" ?>'>
                                        <input class="botones" type="button" name="Submit4" value="Cancelar"></a></center>
                                </td>
                            </table>
                            </td>
                            </tr>
                            <?
                            $encabezado = "&krd=$krd&dep_sel=$dep_sel&usModo=$usModo&perfil=$perfil&cedula=$cedula&dia=$dia&mes=$mes&ano=$ano&ubicacion=$ubicacion&piso=$piso&extension=$extension&email=$email";
                            ?>
                        </form>
                        <?
                    }
                    $ImpAux = new ImpUsrClass($db);
                    $ImpAux->ImpUsrFill($cedula);
                    $SecAux = new SecSuperClass($db);
                    $SecAux->SecSuperFill($cedula);
                    ?>

                    <script type="text/javascript">
                        var UsuaDoc=<?= $cedula ?>;
                        var ImpDeps=[];
                        var SuperDeps=[];
<?php foreach ($ImpAux->Dep as $key => $value) { ?>
        ImpDeps.push("<?= $value[0] ?>"); 
    <?php
}
foreach ($SecAux->Dep as $key => $value) {
    ?>
            SuperDeps.push("<?= $value[0] ?>"); 
<?php } ?>
    function Elim(Strg,toDel){
        var x=0;
        var newStrg=[];
        var esta;
        for(x=0;x<Strg.length;x++){
            esta=false;
            esta=BuscaData(toDel,Strg[x]);
            if(esta==false){
                newStrg.push(Strg[x]) 
            }
        }
        return newStrg;
    }
    function BuscaData(stg,Srch4){
        var i=0;
        var esta=false;
        for (i=0;i<stg.length;i++)
        {
            if(stg[i]==Srch4){
                esta=true;
                break;
            }
        }
        return esta;
    }
    $('input[name="Submit3"]').click(function(){
        if($('input[name="impresion"]:checked').val() == 2){
            PostImpDef();
        }else{
            PostImpDepsNew();
        }
        if($('input[name="usua_super"]:checked').val() == 2){
            PostSecDef();
        }else{
            PostSecDepsNew();
        }
        
        //document.frmPermisos.submit();
        //$("form").submit();
        //setTimeout(function(){alert("Hello")},3000);
        
    });
    /*$("form").submit(function() {
        if($('input[name="impresion"]:checked').val() == 2){
            PostImpDef();
        }else{
            PostImpDepsNew();
        }
        return true;
    });*/
    $(window).load(function(){
        if($('input[name="usua_super"]:checked').val() == 2){
            PostSecMenu();              
        }else{
            $("#DepMenu").empty();
            $("#SuperDep").empty();
        }
        if($('input[name="impresion"]:checked').val() == 2){
            PostImpMenu();               
        }else{
            $("#ImpDepMenu").empty();
            $("#ImpAux").empty();
        }
    });
                    </script>
<!--                    <script type="text/javascript" src="FunctionsValidar.js"></script>-->
                    <script type="text/javascript" src="FunctionsValidarImp.js"></script>
                    <script type="text/javascript" src="FunctionsValidarSec.js"></script>
                    </body>
                    </html>
