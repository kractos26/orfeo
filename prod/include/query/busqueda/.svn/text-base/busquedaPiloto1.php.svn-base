<?PHP 

if (!$db->driver){	$db = $this->db; }	//Esto sirve para cuando se llama este archivo dentro de clases donde no se conoce $db.
$systemDate = $db->conn->sysTimeStamp;
$tmp_substr = $db->conn->substr;
switch($db->driver)
{	case 'mssql':
			// Ejecuta la consulta por defecto si no es DNP
			$radi_nume_radi		= " convert(varchar(14), r.radi_nume_radi) ";
			$radi_nume_deri		= " convert(varchar(14), r.radi_nume_deri) ";
			$usua_doc_c			= " convert(varchar(8), c.USUA_DOC) ";
			$radi_nume_salida	= " convert(varchar(14), RADI_NUME_SALIDA) ";
			$radi_nume_sal		= " convert(varchar(14), RADI_NUME_SAL) ";
			$anex_radi_nume     = " convert(varchar(14), r.anex_radi_nume) ";
			$redondeo = $db->conn->round("(r.radi_fech_radi+(td.sgd_tpr_termino * 7/5)) -$systemDate") + "(select count(*) from sgd_noh_nohabiles where NOH_FECHA between r.radi_fech_radi and ".$db->conn->sysTimeStamp.")";
			$redondeo2 = $db->conn->round("(agen.SGD_AGEN_FECHPLAZO)-$systemDate");
			$diasf              = " convert(int,".$systemDate."-r.sgd_fech_impres)";
			$depe_codi = " convert(varchar(3), d.depe_codi) ";
                        $radi_nume_radiCuerpo	= " convert(varchar(14), b.radi_nume_radi) ";
                        $prefijoFuncion="dbo.";
                        $d_pais="convert(varchar(3),DEPARTAMENTO.ID_PAIS)";
                        $d_depto="convert(varchar(3),DEPARTAMENTO.DPTO_CODI)";
                        $m_pais="convert(varchar(3),MUNICIPIO.ID_PAIS)";
                        $m_depto="convert(varchar(3),MUNICIPIO.DPTO_CODI)";
                        $m_muni="convert(varchar(3),MUNICIPIO.MUNI_CODI)";
		break;
		case 'oracle':
		case 'oci8':
		case 'oci805':
                case 'oci8po':
		case 'ocipo':
		{	$radi_nume_radi = " r.RADI_NUME_RADI ";
			$radi_nume_deri		= " r.radi_nume_deri ";
			$usua_doc_c			= " convert(varchar(8), c.USUA_DOC) ";
			$radi_nume_salida = " RADI_NUME_SALIDA ";
			$radi_nume_sal = " RADI_NUME_SAL ";
			$redondeo = "round(((r.RADI_FECH_RADI+(td.SGD_TPR_TERMINO * 7/5))-$systemDate))+(select count(*) from sgd_noh_nohabiles where NOH_FECHA between r.radi_fech_radi and ".$db->conn->sysTimeStamp.")";
			$depe_codi = " d.depe_codi ";
                        $radi_nume_radiCuerpo	= " b.RADI_NUME_RADI ";
                        $prefijoFuncion="";
                        $d_pais="DEPARTAMENTO.ID_PAIS";
                        $d_depto="DEPARTAMENTO.DPTO_CODI";
                        $m_pais="MUNICIPIO.ID_PAIS";
                        $m_depto="MUNICIPIO.DPTO_CODI";
                        $m_muni="MUNICIPIO.MUNI_CODI";
		}break;
	case 'postgres':
	case 'postgres7':
		{	$radi_nume_radi		= "cast(r.radi_nume_radi as varchar(14)) ";
			$radi_nume_deri		= " cast(r.radi_nume_deri as varchar(14)) ";
			$usua_doc_c		= "cast(c.USUA_DOC as varchar(8)) ";
			$radi_nume_salida	= "cast(RADI_NUME_SALIDA as varchar(14)) ";
			$radi_nume_sal		= "cast(RADI_NUME_SAL as varchar(14)) ";
			$resta=" (r.RADI_FECH_RADI - ".$systemDate.") ";
			$cast = " cast(".$resta." as number(10)) ";
			$redondeo="date_part('days', r.radi_fech_radi-".$db->conn->sysTimeStamp.")+floor(td.sgd_tpr_termino * 7/5)+(select count(*) from sgd_noh_nohabiles where NOH_FECHA between r.radi_fech_radi and ".$db->conn->sysTimeStamp.")";
			$depe_codi = " cast(d.depe_codi as varchar) ";
                        $radi_nume_radiCuerpo		= "cast(b.radi_nume_radi as varchar(14)) ";
                        $prefijoFuncion="";
                        $d_pais="DEPARTAMENTO.ID_PAIS";
                        $d_depto="DEPARTAMENTO.DPTO_CODI";
                        $m_pais="MUNICIPIO.ID_PAIS";
                        $m_depto="MUNICIPIO.DPTO_CODI";
                        $m_muni="MUNICIPIO.MUNI_CODI";
                        
		}break;
	default:
		{
			$radi_nume_radi = " r.radi_nume_radi ";
			$usua_doc_c = " c.USUA_DOC ";
			$radi_nume_salida = " RADI_NUME_SALIDA ";
			$radi_nume_sal = " RADI_NUME_SAL ";
			$depe_codi = " d.depe_codi ";
                        $radi_nume_radiCuerpo	= " b.RADI_NUME_RADI ";
                        $prefijoFuncion="";
                        $d_pais="DEPARTAMENTO.ID_PAIS";
                        $d_depto="DEPARTAMENTO.DPTO_CODI";
                        $m_pais="MUNICIPIO.ID_PAIS";
                        $m_depto="MUNICIPIO.DPTO_CODI";
                        $m_muni="MUNICIPIO.MUNI_CODI";
		}break;
}
?>
