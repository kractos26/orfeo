<?php
if (!$ruta_raiz) $ruta_raiz= "..";
    include_once("$ruta_raiz/include/db/ConnectionHandler.php");
	$db = new ConnectionHandler("$ruta_raiz");
	if (!defined('ADODB_FETCH_ASSOC')) define('ADODB_FETCH_ASSOC',2);
   	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	//$db->conn->debug=true;
	include_once ("../include/query/busqueda/busquedaPiloto1.php");
	include_once "$ruta_raiz/include/tx/Historico.php";
    include_once ("$ruta_raiz/class_control/TipoDocumental.php");
    $trd = new TipoDocumental($db);
if ($borrar)
{		//Modificado skina
		$sqlE = "SELECT $radi_nume_radi as RADI_NUME_RADI
				 FROM SGD_RDF_RETDOCF r
				 WHERE RADI_NUME_RADI = '$nurad'
				       AND  SGD_MRD_CODIGO =  '$codiTRDEli'";
		$rsE=$db->conn->query($sqlE);
		$i=0;
		while(!$rsE->EOF)
		{
	    	$codiRegE[$i] = $rsE->fields['RADI_NUME_RADI'];
	    	$i++;
			$rsE->MoveNext();
		}
		$TRD = $codiTRDEli;
		include "$ruta_raiz/radicacion/detalle_clasificacionTRD.php";
	    $observa = "*Eliminado TRD*".$deta_serie."/".$deta_subserie."/".$deta_tipodocu;
		
		$Historico = new Historico($db);		  
  		//$radiModi = $Historico->insertarHistorico($codiRegE, $coddepe, $codusua, $coddepe, $codusua, $observa, 33); 
		$radiModi = $Historico->insertarHistorico($codiRegE, $dependencia, $codusuario, $dependencia, $codusuario, $observa, 33); 
		$radicados = $trd->eliminarTRD($nurad,$coddepe,$usua_doc,$codusua,$codiTRDEli);
		$mensaje="Archivo eliminado<br> ";
 	}
  /*
  * Proceso de modificación de una clasificación TRD
  */
  if ($modificar)
	{
  		if ($tdoc !=0 && $tsub !=0 && $codserie !=0 )
		{	//Modificado skina
			$sqlH = "SELECT $radi_nume_radi as RADI_NUME_RADI,
			        	SGD_MRD_CODIGO 
					FROM SGD_RDF_RETDOCF r
					WHERE RADI_NUME_RADI = '$nurad'
			    		AND  DEPE_CODI       =  '$coddepe'";
			$rsH=$db->conn->query($sqlH);
			$codiActu = $rsH->fields['SGD_MRD_CODIGO'];
			$i=0;
			while(!$rsH->EOF)
			{
	    		$codiRegH[$i] = $rsH->fields['RADI_NUME_RADI'];
	    		$i++;
				$rsH->MoveNext();
			}
			$TRD = $codiActu;
		    include "$ruta_raiz/radicacion/detalle_clasificacionTRD.php";
			
		  	$observa = "*Modificado TRD* ".$deta_serie."/".$deta_subserie."/".$deta_tipodocu;
  		  	$Historico = new Historico($db);		  
  		  	//$radiModi = $Historico->insertarHistorico($codiRegH, $coddepe, $codusua, $coddepe, $codusua, $observa, 32); 
			$radiModi = $Historico->insertarHistorico($codiRegH, $dependencia, $codusuario, $dependencia, $codusuario, $observa, 32); 
		  	/*
		  	*Actualiza el campo tdoc_codi de la tabla Radicados
		  	*/
		 	$radiUp = $trd->actualizarTRD($codiRegH,$tdoc);
			$mensaje="Registro Modificado";
			$isqlTRD = "select SGD_MRD_CODIGO 
					from SGD_MRD_MATRIRD 
					where DEPE_CODI = '$coddepe'
			 	   	and SGD_SRD_CODIGO = '$codserie'
			  		and SGD_SBRD_CODIGO = '$tsub'
			   	and SGD_TPR_CODIGO = '$tdoc'";
			
			$rsTRD = $db->conn->Execute($isqlTRD);
			$codiTRDU = $rsTRD->fields['SGD_MRD_CODIGO'];
			$sqlUA = "UPDATE SGD_RDF_RETDOCF SET SGD_MRD_CODIGO = '$codiTRDU',
					  USUA_CODI = '$codusua'
					  WHERE RADI_NUME_RADI = '$nurad' AND  DEPE_CODI =  '$coddepe'";
			$rsUp = $db->conn->query($sqlUA); 
            $mensaje="Registro Modificado   <br> ";

		}
		
}
		$tdoc = '';
		$tsub = '';
		$codserie = '';

?>
</script>
<body bgcolor="#FFFFFF" topmargin="0">
<br>
<div align="center">
<p>
<?=$mensaje?>
</p>
<input type='button' value='   Cerrar   ' class='botones_largo' onclick='opener.regresar();window.close();'>
</body>
</html> 
