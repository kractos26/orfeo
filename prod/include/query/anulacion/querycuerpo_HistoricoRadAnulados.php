<?php
	/**
	  * CONSULTA VERIFICACION PREVIA A LA RADICACION
	  */
	switch($db->driver)
	{  
	 case 'mssql':
	  $isql = 'select
								convert(varchar(15), b.RADI_NUME_RADI) "IMG_Numero Radicado"
								,b.RADI_PATH "HID_RADI_PATH"
								,convert(varchar(15),b.RADI_NUME_DERI) "Radicado Padre"
								,b.RADI_FECH_RADI "HOR_RAD_FECH_RADI"
								,'.$sqlFecha.' "Fecha Radicado"
								,b.RA_ASUN "Descripcion"
								,c.SGD_TPR_DESCRIP "Tipo Documento"
								,d.usua_anu_acta "IMG_No Acta"
								,d.sgd_anu_path_acta "HID_PATH_ACTA"
						 from
						 radicado b,
						 SGD_TPR_TPDCUMENTO c,
						 sgd_anu_anulados d
					 where 
					 	b.radi_nume_radi is not null
						and b.radi_nume_radi=d.radi_nume_radi
						and '.$db->conn->substr.'(convert(char(15),b.radi_nume_radi), 5, 3)='.$dep_sel.'
						and b.tdoc_codi=c.sgd_tpr_codigo
						'.$whereTpAnulacion.'
						'.$whereFiltro.'
					  order by '.$order .' ' .$orderTipo;
	break;		
	case 'oracle':
	case 'oci8':
	case 'oci805':	
	       $isql = ' select
          				b.RADI_NUME_RADI as "IDT_Numero_Radicado"
         				,b.RADI_PATH as "HID_RADI_PATH"
        				,'.$sqlFecha.' as "DAT_Fecha Radicado"
        				,b.RADI_NUME_RADI as "HID_RADI_NUME_RADI"
        				,UPPER(b.RA_ASUN) as "Asunto"		   
                        ,(select c.SGD_TPR_DESCRIP from SGD_TPR_TPDCUMENTO 
                        c where c.sgd_tpr_codigo=b.tdoc_codi) as "Tipo_Documento"										
			
					 from
						 radicado b,						 
						 sgd_anu_anulados d
					 where 
						'.$whereTpAnulacion.'						
        				'.$whereRadicado.'				
						'.$whereDepSel.'						
						'.$whereTipoRadicado.'														
						and d.radi_nume_radi=b.radi_nume_radi						
					  order by '.$order.' '.$orderTipo;
            
                                            
				break;
	}
?>