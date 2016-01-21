<?php
$bien=true;
include "config.php"; 
ora_commiton($handle);
if ($usuacrea)
   if ((!$sololect && !$MAX_FILE_SIZE) || ($sololect && $MAX_FILE_SIZE)){
      //include ("config.php");
	  if ($radicado_salida)
	     {$anex_salida = 1;}
		else
		 {$anex_salida = 0;} 
      if ($sololect)
         $auxsololect="S";
      else
         $auxsololect="N";
      $isql = "update anexos set anex_solo_lect='$auxsololect',anex_salida=$anex_salida ".
              "where anex_codigo=$anexo";
      $bien=ora_do($handle,$isql);
      if ($bien)
  	 $resp1="OK";
      else
         $resp1="ERROR";
   }
if ($bien)  
if ($MAX_FILE_SIZE){
$indexversion=strpos($archivo,$radi);
$archivoversion=trim(substr($archivo,0,$indexversion));
$archivosinversion=trim(substr($archivo,$indexversion));
$archivoversion=$archivoversion+1;
$archivo=strtolower(trim($archivoversion).$archivosinversion);
$directorio="./bodega/".substr(trim($archivosinversion),0,4)."/".substr(trim($archivosinversion),4,3)."/docs/";
$bien=is_uploaded_file($userfile);
if ($bien)   
   $bien=move_uploaded_file($userfile,$directorio.trim($archivo));
if ($bien){
	  if ($radicado_salida)
	     {$anex_salida = 1;}
		else
		 {$anex_salida = 0;} 

     $isql = "update anexos set anex_nomb_archivo='$archivo',anex_salida=$anex_salida  ".
              "where anex_codigo=$anexo";
     $bien=ora_do($handle,$isql);
}  
if ($bien) 
  $resp2="OK";
else 
  $resp2="ERROR";
}
$params="?usua=$usua&contra=$contra&radi=$radi&anexo=$anexo&resp1=$resp1&resp2=$resp2";
header("Location:detalle_archivos.php".$params);
?>
