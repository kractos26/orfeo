<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
foreach ($_GET as $key => $valor)   ${$key} = $valor;//iconv("ISO-8859-1","UTF-8",$valor);
foreach ($_POST as $key => $valor)   ${$key} = $valor;
 $ruta_raiz = "../../..";
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
	
define('ADODB_FETCH_ASSOC',2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = new ConnectionHandler("$ruta_raiz");
$contenido = htmlentities($contenido,ENT_COMPAT,"UTF-8");
  $array=array('DESCRIPCION'=>"'".trim($contenido)."'");
  $db->update("GRUPOPQR", $array,array('ID'=>"'".$textabla."'"));

  $sql = "select NOMBREGRUPO,DESCRIPCION from GRUPOPQR";
  $rsu = $db->query($sql);
  ?>
<table class="table table-bordered">
    <tr>
        <td>
            NOMBRE
        </td>
        <td>
            DESCRIPCI&Oacute;N
        </td>
    </tr>
    <?php 
     while(!$rsu->EOF){
         ?>
    <tr>
        <td>
            <?=$rsu->fields['NOMBREGRUPO']?>
        </td>
        <td>
            <?=html_entity_decode($rsu->fields['DESCRIPCION']) ?>
        </td>
    </tr>
        <?php
         $rsu->MoveNext();
     }
    ?>
</table>



