<?php
 if($actu_mtrd && $coddepe !=0 && $codserie !=0 && $tsub !=0)
{
    $num = count($checkValue);
	$i = 0;
	while ($i < $num)
	{
	 $record_id = key($checkValue);
	 $radicados_asig .= $record_id .",";
	 $radicados_sel = $record_id;
	 $chkt = $radicados_sel;
	 $isqlB = "select t.sgd_tpr_codigo as CODIGO
	         from sgd_mrd_matrird m, sgd_tpr_tpdcumento t
			 where m.depe_codi = '$coddepe'
 			       and m.sgd_srd_codigo = '$codserie'
			       and m.sgd_sbrd_codigo = '$tsub'
				   and m.sgd_tpr_codigo = t.sgd_tpr_codigo
				   and t.sgd_tpr_codigo = '$chkt'
			 ";
			 $rs = $db->query($isqlB); # Executa la busqueda y obtiene el registro a actualizar.
			  $radiNumero = $rs->fields["SGD_TPR_CODIGO"];
	          if ($radiNumero !='') {
			 	}else
			 	{
					$isqlCount = "select max(sgd_mrd_codigo) as NUMREGT from sgd_mrd_matrird";
					$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
			   		$rsC = $db->query($isqlCount);
					$numreg = $rsC->fields["NUMREGT"];
					$numreg = $numreg+1;
					$record = array(); # Inicializa el arreglo que contiene los datos a insertar
		
					$record["SGD_MRD_CODIGO"] = $numreg;
					$record["DEPE_CODI"]      = $coddepe;
					$record["SGD_SRD_CODIGO"] = $codserie;
					$record["SGD_SBRD_CODIGO"]= $tsub;
					$record["SGD_TPR_CODIGO"] = $chkt;
					$record["SOPORTE"] = $med;
					$record["SGD_MRD_ESTA"] = '1';
					$record["SGD_MRD_FECHINI"] = $db->conn->OffsetDate(0);
					$insertSQL = $db->insert("SGD_MRD_MATRIRD", $record, "true");
					//echo $insertSQL;
				}
	 next($checkValue);
	$i++;
	}
}
?>