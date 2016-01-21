<?php
session_start();
if(!isset($_SESSION['dependencia']))include "../rec_session.php";
include("../../config.php");
include("../../include/class/Plantillas.class.php");
include_once "../../include/db/ConnectionHandler.php";
$db = new ConnectionHandler("../..");
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
$objPln = new Plantilla($db);

$fec=$_GET['fec']?$_GET['fec']:$_POST['fec'];
$tipoAyuda=$_GET['tipoAyuda']?$_GET['tipoAyuda']:$_POST['tipoAyuda'];
switch ($fec)
{
	case 1:
		$objPln->borraArchivo($_GET['rut']);
		echo $objPln->vistaDir("../../$carpetaBodega/Ayuda/",1,"../..");
		if($objPln->error)$error=$objPln->error;
		break;
	case 2:
		$objPln->agregaArchivo($tipoAyuda);
		$tbl=$objPln->vistaDir("../../$carpetaBodega/Ayuda/",1,"../..");
		if($objPln->error)$error=$objPln->error;
		include("./vPlantillas.php");
		break;
	default:
		$tbl=$objPln->vistaDir("../../$carpetaBodega/Ayuda/",1,"../..");
		include("./vPlantillas.php");
		break;
}
?>