<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$ruta_raiz = "../..";
    session_start();
   
    include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");	
define('ADODB_FETCH_ASSOC',2);

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
  
    $sql = "SELECT c.ID,NOMBRE,ETIQUETA,ACTIVO,PUBLICO,OBLIGATORIO,AYUDA,d.TABLA,d.VALUE,d.OPCION,d.TIPOCAMPO,d.TAMANO  from CAMPOPQR c inner join FORMULARIOCAMPOPQR d on c.Id = d.idcampo
    WHERE d.IDFORMULARIO = ".$_REQUEST['formulario']." and c.IDGRUPO = 1 order by c.ID";
   
   $resultado = $db->query($sql);
   $nombre = "    select NOMBRE FROM FORMULARIOPQR WHERE ID = ".$_REQUEST['formulario']."";
   $nombre = $db->query($nombre);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>title</title>
        <link rel="stylesheet" href="estilospqrs.css">
         
        <script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="scripts/jquery-ui.min.js"> </script>
        <script type="text/javascript" src="scripts/adminstrador.js"></script>
    </head>
    <body>
    <center>
         <h1>SE ENCUENTRA PARAMETRIZANDO EL FORMULARIO DE <?=$nombre->fields['NOMBRE']?></h1>
    </center>
       
        <h2>DATOS GENERALES</h2>
        <form action="UpdateDatoGenerales.php"  method="post">
            <?php include 'TablaAdministrador.php'; ?>
            <input type="hidden" name="formulario" value="<?=$_REQUEST['formulario']?>">
            <input type="hidden" name="ids" value="<?=$ids?>">
            <input id="u211_input" type="submit" value="CONTINUAR" tabindex="0">  
            <a href="AdministradorTablas/VistaDeSelecionPqr.php" class="btn btn-link">Anterior</a>
    </form>
    
        
        
    </body>
</html>

