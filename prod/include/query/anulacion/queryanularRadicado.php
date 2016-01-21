<?php
	/**
	  * CONSULTA TIPO RADICACION
	  */
	  /*
	switch($db->driver)
	{  
	 case 'mssql':
		$whereTipoRadi = ' and '.$db->conn->substr.'(convert(char(15),b.radi_nume_radi), 14, 1) = ' .$tipoRadicado;
	break;		
	case 'oracle':
	case 'oci8':
	case 'oci805':	
		$whereTipoRadi = ' and '.$db->conn->substr.'(b.radi_nume_radi, 14, 1) = ' .$tipoRadicado;
	break;		
	
	}
	 */	 
	$isql= ' select
          		b.RADI_NUME_RADI as "IDT_Numero Radicado"
         		,b.RADI_PATH as "HID_RADI_PATH"
        		,'.$sqlFecha.' as "DAT_Fecha Radicado"
        		,b.RADI_NUME_RADI as "HID_RADI_NUME_RADI"
                ,UPPER(substr(d.sgd_anu_desc,21,length(d.sgd_anu_desc))) "Observación"
				,'.$sqlFechaSolAnul.' "Fecha Solicitud Anulación"
                ,UPPER(substr(d.sgd_anu_desc,21,length(d.sgd_anu_desc))) "HID_OBS"								
			  from
				radicado b,						 
				sgd_anu_anulados d,
				dependencia c
			  where 
     			b.SGD_EANU_CODIGO=1 
	            '.$whereDependencia.'			  				
				'.$whereTipoRadi.' 				
				and b.radi_nume_radi=d.radi_nume_radi 
				and c.depe_codi=substr(b.radi_nume_radi,5,3)
				and c.depe_codi_territorial = '.$depe_codi_territorial.'
                '.$whereFecha.'								
			  order by 1';			  	
?>