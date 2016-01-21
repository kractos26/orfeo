<?php
/*************************************************************************************/
/* ORFEO GPL:Sistema de Gestion Documental		http://www.orfeogpl.org	     */
/*	Idea Original de la SUPERINTENDENCIA DE SERVICIOS PUBLICOS DOMICILIARIOS     */
/*				COLOMBIA TEL. (57) (1) 6913005  orfeogpl@gmail.com   */
/* ===========================                                                       */
/*                                                                                   */
/* Este programa es software libre. usted puede redistribuirlo y/o modificarlo       */
/* bajo los terminos de la licencia GNU General Public publicada por                 */
/* la "Free Software Foundation"; Licencia version 2. 			             */
/*                                                                                   */
/* Copyright (c) 2005 por :	  	  	                                     */
/* SSPS "Superintendencia de Servicios Publicos Domiciliarios"                       */
/*   Jairo Hernan Losada  jlosada@gmail.com                Desarrollador             */
/*   Sixto Angel Pinz�n L�pez --- angel.pinzon@gmail.com   Desarrollador             */
/* C.R.A.  "COMISION DE REGULACION DE AGUAS Y SANEAMIENTO AMBIENTAL"                 */
/*   Liliana Gomez        lgomezv@gmail.com                Desarrolladora            */
/*   Lucia Ojeda          lojedaster@gmail.com             Desarrolladora            */
/* D.N.P. "Departamento Nacional de Planeaci�n"                                      */
/*   Hollman Ladino       hollmanlp@gmail.com                Desarrollador           */
/*                                                                                   */
/* Colocar desde esta lInea las Modificaciones Realizadas Luego de la Version 3.5    */
/*  Nombre Desarrollador   Correo     Fecha   Modificacion                           */
/*************************************************************************************/
?>
<?php
$ruta_raiz = "../..";
session_start();
if (!$_SESSION['dependencia'] or !$_SESSION['tpDepeRad'])
    include "$ruta_raiz/rec_session.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug=true;
error_reporting(0);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
if ($usuLogin) {
    $sqlFechaHoy = $db->conn->DBTimeStamp(time());

    $isql = "UPDATE USUARIO SET ";
    $isql .= " USUA_PRAD_TPX = $perm_tpx, ";
    if ($perm_reprad)
        $isql = $isql . " USUA_PRAD_REPRAD = 1, ";
    else
        $isql = $isql . " USUA_PRAD_REPRAD = 0, ";

    if ($prestamo)
        $isql = $isql . " USUA_PERM_PRESTAMO = 1, ";
    else
        $isql = $isql . " USUA_PERM_PRESTAMO = 0, ";

    if ($digitaliza)
        $isql = $isql . " PERM_RADI = $digitaliza, ";
    else
        $isql = $isql . " PERM_RADI = 0, ";

    if ($masiva)
        $isql = $isql . " USUA_MASIVA = 1, ";
    else
        $isql = $isql . " USUA_MASIVA = 0, ";

    if ($impresion)
        $isql = $isql . " USUA_PERM_IMPRESION = $impresion, ";
    else
        $isql = $isql . " USUA_PERM_IMPRESION = 0, ";

    if ($remitenteTerceros)
    {
        
        $isql = $isql . " USUA_PERM_REMIT_TERCERO = 1, ";
    }   
    else{
        $isql = $isql . " USUA_PERM_REMIT_TERCERO = 0, ";
    }
    if($_POST['ciudadanosempresas']){
          $isql = $isql . "USUA_PERM_CIUDADANOSEMPRESAS = 1, ";
          
    }
    else{
         $isql = $isql . "USUA_PERM_CIUDADANOSEMPRESAS = 0, ";
    }
    if($_POST['adminispqrs'])
        { $isql = $isql . "USUA_PERM_ADMINISTRACIONPQR = 1, ";
        }
     else{         $isql = $isql . "USUA_PERM_ADMINISTRACIONPQR = 0, ";
        }
    if ($emailNotif) {
        $isql = $isql . " EMAIL_NOTIF = 1, ";
    } else {
        $isql = $isql . " EMAIL_NOTIF = 0, ";
    }

    if (!($s_anulaciones) && !($anulaciones))
        $isql = $isql . " SGD_PANU_CODI = 0, ";
    if (($s_anulaciones) && !($anulaciones))
        $isql = $isql . " SGD_PANU_CODI = 1, ";
    if (($anulaciones) && !($s_anulaciones))
        $isql = $isql . " SGD_PANU_CODI = 2, ";
    if (($s_anulaciones) && ($anulaciones))
        $isql = $isql . " SGD_PANU_CODI = 3, ";

    if ($adm_archivo)
        $isql = $isql . " USUA_ADMIN_ARCHIVO = '$adm_archivo', ";
    else
        $isql = $isql . " USUA_ADMIN_ARCHIVO = '0', ";

    if ($dev_correo)
        $isql = $isql . " USUA_PERM_DEV = '1', ";
    else
        $isql = $isql . " USUA_PERM_DEV = '0', ";

    if ($adm_sistema)
        $isql = $isql . " USUA_ADMIN_SISTEMA = '1', ";
    else
        $isql = $isql . " USUA_ADMIN_SISTEMA = '0', ";

    if ($usua_nuevoM)
        $isql = $isql . " USUA_NUEVO = '0', ";
    else
        $isql = $isql . " USUA_NUEVO = '1', ";

    if ($env_correo)
        $isql = $isql . " USUA_PERM_ENVIOS = 1, ";
    else
        $isql = $isql . " USUA_PERM_ENVIOS = 0, ";

    if ($estadisticas)
        $isql = $isql . " SGD_PERM_ESTADISTICA = $estadisticas, ";
    else
        $isql = $isql . " SGD_PERM_ESTADISTICA = 0, ";

    if ($firma)
        $isql = $isql . " USUA_PERM_FIRMA = $firma, ";
    else
        $isql = $isql . " USUA_PERM_FIRMA = 0, ";

    if ($reasigna) {
        $isql = $isql . " USUARIO_REASIGNAR = 1, ";
    }
    else
        $isql = $isql . " USUARIO_REASIGNAR = 0, ";

    if ($usua_publico) {
        $isql = $isql . " USUARIO_PUBLICO = 1, ";
    }
    else
        $isql = $isql . " USUARIO_PUBLICO = 0, ";

    if ($permBorraAnexos) {

        $isql = $isql . " PERM_BORRAR_ANEXO = 1, ";
    }else
        $isql = $isql . " PERM_BORRAR_ANEXO = 0, ";

    if ($permTipificaAnexos) {
        $isql = $isql . " PERM_TIPIF_ANEXO = 1, ";
    }else
        $isql = $isql . " PERM_TIPIF_ANEXO = 0, ";


    if ($autenticaLDAP) {
        $isql = $isql . " USUA_AUTH_LDAP = 1, ";
    }else
        $isql = $isql . " USUA_AUTH_LDAP = 0, ";

    if ($perm_adminflujos) {
        $isql = $isql . " USUA_PERM_ADMINFLUJOS = 1, ";
    }else
        $isql = $isql . " USUA_PERM_ADMINFLUJOS = 0, ";

    if ($permArchivar) {
        $isql = $isql . " PERM_ARCHI = 1, ";
    }else
        $isql = $isql . " PERM_ARCHI = 0, ";
    if($_POST["respuesta"]){
        $isql = $isql. " USUA_PERM_RESPUESTA = 1,";
    }
    else
        $isql = $isql. " USUA_PERM_RESPUESTA = 0,";
    if($_POST["usua_radmail"]){
        $isql = $isql. " USUA_PERM_RADEMAIL = 1,";
    }
    else
       $isql = $isql. " USUA_PERM_RADEMAIL = 0,"; 
    
   

        
     
    /////////////////////////  PERMISOS TIPOS DE RADICADOS /////////////////////
    $cad = "perm_tp";
    $sql = "SELECT SGD_TRAD_CODIGO,SGD_TRAD_DESCR,SGD_TRAD_GENRADSAL FROM SGD_TRAD_TIPORAD ORDER BY SGD_TRAD_CODIGO";
    $rs_trad = $db->query($sql);
    while ($arr = $rs_trad->FetchRow()) {
        $isql = $isql . " USUA_PRAD_TP" . $arr['SGD_TRAD_CODIGO'] . " = " . ${$cad . $arr['SGD_TRAD_CODIGO']} . ", ";
    }
    ////////////////////////////////////////////////////////////////////////////

    if ($modificaciones) {
        $isql = $isql . " USUA_PERM_MODIFICA = 1, ";
    }
    else
        $isql = $isql . " USUA_PERM_MODIFICA = 0, ";

    if ($notifica) {
        $isql = $isql . " USUA_PERM_NOTIFICA = 1, ";
    }
    else
        $isql = $isql . " USUA_PERM_NOTIFICA = 0, ";

    if ($usua_permexp)
        $isql = $isql . " USUA_PERM_EXPEDIENTE = $usua_permexp, ";
    else
        $isql = $isql . " USUA_PERM_EXPEDIENTE = 0, ";
    if ($usua_super)
        $isql = $isql . " USUA_SUPER_PERM = $usua_super, ";
    else
        $isql = $isql . " USUA_SUPER_PERM = 0, ";
    if ($usua_activo)
        $isql = $isql . " USUA_ESTA = '1', ";
    else {
        $isql = $isql . " USUA_ESTA = '0', ";
        if ($radicado) {
            ?>
            <table align="center" border="2" bordercolor="#000000">
                <form name="frmAbortar" action="../formAdministracion.php" method="post">
                    <tr bordercolor="#FFFFFF"> <td width="211" height="30" colspan="2" class="listado2"><p><span class=etexto>
                                    <center><B>El usuario <?= $usuLogin ?> tiene radicados a su cargo, NO PUEDE INACTIVARSE</B></center>
                                </span></p> </td> </tr>
                    <tr bordercolor="#FFFFFF">	<td height="30" colspan="2" class="listado2">
                    <center><input class="botones" type="submit" name="Submit" value="Aceptar"></center>
                    <input name="PHPSESSID" type="hidden" value='<?= session_id() ?>'>
                    <input name="krd" type="hidden" value='<?= $krd ?>'>
                    </td> </tr>
                </form>
            </table>
            <?php
            $swConRadicado = "SI";
            return;
        }
    }

    if ($tablas)
        $isql = $isql . " USUA_PERM_TRD = '1', ";
    else
        $isql = $isql . " USUA_PERM_TRD = '0', ";

    //Nivel de Seguridad
    if (!$nivel)
        $nivel = 1;
    $isql = $isql . " CODI_NIVEL = $nivel ";
    $isql = $isql . " where USUA_LOGIN = '" . $usuLogin . "'";
    
     echo $isql;
    
    $isql1 = "select * from USUARIO WHERE USUA_LOGIN = '" . $usuLogin . "'";
    $rs1 = $db->query($isql1);
    $rs = $db->query($isql);
    $isqldesp = "select * from USUARIO WHERE USUA_LOGIN = '" . $usuLogin . "'";
    $rs = $db->query($isqldesp);
}
?>
<html>
    <head>
        <title></title>
    </head>
    <body style="background-color:#FFFFFF">
        <?php
        
        if ($db->conn->Execute($isql) == false) {
            echo "Existe un error en los datos diligenciados";
        } else {
            if ($rs->fields["USUA_ESTA"] <> $rs1->fields["USUA_ESTA"]) {
                $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN) VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . ", " . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 9, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                $db->conn->Execute($isql);
            }

            if ($rs->fields["USUA_PRAD_TP1"] <> $rs1->fields["USUA_PRAD_TP1"]) {
                if ($rs->fields["USUA_PRAD_TP1"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 19, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PRAD_TP1"] == 2) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 2, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PRAD_TP1"] == 3) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 35, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PRAD_TP2"] <> $rs1->fields["USUA_PRAD_TP2"]) {
                if ($rs->fields["USUA_PRAD_TP2"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN) VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . ", " . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 41, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
                if ($rs->fields["USUA_PRAD_TP2"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN) VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . ", " . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 10, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PRAD_TP2"] == 2) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 11, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["PERM_RADI"] <> $rs1->fields["PERM_RADI"]) {
                if ($rs->fields["PERM_RADI"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "',46, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["PERM_RADI"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 45, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_ADMIN_SISTEMA"] <> $rs1->fields["USUA_ADMIN_SISTEMA"]) {
                if ($rs->fields["USUA_ADMIN_SISTEMA"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 12, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_ADMIN_SISTEMA"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 13, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PERM_PRESTAMO"] <> $rs1->fields["USUA_PERM_PRESTAMO"]) {
                if ($rs->fields["USUA_PERM_PRESTAMO"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 44, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_PRESTAMO"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 43, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }
            /*
              if ($rs->fields["USUA_PERM_REMIT_TERCERO"]<>$rs1->fields["USUA_PERM_REMIT_TERCERO"])
              {
              if ($rs->fields["USUA_PERM_REMIT_TERCERO"]==0)
              {
              $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '". $usua_doc."', ".$rs1->fields["USUA_CODI"].",".$rs1->fields["DEPE_CODI"].", '".$cedula."', 44, ".$sqlFechaHoy.", '".$usuLogin."')";
              $db->conn->Execute($isql);
              }
              elseif ($rs->fields["USUA_PERM_REMIT_TERCERO"]==1)
              {
              $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '". $usua_doc."', ".$rs1->fields["USUA_CODI"].",".$rs1->fields["DEPE_CODI"].", '".$cedula."', 43, ".$sqlFechaHoy.", '".$usuLogin."')";
              $db->conn->Execute($isql);
              }
              }
             */

            if ($rs->fields["USUA_ADMIN_ARCHIVO"] <> $rs1->fields["USUA_ADMIN_ARCHIVO"]) {
                if ($rs->fields["USUA_ADMIN_ARCHIVO"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 14, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_ADMIN_ARCHIVO"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 15, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_ADMIN_ARCHIVO"] == 2) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 76, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }
            if ($rs->fields["PERM_ARCHI"] <> $rs1->fields["PERM_ARCHI"]) {
                if ($rs->fields["PERM_ARCHI"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 77, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["PERM_ARCHI"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 78, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_NUEVO"] <> $rs1->fields["USUA_NUEVO"]) {
                if ($rs->fields["USUA_NUEVO"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 16, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_NUEVO"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 17, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["CODI_NIVEL"] <> $rs1->fields["CODI_NIVEL"]) {
                $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 18, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                $db->conn->Execute($isql);
            }

            if ($rs->fields["USUA_MASIVA"] <> $rs1->fields["USUA_MASIVA"]) {
                if ($rs->fields["USUA_MASIVA"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 22, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_MASIVA"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 21, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                    $isql = "SELECT CODI_CARP FROM CARPETA_PER WHERE USUA_CODI = " . $nusua_codi . " AND DEPE_CODI = " . $dep_sel . " and CODI_CARP=5";
                    $rsCarp = $db->query($isql);
                    $carpMasiva = $rsCarp->fields["CODI_CARP"];
                    if (!$carpMasiva) {
                        $isql = "INSERT INTO CARPETA_PER (USUA_CODI, DEPE_CODI, NOMB_CARP, DESC_CARP, CODI_CARP) VALUES (" . $nusua_codi . ", " . $dep_sel . ", 'Masiva', 'Radicacion Masiva', 5 )";
                        $db->conn->Execute($isql);
                    }
                }
            }


            if ($rs->fields["USUA_PERM_DEV"] <> $rs1->fields["USUA_PERM_DEV"]) {
                if ($rs->fields["USUA_PERM_DEV"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 23, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_DEV"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 24, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["SGD_PANU_CODI"] <> $rs1->fields["SGD_PANU_CODI"]) {
                if ($rs->fields["SGD_PANU_CODI"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 25, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["SGD_PANU_CODI"] == 2) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 26, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["SGD_PANU_CODI"] == 3) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 27, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["SGD_PANU_CODI"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 42, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PERM_IMPRESION"] <> $rs1->fields["USUA_PERM_IMPRESION"]) {
                if ($rs->fields["USUA_PERM_IMPRESION"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 47, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_IMPRESION"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 20, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_IMPRESION"] == 2) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 64, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PERM_ENVIOS"] <> $rs1->fields["USUA_PERM_ENVIOS"]) {
                if ($rs->fields["USUA_PERM_ENVIOS"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 33, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_ENVIOS"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 34, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["SGD_PERM_ESTADISTICA"] <> $rs1->fields["SGD_PERM_ESTADISTICA"]) {
                if ($rs->fields["SGD_PERM_ESTADISTICA"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 53, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["SGD_PERM_ESTADISTICA"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 54, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["SGD_PERM_ESTADISTICA"] == 2) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 63, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }
// Inicio modificacion 25 sep 2006
            if ($rs->fields["USUA_PERM_EXPEDIENTE"] <> $rs1->fields["USUA_PERM_EXPEDIENTE"]) {
                if ($rs->fields["USUA_PERM_EXPEDIENTE"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 71, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_EXPEDIENTE"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 70, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_EXPEDIENTE"] == 2) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 75, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PERM_MODIFICA"] <> $rs1->fields["USUA_PERM_MODIFICA"]) {
                if ($rs->fields["USUA_PERM_MODIFICA"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 49, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_MODIFICA"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 48, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PERM_FIRMA"] <> $rs1->fields["USUA_PERM_FIRMA"]) {
                if ($rs->fields["USUA_PERM_FIRMA"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 59, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_FIRMA"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 60, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_FIRMA"] == 2) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 61, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_FIRMA"] == 3) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 62, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PERM_TRD"] <> $rs1->fields["USUA_PERM_TRD"]) {
                if ($rs->fields["USUA_PERM_TRD"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 52, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_TRD"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 51, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUARIO_PUBLICO"] <> $rs1->fields["USUARIO_PUBLICO"]) {
                if ($rs->fields["USUARIO_PUBLICO"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 56, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUARIO_PUBLICO"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 55, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PERM_NOTIFICA"] <> $rs1->fields["USUA_PERM_NOTIFICA"]) {

                if ($rs->fields["USUA_PERM_NOTIFICA"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 79, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_NOTIFICA"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 80, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }


            if ($rs->fields["USUA_PERM_REMIT_TERCERO"] <> $rs1->fields["USUA_PERM_REMIT_TERCERO"]) {
                if ($rs->fields["USUA_PERM_REMIT_TERCERO"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 81, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_REMIT_TERCERO"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 82, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PRAD_TPX"] <> $rs1->fields["USUA_PRAD_TPX"]) {
                if ($rs->fields["USUA_PRAD_TPX"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 83, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PRAD_TPX"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 84, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PRAD_TPX"] == 2) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 85, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PRAD_TPX"] == 3) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 86, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_PRAD_REPRAD"] <> $rs1->fields["USUA_PRAD_REPRAD"]) {
                if ($rs->fields["USUA_PRAD_REPRAD"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 87, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PRAD_REPRAD"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 88, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["PERM_BORRAR_ANEXO"] <> $rs1->fields["PERM_BORRAR_ANEXO"]) {
                if ($rs->fields["PERM_BORRAR_ANEXO"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 89, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["PERM_BORRAR_ANEXO"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 90, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["PERM_TIPIF_ANEXO"] <> $rs1->fields["PERM_TIPIF_ANEXO"]) {
                if ($rs->fields["PERM_TIPIF_ANEXO"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 91, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["PERM_TIPIF_ANEXO"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 92, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUA_AUTH_LDAP"] <> $rs1->fields["USUA_AUTH_LDAP"]) {
                if ($rs->fields["USUA_AUTH_LDAP"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 93, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_AUTH_LDAP"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 94, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }
            if ($rs->fields["USUA_PERM_ADMINFLUJOS"] <> $rs1->fields["USUA_PERM_ADMINFLUJOS"]) {
                if ($rs->fields["USUA_PERM_ADMINFLUJOS"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 95, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUA_PERM_ADMINFLUJOS"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 96, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }

            if ($rs->fields["USUARIO_REASIGNAR"] <> $rs1->fields["USUARIO_REASIGNAR"]) {
                if ($rs->fields["USUARIO_REASIGNAR"] == 0) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 58, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                } elseif ($rs->fields["USUARIO_REASIGNAR"] == 1) {
                    $isql = "INSERT INTO SGD_USH_USUHISTORICO (SGD_USH_ADMCOD, SGD_USH_ADMDEP, SGD_USH_ADMDOC, SGD_USH_USUCOD, SGD_USH_USUDEP, SGD_USH_USUDOC, SGD_USH_MODCOD, SGD_USH_FECHEVENTO, SGD_USH_USULOGIN)  VALUES ($codusuario, $dependencia, '" . $usua_doc . "', " . $rs1->fields["USUA_CODI"] . "," . $rs1->fields["DEPE_CODI"] . ", '" . $cedula . "', 57, " . $sqlFechaHoy . ", '" . $usuLogin . "')";
                    $db->conn->Execute($isql);
                }
            }
        }
        ?>
    </body>
</html>
