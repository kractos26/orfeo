<?php
session_start();
$ruta_raiz = "..";
if(!isset($_SESSION['dependencia']))include "../rec_session.php";
include("../config.php");
include("../include/class/Plantillas.class.php");
include_once "../include/db/ConnectionHandler.php";
$db = new ConnectionHandler("..");
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
$objPln = new Plantilla($db);
$tbl=$objPln->vistaDir("../$carpetaBodega/Ayuda/",0);
?>
<html>
<head>
<title>.: AYUDAS de Orfeo :.</title>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
</head>
<body>
<?php echo $tbl ?>
</body>
</html>