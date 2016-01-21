<?php
session_start();

    if (!$_SESSION['dependencia'])
        header ("Location: $ruta_raiz/cerrar_session.php");

	$nomfile="orfeoReport-".date("Y-m-d").".doc"; 	
	header("Content-type: application/msword; ");
	header("Content-Disposition: filename=\"$nomfile\";");
	include("adodb-basedoc.inc.php");
?>
