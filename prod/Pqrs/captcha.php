<?php
session_start();
/**
  * @autor Sebastian Ortiz V.
  * @correlibre
  * @licencia GNU/GPL V 3
  */

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;

header('Content-Type: text/html; charset=UTF-8');
include('./captcha/simple-php-captcha.php');

//Si la acccion es recargar
if(isset($recargar) && $recargar=="si"){
	$_SESSION['captcha_formulario'] = captcha();
	echo $_SESSION['captcha_formulario']['image_src'];
	return;
}
$strcmpresult = strcasecmp ($captcha,$_SESSION['captcha_formulario']['code'] );
if($strcmpresult == 0){
	echo "true";
}
else {
	echo "false";
}
?>
