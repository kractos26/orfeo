<?php
session_start();
$ruta_raiz = "../";
if (!isset($_SESSION['dependencia']))
    die(include "$ruta_raiz/errorAcceso.php");
include("$ruta_raiz/config.php");    // incluir configuracion.
if (!$nurad)
    $nurad = $rad;

$ent = substr($nurad, -1);

if (!defined('ADODB_FETCH_ASSOC'))
    define('ADODB_FETCH_ASSOC', 2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug=TRUE;

include_once ("$ruta_raiz/include/tx/Historico.php");
include_once ("$ruta_raiz/class_control/TipoDocumental.php");
include_once ("$ruta_raiz/include/tx/Expediente.php");
require ("$ruta_raiz/include/class/metadatos.class.php");

$coddepe = $_SESSION['dependencia'];
$codusua = $_SESSION['codusuario'];

// PARTE DE CODIGO DONDE SE IMPLEMENTA EL CAMBIO DE ESTADO AUTOMATICO AL TIPIFICAR.
include ("$ruta_raiz/include/tx/Flujo.php");

if ($db) {
    $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
    if (isset($_POST['btn_accion'])) {
    	include_once ("../include/query/busqueda/busquedaPiloto1.php");
    	$trd = new TipoDocumental($db);
        switch ($_POST['btn_accion']) {
            Case 'Insertar': {
                    if ($_POST['slc_tdoc'] != 0 && $_POST['slc_sbrd'] != 0 && $_POST['slc_srd'] != 0) {
                        $sql = "SELECT COUNT(RADI_NUME_RADI) AS CNT 
			FROM SGD_RDF_RETDOCF r 
			WHERE RADI_NUME_RADI = $nurad
				AND DEPE_CODI = " . $_SESSION['dependencia'];
                        if ($db->conn->GetOne($sql) > 0) {
                            $error = 6;
                        } else {
                            $isqlTRD = "select SGD_MRD_CODIGO 
                                from SGD_MRD_MATRIRD 
								where DEPE_CODI = " . $_SESSION['dependencia'] .
                                    " and SGD_SRD_CODIGO = " . $_POST['slc_srd'] .
                                    " and SGD_SBRD_CODIGO = " . $_POST['slc_sbrd'] .
                                    " and SGD_TPR_CODIGO = " . $_POST['slc_tdoc'];
                            $rsTRD = $db->conn->Execute($isqlTRD);
                            $i = 0;
                            while (!$rsTRD->EOF) {
                                $codiTRDS[$i] = $rsTRD->fields['SGD_MRD_CODIGO'];
                                $codiTRD = $rsTRD->fields['SGD_MRD_CODIGO'];
                                $i++;
                                $rsTRD->MoveNext();
                            }
                            $radicados = $trd->insertarTRD($codiTRDS, $codiTRD, $nurad, $coddepe, $codusua);
                            $TRD = $codiTRD;
                            include "$ruta_raiz/radicacion/detalle_clasificacionTRD.php";
                            //Modificado skina
                            $sqlH = "SELECT $radi_nume_radi as RADI_NUME_RADI
				FROM SGD_RDF_RETDOCF r 
				WHERE r.RADI_NUME_RADI = $nurad
				AND r.SGD_MRD_CODIGO = $codiTRD";
                            $rsH = $db->conn->query($sqlH);
                            $i = 0;
                            while (!$rsH->EOF) {
                                $codiRegH[$i] = $rsH->fields['RADI_NUME_RADI'];
                                $i++;
                                $rsH->MoveNext();
                            }
                            $observa = "*Insercion TRD/METADATOS*." . $rsTRD->fields['SERIE'] . "/" . $rsTRD->fields['SUBSERIE'] . "/" . $rsTRD->fields['TIPO_DOCUMENTO'];
                            $Historico = new Historico($db);
                            //$radiModi = $Historico->insertarHistorico($codiRegH, $coddepe, $codusua, $coddepe, $codusua, $observa, 32); 
                            $radiModi = $Historico->insertarHistorico($codiRegH, $dependencia, $codusuario, $dependencia, $codusuario, $observa, 32);
                            /*
                             * Actualiza el campo tdoc_codi de la tabla Radicados
                             */
                            $radiUp = $trd->actualizarTRD($codiRegH, $_POST['slc_tdoc']);

                            $codserie = 0;
                            $tsub = 0;
                            $tdoc = 0;
                            $error = 3;

                            /*                             * *************************** INSERTAR METADATOS ***************** */
                            $db->conn->StartTrans();
                            $tablaACT = "SGD_MMR_MATRIMETARADI";
                            $r['RADI_NUME_RADI'] = $_POST['nurad'];
                            foreach ($_POST as $k => $v) {
                                if (substr($k, 0, 8) == "txt_mtd_") {
                                    $idMtd = substr($k, 8);
                                    $r['SGD_MTD_CODIGO'] = $idMtd;
                                    $r['SGD_MMR_DATO'] = $_POST['txt_mtd_' . $idMtd];
                                    $db->conn->Replace(&$tablaACT, $r, array('RADI_NUME_RADI', 'SGD_MTD_CODIGO'), true);
                                }
                            }
                            $ok = $db->conn->CompleteTrans();
                            /*                             * ****************************************************************** */
                        }
                    }
                }break;
            Case 'Modificar': {
                    /*                     * *******************  MODIFICAR TIPIFICACION ******************** */
                    if ($_POST['slc_tdoc'] != 0 && $_POST['slc_sbrd'] != 0 && $_POST['slc_srd'] != 0) { //Modificado skina
                        $sqlH = "SELECT $radi_nume_radi as RADI_NUME_RADI,
					        	SGD_MRD_CODIGO 
							FROM SGD_RDF_RETDOCF r
							WHERE RADI_NUME_RADI = $nurad
					    		AND  DEPE_CODI = $coddepe";
                        $rsH = $db->conn->query($sqlH);
                        $codiActu = $rsH->fields['SGD_MRD_CODIGO'];
                        $i = 0;
                        while (!$rsH->EOF) {
                            $codiRegH[$i] = $rsH->fields['RADI_NUME_RADI'];
                            $i++;
                            $rsH->MoveNext();
                        }
                        $TRD = $codiActu;
                        include "$ruta_raiz/radicacion/detalle_clasificacionTRD.php";

                        $observa = "*Modificado TRD/METADATOS* " . $deta_serie . "/" . $deta_subserie . "/" . $deta_tipodocu;
                        $Historico = new Historico($db);
                        //$radiModi = $Historico->insertarHistorico($codiRegH, $coddepe, $codusua, $coddepe, $codusua, $observa, 32); 
                        $radiModi = $Historico->insertarHistorico($codiRegH, $dependencia, $codusuario, $dependencia, $codusuario, $observa, 32);
                        /*
                         * Actualiza el campo tdoc_codi de la tabla Radicados
                         */
                        $tdoc=$_POST['slc_tdoc'];
                        $radiUp = $trd->actualizarTRD($codiRegH, $tdoc);
                        $mensaje = "Registro Modificado";
                        $isqlTRD = "select SGD_MRD_CODIGO 
				from SGD_MRD_MATRIRD 
				where DEPE_CODI = $coddepe
				and SGD_SRD_CODIGO = " . $_POST['slc_srd'] .
                                " and SGD_SBRD_CODIGO = " . $_POST['slc_sbrd'] .
                                " and SGD_TPR_CODIGO = " . $_POST['slc_tdoc'];

                        $rsTRD = $db->conn->Execute($isqlTRD);
                        $codiTRDU = $rsTRD->fields['SGD_MRD_CODIGO'];
                        $sqlUA = "UPDATE SGD_RDF_RETDOCF SET SGD_MRD_CODIGO = $codiTRDU,
				USUA_CODI = $codusua
				WHERE RADI_NUME_RADI = $nurad AND DEPE_CODI = $coddepe";
                        $rsUp = $db->conn->query($sqlUA);
                        $mensaje = "Registro Modificado   <br> ";
                    }
                    /*                     * ***************************************************************** */

                    /*                     * *************************** MODIFICAR METADATOS ***************** */
                    $db->conn->StartTrans();
                    $tabla_mmr = "SGD_MMR_MATRIMETARADI";
                    $r['RADI_NUME_RADI'] = $_POST['nurad'];
                    foreach ($_POST as $k => $v) {
                        if (substr($k, 0, 8) == "txt_mtd_") {
                            $idMtd = substr($k, 8);
                            $r['SGD_MTD_CODIGO'] = $idMtd;
                            $r['SGD_MMR_DATO'] = $_POST['txt_mtd_' . $idMtd];
                            $db->conn->Replace(&$tabla_mmr, $r, array('RADI_NUME_RADI', 'SGD_MTD_CODIGO'), true);
                        }
                    }
                    $ok = $db->conn->CompleteTrans();
                    /*                     * ****************************************************************** */
                    $ok ? $error = 4 : $error = 2;
                }break;
            Case 'Borrar': {
            	$db->conn->StartTrans();
            	$sql = "DELETE FROM SGD_MMR_MATRIMETARADI WHERE RADI_NUME_RADI=$nurad AND SGD_MTD_CODIGO IN
            			(SELECT SGD_MTD_CODIGO FROM SGD_MTD_METADATOS WHERE SGD_TPR_CODIGO=".$_POST['slc_tdoc'].")";
            	$db->conn->query($sql);
            	
            	$sql = "SELECT SGD_MRD_CODIGO FROM SGD_MRD_MATRIRD WHERE DEPE_CODI=$coddepe  AND SGD_SRD_CODIGO=".$_POST['slc_srd']." AND SGD_SBRD_CODIGO=".$_POST['slc_sbrd']." AND SGD_TPR_CODIGO=".$_POST['slc_tdoc']." AND SGD_MRD_ESTA='1'";
            	$codiTRDEli = $db->conn->GetOne($sql);
            	
		$sqlE = "SELECT $radi_nume_radi as RADI_NUME_RADI
				 FROM SGD_RDF_RETDOCF r
				 WHERE RADI_NUME_RADI = $nurad
				       AND  SGD_MRD_CODIGO = $codiTRDEli";
		
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
	    $observa = "*Eliminado TRD/METADATOS*".$deta_serie."/".$deta_subserie."/".$deta_tipodocu;
		$trd = new TipoDocumental($db);
		$Historico = new Historico($db);		  
  		$radiModi = $Historico->insertarHistorico($codiRegE, $coddepe, $codusua, $coddepe, $codusua, $observa, 33); 
		$radicados = $trd->eliminarTRD($nurad,$coddepe,$usua_doc,$codusua,$codiTRDEli);
		$mensaje="Archivo eliminado<br> ";
		$ok = $db->conn->CompleteTrans();
                if ($ok) {
                    unset($_POST['slc_sbrd']);
                    unset($_POST['slc_tdoc']);
                } else $error = 5;
                }break;
            Default: break;
        }
    }

    $ADODB_COUNTRECS = true;
    //************************************ Verificamos tipificacion PREVIA ***************************/
    $sqlFechaDocto = $db->conn->SQLDate("Y-m-D H:i:s A", "mf.sgd_rdf_fech");
    $sqlSubstDescS = $db->conn->substr . "(s.sgd_srd_descrip, 0, 30)";
    $sqlSubstDescSu = $db->conn->substr . "(su.sgd_sbrd_descrip, 0, 30)";
    $sqlSubstDescT = $db->conn->substr . "(t.sgd_tpr_descrip, 0, 30)";
    $sqlSubstDescD = $db->conn->substr . "(d.depe_nomb, 0, 30)";

    include "$ruta_raiz/include/query/trd/querylista_tiposAsignados.php";
    $isqlC = "select $sqlConcat AS CODIGO,
                    $sqlSubstDescS AS SERIE,
                    $sqlSubstDescSu AS SUBSERIE,
                    $sqlSubstDescT AS TIPO_DOCUMENTO,
                    $sqlSubstDescD AS DEPENDENCIA,
                    m.sgd_mrd_codigo AS CODIGO_TRD,
                    mf.usua_codi AS USUARIO,
                    mf.depe_codi AS DEPE,
                    s.sgd_srd_codigo AS IDSERIE,
                    su.sgd_sbrd_codigo AS IDSSERIE,
                    t.sgd_tpr_codigo AS IDTDOC
                from SGD_RDF_RETDOCF mf,
                    SGD_MRD_MATRIRD m,
                    DEPENDENCIA d,
                    SGD_SRD_SERIESRD s,
                    SGD_SBRD_SUBSERIERD su, 
                    SGD_TPR_TPDCUMENTO t
                where d.depe_codi = mf.depe_codi 
	   			and s.sgd_srd_codigo  = m.sgd_srd_codigo 
	   			and su.sgd_sbrd_codigo = m.sgd_sbrd_codigo 
				and su.sgd_srd_codigo = m.sgd_srd_codigo
	  			and t.sgd_tpr_codigo  = m.sgd_tpr_codigo
	   			and mf.sgd_mrd_codigo = m.sgd_mrd_codigo
			    and mf.radi_nume_radi = $nurad";
    $rsC = $db->query($isqlC);
    if ($rsC->RecordCount() > 0) {
        $dserie = $rsC->fields["IDSERIE"];
        $dsubser = $rsC->fields["IDSSERIE"];
        $dtipodo = $rsC->fields["IDTDOC"];
    } else {
        $dserie = 0;
        $dsubser = '';
        $dtipodo = '';
    }
    /*     * *************************************************************************************************** */
    $idSerie = isset($_POST['slc_srd']) ? $_POST['slc_srd'] : $dserie;
    $idSSerie = isset($_POST['slc_sbrd']) ? $_POST['slc_sbrd'] : $dsubser;
    $idTdoc = isset($_POST['slc_tdoc']) ? $_POST['slc_tdoc'] : $dtipodo;
    /*     * ** */
    $nomb_varc = "s.sgd_srd_codigo";
    $nomb_varde = "s.sgd_srd_descrip";
    include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
    $sql = "select distinct ($sqlConcat) as detalle, s.sgd_srd_codigo 
            from sgd_mrd_matrird m, sgd_srd_seriesrd s
            where m.depe_codi = " . $_SESSION['dependencia'] .
            " and s.sgd_srd_codigo = m.sgd_srd_codigo
                  and " . $sqlFechaHoy . " between $sgd_srd_fechini and $sgd_srd_fechfin AND SGD_MRD_ESTA='1' AND SGD_MRD_ESTA='1'order by detalle";
    $rs = $db->conn->Execute($sql);
    $slc_srd = $rs->GetMenu2('slc_srd', $idSerie, "0:&gt; Seleccione SERIE &lt;", false, 0, "class='select' id='slc_srd' onchange='this.form.submit()'");

//    if (!(empty($idSSerie))) {
        $nomb_varc = "su.sgd_sbrd_codigo";
        $nomb_varde = "su.sgd_sbrd_descrip";
        include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
        $sql = "select distinct ($sqlConcat) as detalle, su.sgd_sbrd_codigo
            from sgd_mrd_matrird m, sgd_sbrd_subserierd su
            where m.depe_codi = " . $_SESSION['dependencia'] .
                " and m.sgd_srd_codigo = " . $idSerie .
                " and su.sgd_srd_codigo = " . $idSerie .
                " and su.sgd_sbrd_codigo = m.sgd_sbrd_codigo
                  and " . $sqlFechaHoy . " between $sgd_sbrd_fechini and $sgd_sbrd_fechfin and SGD_MRD_ESTA='1'
            order by detalle";
        $rss = $db->conn->Execute($sql);
        $slc_sbrd = $rss->GetMenu2('slc_sbrd', $idSSerie, ":", false, 0, "class='select' id='slc_sbrd' onchange='this.form.submit()'");
//    } else {
//        $slc_sbrd = "<select><option></option></select>";
//    }
    
    if (!empty($idSerie) && !empty($idSSerie)) {
        $nomb_varc = "t.sgd_tpr_codigo";
        $nomb_varde = "t.sgd_tpr_descrip";
        include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
        $sql = "select distinct ($sqlConcat) as detalle, t.sgd_tpr_codigo, t.sgd_tpr_descrip
            from sgd_mrd_matrird m, sgd_tpr_tpdcumento t
            where m.depe_codi = " . $_SESSION['dependencia'] .
                " and m.sgd_mrd_esta = '1'
              and m.sgd_srd_codigo = " . $idSerie .
                " and m.sgd_sbrd_codigo = " . $idSSerie .
                " and t.sgd_tpr_codigo = m.sgd_tpr_codigo
              and t.sgd_tpr_tp$ent='1' order by sgd_tpr_descrip";
        $rst = $db->conn->Execute($sql);
        $slc_tdoc = $rst->GetMenu2('slc_tdoc', $idTdoc, ":", false, 0, " $deshab_tdoc class='select' id='slc_tdoc' onchange='this.form.submit()'");
    } else {
        $slc_tdoc = "<select><option></option></select>";
    }
    $ADODB_COUNTRECS = false;

    $trd = new TipoDocumental($db);
    $trdExp = new Expediente($db);
    $numExpediente = $trdExp->consulta_exp("$nurad");
    $mrdCodigo = $trdExp->consultaTipoExpediente("$numExpediente");
    $trdExpediente = $trdExp->descSerie . " / " . $trdExp->descSubSerie;
    $descPExpediente = $trdExp->descTipoExp;
    $descFldExp = $trdExp->descFldExp;
    $codigoFldExp = $trdExp->codigoFldExp;
    $expUsuaDoc = $trdExp->expUsuaDoc;
    if (!is_null($texp) && $texp > 0) {
        $objFlujo = new Flujo($db, $texp, $usua_doc);
        $expEstadoActual = $objFlujo->actualNodoExpediente($numExpediente);
        $arrayAristas = $objFlujo->aristasSiguiente($expEstadoActual);
        $aristaSRD = $objFlujo->aristaSRD;
        $aristaSBRD = $objFlujo->aristaSBRD;
        $aristaTDoc = $objFlujo->aristaTDoc;
        $aristaTRad = $objFlujo->aristaTRad;
        $arrayNodos = $objFlujo->nodosSig;
        $aristaAutomatica = $objFlujo->aristaAutomatico;
        $aristaTDoc = $objFlujo->aristaTDoc;
        if ($arrayNodos) {
            $i = 0;
            foreach ($arrayNodos as $value) {
                $nodo = $value;
                $arAutomatica = $aristaAutomatica[$i];
                $aristaActual = $arrayAristas[$i];
                $arSRD = $aristaSRD[$i];
                $arSBRD = $aristaSBRD[$i];
                $arTDoc = $aristaTDoc[$i];
                $arTRad = $aristaTRad[$i];
                $nombreNodo = $objFlujo->getNombreNodo($nodo, $texp);
                if ($arAutomatica == 1 and $arSRD == $codserie and $arSBRD == $tsub and $arTDoc == $tdoc and $arTRad == $ent) {
                    if ($insertar_registro) {
                        $objFlujo->cambioNodoExpediente($numExpediente, $nurad, $nodo, $aristaActual, $arAutomatica, "Cambio de Estado Automatico.($nombreNodo)", $texp);
                        $codiTRDS = $codiTRD;
                        $i++;
                        $TRD = $codiTRD;
                        $observa = "*TRD*" . $codserie . "/" . $codiSBRD . " (Creacion de Expediente.)";
                        include_once "$ruta_raiz/include/tx/Historico.php";
                        $radicados = $nurad;
                        $tipoTx = 51;
                        $Historico = new Historico($db);
                        $rs = $db->query($sql);
                        $mensaje = "SE REALIZO CAMBIO DE ESTADO AUTOMATICAMENTE AL EXPEDIENTE No. < $numExpediente > <BR>
				   			 EL NUEVO ESTADO DEL EXPEDIENTE ES  <<< $nombreNodo >>>";
                    } else {
                        $mensaje = "SI ESCOGE ESTE TIPO DOCUMENTAL EL ESTADO DEL EXPEDIENTE  < $numExpediente > 
							 CAMBIARA EL ESTADO AUTOMATICAMENTE A <BR> <<< $nombreNodo >>>";
                    }
                    echo "<table width=100% class=borde_tab>
						<tr><td align=center>
						<span class=titulosError align=center>
						$mensaje
						</span>
						</td></tr>
						</table><TABLE><TR><TD></TD></TR></TABLE>";
                }
                $i++;
            }
        }
    }
} else {
    $error = 6;
    $slc_srd = "<select><option></option></select>";
    $slc_sbrd = "<select><option></option></select>";
    $slc_tdoc = "<select><option></option></select>";
}
if ($error) {
    $msg = '<tr bordercolor="#FFFFFF">
			<td width="3%" align="center" class="titulosError" colspan="2" bgcolor="#FFFFFF">';
    switch ($error) {
        case 1: //NO CONECCION A BD
            $msg .= "Error al conectar a BD, comun&iacute;quese con el Administrador de sistema !!";
            break;
        case 2: //ERROR EJECUCCION SQL
            $msg .= "Error al gestionar datos, comun&iacute;quese con el Administrador de sistema !!";
            break;
        case 3: //INSERCION REALIZADA
            $msg .= "Creaci&oacute;n exitosa!";
            break;
        case 4: //MODIFICACION REALIZADA
            $msg .= "Registro actualizado satisfactoriamente!!";
            break;
        case 5: //IMPOSIBILIDAD DE ELIMINAR REGISTRO
            $msg .= "No se puede eliminar registro, tiene dependencias internas relacionadas.";
            break;
        case 6: //IMPOSIBILIDAD DE ELIMINAR REGISTRO
            $msg .= "Ya existe clasificaci&oacute;n para esta dependencia <" . $_SESSION['dependencia'] . ">.";
            break;
    }
    $msg .= '</td></tr>';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>.: Orfeo :. Tipificaci&oacute;n y Metadatos.</title>
        <link href="<?= $ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function regresar(){   	
                document.TipoDocu.submit();
            }

            function cambiaEditar(form, val) {
                document.getElementById('isEditMTD').value = val;
                //alert(document.getElementById('isEditMTD').value);
                return true;; 
            }
        </script>
    </head>
    <body>
        <form name="form1" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
            <table border=0 width=90% align="center" class="borde_tab" cellspacing="0">
                <tr align="center" class="titulos2">
                    <td height="15" class="titulos2" colspan="2">APLICACI&Oacute;N DE LA TRD</td>
                </tr>
                <tr>
                    <td class="titulos5" width="20%" >SERIE</td>
                    <td class="listado5"><?php echo $slc_srd; ?></td>
                </tr>
                <tr>
                    <td class="titulos5" width="20%" >SUBSERIE</td>
                    <td class="listado5"><?php echo $slc_sbrd; ?></td>
                </tr>
                <tr>
                    <td class="titulos5" width="20%" >TIPO DOCUMENTAL</td>
                    <td class="listado5"><?php echo $slc_tdoc; ?></td>
                </tr>
                <?php
                echo $msg;
                ?>
                <tr>
                    <td colspan="2">
                        <?php
                        $metadatosAmostrar = 'T';  //Tipo Documental
                        $registrosAmostrar = 'R';  //Radicados
                        require "../listado_metadatos.php";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tablas">
                            <tr bordercolor="#FFFFFF">
                                <td width="5%" class="listado2">&nbsp;</td>
                                <td width="30%"  class="listado2">
                                    <p align="center">
                                        <input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Insertar">
                                    </p>
                                </td>
                                <td width="30%" class="listado2">
                                    <p align="center">
                                        <input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Modificar" onClick="return cambiaEditar(this.form, 0);">
                                    </p>
                                </td>
                                <td width="30%" class="listado2">
                                    <p align="center">
                                        <input name="btn_accion" type="button" class="botones" id="btn_accion" value="Cerrar" onClick="opener.regresar();window.close();">
                                    </p>
                                </td>
                                <td width="5%" class="listado2">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="borde_tab">
                <tr align="center">
                    <td>
                        <?php
                        include "lista_tiposAsignados.php";
                        if ($ind_ProcAnex == "S") {
                            echo " <br> <input type='button' value='Cerrar' class='botones_largo' onclick='opener.regresar();window.close();'> ";
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="nurad" name="nurad" value="<?php echo $nurad; ?>">
        </form>
    </body>
</html>
