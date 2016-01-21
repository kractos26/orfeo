<?php

session_start();
$verrad = "";
$ruta_raiz = "..";
define('ADODB_ASSOC_CASE', 1);
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
include($ruta_raiz . '/config.php');
include_once 'MetaDatoClass.php';
include_once '../Aux/CSV/MatToCSV.Class.php';
$db = new ConnectionHandler("$ruta_raiz");
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
$encabezado = "" . session_name() . "=" . session_id() . "&krd=$krd&n_nume_radi=$n_nume_radi&s_RADI_NOM=$s_RADI_NOM&s_solo_nomb=$s_solo_nomb&insertaExp=$insertaExp&s_entrada=$s_entrada&s_salida=$s_salida&fecha_ini=$fecha_ini&fecha_fin=$fecha_fin&fecha1=$fecha1&tipoDocumento=$tipoDocumento&dependenciaSel=$dependenciaSel&nume_expe=$nume_expe&txtExpe=$txtExpe&txtMetadato=$txtMetadato&insertaExp=$insertaExp&orderTipo=$orderTipo&orderNo=";
if ($_POST['Serie']) {
    $sqlSbSerie = " SELECT SGD_SBRD_DESCRIP, SGD_SBRD_CODIGO FROM SGD_SBRD_SUBSERIERD WHERE SGD_SRD_CODIGO=" . $_POST['Serie'] . " ORDER BY SGD_SBRD_DESCRIP ";
    $rsSbSerie = $db->conn->query($sqlSbSerie);
    if ($rsSbSerie && !$rsSbSerie->EOF) {
        $selectSbSerie = "<select name=\"selectSbSerie\" class=\"select\">
                <option value=\"0\">Sub serie</option>";
        while ($arr = $rsSbSerie->FetchRow()) {
            $selectSbSerie.="<option value=\"" . $arr['SGD_SBRD_CODIGO'] . "\">" . $arr['SGD_SBRD_DESCRIP'] . "</option>";
        }
        $selectSbSerie.="</select>";
    } else {
        $selectSbSerie = "<p>No se encontraron  sub series</p>";
    }
    echo $selectSbSerie;
}
if ($_POST['Busq']) {
    $ruta = "$ruta_raiz/$carpetaBodega/tmp/MetaConsulta" . date('Y_m_d_H_i_s') . ".csv";
    if ($_POST['TipoBusq'] == "S") {
        //Busqueda por subserie
        //$_POST['SerieB']
        //$_POST['SubSerie']
        if ($_POST['Num'] != null) {
            $whereNum = " and sgd_exp_numero like '%" . $_POST['Num'] . "%' ";
        }
        if ($_POST['Desde'] != $_POST['Hasta']) {
            $whereFech = " and date_trunc('day',sgd_sexp_fech) between to_date('" . $_POST['Desde'] . "', 'DD-MM-YYYY') and to_date('" . $_POST['Hasta'] . "', 'DD-MM-YYYY') ";
        } else {
            $whereFech = " and date_trunc('day',sgd_sexp_fech) =to_date('" . $_POST['Desde'] . "', 'DD-MM-YYYY')  ";
        }
        if ($_POST['Meta']) {
            $whereMeta = " and sgd_exp_numero in (select sgd_exp_numero from sgd_mmr_matrimetaexpe where (sgd_mmr_dato like '%" . $_POST['Meta'] . "%') or (sgd_mmr_dato like '%" . strtoupper($_POST['Meta']) . "%') or (sgd_mmr_dato like '%" . strtolower($_POST['Meta']) . "%') )  ";
        }
        $sql = " select sgd_exp_numero AS EXPEDIENTE from sgd_sexp_secexpedientes where sgd_srd_codigo=" . $_POST['SerieB'] . " and sgd_sbrd_codigo=" . $_POST['SubSerie'] . " " . $whereNum . $whereFech . $whereMeta;
        //echo $sql;
        $rs = $db->conn->query($sql);
        if ($rs && !$rs->EOF) {
            while ($arr = $rs->FetchRow()) {
                $Exps[$arr['EXPEDIENTE']] = new MetaDatoClass($db, $_POST['TipoBusq'], $arr['EXPEDIENTE']);
            }
            $tableTitle['Expediente'] = " Expediente No. ";
            $tableTitle['Fecha'] = " Fecha creaci&oacute;n ";
            $metaAux = new MetaDatoClass($db);
            $metaAux->MetaFillSS($_POST['SerieB'], $_POST['SubSerie']);
            foreach ($metaAux->MetaSS as $key => $value) {
                $tableTitle[$key] = $value;
            }
            $ResultTable = "<table class=\"sortable\" cellpadding=\"1\" valign=\"top\" style=\"background-color: white\" ><thead style=\"background-color:  #a8b8c6\"><tr>";
            foreach ($tableTitle as $key => $value) {
                $ResultTable.="<th align='center'><span class=\"titulos3\">$value</span></th>";
            }
            $ResultTable.="</thead></tr>";
            foreach ($Exps as $expNum => $metaObj) {
                if ($i % 2) {
                    $listado = "listado2";
                } else {
                    $listado = "listado1";
                }
                $ResultTable.="<tr class=\"$listado\" valign=\"top\">";
                foreach ($tableTitle as $key => $value) {
                    switch ($key) {
                        case 'Expediente':
                            $dataRow = $expNum;
                            break;
                        case 'Fecha':
                            $dataRow = $metaObj->Fech;
                            $radFileClass = "leidos";
                            $v = "<a href=" . ".." . "/expediente/listaConsulta.php?numExpediente=$expNum&" . $encabezado . " target='expediente'><span class=$radFileClass>" . $dataRow . "</span></a>";
                            break;
                        default:
                            $dataRow = $metaObj->Metas[$key];
                            break;
                    }
                    if ($key == 'Fecha') {
                        $ResultTable.="<td align='center'>$v</td>";
                    } else {
                        $ResultTable.="<td align='center'><span class=\"leidos\">$dataRow</span></td>";
                    }
                    $Fila[] = $dataRow;
                }
                $matriz[] = $Fila;
                unset($Fila);
                $i++;
                $ResultTable.="</tr>";
            }
            $ResultTable.="</table>
                <script type=\"text/javascript\">
                    sorttable.init();
                </script>";
            echo $ResultTable;
            echo "<a href='$ruta' target='_blank'><img style='border:0px' height='20' width='20' src='$ruta_raiz/imagenes/csv1.png' alt='Archivo CSV'/>Archivo CSV</a>";

            $csvAux = new MatToCSV($ruta, $matriz, $tableTitle);
            //echo $csvAux->out;
        } else {
            echo " No se encontraron resultados ";
        }
    } else {
        //Buscar pot tipo de documento
        if ($_POST['Num'] != null) {
            $whereNum = " and radi_nume_radi like '%" . $_POST['Num'] . "%' ";
        }
        if ($_POST['Desde'] != $_POST['Hasta']) {
            $whereFech = " and date_trunc('day', radi_fech_radi) between to_date('" . $_POST['Desde'] . "', 'DD-MM-YYYY') and to_date('" . $_POST['Hasta'] . "', 'DD-MM-YYYY') ";
        } else {
            $whereFech = " and date_trunc('day', radi_fech_radi) = to_date('" . $_POST['Desde'] . "', 'DD-MM-YYYY')  ";
        }
        if ($_POST['Meta']) {
            $whereMeta = " and radi_nume_radi in (select radi_nume_radi from sgd_mmr_matrimetaradi where (sgd_mmr_dato like '%" . $_POST['Meta'] . "%') or (sgd_mmr_dato like '%" . strtoupper($_POST['Meta']) . "%') or (sgd_mmr_dato like '%" . strtolower($_POST['Meta']) . "%'))  ";
        }
        if ($_POST['Trad']) {
            $whereTrad = " and radi_nume_radi like '%" . $_POST['Trad'] . "' ";
        }
        if ($_POST['Dep'] != 0) {
            $whereDep = " and radi_depe_radi=" . $_POST['Dep'] . " ";
        }
        $sql = " select radi_nume_radi AS RADICADO from radicado where tdoc_codi=" . $_POST['TpDoc'] . " " . $whereNum . $whereFech . $whereMeta . $whereTrad . $whereDep;
        //echo $sql;
        $rs = $db->conn->query($sql);
        if ($rs && !$rs->EOF) {
            while ($arr = $rs->FetchRow()) {
                $Radis[$arr['RADICADO']] = new MetaDatoClass($db, $_POST['TipoBusq'], $arr['RADICADO']);
            }
            $tableTitle['Radicado'] = " No.Radicado ";
            $tableTitle['Fecha'] = " Fecha radicaci&oacute;n ";
            $metaAux = new MetaDatoClass($db);
            $metaAux->MetaFillTpDoc($_POST['TpDoc']);
            foreach ($metaAux->MetaTpDoc as $key => $value) {
                $tableTitle[$key] = $value;
            }
            $ResultTable = "<table class=\"sortable\" cellpadding=\"1\" valign=\"top\" style=\"background-color: white\" ><thead style=\"background-color:  #a8b8c6\"><tr>";
            foreach ($tableTitle as $key => $value) {
                $ResultTable.="<th align='center'><span class=\"titulos3\">$value</span></th>";
            }
            $ResultTable.="</thead></tr>";
            $i = 0;
            foreach ($Radis as $radiNum => $metaObj) {
                if ($i % 2) {
                    $listado = "listado2";
                } else {
                    $listado = "listado1";
                }

                $ResultTable.="<tr class=\"$listado\" valign=\"top\">";
                foreach ($tableTitle as $key => $value) {
                    switch ($key) {
                        case 'Radicado':
                            $dataRow = $radiNum;
                            break;
                        case 'Fecha':
                            $dataRow = $metaObj->Fech;
                            $radFileClass = "leidos";
                            $v = "<a href=" . ".." . "/verradicado.php?verrad=" . $radiNum . "&" . $encabezado . "><span class=$radFileClass>" . $dataRow . "</span></a>";
                            break;
                        default:
                            $dataRow = $metaObj->Metas[$key];
                            break;
                    }
                    if ($key == 'Fecha') {
                        $ResultTable.="<td align='center'>$v</td>";
                    } else {
                        $ResultTable.="<td align='center'><span class=\"leidos\">$dataRow</span></td>";
                    }
                    $Fila[] = $dataRow;
                }
                $matriz[] = $Fila;
                unset($Fila);
                $i++;
                $ResultTable.="</tr>";
            }
            $ResultTable.="</table>
                <script type=\"text/javascript\">
                    sorttable.init();
                </script>";
            echo $ResultTable;
            echo "<a href='$ruta' target='_blank'><img style='border:0px' height='20' width='20' src='$ruta_raiz/imagenes/csv1.png' alt='Archivo CSV'/>Archivo CSV</a>";
            $csvAux = new MatToCSV($ruta, $matriz, $tableTitle);
            //echo $csvAux->out;
        } else {
            echo " No se encontraron resultados ";
        }
    }
}
?>
