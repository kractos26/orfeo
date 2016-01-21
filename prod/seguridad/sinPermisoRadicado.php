<?php
error_reporting(0);
session_start();
if (!$ruta_raiz)
            $ruta_raiz = "..";
if($radi_depe_actu && $radi_usua_actu){
	$sqlActu="select u.usua_nomb,d.depe_nomb 
			  from usuario u
			  join dependencia d on u.depe_codi=d.depe_codi
			  where u.usua_codi=$radi_usua_actu and u.depe_codi=$radi_depe_actu ";
	$rsActu=$db->conn->Execute($sqlActu);
	if($rsActu && !$rsActu->EOF){
		$depeActu=$rsActu->fields['DEPE_NOMB'];
		$usuActu=$rsActu->fields['USUA_NOMB'];
	}
}
?>

<html>
<head>
<title>Seguridad Radicado</title>
<link href="<?=$ruta_raiz?>/estilos/orfeo.css" rel="stylesheet" type="text/css"><script>

function regresar(){   	
	document.TipoDocu.submit();
}
</script>
</head>
<body bgcolor="#FFFFFF">
<form method="post" action="radicado.php?krd=<?=$krd?>&numRad=<?=$numRad?>" name="TipoDocu">
<P></P>
<table border=0 width=98% align="center" class="borde_tab" cellspacing="0">
<tr align="center" class="titulos2">
	<td height="15" class="titulos2">!! SEGURIDAD !!</td>
</tr>
<tr >
	<td width="38%" class=listado5 >
   		<center><p><font class="no_leidos">NO TIENE PERMISOS PARA ACCEDER AL RADICADO No. <?=$numRad?>,<br>
   				Este Radicado est&aacute; marcado como confidencial.</font></p></center>
	</td>
</tr>
<tr >
	<td height="15" class="titulos2">
   		<center>Favor comunicarse con: <?= $usuActu?> Dependencia: <?= $depeActu?> </center>
	</td>
	
</tr>
</table>
</form>
</body>
</html>
