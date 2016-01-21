<?php
session_start();
	
	$ruta_raiz = "../..";
    $ruta_libs = "../";

	//Paremetros get y pos enviados desde la aplicacion origen
	import_request_variables("gP", "");	

	//Confirmar existencia de session
	if(!isset($_SESSION['dependencia']))
		include "$ruta_raiz/rec_session.php";


    //Realizamos la conexion 
	include_once	("$ruta_raiz/include/db/ConnectionHandler.php");
	$db 			= new ConnectionHandler("$ruta_raiz");
	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);	

    define('SMARTY_DIR', $ruta_libs.'libs/');
    require_once(SMARTY_DIR . 'Smarty.class.php');
    //Se configuran los parametros de smarty
    $smarty = new Smarty;
    $smarty->template_dir       = "$ruta_libs./templates";
    $smarty->compile_dir        = "$ruta_libs/templates_c";
    $smarty->left_delimiter     = '<!--{';
    $smarty->right_delimiter    = '}-->';

	header("Content-Type: text/plain");
	
	//Declaracion de la variables comunes a los archivos de este directorio
	$depenUsua		= $_SESSION['dependencia'];
	$codusuario		= $_SESSION["codusuario"];
	$usua_nomb		= $_SESSION["usua_nomb"];
	$usua_doc		= $_SESSION["usua_doc"];
	$login			= $_SESSION["krd"];
	
	$fecha_hoy 		= Date("Y-m-d");
	$sqlFechaHoy	= $db->conn->DBDate($fecha_hoy);
		
	//Funcion error : Retorna valor para ser leido por el javascript	
	function salirError ($mensaje) {
		$accion		= 	array( 'respuesta' 	=> false,
							   'mensaje'	=> $mensaje);
		print_r(json_encode($accion));
		exit;
	}
	
	//Filtrar caracteres extra�os en textos    
    function strValido($string){
        $arr    = array('/[^\w:()\sáéíóúÁÉÍÓÚ=#\-,.;ñÑ]+/', '/[\s]+/');
        $asu    = preg_replace($arr[0], '',$string);        
        return    trim(strtoupper(preg_replace($arr[1], ' ',$asu)));
    }
?>
