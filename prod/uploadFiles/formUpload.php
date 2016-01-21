<?
$krdOld = $krd;
$carpetaOld = $carpeta;
$tipoCarpOld = $tipo_carp;
session_start();
if (!$krd)
    $krd = $krdOsld;
$ruta_raiz = "..";

if (!$_SESSION['dependencia'])
    include "$ruta_raiz/rec_session.php";
require_once("$ruta_raiz/class_control/Dependencia.php");

/**
 * Retorna la cantidad de bytes de una expresion como 7M, 4G u 8K.
 *
 * @param char $var
 * @return numeric
 */
function return_bytes($val) {
    $val = trim($val);
    $ultimo = strtolower($val{strlen($val) - 1});
    switch ($ultimo) { // El modificador 'G' se encuentra disponible desde PHP 5.1.0
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
    }
    return $val;
}
?>
<html>
    <head>
        <title>Enviar Datos</title>
        <link rel="stylesheet" href="../estilos/orfeo.css">
        <script>
            function notSupported(){ alert('Su browser no soporta las funciones Javascript de esta pagina.'); }
            function setSel(start,end){
                document.realizarTx.observa.focus();
                var t=document.realizarTx.observa;
                if(t.setSelectionRange){
                    t.setSelectionRange(start,end);
                    t.focus();
                    //f.t.value = t.value.substr(t.selectionStart,t.selectionEnd-t.selectionStart);
                } else notSupported();
            }

            function valMaxChars(maxchars)
            {
                if(document.realizarTx.observa.value.length > 0)
                {
                    if (document.realizarTx.observa.value.length > maxchars)
                    {	alert('Demasiados caracteres en el texto, solo se permiten '+ maxchars);
                        setSel(maxchars,document.realizarTx.observa.value.length);
                        document.realizarTx.observa.focus();
                        return false;
                    }
                    else return true;
                }
                else
                {	alert('Ingrese observaciones!!');
                    document.realizarTx.observa.focus();
                    return false;
                }
            }

            function validar()
            {    archivo_up = document.getElementById('upload').value;
                extension = archivo_up.substr(archivo_up.lastIndexOf(".")+1,archivo_up.length-archivo_up.lastIndexOf(".")+1).toLowerCase();
                if (valMaxChars(100))
                {	if (document.realizarTx.upload.value.length == 0)
                    {	alert('Seleccione la imagen a adjutar...');
                        document.realizarTx.upload.focus();
                        return false;
                    }
                    if(extension!='pdf'&& extension!='tif'&& extension!='jpg' && extension!='tiff')
                    {
                        alert('Debe subir archivo pdf, tif, tiff o jpg');
                        document.realizarTx.upload.focus();
                        return false;
                    }
                    else 
                    {
                        return true;
                    }
                }
                else return false;
            }

        </script>
        <?
        /*  FILTRO DE DATOS
         *  @$setFiltroSelect  Contiene los valores digitados por el usuario separados por coma.
         *  @$filtroSelect Si SetfiltoSelect contiene algunvalor la siguiente rutina realiza el arreglo de la condici� para la consulta a la base de datos y lo almacena en whereFiltro.
         *  @$whereFiltro  Si filtroSelect trae valor la rutina del where para este filtro es almacenado aqui.
         *
         */


        if (!strlen(trim($valRadio))) {
            DIE("<TABLE><tr><td></td></tr></TABLE><center><table class='borde_tab' width=100% CELSPACING=5><tr class=titulosError><td><center>NO HAY REGISTROS SELECCIONADOS</CENTER></td></tr></table><center>");
        } else {
            
        }
        /*
         * OPERACIONES EN JAVASCRIPT
         * @marcados Esta variable almacena el numeo de chaeck seleccionados.
         * @document.realizarTx  Este subNombre de variable me indica el formulario principal del listado generado.
         * @tipoAnulacion Define si es una solicitud de anulacion  o la Anulacion Final del Radicado.
         *
         * Funciones o Metodos EN JAVA SCRIPT
         * Anular()  Anula o solicita esta dependiendo del tipo de anulacin.  Previamente verifica que este seleccionado algun  radicado.
         * markAll() Marca o desmarca los check de la pagina.
         *
         */
        ?>
        <script>

            function markAll(noRad)
            {
                if(document.realizarTx.elements.check_titulo.checked || noRad >=1)
                {
                    for(i=3;i<document.realizarTx.elements.length;i++)
                    {
                        document.realizarTx.elements[i].checked=1;
                    }
                }
                else
                {
                    for(i=3;i<document.realizarTx.elements.length;i++)
                    {
                        document.realizarTx.elements[i].checked=0;
                    }
                }
            }

        </script>
        <?
        /**
         * Inclusion de archivos para utiizar la libreria ADODB
         *
         */
        include_once "$ruta_raiz/include/db/ConnectionHandler.php";
        $db = new ConnectionHandler("$ruta_raiz");
        $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
        $objDep = new Dependencia($db);
        /*
         * Genreamos el encabezado que envia las variable a la paginas siguientes.
         * Por problemas en las sesiones enviamos el usuario.
         * @$encabezado  Incluye las variables que deben enviarse a la singuiente pagina.
         * @$linkPagina  Link en caso de recarga de esta pagina.
         */
        $encabezado = "" . session_name() . "=" . session_id() . "&krd=$krd&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion";
        $linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=";
        ?>
    </head>
    <body bgcolor="#FFFFFF" topmargin="0" onLoad="markAll(1);">
        <form <?php
        if ($_POST['anexImgRad']) {
            echo "action=\"uploadAnTx.php?$encabezado\"";
        } else {
            echo "action=\"uploadTx.php?$encabezado\"";
        }
        ?> method="post" name="realizarTx" enctype="multipart/form-data">
            <table border=0 width=100% cellpadding="0" cellspacing="0">
                <tr>
                    <td width=100%>
                        <br>
                        <input type='hidden' name=depsel8 value='<?= $depsel8 ?>'>
                        <input type='hidden' name=codTx value='<?= $codTx ?>'>
                        <input type='hidden' name=EnviaraV value='<?= $EnviaraV ?>'>
                        <input type='hidden' name=fechaAgenda value='<?= $fechaAgenda ?>'>
                        <table width="98%" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
                            <tr>
                                <td width=30% class="titulos4">
                                    USUARIO:<br><br><?= $_SESSION['usua_nomb'] ?>
                                </td>
                                <td width='30%' class="titulos4">
                                    DEPENDENCIA:<br><br><?= $_SESSION['depe_nomb'] ?><br>
                                </td>
                                <td class="titulos4">
                                    <?php
                                    if ($_POST['anexImgRad']) {
                                        echo "Asociaci&oacute;n de imagen como anexo a radicado";
                                    } else {
                                        echo "Asociaci&oacute;n de Imagen a Radicado";
                                    }
                                    ?><BR></td>
                                <td width='5' class="grisCCCCCC">
                                    <input type="submit" value="Realizar" name="Realizar" align="bottom" class="botones" id="Realizar" onclick="return validar();">
                                </td>
                            </tr>
                            <tr align="center">
                                <td colspan="4" class="celdaGris" align=center><br>
                                    <?
                                    if ((($codusuario == 1) || ($usuario_reasignacion == 1)) && !$_POST['anexImgRad']) {
                                        ?>
                                        <input type=checkbox name=chkNivel checked class=ebutton>
                                        <span class="info">El documento tomara el nivel del usuario destino.</span><br>
                                        <?
                                    }
                                    ?>
                            <center>
                                <table width="500"  border=0 align="center" bgcolor="White">
                                    <tr bgcolor="White">
                                        <td width="100">
                                    <center>
                                        <img src="<?= $ruta_raiz ?>/iconos/tuxTx.gif" alt="Tux Transaccion" title="Tux Transaccion">
                                    </center>
                                    </td>
                                    <td align="left">
                                        <textarea name="observa" id="observa" cols=70 rows=3 class=tex_area></textarea>
                                    </td>
                                    </tr>
                                </table>
                            </center>
                            <input type=hidden name=enviar value=enviarsi>
                            <input type=hidden name=enviara value='9'>
                            <input type=hidden name=carpeta value=12>
                            <input type=hidden name=carpper value=10001>
                            </td>
                            </tr>
                            <tr>
                                <td colspan=5 align="center">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo return_bytes(ini_get('upload_max_filesize')); ?>"><br>
                                    <span class="leidos">Seleccione un Archivo (pdf, tif o jpg   Tama&ntilde;o Max. <?= ini_get('upload_max_filesize') ?>)<input type="file" name="upload" id="upload" size="50" class=tex_area></span>
                                    <input type="hidden" name="replace" value="y">
                                    <input type="hidden" name="valRadio" value="<?= $valRadio ?>">
                                    <input name="check" type="hidden" value="y" checked>
                                </td>
                            </tr>
                            <?php
                            if ($_POST['anexImgRad']) {
                                $sqlTPR = "select SGD_TPR_DESCRIP,SGD_TPR_CODIGO from SGD_TPR_TPDCUMENTO";
                                $rsTPR = $db->conn->Execute($sqlTPR);
                                $nmenu = "tipoDoc";
                                $valor = "";
                                $default_str = $tipoDoc;
                                $itemBlanco = " -- Seleccione -- ";
                                ?>
                                <tr>
                                    <td colspan = 5 align = "center">
                                        <span class="leidos">
                                            Tipo documental:
                                            <?php
                                            echo $rsTPR->GetMenu2($nmenu, $default_str, $blank1stItem = "$valor:$itemBlanco", false, 0, 'class=select');
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        <br>
                    </td>
                </tr>
            </table>
            <?
            if ($_POST['anexImgRad']) {
                $verradicado = $verrad;
                $ruta_raiz_archivo = $ruta_raiz;
                $directoriobase = "$ruta_raiz_archivo/$carpetaBodega/";
                //include_once("$ruta_raiz/class_control/anexo.php");
                //include_once "$ruta_raiz/include/db/ConnectionHandler.php";
                //require_once("$ruta_raiz/class_control/TipoDocumento.php");
                //include_once "$ruta_raiz/class_control/firmaRadicado.php";
                include_once "$ruta_raiz/config.php";
                //require_once("$ruta_raiz/class_control/ControlAplIntegrada.php");
                //require_once("$ruta_raiz/class_control/AplExternaError.php");
                //$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug = true;
                //$objTipoDocto = new TipoDocumento($db);
                //$objTipoDocto->TipoDocumento_codigo($tdoc);
                //$objFirma = new FirmaRadicado($db);
                //$objCtrlAplInt = new ControlAplIntegrada($db);
                //$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
                $num_archivos = 0;
                //$anex = & new Anexo($db);
                $sqlFechaDocto = $db->conn->SQLDate("Y-m-D H:i:s A", "a.sgd_fech_doc");
                $sqlFechaAnexo = $db->conn->SQLDate("Y-m-D H:i:s A", "a.anex_fech_anex");
                $sqlSubstDesc = $db->conn->substr . "(a.anex_desc, 0, 50)";
                include_once("$ruta_raiz/include/query/busqueda/busquedaPiloto1.php");
                $anexSql = "select a.anex_codigo AS DOCU
            ,at.anex_tipo_ext AS EXT
	    ,a.anex_tamano AS TAMA
	    ,a.anex_solo_lect AS RO
            ,u.usua_nomb AS CREA
	    ,$sqlSubstDesc AS DESCR
	    ,a.anex_nomb_archivo AS NOMBRE
            ,case when a.SGD_TPR_CODIGO is NULL then 'NA' else (select tp.SGD_TPR_DESCRIP from SGD_TPR_TPDCUMENTO tp where tp.SGD_TPR_CODIGO=a.SGD_TPR_CODIGO) end AS TIPO
	    ,a.ANEX_CREADOR
	    ,a.ANEX_ORIGEN
            ,a.ANEX_SALIDA
	    ,$radi_nume_salida as RADI_NUME_SALIDA
	    ,a.ANEX_ESTADO
	    ,a.SGD_PNUFE_CODI
	    ,a.SGD_DOC_SECUENCIA
	    ,a.SGD_DIR_TIPO
	    ,a.SGD_DOC_PADRE
	    ,a.SGD_TPR_CODIGO
	    ,a.SGD_APLI_CODI
	    ,a.SGD_TRAD_CODIGO
	    ,a.SGD_TPR_CODIGO
	    ,a.ANEX_TIPO
	    ,$sqlFechaDocto as FECDOC
	    ,$sqlFechaAnexo as FEANEX
	    ,a.ANEX_TIPO as NUMEXTDOC
            ,a.SGD_REM_DESTINO
           from anexos a
           join anexos_tipo at on a.anex_tipo=at.anex_tipo_codi
           join usuario u on a.anex_creador=u.usua_login
           where a.anex_radi_nume=$valRadio
		 and a.anex_borrado='N'
	   order by 
                a.anex_radi_nume,a.radi_nume_salida asc, a.anex_codigo";
                //error_reporting(7);
                $rsAnex = $db->conn->Execute($anexSql);
                //echo "$valRadio";
                echo "<table BORDER='1' WIDTH='98%'>
                        <tr>
                            <th width='15%'  class='titulos2'>RADICADO</th>
                            <th  width='5%' class='titulos2'>TIPO</th>
                            <th  width='5%' class='titulos2'>TIPO DOC.</th>
                            <th  width='1%' class='titulos2'></th>
                            <th  width='5%' class='titulos2' >TAMA&Ntilde;O (Kb)</th>
                            <th  width='5%' class='titulos2' >SOLO LECTURA</th>
                            <th  width='20%' class='titulos2' >CREADOR</th>
                            <th  width='20%' class='titulos2'>DESCRIPCI&Oacute;N</th>
                            <th  width='12%' class='titulos2'>ANEXADO</th>
                        </tr>";
                if ($rsAnex)
                    while ($arr = $rsAnex->FetchRow()) {
                        $directoriobase = "$ruta_raiz_archivo/$carpetaBodega/";
                        $bandEnv = 0;
                        $aplinteg = $arr["SGD_APLI_CODI"];
                        $numextdoc = $arr["NUMEXTDOC"];
                        $tpradic = $arr["SGD_TRAD_CODIGO"];
                        $coddocu = $arr["DOCU"];
                        $origen = $arr["ANEX_ORIGEN"];
                        $radicado_rem = $arr["SGD_REM_DESTINO"];
                        $sol_lect = $arr["RO"];
                        $id_Dir_otro = "";
                        $linkarchivo = base64_encode($directoriobase . substr(trim($coddocu), 0, 4) . "/" . substr(trim($coddocu), 4, 3) . "/docs/" . trim($arr["NOMBRE"]));
                        $linkarchivo_vista = "$ruta_raiz/seguridadImagen.php?fec=" . base64_encode(substr(trim($coddocu), 0, 4) . "/" . substr(trim($coddocu), 4, 3) . "/docs/" . trim($arr["NOMBRE"]));
                        if ($arr["RADI_NUME_SALIDA"] != 0) {
                            $totalAnexos = 0;
                            $cod_radi = $arr["RADI_NUME_SALIDA"];
                        } else {
                            $cod_radi = $coddocu;
                        }
                        if (trim($linkarchivo)) {
                            $linkDef = "<b><a class=vinculos href='" . trim($linkarchivo_vista) . "'>" . trim(strtolower($cod_radi)) . "</a></b>";
                        } else {
                            $linkDef = trim(strtolower($cod_radi));
                        }
                        echo "<tr>
                            <td width='15%'  class='listado2'>{$linkDef}</th>
                            <td  width='5%' class='listado2'>{$arr['EXT']}</th>
                            <td  width='5%' class='listado2'>{$arr['TIPO']}</th>
                            <td  width='1%' class='listado2'></th>
                            <td  width='5%' class='listado2'>{$arr['TAMA']}</th>
                            <td  width='5%' class='listado2'>{$arr['RO']}</th>
                            <td  width='20%' class='listado2'>{$arr['CREA']}</th>
                            <td  width='20%' class='listado2'>{$arr['DESCR']}</th>
                            <td  width='12%' class='listado2'>{$arr['FEANEX']}</th>
                        </tr>";
                    } else {
                    echo "<tr>
                            <td width='15%'  class='listado2'></th>
                            <td  width='5%' class='listado2'></th>
                            <td  width='5%' class='listado2'></th>
                            <td  width='1%' class='listado2'></th>
                            <td  width='5%' class='listado2'></th>
                            <td  width='5%' class='listado2'></th>
                            <td  width='20%' class='listado2'></th>
                            <td  width='20%' class='listado2'></th>
                            <td  width='12%' class='listado2'></th>
                        </tr>";
                }
                echo "</table>";
                /* $pager = new ADODB_Pager($db, $anexSql, 'adodb', true, $orderNo, $orderTipo);
                  $pager->toRefLinks = $linkPagina;
                  $pager->toRefVars = $encabezado;
                  $pager->checkAll = true;
                  $pager->checkTitulo = true;
                  $pager->Render($rows_per_page = 20, $linkPagina, $checkbox = chkAnulados); */
            } else {
                /*  GENERACION LISTADO DE RADICADOS
                 *  Aqui utilizamos la clase adodb para generar el listado de los radicados
                 *  Esta clase cuenta con una adaptacion a las clases utiilzadas de orfeo.
                 *  el archivo original es adodb-pager.inc.php la modificada es adodb-paginacion.inc.php
                 */
                error_reporting(7);
                if (!$orderNo)
                    $orderNo = 0;
                $order = $orderNo + 1;
                $sqlFecha = $db->conn->SQLDate("d-m-Y H:i A", "b.RADI_FECH_RADI");
                $busq_radicados_tmp = "radi_nume_radi=$valRadio";
                include_once "../include/query/uploadFile/queryUploadFileRad.php";
                if ($codTx == 12) {
                    $isql = str_replace("Enviado Por", "Devolver a", $isql);
                }
                $pager = new ADODB_Pager($db, $query2, 'adodb', true, $orderNo, $orderTipo);
                $pager->toRefLinks = $linkPagina;
                $pager->toRefVars = $encabezado;
                $pager->checkAll = true;
                $pager->checkTitulo = true;
                $pager->Render($rows_per_page = 20, $linkPagina, $checkbox = chkAnulados);
            }
            ?>
            <input type='hidden' name=depsel value='<?= $depsel ?>'>
        </form>
    </body>
</html>
