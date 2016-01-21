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
  
    $sql = "SELECT c.ID,NOMBRE,ETIQUETA,ACTIVO,PUBLICO,OBLIGATORIO,AYUDA,d.TABLA,d.VALUE,d.OPCION,d.TAMANO,d.TIPOCAMPO from CAMPOPQR c inner join FORMULARIOCAMPOPQR d on c.Id = d.idcampo
    WHERE d.IDFORMULARIO = ".$_REQUEST['formulario']." and c.IDGRUPO = 4 order by c.ID";
    
   $resultado = $db->query($sql);
     
    $nombre = "    select NOMBRE FROM FORMULARIOPQR WHERE ID = ".$_REQUEST['formulario']."";
   $nombre = $db->query($nombre);
?>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>title</title>
        <link rel="stylesheet" href="estilospqrs.css">
        
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="scripts/bootstrap.min.js" type="text/javascript"></script>
          
        <script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="scripts/jquery-ui.min.js"> </script>
        <script type="text/javascript" src="scripts/adminstrador.js"></script>
    </head>
    <body>
         <?php  include 'menu.php';?>
       <center>
         <h1>SE ENCUENTRA PARAMETRIZANDO EL FORMULARIO DE <?=$nombre->fields['NOMBRE']?></h1>
    </center>
      <H2>DATOS DE SEGURIDAD</H2>   
      <form action="UpdateDatosDestinatario.php"  method="post">
          <?php include 'TablaAdministrador.php'; ?>
          <input id="u211_input" type="submit" value="GUARDAR" tabindex="0" onclick="javascript:alert('Formulario parametrizado con exito')">
    <input type="hidden" name="ids" value="<?=$ids?>">
     <input type="hidden" name="formulario" value="<?=$_REQUEST['formulario']?>">
     <a href="VistaDatosContacto.php?formulario=<?=$_REQUEST['formulario']?>">Anterior</a>
 </form>        
    </body>
</html>



