<?php
session_start();
$ruta_raiz="..";
if(!isset($_SESSION['dependencia']))include "../rec_session.php";
define('ADODB_ASSOC_CASE', 1);
require_once("../include/db/ConnectionHandler.php");
include "../include/tx/Tx.php";
include "../class_control/usuario.php";
$db = new ConnectionHandler('..');
$objTx = new Tx($db);
$objUsu = new Usuario($db);
switch ($_POST['i'])
{
	case 1:
			echo $objTx->verficaNivel($_POST['rads'],1);	
		break;
	case 2:
			echo $objUsu->usuaDepSeguridadRad($_POST['deps'],$_POST['numRad']);
		break;
	case 3:
			echo $objUsu->usuaDepSeguridadExp($_POST['deps'],$_POST['numExp'],$_POST['usuSel']);
		break;
	case 4:
			$rs=$objUsu->borraUsuSeguridadExp($_POST['login'],$_POST['numExp']);
			if($rs)echo $objUsu->tblUsuSeguridadExp($_POST['numExp']);
		break;			
	default:
		break;
}
?>