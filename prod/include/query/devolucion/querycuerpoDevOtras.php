<?php
/**
 * CONSULTA VERIFICACION
 */
if($dep_sel!=9999)$whereDep=" and ".$db->conn->substr.'(a.radi_nume_sal, 5, 3)=\''.str_pad($dep_sel,3,"0", STR_PAD_LEFT).'\' ';
switch($db->driver)
{
	case 'mssql':
	case 'oracle':
	case 'oci8':
	case 'oci805':
        case 'oci8po':
		$sqlConcat = $db->conn->Concat("a.radi_nume_sal","'-'","a.sgd_renv_codigo");
		$isql = 'select ' . "4" . '         	AS "CHU_ESTADO"
				,' . 0 . '              AS "HID_DEVE_CODIGO"
				,a.radi_nume_sal        AS "Radicado"
				,c.RADI_NUME_DERI       AS "Radicado Padre"
                                ,'.$db->conn->substr.'(ae.sgd_dir_tipo,2,2) AS "Copia"
				,' . $sqlChar . '       AS "Fecha Envio"
				,a.sgd_renv_planilla    AS "Numero de guia"
				,a.sgd_renv_nombre      AS "Destinatario"
				,a.sgd_renv_dir         AS "Direccion"
				,a.sgd_renv_depto       AS "Departamento"
				,a.sgd_renv_mpio        AS "Municipio"
				,b.sgd_fenv_descrip     AS "Empresa de Envio"
				,d.USUA_LOGIN           AS "Usuario actual"
				,'.$valor.'             AS "Valor de envio"
				, '. $sqlConcat .  '    AS "CHK_RADI_NUME_SAL"
				,a.sgd_dir_tipo         AS "HID_sgd_dir_tipo"
				,a.sgd_renv_cantidad    AS "HID_sgd_renv_cantidad"
				,a.sgd_renv_codigo      AS "HID_sgd_renv_codigo"
				,c.RADI_FECH_RADI       AS "HID_RADI_FECH_RADI"
				,c.RA_ASUN              AS "HID_RA_ASUN"
				,d.USUA_NOMB            AS "HID_USUA_NOMB"
				,c.radi_depe_actu       AS "HID_radi_depe_actu"
			from sgd_renv_regenvio a
                                join anexos ae on  a.radi_nume_sal=ae.radi_nume_salida and a.sgd_dir_tipo=ae.sgd_dir_tipo
                                join radicado c on a.radi_nume_sal=c.radi_nume_radi
                                join usuario d on c.radi_depe_actu=d.depe_codi and c.radi_usua_actu=d.usua_codi
                                left outer join sgd_fenv_frmenvio b ON a.sgd_fenv_codigo = b.sgd_fenv_codigo
			where a.sgd_deve_codigo is null ' .
				$dependencia_busq1 . ' '.$whereDep.

				$dependencia_busq2 . '
				and a.sgd_renv_estado < 8
				' .$sql_masiva . '
			order by ' . $order .$orderTipo;
		break;
	default:
		if($dep_sel!=9999)$whereDep=" and ".$db->conn->substr.'(cast(a.radi_nume_sal as varchar), 5, 3)=\''.str_pad($dep_sel,3,"0", STR_PAD_LEFT).'\' ';
		$sqlConcat = $db->conn->Concat("cast(a.radi_nume_sal as varchar)","'-'","cast(a.sgd_renv_codigo as varchar)");
		$isql = 'select ' . "4" . '     AS "CHU_ESTADO"
				,' . 0 . '              AS "HID_DEVE_CODIGO"
				,a.radi_nume_sal        AS "Radicado"
				,c.RADI_NUME_DERI       AS "Radicado Padre"
                ,'.$db->conn->substr.'(cast(ae.sgd_dir_tipo as varchar),2,2) AS "Copia"
				,' . $sqlChar . '       AS "Fecha Envio"
				,a.sgd_renv_planilla    AS "Planilla"
				,a.sgd_renv_nombre      AS "Destinatario"
				,a.sgd_renv_dir         AS "Direccion"
				,a.sgd_renv_depto       AS "Departamento"
				,a.sgd_renv_mpio        AS "Municipio"
				,b.sgd_fenv_descrip     AS "Empresa de Envio"
				,d.USUA_LOGIN           AS "Usuario actual"
				,'.$valor.'             AS "Valor de envio"
				, '. $sqlConcat .  '    AS "CHK_RADI_NUME_SAL"
				,a.sgd_dir_tipo         AS "HID_sgd_dir_tipo"
				,a.sgd_renv_cantidad    AS "HID_sgd_renv_cantidad"
				,a.sgd_renv_codigo      AS "HID_sgd_renv_codigo"
				,c.RADI_FECH_RADI       AS "HID_RADI_FECH_RADI"
				,c.RA_ASUN              AS "HID_RA_ASUN"
				,d.USUA_NOMB            AS "HID_USUA_NOMB"
				,c.radi_depe_actu       AS "HID_radi_depe_actu"
			from sgd_renv_regenvio a
                                join anexos ae on  a.radi_nume_sal=ae.radi_nume_salida and a.sgd_dir_tipo=ae.sgd_dir_tipo
                                join radicado c on a.radi_nume_sal=c.radi_nume_radi
                                join usuario d on c.radi_depe_actu=d.depe_codi and c.radi_usua_actu=d.usua_codi
                                left outer join sgd_fenv_frmenvio b ON a.sgd_fenv_codigo = b.sgd_fenv_codigo
			where a.sgd_deve_codigo is null ' .
				$dependencia_busq1 . ' '.$whereDep.

				$dependencia_busq2 . '
				and a.sgd_renv_estado < 8
				' .$sql_masiva . '
			order by ' . $order .$orderTipo;
		break;
	}
?>