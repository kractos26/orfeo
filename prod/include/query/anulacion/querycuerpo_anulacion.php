<?php
/**
  * CONSULTA VERIFICACION PREVIA A LA RADICACION
  */
$sqlFecha = $db->conn->SQLDate("d-m-Y H:i A","r.RADI_FECH_RADI"); 
switch($db->driver)
{  
	case 'mssql':
		$isql = 'select
					convert(varchar(14), r.RADI_NUME_RADI) "IMG_Numero Radicado",
					r.RADI_PATH "HID_RADI_PATH",
					convert(varchar(14),r.RADI_NUME_DERI) "Radicado Padre",
					r.RADI_FECH_RADI "HOR_RAD_FECH_RADI",'.
					$sqlFecha.' "Fecha Radicado",
					r.RA_ASUN "Descripcion",
					c.SGD_TPR_DESCRIP "Tipo Documento",
					convert(varchar(14),r.RADI_NUME_RADI) "CHK_CHKANULAR"
				from
					radicado b, SGD_TPR_TPDCUMENTO c
				where 
					r.radi_nume_radi is not null
					and '.$db->conn->substr.'(convert(char(15),r.radi_nume_radi), 5, 3)=\''.str_pad($dep_sel,3,"0", STR_PAD_LEFT).'\'
					and '.$db->conn->substr.'(convert(char(15),r.radi_nume_radi), 14, 1) in (1,3,5)
					and r.tdoc_codi=c.sgd_tpr_codigo
					and sgd_eanu_codigo is null '.
					$whereTpAnulacion.' '.$whereFiltro.'
				order by '.$order .' ' .$orderTipo;
			break;
		case 'oracle':
		case 'oci8':
		case 'oci805':
                case 'oci8po':
			$isql = 'select distinct
                        r.RADI_NUME_RADI as "IMG_Numero Radicado",
                        r.RADI_PATH as "HID_RADI_PATH",
                        r.RADI_NUME_DERI as "Radicado Padre",'.
                        $sqlFecha.' as "HOR_RAD_FECH_RADI",'.
                        $sqlFecha.' as "Fecha Radicado",
                        r.RA_ASUN as "Descripcion",
                        c.SGD_TPR_DESCRIP as "Tipo Documento",
                        r.RADI_NUME_RADI as "CHK_CHKANULAR"
                 from  radicado r
                 inner join SGD_TPR_TPDCUMENTO c on r.tdoc_codi=c.sgd_tpr_codigo
                 left  join anexos a on  r.RADI_NUME_RADI=a.RADI_NUME_SALIDA
                 left  join sgd_renv_regenvio env on r.RADI_NUME_RADI= env.radi_nume_sal
                 where
                       r.radi_nume_radi is not null
                       and (a.anex_estado is null or a.anex_estado < 4)
                       and '.$db->conn->substr.'(r.radi_nume_radi, 5, 3)=\''.str_pad($dep_sel,3,"0", STR_PAD_LEFT).'\'
                       and '.$db->conn->substr.'(r.radi_nume_radi, 14, 1) not in (2)
                       and (sgd_eanu_codigo is null or sgd_eanu_codigo=9)
                                and (env.sgd_renv_planilla = \'00\' or env.sgd_renv_planilla is null)'.
                       $whereTpAnulacion.' '.$whereFiltro.'
                       order by '.$order .' ' .$orderTipo;
			break;
		default:
			$numeroradicado= utf8_encode("IMG_Número Radicado");
			$descripcion= utf8_encode("Descripción");
			$isql = 'select distinct
                        r.RADI_NUME_RADI as "'.$numeroradicado.'",
                        r.RADI_PATH as "HID_RADI_PATH",
                        r.RADI_NUME_DERI as "Radicado Padre",'.
						$sqlFecha.' as "HOR_RAD_FECH_RADI",'.
                        $sqlFecha.' as "Fecha Radicado",
                        r.RA_ASUN as "'.$descripcion.'",
                        c.SGD_TPR_DESCRIP as "Tipo Documento",
                        r.RADI_NUME_RADI as "CHK_CHKANULAR"
                 from  radicado r
                 inner join SGD_TPR_TPDCUMENTO c on r.tdoc_codi=c.sgd_tpr_codigo
                 left  join anexos a on  r.RADI_NUME_RADI=a.RADI_NUME_SALIDA
                 left  join sgd_renv_regenvio env on r.RADI_NUME_RADI= env.radi_nume_sal
                 where
                       r.radi_nume_radi is not null
                       and (a.anex_estado is null or a.anex_estado < 4)
                       and '.$db->conn->substr.'('.$radi_nume_radi.', 5, 3)=\''.str_pad($dep_sel,3,"0", STR_PAD_LEFT).'\'
                       and '.$db->conn->substr.'('.$radi_nume_radi.', 14,1) <> \'2\' 
                       and (sgd_eanu_codigo is null or sgd_eanu_codigo=9)
                                and (env.sgd_renv_planilla = \'00\' or env.sgd_renv_planilla is null)'.
                       $whereTpAnulacion.' '.$whereFiltro.'
                       order by '.$order .' ' .$orderTipo;
			break;		
}
?>