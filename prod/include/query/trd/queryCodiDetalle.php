<?php
/**
* Crea una cadena con el codigo del campo y la descripcion
* $num_car numero de caracteres
* $nomb_varc variable codigo
* $nomb_varde variable descripcion
*/
$sqlFechaHoy = $db->conn->SQLDate('Y-m-d',$db->conn->sysTimeStamp);
$sgd_sbrd_fechini = $db->conn->SQLDate('Y-m-d','sgd_sbrd_fechini');
$sgd_sbrd_fechfin = $db->conn->SQLDate('Y-m-d','sgd_sbrd_fechfin');
$sgd_srd_fechini = $db->conn->SQLDate('Y-m-d','sgd_srd_fechini');
$sgd_srd_fechfin = $db->conn->SQLDate('Y-m-d','sgd_srd_fechfin');
switch($db->driver)
{
	case 'mssql':
			$sqlConcat = $db->conn->Concat("convert(char($num_car),$nomb_varc,0)","'-'","$nomb_varde");
	break;		
	case 'oracle':
	case 'oci8':
        case 'oci8po':
	case 'postgres':
			$sqlConcat = $db->conn->Concat("$nomb_varc","'-'","$nomb_varde");
	break;		
	}
?>