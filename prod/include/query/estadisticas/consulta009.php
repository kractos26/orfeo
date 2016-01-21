<?php

/* * *******************************************************************************
 *       Filename: Reporte Proceso Radicados de Entrada
 * 		 @autor LUCIA OJEDA ACOSTA - CRA
 * 		 @version ORFEO 3.5
 *       PHP 4.0 build 22-Feb-2006
 * ******************************************************************************* */

$coltp3Esp = '"' . $tip3Nombre[3][2] . '"';
if (!$orno)
    $orno = 1;
$_POST['resol'] ? $resolucion = " and r.sgd_tres_codigo = " . $_POST['resol'] . " " : 0;
$_GET['resol'] ? $resolucion = " and r.sgd_tres_codigo = " . $_GET['resol'] . " " : 0;


$orderE = "	ORDER BY $orno $ascdesc ";

$desde = $fecha_ini . " " . "00:00:00";
$hasta = $fecha_fin . " " . "23:59:59";

$sWhereFec = " and " . $db->conn->SQLDate('Y/m/d H:i:s', 'R.RADI_FECH_RADI') . " >= '$desde'
				and " . $db->conn->SQLDate('Y/m/d H:i:s', 'R.RADI_FECH_RADI') . " <= '$hasta'";

if ($dependencia_busq != 99999)
    $condicionE = "	AND r.radi_depe_radi=$dependencia_busq ";

$innerSeries = (!empty($idSerie)) ? "  inner join sgd_rdf_retdocf f on f.radi_nume_radi=r.radi_nume_radi 
									inner join sgd_mrd_matrird m on m.sgd_mrd_codigo = f.sgd_mrd_codigo and m.sgd_srd_codigo=$idSerie " : "";



$redondeo = "diashabiles(" . $db->conn->sysDate . ", r.radi_fech_radi::date)-(td.sgd_tpr_termino)";
//diashabiles(CURRENT_DATE, r.radi_fech_radi::date) AS DIAS_TRAM
switch ($db->driver) {
    case 'postgres':
    case 'mssql': {            
            $sSQL_1 = "select $radi_nume_radi AS RAD_ENTRADA, 
					" . $db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi') . " AS FEC_RAD_E , 
					$tmp_substr(cast($radi_nume_salida AS VARCHAR),1,14) AS RAD_SALIDA, 
					d2.depe_nomb AS DEPE_CONTESTA,
					" . $db->conn->SQLDate('Y/m/d', 'a.anex_radi_fech') . " AS FEC_RAD_S,
					(case when an.sgd_eanu_codi=1 then 'Solicitado' when an.sgd_eanu_codi=2 then 'Anulado' else '.' end) AS ANULADO," .
                    $db->conn->SQLDate('Y/m/d', 'g.sgd_renv_fech') . " AS FEC_ENVIO,
					t.sgd_tpr_descrip AS TIPO, 
					r.ra_asun AS ASUNTO, 
					d.depe_nomb AS DEP_ACTUAL, 
					b.usua_nomb AS USU_ACTUAL, 
					r.radi_usu_ante AS USU_ANT,
					x.sgd_dir_nomremdes AS REMITENTE,                                       
					sumadiashabiles(r.radi_fech_radi::date,t.sgd_tpr_termino::integer) AS FECH_VCMTO,
					diashabilestramite(r.radi_fech_radi::date,g.sgd_renv_fech::date)::varchar AS DIAS_TRAM,                                       
					(select y.depe_nomb from hist_eventos z inner join dependencia y on z.depe_codi_dest=y.depe_codi where z.sgd_ttr_codigo=9 and z.radi_nume_radi=r.radi_nume_radi order by z.hist_fech asc limit 1 ) AS PRIMERA_DEPENDENCIA 
					{$seguridad}
                                         ,e.ent_name        
				from radicado r $innerSeries                                        
					inner join anexos a on r.radi_nume_radi = a.anex_radi_nume AND a.radi_nume_salida > 0
					inner join sgd_renv_regenvio g on a.radi_nume_salida=g.radi_nume_sal and a.sgd_dir_tipo=g.sgd_dir_tipo
					inner join sgd_tpr_tpdcumento t on r.tdoc_codi=t.sgd_tpr_codigo
					inner join usuario b on r.radi_usua_actu=b.usua_codi AND r.radi_depe_actu=b.depe_codi
					inner join dependencia d on r.radi_depe_actu = d.depe_codi
					inner join dependencia d2 on cast(substr(cast(a.radi_nume_salida AS VARCHAR),5,3)as integer) = d2.depe_codi
					left join sgd_anu_anulados an on a.radi_nume_salida = an.radi_nume_radi
					inner join sgd_dir_drecciones x on x.radi_nume_radi=r.radi_nume_radi
                                        left join sgd_rad_entidad e on e.ent_id=r.radi_ent
				where cast (r.RADI_NUME_RADI as VARCHAR) like '%2'  AND x.sgd_dir_tipo=1
					AND r.codi_nivel <=5";

            $sSQL_2 = "select $radi_nume_radi AS RAD_ENTRADA, 
					" . $db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi') . " AS FEC_RAD_E , 
					$tmp_substr(cast($radi_nume_salida AS VARCHAR),1,14) AS RAD_SALIDA, 
					d2.depe_nomb AS DEPE_CONTESTA,
					" . $db->conn->SQLDate('Y/m/d', 'a.anex_radi_fech') . " AS FEC_RAD_S,
					(case when an.sgd_eanu_codi=1 then 'Solicitado' when an.sgd_eanu_codi=2 then 'Anulado' else '.' end) AS ANULADO,
					'' AS FEC_ENVIO,
					t.sgd_tpr_descrip AS TIPO, 
					r.ra_asun AS ASUNTO, 
					d.depe_nomb AS DEP_ACTUAL, 
					b.usua_nomb AS USU_ACTUAL, 
					r.radi_usu_ante AS USU_ANT,
					x.sgd_dir_nomremdes AS REMITENTE,                                      
					sumadiashabiles(r.radi_fech_radi::date,t.sgd_tpr_termino::integer) AS FECH_VCMTO,
					'Pendiente' AS DIAS_TRAM,                                        
					(select y.depe_nomb from hist_eventos z inner join dependencia y on z.depe_codi_dest=y.depe_codi where z.sgd_ttr_codigo=9 and z.radi_nume_radi=r.radi_nume_radi order by z.hist_fech asc limit 1 ) AS PRIMERA_DEPENDENCIA 
					{$seguridad}
                                         ,e.ent_name    
				from radicado r $innerSeries                                        
					inner join anexos a on r.radi_nume_radi = a.anex_radi_nume AND a.radi_nume_salida > 0 and (a.radi_nume_salida,a.sgd_dir_tipo) not in (select g.radi_nume_sal,g.sgd_dir_tipo from sgd_renv_regenvio g)
					inner join sgd_tpr_tpdcumento t on r.tdoc_codi=t.sgd_tpr_codigo
					inner join usuario b on r.radi_usua_actu=b.usua_codi AND r.radi_depe_actu=b.depe_codi
					inner join dependencia d on r.radi_depe_actu = d.depe_codi
					inner join dependencia d2 on cast(substr(cast(a.radi_nume_salida AS VARCHAR),5,3)as integer) = d2.depe_codi
					left join sgd_anu_anulados an on a.radi_nume_salida = an.radi_nume_radi
					inner join sgd_dir_drecciones x on x.radi_nume_radi=r.radi_nume_radi
                                        left join sgd_rad_entidad e on e.ent_id=r.radi_ent
				where cast (r.RADI_NUME_RADI as VARCHAR) like '%2'  AND x.sgd_dir_tipo=1
					AND r.codi_nivel <=5";

            $sSQL_3 = "SELECT 
					$radi_nume_radi AS RAD_ENTRADA, 
					" . $db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi') . " AS FEC_RAD_E, 
					'0' AS RAD_SALIDA,
					'' AS DEPE_CONTESTA,
					'' AS FEC_RAD_S, 
					'.' AS ANULADO,
					'' AS FEC_ENVIO,
					td.sgd_tpr_descrip AS TIPO, 
					r.ra_asun AS ASUNTO, 
					d.depe_nomb AS DEP_ACTUAL, 
					b.usua_nomb AS USU_ACTUAL, 
					r.radi_usu_ante AS USU_ANT,
					x.sgd_dir_nomremdes AS REMITENTE,                                        
					sumadiashabiles(r.radi_fech_radi::date,td.sgd_tpr_termino::integer) AS FECH_VCMTO,
					'Pendiente' AS DIAS_TRAM,                                   
					(select y.depe_nomb from hist_eventos z inner join dependencia y on z.depe_codi_dest=y.depe_codi where z.sgd_ttr_codigo=9 and z.radi_nume_radi=r.radi_nume_radi order by z.hist_fech asc limit 1 ) AS PRIMERA_DEPENDENCIA
					{$seguridad}
                                         ,e.ent_name        
				FROM radicado r $innerSeries
					inner join sgd_tpr_tpdcumento td on r.tdoc_codi=td.sgd_tpr_codigo 
					inner join usuario b on r.radi_usua_actu=b.usua_codi AND r.radi_depe_actu=b.depe_codi 
					inner join dependencia d on r.radi_depe_actu = d.depe_codi
					inner join sgd_dir_drecciones x on x.radi_nume_radi=r.radi_nume_radi
                                        left join sgd_rad_entidad e on e.ent_id=r.radi_ent
				WHERE r.codi_nivel <=5 
					AND cast($tmp_substr(cast($radi_nume_radi AS VARCHAR),14,1)as integer) = 2 AND r.radi_nume_radi NOT IN (select anex_radi_nume from anexos)  AND x.sgd_dir_tipo=1";
            $sSQL_4 = "
				select  $radi_nume_radi AS RAD_ENTRADA, 
					" . $db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi') . " AS FEC_RAD_E,
					'ANEXO SIN RADICAR' AS RAD_SALIDA, 
					'' AS DEPE_CONTESTA,										
					" . $db->conn->SQLDate('Y/m/d', 'a.anex_radi_fech') . " AS FEC_RAD_S,
					'.' AS ANULADO,
					" . $db->conn->SQLDate('Y/m/d', 'a.anex_fech_envio') . " AS FEC_ENVIO,
					td.sgd_tpr_descrip AS TIPO, 
					r.ra_asun AS ASUNTO, 
					d1.depe_nomb AS DEP_ACTUAL, 
					b.usua_nomb AS USU_ACTUAL, 
					r.radi_usu_ante AS USU_ANT,
					x.sgd_dir_nomremdes AS REMITENTE,                                       
					sumadiashabiles(r.radi_fech_radi::date,td.sgd_tpr_termino::integer) AS FECH_VCMTO,
					'Pendiente' AS DIAS_TRAM,                                        
					(select y.depe_nomb from hist_eventos z inner join dependencia y on z.depe_codi_dest=y.depe_codi where z.sgd_ttr_codigo=9 and z.radi_nume_radi=r.radi_nume_radi order by z.hist_fech asc limit 1 ) AS PRIMERA_DEPENDENCIA
					{$seguridad}
                                         ,e.ent_name        
				from radicado r $innerSeries
					inner join anexos a on r.radi_nume_radi = a.anex_radi_nume AND a.radi_nume_salida is null AND a.anex_borrado = 'N' 
					inner join sgd_tpr_tpdcumento td on r.tdoc_codi=td.sgd_tpr_codigo 
					inner join usuario b on r.radi_usua_actu=b.usua_codi AND r.radi_depe_actu=b.depe_codi 
					inner join dependencia d1 on b.depe_codi=d1.depe_codi
					inner join sgd_dir_drecciones x on x.radi_nume_radi=r.radi_nume_radi
                                        left join sgd_rad_entidad e on e.ent_id=r.radi_ent
				where   cast (r.RADI_NUME_RADI as VARCHAR) like '%2'  AND x.sgd_dir_tipo=1 AND r.codi_nivel <=5 ";
            $queryE = "SELECT " .
                    $db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi') . " AS FECH_RADI,
					count($radi_nume_radi) AS RADICADOS,
					MIN(" . $db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi') . ") AS HID_FECH_SELEC
				from radicado r $innerSeries
				WHERE cast (r.RADI_NUME_RADI as VARCHAR) LIKE '%2'
				$condicionE $sWhereFec
			GROUP BY " . $db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi') . " ORDER BY $orno $ascdesc";
            //-------------------------------
            // Assemble full SQL statement
            //-------------------------------
           
            if (!is_null($fecSel))
                $sWhereFecE = " AND " . $db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi') . " = '" . $fecSel . "'";

            /** CONSULTA PARA VER DETALLES 
             */
            $sSQL = $sSQL_1 . $condicionE . $sWhereFecE . " UNION " . $sSQL_2 . $condicionE . $sWhereFecE . " UNION " . $sSQL_3 . $condicionE . $sWhereFecE . " UNION " . $sSQL_4 . $condicionE . $sWhereFecE . $sOrder;
            $queryEDetalle = $sSQL . $orderE;
            if ($genTodosDetalle == 1)
                $queryETodosDetalle = $sSQL_1 . $condicionE . $sWhereFec . " UNION " . $sSQL_2 . $condicionE . $sWhereFec . " UNION " . $sSQL_3 . $condicionE . $sWhereFec . " UNION " . $sSQL_4 . $condicionE . $sWhereFec . $sOrder;
        }break;
    case 'oracle':
    case 'oci8':
    case 'oci805':
    case 'oci8po': {
            $sSQL_1 = "select $radi_nume_radi 										AS RAD_ENTRADA, 
					to_char(r.radi_fech_radi,'yyyy/mm/dd hh24:mi:ss') 				AS FEC_RAD_E , 
					substr(cast(a.radi_nume_salida AS VARCHAR(14)),1,14) 				AS RAD_SALIDA,
                                        d2.depe_nomb                                                                    AS DEPE_CONTESTA,
					to_char(a.anex_radi_fech,'yyyy/mm/dd') 				AS FEC_RAD_S,
                                        (case when an.sgd_eanu_codi=1 then 'Solicitado' when an.sgd_eanu_codi=2 then 'Anulado' else '.' end) AS ANULADO,
                                        to_char(g.sgd_renv_fech,'yyyy/mm/dd hh24:mi:ss')				AS FEC_ENVIO,
					t.sgd_tpr_descrip 												AS TIPO, 
					r.ra_asun 														AS ASUNTO, 
					d.depe_nomb 													AS DEP_ACTUAL, 
					b.usua_nomb 													AS USU_ACTUAL, 
					r.radi_usu_ante 												AS USU_ANT, 
					x.sgd_dir_nomremdes 											AS REMITENTE,
					sumadiashabiles(r.radi_fech_radi,t.sgd_tpr_termino) AS FECH_VCMTO,
                                        to_char(diashabilestramite(r.radi_fech_radi,g.sgd_renv_fech)) AS DIAS_TRAM,
                                        (select * from(select y.depe_nomb from hist_eventos z inner join dependencia y on z.depe_codi_dest=y.depe_codi inner join radicado r on z.radi_nume_radi=r.radi_nume_radi where z.sgd_ttr_codigo=9  order by z.hist_fech asc) where rownum=1) AS PRIMERA_DEPENDENCIA
					{$seguridad}
				from radicado r $innerSeries                                        
					inner join anexos a on r.radi_nume_radi = a.anex_radi_nume AND a.radi_nume_salida > 0
					inner join sgd_renv_regenvio g on a.radi_nume_salida=g.radi_nume_sal and a.sgd_dir_tipo=g.sgd_dir_tipo
					inner join sgd_tpr_tpdcumento t on r.tdoc_codi=t.sgd_tpr_codigo
					inner join usuario b on r.radi_usua_actu=b.usua_codi AND r.radi_depe_actu=b.depe_codi
					inner join dependencia d on r.radi_depe_actu = d.depe_codi
					inner join dependencia d2 on cast(substr(cast(a.radi_nume_salida AS VARCHAR(14)),5,3)as integer) = d2.depe_codi
					left join sgd_anu_anulados an on a.radi_nume_salida = an.radi_nume_radi
					inner join sgd_dir_drecciones x on x.radi_nume_radi=r.radi_nume_radi  
				where cast (r.RADI_NUME_RADI as VARCHAR(14)) like '%2'  AND x.sgd_dir_tipo=1
					AND r.codi_nivel <=5";
            $sSQL_2 = "SELECT    	$radi_nume_radi 												AS RAD_ENTRADA, 
					to_char(r.radi_fech_radi,'yyyy/mm/dd hh24:mi:ss')                                                               AS FEC_RAD_E, 
					substr(cast(a.radi_nume_salida AS VARCHAR(14)),1,14)                                                            AS RAD_SALIDA,
                                        d2.depe_nomb                                                                                                    AS DEPE_CONTESTA,
					to_char(a.anex_radi_fech,'yyyy/mm/dd')             							AS FEC_RAD_S, 
					(case when an.sgd_eanu_codi=1 then 'Solicitado' when an.sgd_eanu_codi=2 then 'Anulado' else '.' end)            AS ANULADO,							
                                         ''                                                     							AS FEC_ENVIO,
					t.sgd_tpr_descrip 												AS TIPO, 
					r.ra_asun 														AS ASUNTO, 
					d.depe_nomb 													AS DEP_ACTUAL, 
					b.usua_nomb 													AS USU_ACTUAL, 
					r.radi_usu_ante 												AS USU_ANT, 
					x.sgd_dir_nomremdes                                                                                             AS REMITENTE,
					sumadiashabiles(r.radi_fech_radi,t.sgd_tpr_termino) AS FECH_VCMTO,
                                        'Pendiente' AS DIAS_TRAM, 
					(select * from(select y.depe_nomb from hist_eventos z inner join dependencia y on z.depe_codi_dest=y.depe_codi inner join radicado r on z.radi_nume_radi=r.radi_nume_radi where z.sgd_ttr_codigo=9  order by z.hist_fech asc) where rownum=1) AS PRIMERA_DEPENDENCIA                                        
					{$seguridad}
				FROM 
					radicado r $innerSeries
					inner join anexos a on r.radi_nume_radi = a.anex_radi_nume AND a.radi_nume_salida > 0 and (a.radi_nume_salida,a.sgd_dir_tipo) not in (select g.radi_nume_sal,g.sgd_dir_tipo from sgd_renv_regenvio g)
                                        inner join sgd_tpr_tpdcumento t on r.tdoc_codi=t.sgd_tpr_codigo
                                        inner join usuario b on r.radi_usua_actu=b.usua_codi AND r.radi_depe_actu=b.depe_codi
                                        inner join dependencia d on r.radi_depe_actu = d.depe_codi
                                        inner join dependencia d2 on cast(substr(cast(a.radi_nume_salida AS VARCHAR(14)),5,3)as integer) = d2.depe_codi
                                        left join sgd_anu_anulados an on a.radi_nume_salida = an.radi_nume_radi
					inner join sgd_dir_drecciones x on x.radi_nume_radi=r.radi_nume_radi
                                        where cast (r.RADI_NUME_RADI as VARCHAR(14)) like '%2'  AND x.sgd_dir_tipo=1
					AND r.codi_nivel <=5";
            $sSQL_3 = "
				select $radi_nume_radi                                                                                                  AS RAD_ENTRADA, 
					to_char(r.radi_fech_radi,'yyyy/mm/dd hh24:mi:ss')                                                               AS FEC_RAD_E, 
                                        '0'                                                                                                             AS RAD_SALIDA,
					''                                                                                                              AS DEPE_CONTESTA,
					''                                                                                                              AS FEC_RAD_S, 
					'.'                                                                                                             AS ANULADO,
					''                                                                                                              AS FEC_ENVIO,
					td.sgd_tpr_descrip                                                                                              AS TIPO, 
					r.ra_asun                                                                                                       AS ASUNTO, 
					d.depe_nomb                                                                                                     AS DEP_ACTUAL, 
					b.usua_nomb                                                                                                     AS USU_ACTUAL, 
					r.radi_usu_ante                                                                                                 AS USU_ANT,
					x.sgd_dir_nomremdes                                                                                 AS REMITENTE,
					sumadiashabiles(r.radi_fech_radi,td.sgd_tpr_termino)                                                             AS FECH_VCMTO,
                                        'Pendiente' AS DIAS_TRAM,
					(select * from(select y.depe_nomb from hist_eventos z inner join dependencia y on z.depe_codi_dest=y.depe_codi inner join radicado r on z.radi_nume_radi=r.radi_nume_radi where z.sgd_ttr_codigo=9  order by z.hist_fech asc) where rownum=1) AS PRIMERA_DEPENDENCIA 
					{$seguridad}
				from radicado r $innerSeries
                                        inner join sgd_tpr_tpdcumento td on r.tdoc_codi=td.sgd_tpr_codigo 
					inner join usuario b on r.radi_usua_actu=b.usua_codi AND r.radi_depe_actu=b.depe_codi 
					inner join dependencia d on r.radi_depe_actu = d.depe_codi
					inner join sgd_dir_drecciones x on x.radi_nume_radi=r.radi_nume_radi
                                        WHERE r.codi_nivel <=5 
					AND cast(substr(cast($radi_nume_radi AS VARCHAR(14)),14,1)as integer) = 2 AND r.radi_nume_radi NOT IN (select anex_radi_nume from anexos)  AND x.sgd_dir_tipo=1";
                       $sSQL_4 = "
				select  $radi_nume_radi AS RAD_ENTRADA, 
					to_char(r.radi_fech_radi,'yyyy/mm/dd hh24:mi:ss')                                                               AS FEC_RAD_E,
					'ANEXO SIN RADICAR' AS RAD_SALIDA, 
					'' AS DEPE_CONTESTA,										
					to_char(a.anex_radi_fech,'yyyy/mm/dd')             							AS FEC_RAD_S,
					'.' AS ANULADO,
					''                                                                                                              AS FEC_ENVIO,
					td.sgd_tpr_descrip AS TIPO, 
					r.ra_asun AS ASUNTO, 
					d1.depe_nomb AS DEP_ACTUAL, 
					b.usua_nomb AS USU_ACTUAL, 
					r.radi_usu_ante AS USU_ANT,
					x.sgd_dir_nomremdes AS REMITENTE,                                       
					sumadiashabiles(r.radi_fech_radi,td.sgd_tpr_termino)                                                             AS FECH_VCMTO,
					'Pendiente' AS DIAS_TRAM,                                      
					(select * from(select y.depe_nomb from hist_eventos z inner join dependencia y on z.depe_codi_dest=y.depe_codi inner join radicado r on z.radi_nume_radi=r.radi_nume_radi where z.sgd_ttr_codigo=9  order by z.hist_fech asc) where rownum=1) AS PRIMERA_DEPENDENCIA 					
					{$seguridad}                                              
				from radicado r $innerSeries
					inner join anexos a on r.radi_nume_radi = a.anex_radi_nume AND a.radi_nume_salida is null AND a.anex_borrado = 'N' 
					inner join sgd_tpr_tpdcumento td on r.tdoc_codi=td.sgd_tpr_codigo 
					inner join usuario b on r.radi_usua_actu=b.usua_codi AND r.radi_depe_actu=b.depe_codi 
					inner join dependencia d1 on b.depe_codi=d1.depe_codi
					inner join sgd_dir_drecciones x on x.radi_nume_radi=r.radi_nume_radi                                    
				where   cast (r.RADI_NUME_RADI as VARCHAR(14)) like '%2'  AND x.sgd_dir_tipo=1 AND r.codi_nivel <=5 ";
				
            $queryE = "
				SELECT substr(to_char(r.radi_fech_radi,'yyyy/mm/dd hh24:mi:ss'),1,10 ) FECH_RADI, 
					count(r.RADI_NUME_RADI) RADICADOS, 
					MIN(radi_fech_radi) HID_FECH_SELEC
				from radicado r $innerSeries
				WHERE r.radi_nume_radi LIKE '%2'
				$condicionE $sWhereFec $resolucion
			GROUP BY substr(to_char(r.radi_fech_radi,'yyyy/mm/dd hh24:mi:ss'),1,10 ) 
			ORDER BY $orno $ascdesc";
           
            
            //-------------------------------
            // Assemble full SQL statement
            //-------------------------------

            $sWhereFecE = " $condicionE AND substr(cast(r.radi_fech_radi AS VARCHAR(14)),1,10) = to_date('" . $fecSel . "', 'yyyy/mm/dd HH24:MI:ss')";

            $sWhereC = $sWhereFecE;
            $sSQL = $sSQL_1 . $sWhereC . $sWhereFec . $resolucion . " UNION " . $sSQL_2 . $sWhereC . $sWhereFec . $resolucion . " UNION " . $sSQL_3 . $sWhereC . $sWhereFec . $resolucion . $sOrder;
            /** CONSULTA PARA VER DETALLES 
             */
           $sSQL = $sSQL_1 . $condicionE . $sWhereFecE . " UNION " . $sSQL_2 . $condicionE . $sWhereFecE . " UNION " . $sSQL_3 . $condicionE . $sWhereFecE . " UNION " . $sSQL_4 . $condicionE . $sWhereFecE . $sOrder;
            $queryEDetalle = $sSQL . $orderE;            
            if ($genTodosDetalle == 1)
                $queryETodosDetalle = $sSQL_1 . $condicionE . $sWhereFec . " UNION " . $sSQL_2 . $condicionE . $sWhereFec . " UNION " . $sSQL_3 . $condicionE . $sWhereFec . " UNION " . $sSQL_4 . $condicionE . $sWhereFec . $sOrder;           
        }break;
}

if ((isset($_GET['genDetalle']) && $_GET['denDetalle'] = 1) ||
        (isset($_GET['genTodosDetalle']) && $_GET['genTodosDetalle'] = 1)
) {
    $titulos = array("#", "1#RADICADO DE ENTRADA", "2#FECHA RADICACI&Oacute;N DE ENTRADA", "3#RADICACI&Oacute;N DE SALIDA", "4#DEPENDENCIA QUE CONTESTA", "5#FECHA DE RADICACI&Oacute;N DE SALIDA", "6#ESTADO ANULACI&Oacute;N", "7#FECHA ENTREGA DESTINATARIO", "8#TIPO", "9#ASUNTO", "10#DEPENDENCIA ACTUAL", "11#USUARIO ACTUAL", "12#USUARIO ANTERIOR", "13#REMITENTE", "14#FECHA VENCIMIENTO", "15#D&Iacute;AS TRAMITE", "16#PRIMERA DEPENDENCIA");
} else {
    $titulos = array("#", "1#FECHA DE RADICACI&Oacute;N", "2#RADICADOS");
}

function pintarEstadistica($fila, $indice, $numColumna) {
    global $ruta_raiz, $_POST, $_GET, $krd;
    $salida = "";
    switch ($numColumna) {
        case 0:
            $salida = $indice;
            break;
        case 1:
            $salida = $fila['FECH_RADI'];
            break;
        case 2:
            $datosEnvioDetalle = "tipoEstadistica=" . $_POST['tipoEstadistica'] . "&amp;genDetalle=1&amp;usua_doc=" . urlencode($fila['HID_USUA_DOC']) . "&amp;dependencia_busq=" . $_POST['dependencia_busq'] . "&amp;fecha_ini=" . $_POST['fecha_ini'] . "&amp;fecha_fin=" . $_POST['fecha_fin'] . "&amp;tipoRadicado=" . $_POST['tipoRadicado'] . "&amp;tipoDocumento=" . $_POST['tipoDocumento'] . "&amp;codUs=" . $fila['HID_COD_USUARIO'] . "&amp;fecSel=" . $fila['HID_FECH_SELEC'] . "&amp;resol=" . $_POST['resol'] . "&amp;idSerie=" . $_POST['idSerie'];
            $datosEnvioDetalle = (isset($_POST['usActivos'])) ? $datosEnvioDetalle . "&amp;usActivos=" . $_POST['usActivos'] : $datosEnvioDetalle;
            $salida = "<a href=\"genEstadistica.php?{$datosEnvioDetalle}&amp;krd={$krd}\"  target=\"detallesSec\" >" . $fila['RADICADOS'] . "</a>";
            break;
    }
    return $salida;
}

function pintarEstadisticaDetalle($fila, $indice, $numColumna) {
    global $ruta_raiz, $encabezado, $krd;
    $verImg = ($fila['SGD_SPUB_CODIGO'] == 1) ? ($fila['USUARIO'] != $_SESSION['usua_nomb'] ? false : true) : ($fila['USUA_NIVEL'] > $_SESSION['nivelus'] ? false : true);
    $numRadicado = $fila['RAD_ENTRADA'];
    switch ($numColumna) {
        case 0:
            $salida = $indice;
            break;
        case 1:
            $salida = "<center class=\"leidos\">{$numRadicado}</center>";
            break;
        case 2:
            if ($verImg) {
                $salida = "<center><a class=\"vinculos\" href=\"{$ruta_raiz}verradicado.php?verrad=" . $numRadicado . "&amp;" . session_name() . "=" . session_id() . "&amp;krd=" . $_GET['krd'] . "&amp;carpeta=8&amp;nomcarpeta=Busquedas&amp;tipo_carp=0 \" >" . $fila['FEC_RAD_E'] . "</a></center>";
            } else {
                $test = str_replace("/", "-", $fila['FEC_RAD_E']);
                $salida = "<center><a class=\"vinculos\" href=\"#\" onclick=\"alert('ud no tiene permisos para ver el radicado');\"> " . $fila['FEC_RAD_E'] . " </a></center>";
            }
            //$salida="<center><a class=\"vinculos\" href=\"#\" onclick=\"alert('ud no tiene permisos para ver el radicado');\">2011/11/16</a></center>";.$fila['FEC_RADI_E'].
            //$salida="<a class=\"vinculos\" href=\"#\" onclick=\"alert(\"ud no tiene permisos para ver el radicado\");\">".$fila['FEC_RADI_E']."</a>";2011/11/16
            break;
        case 3:
            $salida = "<center class=\"leidos\">" . $fila['RAD_SALIDA'] . "</center>";
            break;
        case 4:
            $salida = "<center class=\"leidos\">" . $fila['DEPE_CONTESTA'] . "</center>";
            break;
        case 5:
            $salida = "<center class=\"leidos\">" . $fila['FEC_RAD_S'] . "</center>";
            break;
        case 6:
            $salida = "<center class=\"leidos\">" . $fila['ANULADO'] . "</center>";
            break;
        case 7:
            $salida = "<center class=\"leidos\">" . $fila['FEC_ENVIO'] . "</center>";
            break;
        case 8:
            $salida = "<center class=\"leidos\">" . $fila['TIPO'] . "</center>";
            break;
        case 9:
            $salida = "<center class=\"leidos\">" . $fila['ASUNTO'] . "</center>";
            break;
        case 10:
            $salida = "<center class=\"leidos\">" . $fila['DEP_ACTUAL'] . "</center>";
            break;
        case 11:
            $salida = "<center class=\"leidos\">" . $fila['USU_ACTUAL'] . "</center>";
            break;
        case 12:
            $salida = "<center class=\"leidos\">" . $fila['USU_ANT'] . "</center>";
            break;
        case 13:
            $salida = "<center class=\"leidos\">" . $fila['REMITENTE'] . "</center>";
            break;
        case 14:
            $salida = "<center class=\"leidos\">" . $fila['FECH_VCMTO'] . "</center>";
            break;
        case 15:
            $salida = "<center class=\"leidos\">" . $fila['DIAS_TRAM'] . "</center>";
            break;
        case 16:
            $salida = "<center class=\"leidos\">" . $fila['PRIMERA_DEPENDENCIA'] . "</center>";
            break; 
    }
    return $salida;
}

?>