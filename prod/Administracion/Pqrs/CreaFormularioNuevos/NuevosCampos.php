<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$ruta_raiz = "../../..";
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
	
define('ADODB_FETCH_ASSOC',2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = new ConnectionHandler("$ruta_raiz");

$sql = "select ID,NOMBRE from campopqr";
$rs=$db->query($sql);

?>

<table>
    <tr>
       <td>Campo</td>
       <td>Formulario</td>
       <td>Prioridad</td>
       <td>Opciones</td>
    </tr>
    <?php 
        while(!$rs->EOF)
        {
            ?>
          <tr>
       <td><?=$rs->fields['NOMBRE']?></td>
       <td>Formulario</td>
       <td>Prioridad</td>
       <td>Opciones</td>
    </tr>
        <?php 
        $rs->MoveNext();
        }
    ?>
</table>

