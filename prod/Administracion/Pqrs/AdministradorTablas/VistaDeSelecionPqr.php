<?php
$ruta_raiz = "../../..";
    session_start();
   
    include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");	
define('ADODB_FETCH_ASSOC',2);

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
  
    $sql = "SELECT ID,NOMBRE FROM FORMULARIOPQR WHERE ESTADO = 1";
    
   $resultado = $db->query($sql);

?>

<html>
    <head>
        <title>Administración de pqr</title>
        <link href="../css/bootstrap2.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="../scripts/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="../scripts/jquery-ui.min.js"> 
        
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                
               // $("#formulario").change(function(){window.location.href = "VistaDatosGenerales.php?formulario="+jQuery("#formulario").val();});
                    
                   
                          
                          
                
                });
           
           </script>
           <script src="../scripts/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
     <?php include 'menu.php';?>   
      
      <H1>Seleccione Tipo de PQR:</H1>
      <div class="col-sm-6">
      <form action="../VistaDatosGenerales.php" method="post">
       <div id="u2" class="ax_droplist">
        <select  class="form-control" name="formulario">
          <option selected="" value="">SELECCIONE</option>
          <?php
          while(!$resultado->EOF){
            ?>
          <option value="<?=$resultado->fields['ID']?>"><?=$resultado->fields['NOMBRE']?></option>
          <?php
              $resultado->MoveNext();
          }
          ?>
        </select>
      </div>

      
        <br>
    
    <input id="u211_input" type="submit" value="CONTINUAR" class="btn-primary" tabindex="0">
     </form>   
   </div>   
    </body>
</html>
