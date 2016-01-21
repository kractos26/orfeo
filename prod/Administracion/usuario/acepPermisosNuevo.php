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
/*   Sixto Angel Pinz�n L�pez --- angel.pinzon@gmail.com   Desarrollador             */
/* C.R.A.  "COMISION DE REGULACION DE AGUAS Y SANEAMIENTO AMBIENTAL"                 */
/*   Lucia Ojeda          lojedaster@gmail.com             Desarrolladora            */
/* D.N.P. "Departamento Nacional de Planeaci�n"                                      */
/*   Hollman Ladino       hollmanlp@gmail.com                Desarrollador           */
/*                                                                                   */
/* Colocar desde esta linea las Modificaciones Realizadas Luego de la Version 3.5    */
/*  Nombre Desarrollador   Correo     Fecha   Modificacion                           */
/* * ********************************************************************************** */

if ($usuLogin) {
    $isql_inicial .= " USUA_PRAD_TPX, ";
    $isql_final = $isql_final . " $perm_tpx, ";
    if ($perm_reprad) {
        $isql_inicial .= " USUA_PRAD_REPRAD, ";
        $isql_final = $isql_final . " 1, ";
    } else {
        $isql_inicial .= " USUA_PRAD_REPRAD, ";
        $isql_final = $isql_final . " 0, ";
    }
    if ($prestamo) {
        $isql_inicial = $isql_inicial . " USUA_PERM_PRESTAMO, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_PRESTAMO, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($digitaliza) {
        $isql_inicial = $isql_inicial . " PERM_RADI, ";
        $isql_final = $isql_final . "$digitaliza, ";
    } else {
        $isql_inicial = $isql_inicial . " PERM_RADI, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($masiva) {
        $isql_inicial = $isql_inicial . " USUA_MASIVA, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_MASIVA, ";
        $isql_final = $isql_final . "0, ";
    }

    /////////////////////////  PERMISOS TIPOS DE RADICADOS /////////////////////
    $cad = "perm_tp";
    $sql = "SELECT SGD_TRAD_CODIGO,SGD_TRAD_DESCR,SGD_TRAD_GENRADSAL FROM SGD_TRAD_TIPORAD ORDER BY SGD_TRAD_CODIGO";
    $rs_trad = $db->query($sql);
    while ($arr = $rs_trad->FetchRow()) {
        $isql_inicial .= "USUA_PRAD_TP" . $arr['SGD_TRAD_CODIGO'] . ", ";
        $isql_final .= ${$cad . $arr['SGD_TRAD_CODIGO']} . ", ";
    }
    ////////////////////////////////////////////////////////////////////////////

    if ($modificaciones) {
        $isql_inicial = $isql_inicial . "USUA_PERM_MODIFICA, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . "USUA_PERM_MODIFICA, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($impresion) {
        $isql_inicial = $isql_inicial . " USUA_PERM_IMPRESION, ";
        $isql_final = $isql_final . $impresion . ", ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_IMPRESION, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($remitenteTerceros) {
        $isql_inicial = $isql_inicial . " USUA_PERM_REMIT_TERCERO, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_REMIT_TERCERO, ";
        $isql_final = $isql_final . "0, ";
    }
    if($_POST['ciudadanosempresas']){
         $isql_inicial = $isql_inicial . " USUA_PERM_CIUDADANOSEMPRESAS, ";
         $isql_final = $isql_final . "1, ";
    }else{
        $isql_inicial = $isql_inicial . " USUA_PERM_CIUDADANOSEMPRESAS, ";
        $isql_final = $isql_final . "0, ";
    }
       if($_POST['adminispqrs'])
        {  $isql_inicial = $isql_inicial . "USUA_PERM_ADMINISTRACIONPQR , ";
               $isql_final = $isql_final . "1, ";
        }
     else{       
                         $isql_inicial = $isql_inicial . "USUA_PERM_ADMINISTRACIONPQR, ";
                        $isql_final = $isql_final . "0, ";
        }

    if ($usua_super) {
        $isql_inicial = $isql_inicial . " usua_super_perm, ";
        $isql_final = $isql_final . "$usua_super, ";
    } else {
        $isql_inicial = $isql_inicial . " usua_super_perm, ";
        $isql_final = $isql_final . "0, ";
    }
    if($emailNotif){
        $isql_inicial = $isql_inicial . " email_notif, ";
        $isql_final = $isql_final . "1, ";
    }else{
        $isql_inicial = $isql_inicial . " email_notif, ";
        $isql_final = $isql_final . "0, ";
    }

    if (($s_anulaciones) && !($anulaciones)) {
        $isql_inicial = $isql_inicial . " SGD_PANU_CODI, ";
        $isql_final = $isql_final . "1, ";
    }
    if (($anulaciones) && !($s_anulaciones)) {
        $isql_inicial = $isql_inicial . " SGD_PANU_CODI, ";
        $isql_final = $isql_final . "2, ";
    }
    if (($s_anulaciones) && ($anulaciones)) {
        $isql_inicial = $isql_inicial . " SGD_PANU_CODI, ";
        $isql_final = $isql_final . "3, ";
    } else {
        $isql_inicial = $isql_inicial . " SGD_PANU_CODI, ";
        $isql_final = $isql_final . "0, ";
    }
    if ($adm_archivo) {
        $isql_inicial = $isql_inicial . " USUA_ADMIN_ARCHIVO, ";
        $isql_final = $isql_final . "$adm_archivo, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_ADMIN_ARCHIVO, ";
        $isql_final = $isql_final . "0, ";
    }
    if ($dev_correo) {
        $isql_inicial = $isql_inicial . " USUA_PERM_DEV, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_DEV, ";
        $isql_final = $isql_final . "0, ";
    }
    if ($adm_sistema) {
        $isql_inicial = $isql_inicial . " USUA_ADMIN_SISTEMA, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_ADMIN_SISTEMA, ";
        $isql_final = $isql_final . "0, ";
    }
    if ($usua_nuevoM) {
        $isql_inicial = $isql_inicial . " USUA_NUEVO, ";
        $isql_final = $isql_final . "0, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_NUEVO, ";
        $isql_final = $isql_final . "1, ";
    }
    if ($env_correo) {
        $isql_inicial = $isql_inicial . " USUA_PERM_ENVIOS, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_ENVIOS, ";
        $isql_final = $isql_final . "0, ";
    }
    if ($estadisticas) {
        $isql_inicial = $isql_inicial . " SGD_PERM_ESTADISTICA, ";
        $isql_final = $isql_final . $estadisticas . ", ";
    } else {
        $isql_inicial = $isql_inicial . " SGD_PERM_ESTADISTICA, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($usua_activo) {
        $isql_inicial = $isql_inicial . " USUA_ESTA, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_ESTA, ";
        $isql_final = $isql_final . "0, ";
    }
    if ($tablas) {
        $isql_inicial = $isql_inicial . " USUA_PERM_TRD, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_TRD, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($usua_publico) {
        $isql_inicial = $isql_inicial . " USUARIO_PUBLICO, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUARIO_PUBLICO, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($reasigna) {
        $isql_inicial = $isql_inicial . " USUARIO_REASIGNAR, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUARIO_REASIGNAR, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($firma) {
        $isql_inicial = $isql_inicial . " USUA_PERM_FIRMA, ";
        $isql_final = $isql_final . $firma . ", ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_FIRMA, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($notifica) {
        $isql_inicial = $isql_inicial . " USUA_PERM_NOTIFICA, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_NOTIFICA, ";
        $isql_final = $isql_final . "0, ";
    }
    if ($permBorraAnexos) {

        $isql_inicial = $isql_inicial . " PERM_BORRAR_ANEXO, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " PERM_BORRAR_ANEXO, ";
        $isql_final = $isql_final . "0, ";
    }
    if ($permTipificaAnexos) {
        $isql_inicial = $isql_inicial . " PERM_TIPIF_ANEXO, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " PERM_TIPIF_ANEXO, ";
        $isql_final = $isql_final . "0, ";
    }

    if ($perm_adminflujos) {
        $isql_inicial = $isql_inicial . " USUA_PERM_ADMINFLUJOS , ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_ADMINFLUJOS , ";
        $isql_final = $isql_final . "0, ";
    }
    if ($autenticaLDAP) {
        $isql_inicial = $isql_inicial . " USUA_AUTH_LDAP, ";
        $isql_final = $isql_final . "1, ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_AUTH_LDAP, ";
        $isql_final = $isql_final . "0, ";
    }
    if ($usua_permexp) {
        $isql_inicial = $isql_inicial . " USUA_PERM_EXPEDIENTE, ";
        $isql_final = $isql_final . $usua_permexp . ", ";
    } else {
        $isql_inicial = $isql_inicial . " USUA_PERM_EXPEDIENTE, ";
        $isql_final = $isql_final . "0, ";
    }

    //Nivel de Seguridad
    if (!$nivel)
        $nivel = 1;
    $isql_inicial = $isql_inicial . " CODI_NIVEL) ";
    $isql_final = $isql_final . $nivel . ") ";
}
?>
