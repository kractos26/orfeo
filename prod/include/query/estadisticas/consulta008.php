<?
/** REPORTE DE VENCIMIENTOS
*
*/
$coltp3Esp = '"'.$tip3Nombre[3][2].'"';	
if(!$orno) $orno=1;
$orderE = "	ORDER BY $orno $ascdesc ";
$tmp_substr = $db->conn->substr;
$desde = $fecha_ini . " ". "00:00:00";
$hasta = $fecha_fin . " ". "23:59:59";

switch($db->driver)
{
    case 'oracle':
    case 'oci8':
    case 'oci805':
    case 'oci8po':
//	$fecVenc=" (r.radi_fech_radi + cast ((td.sgd_tpr_termino * 7/5)+(select count(*) from sgd_noh_nohabiles where NOH_FECHA between r.radi_fech_radi and r.radi_fech_radi + cast (td.sgd_tpr_termino * 7/5 ||' days' as interval)) || ' days' as interval))";
//        break;
    case 'postgres':
	$fecVenc=" (sumadiashabiles(cast(r.radi_fech_radi as date),td.sgd_tpr_termino)) ";
        break;
}

$sWhereFec =  " and ".$db->conn->SQLDate('Y/m/d', $fecVenc)." >= '$desde'
				and ".$db->conn->SQLDate('Y/m/d', $fecVenc)." <= '$hasta'";

if ( $dependencia_busq != 99999 && $dependencia_busq != 99998)	$condicionE = "	AND r.RADI_DEPE_ACTU=$dependencia_busq ";
else if ($dependencia_busq == 99999)
{
        
	$sel1 = " d.depe_nomb AS DEPE_NOMB, d.DEPE_CODI AS HID_DEPE_CODI, ";
	$group= " d.depe_nomb, d.depe_codi,";
}
if($depVen){$condicionE = "	AND r.RADI_DEPE_ACTU=$depVen ";}
if($chkDP)$condicionE .=" and r.sgd_id_dpeticion=1 ";
//echo $radi_nume_radi;

$sWhere = " where r.radi_nume_radi not in (select anex_radi_nume from anexos where anex_estado > 2) 
			AND r.radi_nume_radi not in 
				(select r.radi_nume_radi from hist_eventos r 
				where upper($tmp_substr(hist_obse,1,3)) = 'NRR'
					OR upper($tmp_substr(hist_obse,1,3)) = 'RSA'
					OR upper($tmp_substr(hist_obse,1,2)) = 'CE'
					OR upper($tmp_substr(hist_obse,1,3)) = 'TRA')
			AND cast(r.radi_nume_radi as VARCHAR(14)) like '%2' 
			AND r.tdoc_codi = td.sgd_tpr_codigo
			AND r.radi_usua_actu=b.usua_codi 
			AND r.radi_depe_actu=b.depe_codi
			AND b.depe_codi= d.depe_codi $condicionE";

$sSQL = "SELECT r.radi_nume_radi AS radicado, 
			".$db->conn->SQLDate('Y/m/d H:i:s', 'r.radi_fech_radi')." AS fech_radi, 
			td.sgd_tpr_descrip AS tipo, 
			td.sgd_termino_real AS termino,
			r.ra_asun AS asunto, 
			d.depe_nomb AS depe_actu, 
			b.usua_nomb AS nomb_actu, 
			r.radi_usu_ante AS usant,"
                        .$db->conn->SQLDate('Y/m/d', $fecVenc)." as fech_vcmto,
			r.RADI_PATH AS HID_RADI_PATH{$seguridad}
                        FROM radicado r, sgd_tpr_tpdcumento td, usuario b, dependencia d ";//r.fech_vcmto AS fech_vcmto,

$queryE = "SELECT $sel1 ".$db->conn->SQLDate('Y/m/d', $fecVenc)." as fech_vcmto,
                	count(r.radi_nume_radi) AS SUM_RADICADOS
			from radicado r, sgd_tpr_tpdcumento td, usuario b, dependencia d
                        $sWhere $sWhereFec GROUP BY $group ".$db->conn->SQLDate('Y/m/d', $fecVenc)." ORDER BY  $orno $ascdesc";
                        //$sWhere $sWhereFec GROUP BY $group ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." ORDER BY  $orno $ascdesc";
                        //"SELECT distinct ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." AS fech_radi,
			//.$db->conn->SQLDate('Y/m/d', $fecVenc)." AS HID_FECH_SELEC
	
//if (!is_null($fecSel)) $sWhereFecE = " AND ".$db->conn->SQLDate('Y/m/d',$fecVenc)." = '$fecSel'";
if (isset($_GET['FechSel'])) $sWhereFecE = " AND ".$db->conn->SQLDate('Y/m/d', $fecVenc)." = '".$_GET['FechSel']."'";

// CONSULTA PARA VER DETALLES 
$queryEDetalle = $sSQL . $sWhere . $sWhereFecE . $orderE;	

// CONSULTA PARA VER TODOS LOS DETALLES 
$queryETodosDetalle = $sSQL . $sWhere . $sWhereFec . $orderE;	

	
if((isset($_GET['genDetalle'])&& $_GET['genDetalle']=1) || (isset($_GET['genTodosDetalle'])) )
{
		$titulos=array("#","1#RADICADO","2#FECHA RADICACI&Oacute;N","3#TIPO","4#FECHA DE VENCIMIENTO","5#ASUNTO","6#DEPENDENCIA ACTUAL","7#USUARIO ACTUAL","8#USUARIO ANTERIOR");
}
else
{ 	
	if ($dependencia_busq != 99999)	
		$titulos=array("#","1#FECHA DE VENCIMIENTO","2#RADICADOS");
                //$titulos=array("#","1#FECHA DE RADICACION","2#RADICADOS");
	else 
		$titulos=array("#","1#DEPENDENCIA","2#FECHA DE VENCIMIENTO","3#RADICADOS");
                //$titulos=array("#","1#DEPENDENCIA","2#FECHA DE RADICACION","3#RADICADOS");
}
		
function pintarEstadistica($fila,$indice,$numColumna)
{
        global $ruta_raiz,$_POST,$_GET,$krd;
        $salida="";
        switch ($numColumna)
        {
            case  0:
                    $salida=$indice;
                    break;
            case 1:
                    if ($fila['DEPE_NOMB'])$salida=$fila['DEPE_NOMB'];
                    else$salida=$fila['FECH_VCMTO'];
                    //else$salida=$fila['FECH_RADI'];
            break;
            case 2:
                    if ($fila['DEPE_NOMB'])$salida=$fila['FECH_VCMTO'];
                    //if ($fila['DEPE_NOMB'])$salida=$fila['FECH_RADI'];
                    else
                    {       
                            $datosEnvioDetalle="tipoEstadistica=".$_POST['tipoEstadistica']."&amp;genDetalle=1&amp;usua_doc=".urlencode($fila['HID_USUA_DOC'])."&amp;dependencia_busq=".$_POST['dependencia_busq']."&amp;fecha_ini=".$_POST['fecha_ini']."&amp;fecha_fin=".$_POST['fecha_fin']."&amp;tipoRadicado=".$_POST['tipoRadicado']."&amp;tipoDocumento=".$_POST['tipoDocumento']."&amp;codUs=".$fila['HID_COD_USUARIO']."&amp;fecSel=".$fila['HID_FECH_SELEC']."&depVen=".$fila['HID_DEPE_CODI']."&FechSel=".$fila['FECH_VCMTO'];
                            $datosEnvioDetalle=(isset($_POST['usActivos']))?$datosEnvioDetalle."&amp;usActivos=".$_POST['usActivos']:$datosEnvioDetalle;
                            $salida="<center><a href=\"genEstadistica.php?{$datosEnvioDetalle}&amp;krd={$krd}\"  target=\"detallesSec\" >".$fila['SUM_RADICADOS']."</a></center>";
                    }
                    break;
            case 3:
                    $datosEnvioDetalle="tipoEstadistica=".$_POST['tipoEstadistica']."&amp;genDetalle=1&amp;usua_doc=".urlencode($fila['HID_USUA_DOC'])."&amp;dependencia_busq=".$_POST['dependencia_busq']."&amp;fecha_ini=".$_POST['fecha_ini']."&amp;fecha_fin=".$_POST['fecha_fin']."&amp;tipoRadicado=".$_POST['tipoRadicado']."&amp;tipoDocumento=".$_POST['tipoDocumento']."&amp;codUs=".$fila['HID_COD_USUARIO']."&amp;FechSel=".$fila['FECH_VCMTO']."&depVen=".$fila['HID_DEPE_CODI'];
                    $datosEnvioDetalle=(isset($_POST['usActivos']))?$datosEnvioDetalle."&amp;usActivos=".$_POST['usActivos']:$datosEnvioDetalle;
                    $salida="<center><a href=\"genEstadistica.php?{$datosEnvioDetalle}&amp;krd={$krd}\"  target=\"detallesSec\" >".$fila['SUM_RADICADOS']."</a></center>";
            break;
        }
        return $salida;
}
function pintarEstadisticaDetalle($fila,$indice,$numColumna)
{
        global $ruta_raiz,$encabezado,$krd;
        $verImg=($fila['SGD_SPUB_CODIGO']==1)?($fila['USUARIO']!=$_SESSION['usua_nomb']?false:true):($fila['USUA_NIVEL']>$_SESSION['nivelus']?false:true);
        $numRadicado=$fila['RADICADO'];
        switch ($numColumna)
        {
            case 0:
                    $salida=$indice;
                    break;
            case 1:
                    if($fila['HID_RADI_PATH'] && $verImg)
                            $salida="<center><a href=\"{$ruta_raiz}/seguridadImagen.php?fec=".base64_encode($fila['HID_RADI_PATH'])."\">".$fila['RADICADO']."</a></center>";
                    else
                            $salida="<center class=\"leidos\">{$numRadicado}</center>";
                    break;
            case 2:
                    if($verImg)
                            $salida="<a class=\"vinculos\" href=\"{$ruta_raiz}verradicado.php?verrad=".$fila['RADICADO']."&amp;".session_name()."=".session_id()."&amp;krd=".$_GET['krd']."&amp;carpeta=8&amp;nomcarpeta=Busquedas&amp;tipo_carp=0 \" >".$fila['FECH_RADI']."</a>";
                    else
                            $salida="<a class=\"vinculos\" href=\"#\" onclick=\"alert('ud no tiene permisos para ver el radicado')\">".$fila['FECH_RADI']."</a>";
                            //$salida="<a class=\"vinculos\" href=\"#\" onclick=\"alert('ud no tiene permisos para ver el radicado');\">".$fila['FECHA_RADICACION']."</a>";
                    break;
            case 3:
                    $salida="<center class=\"leidos\">".$fila['TIPO']."</center>";
                    break;
            case 4:
                    $salida="<center class=\"leidos\">".$fila['FECH_VCMTO']."</center>";
                    break;
            case 5:
                    $salida="<center class=\"leidos\">".$fila['ASUNTO']."</center>";
                    break;
            case 6:
                    $salida="<center class=\"leidos\">".$fila['DEPE_ACTU']."</center>";
                    break;
            case 7:
                    $salida="<center class=\"leidos\">".$fila['NOMB_ACTU']."</center>";
                    break;
            case 8:
                    $salida="<center class=\"leidos\">".$fila['USANT']."</center>";
                    break;
            case 9:
                    $salida="<center class=\"leidos\">".$fila['FECH_VCMTO']."</center>";
                    break;
        }
        return $salida;
}
?>
