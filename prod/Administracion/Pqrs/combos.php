<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$ruta_raiz = "../..";

   
?>

<?php
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");	
define('ADODB_FETCH_ASSOC',2);
switch($_REQUEST['campo']) 
{
    case 1:
      $sql = "SELECT ID_PAIS AS VALOR,NOMBRE_PAIS AS NOMBRE FROM SGD_DEF_PAISES WHERE ID_CONT=".$_REQUEST['valor']; 
    break;
    case 2:
       $sql = "SELECT DPTO_CODI AS VALOR,DPTO_NOMB AS NOMBRE FROM DEPARTAMENTO WHERE ID_PAIS=".$_REQUEST['valor'];  
       
    break;
    case 3:
        $sql = "SELECT MUNI_CODI AS VALOR,MUNI_NOMB AS NOMBRE FROM MUNICIPIO WHERE DPTO_CODI = ".$_REQUEST['valor']." AND ID_CONT = ".$_REQUEST['valorcon']." AND ID_PAIS = ".$_REQUEST['valorpais']."";  
    break;
}
?>

<?php
$resultado=$db->query($sql);
?>

<option value="">SELECCIONE<option
<?php
while(!$resultado->EOF){
?>
<option value = "<?=$resultado->fields['VALOR']?>" ><?=$resultado->fields['NOMBRE']?></option>
<?php
$resultado->MoveNext();
}
 ?>

