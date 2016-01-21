<?php
//Seguridad
session_start();
$ruta_raiz="..";
if (!($_SESSION["usua_perm_tpx"]==2 || $_SESSION["usua_perm_tpx"]==3)) die("Error accesando la p&aacute;gina. No tiene Privilegios.");
?>
<html>
<head>
<title>Buscar Radicado</title>
<script language="JavaScript" src="<?=$ruta_raiz?>/js/formchek.js"></script>
<link rel="stylesheet" href="<?=$ruta_raiz?>/estilos/orfeo.css" type="text/css">
<script>
function validaciones()
{
	jh =  trim(document.getElementById('nurad').value);
	if (!isPositiveInteger(jh, false))
 	{	var1 =  parseInt(jh);
		if(var1 != jh)
		{	alert("Atenci\xf3n: El n\xfamero de radicado debe ser de s\xf3lo n\xfameros.");
			return false;
	}	}
	if (jh.length != 14)
	{	alert("Atenci\xf3n: El n\xfamero de Caracteres del radicado es de 14");
		return false;
	}
	if (jh.substr(13,1) != 2)
	{	alert("Atenci\xf3n: Solo se admiten radicados de entrada");
		return false;
	}	
 	document.FrmBuscar.submit(  );
}
</script>
</head>

<body  onLoad='document.getElementById("nurad").focus();'>
<table border=0 width=100% class="borde_tab" cellspacing="5">
<tr align="center" class="titulos5">
	<td height="15" class="titulos5">MODIFICACI&Oacute;N DE RADICADOS R&Aacute;PIDOS DE ENTRADA</td>
</tr>
</Table>
<center></P>
  <form action='NEW.php?<?=session_name()."=".session_id()."&krd=$krd"?>&Submit3=ModificarDocumentos' name="FrmBuscar" class=celdaGris method="POST">
    <table width="80%" class='borde_tab' cellspacing='5'>
  <tr class='titulos2'> 
        <td width="25%" height="49">N&uacute;mero de Radicado</td>
    <td width="55%" class=listado2>
		<input type='text' name='nurad' class='tex_area' id='nurad'>
		<input type='hidden' name='Buscar' Value='Buscar Radicado'>
		<input type='hidden' name='radexp' Value='1' id='radexp'>
		<input type=button name=Buscar1 Value="Buscar Radicado" class=botones_largo onclick="validaciones();"> 
	 </td>
  </tr>
</table>
</form>
</center>
</body>
</html>