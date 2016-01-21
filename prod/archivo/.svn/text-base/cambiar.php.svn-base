<? 
$per=1;
session_start();
/**
  * Modificacion Variables Globales Fabian losada 2009-07
  * Licencia GNU/GPL 
  */

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;


$krd = $_SESSION["krd"];
$dependencia = $_SESSION["dependencia"];
$usua_doc = $_SESSION["usua_doc"];
$codusuario = $_SESSION["codusuario"];
$tpNumRad = $_SESSION["tpNumRad"];
$tpPerRad = $_SESSION["tpPerRad"];
$tpDescRad = $_SESSION["tpDescRad"];
$tpDepeRad = $_SESSION["tpDepeRad"];
$ruta_raiz = "..";
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");

include_once "$ruta_raiz/include/tx/Historico.php";
$objHistorico= new Historico($db);
$encabezado = session_name()."=".session_id()."&krd=$krd&nomcarpeta=$nomcarpeta";
?>
<html height=50,width=150>
<head>
<title>Cambio Estado Expediente</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
<body bgcolor="#FFFFFF">

<form name=cambiar action="lista_expediente.php?<?=$encabezado?>" method='get'>
<?
$dat=date("Y-m-d");
$sqle="update SGD_EXP_EXPEDIENTE set SGD_EXP_ARCHIVO='$est',SGD_EXP_FECHFIN='$dat' where SGD_EXP_NUMERO LIKE '$expediente'";
$rs=$db->query($sqle);
$arrayRad[0]=$numRad;
$isqlDepR = "SELECT USUA_CODI
			FROM usuario
			WHERE USUA_LOGIN = '$krd'";
	$rsDepR = $db->conn->Execute($isqlDepR);
	$codusua = $rsDepR->fields['USUA_CODI'];
if ($est==2){
	$observa = "Se Cerro el Expediente  ";
	$objHistorico->insertarHistoricoExp($expediente,$arrayRad,$dependencia, $codusua,$observa,58,1);
?>
<center>El Expediente fue Cerrado
<?
}
if ($est==1){
	$observa = "Se Reabrio el Expediente  ";
	$objHistorico->insertarHistoricoExp($expediente,$arrayRad,$dependencia, $codusua,$observa,59,1);
?>

<center>El Expediente fue Reabierto
<?
}
?>

<input type="button" value="Cerrar" class="botones_3" onClick="opener.regresar();window.close()">
</center>
</form>
</html>