<?php
/**
  * CONSULTA VERIFICACION PREVIA A LA RADICACION
  */
$isql = 'select '.
	 			$radi_nume_radi. ' AS "IMG_Numero Radicado"
	 			,r.RADI_PATH AS "HID_RADI_PATH", '.
	 			$radi_nume_deri.' AS "Radicado Padre"
	 			,r.RADI_FECH_RADI AS "HOR_RAD_FECH_RADI"
	 			,r.RADI_FECH_RADI AS "Fecha Radicado"
	 			,r.RA_ASUN AS "Descripcion"
	 			,c.SGD_TPR_DESCRIP AS "Tipo Documento"
	 			,d.usua_anu_acta AS "IMG_No Acta"
	 			,d.sgd_anu_path_acta AS "HID_PATH_ACTA"
	 		from radicado r,
	 			SGD_TPR_TPDCUMENTO c,
	 			sgd_anu_anulados d
	 		where
	 			r.radi_nume_radi is not null
	 			and r.radi_nume_radi=d.radi_nume_radi
	 			and '.$db->conn->substr.'('.$radi_nume_radi.', 5, 3)=\''.str_pad($dep_sel,3,"0", STR_PAD_LEFT).'\'
	 			and r.tdoc_codi=c.sgd_tpr_codigo '.$whereTpAnulacion.' '.$whereFiltro.' order by '.$order .' ' .$orderTipo;
?>