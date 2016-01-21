<?php
	/**
	  * CONSULTA TIPO RADICACION
	  */
	switch($db->driver)
	{  
	 case 'mssql':
		$whereTipoRadi = ' and '.$db->conn->substr.'(convert(char(14),b.radi_nume_radi), 14, 1) = ' .$tipoRadicado;
	break;		
	case 'oracle':
	case 'oci8':
	case 'oci805':
        case 'oci8po':
		$whereTipoRadi = ' and '.$db->conn->substr.'(b.radi_nume_radi, 14, 1) = ' .$tipoRadicado;
	break;		
	//Modificacion skina
	default:
		$whereTipoRadi = " and ".$db->conn->substr."(cast(b.radi_nume_radi as varchar), 14, 1) = '$tipoRadicado'";
		break;
	}
?>