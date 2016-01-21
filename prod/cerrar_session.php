<?php 
session_start();
    $ruta_raiz = ".";
    include_once "$ruta_raiz/config.php";
    include_once "$ruta_raiz/include/db/ConnectionHandler.php";
 
    $db     = new ConnectionHandler($ruta_raiz);    
    $fecha  = "'FIN  ".date("Y:m:d H:mi:s")."'";
    $isql   = "UPDATE 
                    usuario 
               SET
                    USUA_SESION =".$fecha." 
               WHERE
                    USUA_SESION like '%".session_id()."%'";
    if (!$db->conn->Execute($isql)) {
        echo "<p><center>No pude actualizar<p><br>";
    }    
   
    session_destroy(); 
?>

<html>    
    <head>
        <title>Sesion cerrada ::: ORFEO :::</title>
       <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$ESTILOS_PATH?>/orfeo.css" />
        <script type="text/javascript">
            if (top.location != self.location) top.location = self.location
        </script>
    </head>
    </HEAD>
	<body class="titulos4">
	<p><br>
	<p>
	<center>
	<font face='Verdana, Arial, Helvetica, sans-serif' SIZE=3 color=white>
	<p>
	<a href="<?=$ruta_raiz?>/login.php" target="_parent">
	<img border="0" src="<?=$ruta_raiz?>/imagenes/logo.gif" width="206" height="76"></a>
	<p>
	Su sesion ha expirado o ha ingresado en otro equipo <p>
	por favor cierre su navegador e intente de nuevo.</font>
	</center>
	
</body>
</html>
