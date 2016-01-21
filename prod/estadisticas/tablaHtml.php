<?php
require_once($ruta_raiz."/include/myPaginador.inc.php");
require_once($ruta_raiz."/radsalida/masiva/OpenDocText.class.php");
$odt = new OpenDocText();
$paginador=new myPaginador($db,($queryE),$orden,$ascdesc,1000);
if(isset($_GET['genDetalle']) ||isset($_GET['genTodosDetalle']))
{
	$paginador->setFuncionFilas("pintarEstadisticaDetalle");
}
else
{
	$orden=isset($orden)?$orden:"";
	$paginador->setFuncionFilas("pintarEstadistica");
}
$paginador->setImagenASC($ruta_raiz."iconos/flechaasc.gif");
$paginador->setImagenDESC($ruta_raiz."iconos/flechadesc.gif");
echo $paginador->generarPagina($titulos,"titulos3");
if(!isset($_GET['genDetalle']) && !isset($_GET['genTodosDetalle']) && $paginador->getTotal() > 0)
{
    $total=$paginador->getId()."_total";
	$res=$db->query($queryE);
	$datos=0;
	while(!$res->EOF)
	{
		$data1y[]=$res->fields[1];
		$nombUs[]= iconv($odt->codificacion($res->fields[0]), 'ISO-8859-1',$res->fields[0]);
		$nombPqr[]=iconv($odt->codificacion($res->fields[2]), 'ISO-8859-1',$res->fields[2]);
		$nombPqrLbl[]=iconv($odt->codificacion($res->fields[2]), 'ISO-8859-1',$res->fields[2])." %.1f%%";
		$res->MoveNext();
	}
        include($ruta_raiz."/config.php");
	$nombXAxis=substr($titulos[1],strpos($titulos[1],"#")+1);
	$nombXAxis = str_replace("&Aacute;", "Á", $nombXAxis);
	$nombXAxis = str_replace("&Eacute;", "É", $nombXAxis);
	$nombXAxis = str_replace("&Iacute;", "Í", $nombXAxis);
	$nombXAxis = str_replace("&Oacute;", "Ó", $nombXAxis);
	$nombXAxis = str_replace("&Uacute;", "Ú", $nombXAxis);
	$nombXAxis = utf8_encode($nombXAxis);
	$nombYAxis=substr($titulos[2],strpos($titulos[2],"#")+1);
	$nombYAxis = str_replace("&Aacute;", "Á", $nombYAxis);
	$nombYAxis = str_replace("&Eacute;", "É", $nombYAxis);
	$nombYAxis = str_replace("&Iacute;", "Í", $nombYAxis);
	$nombYAxis = str_replace("&Oacute;", "Ó", $nombYAxis);
	$nombYAxis = str_replace("&Uacute;", "Ú", $nombYAxis);
	$nombYAxis = utf8_encode($nombYAxis);
	$nombreGraficaTmp = $ruta_raiz."$carpetaBodega/tmp/E_$krd.png";
	$rutaImagen = $nombreGraficaTmp;
	if(file_exists($rutaImagen))
	{
		unlink($rutaImagen);
	}
	$notaSubtitulo = $subtituloE[$tipoEstadistica]."\n";
	$notaSubtitulo = str_replace("&aacute;", "á", $notaSubtitulo);
	$notaSubtitulo = str_replace("&eacute;", "é", $notaSubtitulo);
	$notaSubtitulo = str_replace("&iacute;", "í", $notaSubtitulo);
	$notaSubtitulo = str_replace("&oacute;", "ó", $notaSubtitulo);
	$notaSubtitulo = str_replace("&uacute;", "ú", $notaSubtitulo);
	$notaSubtitulo = utf8_encode($notaSubtitulo);
	$tituloGraph = $tituloE[$tipoEstadistica];
	$tituloGraph = str_replace("&Aacute;", "Á", $tituloGraph);
	$tituloGraph = str_replace("&Eacute;", "É", $tituloGraph);
	$tituloGraph = str_replace("&Iacute;", "Í", $tituloGraph);
	$tituloGraph = str_replace("&Oacute;", "Ó", $tituloGraph);
	$tituloGraph = str_replace("&Uacute;", "Ú", $tituloGraph);
	$tituloGraph = utf8_encode($tituloGraph);
	if($tipoEstadistica==15)include "PdfEstadistica015.php";
    else include "genBarras1.php";

?>
    <table align="center">
    <tr>
    	<td>
            <!-- Modificado SGD 21-Agosto-2007
            <input type=button class="botones_largo" value="Ver Grafica" onClick='window.open("image.php?rutaImagen=<?=$rutaImagen."&fechaH=".date("YmdHis")?>" , "Grafica_Estadisticas_-_Orfeo", "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=560,height=720");' />
            -->
            <input type=button class="botones_largo" value="Ver Grafica" onClick='window.open("<?php print $ruta_raiz; ?>/estadisticas/image.php?rutaImagen=<?=$rutaImagen."&fechaH=".date("YmdHis")?>" , "Grafica_Estadisticas_-_Orfeo", "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=560,height=720");' />
            <?php echo "<!-- $queryE -->"; ?>
        </td>
   </tr>
   <?if($tipoEstadistica==1 or $tipoEstadistica==9){?>
   <tr>
        <td align="center">
            <a href="genEstadistica.php?<?=$datosEnvioDetalle?>&genTodosDetalle=1&<?=$datosaenviar?>" Target="detallesSec" class="vinculos">VER TODOS LOS DETALLES</a>
        </td>
    </tr>
   <?}}?>
    </table>

</center>
</body>
</html>
