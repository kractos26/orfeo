<?php
 $ruta_raiz = "../..";
 session_start();
 $phpsession = session_name()."=".session_id();
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
 $db = new ConnectionHandler("$ruta_raiz"); 
  $db->conn->debug = true;
  echo $_GET['sql'];
 $repuest=$db->query($_GET['sql']);

?>
<html>
    <head>
        <title>title</title>
        <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/orfeo38/orfeo.css"?>">
    </head>
    <body>  
           <a href='CuerpoTranslado.php?<?=$phpsession ?>&krd=<?=$krd?>&trans=1' class="vinculos" target='mainFrame'>Regresar </a>
        <table border="0" cellspace="2" cellpad="2" width="50%" class="t_bordeGris" id="tb_general" align="left">
            <tr>
                  <td colspan="3" class="titulos4">TRANSLADO DE USUARIOS </td>
            </tr>
             <tr>
                   <td align="left" bgcolor="#CCCCCC" height="25" class="titulos2">USUARIO
                   </td>
                   <td width="65%" height="25" class="listado2_no_identa">
                      DEPENDENCIA DESTINO
                   </td>
             </tr>
            <?php
                while(!$respuesta->EOF)
                {   echo "<tr>";
                    ?>
                    <td width="50%" height="25" class="listado2_no_identa"><?=$repuest->fields['USUA_NOMB'] ?></td>
                    <td width="50%" height="25" class="listado2_no_identa"><?=$repuest->fields['DEPE_NOMB']?></td>
                   <?php
                   echo "</tr>";
                   $respuesta->MoveNext();
                }

                 ?>
          </table>
    </body>
</html>




                
                
             