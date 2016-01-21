<?php
/**
  * CONSULTA VERIFICACION PREVIA A LA RADICACION
  */
switch($db->driver)
{  
	case 'mssql':
		$sqlConcat = $db->conn->Concat("RTRIM(depe_codi)","'-'","depe_nomb");
		break;
	case 'oracle':
        case 'oci8':
        case 'oci8po':
		$sqlConcat = $db->conn->Concat("depe_codi","'-'","depe_nomb");
		break;
	default:
		$sqlConcat = $db->conn->Concat("cast(depe_codi as varchar)","'-'","depe_nomb");
		break;
	}
?>
