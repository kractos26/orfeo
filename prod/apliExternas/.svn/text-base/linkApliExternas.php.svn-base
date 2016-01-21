<?
$krd = $_GET["krd"];
$usua_nomb = $_GET["usua_nomb"];
$usua_codi = $_GET["usua_codi"];
$depe_nomb = $_GET["depe_nomb"];
?>
<html>
<head>
<SCRIPT>
	function submitFormSigar()
	{
	   document.sigarSoloSSPD.submit();
	}
</SCRIPT>
</head>
<body onload="submitFormSigar();">
<FORM id="sigarSoloSSPD" name="sigarSoloSSPD" method="POST" action="http://www.superservicios.gov.co/sigar/inicio.php">
<INPUT TYPE="hidden" name="tusuario" value="<?=$krd?>">
<INPUT TYPE="hidden" name="tnombre" value="<?=$usua_nomb?>">
<INPUT TYPE="hidden" name="tcodigo" value="<?=$usua_codi?>">
<INPUT TYPE="hidden" name="tdependencia" value="<?=$depe_nomb?>">
</FORM>
</body>
</html>