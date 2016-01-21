<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('recaptchalib.php');
 $privatekey = "6LcoORQTAAAAAFNm70fHBdM-o8DQ2AV36le3za5E";
 $resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
 
 if (!$resp->is_valid) {
      //ERROR EN EL CAPTCHA
      echo 0;
 }else{
      //CAPTCHA CORRECTO
      echo 1;
 }
?>

