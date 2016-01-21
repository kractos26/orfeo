<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function TildesHtml($cadena) 
    {    
            return str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
                                         array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                                                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $cadena);     
    }
$ruta_raiz = "../../..";
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
	
define('ADODB_FETCH_ASSOC',2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = new ConnectionHandler("$ruta_raiz");


$insert = "INSERT INTO PROFESION(ID,NOMBRE)VALUES('".$_POST['codigo']."', '".htmlentities($_POST['datos'])."')";
$db->query($insert);

$sql="select * from profesion";
$rs=$db->query($sql);
while(!$rs->EOF){
  echo "salida: ".$rs->fields['NOMBRE'];
  echo "<br>";
  $rs->MoveNext();
}






?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
    </head>
    <body>
        
        <form action="prueba.php" method="post">
    <input name="datos" value="" />
    <input name="codigo" value="" />
    <input type="submit">
</form>
    </body>
</html>
