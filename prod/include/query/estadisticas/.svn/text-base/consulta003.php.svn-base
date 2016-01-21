<?php
/** CONSUTLA 001 
  *Estadisticas por medio de envio -Salida *******
  *se tienen en cuenta los registros enviados por la dep xx contando la masiva ----
	*ej. COnsulta Base SELECT a.sgd_fenv_codigo,b.sgd_fenv_descrip,a.tot_reg 
  * FROM (SELECT SUM(SGD_RENV_CANTIDAD)AS tot_reg,sgd_fenv_codigo FROM fldoc.SGD_RENV_REGENVIO 
 	*  WHERE TO_CHAR(SGD_RENV_FECH,'yyyy/mm/%') LIKE '2005/05/%' 
	*   AND depe_codi LIKE 529
	*   AND RADI_NUME_SAL LIKE '2005%'
	*  GROUP BY sgd_fenv_codigo) a, fldoc.SGD_FENV_FRMENVIO b
  *  WHERE a.sgd_fenv_codigo=b.sgd_fenv_codigo;
	*
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
   * 
   */
$_POST['resol']? $resolucion=" and r.sgd_tres_codigo = ".$_POST['resol']." ":0;
$_GET['resol']? $resolucion=" and r.sgd_tres_codigo = ".$_GET['resol']." ":0;
$seguridad=",B.CODI_NIVEL USUA_NIVEL,R.SGD_SPUB_CODIGO";
switch($db->driver)
{
	case 'oracle':
	case 'oci8':
	case 'oci805':
	case 'oci8po':
		{
			if ($whereDependencia && $dependencia_busq != 99999)
			{
				$wdepend = " AND b.depe_codi = $dependencia_busq ";
			}
			$queryE = "
                        SELECT b.USUA_NOMB  USUARIO, COUNT(*) TOTAL_ENVIADOS , b.USUA_DOC HID_COD_USUARIO , 
                            b.depe_codi HID_DEPE_USUA , c.sgd_fenv_codigo CODIGO_ENVIO , f.sgd_fenv_descrip MEDIO_ENVIO , 
                            f.sgd_fenv_codigo HID_CODIGO_ENVIO 
                        FROM SGD_RENV_REGENVIO c
                        join USUARIO b on c.usua_doc=b.usua_doc
                        join radicado r on r.radi_nume_radi = c.radi_nume_sal 
                        left join SGD_FENV_FRMENVIO f ON f.sgd_fenv_codigo=c.sgd_fenv_codigo
                        WHERE TO_CHAR(c.SGD_RENV_FECH, 'yyyy/mm/dd') BETWEEN '$fecha_ini'  AND '$fecha_fin'
                          $wdepend
                            AND (c.sgd_renv_planilla != '00' or c.sgd_renv_planilla is null) 
                            and (c.sgd_renv_observa not like 'Masiva%' or c.sgd_renv_observa is null) $whereTipoRadicado $resolucion
                        GROUP BY b.USUA_NOMB, b.USUA_DOC, b.depe_codi, c.sgd_fenv_codigo, f.sgd_fenv_descrip, f.sgd_fenv_codigo
                        ORDER BY $orno $ascdesc";
			/** CONSULTA PARA VER DETALLES 
	 		*/ 
                        if(!$fenvCodi)$fenvCodi="null";
			$condicionDep = " AND b.depe_codi = $depeUs ";
			$condicionE = " AND c.sgd_fenv_codigo = $fenvCodi AND b.USUA_doc =".$_GET['usua_doc'];

			$queryEDetalle = "SELECT  c.RADI_NUME_SAL RADICADO
				,d.sgd_fenv_descrip ENVIO_POR
				,b.USUA_NOMB USUARIO_QUE_ENVIO
				,c.sgd_renv_fech FECHA_ENVIO
				,c.sgd_renv_planilla PLANILLA
				,c.sgd_fenv_codigo HID_CODIGO_ENVIO
                                ,r.radi_path as HID_RADI_PATH
				FROM SGD_RENV_REGENVIO c, SGD_FENV_FRMENVIO d, USUARIO b, radicado r
				WHERE 
				    c.sgd_fenv_codigo=d.sgd_fenv_codigo(+)
					AND TO_CHAR(c.SGD_RENV_FECH,'yyyy/mm/dd') BETWEEN '$fecha_ini'  AND '$fecha_fin'
					AND r.radi_nume_radi = c.radi_nume_sal
					and cast(substr(cast(c.usua_doc AS VARCHAR(20)),1,15)as INTEGER) =  b.USUA_doc
					$wdepend
					AND (c.sgd_renv_planilla != '00' or c.sgd_renv_planilla is null)
					and (c.sgd_renv_observa not like 'Masiva%' or  c.sgd_renv_observa is null)
					
					$whereTipoRadicado $resolucion";

			$orderE = "	ORDER BY $orno $ascdesc ";
 			/** CONSULTA PARA VER TODOS LOS DETALLES 
	 		*/ 
			$queryETodosDetalle = $queryEDetalle . $orderE;
			$queryEDetalle .= $condicionE . $condicionDep . $orderE;
		}break;
	default:
		{	// Este default trabaja con Mssql 2K, 2K5.
			if ($whereDependencia && $dependencia_busq != 99999)	$wdepend = " AND b.depe_codi = $dependencia_busq ";
			$queryE = " SELECT  b.USUARIO
                                , b.tot_reg AS TOTAL_ENVIADOS
                                ,b.USUA_DOC AS HID_COD_USUARIO
                                , HID_DEPE_USUA
                                , b.sgd_fenv_codigo AS CODIGO_ENVIO
                                , c.sgd_fenv_descrip AS MEDIO_ENVIO
                                , b.sgd_fenv_codigo AS HID_CODIGO_ENVIO
			    		FROM  (SELECT COUNT(c.SGD_RENV_CANTIDAD) AS tot_reg, c.sgd_fenv_codigo, b.USUA_NOMB AS USUARIO,
									MIN(b.depe_codi) AS HID_DEPE_USUA, MIN(b.usua_doc) AS USUA_DOC
								FROM  SGD_RENV_REGENVIO c, USUARIO b, radicado r
								WHERE ".$db->conn->SQLDate('Y/m/d', 'c.SGD_RENV_FECH')." BETWEEN '$fecha_ini'  AND '$fecha_fin' AND
									r.radi_nume_radi = c.radi_nume_sal $wdepend AND cast(c.usua_doc as VARCHAR) = b.usua_doc AND
									(c.sgd_renv_planilla != '00' or c.sgd_renv_planilla is null) and
									(c.sgd_renv_observa not like 'Masiva%' or  c.sgd_renv_observa is null)
									$whereTipoRadicado
								GROUP BY b.USUA_NOMB, c.sgd_fenv_codigo
							  ) b, SGD_FENV_FRMENVIO c
						WHERE b.sgd_fenv_codigo=c.sgd_fenv_codigo
						ORDER BY $orno $ascdesc";
		
			/** CONSULTA PARA VER DETALLES   */ 
			$condicionDep = ($dependencia_busq == 99999) ? '' : " and b.depe_codi = ".$dependencia_busq;
			//$condicionE = " AND c.sgd_fenv_codigo = $fenvCodi AND b.USUA_doc = '$usua_doc' "; J0.0!
			$condicionE = " AND c.sgd_fenv_codigo = $fenvCodi AND b.USUA_doc = '".$_GET["usua_doc"]."'";
			$queryEDetalle = "SELECT $radi_nume_radi AS RADICADO
                                    ,d.sgd_fenv_descrip AS ENVIO_POR
                                    ,b.USUA_NOMB AS USUARIO_QUE_ENVIO
                                    ,c.sgd_renv_fech AS FECHA_ENVIO
                                    ,c.sgd_renv_planilla AS PLANILLA
                                    ,c.sgd_fenv_codigo AS HID_CODIGO_ENVIO
                               FROM SGD_RENV_REGENVIO c, SGD_FENV_FRMENVIO d, USUARIO b, radicado r
                               WHERE c.sgd_fenv_codigo=d.sgd_fenv_codigo AND
                               ".$db->conn->SQLDate('Y/m/d', 'c.SGD_RENV_FECH')." BETWEEN '$fecha_ini'  AND '$fecha_fin' AND
                               r.radi_nume_radi = c.radi_nume_sal and cast(c.usua_doc as VARCHAR) =  b.USUA_doc $wdepend AND
                               (c.sgd_renv_planilla != '00' or c.sgd_renv_planilla is null) and
                               (c.sgd_renv_observa not like 'Masiva%' or  c.sgd_renv_observa is null)
                               $whereTipoRadicado ";
	
			$orderE = "     ORDER BY $orno $ascdesc ";
		
	 		/** CONSULTA PARA VER TODOS LOS DETALLES */
			$queryETodosDetalle = $queryEDetalle . $orderE;
			$queryEDetalle .= $condicionE . $condicionDep . $orderE;	
		}break;
}

if(isset($_GET['genDetalle'])&& $_GET['denDetalle']=1)
	$titulos=array("#","1#RADICADO","2#ENV&Iacute;O POR","3#USUARIO QUE ENVI&Oacute;","4#FECHA ENV&Iacute;O","5#PLANILLA");
else             
	$titulos=array("#","1#USUARIO","2#TOTAL ENVIADOS","3#MEDIO DE ENV&Iacute;O");
                 
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
                                 $datosEnvioDetalle="tipoEstadistica=".$_POST['tipoEstadistica']."&amp;genDetalle=1&amp;usua_doc=".urlencode($fila['HID_COD_USUARIO'])."&amp;dependencia_busq=".$_POST['dependencia_busq']."&amp;depeUs=".$fila['HID_DEPE_USUA']."&amp;fenvCodi=".$fila['HID_CODIGO_ENVIO']."&amp;fecha_ini=".$_POST['fecha_ini']."&amp;fecha_fin=".$_POST['fecha_fin']."&amp;tipoRadicado=".$_POST['tipoRadicado']."&amp;tipoDocumento=".$_POST['tipoDocumento']."&amp;resol=".$_POST['resol'];
                                 $datosEnvioDetalle=(isset($_POST['usActivos']))?$datosEnvioDetalle."&amp;usActivos=".$_POST['usActivos']:$datosEnvioDetalle;
                                 $salida="<a href=\"genEstadistica.php?{$datosEnvioDetalle}&amp;krd={$krd}\"  target=\"detallesSec\" >".$fila['TOTAL_ENVIADOS']."</a>";
                                break;
                        case 3:
                                $salida=$fila['MEDIO_ENVIO'];
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
						$salida=$fila['ENVIO_POR'];
                                                break;
                                        case 3:  
                                              $salida="<center class=\"leidos\">".$fila['USUARIO_QUE_ENVIO']."</center>";                                                 break;
                                        case 4:
                                                $salida="<center class=\"leidos\">".$fila['FECHA_ENVIO']."</center>";
                                                break;
                                        case 5:
                                                $salida="<center class=\"leidos\">".$fila['PLANILLA']."</center>";
                                                break;
                        }
                        return $salida;               
		
}
?>
