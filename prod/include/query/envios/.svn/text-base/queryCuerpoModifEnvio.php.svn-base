<?php
/**
  * CONSULTA VERIFICACION PREVIA A LA RADICACION
  */
$sqlConcat = $db->conn->Concat("rtrim(a.radi_nume_sal)","'-'","rtrim(a.sgd_renv_codigo)","'-'","rtrim(a.sgd_fenv_codigo)","'-'","rtrim(a.sgd_renv_peso)");
if($dep_sel!=9999)$whereDep=" and ".$db->conn->substr.'(a.radi_nume_sal, 5, 3)=\''.str_pad($dep_sel,3,"0", STR_PAD_LEFT).'\' ';
switch($db->driver)
{
	case 'mssql':
		{	$isql = 'select convert(varchar(15),a.radi_nume_sal)        AS "Radicado"
			,convert(varchar(15),c.RADI_NUME_DERI) AS "Radicado Padre"
			,' . $sqlChar . '       AS "Fecha Envio"
			,a.sgd_renv_planilla    AS "Numero de guia"
			,a.sgd_renv_nombre      AS "Destinatario"
			,a.sgd_renv_dir         AS "Direccion"
			,a.SGD_RENV_PAIS		AS "Pais"
			,a.sgd_renv_depto       AS "Departamento"
			,a.sgd_renv_mpio        AS "Municipio"
			,b.sgd_fenv_descrip     AS "Empresa de Envio"
			,d.USUA_LOGIN           AS "Usuario actual"
			,a.sgd_renv_valor       AS "Valor de envio"
			, '. $sqlConcat .  '    AS "CHR_RADI_NUME_SAL" 
			,a.sgd_dir_tipo         AS HID_sgd_dir_tipo
			,a.sgd_renv_cantidad    AS HID_sgd_renv_cantidad
			,a.sgd_renv_codigo      AS HID_sgd_renv_codigo
			,c.RADI_FECH_RADI       AS HID_RADI_FECH_RADI
			,c.RA_ASUN              AS HID_RA_ASUN
			,d.USUA_NOMB            AS HID_USUA_NOMB
            ,c.radi_depe_actu       AS HID_radi_depe_actu
		from sgd_renv_regenvio a
			 LEFT OUTER JOIN sgd_fenv_frmenvio b
			 ON (a.sgd_fenv_codigo = b.sgd_fenv_codigo)
             ,radicado c
             , usuario d
		where  a.sgd_renv_estado < 8' . 
			$dependencia_busq1 . ' ' .$whereDep.
			$dependencia_busq2 . ' ' .
			$sql_masiva . '		
			and	c.radi_nume_radi= a.radi_nume_sal
  			    and c.radi_depe_actu=d.depe_codi
			    and c.radi_usua_actu=d.usua_codi
      		order by ' . $order .' ' .$orderTipo;
		}break;
	case 'oracle':
        case 'oci8':
        case 'oci8po':
		{
		$isql = 'select 
        		a.radi_nume_sal        AS "Radicado"
			,c.RADI_NUME_DERI       AS "Radicado Padre"
			,' . $sqlChar . '       AS "Fecha Envio"
			,a.sgd_renv_planilla    AS "Numero de guia"
			,a.sgd_renv_nombre      AS "Destinatario"
			,a.sgd_renv_dir         AS "Direccion"
			,a.SGD_RENV_PAIS		AS "Pais"
			,a.sgd_renv_depto       AS "Departamento"
			,a.sgd_renv_mpio        AS "Municipio"
			,b.sgd_fenv_descrip     AS "Empresa de Envio"
			,d.USUA_LOGIN           AS "Usuario actual"
			,a.sgd_renv_valor       AS "Valor de envio"
			,'. $sqlConcat .  '     AS "CHR_RADI_NUME_SAL" 
			,a.sgd_dir_tipo         AS "HID_sgd_dir_tipo"
			,a.sgd_renv_cantidad    AS "HID_sgd_renv_cantidad"
			,a.sgd_renv_codigo      AS "HID_sgd_renv_codigo"
			,c.RADI_FECH_RADI       AS "HID_RADI_FECH_RADI"
			,c.RA_ASUN              AS "HID_RA_ASUN"
			,d.USUA_NOMB            AS "HID_USUA_NOMB"
		        ,c.radi_depe_actu       AS "HID_radi_depe_actu"
			from sgd_renv_regenvio a
			 LEFT OUTER JOIN sgd_fenv_frmenvio b ON a.sgd_fenv_codigo=b.sgd_fenv_codigo,
        		  radicado c, usuario d
			where a.sgd_renv_estado < 8' . 
			$dependencia_busq1 . ' '.$whereDep.
			$dependencia_busq2 . ' '.$sql_masiva .'
			and	c.radi_nume_radi= a.radi_nume_sal
  			    and c.radi_depe_actu=d.depe_codi
			    and c.radi_usua_actu=d.usua_codi
			  order by ' . $order .' ' .$orderTipo;
		}break;
	default:	
		{
			$fechaenvio=utf8_encode("Fecha Envío");
			$direccion=utf8_encode("Dirección");
			$pais=utf8_encode("País");
			$empresaenvio=utf8_encode("Empresa de Envío");
			$valorenvio=utf8_encode("Valor de envío");
			$sqlConcat = $db->conn->Concat("cast(a.radi_nume_sal as varchar)","'-'","cast(a.sgd_renv_codigo as varchar)","'-'","cast(a.sgd_fenv_codigo as varchar)","'-'","cast(a.sgd_renv_peso as varchar)");
			if($dep_sel!=9999)$whereDep=" and ".$db->conn->substr.'(cast(a.radi_nume_sal as varchar), 5, 3)=\''.str_pad($dep_sel,3,"0", STR_PAD_LEFT).'\' ';
		$isql = 'select 
        		a.radi_nume_sal        AS "Radicado"
			,c.RADI_NUME_DERI       AS "Radicado Padre"
			,' . $sqlChar . '       AS "'.$fechaenvio.'"
			,a.sgd_renv_planilla    AS "Planilla"
			,a.sgd_renv_nombre      AS "Destinatario"
			,a.sgd_renv_dir         AS "'.$direccion.'"
			,a.SGD_RENV_PAIS		AS "'.$pais.'"
			,a.sgd_renv_depto       AS "Departamento"
			,a.sgd_renv_mpio        AS "Municipio"
			,b.sgd_fenv_descrip     AS "'.$empresaenvio.'"
			,d.USUA_LOGIN           AS "Usuario actual"
			,a.sgd_renv_valor       AS "'.$valorenvio.'"
			,'. $sqlConcat .  '     AS "CHR_RADI_NUME_SAL" 
			,a.sgd_dir_tipo         AS "HID_sgd_dir_tipo"
			,a.sgd_renv_cantidad    AS "HID_sgd_renv_cantidad"
			,a.sgd_renv_codigo      AS "HID_sgd_renv_codigo"
			,c.RADI_FECH_RADI       AS "HID_RADI_FECH_RADI"
			,c.RA_ASUN              AS "HID_RA_ASUN"
			,d.USUA_NOMB            AS "HID_USUA_NOMB"
		        ,c.radi_depe_actu       AS "HID_radi_depe_actu"
			from sgd_renv_regenvio a
			 LEFT OUTER JOIN sgd_fenv_frmenvio b ON a.sgd_fenv_codigo=b.sgd_fenv_codigo,
        		  radicado c, usuario d
			where a.sgd_renv_estado < 8' . 
			$dependencia_busq1 . ' '.$whereDep.
			$dependencia_busq2 . ' '.$sql_masiva .'
			and	c.radi_nume_radi= a.radi_nume_sal
  			    and c.radi_depe_actu=d.depe_codi
			    and c.radi_usua_actu=d.usua_codi
			  order by ' . $order .' ' .$orderTipo;
		}break;
}
?>