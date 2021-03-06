<?php
session_start();
$ruta_raiz = "..";
include("$ruta_raiz/config.php");    // incluir configuracion.
include_once "$ruta_raiz/include/tx/Historico.php";
include "$ruta_raiz/include/db/ConnectionHandler.php";

if (!$fecha_busq)
    $fecha_busq = date('Y-m-d');
if (!$fecha_busq2)
    $fecha_busq2 = date('Y-m-d');
$txtExpediente = (isset($_POST['txtExpediente'])) ? $_POST['txtExpediente'] : $_GET['txtExpediente'];
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : $_GET['accion'];
$slcTipoReporte = (isset($_POST['slcTipoReporte'])) ? $_POST['slcTipoReporte'] : $_GET['slcTipoReporte'];
$dependenciaSel = (isset($_POST['dependenciaSel'])) ? $_POST['dependenciaSel'] : $_GET['dependenciaSel'];
$db = new ConnectionHandler($ruta_raiz);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
if ($db) { //$db->conn->debug=true;
    if (isset($accion)) {
        switch ($accion) {
            case 'Buscar': {
                    //if(isset($orderNo))
                    $c_order = " ORDER BY " . ($orderNo + 1);
                    (!$orderTipo) ? $c_order .= $orderTipo = " desc " : $orderTipo = "";

                    switch ($db->driver) {
                        case 'postgres':
                            $fechaCFase = " " . $db->conn->SQLDate('Y-m-d', 'exp.sgd_sexp_fechacierre') . "::date + cast(sbr.sgd_sbrd_tiemag||' years' as interval) ";
                            break;
                        case 'oci8':
                        case 'oci8po':
                            $fechaCFase = " " . $db->conn->SQLDate('Y-m-d', ' add_months(exp.sgd_sexp_fechacierre,sbr.sgd_sbrd_tiemag*12) ');
                            break;
                        default:
                    }
                    if ($txtExpediente) {
                        $where.="  and exp.sgd_exp_numero='" . $txtExpediente . "'";
                    }
                    if ($slcTipoReporte == 1) {
                        $where .= " and exp.sgd_sexp_cerrado=1";
                        $whereFec .= " and $fechaCFase BETWEEN '$fecha_busq' AND '$fecha_busq2'";
                        $tipoReporte = "ARCHIVO CENTRAL";
                    } else if ($slcTipoReporte == 2) {
                        $where .= " and sbr.SGD_SBRD_DISPFIN=2 and exp.sgd_sexp_cerrado=1 and sbr.SGD_SBRD_TIEMAC=0";
                        $whereFec .= " and " . $db->conn->SQLDate('Y-m-d', 'exp.sgd_sexp_fech') . " BETWEEN '$fecha_busq' AND '$fecha_busq2'";
                        $tipoReporte = "ARCHIVO DE ELIMINACIÓN";
                    } else if ($slcTipoReporte == 3) {
                        $where .= " and (exp.sgd_sexp_cerrado <> 1 or exp.sgd_sexp_cerrado is null) ";
                        $whereFec .= " and " . $db->conn->SQLDate('Y-m-d', 'exp.sgd_sexp_fech') . " BETWEEN '$fecha_busq' AND '$fecha_busq2'";
                        $tipoReporte = "ARCHIVO DE GESTIÓN";
                    }
                    if ($dependenciaSel != '9999') {
                        $where.=" and exp.depe_codi=" . $dependenciaSel;
                    }
                    $sql = " SELECT	exp.SGD_EXP_NUMERO AS \"No_Expediente\", exp.SGD_SEXP_FECH AS \"DEX_Fecha Creacion\", exp.sgd_sexp_fechacierre as \"Fecha cierre\",
                                                             exp.sgd_sexp_nombre AS \"Nombre\"
                                                            , u.usua_nomb AS \"Usuario Responsable\"
                                                            ,$fechaCFase as \"Fecha Real TRD\"
                                                            ,exp.SGD_EXP_NUMERO AS \"CHK_CHKANULAR\"
                                            FROM SGD_SEXP_SECEXPEDIENTES exp
                                            JOIN USUARIO u on u.usua_doc=exp.usua_doc_responsable and u.depe_codi=exp.depe_codi
                                            JOIN SGD_SBRD_SUBSERIERD sbr ON sbr.SGD_SBRD_CODIGO=exp.SGD_SBRD_CODIGO AND sbr.SGD_SRD_CODIGO=exp.SGD_SRD_CODIGO
                                            WHERE	exp.sgd_exp_numero is not null AND (exp.sgd_sexp_faseexp not in (2,3)  or exp.sgd_sexp_faseexp is null)  $whereFec $where $c_order";
                    //$db->conn->debug=true;
                    $rs = $db->conn->Execute($sql);
                    $rscsv = $db->conn->Execute($sql);
                    if ($rs and !$rs->EOF) {
                        $encabezado1 = $_SERVER['PHP_SELF'] . "?" . session_name() . "=" . session_id() . "&krd=$krd";
                        $linkPagina = "$encabezado1&txtExpediente=$txtExpediente&dependenciaSel=$dependenciaSel&fecha_busq=$fecha_busq&fecha_busq2=$fecha_busq2&accion=$accion&slcTipoReporte=$slcTipoReporte&orderNo=$orderNo";
                        $encabezado = "" . session_name() . "=" . session_id() . "&krd=$krd&txtExpediente=$txtExpediente&dependenciaSel=$dependenciaSel&fecha_busq=$fecha_busq&fecha_busq2=$fecha_busq2&slcTipoReporte=$slcTipoReporte&accion=$accion&orderTipo=$orderTipo&orderNo=";
                        $pager = new ADODB_Pager($db, $sql, 'adodb', true, $orderNo, $orderTipo);
                        $pager->checkAll = true;
                        $pager->checkTitulo = true;
                        $pager->toRefLinks = $linkPagina;
                        $pager->toRefVars = $encabezado;
                        $pager->txtBusqueda = trim($txtExpe);
                        $btnConfirma = "<input type='submit' name='accion' id='accion' value='Generar Reporte' class='botones_mediano2'>";
                    } else {
                        $msg = "<tr><td class='listado5' colspan='2'><center><font color=red size=3>No existen Expedientes para la transferencia con el criterio de B&uacute;squeda</font></center></td></tr>";
                    }
                }
                break;
            case 'Generar Reporte': {
                    include("$ruta_raiz/include/class/InventarioFUI.php");
                    define('FPDF_FONTPATH', "$ruta_raiz/fpdf/font/");
                    $objFui = new InventarioFUI($db->conn);
                    //$db->conn->debug=true;
                    if (is_array($_POST['checkValue'])) {
                        $expBusq = implode("','", array_keys($_POST['checkValue']));
                        $exps = implode(",", array_keys($_POST['checkValue']));
                    }
                    if ($_POST['slcTipo'] == 1 || $_POST['slcTipo'] == 0) {
                        $titulosAdm = array('No Correl', 'CODIGO SERIE' => array("\nDEP\n ", "\nSERIE-SUB"), "NUMERO\nEXP", "NOMBRE UNIDAD DE CONSERVACION\n ", 'FECHAS EXTREMAS' => array("INICIAL\n\nDD/MM/AA", "FINAL\n\nDD/MM/AA"), 'NUMERO' => array("\nCARPETA\n "), "NOMBRE CARPETA\n\n", 'TOTAL FOLIOS');
                        $widthsAdm = array(2.8, 4.8, 7.5, 40, 8, 5, 30, 5);

                        $sqlAdm = "select exp.depe_codi as DEPENDENCIA,  exp.sgd_srd_codigo " . $db->conn->concat_operator . "'-'" . $db->conn->concat_operator . " exp.sgd_sbrd_codigo as SERIE,exp.sgd_exp_numero as NUMERO_EXP, exp.sgd_sexp_nombre as NOMBRE_UNIDAD_DE_CONSERVACION, " . $db->conn->SQLDate('d/m/Y', 'exp.sgd_sexp_fech') . " as FECHA_INICIAL," . $db->conn->SQLDate('d/m/Y', 'exp.sgd_sexp_fechacierre') . " as FECHA_FINAL, carp.sgd_carpeta_numero AS NUMERO_CARPETA, carp.sgd_carpeta_descripcion AS CONTENIDO, carp.sgd_carpeta_nfolios as NFOLIOS
                                                        from sgd_carpeta_expediente carp
                                                        join sgd_sexp_secexpedientes exp on carp.sgd_exp_numero=exp.sgd_exp_numero
                                                    where  exp.sgd_exp_numero in ('$expBusq')
                                                    order by exp.sgd_exp_numero, carp.sgd_carpeta_csc";
                        $ADODB_COUNTRECS = true;
                        $rsAdm = $db->conn->Execute($sqlAdm);
                        $ADODB_COUNTRECS = false;
                        $contA = $rsAdm->RecordCount();
                        if ($rsAdm->RecordCount() > 0) {
                            $objFui->tipoReporte = $tipoReporte;
                            $objFui->creaFormato($rsAdm, $titulosAdm, $widthsAdm);
                            $resultado = "<tr><td class='listado5' ><font color=red >(" . $rsAdm->RecordCount() . ") Registros. Descargar Archivo </font></td><td class='listado5'>";
                            $resultado .= "<a href='" . $objFui->enlacePDF() . "' target='_blank'><img  width='30' height='13' src='../imagenes/pdf.png' border='0' alt='Formato PDF' title='Formato PDF' align='top' /></a> &nbsp;";
                            $resultado .= "<a href='" . $objFui->enlaceXML() . "' target='_blank'><img  width='30' height='13' src='../imagenes/xml.png' border='0' alt='Formato XML' title='Formato XML' align='top' /></a>";
                            if ($slcTipoReporte == 1)
                                $resultado .= "&nbsp;&nbsp;Solicitar Transferencia <input name='accion' value='&gt;&gt;' class='botones_2' onclick='solicitaTransf(\"$exps\",1)' type='button'>";
                            $resultado .= "</td></tr>";
                        }
                    }
                    if (($_POST['slcTipo'] == 0 and $rsProc and !$rsProc->RecordCount()
                            and $rsAdm and !$rsAdm->RecordCount()) or ($_POST['slcTipo'] == 1
                            and $rsAdm and !$rsAdm->RecordCount()) or ($_POST['slcTipo'] == 2
                            and $rsProc and !$rsProc->RecordCount())) {
                        $msg = "<tr><td class='listado5' colspan='2'><center><font color=red size=3>No es posible generar el Reporte, No existen carpetas</font></center></td></tr>";
                    }
                }
                break;
        }
    }
    $arrTipRep = array('1' => "Transferencias", '2' => "Eliminaci&oacute;n", '3' => "Archivo de Gesti&oacute;n");
    $slcTpRep = "<select name='slcTipoReporte' id='slcTipoReporte' class='select'>";
    !$_POST['slcTipoReporte'] ? $estSelRep = 'selected' : $estSelRep = '';
    //$slcTpRep.="<option value=0 $estSelRep >Seleccione</option>";
    foreach ($arrTipRep as $h => $valueR) {
        $_POST['slcTipoReporte'] == $h ? $estSelRep = 'selected' : $estSelRep = '';
        $slcTpRep.="<option value=$h $estSelRep >$valueR</option>";
    }
    $slcTpRep.="</select>";

    if ($_SESSION["usua_admin_archivo"] < 2) {
        $whereDep = " and depe_codi=" . $_SESSION["dependencia"];
        $blank1stItem = false;
    }
    else
        $blank1stItem = "9999:Todas las dependencias";
    $sql = "SELECT dep_sigla " . $db->conn->concat_operator . "'-'" . $db->conn->concat_operator . " DEPE_NOMB, DEPE_CODI FROM DEPENDENCIA where depe_estado=1 $whereDep ORDER BY 1";
    $rs = $db->conn->execute($sql);
    $cmb_dep = $rs->GetMenu2('dependenciaSel', $dependenciaSel, $blank1stItem, false, 0, 'class=select');
}
?>

<html>
    <head><title></title>
        <link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
        <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
          <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/tabber.css"?>" type="text/css" media="screen">
    </head>
    <script language="javascript" src="../js/funciones.js"></script>
    <script type="text/javascript" language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
    <script type="text/javascript" language="JavaScript">
        var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "frmTransf", "fecha_busq","btnDate1",<?= "'" . $fecha_busq . "'" ?>,scBTNMODE_CUSTOMBLUE);
        var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "frmTransf", "fecha_busq2","btnDate2",<?= "'" . $fecha_busq2 . "'" ?>,scBTNMODE_CUSTOMBLUE);

        function markAll()
        {
            if(document.frmTransf.elements['checkAll'].checked)
            {
                for(i=3;i<document.frmTransf.elements.length;i++)
                {
                    document.frmTransf.elements[i].checked=1;
                }
            }
            else
            {
                for(i=3;i<document.frmTransf.elements.length;i++)
                {
                    document.frmTransf.elements[i].checked=0;
                }
            }
        }

        function solicitaTransf(exps,tip)
        {
            var anchoPantalla = 300//screen.availWidth;
            var altoPantalla  = 300//screen.availHeight;
            var iniX= (screen.availHeight/2)-150
            var iniY= (screen.availWidth/2)-150
            window.open("<?= $ruta_raiz ?>/expediente/solicitarTransferenciaExp.php?sessid=<?= session_id() ?>&exps="+exps+"&tip="+tip+"&krd=<?= $krd ?>","modExp","top="+iniX+",left="+iniY+",height="+altoPantalla+",width="+anchoPantalla+",scrollbars=yes");
        }

    </script>
    <body onload="document.getElementById('txtExpediente').focus();">
        <div id="spiffycalendar" class="text"></div>
        <form action="<?php echo $_SERVER['PHP_SELF'] . "?numExpediente=$numExpediente"; ?>" name="frmTransf" id="frmTransf" method="post">
            <input type="hidden" name="tipoReporte" id="tipoReporte" value="<?= htmlentities($tipoReporte) ?>">
            <table border=0 cellpadding=0 cellspacing=2 width="60%" class='borde_tab'>
                <tr>
                    <td  class="titulos4" colspan="13">B&Uacute;SQUEDAS POR:</td>
                </tr>
                <tr>
                    <td colspan="3" class="titulos5">
                         <table border=0 width=69% cellpadding="0" cellspacing="0">
                            <tr>
                                <td>		
                                    <div id="tab1" class="tabberlive" border="1">
                                            <ul class="tabbernav">
                                            <li >
                                            <a class="vinculos" href="../busqueda/busquedaPiloto.php?<?= $phpsession ?>&krd=<?= $krd ?>&<? echo "&fechah=$fechah&primera=1&ent=2&s_Listado=VerListado"; ?>">
                                                    GENERAL
                                                    </a>
                                            </li>
                                            </ul>
                                    </div>
                                </td>
                                 <td>		
                                    <div id="tab1" class="tabberlive" border="1">
                                            <ul class="tabbernav">
                                            <li >
                                                <a class="vinculos" href="../busqueda/busquedaHist.php?<?= session_name() . "=" . session_id() . "&fechah=$fechah&krd=$krd" ?>">
                                                HISTORICO
                                                    </a>
                                            </li>
                                            </ul>
                                    </div>
                                </td>
                                <td>		
                                    <div id="tab1" class="tabberlive" border="1">
                                            <ul class="tabbernav">
                                            <li >
                                           <a class="vinculos" href="../busqueda/busquedaExp.php?<?= $phpsession ?>&krd=<?= $krd ?>&<? ECHO "&fechah=$fechah&primera=1&ent=2"; ?>">

                                                Expedientes
                                               </a>
                                            </li>
                                            </ul>
                                    </div>
                                </td>
                                <td>		
                                    <div id="tab1" class="tabberlive" border="1">
                                            <ul class="tabbernav">
                                            <li >
                                                <a class="vinculos" href="../expediente/consultaTransferenciaExp.php?<?= $phpsession ?>&krd=<?= $krd ?>&<? ECHO "&fechah=$fechah&primera=1&ent=2"; ?>">
                                                TRANSFERENCIA
                                               </a>
                                            </li>
                                            </ul>
                                    </div>
                                </td>
                                <td>		
                                    <div id="tab1" class="tabberlive" border="1">
                                            <ul class="tabbernav">
                                            <li >
                                                <a class="vinculos" href="../busqueda/busquedaMetaDato.php?<?= $phpsession ?>&krd=<?= $krd ?>&<? ECHO "&fechah=$fechah&primera=1&ent=2"; ?>"> 

                                                METADATO
                                               </a>
                                            </li>
                                            </ul>
                                    </div>
                                </td>
                                <!--<td width="13%" valign="bottom" class="" ><a class="vinculos" href="../busqueda/busquedaUsuActu.php?<?= session_name() . "=" . session_id() . "&fechah=$fechah&krd=$krd" ?>"><img src='../imagenes/usuarios.gif' alt='' border=0 width="110" height="25" ></a></td>-->
                                <td width="35%" valign="bottom" class="" >&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class='titulos5'>No. de expediente:</TD>
                    <td class='listado5'><input name="txtExpediente" type="text" size="21" class="tex_area" value="" id="txtExpediente"></td>
                </tr>
                <tr>
                    <td class='titulos5'>Tipo de reporte:</TD>
                    <td class='listado5'><?= $slcTpRep ?></td>
                </tr>
                <tr>
                    <td class='titulos5'> Fecha desde</td>
                    <td class='listado5'>
                        <script language="javascript">
                            dateAvailable.date = "<?= date('Y-m-d'); ?>";
                            dateAvailable.writeControl();
                            dateAvailable.dateFormat="yyyy-MM-dd";
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class='titulos5'> Fecha hasta</td>
                    <td class='listado5'>
                        <script language="javascript">
                            dateAvailable2.date = "<?= date('Y-m-d'); ?>";
                            dateAvailable2.writeControl();
                            dateAvailable2.dateFormat="yyyy-MM-dd";
                        </script>
                    </td>
                </tr>
                <tr>
                    <td height="26" class='titulos5'>Dependencia</td>
                    <td valign="top" class='listado5'><?= $cmb_dep ?></td>
                </tr>
                <tr>
                    <td height="26" colspan="2" valign="top" class='titulos5'> 
                <center>
                    <input type="submit" name="accion" id="accion" value='Buscar' class='botones_mediano'>
<?= $btnConfirma ?>
                </center>
                </td>
                </tr>
<?
if ($msg)
    echo $msg;
echo $resultado;
?>
            </table>
<?
if ($pager)
    $pager->Render($rows_per_page = 20, $linkPagina, $checkbox = chkAnulados);
if ($rscsv->EOF || !$rscsv) {
    
} else {
    if (!isset($carpetaBodega)) {
        include "$ruta_raiz/config.php";
    }
    include_once("$ruta_raiz/adodb/toexport.inc.php");

    $ruta = "$ruta_raiz/" . $carpetaBodega . "tmp/Busqtransferencia" . date('Y_m_d_H_i_s') . ".csv";
    $f = fopen($ruta, 'w');
    if ($f) {
        rs2csvfile($rscsv, $f);
        echo "<a href='$ruta' target='_blank'><img style='border:0px' width='20' height='20' src='" . $ruta_raiz . "/imagenes/csv.png' alt='Archivo CSV'/>Archivo CSV</a>";
    }
}
?>
        </form>
    </body>
</html>