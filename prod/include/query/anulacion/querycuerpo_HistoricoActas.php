<?php
	/**
	  * CONSULTA QUE PRESENTA EL LISTADO DE ACTAS
   	  */
    $whereTipoRadicado="";
	if ($tipoRadicado){ $whereTipoRadicado=" and b.sgd_trad_codigo=$tipoRadicado"; }
    $rutaIsql1="'<a class=''leidos'' href=../bodega/'";
    $rutaIsql2="'><span class=>'";
	$rutaIsql3="'</span></a>'";
    $isql='select distinct b.usua_anu_acta "IMG_No Acta" , b.sgd_anu_path_acta "HID_PATH_ACTA", 
					u.usua_nomb as "Usuario Anulador", 
					t.sgd_trad_descr as "Tipo Radicacion Anulada", 
					'.$sqlFechaAnul.'  as "Fecha_Anulacion" 
					from sgd_anu_anulados b 
						inner join  usuario u on u.usua_doc=b.usua_doc_anu 
  					   inner join sgd_trad_tiporad t on t.sgd_trad_codigo=b.sgd_trad_codigo
					, dependencia d  
					where d.depe_codi=b.depe_codi_anu 
				 '.$whereTipoRadicado.'
     	   order by '.$order .' ' .$orderTipo
   
      /*
      select distinct 		
			     b.usua_anu_acta "IMG_No Acta" ,
  			     b.sgd_anu_path_acta "HID_PATH_ACTA", 
                 (select u.usua_nomb from usuario u where u.usua_doc=b.usua_doc_anu) as "Usuario Anulador",
                 (select t.sgd_trad_descr from sgd_trad_tiporad t where t.sgd_trad_codigo=b.sgd_trad_codigo) as "Tipo Radicación Anulada", 
                 '.$sqlFechaAnul.' as "Fecha_Anulación"						   		
		   from  sgd_anu_anulados b,
			     dependencia d
		   where d.depe_codi=b.depe_codi_anu 
				 '.$whereTipoRadicado.'
     	   order by '.$order .' ' .$orderTipo;*/
?>