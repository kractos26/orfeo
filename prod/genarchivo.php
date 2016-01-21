<?php
session_start();
error_reporting(0);
if (!$ruta_raiz)
    $ruta_raiz = ".";
include("$ruta_raiz/config.php");
if (!isset($_SESSION['dependencia']))
    include "$ruta_raiz/rec_session.php";
if (isset($db))
    unset($db);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
//$db->conn->debug = true;

require_once("$ruta_raiz/class_control/anexo.php");
require_once("$ruta_raiz/class_control/CombinaError.php");
require_once("$ruta_raiz/class_control/Sancionados.php");
require_once("$ruta_raiz/class_control/Dependencia.php");
require_once("$ruta_raiz/class_control/Esp.php");
require_once("$ruta_raiz/class_control/TipoDocumento.php");
require_once("$ruta_raiz/class_control/Radicado.php");
require_once("$ruta_raiz/include/tx/Radicacion.php");
require_once("$ruta_raiz/include/tx/Historico.php");
require_once("$ruta_raiz/class_control/ControlAplIntegrada.php");
require_once("$ruta_raiz/include/tx/Expediente.php");
require_once("$ruta_raiz/include/tx/Historico.php");
require_once "$ruta_raiz/include/class/DatoOtros.php";
error_reporting(0);
$dep = new Dependencia($db);
$espObjeto = new Esp($db);
$radObjeto = new Radicado($db);
$radObjeto->radicado_codigo($numrad);
//objeto que maneja el tipo de documento del anexos
$tdoc = new TipoDocumento($db);
//objeto que maneja el tipo de documento del radicado
$tdoc2 = new TipoDocumento($db);
$tdoc2->TipoDocumento_codigo($radObjeto->getTdocCodi());

$fecha_dia_hoy = Date("Y-m-d");
$sqlFechaHoy = $fecha_dia_hoy;
//OBJETO CONTROL DE APLICACIONES INTEGRADAS.
$objCtrlAplInt = new ControlAplIntegrada($db);
//OBJETO EXPEDIENTE
$objExpediente = new Expediente($db);
$expRadi = $objExpediente->consulta_exp($numrad);


$dep->Dependencia_codigo($dependencia);
$dep_sigla = $dep->getDepeSigla();
$nurad = trim($nurad);
$numrad = trim($numrad);
$hora = date("H") . "_" . date("i") . "_" . date("s");
// var que almacena el dia de la fecha
$ddate = date('d');
// var que almacena el mes de la fecha
$mdate = date('m');
// var que almacena el a�o de la fecha
$adate = date('Y');
// var que almacena  la fecha formateada
$fechaArchivo = $adate . "_" . $mdate . "_" . $ddate;
//var que almacena el nombre que tendr� la pantilla
$archInsumo = "tmp_" . $usua_doc . "_" . $fechaArchivo . "_" . $hora . ".txt";
//Var que almacena el nombre de la ciudad de la territorial
$terr_ciu_nomb = $dep->getTerrCiuNomb();
//Var que almacena el nombre corto de la territorial
$terr_sigla = $dep->getTerrSigla();
//Var que almacena la direccion de la territorial
$terr_direccion = $dep->getTerrDireccion();
//Var que almacena el nombre largo de la territorial
$terr_nombre = $dep->getTerrNombre();
//Var que almacena el nombre del recurso
$nom_recurso = $tdoc2->get_sgd_tpr_descrip();
?>
<HEAD>
    <TITLE>Gen  -  ORFEO - <?= DATE ?></TITLE>
    <link rel="stylesheet" href="estilos_totales.css">
</HEAD>

<body>
    <?php
    if (!$numrad) {
        $numrad = $verrad;
    }
    if (strlen(trim($radicar_a)) == 13 or strlen(trim($radicar_a)) == 18) {
        $no_digitos = 5;
    } else {
        $no_digitos = 6;
    }
    $linkarchivo = base64_decode($linkarchivo);
    $linkarchivotmp = base64_decode($linkarchivotmp);
    $linkArchSimple = strtolower($linkarchivo);
    $linkArchivoTmpSimple = strtolower($linkarchivotmp);

    $linkarchivo = strtolower($linkarchivo);
    $linkarchivotmp = strtolower($linkarchivotmp);
    $fechah = date("Ymd") . "_" . time("hms");
    $trozosPath = explode("/", $linkarchivo);
    $nombreArchivo = $trozosPath[count($trozosPath) - 1];

// ABRE EL ARCHIVO
    $a = new Anexo($db);
    $a->anexoRadicado($numrad, $anexo);
    $apliCodiaux = $a->get_sgd_apli_codi();
    $anex = $a;
    $secuenciaDocto = $a->get_doc_secuencia_formato($dependencia);
    $fechaDocumento = $a->get_sgd_fech_doc();
    $tipoDocumento = $a->get_sgd_tpr_codigo();
    $tdoc->TipoDocumento_codigo($tipoDocumento);

    $tipoDocumentoDesc = $tdoc->get_sgd_tpr_descrip();

    if ($radicar_documento) {
        //GENERACION DE LA SECUENCIA PARA DOCUMENTOS ESPECIALES  *******************************
        // Generar el Numero de Radicacion
        if (($ent != 2) and $nurad and $vpppp == "ddd") {
            $sec = $nurad;
            $anoSec = substr($nurad, 0, 4);
            // @tipoRad define el tipo de radicado el -X
            $tipoRad = substr($radicar_documento, -1);
        } else {
            if ($vp == "n" and $radicar_a == "si") {
                if ($generar_numero == "no") {
                    $sec = substr($nurad, 7, $no_digitos);
                    $anoSec = substr($nurad, 0, 4);
                    $tipoRad = substr($radicar_documento, -1);
                } else {
                    $isql = "select * from ANEXOS where ANEX_CODIGO='$anexo' AND ANEX_RADI_NUME=$numrad";
                    $rs = $db->query($isql);
                    if (!$rs->EOF) {
                        $radicado_salida = $rs->fields['RADI_NUME_SALIDA'];
                        $expAnexoActual = $rs->fields['SGD_EXP_NUMERO'];
                        $AnexDescripcion = $rs->fields['ANEX_DESC'];
                        if ($expAnexoActual != '') {
                            $expRadi = $expAnexoActual;
                        }
                    } else {
                        $db->conn->RollbackTrans();
                        die("<span class='etextomenu'>No se ha podido obtener la informacion del radicado");
                    }

                    if (!$radicado_salida) {
                        $no_digitos = 6;
                        $tipoRad = "1";
                    } else {
                        $sec = substr($radicado_salida, 7, $no_digitos);
                        $tipoRad = substr($radicar_documento, -1);
                        $anoSec = substr($radicado_salida, 0, 4);
                        $db->conn->RollbackTrans();
                        die("<span class='etextomenu'><br>Ya estaba radicado<br>");
                        $radicar_a = $radicado_salida;
                    }
                }
            } else {
                if ($vp == "s") {
                    $sec = "XXX";
                } else {
                    // EN ESTA PARTE ES EN LA CUAL SE ENTRA A ASIGNAR EL NUMERO DE RADICADO
                    $sec = substr($radicar_a, 7, $no_digitos);
                    $anoSec = substr($radicar_a, 0, 4);
                    $tipoRad = substr($radicar_a, 13, 1);
                }
            }
            // GENERACION DE NUMERO DE RADICADO DE SALIDA
            $sec = str_pad($sec, $no_digitos, "0", STR_PAD_LEFT);
            $plg_comentarios = "";
            $plt_codi = $plt_codi;
            if (!$anoSec) {
                $anoSec = date("Y");
            }
            if (!$tipoRad) {
                $tipoRad = "1";
            }
            //Adicion para que no reemplace el numero de radicado de un anexo al ser reasignado a otra dependencia
            if ($generar_numero == "no") {
                $rad_salida = $numrad;
            } else {
                //Es un anexo radicado en otra dependencia y no queremos que le genere un nuevo numero
                if ($radicar_a != null && $radicar_a != 'si') {
                    $rad_salida = $radicar_a;
                } else {
                    $rad_salida = $anoSec . $dependencia . $sec . $tipoRad;
                }
            }
            if ($numerar == 1) {
                //print ("CAMBIA LA SALIDA POR QUE NUMERA");
                $numResol = $a->get_doc_secuencia_formato();
                $rad_salida = date("Y") . $dependencia . str_pad($a->sgd_doc_secuencia(), 6, "0", STR_PAD_left) . $a->get_sgd_tpr_codigo();
            }
        }
        //**********************************************************************************************************************************
        // * FIN GENRACION DE NUMERO DE RADICADO DE SALIDA
        $ext = substr(trim($linkarchivo), -3);
        echo "<font size='3' color='#000000'><span class='etextomenu'>";

        $extVal = strtoupper($ext);
        if ($extVal == "XLS" or $extVal == "PPT" or $extVal == "PDF") {
            echo "<br><font size='3' ><span class='etextomenu'>Sobre formato ($ext) no se puede realizar combinaci&oacute;n de correspondencia</br>";
            die;
        } else {
            require "$ruta_raiz/jh_class/funciones_sgd.php";
            $verrad = $numrad;
            $radicado_p = $verrad;
            $no_tipo = "true";
            require "$ruta_raiz/ver_datosrad.php";
            include "$ruta_raiz/radicacion/busca_direcciones.php";
            $a = new LOCALIZACION($codep_us1, $muni_us1, $db);
            $dpto_nombre_us1 = $a->departamento;
            $muni_nombre_us1 = $a->municipio;
            $a = new LOCALIZACION($codep_us2, $muni_us2, $db);
            $dpto_nombre_us2 = $a->departamento;
            $muni_nombre_us2 = $a->municipio;
            $a = new LOCALIZACION($codep_us3, $muni_us3, $db);
            $dpto_nombre_us3 = $a->departamento;
            $muni_nombre_us3 = $a->municipio;
            $espObjeto->Esp_nit($cc_documento_us3);
            $nuir_e = $espObjeto->getNuir();
            // Inicializacion de la fecha que va a pasar al reemplazable *F_RAD_S*
            $fecha_hoy_corto = "";
            include "$ruta_raiz/class_control/class_gen.php";

            $b = new CLASS_GEN();
            $date = date("m/d/Y");
            $fecha_hoy = $b->traducefecha($date);
            $fecha_e = $b->traducefecha($radi_fech_radi);
            $fechaDocumento2 = $b->traducefecha_sinDia($fechaDocumento);
            $fechaDocumento = $b->traducefechaDocto($fechaDocumento);

            if ($vp == "n")
                $archivoFinal = $linkArchSimple;
            else
                $archivoFinal = $linkArchivoTmpSimple;

            //almacena la extension del archivo a procedar
            $extension = (strrchr($archivoFinal, "."));
            $archSinExt = substr($archivoFinal, 0, strpos($archivoFinal, $extension));
            //Almacena el path completo hacia el archivo a producirse luego de la combinacion

            if (substr($archSinExt, -1) == "d") {
                $caracterDefinitivo = "";
            } else {
                $caracterDefinitivo = "d";
            }

            if ($ext == 'xml' || $ext == 'XML' || $ext == 'odt' || $ext == 'ODT') {
                $archivoFinal = $archSinExt . "." . $ext;
            } else {
                $archivoFinal = $archSinExt . $caracterDefinitivo . "." . $ext;
            }

            //Almacena el nombre de archivo a producirse luego de la combinacion y que ha de actualizarce en la tabla de anexos
            $archUpdate = substr($archivoFinal, strpos($archivoFinal, strrchr($archivoFinal, "/")) + 1, strlen($archivoFinal) - strpos($archivoFinal, strrchr($archivoFinal, "/")) + 1);
            //Almacena el path de archivo a producirse luego de la combinacion y que ha de actualizarce en la tabla de radicados
            $archUpdateRad = substr_replace($archivoFinal, "", 0, strpos($archivoFinal, "$carpetaBodega") + strlen("$carpetaBodega"));
        }
        //****************************************************************************************************
        $db->conn->BeginTrans();
        $tipo_docto = $anex->get_sgd_tpr_codigo();

        if (!$tipo_docto)
            $tipo_docto = 0;
        if ($sec and $vp == "n") {
            if ($generar_numero != "no" and $radicar_a == "si") {
                if (!$tpradic) {
                    $tpradic = 'null';
                }
                $rad = new Radicacion($db);
                $hist = new Historico($db);
                $rad->radiTipoDeri = 0;
                $rad->radiCuentai = "''";
                $rad->eespCodi = $espcodi;
                $rad->mrecCodi = "null";
                $rad->radiFechOfic = $sqlFechaHoy;
                $rad->radiNumeDeri = trim($verrad);
                $rad->descAnex = $desc_anexos;
                $rad->radiPais = "$pais";
                $rad->raAsun = $AnexDescripcion;
                if ($tpradic != 2) {
                    if ($entidad_depsal != 0) {
                        $rad->radiDepeActu = $entidad_depsal;
                        $rad->radiUsuaActu = 1;
                    } else {
                        $rad->radiDepeActu = $dependencia;
                        $rad->radiUsuaActu = $codusuario;
                    }
                } else {
                    $rad->radiDepeActu = $dependencia;
                    $rad->radiUsuaActu = $codusuario;
                }
                $rad->radiDepeRadi = $dependencia;
                $rad->trteCodi = "null";
                $rad->tdocCodi = $tipo_docto;
                $rad->tdidCodi = "null";
                $rad->carpCodi = $tpradic; //por revisar como recoger el valor
                $rad->carPer = 0;
                $rad->trteCodi = "null";
                $rad->ra_asun = "'$asunto'";
                $rad->radiPath = "'$archUpdateRad'";
                if (strlen(trim($apliCodiaux)) > 0 && $apliCodiaux > 0)
                    $aplinteg = $apliCodiaux;
                else
                    $aplinteg = "0";
                $rad->sgd_apli_codi = $aplinteg;
                $codTx = 2;
                $flag = 1;
                // Se genera el numero de radicado del anexo
                $noRad = $rad->newRadicado($tpradic, $tpDepeRad[$tpradic]);
                // Se instancia un objeto para el radicado generado y obtener la fecha real de radicacion
                $radGenerado = new Radicado($db);
                $radGenerado->radicado_codigo($noRad);
                // Asgina la fecha de radicacion
                $fecha_hoy_corto = $radGenerado->getRadi_fech_radi("d-m-Y");
                //BUSCA QUERYS ADICIONALES RESPECTO DE APLICATIVOS INTEGRADOS
                $campos["P_RAD_E"] = $noRad;
                $campos["P_USUA_CODI"] = $codusuario;
                $campos["P_DEPENDENCIA"] = $dependencia;
                $campos["P_USUA_DOC"] = $usua_doc;
                $campos["P_COD_REF"] = $anexo;
                //El nuevo radicado hereda la informacion del expediente del radicado padre
                if (isset($expRadi) && $expRadi != 0) {
                    $resultadoExp = $objExpediente->insertar_expediente($expRadi, $noRad, $dependencia, $codusuario, $usua_doc);
                    $radicados = "";
                    if ($resultadoExp == 1) {
                        $observa = "Se ingresa al expediente del radicado padre ($numrad)";
                        include_once "$ruta_raiz/include/tx/Historico.php";
                        $radicados[] = $noRad;
                        $tipoTx = 53;
                        $Historico = new Historico($db);
                        $Historico->insertarHistoricoExp($expRadi, $radicados, $dependencia, $codusuario, $observa, $tipoTx, 0, 0);
                    } else {
                        die('<hr><font color=red>No se anexo este radicado al expediente. Verifique que el numero del expediente exista e intente de nuevo.</font><hr>');
                    }
                }
                $estQueryAdd = $objCtrlAplInt->queryAdds($noRad, $campos, $MODULO_RADICACION_DOCS_ANEXOS);
                if ($estQueryAdd == "0") {
                    $db->conn->RollbackTrans();
                    die("fallo en la consulta de aplintegra");
                }
                $radicadosSel[0] = $noRad;
                $hist->insertarHistorico($radicadosSel, $dependencia, $codusuario, $dependencia, $codusuario, " ", $codTx);
                echo "<br/>";
                echo "<br/>";
                echo "<br/>";
                //echo "inserto el historico tal rads=".var_dump($radicadosSel)."--dep=".$dependencia."--cod=".$codusuario."--dep2".$dependencia."---coduser".$codusuario."--codtx".$codTx;
                
                
                
                if ($noRad == "-1") {
                    $db->conn->RollbackTrans();
                    die("<hr><b><font color=red><center>Error no genero un Numero de Secuencia o inserto el radicado </center></font></b><hr>");
                }
                $rad_salida = $noRad;
            } else {
                $linkarchivo_grabar = str_replace("$carpetaBodega", "", $linkarchivo);
                $linkarchivo_grabar = str_replace("./", "", $linkarchivo_grabar);
                $posExt = strpos($linkarchivo_grabar, 'd.doc');
                if ($posExt === false) {
                    $temp = $linkarchivo_grabar;
                    $ruta = str_replace('.doc', 'd.doc', $temp);
                    $linkarchivo_grabar = $ruta;
                }
                $isql = "update RADICADO set RADI_PATH='$linkarchivo_grabar' where RADI_NUME_RADI = $rad_salida";
                $radGenerado = new Radicado($db);
                $radGenerado->radicado_codigo($rad_salida);
                // Asgina la fecha de radicacion
                $fecha_hoy_corto = $radGenerado->getRadi_fech_radi("d-m-Y");
                $rs = $db->query($isql);
                if (!$rs) {
                    $db->conn->RollbackTrans();
                    die("<span class='etextomenu'>No se ha podido Actualizar el Radicado");
                }
            }
            
            if ($ent == 1)
                $rad_salida = $nurad;
            
            $tipo = substr($numrad,-1);
            $sqlesta = "SELECT ANEX_ESTADO FROM ANEXOS WHERE ANEX_RADI_NUME = $numrad and ANEX_CODIGO = '$anexo'";
            
            $estaa=$db->conn->Execute($sqlesta);
            $estadoactual=$estaa->fields['ANEX_ESTADO'];
            
            $condicion = ($tipo == 3 && $estadoactual ==4)? "anex_estado = 4":"anex_estado < 4";
            $estado = ($tipo == 3 && $estadoactual == 4)?4:2;
            $isql = "update ANEXOS set RADI_NUME_SALIDA=$rad_salida,
				ANEX_RADI_FECH = " . $db->conn->DBDate($sqlFechaHoy) . ",
				ANEX_ESTADO = $estado,
				ANEX_NOMB_ARCHIVO = '$archUpdate', 
				ANEX_TIPO='$numextdoc',
				SGD_DEVE_CODIGO = null
	         where ANEX_CODIGO='$anexo' AND ANEX_RADI_NUME=$numrad and $condicion"; //Actualiza los datos del radicado padre
            
            $rs = $db->conn->Execute($isql);
            if (!$rs) {
                $db->conn->RollbackTrans();
                die("<span class='etextomenu'>No se ha podido actualizar la informacion de anexos");
            }
            $isql = "select * from ANEXOS where ANEX_CODIGO='$anexo' AND ANEX_RADI_NUME=$numrad"; //Datos de radicado padre en anexos
            $rs = $db->query($isql);
            if ($rs == false) {
                $db->conn->RollbackTrans();
                die("<span class='etextomenu'>No se ha podido obtener la informacion de anexo");
            }
            $sgd_dir_tipo = $rs->fields["SGD_DIR_TIPO"]; //Destinatario de respuesta de radicado padre
            $anex_desc = $rs->fields["ANEX_DESC"];
            $anex_numero = $rs->fields["ANEX_NUMERO"];
            $direccionAlterna = $rs->fields["SGD_DIR_DIRECCION"];
            $pasar_direcciones = true;
            $dep_radicado = substr($rad_salida, 4, 3);
            //	 echo ("al radicar($dep_radicado)($rad_salida)");
            $carp_codi = 1;
            if (!$tipo_docto)
                $tipo_docto = 0;
            $linkarchivo_grabar = str_replace("$carpetaBodega", "", $linkarchivo);
            $linkarchivo_grabar = str_replace("./", "", $linkarchivo_grabar);
            if ($sgd_dir_tipo == 1) {
                $grbNombresUs1 = $nombret_us1_u;
            }

            //---------->>		
            //Adiciones para DIR_E SSPD, no quieren que se reemplace DIR_R con DIR_E
            $campos = array();
            $datos = array();
            $anex->obtenerArgumentos($campos, $datos);
            $vieneDeSancionados = 0;

            //Trae la informacion de Sancionados y genera los campos de combinacion
            $camposSanc = array();
            $datosSanc = array();
            $objSancionados = new Sancionados($db);
            if ($objSancionados->sancionadosRad($anexo)) {
                $objSancionados->obtenerCampos($camposSanc, $datosSanc);
                $vieneDeSancionados = 1;
            } else if ($objSancionados->sancionadosRad($numrad)) {
                $objSancionados->obtenerCampos($camposSanc, $datosSanc);
                $vieneDeSancionados = 2;
            }
            else
                $vieneDeSancionados = 0;

            //------->>
            if ($sgd_dir_tipo == 2 && $vieneDeSancionados == 0) {
                $dir_tipo_us1 = $dir_tipo_us2;
                $tipo_emp_us1 = $tipo_emp_us2;
                $nombre_us1 = $nombre_us2;
                $grbNombresUs1 = $nombre_us2;
                $documento_us1 = $documento_us2;
                $cc_documento_us1 = $cc_documento_us2;
                $prim_apel_us1 = $prim_apel_us2;
                $seg_apel_us1 = $seg_apel_us2;
                $telefono_us1 = $telefono_us2;
                $direccion_us1 = $direccion_us2;
                $mail_us1 = $mail_us2;
                $muni_us1 = $muni_us2;
                $codep_us1 = $codep_us2;
                $tipo_us1 = $tipo_us2;
                $otro_us1 = $otro_us2;
            }
            if ($sgd_dir_tipo == 3 && $vieneDeSancionados == 0) {
                $dir_tipo_us1 = $dir_tipo_us3;
                $tipo_emp_us1 = $tipo_emp_us3;
                $nombre_us1 = $nombre_us3;
                $grbNombresUs1 = $nombre_us3;
                $documento_us1 = $documento_us3;
                $cc_documento_us1 = $cc_documento_us3;
                $prim_apel_us1 = $prim_apel_us3;
                $seg_apel_us1 = $seg_apel_us3;
                $telefono_us1 = $telefono_us3;
                $direccion_us1 = $direccion_us3;
                $mail_us1 = $mail_us3;
                $muni_us1 = $muni_us3;
                $codep_us1 = $codep_us3;
                $tipo_us1 = $tipo_us3;
                $otro_us1 = $otro_us3;
            }
            if ($direccionAlterna and $sgd_dir_tipo == 3) {
                $direccion_us3 = $direccionAlterna;
                $muni_us3 = $muniCodiAlterno;
                $codep_us3 = $dptoCodiAlterno;
            }
            $nurad = $rad_salida;
            $documento_us2 = "";
            $documento_us3 = "";
            $conexion = $db;

            $actualizados = 4;
            $sgd_dir_tipo = 1; //WTF? pasa de 7 a 1?

            $isql = "select anex_codigo, sgd_dir_tipo from anexos where RADI_NUME_SALIDA=$nurad and anex_estado=4"; //Ya se encuentran enviados?
            $arr = $db->conn->GetArray($isql);
            foreach ($arr as $i => $value) {
                $enviados[] = $value['ANEX_CODIGO'];
                $tipoEnviados[] = $value['SGD_DIR_TIPO'];
            }
            // Borro todo lo generando anteriormete .....  para el caso de regenerar
            /* if($_GET['flag_regenerar']== FALSE)
              { */
            $isql = "delete from ANEXOS where RADI_NUME_SALIDA=$nurad
		and sgd_dir_tipo > 700 and sgd_dir_tipo !=7 and anex_estado<4"; //Borrar copias?
            $rs = $db->query($isql);
            /* } */
            if ($_GET['radicado_rem'] == 1) {
                $del_Anex = "delete from anexos where radi_nume_salida=$rad_salida and sgd_dir_tipo=1 and anex_nomb_archivo is null and anex_estado<4";
                //Borra la primer respuesta, el anexo de salida
                $rsdel_Anex = $db->query($del_Anex);
            }

            if (!$rs) {
                $db->conn->RollbackTrans();
                die("<span class='etextomenu'>No se ha borrar los datos previos del radicado");
            }
            // fIN BORRADO Para reproceso....
            $isql = "select * from ANEXOS where ANEX_RADI_NUME=$nurad Order by ANEX_NUMERO desc "; //Nunca se cumple, el radicado de salida no es == al radicado padre!!!
            $rs = $db->query($isql);
            if (!$rs->EOF)
                $i = 0; //$rs->fields['ANEX_NUMERO'];
            $s_lect = $rs->fields['ANEX_SOLO_LECT'];
            !$s_lect ? $s_lect = $_GET['sol_lect'] : 0;
            include_once "./include/query/queryGenarchivo.php"; // Hay copias?
            $isql = $query1;
            $rs = $db->conn->Execute($isql);
            $k = 0;
            if ($numerar != 1 and ($_GET['radicado_rem'] == 1 || $_GET['radicado_rem'] == 2 || $_GET['radicado_rem'] == 3)) {
                $del_Anex = "delete from anexos where radi_nume_salida=$rad_salida and sgd_dir_tipo=" . $_GET['radicado_rem'] . " and anex_nomb_archivo is null"; //Borra los anexos relacionados con esta salida
                $rsdel_Anex = $db->query($del_Anex);
                include "$ruta_raiz/radicacion/grb_direcciones.php";
            }
            $_GET['radicado_rem'] == 7 ? $k = 1 : 0; //Reset para numero de copias
            $band = 0;
            $i = 0;
            $sqlUp = "UPDATE anexos
                        set anex_estado=2,
                            anex_fech_envio=null,
                            sgd_deve_codigo=null,
                            sgd_deve_fech=null
                 where radi_nume_salida=$rad_salida and anex_estado < 4"; //Se actualizan los radicados de salida con en estado 2, No se cumple?
            $rsUp = $db->query($sqlUp);
            while (!$rs->EOF) { // Si las hay, anexarlas!
                $set = "";
                $sgd_dir_codigo = $rs->fields['SGD_DIR_CODIGO'];
                $radi_nume_radi = $rs->fields['RADI_NUME_RADI'];
                $sgd_dir_tipo = $rs->fields['SGD_DIR_TIPO']; //Desde la tabla sgd_dir_drecciones
                $anexo_new = $rad_salida . substr("00000" . ($i + 1), -5);
                $rsVerif = $db->conn->Execute("select anex_codigo from anexos where anex_codigo='$anexo_new'");
                //$rsVerif=$db->conn->Execute("select min(anex_codigo) AS anex_codigo from anexos where radi_nume_salida=$rad_salida and sgd_dir_tipo=1 or (radi_nume_salida=anex_radi_nume and radi_nume_salida=$rad_salida and (sgd_dir_tipo=1 or sgd_dir_tipo=7))");
                if ($rsVerif->fields['ANEX_CODIGO'] === $anexo_new) {//Existe el anexo a introducir?
                    $i++;
                    continue;
                }

                if ((!isset($enviados) or (!in_array($anexo_new, $enviados, true))) and (!isset($tipoEnviados) or (!in_array($sgd_dir_tipo, $tipoEnviados, true)))) {//si no ha sido enviado
                    $selEnvio7 = "select sgd_dir_codigo from sgd_renv_regenvio where radi_nume_sal=$rad_salida and sgd_dir_tipo=$sgd_dir_tipo";
                    $rsSelEnvio7 = $db->query($selEnvio7);


                    if ($_GET['radicado_rem'] != 1 and $band == 0 and $sgd_dir_tipo != 1 and ($rsSelEnvio7 && $rsSelEnvio7->EOF)) {
                        $sqlVerif = "select sgd_renv_codigo from sgd_renv_regenvio where radi_nume_sal=$rad_salida and sgd_dir_tipo=1"; //Hay uno de salida?
                        $ADODB_COUNTRECS = true;
                        $rsVerif = $db->conn->Execute($sqlVerif);
                        $ADODB_COUNTRECS = false;
                        $sqlVerifAnex = "select * from anexos where radi_nume_salida=$rad_salida and sgd_dir_tipo=1 and sgd_rem_destino=0"; //Primer destinatario a otro diferente al remitente original
                        $ADODB_COUNTRECS = true;
                        $rsVerifAnex = $db->conn->Execute($sqlVerifAnex);
                        $ADODB_COUNTRECS = false;
                        $FirstInc = false;
                        if ($rsVerif && $rsVerif->RecordCount() == 0 && $rsVerifAnex && $rsVerifAnex->RecordCount() == 0) {//Anexos sin enviar, o de salida sin diferente destinatario, radicado de salida y copias
                            $set = " ,sgd_dir_tipo = 1";
                            $FirstInc = true;
                            $sgd_dir_tipo = 1;
                            $k = $k - 1;
                            $delete = "delete from sgd_dir_drecciones where RADI_NUME_RADI=$rad_salida and sgd_dir_tipo=1";
                            $rsdel = $db->query($delete);
                            $del_Anex = "delete from anexos where radi_nume_salida=$rad_salida and sgd_dir_tipo=1";
                            $rsdel_Anex = $db->query($del_Anex);
                            $band = 1;
                        } else {//otros destinatarios
                            $objOtro = new DatoOtros($db->conn);
                            $sqlSel7 = "
                        select d.sgd_dir_codigo, d.sgd_dir_tipo 
                        from sgd_dir_drecciones d
                        left join sgd_renv_regenvio e on e.sgd_dir_codigo=d.sgd_dir_codigo
                        where 
                        d.sgd_anex_codigo='$anexo' and d.sgd_dir_tipo <> 1 and e.radi_nume_sal is null
                        order by 
                        sgd_dir_tipo";
                            $rsSelDir7 = $db->conn->Execute($sqlSel7);
                            $sqlSel1 = "select sgd_dir_codigo from sgd_dir_drecciones where radi_nume_radi=$rad_salida and sgd_dir_tipo = 1"; //Datos del primer destinatario
                            $rsSelDir1 = $db->conn->Execute($sqlSel1);
                            if ($rsSelDir7 && $rsSelDir1) {
                                $objOtro->pasaDir1ToDir7($rsSelDir1->fields['SGD_DIR_CODIGO'], $rsSelDir7->fields['SGD_DIR_CODIGO']);
                            }
                            $k = $k - 1;
                            $band = 1;
                            if ($_GET['radicado_rem'] != 7) {
                                $sgd_dir_tipo = 1;
                            }
                        }
                    }
                    $anex_tipo = "20";
                    $anex_creador = $krd;
                    $anex_borrado = "N";
                    $anexo_num = $i + 1;
                    /* if($_GET['flag_regenerar']== FALSE)
                      { */
                    if ($_GET['radicado_rem'] == 7) {
                        if ($sgd_dir_tipo > 700) {
                            if ($FirstInc) {
                                $sgd_dir_tipo = $sgd_dir_tipo - 1;
                                $set.=" ,sgd_dir_tipo = $sgd_dir_tipo ";
                            }
                        }
                    }
                    $isql = "insert into ANEXOS (ANEX_RADI_NUME,RADI_NUME_SALIDA,ANEX_SOLO_LECT,ANEX_RADI_FECH,ANEX_ESTADO,ANEX_CODIGO  ,anex_tipo   ,ANEX_CREADOR  ,ANEX_NUMERO    ,ANEX_NOMB_ARCHIVO   ,ANEX_BORRADO   ,sgd_dir_tipo)
                         VALUES ($verrad       ,$rad_salida     ,'$s_lect'           ," . $db->conn->DBDate($sqlFechaHoy) . "       ,2          ,'$anexo_new','$anex_tipo','$anex_creador','$anexo_num',null,'$anex_borrado','$sgd_dir_tipo')";
                    $rs2 = $db->query($isql);
                    if (!$rs2) {
                        $db->conn->RollbackTrans();
                        die("<span class='etextomenu'>No se pudo insertar en la tabla de anexos");
                    }
                    /* } */
                    $isql = "UPDATE sgd_dir_drecciones
                         set RADI_NUME_RADI=$rad_salida $set
                         where sgd_dir_codigo=$sgd_dir_codigo "; //cambio de tipo anexo a radicado definitivo
                    $rs2 = $db->query($isql);
                    if (!$rs2) {
                        $db->conn->RollbackTrans();
                        die("<span class='etextomenu'>No se pudo actualizar las direcciones");
                    }
                } else {
                    substr($anexo_new, -2) == substr($sgd_dir_tipo, -2) ? 0 : $i++;
                    if ((!isset($tipoEnviados) or (!in_array($sgd_dir_tipo, $tipoEnviados, true)))) {
                        $i++;
                        continue;
                    }
                }
                $i++;
                $k++;
                $rs->MoveNext();
            }
            $s_copia = "SELECT COUNT(*) as copias from sgd_dir_drecciones where radi_nume_radi=$rad_salida and sgd_dir_tipo >=700";
            $s_copia1 = $db->conn->Execute($s_copia);
            echo "<br><p align='center'>Se han generado " . $s_copia1->fields['COPIAS'] . " copias</p><br>";
            ?>
            <p>
        <center>
            <?php
            if ($actualizados > 0) {
                if ($ent != 1) {
                    $mensaje = "<input type='button' value='cerrar' onclick='opener.history.go(0); window.close()'>";
                    $mensaje = "";
                    if ($numerar != 1) {
                        $numerar = $numerar;
                        ?>
                        <span class='etextomenu'>Ha sido radicado el documento con el n&uacute;mero <br><b>
                                <a title='Click para modificar el Documento' href='./radicacion/NEW.php?nurad=<?= $rad_salida ?>&Buscar=BuscarDocModUS&krd=<?= $krd ?>&Submit3=ModificarDocumentos&Buscar1=BuscarOrfeo78956jkgf' notborder >
                                    <?= $rad_salida ?></a><p><?= $mensaje ?>
                                    <?php
                                }
                            }
                            else
                                $mensaje = "";
                        }
                        else {
                            ?>          <span class='alarmas'>No se ha podido radicar el Documento con el N&uacute;mero
                                <?php
                            }
                            ?>
                            </center>
                            <?php
                        }
                    }
                    $ra_asun = ereg_replace("\n", "-", $ra_asun);
                    $ra_asun = ereg_replace("\r", " ", $ra_asun);
                    $archInsumo = "tmp_" . $usua_doc . "_" . $fechaArchivo . "_" . $hora . ".txt";

                    $fp = fopen("$ruta_raiz/$carpetaBodega/masiva/$archInsumo", 'w+');
                    if (!$fp) {
                        echo "<br><font size='3' ><span class='etextomenu'>ERROR..No se pudo abrir el archivo $ruta_raiz/$carpetaBodega/masiva/$archInsumo</br>";
                        $db->conn->RollbackTrans();
                        die;
                    }
                    if (!strpos($rad_salida, 'X')) {
                        $radGenerado = new Radicado($db);
                        $radGenerado->radicado_codigo($rad_salida);
                        $fecha_hoy = $b->traducefecha($radGenerado->getRadi_fech_radi("m/d/Y"));
                    }
                    $tipo = ($_GET['vp'] && $_GET['rRem'] == 7) ? 701 : 1;
                    $isql = "select a.* from sgd_dir_drecciones a where a.sgd_anex_codigo='$anexo' and sgd_dir_tipo=$tipo";
                    $rs = $db->query($isql);
                    if ($rs && !$rs->EOF) {
                        $objOtro = new DatoOtros($db->conn);
                        $datos1 = $objOtro->obtieneDatosReales($rs->fields["SGD_DIR_CODIGO"]);
                        $datos1Dir = $objOtro->obtieneDatosDir($rs->fields["SGD_DIR_CODIGO"]);
                        $nombret_us1_u = $datos1[0]['NOMBRE'] . " " . $datos1[0]['APELLIDO'];
                        $dpto_nombre_us1 = $datos1[0]['DEPARTAMENTO'];
                        $direccion_us1 = $datos1Dir[0]['DIRECCION'];
                        $muni_nombre_us1 = $datos1[0]['MUNICIPIO'];
                        $telefono_us1 = $datos1[0]['TELEFONO'];
                        $cc_documentous1 = $datos1[0]['TELEFONO'];
                        $otro_us1 = $rs->fields["SGD_DIR_NOMBRE"];
                    }

                    fputs($fp, "archivoInicial=$linkArchSimple" . "\n");
                    fputs($fp, "archivoFinal=$archivoFinal" . "\n");
                    fputs($fp, "*RAD_S*=$rad_salida\n");
                    fputs($fp, "*RAD_E_PADRE*=$radicado_p\n");
                    fputs($fp, "*CTA_INT*=$cuentai\n");
                    fputs($fp, "*ASUNTO*=$ra_asun\n");
                    fputs($fp, "*F_RAD_E*=$fecha_e\n");
                    fputs($fp, "*SAN_FECHA_RADICADO*=$fecha_e\n");
                    fputs($fp, "*NOM_R*=$nombret_us1_u\n");
                    fputs($fp, "*DIR_R*=$direccion_us1\n");
                    fputs($fp, "*DIR_E*=$direccion_us3\n");
                    fputs($fp, "*DEPTO_R*=$dpto_nombre_us1\n");
                    fputs($fp, "*MPIO_R*=$muni_nombre_us1\n");
                    fputs($fp, "*TEL_R*=$telefono_us1\n");
                    fputs($fp, "*MAIL_R*=$mail_us1\n");
                    fputs($fp, "*DOC_R*=$cc_documentous1\n");
                    fputs($fp, "*NOM_P*=$nombret_us2_u\n");
                    fputs($fp, "*DIR_P*=$direccion_us2\n");
                    fputs($fp, "*DEPTO_P*=$dpto_nombre_us2\n");
                    fputs($fp, "*MPIO_P*=$muni_nombre_us2\n");
                    fputs($fp, "*TEL_P*=$telefono_us1\n");
                    fputs($fp, "*MAIL_P*=$mail_us2\n");
                    fputs($fp, "*DOC_P*=$cc_documento_us2\n");
                    fputs($fp, "*NOM_E*=$nombret_us3_u\n");
                    fputs($fp, "*DIR_E*=$direccion_us3\n");
                    fputs($fp, "*MPIO_E*=$muni_nombre_us3\n");
                    fputs($fp, "*DEPTO_E*=$dpto_nombre_us3\n");
                    fputs($fp, "*TEL_E*=$telefono_us3\n");
                    fputs($fp, "*MAIL_E*=$mail_us3\n");
                    fputs($fp, "*NIT_E*=$cc_documento_us3\n");
                    fputs($fp, "*NUIR_E*=$nuir_e\n");
                    fputs($fp, "*F_RAD_S*=$fecha_hoy_corto\n");
                    fputs($fp, "*RAD_E*=$radicado_p\n");
                    fputs($fp, "*SAN_RADICACION*=$radicado_p\n");
                    fputs($fp, "*SECTOR*=$sector_nombre\n");
                    fputs($fp, "*NRO_PAGS*=$radi_nume_hoja\n");
                    fputs($fp, "*DESC_ANEXOS*=$radi_desc_anex\n");
                    fputs($fp, "*F_HOY_CORTO*=$fecha_hoy_corto\n");
                    fputs($fp, "*F_HOY*=$fecha_hoy\n");
                    fputs($fp, "*NUM_DOCTO*=$secuenciaDocto\n");
                    fputs($fp, "*F_DOCTO*=$fechaDocumento\n");
                    fputs($fp, "*F_DOCTO1*=$fechaDocumento2\n");
                    fputs($fp, "*FUNCIONARIO*=$usua_nomb\n");
                    fputs($fp, "*LOGIN*=$krd\n");
                    fputs($fp, "*DEP_NOMB*=$dependencianomb\n");
                    fputs($fp, "*CIU_TER*=$terr_ciu_nomb\n");
                    fputs($fp, "*DEP_SIGLA*=$dep_sigla\n");
                    fputs($fp, "*DEP_DIR*=$dep_dir\n");
                    fputs($fp, "*TER*=$terr_sigla\n");
                    fputs($fp, "*DIR_TER*=$terr_direccion\n");
                    fputs($fp, "*TER_L*=$terr_nombre\n");
                    fputs($fp, "*NOM_REC*=$nom_recurso\n");
                    fputs($fp, "*EXPEDIENTE*=$expRadi\n");
                    fputs($fp, "*NUM_EXPEDIENTE*=$expRadi\n");
                    fputs($fp, "*DIGNATARIO*=$otro_us1\n");

                    for ($i_count = 0; $i_count < count($camposSanc); $i_count++) {
                        fputs($fp, trim($camposSanc[$i_count]) . "=" . trim($datosSanc[$i_count]) . "\n");
                    }

                    for ($i_count = 0; $i_count < count($campos); $i_count++) {
                        fputs($fp, trim($campos[$i_count]) . "=" . trim($datos[$i_count]) . "\n");
                    }
                    fclose($fp);

//El include del servlet hace que se altere el valor de la variable  $estadoTransaccion como 0 si se pudo procesar el documento, -1 de lo
// contrario
                    $estadoTransaccion = -1;

                    if ($ext == "ODT" || $ext == "odt") {
                        //Se incluye la clase que maneja la combinaci�n masiva
                        include ( "$ruta_raiz/radsalida/masiva/OpenDocText.class.php" );
                        define('WORKDIR', "./$carpetaBodega/tmp/workDir/");
                        define('CACHE', WORKDIR . 'cacheODT/');

                        //Se abre archivo de insumo para lectura de los datos
                        $fp = fopen("$ruta_raiz/$carpetaBodega/masiva/$archInsumo", 'r');
                        if ($fp) {
                            $contenidoCSV = file("$ruta_raiz/$carpetaBodega/masiva/$archInsumo");
                            fclose($fp);
                        } else {
                            echo "<br><b>No hay acceso para crear el archivo $archInsumo <b>";
                            exit();
                        }
                        $accion = false;
                        $odt = new OpenDocText();
                        //Se carga el archivo odt Original 
                        $archivoACargar = str_replace('./', '', $linkarchivo);
                        $odt->cargarOdt("$archivoACargar", $nombreArchivo);
                        $odt->setWorkDir(WORKDIR);
                        $accion = $odt->abrirOdt();
                        if (!$accion) {
                            die("<CENTER><table class=borde_tab><tr><td class=titulosError>Problemas en el servidor abriendo archivo ODT para combinaci&oacute;n.</td></tr></table>");
                        }
                        $odt->cargarContenido();

                        //Se recorre el archivo de insumo
                        foreach ($contenidoCSV as $line_num => $line) {
                            if ($line_num > 1) { //Desde la linea 2 hasta el final del archivo de insumo estan los datos de reemplazo
                                $cadaLinea = explode("=", $line);
                                $cadaLinea[1] = str_replace("<", "'", $cadaLinea[1]);
                                $cadaLinea[1] = str_replace(">", "'", $cadaLinea[1]);
                                $cadaVariable[$line_num - 2] = $cadaLinea[0];
                                $cadaValor[$line_num - 2] = $cadaLinea[1];
                            }
                        }
                        $tipoUnitario = '1';
                        if ($vp == "s") {
                            $linkarchivo_grabar = str_replace("$carpetaBodega/", "", $linkarchivotmp);
                            $linkarchivo_grabar = str_replace("./", "", $linkarchivo_grabar);
                            $odt->setVariable($cadaVariable, $cadaValor);
                            $archivoDefinitivo = $odt->salvarCambios(null, $linkarchivo_grabar, '1');
                        } else {
                            $odt->setVariable($cadaVariable, $cadaValor);
                            $odt->salvarCambios(null, $linkarchivo_grabar, '1');
                        }
                        $db->conn->CommitTrans();
                        $odt->borrar();
                        echo "<script> function abrirArchivo(url){nombreventana='Documento'; window.open(url, nombreventana,  'status, width=900,height=500,screenX=100,screenY=75,left=50,top=75');return; }</script>
<br><B><CENTER><span class='info'>Combinaci&oacute;n de correspondencia realizada <br>";
                        echo "<B><CENTER><a class='vinculos' href='./seguridadImagen.php?fec=" . base64_encode($linkarchivo_grabar) . "'> Ver archivo </a><br>";
                    } elseif ($ext == "XML" || $ext == "xml") {
                        //Se incluye la clase que maneja la combinacion masiva
                        include ( "$ruta_raiz/include/AdminArchivosXML.class.php" );
                        define('WORKDIR', "./$carpetaBodega/tmp/workDir/");
                        define('CACHE', WORKDIR . 'cacheODT/');

                        //Se abre archivo de insumo para lectura de los datos
                        $fp = fopen("$ruta_raiz/$carpetaBodega/masiva/$archInsumo", 'r');
                        if ($fp) {
                            $contenidoCSV = file("$ruta_raiz/$carpetaBodega/masiva/$archInsumo");
                            fclose($fp);
                        } else {
                            echo "<br><b>No hay acceso para crear el archivo $archInsumo <b>";
                            exit();
                        }
                        $accion = false;
                        $xml = new AdminArchivosXML();
                        //Se carga el archivo odt Original
                        $archivoACargar = str_replace('../', '', $linkarchivo);
                        $xml->cargarXML("$archivoACargar", $nombreArchivo);
                        $xml->setWorkDir(WORKDIR);
                        $accion = $xml->abrirXML();
                        $xml->cargarContenido();

                        //Se recorre el archivo de insumo
                        foreach ($contenidoCSV as $line_num => $line) {
                            if ($line_num > 1) { //Desde la linea 2 hasta el final del archivo de insumo estan los datos de reemplazo
                                $cadaLinea = explode("=", $line);
                                $cadaLinea[1] = str_replace("<", "'", $cadaLinea[1]);
                                $cadaLinea[1] = str_replace(">", "'", $cadaLinea[1]);
                                $cadaVariable[$line_num - 2] = $cadaLinea[0];
                                $cadaValor[$line_num - 2] = $cadaLinea[1];
                            }
                        }
                        if ($vp == "s") {
                            $linkarchivo_grabar = str_replace("$carpetaBodega", "", $linkarchivotmp);
                            $linkarchivo_grabar = str_replace("./", "", $linkarchivo_grabar);
                        }

                        $xml->setVariable($cadaVariable, $cadaValor);
                        $xml->salvarCambios(null, $linkarchivo_grabar);
                        $db->conn->CommitTrans();
                        echo "<script> function abrirArchivo(url){nombreventana='Documento'; window.open(url, nombreventana,  'status, width=900,height=500,screenX=100,screenY=75,left=50,top=75');return; }</script>
<br><B><CENTER><span class='info'>Combinacion de Correspondencia Realizada <br>";
                        echo "<B><CENTER><a class='vinculos' href='./seguridadImagen.php?fec=" . base64_encode($linkarchivo_grabar) . "'> Ver Archivo </a><br>";
                    } else {
                        include ("http://$servProcDocs/docgen/servlet/WorkDistributor?accion=1&ambiente=$ambiente&archinsumo=$archInsumo&vp=$vp");
                        if ($estadoTransaccion != 0) {
                            $db->conn->RollbackTrans();
                            $objError = new CombinaError(NO_DEFINIDO);
                            echo ($objError->getMessage());
                            die;
                        }
                        print ("<BR> El estado de la transaccion....$estadoTransaccion");
                        error_reporting(0);
                        $linkarchivo_grabar = $linkarchivo;
                        if (!strrpos($rad_salida, "XXX")) {
                            copy("$ruta_raiz/$linkarchivo", "$ruta_raiz/$carpetaBodega/masiva/$nombreArchivo.cb");
                            copy("$ruta_raiz/$carpetaBodega/masiva/$nombreArchivo", "$ruta_raiz/$linkarchivo");
                        }

                        $db->conn->CommitTrans();
                        if (!strrpos($rad_salida, "XXX") && $radObjeto->radicado_codigo($rad_salida))
                            copy("$ruta_raiz/$carpetaBodega/masiva/$nombreArchivo.cb", "$ruta_raiz/$linkarchivo");
                    }
                    ?>
                    </body>
