<?
if (!$ruta_raiz) $ruta_raiz = ".";  
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
include("$ruta_raiz/config.php");
$db = new ConnectionHandler("."); 
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
$sec=$db->nextId("secr_pruebayo");
print ("Se obtiene ($sec)");



?>