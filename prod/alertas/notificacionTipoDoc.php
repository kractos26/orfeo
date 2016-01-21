<?
session_start();  $ruta_raiz = ".."; 
//ini_set('display_errors',1);
require_once($ruta_raiz.'/include/PHPMailer_v5.1/class.phpmailer.php');
include_once $ruta_raiz."/conf/configPHPMailer.php";
   
    // if (!$_SESSION['dependencia'])   header ("Location: $ruta_raiz/cerrar_session.php");

/**
* Pagina Cuerpo.php que muestra el contenido de las Carpetas
* @autor Jairo Losada 2009-05 Correlibre.org
* @licencia GNU/GPL V 3
*/

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;


define('ADODB_ASSOC_CASE', 1);
$verrad         = "";
$krd            = $_SESSION["krd"];
$dependencia    = $_SESSION["dependencia"];
$usua_doc       = $_SESSION["usua_doc"];
$codusuario     = $_SESSION["codusuario"];
$tip3Nombre     = $_SESSION["tip3Nombre"];
$tip3desc       = $_SESSION["tip3desc"];
$tip3img        = $_SESSION["tip3img"];
$descCarpetasGen= $_SESSION["descCarpetasGen"] ;
$descCarpetasPer= $_SESSION["descCarpetasPer"];

$diasAlarma = $_GET["diasAlarma"];
if(!$diasAlarma) $diasAlarma = 5;
$_SESSION['numExpedienteSelected'] = null;
?>

<html>
<head>
    <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
    <script src="js/popcalendar.js"></script>
    <script src="js/mensajeria.js"></script>
    <div id="spiffycalendar" class="text"></div>
    <?php include_once "$ruta_raiz/js/funtionImage.php"; ?>
</head>

<?php include "$ruta_raiz/envios/paEncabeza.php"; ?>

<body bgcolor="#FFFFFF" topmargin="0" onLoad="window_onload();">

<?php

include_once    ("$ruta_raiz/include/db/ConnectionHandler.php");
require_once    ("$ruta_raiz/class_control/Mensaje.php");

if (!$db) $db = new ConnectionHandler($ruta_raiz);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
ini_set("display_errors",1);
$iSql = "
select r.radi_nume_radi,tpr.sgd_tpr_descrip,tpr.sgd_tpr_termino, r.radi_fech_radi, r.fech_vcmto,r.ra_asun
,extract('day' from (current_date - r.fech_vcmto)) as diasVcmto, radi_usua_actu, radi_depe_actu
from radicado  r, sgd_tpr_tpdcumento tpr 
where EXTRACT('day' from (current_date - r.fech_vcmto)) >=$diasAlarma
and tpr.sgd_tpr_codigo=r.tdoc_codi
and r.tdoc_codi=$tipoDocumental
and r.sgd_trad_codigo=2 and r.radi_depe_actu<>999 and r.radi_depe_actu<>205 ";
$rs = $db->conn->Execute("$iSql");
$codTx = 98;
?>
<table class=borde_tab>

<?
//y{
while (!$rs->EOF){
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
  $mail->IsSMTP(); // telling the class to use SMTP
  $mail->Host       = $hostPHPMailer; // SMTP server
  $mail->SMTPDebug  = $debugPHPMailer;                     // enables SMTP debug information (for testing) 2 debuger
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->Host       = $hostPHPMailer; // sets the SMTP server
  $mail->Port       = $portPHPMailer;                    // set the SMTP port for the GMAIL server
  $mail->Username   = $userPHPMailer; // SMTP account username
  $mail->Password   = $passwdPHPMailer;
  $mail->Timeout=30;


  sleep(5);
  $usuaCodiMail = $rs->fields["RADI_USUA_ACTU"];
  $depeCodiMail = $rs->fields["RADI_DEPE_ACTU"];
  $radicadosSelText = $rs->fields["RADI_NUME_RADI"] . ", ";
  $diasVencido = $rs->fields["DIASVCMTO"];
  echo "<tr class=listado2>";
  echo "<td>". $rs->fields["RADI_NUME_RADI"]."</td>";
  echo "<td>". $rs->fields["SGD_TPR_TERMINO"]."</td>";
  echo "<td>". $rs->fields["SGD_TPR_DESCRIP"]."</td>";
  echo "<td>". $rs->fields["RA_ASUN"]."</td>";
  echo "<td>". $rs->fields["RADI_FECH_RADI"]."</td>";
  echo "<td>". $rs->fields["FECH_VCMTO"]."</td>";
  echo "<td>". $rs->fields["DIASVCMTO"]."</td>";
  echo "<td>";
  $query = "select u.USUA_EMAIL
                from usuario u
                where u.USUA_CODI ='$usuaCodiMail' and  u.depe_codi='$depeCodiMail'";
  $rs2=$db->conn->query($query);
  $mailDestino = $rs2->fields["USUA_EMAIL"];
  // SMTP account password
  if(!$mailDestino) $mailDestino = "nestorvelasquez@gmail.com";
  $ii++;
  $mailDestinoTmp = $mailDestino;
  $mailDestino = "nestorvelasquez@gmail.com";
  $mail->AddAddress($mailDestino, "$mailDestinoTmp Prueba N $ii");
  $mail->SetFrom($admPHPMailer, $admPHPMailer);
  $mail->AddCC('atocora@dne.gov.co','Gestion Documetnal DNE');
  $mail->AddCC('nestorvelasquez@gmail.com','AdminOrfeo');
  $mail->AddCC('jlosada@gmail.com', 'pbcg');
  $mensaje = file_get_contents($ruta_raiz."/conf/MailNotificaTipoDoc.html");
  $asuntoMail =  $asuntoMailNotificaTipoDoc;
  $mail->Subject = "OrfeoGPL: $asuntoMail"; 
  $mail->AltBody = 'Para ver correctamente el mensaje, por favor use un visor de mail compatible con HTML!'; // optional - MsgHTML will create an alternate automatically
  $mensaje = str_replace("*RAD_S*", $radicadosSelText, $mensaje);
  $mensaje = str_replace("*USUARIO*", $krd, $mensaje);
  $linkImagenes = str_replace("*SERVIDOR_IMAGEN*",$servidorOrfeoBodega,$linkImagenes);
  $mensaje = str_replace("*IMAGEN*", $linkImagenes, $mensaje);
  $mensaje = str_replace("*ASUNTO*", $asu, $mensaje);
  $nom_r = $nombre_us1 ." ". $prim_apel_us1." ". $seg_apel_us1. " - ". $otro_us1;
  $mensaje = str_replace("*NOM_R*", $nom_r, $mensaje);
  $mensaje = str_replace("*RADICADO_PADRE*", $radicadopadre, $mensaje);
  $mensaje = str_replace("*MENSAJE*", $observa, $mensaje);
  $mensaje = str_replace("*DIAS_VENCIDO*", $diasVencido, $mensaje);
  $mensaje .= "<hr>Sistema de gestion Orfeo. http://www.orfeogpl.org - http://www.correlibre.org";
  $mail->MsgHTML($mensaje);
  if($mail->Send()){
  echo "Enviado correctamente a:  $mailDestino</br>\n"; 
  }else{
    echo "<font color=red>No se envio Correo a $mailDestino</font>";
  }

  echo "</td>";
  echo "<tr>";
  
  $rs->MoveNext();
}
 /** } catch (phpmailerException $e) {
  echo $e->errorMessage() . " " .$mailDestino; //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage() . " " .$mailDestino; //Boring error messages from anything else!
}**/



?>

</table>
