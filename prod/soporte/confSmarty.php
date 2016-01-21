<?php
session_start();

	$ruta_raiz = "../";
    if (!$_SESSION['dependencia'])
        header ("Location: $ruta_raiz/cerrar_session.php");
    /*
     * Created on 14/07/2010
     * Archivo de configuracion de todos los script de la aplicacion soportes.
     * 
     * Se colocan como prederterminadas y comunes la creacion de un objeto
     * de adodb, configuracion de smarty, session
     * captura de mensajes get y post. 
     */ 

    $ruta_libs = "";
	
	//Paremetros get y pos enviados desde la apliacion origen
	import_request_variables("gP", "");	
	
	//Confirmar existencia de session 
		if(!isset($_SESSION['dependencia']))
			include "$ruta_raiz/rec_session.php";		
            
	define('SMARTY_DIR', $ruta_libs.'libs/');
	
	//inicio de de ododb
	include_once	("$ruta_raiz/include/db/ConnectionHandler.php");
	$db = new ConnectionHandler("$ruta_raiz");
	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
	$sqlFechaHoy	=	$db->conn->DBDate($fecha_hoy);
	
	require_once(SMARTY_DIR . 'Smarty.class.php');
	//Se configuran los parametros de smarty
	$smarty = new Smarty;
	$smarty->template_dir = './templates';
	$smarty->compile_dir = './templates_c';
	$smarty->left_delimiter = '<!--{';
	$smarty->right_delimiter = '}-->';
	
	$dependencia 	= trim($_SESSION['depecodi']);
	$codusuario		= trim($_SESSION['codusuario']);
	$usua_doc		= trim($_SESSION['usua_doc']);
	
	$smarty->assign("krd"	,$krd);			//recarga de session con el krd 
?>
