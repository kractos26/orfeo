<?php
$coltp3Esp = '"'.$tip3Nombre[3][2].'"';
if(!$orno) $orno=2;
$where=null;
$whereDep=null;
$and=null;
$group1=null;
$select1=null;
$titulo=null;
$_POST['resol']? $resolucion=" and r.sgd_tres_codigo = ".$_POST['resol']." ":0;
$_GET['resol']? $resolucion=" and r.sgd_tres_codigo = ".$_GET['resol']." ":0;
if($dependencia_busq==99999)
{
    if($dependencia_detalle)
    {
        $where=" his.DEPE_CODI_DEST = ".$dependencia_detalle;
        $titulo="1#Dependencia";
        $select1=" d.DEPE_NOMB AS DEPENDENCIA,";
        $group1 = "d.DEPE_NOMB, ";
    }
    else
    {
    $titulo="1#Dependencia";
    $select1=" d.DEPE_NOMB AS DEPENDENCIA,";
    $group1 = "d.DEPE_NOMB,d.DEPE_CODI, ";
    $tituloHID1="AS HID_DEPE_CODI";
    $selectHID1 =" , d.DEPE_CODI  ";

    }

}
else if($dependencia_busq==99998)
{
    $titulo="1#Dependencia";
    $select1=" 'CONSOLIDADO GRAL' AS DEPENDENCIA,";
}
else {
    $where=" his.DEPE_CODI_DEST = ".$dependencia_busq;
    $titulo="1#Dependencia";
    $select1=" d.DEPE_NOMB AS DEPENDENCIA,";
    $group1 = "d.DEPE_NOMB, ";
}

if($codus)
{
    $where.=" AND b.USUA_CODI=".$codus;
    $select1=" b.USUA_NOMB AS USUARIO, "  ;
    $group1=" b.USUA_NOMB, "  ;
    $titulo="1#Usuario";
    $tituloHID2=" as HID_USUA_DOC";
    $selectHID2=" ,b.USUA_DOC ";
}
if($tipoRadicado)
{
    if($where)$where.=" AND r.RADI_NUME_RADI LIKE '%$tipoRadicado'";
    else $where.=" r.RADI_NUME_RADI LIKE '%$tipoRadicado'";
}
if($tipoPQR)
{
    if($where)$where.=" AND ser.PAR_SERV_SECUE = $tipoPQR";
    else      $where.=" ser.PAR_SERV_SECUE = $tipoPQR ";
}
if($where){
    $where.= " AND ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini' AND '$fecha_fin'";
}
else{
    $where.= $db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini' AND '$fecha_fin'";
}
if(!is_null($where))$where=" WHERE ".$where;


$selectE="SELECT $select1 COUNT(*) AS RADICADOS ,ser.PAR_SERV_NOMBRE AS PQR,ser.PAR_SERV_SECUE AS HID_COD_PETICION
                    $selectHID1 $tituloHID1 $selectHID2 $tituloHID2";
$anexos=$db->conn->Concat("a.RADI_NUME_SALIDA","' '",$db->conn->substr."(cast(a.SGD_DIR_TIPO AS VARCHAR(14)),2,2)");//$db->conn->substr."(a.ANEX_CODIGO,15,5)");                   
$selectEDetalle="SELECT  r.RADI_NUME_RADI AS RADICADO
                        ,ser.PAR_SERV_NOMBRE AS PQR
                        ,r.RADI_FECH_RADI as FECHA_RADICADO
                        ,r.RA_ASUN as ASUNTO
                        ,m.MREC_DESC as MEDIO_RECEPCION
                        ,r.RADI_PATH as HID_RADI_PATH {$seguridad}
                        ,d.DEPE_NOMB AS DEPENDENCIA_PQR
                        ,dACTU.DEPE_NOMB AS DEPENDENCIA_ACTUAL
                        ,$anexos AS ANEXO
                        ,a.ANEX_CREADOR AS USUARIO
                        ,caux.sgd_dcau_codigo AS COD_CAUSALX
                        ,cau.sgd_cau_descrip AS CAUSAL
                        ,dcau.sgd_dcau_descrip AS DCAUSAL
                        
                        
                    $selectHID1 $tituloHID1";
if($genDetalle==1){
            $inner_Anexos="LEFT OUTER JOIN
             ANEXOS a
               ON       r.RADI_NUME_RADI = a.ANEX_RADI_NUME";

           }
$query = "
           FROM 
           HIST_EVENTOS his
           INNER JOIN
                    (SELECT  r.RADI_NUME_RADI, MIN(h.HIST_FECH) AS FECHA
                     FROM HIST_EVENTOS h
                     INNER JOIN RADICADO r ON r.RADI_NUME_RADI=h.RADI_NUME_RADI
                     WHERE h.SGD_TTR_CODIGO =9
                     GROUP BY r.RADI_NUME_RADI
                     ORDER BY 1) TconHis
           ON 	     his.RADI_NUME_RADI= TconHis.RADI_NUME_RADI AND his.HIST_FECH=TconHis.FECHA
           INNER JOIN
                     DEPENDENCIA d
           ON 	     d.depe_codi=his.depe_codi_dest
           INNER JOIN
                     RADICADO r
           ON    	 r.RADI_NUME_RADI=his.RADI_NUME_RADI
           INNER JOIN
                     USUARIO b
           ON    	 b.USUA_DOC=his.HIST_DOC_DEST
           INNER JOIN
                     PAR_SERV_SERVICIOS ser
           ON        ser.PAR_SERV_SECUE=r.PAR_SERV_SECUE
           LEFT OUTER JOIN
                    MEDIO_RECEPCION m
           ON       r.MREC_CODI = m.MREC_CODI
           INNER JOIN
                     DEPENDENCIA dACTU
           ON 	     dACTU.DEPE_CODI=r.RADI_DEPE_ACTU
           LEFT JOIN sgd_caux_causales caux ON caux.RADI_NUME_RADI=r.radi_nume_radi 
           LEFT JOIN sgd_dcau_causal dcau ON caux.sgd_dcau_codigo=dcau.sgd_dcau_codigo
           left join sgd_cau_causal cau ON dcau.sgd_cau_codigo=cau.sgd_cau_codigo
           $inner_Anexos
           $where $resolucion ";

$group=" GROUP BY  $group1 ser.PAR_SERV_NOMBRE,ser.PAR_SERV_SECUE $selectHID1 $selectHID2";
$order =" ORDER BY $orno $ascdesc";

 		
$queryE = $selectE.$query.$group.$order;
$queryEDetalle = $selectEDetalle.$query.$order ;
			
if(isset($_GET['genDetalle'])&& $_GET['genDetalle']==1 || isset($_GET['genTodosDetalle'])&& $_GET['genTodosDetalle']==1)
	$titulos=array("#","1#RADICADO","2#FECHA RADICADO","3#ASUNTO","4#DEPENDENCIA_PQR","5#MEDIO_RECEPCI&Oacute;N","6#RADICADO_SALIDA","7#USUARIO_CREADOR","8#DEPENDENCIA_ACTUAL","9#PQR","10#CAUSAL","11#DCAUSAL");
else
	$titulos=array("#",trim($titulo),"2#Radicados","3#Tipo de PQR");

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
            if(!$salida)$salida=$fila['DEPENDENCIA'];
            if(!$salida)$salida="Todas las Dependencias";
        	break;
        case 2:
        	$datosEnvioDetalle="tipoEstadistica=".$_POST['tipoEstadistica']."&amp;genDetalle=1&amp;usua_doc=".urlencode($fila['HID_USUA_DOC'])."&amp;dependencia_busq=".$_POST['dependencia_busq']."&amp;dependencia_detalle=".$fila['HID_DEPE_CODI']."&amp;fecha_ini=".$_POST['fecha_ini']."&amp;fecha_fin=".$_POST['fecha_fin']."&amp;tipoRadicado=".$_POST['tipoRadicado']."&amp;tipoDocumento=".$_POST['tipoDocumento']."&TIPDOC=".$fila['TIPDOC']."&amp;codUs=".$fila['HID_COD_USUARIO']."&amp;tipoPQR=".$fila['HID_COD_PETICION']."&amp;resol=".$_POST['resol'];
	    	$datosEnvioDetalle=(isset($_POST['usActivos']))?$datosEnvioDetalle."&amp;usActivos=".$_POST['usActivos']:$datosEnvioDetalle;
	    	$salida="<a href=\"genEstadistica.php?{$datosEnvioDetalle}&amp;krd={$krd}\"  target=\"detallesSec\" >".$fila['RADICADOS']."</a>";
        	break;
        case 3:
            $salida=$fila['PQR'];
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
				$salida="<a class=\"vinculos\" href=\"#\" onclick=\"alert('ud no tiene permisos para ver el radicado')\">".$fila['FECHA_RADICADO']."</a>";
			break;
                case 3:
			$salida="<center class=\"leidos\">".$fila['ASUNTO']."</center>";
			break;
		case 4:
			$salida="<center class=\"leidos\">".$fila['DEPENDENCIA_PQR']."</center>";
			break;
		case 5:
			$salida="<center class=\"leidos\">".$fila['MEDIO_RECEPCION']."</center>";
			break;
                case 6:
			$salida="<center class=\"leidos\">".$fila['ANEXO']."</center>";
			break;
		case 7:
			$salida="<center class=\"leidos\">".$fila['USUARIO']."</center>";
			break;
		case 8:
			$salida="<center class=\"leidos\">".$fila['DEPENDENCIA_ACTUAL']."</center>";
			break;
                case 9:
			$salida="<center class=\"leidos\">".$fila['PQR']."</center>";
			break;
                case 10:
			$salida="<center class=\"leidos\">".$fila['CAUSAL']."</center>";
			break; 
                case 11:
			$salida="<center class=\"leidos\">".$fila['DCAUSAL']."</center>";
			break;                    
                    
	}
	return $salida;
}
?>
