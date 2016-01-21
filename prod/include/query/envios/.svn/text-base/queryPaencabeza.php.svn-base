<?php
/**
  * Consulta para paEncabeza.php
  */
switch($db->driver)
{
	case 'mssql':
		$conversion = "CONVERT (CHAR(5), depe_codi)";
		break;
	case 'postgres':
		$conversion = "depe_codi||''";
		break;
	default:
		$conversion = "depe_codi";
		break;
}
?>