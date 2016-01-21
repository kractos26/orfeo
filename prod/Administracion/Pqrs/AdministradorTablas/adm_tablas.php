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

   
    if($eliminar):
         $sql="DELETE FROM $textabla WHERE ID = '".$id."'";
        $db->query($sql);
    endif;
    
    if($activar == 1):
        $sql = "UPDATE $textabla SET ESTADO = $valor WHERE ID = '".$id."'";
        $db->query($sql);
       
    endif;
 
$contenido = htmlentities($contenido,ENT_COMPAT,"UTF-8");

if($listar == null && $eliminar != 1 && $activar !=1){
$sql="SELECT count(ID)+1 as ID FROM $textabla";
$resul = $db->query($sql);

$verifiarr="select ID from $textabla where LOWER(nombre)='".strtolower($contenido)."'";


$r=$db->query($verifiarr);
$existe = $r->fields['ID'];
$codigo = $resul->fields['ID'];

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
elseif($listar || $eliminar || $activar){
  $condicion = ($listar == 2 && trim($contenido) != "")?"where nombre like '%".$contenido."%'":"";
  $sql = "select * from $textabla $condicion order by nombre";
 
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
            if(trim($textabla) == "formulariopqr"):
                $funcion = ($rsu->fields['ESTADO']==1)?"DesactivarActivar(".$rsu->fields['ID'].",2)":"DesactivarActivar(".$rsu->fields['ID'].",1)";
                $opcion = ($rsu->fields['ESTADO'] ==1)?"Desactivar":"Activar";
            else:
                $funcion = "eliminar(".$rsu->fields['ID'].")";
                $opcion = "eliminar";
            endif;
            
         ?>
    <tr>
        <td>
            <?=$rsu->fields['ID']?>
        </td>
        <td>
            <?php echo(html_entity_decode($rsu->fields['NOMBRE']));?>
        </td>
        <td>
            <button onclick="<?=$funcion?>"><?=$opcion?></button>
        </td>
    </tr>
        <?php
         $rsu->MoveNext();
     }
    ?>
</table>
<?php
}
$existe = (!$existe)?0:$existe;


if(trim($textabla) == "formulariopqr" && $existe==0 && !$eliminar && !$listar)
{
   
    
    $sql = "select  DISTINCT IDCAMPO,PRIORIDAD,FUNCIONJS,EVENTO,TABLA,VALUE,OPCION,TIPOCAMPO from FORMULARIOCAMPOPQR
            where IDFORMULARIO = 1
            order by prioridad";
    $rs = $db->query($sql);
    while(!$rs->EOF)
    {  
        $sqlformulariocampopqr = "select max(id)+1 as numero  from formulariocampopqr";
        $rt = $db->query($sqlformulariocampopqr);
        
        $array = array(
             'ID' => $rt->fields['NUMERO'],
             'IDFORMULARIO' => $codigo,
             'IDCAMPO' => $rs->fields['IDCAMPO'],
             'PRIORIDAD' => $rs->fields['PRIORIDAD'],
             'FUNCIONJS' => "'".$rs->fields['FUNCIONJS']."'",
             'EVENTO' => "'".$rs->fields['EVENTO']."'",
             'TABLA' => "'".$rs->fields['TABLA']."'",
             'VALUE' => "'".$rs->fields['VALUE']."'",
             'OPCION' => "'".$rs->fields['OPCION']."'",
             'TIPOCAMPO' => $rs->fields['TIPOCAMPO']
           );
        
        $db->insert("FORMULARIOCAMPOPQR", $array);
        $rs->MoveNext();
    }
    
}

?>

