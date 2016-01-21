<?php
$isEditMTD = (isset($_POST['isEditMTD']) ? $_POST['isEditMTD'] : ($_GET['isEditMTD'] ? $_GET['isEditMTD'] : 0));
//Contar si existe clasificacion metadatos para la subserie/tipoDoc seleccionada
$sql = "SELECT COUNT(SGD_MTD_CODIGO) FROM SGD_MTD_METADATOS m ";
if ($metadatosAmostrar=='S' && !empty($idSerie) && !empty($idSSerie)) {
	$sql .= " where m.sgd_mtd_estado=1 and m.sgd_srd_codigo=".$idSerie." and sgd_sbrd_codigo=".$idSSerie;
	$cnt = $db->conn->GetOne($sql);
}
if ($metadatosAmostrar=='T' && !empty($idTdoc)) {
	$sql .= " where m.sgd_mtd_estado=1 and m.sgd_tpr_codigo=".$idTdoc;
	$cnt = $db->conn->GetOne($sql);
}

//Si existe clasificación requerida o se está editando se mostrará pantalla sin/con datos respectivamente. 
if ($cnt || $isEditMTD) {
	$sql = "select m.sgd_mtd_codigo AS IDM, m.sgd_mtd_nombre AS NOMBRE, m.sgd_mtd_descrip AS DESCRIP, s.sgd_mmr_dato AS DATOS 
			from sgd_mtd_metadatos m ";
	if ($registrosAmostrar == 'R') {
			$tabla = "sgd_mmr_matrimetaradi";
			$campo = "radi_nume_radi";
			$cod = $nurad;
			$border=0;
	} else { 
			$tabla = "sgd_mmr_matrimetaexpe";
			$campo = "sgd_exp_numero";
			$cod = "'$numExpediente'";
			$border=1;
	}

	//contar los radicados con metadatos...
	if ($cnt) {
		//SI no hay ===> Se muestra la pantalla de captura con datos en blanco
		// por eso el INNER
		$sql .=" inner join $tabla s on s.sgd_mtd_codigo = m.sgd_mtd_codigo and s.$campo=$cod";
	} else {
		//Si está editando ===> Se muestra la pantalla de captura con datos gestionados.
		// por eso el LEFT
		$sql .=" left join $tabla s on s.sgd_mtd_codigo = m.sgd_mtd_codigo and s.$campo=$cod";
	}
	
	if ($metadatosAmostrar=='S') {
		$sql .= " where  m.sgd_mtd_estado=1 and m.sgd_srd_codigo=".$idSerie." and sgd_sbrd_codigo=".$idSSerie;
	} else {
		$sql .= " where  m.sgd_mtd_estado=1 and m.sgd_tpr_codigo=".$idTdoc;
	}
	$ADODB_COUNTRECS = true;
	$rsmtd = $db->conn->query($sql);

	if ($cnt && $rsmtd->RecordCount()==0) {
		$sql = str_replace("inner", "left", $sql);
		$rsmtd = $db->conn->query($sql);
		$mostrar = true;
	}
	$ADODB_COUNTRECS = false;
	if ($mostrar || $isEditMTD) {
		$tablamtd = "<table border='$border' width='100%' align='center' class='borde_tab' cellspacing='0'>
				<tr align='center' class='titulos2'>
					<td colspan='2' height='15' class='titulos2'>METADATOS</td>
				</tr>";
		while (!$rsmtd->EOF) {
			$dato = is_null($rsmtd->fields['DATOS']) ? $_POST['txt_mtd_'.$rsmtd->fields['IDM']] : $rsmtd->fields['DATOS'];
			$tablamtd .= "<tr>
						<td class='titulos5' width='15%'>".$rsmtd->fields['NOMBRE']."</td>
						<td class='listado5'><input type='text' name='txt_mtd_".$rsmtd->fields['IDM']."' maxlength='300' size='50' value='".$dato."'></td>
						</tr>";
			$rsmtd->MoveNext();
		}
		$tablamtd .= "</table><br/>";
		echo $tablamtd;
	}
}
echo "<input name='isEditMTD' id='isEditMTD' type='hidden' value='$isEditMTD'>";
?>