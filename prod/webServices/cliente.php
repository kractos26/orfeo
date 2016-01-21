
<?php 
require_once('nusoap/lib/nusoap.php');

$wsdl="http://172.16.0.147:81/~gmahecha/orfeo_3.6.0/webServices/servidor.php?wsdl"; 

$client=new soapclient2($wsdl, 'wsdl');  
//$extension = explode(".",$archivo_name);
//copy($archivo, "../bodega/tmp/visitas/".$archivo_name);

$arregloDatos = array();

$a = $client->call('crearRadicado',array());
var_dump($a);



?>



