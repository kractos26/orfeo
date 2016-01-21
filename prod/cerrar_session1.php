<?php
session_start();
$ruta_raiz = ".";
include_once "./include/db/ConnectionHandler.php";
$db = new ConnectionHandler(".");
error_reporting(7);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);	
$fecha = "'FIN  ".date("Y:m:d H:mi:s")."'";
//$db->conn->debug=true;
$isql = "update usuario set usua_sesion=".$fecha." where USUA_SESION like '%".substr(session_id(),0,29)."%'";
//echo "Fecha $fecha "; // --- Session ->".substr(session_id(),0,29);
if (!$db->conn->query($isql))
{
	echo "<p><center>No pude actualizar<p><br>";
}
//  fin cierre session
session_destroy();
include "./paginaError.php"
?>