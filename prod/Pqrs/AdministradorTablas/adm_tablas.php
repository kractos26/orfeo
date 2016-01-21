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
$db->conn->debug = false;

   
    if($eliminar)
    {
        $sql="DELETE FROM $textabla WHERE ID = '".$id."'";
        $db->query($sql);
        
    }
 
$contenido = htmlentities($contenido,ENT_COMPAT,"UTF-8");

if($listar == null && $eliminar != 1){
$sql="SELECT count(ID)+1 as ID FROM $textabla";
$resul = $db->query($sql);


$verifiarr="select ID from $textabla where LOWER(nombre)='".strtolower($contenido)."'";


$r=$db->query($verifiarr);
if($r->fields['ID'])
{
     $arrau = array('NOMBRE'=>"'".$contenido."'");
     $db->update($textabla, $arrau,array('ID'=>$r->fields['ID']));
     echo "elemento existente modificado con exito";
}
else
{
    $arrau = array('ID'=>$resul->fields['ID'],'NOMBRE'=>"'".$contenido."'");
    $db->insert($textabla, $arrau);
    echo "creado con exito";
}


 



}
elseif($listar || $eliminar){
  $sql = "select * from $textabla order by nombre";
 
  $rsu = $db->query($sql);
  ?>
<head>
    
    <meta charset="ISO-8859-1"/>
</head>
<table class="table table-bordered">
    <tr>
        <td>
            ID
        </td>
        <td colspan="2">
            NOMBRE
        </td>
    </tr>
    <?php 
     while(!$rsu->EOF){
         ?>
    <tr>
        <td>
            <?=$rsu->fields['ID']?>
        </td>
        <td>
            <?php echo(html_entity_decode($rsu->fields['NOMBRE']));?>
        </td>
        <td>
            <button onclick="eliminar(<?=$rsu->fields['ID']?>)">eliminar</button>
        </td>
    </tr>
        <?php
         $rsu->MoveNext();
     }
    ?>
</table>
<?php
}
?>

