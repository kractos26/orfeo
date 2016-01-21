<?
	/**
	  * CONSULTA VERIFICACION PREVIA A LA RADICACION
	  */
	switch($db->driver)
	{  
	 case 'mssql':
			$radi_nume_sal = "convert(varchar(14), RADI_NUME_SAL)";
			$where_depe = " and ".$db->conn->substr."(".$radi_nume_sal.", 5, 3) in ($lista_depcod)";
			$joinDep = " ".$db->conn->substr."(cast (a.radi_nume_sal AS VARCHAR), 5, 3)=c.depe_codi ";
	break;		
	case 'oracle':
	case 'oci8':
    case 'oci8po':
	case 'oci805':		
			$where_depe = "and ".$db->conn->substr."(cast (a.radi_nume_sal as varchar2(14)), 5, 3) in ($lista_depcod)";
			$joinDep = " ".$db->conn->substr."(a.radi_nume_sal, 5, 3)=c.depe_codi ";
		break;		
	case 'postgres':
			$where_depe = "and cast(".$db->conn->substr."(cast(a.radi_nume_sal as varchar), 5, 3) as integer) in ($lista_depcod)";
			$joinDep = " cast(".$db->conn->substr."(cast(a.radi_nume_sal as varchar), 5, 3) as integer) =c.depe_codi";
		break;
	//Modificado skina
	default:
		$where_depe = "and cast(".$db->conn->substr."(cast (a.radi_nume_sal AS VARCHAR), 5, 3) as integer) in ($lista_depcod)";
		$joinDep = " ".$db->conn->substr."(cast (a.radi_nume_sal AS VARCHAR), 5, 3)=c.depe_codi ";
	}
?>
