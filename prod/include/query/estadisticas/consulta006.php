<?php
$coltp3Esp = '"'.$tip3Nombre[3][2].'"';	
if(!$orno) $orno=1;
$_POST['resol']? $resolucion=" and r.sgd_tres_codigo = ".$_POST['resol']." ":0;
$_GET['resol']? $resolucion=" and r.sgd_tres_codigo = ".$_GET['resol']." ":0;
switch($db->driver)
{
	case 'mssql':
	case 'postgres':
                $redondeo="date_part('days', radi_fech_radi-".$db->conn->sysTimeStamp.")+floor(t.sgd_tpr_termino * 7/5)+(select count(*) from sgd_noh_nohabiles where NOH_FECHA between radi_fech_radi and ".$db->conn->sysTimeStamp.")";
                break;
	case 'oracle':
	case 'oci8':
	case 'oci805':
	case 'oci8po':
                $redondeo="round(((r.radi_fech_radi+(t.sgd_tpr_termino * 7/5))-sysdate))+(select count(*) from sgd_noh_nohabiles where NOH_FECHA between r.radi_fech_radi and ".$db->conn->sysTimeStamp.")";
                break;
}
if ( $dependencia_busq != 99999)
{
    $condicionE = " b.DEPE_CODI=$dependencia_busq AND r.RADI_DEPE_ACTU=$dependencia_busq ";
}
else
{
    $condicionE = " r.radi_depe_actu=b.depe_codi ";
}
if($tipoDocumento=='9999')
{
    $queryE = "SELECT  b.usua_nomb 	                as USUARIO
                       ,count($radi_nume_radi) 	as RADICADOS
                       ,MIN(b.USUA_CODI) 	as HID_COD_USUARIO
                       ,b.USUA_DOC              as HID_USUA_DOC
                       ,d.depe_codi             as HID_DEPE_CODI
	       FROM  RADICADO r
               JOIN  USUARIO b     ON r.RADI_USUA_ACTU=b.USUA_CODI AND r.RADI_DEPE_ACTU=b.DEPE_CODI
               JOIN  DEPENDENCIA d ON d.DEPE_CODI=b.DEPE_CODI
               WHERE
			$condicionE
			$whereTipoRadicado $resolucion
               GROUP BY b.USUA_DOC,d.depe_codi, b.usua_nomb
	       ORDER BY $orno $ascdesc";
}
else
{
    $queryE = "SELECT   b.usua_nomb                    as USUARIO
			, t.SGD_TPR_DESCRIP         as TIPO_DOCUMENTO
			, count($radi_nume_radi)    as RADICADOS
			, MIN(b.USUA_CODI)          as HID_COD_USUARIO
			, MIN(SGD_TPR_CODIGO)       as HID_TPR_CODIGO
                        ,d.depe_codi                as HID_DEPE_CODI
                        ,b.USUA_DOC                 as HID_USUA_DOC
		FROM RADICADO r
                JOIN USUARIO b ON r.RADI_USUA_ACTU=b.USUA_CODI AND r.RADI_DEPE_ACTU=b.DEPE_CODI
		LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.tdoc_codi=t.SGD_TPR_CODIGO
                JOIN DEPENDENCIA d ON d.DEPE_CODI=b.DEPE_CODI
		WHERE $condicionE $whereTipoRadicado $resolucion
		GROUP BY t.SGD_TPR_DESCRIP,d.depe_codi, b.usua_nomb, b.USUA_DOC
		ORDER BY $orno $ascdesc";
}
			/** CONSULTA PARA VER DETALLES
                        */
if (!is_null($_GET['usua_doc'])) $condicionE .= "and r.radi_usua_actu=b.USUA_CODI  AND b.USUA_DOC='".$_GET['usua_doc']."'";
if (!is_null($tipoDOCumento))
{
    $condicionE .= " AND t.SGD_TPR_CODIGO = $tipoDOCumento ";
}
$systemDate = "CURRENT_TIMESTAMP";
$sgdir_tipo=" AND dir.SGD_DIR_TIPO=1 ";
$queryEDetalle = "SELECT DISTINCT $radi_nume_radi 			as RADICADO
                                  ,t.SGD_TPR_DESCRIP 			as TIPO_DE_DOCUMENTO
                                  , b.USUA_NOMB 			as USUARIO
                                  , r.RA_ASUN 				as ASUNTO
                                  , ".$db->conn->SQLDate('Y/m/d H:i:s','r.radi_fech_radi')." as FECHA_RADICACION
                                  , dir.SGD_DIR_NOMREMDES 	as REMITENTE
                                  ,r.RADI_PATH 				as HID_RADI_PATH{$seguridad},
                                  $redondeo				as \"Dias Restantes\"
                                  ,ser.PAR_SERV_NOMBRE           as SECTOR$dependenciarad
                   FROM RADICADO r
                   INNER JOIN USUARIO b ON r.RADI_USUA_ACTU=b.USUA_CODI AND r.RADI_DEPE_ACTU=b.DEPE_CODI
		   LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.tdoc_codi = t.SGD_TPR_CODIGO
		   LEFT OUTER JOIN SGD_DIR_DRECCIONES dir ON r.radi_nume_radi = dir.radi_nume_radi
                   LEFT JOIN PAR_SERV_SERVICIOS ser ON ser.PAR_SERV_SECUE=r.PAR_SERV_SECUE
		   WHERE
                        $condicionE
			$whereTipoRadicado $resolucion $sgdir_tipo";
                    $orderE = "	ORDER BY $orno $ascdesc";

	 /** CONSULTA PARA VER TODOS LOS DETALLES
	 */
$queryETodosDetalle = $queryEDetalle . $orderE;
$queryEDetalle .= $orderE;
	
if(isset($_GET['genDetalle'])&& $_GET['denDetalle']=1){
		$titulos=array("#","1#RADICADO","2#FECHA RADICACI&Oacute;N","3#TIPO DE DOCUMENTO","4#USUARIO ACTUAL","5#ASUNTO","6#REMITENTE","7#D&Iacute;AS RESTANTES","8#SECTOR");
	}else{ 		
		$titulos=($tipoDocumento=='9999')?array("#","1#Usuario","2#Radicados"):array("#","1#Usuario","3#TIPO DE DOCUMENTO","2#Radicados");
	}
function pintarEstadistica($fila,$indice,$numColumna){
        	global $ruta_raiz,$_POST,$_GET;
        	$salida="";
        	switch ($numColumna){
        		case  0:
        			$salida=$indice;
        			break;
        		case 1:	
        			$salida=$fila['USUARIO'];
        		break;
        		case 2:
        			if(isset($fila['TIPO_DOCUMENTO'])){
        				$salida=$fila['TIPO_DOCUMENTO']; 
        			}else{
        			$datosEnvioDetalle="tipoEstadistica=".$_POST['tipoEstadistica']."&amp;genDetalle=1&amp;usua_doc=".urlencode($fila['HID_USUA_DOC'])."&amp;dependencia_busq=".$_POST['dependencia_busq']."&amp;fecha_ini=".$_POST['fecha_ini']."&amp;fecha_fin=".$_POST['fecha_fin']."&amp;tipoRadicado=".$_POST['tipoRadicado']."&amp;tipoDocumento=".$_POST['tipoDocumento']."&amp;codUs=".$fila['HID_COD_USUARIO']."&amp;resol=".$_POST['resol']."&amp;";
	        		$datosEnvioDetalle=(isset($_POST['usActivos']))?$datosEnvioDetalle."&amp;usActivos=".$_POST['usActivos']:$datosEnvioDetalle;
	        		$salida="<a href=\"genEstadistica.php?{$datosEnvioDetalle}\"  target=\"detallesSec\" >".$fila['RADICADOS']."</a>";}        	break;
        		case 3:
        			$datosEnvioDetalle="tipoEstadistica=".$_POST['tipoEstadistica']."&amp;genDetalle=1&amp;usua_doc=".urlencode($fila['HID_USUA_DOC'])."&amp;dependencia_busq=".$fila['HID_DEPE_CODI']."&amp;fecha_ini=".$_POST['fecha_ini']."&amp;fecha_fin=".$_POST['fecha_fin']."&amp;tipoRadicado=".$_POST['tipoRadicado']."&amp;tipoDocumento=".$_POST['tipoDocumento']."&amp;codUs=".$fila['HID_COD_USUARIO']."&amp;tipoDOCumento=".$fila['HID_TPR_CODIGO'];
	        		$datosEnvioDetalle=(isset($_POST['usActivos']))?$datosEnvioDetalle."&amp;usActivos=".$_POST['usActivos']:$datosEnvioDetalle;
	        		$salida="<a href=\"genEstadistica.php?{$datosEnvioDetalle}\"  target=\"detallesSec\" >".$fila['RADICADOS']."</a>";
        	break;
        	}
        	return $salida;
        }
function asunto($var_asunto)
{
	$cont = strlen($var_asunto);
	$cont2= $cont / 70;
	$valor= round($cont2,0);
	if($valor < $cont2)
	{
	    $valor=$valor+1;
	}
	$arreglo = array($valor-1);
	$ini=0;
	$fin=70;
	for ($i=0; $i<= $valor-1;$i++)
	{
		$campo= substr($var_asunto,$ini,$fin);
		$arreglo[$i]= $campo;
		echo $arreglo[$i]."<br>";
		if($ini==0){$ini=$ini+71;}else{$ini=$ini+70;}
	}
}
function pintarEstadisticaDetalle($fila,$indice,$numColumna){
			global $ruta_raiz,$encabezado,$krd;
			$verImg=($fila['SGD_SPUB_CODIGO']==1)?($fila['RADI_DEPE_ACTU']!=$_SESSION['dependencia']?($fila['USUARIO']!=$_SESSION['usua_nomb']?false:true):true):($fila['USUA_NIVEL']>$_SESSION['nivelus']?false:true);
			//$verImg=($fila['SGD_SPUB_CODIGO']==1)?($fila['USUARIO']!=$_SESSION['usua_nomb']?false:true):($fila['USUA_NIVEL']>$_SESSION['nivelus']?false:true);
        	$numRadicado=$fila['RADICADO'];	
        	$aux= $_SESSION['dependencia'];
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
						if($verImg)
		   					$salida="<a class=\"vinculos\" href=\"{$ruta_raiz}verradicado.php?verrad=".$fila['RADICADO']."&amp;".session_name()."=".session_id()."&amp;krd=".$_GET['krd']."&amp;carpeta=8&amp;nomcarpeta=Busquedas&amp;tipo_carp=0 \" >".$fila['FECHA_RADICACION']."</a>";
		   				else 
		   				$salida="<a class=\"vinculos\" href=\"#\" onclick=\"alert('ud no tiene permisos para ver el radicado')\">".$fila['FECHA_RADICACION']."</a>";
						break;
					case 3:
						$salida="<center class=\"leidos\">".$fila['TIPO_DE_DOCUMENTO']."</center>";		
						break;
					case 4:
						$salida="<center class=\"leidos\">".$fila['USUARIO']."</center>";
						break;
					case 5:
			            $cont = strlen($fila['ASUNTO']);
						$cont2= $cont / 70;
						$valor= round($cont2,0);
						if($valor < $cont2)
						{
						    $valor=$valor+1;
						}
						$arreglo = array($valor-1);
						$ini=0;
						$fin=70;
						$salida="<left class=\"leidos\">";
						for ($i=0; $i<= $valor-1;$i++)
						{
							$campo= substr($fila['ASUNTO'],$ini,$fin);
							$arreglo[$i]= $campo;
							$salida.=$arreglo[$i]."<br>";
							if($ini==0){$ini=$ini+71;}else{$ini=$ini+70;}
						}
						$salida.="</center>";
						break;
					case 6:
						$salida="<left class=\"leidos\">".$fila['REMITENTE']."</left>";			
						break;	
					case 7:
						$salida="<center class=\"leidos\">".$fila['Dias Restantes']."</center>";			
						break;	
					case 8:
						$salida="<center class=\"leidos\">".$fila['SECTOR']."</center>";
						break;	
					case 9:
						$salida="<center class=\"leidos\">".$fila['DETALLE_CAUSAL']."</center>";			
						break;	
					case 10:
						$salida="<center class=\"leidos\">".$fila['USUARIO_ANTERIOR']."</center>";			
						break;
			}
			return $salida;
		}	
?>
