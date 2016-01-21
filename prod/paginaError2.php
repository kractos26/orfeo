
<html>
<title>Adm - Contrase&ntilde;as - ORFEO 3 </title>
<HEAD>
    <link rel="stylesheet" href="estilos/orfeo38/orfeo.css">
</HEAD>
	<body class="titulos4">
	<p><br>
	<p>
	<center>
	<font face='Verdana, Arial, Helvetica, sans-serif' SIZE=3 color=white>
	<p>
	<a href="<?=$ruta_raiz?>/login.php" target="_parent">
	<img border="0" src="<?=$ruta_raiz?>/imagenes/logo2.gif" width="206" height="76"></a>
	<p>
	Su sesion ha expirado o ha ingresado en otro equipo <p>
	por favor cierre su navegador e intente de nuevo.</font>
	</center>
<?php
if (session_id())
	session_destroy();
?>	
</body>
</html>