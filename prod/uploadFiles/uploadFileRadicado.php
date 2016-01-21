<?
$krdOld = $krd;
session_start();
if (!$krd)
    $krd = $krdOsld;
$ruta_raiz = "..";
if (!isset($_SESSION['dependencia']))
    include "$ruta_raiz/rec_session.php";
error_reporting(7);
$verrad = "";
/** PROGRAMA DE CARGA DE IMAGENES DE RADICADOS
 * @author JAIRO LOSADA - DNP - SSPD
 * @version Orfeo 3.5.1
 *
 * @param $varBuscada sTRING Contiene el nombre del campo que buscara
 * @param $krd  string Trae el Login del Usuario actual
 * @param $isql strig Variable temporal que almacena consulta
 */
?>
<HTML>
    <head>
        <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
    </head>
    <BODY>
        <FORM ACTION="<?= $_SERVER['PHP_SELF'] ?>?krd=<?= $krd ?>&<?= session_name() ?>=<?= session_id() ?>" method="POST">
            <?
            /**
             * @param $varBuscada string Contiene el nombre del campo que buscara
             * @param $busq_radicados_tmp sting Almacena cadena de busqueda de radicados generada por pagina paBuscar.php
             */
            include "$ruta_raiz/envios/paEncabeza.php";
            include_once "$ruta_raiz/include/query/busqueda/busquedaPiloto1.php";
            $varBuscada = $radi_nume_radi;
            include "$ruta_raiz/envios/paBuscar.php";
            $encabezado = "" . session_name() . "=" . session_id() . "&krd=$krd&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&chkCarpeta=$chkCarpeta&busqRadicados=$busqRadicados&nomcarpeta=$nomcarpeta&agendado=$agendado&";
            $linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";
            $encabezado = "" . session_name() . "=" . session_id() . "&adodb_next_page=1&krd=$krd&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&nomcarpeta=$nomcarpeta&agendado=$agendado&orderTipo=$orderTipo&orderNo=";
            ?>
        </FORM>
        <FORM ACTION="formUpload.php?krd=<?= $krd ?>&<?= session_name() ?>=<?= session_id() ?>" method="POST">
            <center><input type="submit" value="Asociar imagen del radicado" name=asocImgRad class="botones_largo"><input type="submit" value="Asociar imagen como anexo a radicado" name=anexImgRad class="botones_largo"></center>
                <?
///validacion de permisos de digitalizacion 
                $sql_perm = "select perm_radi from usuario where usua_codi=" . $_SESSION['codusuario'] . " and depe_codi = " . $_SESSION['depecodi'];
                $rs_perm = $db->conn->Execute($sql_perm);
                if ($rs_perm) {
                    if ($rs_perm->fields['PERM_RADI'] == 1)
                        $where_perm = " AND  RADI_PATH like '%.odt%' or RADI_PATH is null";
                    else
                        $where_perm = "";
                }
                else
                    die("fallo en la consulta $sql_perm");
                if ($Buscar AND $busq_radicados_tmp) {
                    include "$ruta_raiz/include/query/uploadFile/queryUploadFileRad.php";
                    $rs = $db->conn->Execute($query);

                    //$db->conn->debug=true;
                    if ($rs->EOF) {
                        echo "<hr><center><b><span class='alarmas'>No se encuentra ningun radicado con el criterio de busqueda</span></center></b></hr>";
                    } else {
                        $orderNo = 1;
                        $orderTipo = " Desc ";
                        $pager = new ADODB_Pager($db, $query, 'adodb', true, $orderNo, $orderTipo);
                        $pager->checkAll = false;
                        $pager->checkTitulo = true;
                        $pager->toRefLinks = $linkPagina;
                        $pager->toRefVars = $encabezado;
                        $pager->descCarpetasGen = $descCarpetasGen;
                        $pager->descCarpetasPer = $descCarpetasPer;
                        $pager->Render($rows_per_page = 100, $linkPagina, $checkbox = chkAnulados);
                    }
                }
                ?>
        </FORM>
    </BODY>
</HTML>
