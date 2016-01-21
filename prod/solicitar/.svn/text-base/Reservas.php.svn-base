<?php
   $krdOld = $krd;
   error_reporting(0);
   session_start();
   if(!$krd) $krd=$krdOsld;
   $ruta_raiz = "..";
   if(!$dependencia or !$tpDepeRad) include "$ruta_raiz/rec_session.php";
   if(!$carpeta) {
      $carpeta = $carpetaOld;
      $tipo_carp = $tipoCarpOld;
   }
   $verrad = "";
   include_once "$ruta_raiz/include/db/ConnectionHandler.php";
   $db = new ConnectionHandler($ruta_raiz);	 


/*********************************************************************************
 *       Filename: Reservas.php
 *       Modificado: 
 *          1/3/2006  IIAC  Llama la página para que el usuario pueda consultar
 *                          el estado de sus solicitudes.
 *********************************************************************************/ 

// Reservar CustomIncludes begin
   include "common.php";
// Save Page and File Name available into variables
   $sFileName = "Reservas.php";
// Begin   
   echo "..";    
   echo "<form method=\"post\" action=\"".$ruta_raiz."/prestamo/prestamo.php\" name=\"reservas\">
            <input type=\"hidden\" name=\"opcionMenu\" value=\"4\">      
            <input type=\"hidden\" name=\"sFileName\" value=\"<?=$sFileName?>\">  
            <input type=\"hidden\" name=\"krd\" value=\"".$krd."\">
            <input type=\"hidden\" value=\"\" name=\"radicado\">  
         </form>";								
   echo "<script> document.reservas.submit(); </script>";   
   
   