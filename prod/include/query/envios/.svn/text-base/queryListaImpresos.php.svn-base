<?php
switch($db->driver)
{
	case 'mssql':
		$isql = "SELECT 
	        convert(varchar(14),b.RADI_NUME_RADI) as RADI_NUME_RADI,a.ANEX_NOMB_ARCHIVO,a.ANEX_DESC,a.SGD_REM_DESTINO,a.SGD_DIR_TIPO
  		   ,convert(varchar(14),a.ANEX_RADI_NUME) as ANEX_RADI_NUME, convert(varchar(14),a.RADI_NUME_SALIDA) as RADI_NUME_SALIDA
		 FROM ANEXOS a,RADICADO b
		 WHERE a.radi_nume_salida=b.radi_nume_radi
			and ".$db->conn->Concat("convert(char(14),a.radi_nume_salida)","'-'","convert(char(3),a.sgd_dir_tipo)")." in(".$setFiltroSelect.")
			and a.sgd_dir_tipo <>7 and anex_estado=3";
		break;
	case 'oracle':
	case 'oci8':
	case 'oci805':
        case 'oci8po':
	$isql = "SELECT 
	        b.RADI_NUME_RADI as RADI_NUME_RADI,a.ANEX_NOMB_ARCHIVO,a.ANEX_DESC,a.SGD_REM_DESTINO,a.SGD_DIR_TIPO
  		   ,a.ANEX_RADI_NUME as ANEX_RADI_NUME, a.RADI_NUME_SALIDA as RADI_NUME_SALIDA, mr.MREC_DESC
		 FROM ANEXOS a,RADICADO b, sgd_dir_drecciones d , MEDIO_RECEPCION mr
		 WHERE a.radi_nume_salida=b.radi_nume_radi
                        and b.radi_nume_radi=d.radi_nume_radi and a.sgd_dir_tipo=d.sgd_dir_tipo
                        and d.MREC_CODI=mr.MREC_CODI
			and a.radi_nume_salida ||'-'||a.sgd_dir_tipo in(".$setFiltroSelect.")
			and a.sgd_dir_tipo <>7 ";		
		break;
	default:
		$isql = "SELECT 
	        	b.RADI_NUME_RADI as RADI_NUME_RADI
			,a.ANEX_NOMB_ARCHIVO
			,a.ANEX_DESC,a.SGD_REM_DESTINO,a.SGD_DIR_TIPO
  		   	,a.ANEX_RADI_NUME as ANEX_RADI_NUME
			,a.RADI_NUME_SALIDA as RADI_NUME_SALIDA
                        ,mr.MREC_DESC
                        ,dep.depe_nomb as DEPENDENCIA
			 FROM ANEXOS a,RADICADO b, sgd_dir_drecciones d , MEDIO_RECEPCION mr, dependencia dep 
			 WHERE a.radi_nume_salida=b.radi_nume_radi
                         and b.radi_depe_radi=dep.depe_codi
                         and b.radi_nume_radi=d.radi_nume_radi and a.sgd_dir_tipo=d.sgd_dir_tipo
                         and d.MREC_CODI=mr.MREC_CODI
			and a.radi_nume_salida ||'-'||a.sgd_dir_tipo in(".$setFiltroSelect.")
			and a.sgd_dir_tipo <>7 ";
	}
?>
