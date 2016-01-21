<?php 
  	require_once($ruta_raiz."/include/myPaginador.inc.php");
  	$paginador=new myPaginador($db,($queryE),$orden);
	// Modificado SGD 02-Noviembre-2007
  	//if(!isset($_GET['genDetalle'])){
  	       	$orden=isset($orden)?$orden:"";
        	$paginador->setFuncionFilas("pintarEstadistica");
	       	$paginador->setImagenASC($ruta_raiz."iconos/flechaasc.gif");
        	$paginador->setImagenDESC($ruta_raiz."iconos/flechadesc.gif");
        	//$paginador->setPie($pie);
        	echo $paginador->generarPagina($titulos,"titulos3");
                                                       
if(!isset($_GET['genDetalle'])&& $paginador->getTotal() > 0){	
    $total=$paginador->getId()."_total";         
	if(!isset($_REQUEST[$total])) {
		$res=$db->query($queryE);
		$datos=0;
		while(!$res->EOF){ 
			  $data1y[]=$res->fields[1];
              $nombUs[]=$res->fields[0];
            $res->MoveNext();		
		}
		$nombYAxis=substr($titulos[1],strpos($titulos[1],"#")+1);
		$nombXAxis=substr($titulos[2],strpos($titulos[2],"#")+1);
		$nombreGraficaTmp = $ruta_raiz."bodega/tmp/E_$krd.png";
		$rutaImagen = $nombreGraficaTmp;
		if(file_exists($rutaImagen)){
			unlink($rutaImagen);
		}
		$notaSubtitulo = $subtituloE[$tipoEstadistica]."\n";
		$tituloGraph = $tituloE[$tipoEstadistica];
		// Modificado SGD 09-Noviembre-2007
		// Para el informe de Quejas y Reclamos no genera gráfica, se exporta a un archivo con formato CSV.
		if( $tipoEstadistica != 15 )
		{
			include "genBarras1.php";
		}
		else
		{
			include_once( $ADODB_PATH.'/toexport.inc.php' );
			
			$db->conn->SetFetchMode( ADODB_FETCH_ASSOC );
			
			$rs = $db->query( $queryE );

			$archivoCSV = $ruta_raiz."bodega/tmp/E_$krd.xls";
			
			$fp = fopen( $archivoCSV, "w" );
			if( $fp )
			{
				fwrite( $fp, iconv( "UTF-8", "ISO-8859-1", rs2csv( $rs ) ) );
				fclose( $fp );
			}
		}
	}
?>
    <table align="center">
    <tr>
    	<td>
		<?php
		// Modificado SGD 09-Noviembre-2007
		// Para el informe de Quejas y Reclamos no genera gráfica, se exporta a un archivo con formato CSV.
		if( $tipoEstadistica != 15 )
		{
		?>
  			<!-- Modificado SGD 21-Agosto-2007
			<input type=button class="botones_largo" value="Ver Grafica" onClick='window.open("image.php?rutaImagen=<?=$rutaImagen."&fechaH=".date("YmdHis")?>" , "Grafica Estadisticas - Orfeo", "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=560,height=720");' />
			-->
			<input type=button class="botones_largo" value="Ver Grafica" onClick='window.open("<?php print $ruta_raiz; ?>/estadisticas/image.php?rutaImagen=<?=$rutaImagen."&fechaH=".date("YmdHis")?>" , "Grafica Estadisticas - Orfeo", "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=560,height=720");' />
		<?php
		}
		else
		{
		?>
			<a href="<?php print $archivoCSV; ?>" class="botones_largo">Ver Archivo</a>
		<?php
		}
		?>
		</td>  	
  	</tr> 
  	</table>
<?
}
?>
</center>
</body>
</html>

