<?php
session_start();
if ( (strpos( $_SERVER['HTTP_REFERER'], "principal.php")===false) && (!isset($_SESSION['dependencia'])) ) {
    die("Mal Acceso a la p&aacute;gina .");
}
if (!isset($_GET['fec'])) {
    die("No ingres&oacute; datos");
}

include("config.php");
include './include/class/mime.class.php';
$ruta = "$carpetaBodega" . base64_decode($_GET['fec']);
if (file_exists($ruta)) {//
    if (isset($_GET['ln']) && base64_decode($_GET['ln']) == "check") {
        if (!$ruta_raiz)
            $ruta_raiz = ".";
        if (!isset($_SESSION['dependencia']))
            include "./rec_session.php";
        if (!defined('ADODB_ASSOC_CASE'))
            define('ADODB_ASSOC_CASE', 1);
        include_once "./include/db/ConnectionHandler.php";
        $db = new ConnectionHandler(".");
//$db->conn->debug=true;
        $db->conn->SetFetchMode(3);
        $pieces = explode("/", $ruta);
        $archNomb = end($pieces);
        $sql = "select anex_radi_nume radicado,anex_nomb_archivo,sgd_spub_codigo priv
                from anexos 
                inner join radicado rad on rad.radi_nume_radi=anex_radi_nume
                where anex_nomb_archivo like '%$archNomb%'";
        $rs = $db->conn->Execute($sql);
        $verrad = $rs->fields['RADICADO'];
        $nivelRad = $rs->fields['PRIV'];
        if ($nivelRad == 0) {
            $verradPermisos = "Full";
        } elseif ($nivelRad == 2) {
            if ($nivelRad == 2 and $spubDepe != $_SESSION['dependencia']) {
                $verradPermisos = "otro";
            } else {
                $verradPermisos = "Full";
            }
        } elseif ($nivelRad == 3) {
            $sql = "select * from sgd_matriz_nivelrad where radi_nume_radi=$verrad and usua_login='" . $_SESSION['krd'] . "'";
            $rsVerif = $db->conn->Execute($sql);
            if ($rsVerif && $rsVerif->EOF) {
                $verradPermisos = "otro";
            }
        } else {
            require "$ruta_raiz/Administracion/usuario/SecSuperClass.php";
            $SecSuperAux = new SecSuperClass($db);
            $SecSuperAux->SecSuperFill($_SESSION['usua_doc']);
            include "$ruta_raiz/tx/verifSession.php";
        }
    } else {
        $verradPermisos = "Full";
    }
    if ($verradPermisos == "Full") {
        $nombre = substr($ruta, strripos($ruta, "/") + 1);
        $tipo = Mime::tipoMime($ruta);
        header("Content-type: $tipo");
        header('Content-Disposition: inline; filename="' . $nombre . '"');
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($ruta));
        readfile($ruta);
    } else {
        $numRad = $verrad;
        $radi_depe_actu = $verDependencia;
        $radi_usua_actu = $verCodusuario;
        include "$ruta_raiz/seguridad/sinPermisoRadicado.php";
        die("-");
    }
}
else
    header("Location: error/HTTP_NOT_FOUND.html");
?>
