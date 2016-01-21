<?
	$ruta_raiz = "..";
	session_start();
	if(!isset($_SESSION['dependencia']))	include "$ruta_raiz/rec_session.php";	
	$phpsession = session_name()."=".session_id();
?>
<html>
<head>
<title>Documento  sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body>
  <table width="300" align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
  <tr bordercolor="#FFFFFF">
    <td colspan="2" class="titulos4"><div align="center"><strong>ANULACION</strong></div></td>
  </tr>
  <tr bordercolor="#FFFFFF">
    <td align="center" class="listado2">1. <a href="historicoActas.php?<?=$phpsession?>&krd=<?=$krd?>" target='mainFrame' class="vinculos">REPORTE ACTAS DE ANULACION GENERADAS</a>
	</td>
  </tr>
  <tr bordercolor="#FFFFFF">
    <td align="center" class="listado2">2. <a href="historicoRadAnulados.php?<?=$phpsession?>&krd=<?=$krd?>&estado_sal=4&tpAnulacion=2&<? echo "fechah=$fechah"; ?>" target='mainFrame' class="vinculos">REPORTE RADICADOS ANULADOS</a>
	</td>
  </tr>
<?php
if($_SESSION["usua_perm_anu"]==3 or $_SESSION["usua_perm_anu"]==2){
?>  
  <tr bordercolor="#FFFFFF">  
		<td align="center" class="listado2">3. 
			<a href="anularRadicado.php?<?=$phpsession?>&krd=<?=$krd?>&estado_sal=4&tpAnulacion=2&<? echo "fechah=$fechah"; ?>" target='mainFrame' class="vinculos">ANULAR RADICADOS EN SOLICITUD</a>
		</td>
  </tr>			
<?
}
?>      
</table>
</body>
</html>
