<?php
session_start();
$matriz = $_SESSION["cantCarpetasGen"];
$cnt = 0;
foreach ($matriz as $carpeta=>$dato)
{	$cadena .= "<tr>";
	if (($dato[0] != $dato[1]) && ($dato[1] - $dato[0])>0)
	{
		$cnt += ($dato[1] - $dato[0]);
		$cadena .= "<td class='titulos2' width='80%' align='left'>$carpeta</td><td align='center' class='listado2_no_identa'>".($dato[1] - $dato[0])."</td>";
	}
	$cadena .= "</tr>";
}
?>
<html>
<head>
<title>..: Nuevos Documentos :..</title>
<link rel="stylesheet" href="estilos/orfeo.css">
</head>
<body onLoad="setTimeout('window.close()', 10000);">
<table border=0 cellspace=2 cellpad=2 WIDTH=90% class="t_bordeGris" id=tb_general align="left">
<tr>
	<td colspan="2" class="titulos4"><h2>TIENE <?php echo $cnt; ?> DOCUMENTO(S):</h2></td>
</tr>
<?php echo $cadena; ?>
</table>
</body>
</html>