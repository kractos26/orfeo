<?php
error_reporting(0);
$krdAnt = $krd;
session_start(); 
if(!$krd)  $krd = $krdAnt;
$ruta_raiz = "..";
if (!$dependencia)   include "../rec_session.php";
error_reporting(7);
define('ADODB_ASSOC_CASE', 1); 
include_once "../include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
$db->conn->SetFetchMode(ADODB_FETCH_NUM);
$fechah = date("ymd") ."_". time("hms");
   include("functions.php");
   $vars = session_name()."=".session_id()."&krd=$krd&ent=2";
?>
<html>
<head>
  <title>form</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body>
<?php
	switch($lista)
	{
		case "inbox":
	 		recvq_list();
	 	break;
		case "historico":
	 		recvq_list_historico();
	 	break;
	 	case "outbox":
	 		doneq_list();
	 	break;
	 	case "process":
	 		sendq_list();
	 	break;
	 	case "faxStat":
	 		faxStat_list();
	 	break;
	 	default:
	 		recvq_list();
	 	break;
	}
?>
</body>
</html>