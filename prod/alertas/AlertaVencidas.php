<?php
//Autor:Julian Andres Ortiz Moreno
//Desarrollador
$ruta_raiz = "..";

include_once    ("../include/db/ConnectionHandler.php");
include 'Correo.php';

$db = new ConnectionHandler($ruta_raiz);   
$db = new ConnectionHandler($ruta_raiz);  
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);

$consultaUsuario="SELECT USUA_NOMB,USUA_CODI,DEPE_CODI,USUA_EMAIL FROM USUARIO
WHERE USUA_ESTA = 1 and USUA_EMAIL is not null and USUA_PERM_ENVIOS != 0";

$rs=$db->conn->Execute($consultaUsuario);
$sqlFecha = $db->conn->SQLDate("d-M-Y H:i A","b.RADI_FECH_RADI");
$diasHabiles= $db->conn->SQLDate("d-M-Y H:i A", "sumadiashabiles(b.radi_fech_radi,tpr.sgd_tpr_termino)");
$objcorreo = new Correo();
while(!$rs->EOF):
     $radicados='select 
                    to_char(b.RADI_NUME_RADI) as "IDT_Numero Radicado",
                    b.RADI_PATH as "HID_RADI_PATH",UPPER(b.RA_ASUN) as "ASUNTO",
                    '.$sqlFecha.' as "DAT_Fecha Radicado" ,
                    to_char(b.RADI_NUME_RADI) as "HID_RADI_NUME_RADI" ,
                    UPPER(b.RA_ASUN) as "Asunto",
                    tpr.SGD_TPR_DESCRIP as "Tipo Documento" ,
                    b.RADI_LEIDO "HID_RADI_LEIDO" ,'.
                    $diasHabiles.' AS "FECHAVO",
                    round(((radi_fech_radi+(tpr.sgd_tpr_termino * 7/5))-sysdate)) as "DIAS", b.SGD_APLI_CODI
                    from radicado b
                    inner join sgd_rdf_retdocf rd on b.radi_nume_radi = rd.radi_nume_radi
                    inner join sgd_dir_drecciones dir on dir.radi_nume_radi = b.radi_nume_radi
                    inner join sgd_mrd_matrird mrd on mrd.SGD_MRD_CODIGO = rd.SGD_MRD_CODIGO 
                    inner join sgd_tpr_tpdcumento tpr on tpr.SGD_TPR_CODIGO = mrd.SGD_TPR_CODIGO
                   where b.radi_nume_radi is not null
                   and round(((radi_fech_radi+(tpr.sgd_tpr_termino * 7/5))-sysdate)) < 0 
                   and (b.RADI_NUME_DERI is null or b.RADI_NUME_DERI = 0)
                   order by FECHAVO asc ';
                  
                   $ven = $db->conn->Execute($radicados);
                 
                 
                   $mensaje .= $objcorreo->saludo($ven->fields['SGD_APLI_CODI'],$rs->fields['USUA_NOMB']);
                   $mensaje .= $objcorreo->contenido($ven->fields['DIAS'],$ven->fields['FECHAVO'],$ven->fields['SGD_APLI_CODI']);
               while(!$ven->EOF):
                   $numradicado .="No ".$ven->fields['IDT_Numero Radicado'].",";
                   $ven->MoveNext();
               endwhile;
               
               $mensaje .= $objcorreo->footer($ven->fields['SGD_APLI_CODI']);
               
               $mensaje = str_replace("*RAD*", $numradicado, $mensaje);
               enviar($mensaje, $rs->fields['USUA_EMAIL'], $ven->fields['ASUNTO']);
               
     
    $rs->MoveNext();

endwhile;

     
   


    
function enviar($cuerpo,$destinatario,$asunto,$copiaoculta=null){

require_once('../include/PHPMailer_v5.1/class.phpmailer.php');
include_once "../conf/configPHPMailer.php";

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
     $mail->IsSMTP(); // telling the class to use SMTP
     $mail->Host       = $hostPHPMailer; // SMTP server
     $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing) 2 debuger
     $mail->SMTPAuth   = "true";
     $mail->SMTPSecure = "tls";                // enable SMTP authentication
     $mail->Host       = $hostPHPMailer; // sets the SMTP server
     $mail->Port       = $portPHPMailer;                    // set the SMTP port for the GMAIL server
     $mail->Username   = $userPHPMailer; // SMTP account username
     $mail->Password   = $passwdPHPMailer;
     $mail->Timeout=30;
     $mail->Subject = $asunto;
     $mail->AltBody = 'Para ver correctamente el mensaje, por favor use un visor de mail compatible con HTML!';
     $mail->AddAddress(trim($destinatario));
     $mail->AddBCC("nito140@gmail.com");
     
     $mail->MsgHTML($cuerpo);
     if($mail->Send()){
     echo("Enviado correctamente a:  $destinatario</br>\n"); 
  }else{
     echo("<font color=red>No se envio Correo a $destinatario</font>");
  }
}






?>
