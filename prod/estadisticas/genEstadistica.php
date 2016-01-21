<?php
/* * ********************************************************************************** */
/* ORFEO GPL:Sistema de Gestion Documental		http://www.orfeogpl.org	     */
/* 	Idea Original de la SUPERINTENDENCIA DE SERVICIOS PUBLICOS DOMICILIARIOS     */
/* 				COLOMBIA TEL. (57) (1) 6913005  orfeogpl@gmail.com   */
/* ===========================                                                       */
/*                                                                                   */
/* Este programa es software libre. usted puede redistribuirlo y/o modificarlo       */
/* bajo los terminos de la licencia GNU General Public publicada por                 */
/* la "Free Software Foundation"; Licencia version 2. 			             */
/*                                                                                   */
/* Copyright (c) 2005 por :	  	  	                                     */
/* SSPS "Superintendencia de Servicios Publicos Domiciliarios"                       */
/*   Jairo Hernan Losada  jlosada@gmail.com                Desarrollador             */
/*   Sixto Angel Pinzón López --- angel.pinzon@gmail.com   Desarrollador             */
/* C.R.A.  "COMISION DE REGULACION DE AGUAS Y SANEAMIENTO AMBIENTAL"                 */
/*   Liliana Gomez        lgomezv@gmail.com                Desarrolladora            */
/*   Lucia Ojeda          lojedaster@gmail.com             Desarrolladora            */
/* D.N.P. "Departamento Nacional de Planeación"                                      */
/*   Hollman Ladino       hladino@gmail.com                Desarrollador             */
/*                                                                                   */
/* Colocar desde esta lInea las Modificaciones Realizadas Luego de la Version 3.5    */
/*  Nombre Desarrollador   Correo     Fecha   Modificacion                           */
/* * ********************************************************************************** */
?>
<?php
if (!$db) {
    $krdOld = $krd;
    $carpetaOld = $carpeta;
    $tipoCarpOld = $tipo_carp;
    if (!$tipoCarpOld)
        $tipoCarpOld = $tipo_carpt;
    session_start();
    if (!$krd)
        $krd = $krdOsld;
    $ruta_raiz = "..";
//	include "$ruta_raiz/rec_session.php";
    if (isset($_GET['genDetalle']) || isset($_GET['genTodosDetalle'])) {
        ?>	
        <html>
            <title>ORFEO - IMAGEN ESTADISTICAS </title>
            <link rel="stylesheet" href="../estilos/orfeo.css" />
            <body>
            <CENTER>
                <?php
            }
            include "$ruta_raiz/envios/paEncabeza.php";
            ?>
            <table><tr><TD></TD></tr></table>
            <?php
            include_once "$ruta_raiz/include/db/ConnectionHandler.php";
            require_once("$ruta_raiz/class_control/Mensaje.php");
            include("$ruta_raiz/class_control/usuario.php");
            $db = new ConnectionHandler($ruta_raiz);

            $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
            $objUsuario = new Usuario($db);
            if (isset($dependencia_busq) && $dependencia_busq != '99999') {
                $dependencia_busq = $_GET["dependencia_busq"];
                $whereDependencia = " AND DEPE_CODI=$dependencia_busq ";
            }
            else
                $whereDependencia = " AND DEPE_CODI is not null ";
            $datosaenviar = "fechaf=$fechaf&genDetalle=$genDetalle&tipoEstadistica=$tipoEstadistica&idSerie=$idSerie&codus=$codus&krd=$krd&dependencia_busq=$dependencia_busq&ruta_raiz=$ruta_raiz&fecha_ini=$fecha_ini&fecha_fin=$fecha_fin&tipoRadicado=$tipoRadicado&tipoDocumento=$tipoDocumento&codUs=$codUs&fecSel=$fecSel";
        }
        $seguridad = ",r.SGD_SPUB_CODIGO,b.CODI_NIVEL as  USUA_NIVEL";
        $dependenciarad = ", r.RADI_DEPE_ACTU ";

        $whereTipoRadicado = "";
        if ($tipoRadicado) {
            $whereTipoRadicado = " AND cast(r.RADI_NUME_RADI AS VARCHAR(14)) LIKE '%$tipoRadicado'";
        }
        if ($tipoRadicado and ($tipoEstadistica == 1 or $tipoEstadistica == 6)) {
            $whereTipoRadicado = " AND cast(r.RADI_NUME_RADI AS VARCHAR(14)) LIKE '%$tipoRadicado'";
        }
        $codus = (isset($codus) ? $codus : $codUs);
        if ($codus) {
            $whereTipoRadicado.=" AND b.USUA_CODI = $codus ";
        } elseif (!$codus and $usua_perm_estadistica < 1) {
            $whereTipoRadicado.=" AND b.USUA_CODI = $codusuario ";
        }
        if ($tipoDocumento and ($tipoDocumento != '9999' and $tipoDocumento != '9998' and $tipoDocumento != '9997')) {
            $whereTipoRadicado.=" AND t.SGD_TPR_CODIGO = $tipoDocumento ";
        } elseif ($tipoDocumento == "9997") {
            $whereTipoRadicado.=" AND t.SGD_TPR_CODIGO = 0 ";
        }
        if ($_POST["tramitado"]==2)
        {
            $whereTipoRadicado .= "AND r.radi_nume_deri is not null";
        }
        else if($_POST["tramitado"]==1) {
                $whereTipoRadicado .= "AND r.radi_nume_deri is null";
            }
        include_once($ruta_raiz . "/include/query/busqueda/busquedaPiloto1.php");
//echo(" tipo $tipoEstadistica ");	
        switch ($tipoEstadistica) {
            case "1":
		
                include "$ruta_raiz/include/query/estadisticas/consulta001.php";
                $generar = "ok";
                break;
            case "2":
                include "$ruta_raiz/include/query/estadisticas/consulta002.php";
                $generar = "ok";
                break;
            case "3":
                include "$ruta_raiz/include/query/estadisticas/consulta003.php";
                $generar = "ok";
                break;
            case "4":
                include "$ruta_raiz/include/query/estadisticas/consulta004.php";
                $generar = "ok";
                break;
            case "5":
                include "$ruta_raiz/include/query/estadisticas/consulta005.php";
                $generar = "ok";
                break;
            case "6":
                include "$ruta_raiz/include/query/estadisticas/consulta006.php";
                $generar = "ok";
                break;
            case "7":
                include "$ruta_raiz/include/query/estadisticas/consulta007.php";
                $generar = "ok";
                break;
            case "8":
                include "$ruta_raiz/include/query/estadisticas/consulta008.php";
                $generar = "ok";
                break;
            case "9":
                include "$ruta_raiz/include/query/estadisticas/consulta009.php";
                $generar = "ok";
                break;
            case "10":
                include "$ruta_raiz/include/query/estadisticas/consulta010.php";
                $generar = "ok";
                break;
            case "11":
                include "$ruta_raiz/include/query/estadisticas/consulta011.php";
                $generar = "ok";
                break;
            case "12":
                include "$ruta_raiz/include/query/estadisticas/consulta012.php";
                $generar = "ok";
                break;
            case "13":
                include "$ruta_raiz/include/query/estadisticas/consulta013.php";
                $generar = "ok";
                break;
            case "14":
                include "$ruta_raiz/include/query/estadisticas/consulta014.php";
                $generar = "ok";
                break;
            case "15":
                include "$ruta_raiz/include/query/estadisticas/consulta015.php";
                $generar = "ok";
                break;
            case "20":
                include "$ruta_raiz/include/query/estadisticas/consulta020.php";
                $generar = "ok";
                break;
        }

        /*         * *******************************************************************************
          Modificado Por: Supersolidaria
          Fecha: 15 diciembre de 2006
          Descripción: Se incluyó el reporte de radicados archivados reporte_archivo.php
         * ******************************************************************************** */
        if ($tipoReporte == 1) {
            include "$ruta_raiz/include/query/archivo/queryReportePorRadicados.php";
            $generar = "ok";
        }
        
//        $db->conn->debug = true;
        if ($generar == "ok") {
            if ($genDetalle == 1)
                $queryE = $queryEDetalle;
            if ($genTodosDetalle == 1)
                $queryE = $queryETodosDetalle;
//	$db->conn->debug = true;
            $rsE = $db->conn->Execute($queryE);
	
		
            echo "<!-- HLP : $queryE  -->";
            include ("tablaHtml.php");
        }

// Generamos enlace a archivo XML
        if ($genDetalle == 1 || $genTodosDetalle == 1) {
            if ($tipoEstadistica) {//==9
                if (!isset($carpetaBodega)) {
                    include "$ruta_raiz/config.php";
                }
                include_once("$ruta_raiz/adodb/toexport.inc.php");
                /**
                  require "$ruta_raiz/include/class/RecordSetToXml.class.php";
                  $objXml = new RecodSetToXml($rsE);
                  if ($objXml) {
                  $ruta = "$ruta_raiz/$carpetaBodega/tmp/Est".date('Y_m_d_H_i_s').".xml";
                  $f = fopen($ruta, 'w');
                  if ($f) {
                  fwrite($f,$objXml->creaXml());
                  fclose($f);
                  echo "<br/><a href='$ruta' target='_blank'><img style='border:0px' src='$ruta_raiz/imagenes/xml.png' alt='Archivo xml'/></a>";
                  }
                  }
                 */
                $ruta = "$ruta_raiz/$carpetaBodega/tmp/Est" . date('Y_m_d_H_i_s') . ".csv";
                $f = fopen($ruta, 'w');
                if ($f) {
                    unset($rsE->fields['USUA_NIVEL']);
                    unset($rsE->fields['SGD_SPUB_CODIGO']);
                    rs2csvfile($rsE, $f);
                    //echo "<a href='$ruta' target='_blank'><img style='border:0px' width='20' height='20' src='$ruta_raiz/imagenes/csv.png' alt='Archivo CSV'/>Archivo CSV</a>";
                }
            }
        }
        ?>
