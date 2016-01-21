<?
/** CONSUTLA 004
	* Estadiscas de Numero de Radicados digitalizados y Hojas Digitalizadas.
	* @autor JAIRO H LOSADA - SSPD
	* @version ORFEO 3.1
	* 
	*/
$coltp3Esp = '"'.$tip3Nombre[3][2].'"';	
if(!$orno) $orno=2;
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
switch($db->driver)
{	case 'mssql':
	case 'postgres':
		{	if ( $dependencia_busq != 99999)
			{	$condicionE = "	AND h.DEPE_CODI=$dependencia_busq AND b.depe_codi = $dependencia_busq";	}
			$queryE = "
	    	SELECT b.USUA_NOMB AS USUARIO
                , count(*) AS RADICADOS
				, b.usua_doc AS HID_USUA_DOC
				, SUM(r.RADI_NUME_HOJA) AS HOJAS_DIGITALIZADAS						
				, MIN(b.USUA_CODI) AS HID_COD_USUARIO
			FROM RADICADO r, USUARIO b, HIST_EVENTOS h
			WHERE 
				h.USUA_CODI=b.usua_CODI 
				AND b.depe_codi = h.depe_codi
				$condicionE
				AND h.RADI_NUME_RADI=r.RADI_NUME_RADI
				AND h.SGD_TTR_CODIGO IN(22,42)
				AND ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini'  AND '$fecha_fin' 
				$whereTipoRadicado 
			GROUP BY b.USUA_NOMB,b.usua_doc
			ORDER BY $orno $ascdesc";
 			/** CONSULTA PARA VER DETALLES 
	 		*/

			if($_GET['usua_doc'])$whereTipoRadicado.=" AND b.USUA_DOC ='". $_GET['usua_doc']."'" ;
			$queryEDetalle = "SELECT 
				$radi_nume_radi AS RADICADO
				, b.USUA_NOMB AS USUARIO_DIGITALIZADOR
				, h.HIST_OBSE AS OBSERVACIONES, ".
				$db->conn->SQLDate('Y/m/d H:i:s','r.radi_fech_radi')." AS FECHA_RADICACION, ".
				$db->conn->SQLDate('Y/m/d H:i:s','h.HIST_FECH')." AS FECHA_DIGITALIZACION
				, mr.mrec_desc AS MEDIO_RECEPCION
				,r.RADI_PATH AS HID_RADI_PATH{$seguridad}
				FROM RADICADO r 
            inner join  HIST_EVENTOS h on h.RADI_NUME_RADI=r.RADI_NUME_RADI
            inner join USUARIO b on h.USUA_CODI=b.usua_CODI AND b.depe_codi = h.depe_codi
            left join  MEDIO_RECEPCION mr on  r.MREC_CODI=mr.MREC_CODI
			WHERE 
				h.SGD_TTR_CODIGO IN(22,42)
				$condicionE
				AND b.USUA_CODI=$codUs 
				AND ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini'  AND '$fecha_fin' 
				$whereTipoRadicado 
			ORDER BY $orno $ascdesc";
		}break;
	case 'oracle':
	case 'oci8':
	case 'oci805':
	case 'oci8po':
		{	if ( $dependencia_busq != 99999)
			{	$condicionE = "	AND h.DEPE_CODI=$dependencia_busq AND b.depe_codi = $dependencia_busq";	}
			$queryE = "
	    	SELECT b.USUA_NOMB USUARIO
                , count(*) RADICADOS
				, b.usua_doc AS HID_USUA_DOC
				, SUM(r.RADI_NUME_HOJA) HOJAS_DIGITALIZADAS						
				, MIN(b.USUA_CODI) HID_COD_USUARIO
			FROM RADICADO r, USUARIO b, HIST_EVENTOS h
			WHERE 
				h.USUA_CODI=b.usua_CODI 
				AND b.depe_codi = h.depe_codi
				$condicionE
				AND h.RADI_NUME_RADI=r.RADI_NUME_RADI
				AND h.SGD_TTR_CODIGO IN(22,42)
				AND TO_CHAR(r.radi_fech_radi,'yyyy/mm/dd') BETWEEN '$fecha_ini'  AND '$fecha_fin' 
				$whereTipoRadicado $resolucion
			GROUP BY b.USUA_NOMB,b.usua_doc
			ORDER BY $orno $ascdesc";
 			/** CONSULTA PARA VER DETALLES 
	 		*/

			if($_GET['usua_doc'])$whereTipoRadicado.=" AND b.USUA_DOC ='". $_GET['usua_doc']."'" ;
			$queryEDetalle = "SELECT 
				r.RADI_NUME_RADI RADICADO
				, b.USUA_NOMB USUARIO_DIGITALIZADOR
				, h.HIST_OBSE OBSERVACIONES
				, TO_CHAR(r.RADI_FECH_RADI, 'DD/MM/YYYY HH24:MI:SS') FECHA_RADICACION
				, TO_CHAR(h.HIST_FECH, 'DD/MM/YYYY HH24:MI:SS') FECHA_DIGITALIZACION
				, mr.mrec_desc MEDIO_RECEPCION
				,R.RADI_PATH HID_RADI_PATH{$seguridad}
				FROM RADICADO r
            inner join HIST_EVENTOS h on h.RADI_NUME_RADI=r.RADI_NUME_RADI
            inner join USUARIO b on h.USUA_CODI=b.usua_CODI AND b.depe_codi = h.depe_codi
            left  join MEDIO_RECEPCION mr on r.MREC_CODI=mr.MREC_CODI
			WHERE 
				h.SGD_TTR_CODIGO IN(22,42)
				$condicionE
				AND b.USUA_CODI=$codUs
				AND TO_CHAR(r.radi_fech_radi,'yyyy/mm/dd') BETWEEN '$fecha_ini'  AND '$fecha_fin' 
				$whereTipoRadicado $resolucion
			ORDER BY $orno $ascdesc";
		}break;
}

if(isset($_GET['genDetalle'])&& $_GET['denDetalle']=1)
		$titulos=array("#","1#RADICADO","2#USUARIO DIGITALIZADOR","3#OBSERVACIONES","4#FECHA RADICACI&Oacute;N","5#FECHA DIGITALIZACI&Oacute;N","6#MEDIO DE RECEPCI&Oacute;N");
	else 		
		$titulos=array("#","1#Usuario","2#Radicados","3#HOJAS DIGITALIZADAS");

function pintarEstadistica($fila,$indice,$numColumna){
        	global $ruta_raiz,$_POST,$_GET,$krd;
        	$salida="";
        	switch ($numColumna){
        		case  0:
        			$salida=$indice;
        			break;
        		case 1:	
        			$salida=$fila['USUARIO'];
        		break;
        		case 2:
        			$datosEnvioDetalle="tipoEstadistica=".$_POST['tipoEstadistica']."&amp;genDetalle=1&amp;usua_doc=".urlencode($fila['HID_USUA_DOC'])."&amp;dependencia_busq=".$_POST['dependencia_busq']."&amp;fecha_ini=".$_POST['fecha_ini']."&amp;fecha_fin=".$_POST['fecha_fin']."&amp;tipoRadicado=".$_POST['tipoRadicado']."&amp;tipoDocumento=".$_POST['tipoDocumento']."&amp;codUs=".$fila['HID_COD_USUARIO']."&amp;resol=".$_POST['resol'];
	        		$datosEnvioDetalle=(isset($_POST['usActivos']))?$datosEnvioDetalle."&amp;usActivos=".$_POST['usActivos']:$datosEnvioDetalle;
	        		$salida="<a href=\"genEstadistica.php?{$datosEnvioDetalle}&amp;krd={$krd}\"  target=\"detallesSec\" >".$fila['RADICADOS']."</a>";
        	break;
        	 case 3:
        	 	$salida=$fila['HOJAS_DIGITALIZADAS'];
        	 	break;
        	default: $salida=false;
        	}
        	return $salida;
        }
function pintarEstadisticaDetalle($fila,$indice,$numColumna){
			global $ruta_raiz,$encabezado,$krd;
			$verImg=($fila['SGD_SPUB_CODIGO']==1)?($fila['USUARIO']!=$_SESSION['usua_nomb']?false:true):($fila['USUA_NIVEL']>$_SESSION['nivelus']?false:true);
        	$numRadicado=$fila['RADICADO'];	
			switch ($numColumna){
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
							$salida="<center class=\"leidos\">".$fila['USUARIO_DIGITALIZADOR']."</center>";
							break;
						case 3:
							$salida="<center class=\"leidos\">".$fila['OBSERVACIONES']."</center>";
							break;
						case 4:
						if($verImg)
		   					$salida="<a class=\"vinculos\" href=\"{$ruta_raiz}verradicado.php?verrad=".$fila['RADICADO']."&amp;".session_name()."=".session_id()."&amp;krd=".$_GET['krd']."&amp;carpeta=8&amp;nomcarpeta=Busquedas&amp;tipo_carp=0 \" >".$fila['FECHA_RADICACION']."</a>";
		   				else 
		   				$salida="<a class=\"vinculos\" href=\"#\" onclick=\"alert('ud no tiene permisos para ver el radicado')\">".$fila['FECHA_RADICACION']."</a>";
						break;
					case 5:
						$salida="<center class=\"leidos\">".$fila['FECHA_DIGITALIZACION']."</center>";		
						break;
					case 6:
						$salida="<center class=\"leidos\">".$fila['MEDIO_RECEPCION']."</center>";
			}
			return $salida;
		}
?>
