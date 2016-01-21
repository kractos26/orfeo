<?php
	if (!$ruta_raiz) $ruta_raiz=".";
	include_once("$ruta_raiz/include/db/ConnectionHandler.php");
	require_once("$ruta_raiz/class_control/TipoDocumento.php");
	require_once("$ruta_raiz/config.php");
	if (!($db instanceof ConnectionHandler))
		$db = new ConnectionHandler("$ruta_raiz");
	//$db->conn->debug = true;
	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
	$objTipoDocto = new TipoDocumento($db);

	$nombre_us1 = "";$nombre_us2 = "";$nombre_us3 = "";
	$prim_apel_us1 = ""; $prim_apel_us2 = ""; $prim_apel_us3 = "";
	$seg_apel_us1 = ""; $seg_apel_us2 = ""; $seg_apel_us3 = "";

	if (!$ruta_raiz) $ruta_raiz=".";
	error_reporting(7);
	if(!$verradicado and $verrad) $verradicado = $verrad;

	if(!$verradicado) die("<!-- No viene un numero de radicado a buscar -->");
	include "$ruta_raiz/include/query/queryver_datosrad.php";

	//include_once("include/query/busqueda/busquedaPiloto1.php");

	$isql = "select a.*, $numero, $radi_nume_radi as RADI_NUME_RADI,
			$radi_nume_deri as RADI_NUME_DERI,
			a.SGD_SPUB_CODIGO AS NIVEL_SEGURIDAD
		FROM radicado a
		WHERE a.radi_nume_radi = $verradicado";

	$rs = $db->conn->Execute($isql);
	if ($rs->EOF)
		die ("<span class='titulosError'>No se ha podido obtener la informacion del radicado($isql)");

	if($menu_ver != 5) {
		$nombre = $rs->fields["RADI_NOMB"] . " " .
		$rs->fields["RADI_PRIM_APEL"] . " " .
		$rs->fields["RADI_SEGU_APEL"];
	}

	$radi_nume_iden=$rs->fields["RADI_NUME_IDEN"];
	$radi_fech_radi=$rs->fields["RADI_FECH_RADI"];
	$mrec_codi=$rs->fields["MREC_CODI"];
	$ra_asun = stripslashes($rs->fields["RA_ASUN"]);
	$radi_desc_anex = stripslashes($rs->fields["RADI_DESC_ANEX"]);
	$radi_rem =  $rs->fields["RADI_REM"];
	$radi_nume_hoja = TRIM($rs->fields["RADI_NUME_HOJA"]);
	$cuentai = $rs->fields["RADI_CUENTAI"];
	$radi_usua_ante = $rs->fields["RADI_USU_ANTE"];
	$radi_usua_actu = $rs->fields["RADI_USUA_ACTU"];
	$radi_depe_actu = $rs->fields["RADI_DEPE_ACTU"];
	$radi_depe_radicacion = substr($verradicado,4,3);
	$radi_depe_radi = $rs->fields["RADI_DEPE_RADI"];
	$radi_usua_radi = $rs->fields["RADI_USUA_RADI"];

	if($rs->fields["CARP_PER"]==1) {
		$personal="(personal)";
	} else {
		$personal=" ";
	}

	$carpeta_rad = $rs->fields["CARP_CODI"];
	$radi_nume_deri = $rs->fields["RADI_NUME_DERI"];
	$nivelRad = $rs->fields["SGD_SPUB_CODIGO"];
	$spubDepe = $rs->fields["SGD_SPUB_DEPE"];

	//El nivel de seguridad basico viene del radicado, pero si el Expediente en el que se encuentra tiene seguridad diferente de publico
	//Este determina el verdadero nivel de seguridad del radicado
	if($perm == 1 )
		$nivelRad = 1;
	
	$radi_tipo_deri = $rs->fields["RADI_TIPO_DERI"];
	$sector_grb = $rs->fields["PAR_SERV_SECUE"];
	$flujo_grb = $rs->fields["SGD_FLD_CODIGO"];
	$tema_grb = $rs->fields["SGD_TMA_CODIGO"];
	$radi_path = $rs->fields["RADI_PATH"];
	$sgd_tdes_codigo = $rs->fields["SGD_TDEC_CODIGO"];
	$fechaNotific = $rs->fields["RADI_FECH_NOTIF"];
	$sgd_apli_codi =  $rs->fields["SGD_APLI_CODI"];
	$tpdoc_rad = $rs->fields["TDOC_CODI"];
	$sgd_tres_codigo = $rs->fields["SGD_TRES_CODIGO"];
	//HLP $fechaNotific = $rs->fields["RADI_FECH_NOTIF"];
	$sgd_apli_codi =  $rs->fields["SGD_APLI_CODI"];

	if ($rs->fields["RADI_PATH"]){
		$imagenv = "<a  class='vinculos' href='seguridadImagen.php?fec=".base64_encode($rs->fields["RADI_PATH"]). "' target='$fechah'>Ver Imagen en Otra Ventana</a> ";
		} else {
			$imagenv = "No hay Imagen Disp.";
		}
	 	if ($radi_tipo_deri == 0) { $nombre_deri="ANEXO DE ";}
 	 	if ($radi_tipo_deri == 1) { $nombre_deri="COPIA DE ";}
	 	if ($radi_tipo_deri == 2) { $nombre_deri="ASOCIADO DE ";}
		$nurad	= $verradicado;
		$espcodi = $rs->fields["EESP_CODI"];

		include "$ruta_raiz/radicacion/busca_direcciones.php";


	 if($tipo_emp_us1>0){$datoos1 = "("; $datoos2 = ")";}else{$datoos1 = " "; $datoos2 = " ";}
	 $nombret_us1 = trim($nombre_us1) . " $datoos1 " . trim($prim_apel_us1) . " " . trim($seg_apel_us1) . " $datoos2";
	 if($tipo_emp_us2) {$datoos1 = "("; $datoos2 = ")";}else{$datoos1 = " " ; $datoos2 = " ";}
	 $nombret_us2 = trim($nombre_us2) . " $datoos1 " . trim($prim_apel_us2) . " " . trim($seg_apel_us2) . " $datoos2" ;
	 if(!is_null($tipo_emp_us3)){$datoos1 = "("; $datoos2 = ")";}else{$datoos1 = " "; $datoos2 = " ";}
	 $nombret_us3 = trim($nombre_us3) . " $datoos1 " . trim($prim_apel_us3) . " " . trim($seg_apel_us3) . " $datoos2" ;
	 $nombret_us1_u = trim($nombret_us1);
	 $nombret_us2_u = trim($nombret_us2);
	 $nombret_us3_u = trim($nombret_us3);
	 if($tipo_emp_us1>0){$nombret_us1_u = trim($nombre_us1);}
	 if($tipo_emp_us2>0){$nombret_us2_u = trim($nombre_us2);}
	 if($tipo_emp_us3>0){$nombret_us3_u = trim($nombre_us3);}
        include "$ruta_raiz/jh_class/funciones_sgd.php";
        $a = new LOCALIZACION($codep_us1,$muni_us1,$db);
        $dpto_nombre_us1 = $a->departamento;
        $muni_nombre_us1 = $a->municipio;
	if (!is_null($codep_us2))
	{	$a = new LOCALIZACION($codep_us2,$muni_us2,$db);
   		$dpto_nombre_us2 = $a->departamento;
   		$muni_nombre_us2 = $a->municipio;
	}
	if (!is_null($codep_us3))
	{	$a = new LOCALIZACION($codep_us3,$muni_us3,$db);
   		$dpto_nombre_us3 = $a->departamento;
   		$muni_nombre_us3 = $a->municipio;
	}
   if($carpeta==8) {$modificar="False"; $mostrar_opc_envio=1;}else {$modificar=="";}
   
    $datos_envio ="&dir_codigo_us1=$dir_codigo_us1&dir_codigo_us2=$dir_codigo_us2&dir_codigo_us3=$dir_codigo_us3";
    $datos_envio = str_replace("#","No.",$datos_envio);
	$mrec_codi?$mrec_codi=$mrec_codi:$mrec_codi='null';
    $isql = "select mrec_desc
		          from medio_recepcion
				  where
				  mrec_codi=$mrec_codi";
	$rs=$db->query($isql);
	if  (!$rs->EOF)
		$medio_recepcion = $rs->fields["MREC_DESC"];


	 // Extraccion de tipo de documento de la matriz
	 // Para mostrarla en el listado general.
	 // CODIGO QUE EXTRAE DE LA TABLA HMTD_ EL TIPO DE DOCUMENTO


if($sector_grb)
{
	$isql = "select PAR_SERV_NOMBRE FROM PAR_SERV_SERVICIOS where PAR_SERV_SECUE=$sector_grb ";
	$rs=$db->query($isql);
	if  (!$rs->EOF)
		$sector_nombre = $rs->fields["PAR_SERV_NOMBRE"];
}
if($flujo_grb)
{
    if($flujo) $flujo_grb = $flujo;
	$isql = "select SGD_FLD_DESC FROM SGD_FLD_FLUJODOC where SGD_FLD_CODIGO=$flujo_grb and sgd_tpr_codigo='$tdoc'";

	$rs=$db->query($isql);
	if  (!$rs->EOF)
		$flujo_nombre = $rs->fields["SGD_FLD_DESC"];
}

if($no_tipo!="true") {
	include_once("include/query/busqueda/busquedaPiloto1.php");
	// Clasificacion TRD
	$radi_nume_radi2 = str_replace("a.","r.",$radi_nume_radi);
	$isql = "SELECT $radi_nume_radi2 AS RADI_NUME_RADI,
			m.SGD_SRD_CODIGO,
			s.SGD_SRD_CODIGO,
			s.SGD_SRD_DESCRIP,
			su.SGD_SBRD_CODIGO,
			su.SGD_SBRD_DESCRIP,
			t.SGD_TPR_CODIGO,
			t.SGD_TPR_DESCRIP,
			t.sgd_tpr_termino
		FROM sgd_rdf_retdocf r,
			sgd_mrd_matrird m,
			sgd_srd_seriesrd s,
			sgd_sbrd_subserierd su,
			sgd_tpr_tpdcumento t
		WHERE r.sgd_mrd_codigo = m.sgd_mrd_codigo AND
			r.depe_codi='$dependencia' AND
			r.RADI_NUME_RADI = '$verradicado' AND
			s.sgd_srd_codigo = m.sgd_srd_codigo AND
			su.sgd_srd_codigo = m.sgd_srd_codigo AND
			su.sgd_sbrd_codigo = m.sgd_sbrd_codigo AND
			t.sgd_tpr_codigo = m.sgd_tpr_codigo";

	$rs = $db->query($isql);

	if (!$rs->EOF) {
		$cod_guardado = $rs->fields["SGD_SRD_CODIGO"];
		$tpdoc_grbTRD    = $rs->fields["SGD_TPR_CODIGO"];
		$tpdoc_nombreTRD = $rs->fields["SGD_TPR_DESCRIP"];
		$serie_grb    = $rs->fields["SGD_SRD_CODIGO"];
		$serie_nombre = $rs->fields["SGD_SRD_DESCRIP"];
		$subserie_grb = $rs->fields["SGD_SBRD_CODIGO"];
		$subserie_nombre = $rs->fields["SGD_SBRD_DESCRIP"];
		$termino_doc=$rs->fields["SGD_TPR_TERMINO"];
		
	} else {
		/* Modificacion por que generaba error se adiciono otra variable para no
		 * modificar radi_nume_radi
		 */
		$radi_nume_radi3 = str_replace("a.","r.",$radi_nume_radi);
		$isql = "SELECT $radi_nume_radi3 AS RADI_NUME_RADI,
				m.SGD_SRD_CODIGO,
				s.SGD_SRD_CODIGO,
				s.SGD_SRD_DESCRIP,
				su.SGD_SBRD_CODIGO,
				su.SGD_SBRD_DESCRIP,
				t.SGD_TPR_CODIGO,
				t.SGD_TPR_DESCRIP,
				t.sgd_tpr_termino
		 	FROM sgd_rdf_retdocf r,
				sgd_mrd_matrird m,
				sgd_srd_seriesrd s,
				sgd_sbrd_subserierd su,
				sgd_tpr_tpdcumento t
		  	WHERE r.sgd_mrd_codigo = m.sgd_mrd_codigo and
				r.RADI_NUME_RADI = '$verradicado' and
				s.sgd_srd_codigo = m.sgd_srd_codigo and
				su.sgd_srd_codigo = m.sgd_srd_codigo and
				su.sgd_sbrd_codigo = m.sgd_sbrd_codigo and
				t.sgd_tpr_codigo = m.sgd_tpr_codigo";

	  	$rs=$db->query($isql);

	  	if  (!$rs->EOF){
			$cod_guardado = $rs->fields["SGD_SRD_CODIGO"];
			$tpdoc_grbTRD = $rs->fields["SGD_TPR_CODIGO"];
			$tpdoc_nombreTRD = $rs->fields["SGD_TPR_DESCRIP"];
			$serie_grb    = $rs->fields["SGD_SRD_CODIGO"];
			$serie_nombre = $rs->fields["SGD_SRD_DESCRIP"];
			$subserie_grb = $rs->fields["SGD_SBRD_CODIGO"];
			$subserie_nombre = $rs->fields["SGD_SBRD_DESCRIP"];
			$termino_doc=$rs->fields["SGD_TPR_TERMINO"];
		}
	}

		$val_tpdoc_grbTRD = "$serie_nombre / $subserie_nombre/$tpdoc_nombreTRD";

		/*
		* Fin modificacion clasificacion TRD
		*/
		$isql = "select b.*,a.SGD_MTD_CODIGO,a.SGD_TPR_CODIGO
		          ,b.SGD_FUN_CODIGO,b.SGD_PRC_CODIGO,b.SGD_PRD_CODIGO
				  ,d.SGD_TPR_DESCRIP,e.SGD_FUN_DESCRIP,f.SGD_PRC_DESCRIP,g.SGD_PRD_DESCRIP

		          from sgd_mat_matriz b, sgd_mtd_matriz_doc a,sgd_hmtd_hismatdoc c,
				  sgd_tpr_tpdcumento d,sgd_fun_funciones e,sgd_prc_proceso f
				  ,sgd_prd_prcdmentos g
				  where
				  a.SGD_TPR_CODIGO=d.SGD_TPR_CODIGO and
				  b.SGD_FUN_CODIGO=e.SGD_FUN_CODIGO and
				  b.SGD_PRC_CODIGO=f.SGD_PRC_CODIGO and
				  b.SGD_PRD_CODIGO=g.SGD_PRD_CODIGO and
				  c.radi_nume_radi=$verradicado and c.sgd_mtd_codigo=a.sgd_mtd_codigo and
				  a.sgd_mat_codigo=b.sgd_mat_codigo
				  order by sgd_hmtd_fecha desc";
	  	$rs=$db->query($isql);
	if  (!$rs->EOF){
		$cod_guardado = $rs->fields["SGD_MTD_CODIGO"];
		$tpdoc_grb = $rs->fields["SGD_TPR_CODIGO"];
		$tpdoc_nombre = $rs->fields["SGD_TPR_DESCRIP"];
		$funciones_grb = $rs->fields["SGD_FUN_CODIGO"];
		$funcion_nombre = $rs->fields["SGD_FUN_DESCRIP"];
		$procesos_grb = $rs->fields["SGD_PRC_CODIGO"];
		$proceso_nombre = $rs->fields["SGD_PRC_DESCRIP"];
		$procedimientos_grb = $rs->fields["SGD_PRD_CODIGO"];
		$procedimiento_nombre = $rs->fields["SGD_PRD_DESCRIP"];

	}
		$val_tpdoc_grb = "$tpdoc_nombre / $funcion_nombre / $proceso_nombre / $procedimiento_nombre";
		if(!$tpdoc_nombre and $tdoc)
		{
		$isql = "select a.SGD_TPR_CODIGO
		          ,a.SGD_TPR_DESCRIP, a.SGD_TPR_TERMINO
		          from sgd_tpr_tpdcumento a
				  where
				  a.SGD_TPR_CODIGO=$tdoc";
		$rs=$db->query($isql);
		if  (!$rs->EOF)
			$tpdoc_nombre = $rs->fields["SGD_TPR_DESCRIP"];
			$termino_doc = $rs->fields["SGD_TPR_TERMINO"];

		}
	//--------------------------departamento / municipio

	if(!$tpdoc)
	{
	   $tpdoc = $tpdoc_grb;
	   if (!$funciones) $funciones = $funciones_grb;
	   if (!$procesos) $procesos = $procesos_grb;
	   if (!$procedimientos) $procedimientos = $procedimientos_grb;
	}
// FIN CODIGO EXTR. TIPO DOC GRABADO EN BD
// INICIO DE EXTRACCION DE CAUSALES
//
	 if(!$procesos) {$procesos=0;}
	 if(!$procedimientos) {$procedimientos=0;}
	 if(!$funciones) {$funciones=0;}
	 $isql = "select b.*,a.SGD_MTD_CODIGO from sgd_mat_matriz b, sgd_mtd_matriz_doc a
	          where b.depe_codi=$dependencia and a.sgd_mat_codigo=b.sgd_mat_codigo and
                  b.sgd_fun_codigo=$funciones and b.sgd_prc_codigo=$procesos and
		  b.sgd_prd_codigo=$procedimientos ";
	 $rs=$db->query($isql);
	 if  (!$rs->EOF)
	 		$cod_tmp = $rs->fields["SGD_MTD_CODIGO"];

 // EXTRAE LA CAUSAL DEL DOCUMENTO

		$isql = "select a.*,b.SGD_CAU_CODIGO,
		          b.SGD_DCAU_DESCRIP
		          from SGD_CAUX_CAUSALES a,SGD_DCAU_CAUSAL b
				  where
				  a.SGD_DCAU_CODIGO=b.SGD_DCAU_CODIGO and a.radi_nume_radi=$verrad
				 ";

   $rs=$db->query($isql);
	 if  (!$rs->EOF) {
		$causal_grb = $rs->fields["SGD_CAU_CODIGO"];
		$deta_causal_grb = $rs->fields["SGD_DCAU_CODIGO"];
		$dcausal_nombre = $rs->fields["SGD_DCAU_DESCRIP"];
  	$ddcausal_grb = $rs->fields["SGD_DDCA_CODIGO"];
	 }

	 if($ddcausal_grb)
	    {
		$isql = "select a.SGD_DDCA_DESCRIP,a.SGD_DDCA_CODIGO
		          from SGD_DDCA_DDSGRGDO  a
				  where
				  a.SGD_DDCA_CODIGO=$ddcausal_grb
				 ";
		 $rs=$db->query($isql);
		 if  (!$rs->EOF)
				$ddcausal_nombre = $rs->fields["SGD_DDCA_DESCRIP"];
	    }
		if($causal_grb)
	    {
		$isql = "select a.SGD_CAU_DESCRIP,a.SGD_CAU_CODIGO
		          from SGD_CAU_CAUSAL  a
				  where
				  a.SGD_CAU_CODIGO=$causal_grb
				 ";
	 $rs=$db->query($isql);
	 if  (!$rs->EOF)
	 	$causal_nombre = $rs->fields["SGD_CAU_DESCRIP"];
		}
	if(!$causal)
	{
	  $causal= $causal_grb;
	}
	if(!$deta_causal)
	{
	  $deta_causal= $deta_causal_grb;
	}
	if(!$ddca_causal)
	{
	  $ddca_causal= $ddca_causal_grb;
	}

//  FIN EXTRACCION DE CAUSALES

 // Si no viene tema coloca el que se ha grabado en el DOCUMENTO
 // Luegolo extrae el nombre de la BD

 if($tema_grb)
{
	$isql = "select a.SGD_TMA_DESCRIP FROM SGD_TMA_TEMAS a, SGD_TMD_TEMADEPE b where b.depe_codi=$dependencia and a.sgd_tma_codigo=$tema_grb ";
	$rs=$db->query($isql);
	if  (!$rs->EOF)
		$tema_nombre = $rs->fields["SGD_TMA_DESCRIP"];
}
if(!$tema)
{
  $tema= $tema_grb;

}

if(!$sector)
{
  $sector= $sector_grb;

}


//BUSCA POSIBLES DATOS RELACIONADOS CON SANCIONADOS
if ( $sgd_apli_codi )
{
	$isql = "select * from SGD_TDEC_TIPODECISION where SGD_APLI_CODI=1  and SGD_TDEC_CODIGO = $sgd_tdes_codigo ";
	$rs=$db->query($isql);
	if  (!$rs->EOF){
	 	$sgd_tdes_descrip = $rs->fields["SGD_TDEC_DESCRIP"];
	 	$sgd_tdec_versancion = $rs->fields["SGD_TDEC_VERSANCION"];
	 	$sgd_tdec_firmeza = $rs->fields["SGD_TDEC_FIRMEZA"];

	}
}

//Busca si esiste notificaci�n para este radicado
$sqlNotif="select * from SGD_NTRD_NOTIFRAD where radi_nume_radi = $verradicado";
$rs=$db->query($sqlNotif);

if ($rs && !$rs->EOF )
{
	$tipoNotific=$rs->fields['SGD_NOT_CODI'];
	$tNotNotifica = $rs->fields["SGD_NTRD_NOTIFICADOR"];
	$tNotNotificado = $rs->fields["SGD_NTRD_NOTIFICADO"];
	$tFechNot = $rs->fields["SGD_NTRD_FECHA_NOT"];
	$tFechFija = $rs->fields["SGD_NTRD_FECHA_FIJA"];
	$tFechDesFija = $rs->fields["SGD_NTRD_FECHA_DESFIJA"];
	$tNotEdicto = $rs->fields["SGD_NTRD_NUM_EDICTO"];
	$tNotObserva = $rs->fields["SGD_NTRD_OBSERVACIONES"];
	$isql = "select * from SGD_NOT_NOTIFICACION  where SGD_NOT_CODI = $tipoNotific ";
	$rs=$db->query($isql);

	if  (!$rs->EOF){
	 	$tipoNotDesc = $rs->fields["SGD_NOT_DESCRIP"];
	 	$tipoNotUpdnotif = $rs->fields["SGD_TDEC_UPDNOTIF"];

	}


}
	include_once ("$ruta_raiz/include/tx/Expediente.php");
	$trdExp = new Expediente($db);
	$numExpediente = $trdExp->consulta_exp("$verrad");
	$mrdCodigo = $trdExp->consultaTipoExpediente($numExpediente);
	$trdExpediente= $trdExp->descSerie." / ".$trdExp->descSubSerie;
	$descPExpediente = $trdExp->descTipoExp;
	$codserie = $trdExp->codiSRD;
	$tsub = $trdExp->codiSBRD;
	$tdoc = $trdExp->codigoTipoDoc;
	$texp = $trdExp->codigoTipoExp;
	$descFldExp = $trdExp->descFldExp;
	$codigoFldExp = $trdExp->codigoFldExp;
	$expUsuaDoc = $trdExp->expUsuaDoc;
	//unset($verradicado);
}
?>
