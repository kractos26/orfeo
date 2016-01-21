<?
	switch($db->driver)
	{
	case 'mssql':
		$isql = "SELECT 
	        convert(varchar(14),b.RADI_NUME_RADI) as RADI_NUME_RADI,a.ANEX_NOMB_ARCHIVO,a.ANEX_DESC,a.SGD_REM_DESTINO,a.SGD_DIR_TIPO
  		   ,convert(varchar(14),a.ANEX_RADI_NUME) as ANEX_RADI_NUME, convert(varchar(14),a.RADI_NUME_SALIDA) as RADI_NUME_SALIDA
		 FROM ANEXOS a,RADICADO b
		 WHERE a.radi_nume_salida=b.radi_nume_radi
			and a.RADI_NUME_SALIDA in(".$setFiltroSelect.")
			and a.sgd_dir_tipo <>7 and anex_estado=2";
		break;
	case 'oracle':
	case 'oci8':
	case 'oci805':
    case 'oci8po':
	default:
		
		$isql = "SELECT 
				b.RADI_NUME_RADI as RADI_NUME_RADI
				,a.ANEX_NOMB_ARCHIVO ,a.ANEX_DESC 
				,a.SGD_REM_DESTINO ,a.SGD_DIR_TIPO
				,a.ANEX_RADI_NUME as ANEX_RADI_NUME
				,a.RADI_NUME_SALIDA as RADI_NUME_SALIDA
				,m.envio_directo
				,d.sgd_dir_codigo
				,mf.sgd_fenv_codigo
				,d.sgd_dir_telefono
				,d.sgd_dir_direccion
				,d.sgd_dir_mail
				,m.mrec_desc
		 	FROM ANEXOS a
		 	join RADICADO b on a.radi_nume_salida=b.radi_nume_radi
		 	join sgd_dir_drecciones d on d.radi_nume_radi=a.radi_nume_salida and d.sgd_dir_tipo=a.sgd_dir_tipo
		 	left join medio_recepcion m on m.mrec_codi=d.mrec_codi
		 	left join sgd_mtr_mrecfenv mf on mf.mrec_codi=m.mrec_codi
		 	WHERE 
				a.RADI_NUME_SALIDA in(".$setFiltroSelect.")
				 and anex_estado=2";
	}
?>