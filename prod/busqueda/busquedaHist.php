<?php
session_start();
$ruta_raiz = "..";
define('ADODB_ASSOC_CASE', 2);
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");
    include "../Administracion/usuario/SecSuperClass.php";
    $UsrSecAux = new SecSuperClass($db);
    $UsrSecAux->SecSuperFill($_SESSION['usua_doc']);
//$db->conn->debug=TRUE;
////  Validaciones /////
if ($orden_cambio == 1)
    (!$orderTipo) ? $orderTipo = "desc" : $orderTipo = "";

if (!isset($fecha_ini))
    $fecha_ini = date("Y/m/d");
if (!isset($fecha_fin))
    $fecha_fin = date("Y/m/d");

$encabezadol = "$PHP_SELF?" . session_name() . "=" . session_id() . "&krd=$krd";
$linkPagina = "$PHP_SELF?" . session_name() . "=" . session_id() . "&krd=$krd&fecha_ini=$fecha_ini&fecha_fin=$fecha_fin&fecha1=$fecha1&s_entrada=$s_entrada&s_salida=$s_salida&tipoDocumento=$tipoDocumento&tipoRadicado=$tipoRadicado&dependenciaSel=$dependenciaSel&s_ciudadano=$s_ciudadano&s_empresaESP=$s_empresaESP&s_oEmpresa=$s_oEmpresa&s_funcionario=$s_funcionario&palabra=$palabra&s_solo_nomb=$s_solo_nomb";
$encabezado = "" . session_name() . "=" . session_id() . "&krd=$krd";
$variables = "" . session_name() . "=" . session_id() . "&krd=$krd&n_nume_radi=$n_nume_radi&s_solo_nomb=$s_solo_nomb&s_entrada=$s_entrada&s_salida=$s_salida&tipoDocumento=$tipoDocumento&tipoRadicado=$tipoRadicado&dependenciaSel=$dependenciaSel&fecha_ini=$fecha_ini&fecha_fin=$fecha_fin&fecha1=$fecha1&orderTipo=$orderTipo&orderNo=";

////////////////////

if (isset($_POST['submit']) or
        $tipoRadicado or
        $tipoDocumento or
        $dependenciaSel or
        $adodb_next_page or $orderNo or $orderTipo or $orden_cambio) {
    if (!isset($orderNo))
        $orderNo = 0;
    $sqlFecha = $db->conn->SQLDate("Y/m/d", "R.RADI_FECH_RADI");

    switch ($orderNo) {
        case 0:
            $c_order = " ORDER BY R.RADI_NUME_RADI ";
            break;
        case 2:
            $c_order = " ORDER BY " . $sqlFecha;
            break;
        case 4:
            $c_order = " ORDER BY A.SGD_DIR_NOMREMDES ";
            break;
        case 5:
            $c_order = " ORDER BY A.SGD_DIR_DOC ";
            break;
        case 6:
            $c_order = " ORDER BY D.DEPE_NOMB ";
            break;

        case 7:
            $c_order = " ORDER BY R.RADI_USU_ANTE";
            break;
    }
    $c_order .= (!$orderTipo) ? "asc" : "desc";

    /* Se recibe el tipo de radicado para la busqueda */
    if ($tipoRadicado == "9999")
        $sWhere .= " AND R.RADI_NUME_RADI IS NOT NULL ";
    else
        $sWhere .= " AND cast(R.RADI_NUME_RADI AS VARCHAR) like '%" . $tipoRadicado . "'";

    /* Se recibe el tipo de documento para la busqueda */
    if ($tipoDocumento == "9999")
        $sWhere .= " AND R.TDOC_CODI IS NOT NULL ";
    else
        $sWhere .= " AND R.TDOC_CODI =" . $tipoDocumento;

    /* Se recibe la dependencia actual para busqueda */
    if ($dependenciaSel == "99999")
        $sWhere .= " AND R.RADI_DEPE_ACTU IS NOT NULL ";
    else
        $sWhere = $sWhere . " and R.RADI_DEPE_ACTU =" . $dependenciaSel;

    /* Se recibe el numero del Radicado a Buscar */
    if ($n_nume_radi)
        $sWhere = $sWhere . " AND cast(R.RADI_NUME_RADI AS VARCHAR) like '%$n_nume_radi%'";

    /* Se recibe la cadena a buscar y el tipo de busqueda (All) (Any) */
    $c = $db->conn->concat_operator;
    if ($palabra) {
        if ($s_solo_nomb == "All") {
            $sWhere.= " and (";
            $and = "false";
            $s_RADI_NOMB = strtoupper($palabra);
            $tok = strtok($s_RADI_NOMB, " ");
            while ($tok) {
                if ($sWhere != "" && $and == "true")
                    $sWhere .= " and ";
                $HasParam = true;
                $sWhere .= " upper(A.SGD_DIR_NOMREMDES" . $c . "A.SGD_DIR_NOMBRE" . $c . "R.RADI_CUENTAI" . $c . "A.SGD_DIR_TELEFONO" . $c . "A.SGD_DIR_DIRECCION" . $c . "R.RA_ASUN" . $c . "R.RADI_REM) like '%" . $tok . "%' ";
                $tok = strtok(" ");
                $and = "true";
            }
            $sWhere.=")";
        }
        if ($s_solo_nomb == "Any") {
            $sWhere.= " and (";
            $and = "false";
            $ps_RADI_NOMB = strtoupper($palabra);
            $tok = strtok($ps_RADI_NOMB, " ");
            while ($tok) {
                $HasParam = true;
                if ($sWhere != "" && $and == "true") {
                    $sWhere .= ") OR (";
                }
                $sWhere .= "upper(A.SGD_DIR_NOMREMDES" . $c . "A.SGD_DIR_NOMBRE" . $c . "R.RADI_CUENTAI" . $c . "A.SGD_DIR_TELEFONO" . $c . "A.SGD_DIR_DIRECCION" . $c . "R.RA_ASUN" . $c . "R.RADI_REM) like '%" . $tok . "%' ";
                $tok = strtok(" ");
                $and = "true";
            }
            $sWhere.=")";
        }
    }
    // Preparacion del listado de -- APAREZCO COMO ACTUAL  Se borro campo identificacion con HID 
    $sql = 'SELECT DISTINCT R.RADI_NUME_RADI   AS "IMG_Numero radicado",
				R.RADI_PATH AS "HID_RADI PATH", ' .
            $sqlFecha . ' AS "DAT_Fecha radicado", 
				R.RADI_NUME_RADI AS "HID_Numero Radicado", 
				A.SGD_DIR_NOMREMDES AS "Remitente", 
				A.SGD_DIR_DOC AS "HID_Identificacion",
				R.RADI_USU_ANTE AS "Reasignado por" 
			FROM RADICADO R 
			INNER JOIN HIST_EVENTOS H ON R.RADI_NUME_RADI = H.RADI_NUME_RADI 
			INNER JOIN SGD_DIR_DRECCIONES A ON R.RADI_NUME_RADI = A.RADI_NUME_RADI 
			WHERE ' . $db->conn->SQLDate('Y/m/d', 'H.HIST_FECH') . " BETWEEN '" . $fecha_ini . "' and '" . $fecha_fin . "
				' AND R.RADI_USUA_ACTU = " . $_SESSION["codusuario"] . " AND R.RADI_DEPE_ACTU = " . $_SESSION["dependencia"] . " " . $sWhere; //."
    //GROUP BY R.RADI_NUME_RADI, R.RADI_PATH, R.RADI_NUME_RADI,  ".$sqlFecha.", A.SGD_DIR_NOMREMDES, A.SGD_DIR_DOC";



    $sql .= ($orderNo < 6) ? $c_order : '';
    $ADODB_FETCH_MODE = 2;
    $db->conn->SetFetchMode(ADODB_FETCH_BOTH);
    $ADODB_COUNTRECS = true;
    $temp_rs = $db->conn->Execute($sql);
    $csvpager1 = $db->conn->Execute($sql);
    $ADODB_COUNTRECS = false;
    if ($temp_rs) {
        $nregis = $temp_rs->recordcount();
        $fldTota1 = $nregis;
    }
    else
        $fldTota1 = 0;
    $temp_rs->Close();

    $pager1 = new ADODB_Pager($db, $sql, 'adodb', true, $orderNo, $orderTipo);
    $pager1->toRefLinks = $linkPagina;
    $pager1->toRefVars = $variables;
    $pager1->txtBusqueda = trim($palabra);
    $pager1->UsrSec = $UsrSecAux;

    // Preparacion del listado de -- APAREZCO COMO HISTORICO
    $sql = 'SELECT DISTINCT R.RADI_NUME_RADI AS "IMG_Numero radicado",
				R.RADI_PATH AS "HID_RADI PATH", ' .
            $sqlFecha . ' as "DAT_Fecha radicado", 
				R.RADI_NUME_RADI AS "HID_Numero Radicado",
				A.SGD_DIR_NOMREMDES AS "Remitente", 
				A.SGD_DIR_DOC AS "HID_Identificacion",
				D.DEPE_NOMB AS "Dependencia actual", 
				R.RADI_USUA_ACTU AS "Usuario actual", ' .
            $db->conn->concat('R.RADI_DEPE_ACTU', "'-'", 'R.RADI_USUA_ACTU', "'-'", 'R.SGD_SPUB_CODIGO', "'-'", 'R.CODI_NIVEL') . ' AS "HID_priv "
			FROM RADICADO R 
			INNER JOIN HIST_EVENTOS H ON R.RADI_NUME_RADI = H.RADI_NUME_RADI 
			INNER JOIN SGD_DIR_DRECCIONES A ON R.RADI_NUME_RADI = A.RADI_NUME_RADI 
			INNER JOIN DEPENDENCIA D ON R.RADI_DEPE_ACTU = D.DEPE_CODI
			WHERE ' . $db->conn->SQLDate('Y/m/d', 'H.HIST_FECH') . ' BETWEEN \'' . $fecha_ini . '\' and \'' . $fecha_fin . '\'
				 AND A.SGD_DIR_TIPO=1 AND H.USUA_CODI = ' . $_SESSION["codusuario"] .
            ' AND H.DEPE_CODI = ' . $_SESSION["dependencia"] . ' ' . $sWhere; //'
    //GROUP BY R.RADI_NUME_RADI, R.RADI_PATH, R.RADI_DEPE_ACTU, R.RADI_USUA_ACTU '.$sqlFecha.', A.SGD_DIR_NOMREMDES, 
    //	A.SGD_DIR_DOC, D.DEPE_NOMB, '.$db->conn->concat('R.RADI_DEPE_ACTU',"'-'",'R.RADI_USUA_ACTU',"'-'",'R.SGD_SPUB_CODIGO',"'-'",'R.CODI_NIVEL'). $c_order;


    $ADODB_COUNTRECS = true;
    $temp_rs = $db->conn->Execute($sql);
    $csvpager2 = $db->conn->Execute($sql);
    $ADODB_COUNTRECS = false;
    if ($temp_rs) {
        $nregis = $temp_rs->recordcount();
        $fldTota2 = $nregis;
    }
    else
        $fldTota2 = 0;
    $temp_rs->Close();

    $pager2 = new ADODB_Pager($db, $sql, 'adodb', true, $orderNo, $orderTipo);
    $pager2->toRefLinks = $linkPagina;
    $pager2->toRefVars = $variables;
    $pager2->txtBusqueda = trim($palabra);
    $pager2->UsrSec = $UsrSecAux;
}
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
//  COMBO DE TIPOS DE RADICADOS
$rs = $db->conn->Execute('select SGD_TRAD_DESCR, SGD_TRAD_CODIGO  from SGD_TRAD_TIPORAD order by 2');
$cmb_trad = $rs->GetMenu2('tipoRadicado', $tipoRadicado, $blank1stItem = "9999:Todos los tipos (-1,-2,-3,-5, . . .)", false, 0, 'class=select');

//COMBO TIPO TIPO DOCUMENTAL
$rs = $db->conn->Execute('select SGD_TPR_DESCRIP, SGD_TPR_CODIGO from SGD_TPR_TPDCUMENTO order by 1');
$cmb_tdoc = $rs->GetMenu2('tipoDocumento', $tipoDocumento, $blank1stItem = "9999:Todos los tipos", false, 0, 'class=select');

//COMBO DE DEPENDENCIAS
$rs = $db->conn->Execute('select DEPE_NOMB, DEPE_CODI from DEPENDENCIA where depe_estado=1 order by 1');
$default_str = $dependenciaSel;
$cmb_depe = $rs->GetMenu2('dependenciaSel', $dependenciaSel, $blank1stItem = "99999:Todas las dependencias", false, 0, 'class=select');
?>
<HTML>
    <head>
        <title>Consultas</title>
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta http-equiv="cache-control" content="no-cache">
        <link rel="stylesheet" href="Site.css" type="text/css">
         <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
          <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/tabber.css"?>" type="text/css" media="screen">
        <script>
            function limpiar()
            {
                document.Search.elements['n_nume_radi'].value = "";
                document.Search.elements['palabra'].value = "";
                document.Search.elements['dependenciaSel'].value = "99999";
                document.Search.elements['tipoDocumento'].value = "9999";
                document.Search.elements['s_entrada'].checked=1;
                document.Search.elements['s_salida'].checked=1;	 
                document.Search.s_solo_nomb[0].checked = true; 	
            }
            function noPermiso(tip)
            {
                if(tip==0)
                    alert ("No tiene permiso para acceder, su nivel es inferior al del usuario actual");
                if(tip==1)
                    alert ("No tiene permiso para ver la imagen, el Radicado es confidencial");
            }
        </script>
    </head>
    <body class="PageBODY" topmargin="0" onload="document.getElementById('n_nume_radi').focus();">
        <div id="spiffycalendar" class="text"></div>
        <link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
        <script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
        <script language="JavaScript"><!--
            var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "Search", "fecha_ini","btnDate1","<?= $fecha_ini ?>",scBTNMODE_CUSTOMBLUE);
            var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "Search", "fecha_fin","btnDate2","<?= $fecha_fin ?>",scBTNMODE_CUSTOMBLUE);
            --></script>
        <form method="post" action="<?= $encabezadol ?>" name="Search">
            <table border=0 cellpadding=0 cellspacing=2 class='borde_tab'>
                <tr>
                    <td  class="titulos4" colspan="3"><a name="Search">B&Uacute;SQUEDAS POR:</td>
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
                    <td colspan="3" valign="top">
                        <table width=100%  class="FormTABLE">
                            <tr> 
                                <td class="titulos5">Radicado</td>
                                <td class="listado5"><input class="tex_area" type="text" name="n_nume_radi" id="n_nume_radi" maxlength="14" value="<?= $n_nume_radi ?>" size="20" ></td>
                            </tr>
                            <tr>
                                <td class="titulos5">
                                    <INPUT type="radio" NAME="s_solo_nomb" CHECKED value="All" <?
if ($s_solo_nomb == "All") {
    echo ("CHECKED");
}
?>>Todas las palabras (y)<br>
                                    <INPUT type="radio" NAME="s_solo_nomb" value="Any" <?
                                           if ($s_solo_nomb == "Any") {
                                               echo ("CHECKED");
                                           }
?>>Cualquier palabra (o)<br>
                                </td>
                                <td class="titulos5"><input class="tex_area" type="text" name="palabra" maxlength="70" value="<?= $palabra ?>" size="70" ></td>
                            </tr>
                            <tr>
                                <td class="titulos5"> Tipo radicado :</td>
                                <td class="listado5"> <?php echo $cmb_trad ?></td>
                            </tr>
                            <tr>
                                <td class="titulos5">Desde fecha (dd/mm/yyyy)</td>
                                <td class="listado5">
                                    <script language="Javascript">
                                        dateAvailable.writeControl();
                                        dateAvailable.dateFormat="yyyy/MM/dd";
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td class="titulos5">Hasta fecha (dd/mm/yyyy)</td>
                                <td class="listado5">
                                    <script language="Javascript">
                                        dateAvailable1.writeControl();
                                        dateAvailable1.dateFormat="yyyy/MM/dd";
                                    </script>
                                </td>
                            </tr>
                            <tr> 
                                <td class="titulos5">Tipo de documento</td>
                                <td class="listado5">
                                    <?php echo $cmb_tdoc ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="titulos5">Dependencia actual</td>
                                <td class="listado5">
                                    <?php echo $cmb_depe ?>
                                </td>
                            </tr>
                            <tr>
                                <td align="right" colspan="2">
                                    <input name="button" type="button" class="botones" onClick="limpiar();" value="Limpiar">
                                    <input name="submit" type="submit" class="botones" value="Buscar">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <?php
            if (isset($_POST['submit']) or
                    $tipoRadicado or
                    $tipoDocumento or
                    $dependenciaSel or
                    $adodb_next_page or $orderNo or $orderTipo or $orden_cambio) {
                echo("<table width=100%><tr><td class='titulos5'>Radicados en los que aparezco como actual.</td></tr>");
                echo("<tr><td class='info'>Total registros encontrados: " . $fldTota1 . ".</td></tr><tr><td>");
                $pager1->Render($rows_per_page = 10, $linkPagina, $checkbox = chkAnulados);
                echo("</td></tr></table>");
                if ($csvpager1->EOF || !$csvpager1) {
                    
                } else {
                    if (!isset($carpetaBodega)) {
                        include "$ruta_raiz/config.php";
                    }
                    include_once("$ruta_raiz/adodb/toexport.inc.php");

                    $ruta = "$ruta_raiz/" . $carpetaBodega . "tmp/Busqhist_actual" . date('Y_m_d_H_i_s') . ".csv";
                    $f = fopen($ruta, 'w');
                    if ($f) {
                        rs2csvfile($csvpager1, $f);
                        echo "<a href='$ruta' target='_blank'><img style='border:0px' width='20' height='20' src='" . $ruta_raiz . "/imagenes/csv.png' alt='Archivo CSV'/>Archivo CSV</a>";
                    }
                }

                echo("<table width=100%><tr><td class='titulos5'>Radicados en los que aparezco como hist&oacute;rico.</td></tr>");
                echo("<tr><td class='info'>Total registros encontrados: " . $fldTota2 . ".</td></tr><tr><td>");
                $pager2->Render($rows_per_page = 10, $linkPagina, $checkbox = chkAnulados);
                echo("</td></tr></table>");
                if ($csvpager2->EOF || !$csvpager2) {
                    
                } else {
                    if (!isset($carpetaBodega)) {
                        include "$ruta_raiz/config.php";
                    }
                    include_once("$ruta_raiz/adodb/toexport.inc.php");

                    $ruta = "$ruta_raiz/" . $carpetaBodega . "tmp/Busqhist_historico" . date('Y_m_d_H_i_s') . ".csv";
                    $f = fopen($ruta, 'w');
                    if ($f) {
                        rs2csvfile($csvpager2, $f);
                        echo "<a href='$ruta' target='_blank'><img style='border:0px' src='" . $ruta_raiz . "/imagenes/csv.png' alt='Archivo CSV'/></a>";
                    }
                }
            }
            ?>
        </form>
    </body>
</HTML>
