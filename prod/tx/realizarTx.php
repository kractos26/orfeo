<?
session_start();
$ruta_raiz = "..";
if (!isset($_SESSION['dependencia']) or !isset($_SESSION['nivelus']))
    include "$ruta_raiz/rec_session.php";
if (true) {
    include "$ruta_raiz/config.php";
    include "$ruta_raiz/auxLib/PHPMailer/class.phpmailer.php";
    $mailObj = new PHPmailer(true);
    $mailObj->IsSMTP(); // enable SMTP
    $mailObj->CharSet = ini_get('default_charset');
    $mailObj->SMTPDebug = $SMTPDebug;  // debugging: 1 = errors and messages, 2 = messages only
    $mailObj->SMTPAuth = $SMTPAuth;  // authentication enabled
    $mailObj->SMTPSecure = $SMTPSecure; // secure transfer enabled REQUIRED for GMail
    $mailObj->Host = $Host;
    $mailObj->Port = $Port;
    $mailObj->Username = $Username;
    $mailObj->Password = $Password;
    $mailObj->From = $from;
    $mailObj->FromName = $from_name;
}
error_reporting(0);
/*  REALIZAR TRANSACCIONES
 *  Este archivo realiza las transacciones de radicados en Orfeo.
 */
?>
<html>
    <head>
        <title>Realizar Transaccion - Orfeo </title>
        <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
    </head>
    <?
    /**
     * Inclusion de archivos para utiizar la libreria ADODB
     *
     */
    include_once "$ruta_raiz/include/db/ConnectionHandler.php";
    $db = new ConnectionHandler("$ruta_raiz");
    /*
     * Genreamos el encabezado que envia las variable a la paginas siguientes.
     * Por problemas en las sesiones enviamos el usuario.
     * @$encabezado  Incluye las variables que deben enviarse a la singuiente pagina.
     * @$linkPagina  Link en caso de recarga de esta pagina.
     */
    $encabezado = "" . session_name() . "=" . session_id() . "&krd=$krd&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion";

    /*  FILTRO DE DATOS
     *  @$setFiltroSelect  Contiene los valores digitados por el usuario separados por coma.
     *  @$filtroSelect Si SetfiltoSelect contiene algunvalor la siguiente rutina realiza el arreglo de la condici� para la consulta a la base de datos y lo almacena en whereFiltro.
     *  @$whereFiltro  Si filtroSelect trae valor la rutina del where para este filtro es almacenado aqui.
     *
     */
    if ($checkValue) {
        $num = count($checkValue);
        $i = 0;
        while ($i < $num) {
            $record_id = key($checkValue);
            $setFiltroSelect .= $record_id;
            $radicadosSel[] = $record_id;
            if ($i <= ($num - 2)) {
                $setFiltroSelect .= ",";
            }
            next($checkValue);
            $i++;
        }
        if ($radicadosSel) {
            $whereFiltro = " and b.radi_nume_radi in($setFiltroSelect)";
        }
    }
    if ($setFiltroSelect) {
        $filtroSelect = $setFiltroSelect;
    }
    ?>
    <body>
        <?
        $txSql = "";
        if ($chkNivel and $_SESSION["usua_vobo_perm"] == 1) {
            $tomarNivel = "si";
        } else {
            $tomarNivel = "no";
        }
        include "$ruta_raiz/include/tx/Tx.php";
//$db->conn->debug=true;
        $rs = new Tx($db);
        switch ($codTx) {
            case 7:
                $nombTx = "Borrar Informados";
                $observa = "($krd) $observa";
                $radicadosSel = $rs->borrarInformado($radicadosSel, $krd, $depsel8, $_SESSION['dependencia'], $_SESSION['codusuario'], $codusuario, $observa);
                break;
            case 8: {
                    if (is_array($_POST['usCodSelect']))
                        while (list(, $var) = each($_POST['usCodSelect'])) {
                            $depsel8 = split('-', $var);
                            $usCodSelect = $depsel8[1];
                            $depsel8 = $depsel8[0];
                            $nombTx = "Informar Documentos";
                            $usCodDestino .= $rs->informar($radicadosSel, $krd, $depsel8, $dependencia, $usCodSelect, $codusuario, $observa, $_SESSION['usua_doc'], $mailObj) . ", ";
                        }
                    $usCodDestino = substr($usCodDestino, 0, strlen(trim($usCodDestino)) - 1);
                }
                break;
            case 9:

                if ($EnviaraV == "VoBo") {
                    $codTx = 16;
                    $carp_codi = 11;
                } else {
                    $codTx = 9;
                    $carp_codi = 0;
                }
                $nombTx = "Reasignar ";
                $depsel = split('-', $_POST['usCodSelect']);
                $usCodSelect = $depsel[1];
                $depsel = $depsel[0];
                if ($_POST['secCons']) {
                    
                }
                $usCodDestino = $rs->reasignar($radicadosSel, $krd, $depsel, $dependencia, $usCodSelect, $codusuario, $tomarNivel, $observa, $codTx, $carp_codi, $mailObj);

                if (is_array($_POST['usCodInfo'])) {
                    $k = 0;
                    $nombTx .= "e Informar Documentos";
                    while (list(, $var) = each($_POST['usCodInfo'])) {
                        $k == 0 ? $car = ' /Informados: ' : $car = ',';
                        $depsel8 = split('-', $var);
                        $usCodSelect = $depsel8[1];
                        $depsel8 = $depsel8[0];
                        $usCodDestino .= $car . $rs->informar($radicadosSel, $krd, $depsel8, $dependencia, $usCodSelect, $codusuario, $observaInf, $_SESSION['usua_doc'], $mailObj);
                        $k++;
                        //Informar y Reasignar
                    }
                }
                break;
            case 10:
                $nombTx = "Movimiento a Carpeta $carpetaNombre";
                $okTx = $rs->cambioCarpeta($radicadosSel, $krd, $carpetaCodigo, $carpetaTipo, $tomarNivel, $observa);
                $depSel = $dependencia;
                $usCodSelect = $codusuario;
                $usCodDestino = $usua_nomb;

                break;
            case 12:
                $nombTx = "Devolucion de Documentos";
                $usCodDestino = $rs->devolver($radicadosSel, $krd, $dependencia, $codusuario, $tomarNivel, $observa);
                break;
            case 13:
                $nombTx = "Archivo de Documentos";
                if ($_POST['secCons'] == "S") {
                    $txSql = $rs->archivar($radicadosSel, $krd, $dependencia, $codusuario, $observa, true);
                } else {
                    $txSql = $rs->archivar($radicadosSel, $krd, $dependencia, $codusuario, $observa);
                }
                break;
            case 14:
                $nombTx = "Agendar Documentos";
                $txSql = $rs->agendar($radicadosSel, $krd, $dependencia, $codusuario, $observa, $fechaAgenda);
                break;
            case 15:
                $nombTx = "Sacar de 'Agendar Documentos'";
                $txSql = $rs->noAgendar($radicadosSel, $krd, $dependencia, $codusuario, $observa);
                break;
            case 16:
                $nombTx = "Radicados NRR";
                $txSql = $rs->nrr($radicadosSel, $krd, $dependencia, $codusuario, $observa);
                break;
        }
        if ($okTx == -1)
            $okTxDesc = " No ";
        /**  if($txSql and codTx != 12 and  $txSql and codTx != 13)
          {
          include "$ruta_raiz/include/tx/Historico.php";
          $hist = new Historico($db);
          $hist->insertarHistorico($radicadosSel,  $dependencia , $codusuario, $depsel, $usCodSelect, $observa, $codTx);
          } * */
        /**  IMPRESION DE RESULTADOS DE LA Transaccion
         */
        ?>
        <form action='enviardatos.php?PHPSESSID=172o16o0o154oJH&krd=JH' method=post name=formulario>
            <br>
            <table border=0 cellspace=2 cellpad=2 WIDTH=50%  class="t_bordeGris" id=tb_general align="left">
                <tr>
                    <td colspan="2" class="titulos4">ACCION REQUERIDA <?= $accionCompletada ?>  <?= $okTxDesc ?> COMPLETADA <?= $causaAccion ?> </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">ACCION REQUERIDA :
                    </td>
                    <td  width="65%" height="25" class="listado2_no_identa">
                        <?= $nombTx ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">RADICADOS INVOLUCRADOS :
                    </td>
                    <td  width="65%" height="25" class="listado2_no_identa"><?= join("<BR> ", $radicadosSel) ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">USUARIO DESTINO :
                    </td>
                    <td  width="65%" height="25" class="listado2_no_identa">
                        <?= $usCodDestino ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">FECHA Y HORA :
                    </td>
                    <td  width="65%" height="25" class="listado2_no_identa">
                        <?= date("d-m-Y  H:i:s") ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">USUARIO ORIGEN:
                    </td>
                    <td  width="65%" height="25" class="listado2_no_identa">
                        <?= $usua_nomb ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">DEPENDENCIA ORIGEN:
                    </td>
                    <td  width="65%" height="25" class="listado2_no_identa">
                        <?= $depe_nomb ?>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
