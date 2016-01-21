<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$ruta_raiz = "../..";
   
    include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");	
define('ADODB_FETCH_ASSOC',2);

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db->conn->debug = true;
$datos = explode(",", $_POST['ids']);
include 'ModificarCampos.php';

header('Location:VistaDatosDestinatario.php?formulario='.$_POST['formulario'].'');
?>

