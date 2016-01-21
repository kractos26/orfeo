<?php
 // include the server class
include 'HTML/AJAX/Server.php';
/**
 * Advanced usage of HTML_AJAX_Server
 * Allows for a single server to manage exporting a large number of classes without high overhead per call
 * Also gives a single place to handle setup tasks especially useful if session setup is required
 *
 * The server responds to ajax calls and also serves the js client libraries, so they can be used directly from the PEAR data dir
 * 304 not modified headers are used when server client libraries so they will be cached on the browser reducing overhead
 *
 * @category   HTML
 * @package    AJAX
 * @author     Joshua Eichorn <josh@bluga.net>
 * @copyright  2005 Joshua Eichorn
 * @license    http://www.opensource.org/licenses/lgpl-license.php  LGPL
 * @version    Release: 0.5.6
 * @link       http://pear.php.net/package/HTML_AJAX
 */
// extend HTML_AJAX_Server creating our own custom one with init{ClassName} methods for each class it supports calls on
class UsuariosServer extends HTML_AJAX_Server {
	// this flag must be set to on init methods
	var $initMethods = false;
	//Conexion a Base de datos de Orfeo
	var $db;
  var $ruta_raiz;
	// init method for the testHaa class, includes needed files an registers it for ajax, directly passes in methods to register to specify case in php4
	function initUsuarios() {
    $ruta_raiz = "../../..";
    //alert("Entro a initUsuarios");
		include 'usuarios.class.php';
		$this->registerClass(new usuarios($this->db,$this->ruta_raiz),'usuarios',array('getUsuarios','informarUsuario','borrarInformado','borrarDerivado'));
  
	}
	function conexion($db,$ruta_raiz)
	{
	  $this->db = $db;
    $this->ruta_raiz = $ruta_raiz;
	}	
}

// create an instance of our test server

  include_once ("../../../include/db/ConnectionHandler.php");
  $ruta_raiz = "../../..";
  $db = new ConnectionHandler($ruta_raiz);
  $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
  //error_reporting(7);
  
$server = new UsuariosServer();
$server->conexion($db,$ruta_raiz);
$server->initUsuarios();
$server->handleRequest();
?>