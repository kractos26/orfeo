<?php
/** CONSUTLA 001 
	* Estadiscas por medio de recepcion Entrada
	* @autor JAIRO H LOSADA - SSPD
	* @version ORFEO 3.1
	* 
	*/
$coltp3Esp = '"'.$tip3Nombre[3][2].'"';
if(!$orno) $orno=2;
$tmp_substr = $db->conn->substr;
 /**
   * $db-driver Variable que trae el driver seleccionado en la conexion
   * @var string
   * @access public
   */
 /**
   * $fecha_ini Variable que trae la fecha de Inicio Seleccionada  viene en formato Y-m-d
   * @var string
   * @access public
   */
/**
   * $fecha_fin Variable que trae la fecha de Fin Seleccionada
   * @var string
   * @access public
   */
/**
   * $mrecCodi Variable que trae el medio de recepcion por el cual va a sacar el detalle de la Consulta.
   * @var string
   * @access public
   */
$_POST['resol']? $resolucion=" and r.sgd_tres_codigo = ".$_POST['resol']." ":0;
$_GET['resol']? $resolucion=" and r.sgd_tres_codigo = ".$_GET['resol']." ":0;
$desde = $fecha_ini . " " . "00:00:00";
$hasta = $fecha_fin . " " . "23:59:59";

$sWhereFec = "" . $db->conn->SQLDate('Y/m/d H:i:s', 'R.RADI_FECH_RADI') . " >= '$desde'
				and " . $db->conn->SQLDate('Y/m/d H:i:s', 'R.RADI_FECH_RADI') . " <= '$hasta'";
switch($db->driver)
{
	case 'mssql':
	case 'postgresql':	
	case 'postgres':	
	{	if($tipoDocumento=='9999')
		{	$queryE = "SELECT b.USUA_NOMB as USUARIO, count(*) as RADICADOS, 'Todos' as TIPO_DOCUMENTO,b.usua_doc as  HID_USUA_DOC, MIN(USUA_CODI) as HID_COD_USUARIO, MIN(depe_codi) as HID_DEPE_USUA
					FROM RADICADO r 
						INNER JOIN USUARIO b ON r.radi_usua_radi=b.usua_CODI AND cast($tmp_substr(cast($radi_nume_radi AS VARCHAR),5,3) as integer)=b.depe_codi
					WHERE ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini' AND '$fecha_fin' 
						$whereDependencia $whereActivos $whereTipoRadicado 
					GROUP BY b.USUA_NOMB,b.usua_doc ORDER BY $orno $ascdesc";
		}
		else
		{	$queryE = "SELECT b.USUA_NOMB as USUARIO, count(*) as RADICADOS, t.SGD_TPR_DESCRIP as TIPO_DOCUMENTO, b.usua_doc as  HID_USUA_DOC,
						MIN(USUA_CODI) as HID_COD_USUARIO, MIN(SGD_TPR_CODIGO) as HID_TPR_CODIGO, MIN(depe_codi) as HID_DEPE_USUA, r.TDOC_CODI as TIPDOC
					FROM RADICADO r 
						INNER JOIN USUARIO b ON r.RADI_USUA_RADI = b.USUA_CODI AND cast($tmp_substr(cast($radi_nume_radi AS VARCHAR), 5, 3) as integer)= b.DEPE_CODI
						LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.TDOC_CODI = t.SGD_TPR_CODIGO
					WHERE ".$db->conn->SQLDate('Y/m/d h:i:s', 'r.radi_fech_radi')." BETWEEN '$fecha_ini' AND '$fecha_fin' 
						$whereDependencia $whereActivos $whereTipoRadicado 
					GROUP BY b.USUA_NOMB,t.SGD_TPR_DESCRIP,b.usua_doc,r.TDOC_CODI ORDER BY $orno $ascdesc";
		}
 		/** CONSULTA PARA VER DETALLES 
	 	*/
		//$condicionDep = " AND depe_codi = $depeUs ";
		$condicionDep = ($dependencia_busq==99999) ? " AND b.depe_codi is not null " : "AND b.depe_codi = $dependencia_busq ";
		if($_GET['usua_doc'])$whereTipoRadicado.=" AND b.USUA_DOC ='". $_GET['usua_doc'] ."'";
		if($_GET['TIPDOC'] || $_GET['TIPDOC']==='0')$whereTipoRadicado.=" AND t.SGD_TPR_CODIGO =". $_GET['TIPDOC'] ;
		//$condicionDep = " AND depe_codi = $dependencia_busq ";
		$condicionE = " AND b.USUA_CODI=$codUs $condicionDep ";
		$queryEDetalle = "SELECT $radi_nume_radi as RADICADO
					,".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." AS FECHA_RADICADO
					,t.SGD_TPR_DESCRIP as TIPO_DE_DOCUMENTO
					,r.RA_ASUN as ASUNTO 
					,r.RADI_DESC_ANEX as ANEXOS
					,r.RADI_NUME_HOJA as N_HOJAS
					,m.MREC_DESC as MEDIO_RECEPCION
					,b.usua_nomb as USUARIO
					,r.RADI_PATH as HID_RADI_PATH {$seguridad}
					, dir.SGD_DIR_NOMREMDES as REMITENTE
                    ,d.depe_nomb as DEP_ASIG
                    ,$tmp_substr(cast (dir.sgd_dir_tipo as VARCHAR),2,2) as COPIA
                    ,ser.PAR_SERV_NOMBRE           as SECTOR
				FROM RADICADO r
					INNER JOIN USUARIO b ON r.radi_usua_radi=b.usua_CODI AND cast($tmp_substr(cast($radi_nume_radi AS VARCHAR),5,3) as integer)=b.depe_codi
					LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.tdoc_codi=t.SGD_TPR_CODIGO 
					LEFT OUTER JOIN MEDIO_RECEPCION m ON r.MREC_CODI = m.MREC_CODI
                    INNER JOIN DEPENDENCIA d ON r.RADI_DEPE_RADI= d.depe_codi
				 	LEFT OUTER JOIN SGD_DIR_DRECCIONES dir ON r.radi_nume_radi = dir.radi_nume_radi and dir.sgd_dir_tipo=1
                    LEFT JOIN PAR_SERV_SERVICIOS ser ON ser.PAR_SERV_SECUE=r.PAR_SERV_SECUE
				WHERE ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini' AND '$fecha_fin' $whereTipoRadicado ";
					$orderE = "	ORDER BY $orno $ascdesc";
			 /** CONSULTA PARA VER TODOS LOS DETALLES 
			 */ 
					
			$queryETodosDetalle = $queryEDetalle . $condicionDep . $orderE;
			$queryEDetalle .= $condicionE . $orderE;
	}break;
	case 'oracle':
	case 'oci8':
	case 'oci805':
	case 'ocipo':
        case 'oci8po':
	{
		if($tipoDocumento=='9999')
		{
			$queryE = "SELECT b.USUA_NOMB as USUARIO,  count(*) as RADICADOS,'Todos' as TIPO_DOCUMENTO, b.usua_doc as  HID_USUA_DOC, MIN(USUA_CODI) as HID_COD_USUARIO, MIN(depe_codi) as HID_DEPE_USUA
					FROM RADICADO r 
						INNER JOIN USUARIO b ON r.radi_usua_radi=b.usua_CODI AND cast($tmp_substr(cast ($radi_nume_radi AS VARCHAR(14)),5,3)AS VARCHAR(3))=b.depe_codi 
					WHERE  $sWhereFec 
						$whereDependencia $whereActivos $whereTipoRadicado $resolucion
					GROUP BY b.USUA_NOMB,b.usua_doc ORDER BY $orno $ascdesc";
		}
		else
		{
			$queryE = "SELECT b.USUA_NOMB as USUARIO, b.usua_doc as HID_USUA_DOC,t.SGD_TPR_DESCRIP as TIPO_DOCUMENTO, count(*) as RADICADOS,
						MIN(USUA_CODI) as HID_COD_USUARIO, MIN(SGD_TPR_CODIGO) as HID_TPR_CODIGO, MIN(depe_codi) as HID_DEPE_USUA,r.TDOC_CODI as TIPDOC
					FROM RADICADO r 
						INNER JOIN USUARIO b ON r.RADI_USUA_RADI = b.USUA_CODI AND cast($tmp_substr(cast($radi_nume_radi AS VARCHAR(14)), 5, 3)AS VARCHAR(3)) = b.DEPE_CODI 
						LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.TDOC_CODI = t.SGD_TPR_CODIGO
					WHERE   $sWhereFec 
						$whereDependencia $whereActivos $whereTipoRadicado $resolucion
					GROUP BY b.USUA_NOMB,t.SGD_TPR_DESCRIP,b.usua_doc,r.TDOC_CODI ORDER BY $orno $ascdesc";
		}
 		/** CONSULTA PARA VER DETALLES 
	 	*/
		//$condicionDep = " AND depe_codi = $depeUs ";
		$condicionDep = ($dependencia_busq==99999) ? " AND b.depe_codi is not null " : "AND b.depe_codi = $dependencia_busq ";
		if($_GET['usua_doc'])$whereTipoRadicado.=" AND b.USUA_DOC = '".$_GET['usua_doc']."' " ;
		if($_GET['TIPDOC'] || $_GET['TIPDOC']==='0')$whereTipoRadicado.=" AND t.SGD_TPR_CODIGO =". $_GET['TIPDOC'] ;
		//$condicionDep = " AND depe_codi = $dependencia_busq ";
		$condicionE = " AND b.USUA_CODI=$codUs $condicionDep ";
		$queryEDetalle = "SELECT $radi_nume_radi as RADICADOJ
					,".$db->conn->SQLDate('Y-m-d h:i:s','r.RADI_FECH_RADI')." AS FECHA_RADICADO
					,t.SGD_TPR_DESCRIP as TIPO_DE_DOCUMENTO
					,r.RA_ASUN as ASUNTO 
					,r.RADI_DESC_ANEX as ANEXOS
					,r.RADI_NUME_HOJA as N_HOJAS
					,m.MREC_DESC as MEDIO_RECEPCION
					,b.usua_nomb as USUARIO
					,r.RADI_PATH as HID_RADI_PATH {$seguridad}
                                        ,d.depe_nomb as DEP_ASIG
					, dir.SGD_DIR_NOMREMDES as REMITENTE
                                        ,$tmp_substr(cast(dir.sgd_dir_tipo as VARCHAR(2)),2,2) as COPIA
                                        ,tres.SGD_TRES_DESCRIP as DIRIGIDO_A,
                                        (select P.PAR_SERV_NOMBRE from PAR_SERV_SERVICIOS P where p.par_serv_secue = r.par_serv_secue) as SECTOR
				        FROM RADICADO r
			INNER JOIN USUARIO b ON r.radi_usua_radi=b.usua_CODI AND cast($tmp_substr(cast($radi_nume_radi AS VARCHAR(14)),5,3)AS VARCHAR(3))=b.depe_codi 
					LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.tdoc_codi=t.SGD_TPR_CODIGO 
					LEFT OUTER JOIN MEDIO_RECEPCION m ON r.MREC_CODI = m.MREC_CODI
                    INNER JOIN DEPENDENCIA d ON r.RADI_DEPE_RADI= d.depe_codi
				 	LEFT OUTER JOIN SGD_DIR_DRECCIONES dir ON r.radi_nume_radi = dir.radi_nume_radi
                    LEFT JOIN SGD_TRES_TPRESOLUCION tres ON tres.SGD_TRES_CODIGO=r.SGD_TRES_CODIGO
				WHERE  $sWhereFec $whereTipoRadicado $resolucion";
					$orderE = "	ORDER BY $orno $ascdesc";
			 /** CONSULTA PARA VER TODOS LOS DETALLES 
			 */ 
		
			$queryETodosDetalle = $queryEDetalle . $condicionDep.$resolucion. $orderE;
			$queryEDetalle .= $condicionE . $orderE;
			


		
	}break;
}

if(isset($_GET['genDetalle'])&& $_GET['genDetalle']==1 || isset($_GET['genTodosDetalle'])&& $_GET['genTodosDetalle']==1)
	$titulos=array("#","1#RADICADO","2#FECHA RADICADO","3#TIPO DOCUMENTO","4#ASUNTO","5#ANEXOS","6#NO HOJAS","7#MEDIO  DE RECEPCI&Oacute;N","8#USUARIO","9#REMITENTE","10#_COPIA_ ","11#PRIMER DEPENDENCIA_ASIGNADA","12#SECTOR");
else 		
	$titulos=array("#","1#Usuario","2#Radicados","3#Tipo de Documento");
		
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
        	$salida=$fila['USUARIO'];
        	break;
        case 2:
        	$datosEnvioDetalle="tipoEstadistica=".$_POST['tipoEstadistica']."&amp;genDetalle=1&amp;usua_doc=".urlencode($fila['HID_USUA_DOC'])."&amp;dependencia_busq=".$_POST['dependencia_busq']."&amp;fecha_ini=".$_POST['fecha_ini']."&amp;fecha_fin=".$_POST['fecha_fin']."&amp;tipoRadicado=".$_POST['tipoRadicado']."&amp;tipoDocumento=".$_POST['tipoDocumento']."&TIPDOC=".$fila['TIPDOC']."&amp;codUs=".$fila['HID_COD_USUARIO']."&amp;resol=".$_POST['resol'];
	    	$datosEnvioDetalle=(isset($_POST['usActivos']))?$datosEnvioDetalle."&amp;usActivos=".$_POST['usActivos']:$datosEnvioDetalle;
	    	$salida="<a href=\"genEstadistica.php?{$datosEnvioDetalle}&amp;krd={$krd}\"  target=\"detallesSec\" >".$fila['RADICADOS']."</a>";
        	break;
         case 3:
        	$salida=$fila['TIPO_DOCUMENTO'];
        	break;
        default: $salida=false;
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
				$salida="<a class=\"vinculos\" href=\"{$ruta_raiz}verradicado.php?verrad=".$fila['RADICADO']."&amp;".session_name()."=".session_id()."&amp;krd=".$_GET['krd']."&amp;carpeta=8&amp;nomcarpeta=Busquedas&amp;tipo_carp=0 \" >".$fila['FECHA_RADICADO']."</a>";
			else
				$salida="<center><a class=\"vinculos\" href=\"#\" onclick=\"alert('ud no tiene permisos para ver el radicado');\"> ".$fila['FECHA_RADICADO']." </a></center>"; 
				//$salida="<a class=\"vinculos\" href=\"#\" onclick=\"alert(\"ud no tiene permisos para ver el radicado\");\">".$fila['FECHA_RADICADO']."</a>";
			break;
		case 3:
			$salida="<center class=\"leidos\">".$fila['TIPO_DE_DOCUMENTO']."</center>";		
			break;
		case 4:
			$salida="<center class=\"leidos\">".$fila['ASUNTO']."</center>";
			break;
		case 5:
			$salida="<center class=\"leidos\">".$fila['ANEXOS']."</center>";
			break;
		case 6:
			$salida="<center class=\"leidos\">".$fila['N_HOJAS']."</center>";			
			break;	
		case 7:
			$salida="<center class=\"leidos\">".$fila['MEDIO_RECEPCION']."</center>";			
			break;	
		case 8:
			$salida="<center class=\"leidos\">".$fila['USUARIO']."</center>";			
			break;	
		case 9:
			$salida="<center class=\"leidos\">".$fila['REMITENTE']."</center>";
			break;	
		case 10:
			$salida="<center class=\"leidos\">".$fila['COPIA']."</center>";
			break;
		case 11:
			$salida="<center class=\"leidos\">".$fila['DEP_ASIG']."</center>";
			break;
                case 12:
			$salida="<center class=\"leidos\">".$fila['SECTOR']."</center>";
			break;
	}
	return $salida;
}
?>
