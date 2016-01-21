<?

$tm="select sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo='$edifi'";
$tm1="select sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo='$ite3'";
$tm2="select sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo='$ite4'";
$tm3="select sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo='$ite2'";
$tm4="select sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo='$ite1'";
$tm5="select sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo='$ite5'";
$tm6="select sgd_eit_sigla from sgd_eit_items where sgd_eit_codigo='$caja'";

	switch($db->driver)
	{
	case 'mssql':
		$redondeo = $db->conn->round(((radi_fech_radi+(b.sgd_tpr_termino * 7/5))-$sqlFechaHoy));
		$isql = "select d.sgd_exp_numero as sgd_exp_numero ,
	   				d.sgd_exp_estado,
	   				a.radi_path,
	   				convert(varchar(15),d.RADI_NUME_RADI) as RADI_NUME_RADI,
	   				a.RADI_NUME_HOJA,
	   				a.RADI_FECH_RADI,
	   				convert(varchar(15),a.RADI_NUME_RADI) as RADI_NUME_RADI,
	   				a.RA_ASUN  ,
	   				a.RADI_PATH ,
	   				a.RADI_USUA_ACTU ,".
					$sqlfecha." AS FECHA ,
					b.sgd_tpr_descrip,
					b.sgd_tpr_codigo,
					b.sgd_tpr_termino,
					$redondeo AS diasr,	
					RADI_LEIDO,RADI_TIPO_DERI,RADI_NUME_DERI,a.radi_depe_actu,
					e.depe_nomb,
					f.usua_nomb,
					d.sgd_exp_fech_arch,
					d.sgd_exp_fech
			   from radicado a,sgd_tpr_tpdcumento b,SGD_EXP_EXPEDIENTE d, DEPENDENCIA e,USUARIO f
			   where 
			    f.usua_codi=a.radi_usua_actu and f.depe_codi=a.radi_depe_actu
				and e.depe_codi=a.radi_depe_actu 
				and a.tdoc_codi=b.sgd_tpr_codigo
				AND a.radi_nume_radi=d.radi_nume_radi
				$dependencia_busq1
				order by $order	";
		$isqlCount = "select count(*) REGS
				from radicado a,sgd_tpr_tpdcumento b,SGD_EXP_EXPEDIENTE d, DEPENDENCIA e,USUARIO f
				where 
				f.usua_codi=a.radi_usua_actu and f.depe_codi=a.radi_depe_actu
			and e.depe_codi=a.radi_depe_actu 
			and a.tdoc_codi=b.sgd_tpr_codigo
			AND a.radi_nume_radi=d.radi_nume_radi
			$dependencia_busq1
			";
			if($estado==2)$isqlCount.=" and d.SGD_EXP_FECH_ARCH !='' ";

		$sqlr="select m.sgd_tpr_descrip from sgd_tpr_tpdcumento m,radicado r where
	r.radi_nume_radi like '$data' and m.sgd_tpr_codigo=r.tdoc_codi";
		$sqle="select SGD_EXP_CAJA,SGD_EXP_ESTANTE,RADI_USUA_ARCH,SGD_EXP_ENTREPA,SGD_EXP_EDIFICIO,SGD_EXP_ISLA from
		SGD_EXP_EXPEDIENTE where SGD_EXP_NUMERO like '$num_expediente' order by '$order2'";

	break;
	case 'oracle':
	case 'oci8':
        case 'oci8po':
	case 'postgres':
		$isql = "select d.sgd_exp_numero,
				d.sgd_exp_estado,
				a.radi_path,
				d.RADI_NUME_RADI ,
				a.RADI_NUME_HOJA,
				a.RADI_FECH_RADI,
				a.RADI_NUME_RADI,
				a.RA_ASUN  ,
				a.RADI_PATH ,
				a.RADI_USUA_ACTU ,".
				$sqlfecha." AS FECHA ,
				b.sgd_tpr_descrip,
				b.sgd_tpr_codigo,
				b.sgd_tpr_termino,
				ROUND(((radi_fech_radi+(b.sgd_tpr_termino * 7/5))-SYSDATE)) AS diasr ,
				RADI_LEIDO,RADI_TIPO_DERI,RADI_NUME_DERI,a.radi_depe_actu,
				e.depe_nomb,
				f.usua_nomb,
				d.sgd_exp_fech_arch,
				d.sgd_exp_fech
				,d.SGD_EXP_ASUNTO
				from radicado a,sgd_tpr_tpdcumento b,SGD_EXP_EXPEDIENTE d, DEPENDENCIA e,USUARIO f
				where 
				f.usua_codi=a.radi_usua_actu and f.depe_codi=a.radi_depe_actu
			and e.depe_codi=a.radi_depe_actu 
			and a.tdoc_codi=b.sgd_tpr_codigo
			AND a.radi_nume_radi=d.radi_nume_radi
			$dependencia_busq1
			order by $order	";
		$isqlCount = "select count(*) CONTADOR
			from radicado a,SGD_EXP_EXPEDIENTE d, DEPENDENCIA e
			where 
			e.depe_codi=a.radi_depe_actu 
			AND a.radi_nume_radi=d.radi_nume_radi
			$dependencia_busq1
			";
			
			if($estado==2)$isqlCount.=" and d.SGD_EXP_FECH_ARCH !='' ";

		$sqlr="select m.sgd_tpr_descrip from sgd_tpr_tpdcumento m,radicado r where
	r.radi_nume_radi like '$data' and m.sgd_tpr_codigo=r.tdoc_codi";
		$sqle="select SGD_EXP_CAJA,RADI_USUA_ARCH,SGD_EXP_ENTREPA,SGD_EXP_EDIFICIO from SGD_EXP_EXPEDIENTE where SGD_EXP_NUMERO like '$num_expediente' and sgd_exp_estado=1";
	break;
	}
?>