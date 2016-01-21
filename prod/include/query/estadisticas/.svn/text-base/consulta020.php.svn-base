<?php
$coltp3Esp = '"'.$tip3Nombre[3][2].'"';
if(!$orno) $orno=1;

			
$titulos=array("#","1#RADICADO","3#FECHA RADICADO","4#FECHA ARCHIVO","5#USUARIO","6#DEPENDENCIA","7#NO FOLIOS","8#EXPEDIENTE");


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
				$salida="<center><a href=\"{$ruta_raiz}bodega/".$fila['HID_RADI_PATH']."\">".$fila['RADICADO']."</a></center>";
			else
				$salida="<center class=\"leidos\">{$numRadicado}</center>";
			break;
		case 2:
			if($verImg)
				$salida="<a class=\"vinculos\" href=\"{$ruta_raiz}verradicado.php?verrad=".$fila['RADICADO']."&amp;".session_name()."=".session_id()."&amp;krd=".$_GET['krd']."&amp;carpeta=8&amp;nomcarpeta=Busquedas&amp;tipo_carp=0 \" >".$fila['FECHA_RADICACION']."</a>";
			else
				$salida="<a class=\"vinculos\" href=\"#\" onclick=\"alert(\"ud no tiene permisos para ver el radicado\");\">".$fila['FECHA_RADICACION']."</a>";
			break;
        case 3:
			$salida="<center class=\"leidos\">".$fila['FECHA_ARCHIVO']."</center>";
			break;
		case 4:
			$salida="<center class=\"leidos\">".$fila['USUARIO']."</center>";
			break;
		case 5:
			$salida="<center class=\"leidos\">".$fila['DEPENDENCIA']."</center>";
			break;
        case 6:
			$salida="<center class=\"leidos\">".$fila['NUMERO_FOLIOS']."</center>";
			break;
		case 7:
			$salida="<center class=\"leidos\">".$fila['EXPEDIENTE']."</center>";
			break;
	}
	return $salida;
}
?>
