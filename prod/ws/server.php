<?php
/**
 * WebService que realiza diferentes funciones a nivel interno en MinAgricutura.
 * @author Grupo Iyunxi Ltda <info@iyu.com.co>
 * @version 1.0
 */
$tipoMod="SWs";
require "../../../_config.php";
/**
 * Ruta fï¿?sica donde se encuentra el proyecto ADOdb.
 * @var string
 */
//$rutaAdoDB = "/var/www/seguro/temp/include/class/adodb/";

/**
 * Ruta fï¿?sica donde se encuentra el proyecto NuSOAP.
 * @var string
 */
//$rutaNuSOAP = "/var/www/pqr/nusoap-0.7.3/";

/**
 * Ruta fï¿?sica donde se encuentra el archivo config.php de Orfeo.
 * @var string
 */
//$rutaConfig = "../";

/**
 * Ruta fï¿?sica donde se encuentra la estructura de carpetas de la bodega de Orfeo.
 * @var string
 */
//$rutaBodega = "../bodega/";

/**
 * Version a la que esta conectado
 */
//$version_orfeo = "temp";

//Agregamos nusoap y Adodb a la variable include_path para su instanciacion.
ini_set('include_path', $rutaNuSOAP."/lib:".$rutaAdoDB);
// incluimos la clase NuSOAP
require_once("nusoap.php");

// Declaramos el namespace, el cual sera utilizado al momento de crear el WS.
//$ns = "https://citrino.sgc.gov.co/prod/ws";
// instanciamos el objeto server, brindado por la clase soap_server
$objServer = new soap_server();
$objServer->setDebugLevel(1);
$objServer->debug_flag=false;
// wsdl generation
$objServer->configureWSDL('OrfeoWebService', $ns);
$objServer->wsdl->schemaTargetNamespace = $ns;


//Registramos metodos
$objServer->register('HolaMundo',
                    array('nombre' => 'xsd:string'),
                    array('return' => 'xsd:string'),
                    $ns,false,false,false,
                    "Metodo de prueba. Para probar conexion rapida a OrfeoWebService");

$objServer->register('GetRadicadoInterfazApp',
                    array('cod_app' => 'xsd:integer',
                          'referencia'=>'xsd:string'),
                    array('return' => 'xsd:string'),
                    $ns,false,false,false,
                    "Metodo que brindado un codigo y referencia de un S.I. retorna una cadena con los radicados (separada por comas) asociados a dicho parametros.");

$objServer->register('CrearRadicado',
                    array(  'cod_app'=>'xsd:int',
                            'referencia'=>'xsd:string',
                            'usrRadicador'=>'xsd:string',
                            'TipoTercero'=>'xsd:int',
                            'NombreTercero'=>'xsd:string',
                            'PrimerApellidoTercero'=>'xsd:string',
                            'SegundoApellidoTercero'=>'xsd:string',
                            'TipoIDTercero'=>'xsd:long',
                            'NumeroIDTercero'=>'xsd:string',
                            'CorreoElectronicoTercero'=>'xsd:string',
                            'DireccionTercero'=>'xsd:string',
                    		'Internacionalizacion'=>'xsd:string',
                            'AsuntoRadicado'=>'xsd:string',
                            'FechaOficioRadicado'=>'xsd:date'),
                    array('return' => 'xsd:long'),
                    $ns,false,false,false,
                    "Metodo que genera un radicado de entrada en Orfeo.");

$objServer->register('anexarArchivo',
                    array(  'archivo'=>'xsd:base64binary',
                            'nombreArchivo'=>'xsd:string',
                            'radicado'=>'xsd:long',
                            'usrRadicador'=>'xsd:string',
                            'principal'=>'xsd:boolean'),
                    array('return' => 'xsd:boolean'),
                    $ns,false,false,false,
                    "Metodo cuya finalidad es anexar un documento a un radicado.");

/**
 * Metodo de comprobacion de conexion a WebService
 *
 * @param <string> $nombre Nombre de la persona. Obligatorio.
 * @return <string> Concatenacion "Hola" + $nombre.
 */
function HolaMundo ($nombre)
{
    if (!empty($nombre))
        return "Hola ".$nombre;
    else
        return new soap_fault('Client', '', 'Faltan datos basicos.');
}

/**
 * Mï¿?todo que dado un codigo y referencia de un sistema de informaciï¿?n
 * retorna una cadena (separada por comas) de radicados asociados con los parï¿?metros brindados.
 * @param <smallint> $codApp Codigo del aplicativo interfaz parametrizado en Orfeo. Obligatorio.
 * @param <string> $referencia Referencia de enlace con la aplicacion previa parametrizada. Obligatorio.
 * @global rutaConfig
 * @return <string> Cadena de radicados separada por comas.
 */
function GetRadicadoInterfazApp($codApp, $referencia)
{
    if (empty($codApp) || empty($referencia))
        return new soap_fault('Client', '', 'Faltan datos basicos.');
    else
    {
        if (is_numeric($codApp) && is_string($referencia))
        {
            require($GLOBALS['pathOrfeo']."/config.php");
            define('ADODB_ASSOC_CASE', 1);
            require("adodb.inc.php");
            $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
            $dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
            $conn = NewADOConnection($dsn);
            if ($conn===false)	return new soap_fault('Server', '', 'Error de Conexion a BD.');
            $query = "SELECT radi_nume_radi as RADICADO FROM RADICADO WHERE SGD_APLI_CODIGO=$codApp AND SGD_APLI_ENLACE='$referencia' ";
            $ADODB_COUNTRECS = true;
            $conn->SetFetchMode(ADODB_FETCH_ASSOC);
            $rs = $conn->Execute($query);
            $ADODB_COUNTRECS = false;
            if ($rs===false)	return new soap_fault('Server', '', 'Error en la consulta.');
            if ($rs->RecordCount() == 0)	return new soap_fault('Server', '', 'No se hallaron registros.');
            while(!$rs->EOF)
            {
                $algo[] = $rs->fields['RADICADO'];
                $rs->MoveNext();
            }
            return implode(',',$algo);
        }
        else
            return new soap_fault('Server', '', 'Datos brindados erroneos.');
    }
}

/**
 * Mï¿?todo que dados unos parï¿?metros de entrada genera un adicado de entrada en Orfeo.
 * @param <integer> $cod_app        Codigo del aplicativo interfaz parametrizado en Orfeo. Obligatorio.
 * @param <string> $referencia      Referencia de enlace con la aplicacion previa parametrizada.
 * @param <string> $usrRadicador    Login del usuario preestablecido para realizar la radicaciï¿?n a travï¿?s del webservice. Obligatorio.
 * @param <integer> $TipoTercero    Cï¿?digo de tipo de usuario que genera el radicado. 1=Ciudadano 2=Entidad 3=Empresa 4=Funcionario. Solo estï¿? habilitada la lï¿?gica para los valores 1 y 3. Obligatorio.
 * @param <string> $NombreTercero   Si TipoTercero es 1 se envia nombre del ciudadano. Si TipoTercero es 3 se envia nombre de la empresa. Obligatorio.
 * @param <string> $PrimerApellidoTercero   Si TipoTercero es 1 se envia 1er apellido del ciudadano. Si TipoTercero es 3 se envia sigla de la empresa.
 * @param <string> $SegundoApellidoTercero  Si TipoTercero es 1 se envia 2o apellido del ciudadano. Si TipoTercero es 3 se envia representante legal de la empresa.
 * @param <integer> $TipoIDTercero  Cï¿?digo de tipo de identificaciï¿?n. 0=Cï¿?dula de Ciudadanï¿?a 1=Tarjeta de Identidad 2=Cï¿?dula de Extranjerï¿?a 3=Pasaporte 4=Nit 5=NUIR.
 * @param <string> $NumeroIDTercero Referencia segï¿?n el tipo de identificaciï¿?n (TipoIDTercero).
 * @param <string> $CorreoElectronicoTercero    Correo Electronico a travï¿?s del cual se responderï¿? al radicado.
 * @param <string> $DireccionTercero    Direcciï¿?n correspondencia del ciudadano/empresa. Obligatorio.
 * @param <string> $Internacionalizacion   CodCont-CodPais-CodDpto-CodMcpio. Obligatorio.
 * @param <string> $AsuntoRadicado  Asunto o descripcion del radicado a crear. Obligatorio.
 * @param <date> $FechaOficioRadicado   Fecha del documento con que se crea el radicado. Formato AAAA-MM-DD. Sino se envia toma la fecha del sistema.
 * @return <long> Numero de radicado.   Cï¿?digo de radicado Orfeo.
 */
function CrearRadicado( $cod_app,
                        $referencia,
                        $usrRadicador,
                        $TipoTercero,
                        $NombreTercero,
                        $PrimerApellidoTercero,
                        $SegundoApellidoTercero,
                        $TipoIDTercero,
                        $NumeroIDTercero,
                        $CorreoElectronicoTercero,
                        $DireccionTercero,
                        $Internacionalizacion,
                        $AsuntoRadicado,
                        $FechaOficioRadicado
                        )
{
    $validaOk = true;
    //1a validacion. Que vengan datos basicos.
    if (empty($cod_app) || empty($usrRadicador) || empty($TipoTercero) || empty($NombreTercero) ||
        empty($DireccionTercero) || empty($Internacionalizacion) || empty($AsuntoRadicado)
        )
        return new soap_fault('Client', '', 'Faltan datos basicos.');
    else
    {   //2a validacion. Que los datos brindados sean validos en tipologia (y longitud).
        $cadError = array();
        //Validamos codigo de aplicacion interfaz
        if (!is_numeric($cod_app))
        {
            $cadError[] = 'Codigo aplicativo debe ser numerico.';
            $validaOk = false;
        }
        $InterNal = explode('-',$Internacionalizacion);
        if (count($InterNal) != 4)
    	{
            $cadError[] = 'Internacionalizacion debe ser del tipo IdContinente-IdPAis-IdDpto-IdMcpio.';
            $validaOk = false;
        }
        else
        {
        	$idCont = $InterNal[0];
        	$idPais = $InterNal[1];
        	$idDpto = $InterNal[2];
        	$idMpio = $InterNal[3];
        }
        //Validamos tipo tercero.
        if (!is_numeric($TipoTercero))
        {
            $cadError[] = 'Tipo tercero debe ser numerico.';
            $validaOk = false;
        }
        else
        {
            $sgd_ciu_codigo='null';
            $sgd_oem_codigo='null';
            $sgd_esp_codigo='null';
            $sgd_fun_codigo='null';
            switch ($TipoTercero)
            {
                case 1: //USUARIO
                {
                    $Tercero = 0;
                    $sgdTrd = 1;
                    $datos_t = array();
                    $datos_t['TDID_CODI'] = $TipoIDTercero;
                    $datos_t['SGD_CIU_NOMBRE'] = substr($NombreTercero, 0, 130);
                    $datos_t['SGD_CIU_DIRECCION'] = substr($DireccionTercero, 0, 145);
                    $datos_t['ID_CONT'] = $idCont;
                    $datos_t['ID_PAIS'] = $idPais;
                    $datos_t['MUNI_CODI'] = $idMpio;
                    $datos_t['DPTO_CODI'] = $idDpto;
                    $datos_t['SGD_CIU_APELL1'] = substr($PrimerApellidoTercero, 0, 45);
                    $datos_t['SGD_CIU_APELL2'] = substr($SegundoApellidoTercero, 0, 45);
                    $datos_t['SGD_CIU_EMAIL'] = substr($CorreoElectronicoTercero, 0, 50);
                    $datos_t['SGD_CIU_CEDULA'] = substr($NumeroIDTercero, 0, 13);
                }break;
                case 2: //ENTIDADES
                {   $Tercero = 1;
                    $sgdTrd = 3;
                    return new soap_fault('Server', '', 'Logica no implementada para tipo tercero entidad.');
                }break;
                case 3: //EMPRESAS
                {   $Tercero = 2;
                    $sgdTrd = 2;
                    $datos_t = array();
                    $datos_t['TDID_CODI'] = $TipoIDTercero;
                    $datos_t['SGD_OEM_OEMPRESA'] = substr($NombreTercero, 0, 130);
                    $datos_t['SGD_OEM_DIRECCION'] = substr($DireccionTercero, 0, 145);
                    $datos_t['ID_CONT'] = $idCont;
                    $datos_t['ID_PAIS'] = $idPais;
                    $datos_t['MUNI_CODI'] = $idMpio;
                    $datos_t['DPTO_CODI'] = $idDpto;
                    $datos_t['SGD_OEM_SIGLA'] = substr($PrimerApellidoTercero, 0, 45);
                    $datos_t['SGD_OEM_REP_LEGAL'] = substr($SegundoApellidoTercero, 0, 45);
                    $datos_t['SGD_OEM_NIT'] = substr($NumeroIDTercero, 0, 13);
                }break;
                case 4: //FUNCIONARIOS
                {   $Tercero = 6;
                    $sgdTrd = 4;
                    return new soap_fault('Server', '', 'Logica no implementada para tipo tercero funcionarios.');
                }break;
                default:
                {   $cadError[] = 'Tipo tercero no valido.';
                    $validaOk = false;
                }break;
            }
        }

        //Validamos datos en BD previos a radicar.

        require($GLOBALS['pathOrfeo']."/config.php");
        define('ADODB_ASSOC_CASE', 1);
        require("adodb.inc.php");
        $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
        $dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
        $conn = NewADOConnection($dsn);

        ///// Hasta aqui validamos tipologia de los OBLIGATORIOS /////
        //Validamos tipo de identificacion.
        if (is_numeric($TipoIDTercero))
        {
            if(ereg( "([0-5]{1})", $TipoIDTercero))
            {
                //$cadError[] = 'Tipo identificacion tercero esta entre 0 y 5.';
                //$validaOk = false;
            }
            else
            {
                $cadError[] = 'Tipo identificacion tercero no valido.';
                $validaOk = false;
             }
        }
        else
        {
            $cadError[] = 'Tipo identificacion tercero debe ser numerico.';
            $validaOk = false;
        }
        //Validamos fecha de oficio
        if (empty($FechaOficioRadicado))
        {
            $fechaRadicado= date('Y-m-d');
            $fechaRadicado = $conn->DBDate($fechaRadicado);
        }
        else
        {
            if (is_date($FechaOficioRadicado))
                $fechaRadicado = $FechaOficioRadicado;
            else
            {
                $cadError[] = 'Formato fecha no valido (YYYY-mm-dd).';
                $validaOk = false;
            }
        }
        //Validamos formato correo electronico
        if (comprobar_email($CorreoElectronicoTercero))
        {
            $email = $CorreoElectronicoTercero;
        }
        else
        {
            $cadError[] = 'Formato correo electronico erroneo.';
            $validaOk = false;
        }
        if ($conn===false)	return new soap_fault('Server', '', 'Error de Conexion a BD.');

        $conn->StartTrans();

        $sql = "SELECT SGD_APLI_DEPE as DEPEN, SGD_APLI_ESTADO as ESTADO FROM SGD_APLICACIONES WHERE SGD_APLI_CODIGO=$cod_app";
        $ADODB_COUNTRECS = true;
        $conn->SetFetchMode(ADODB_FETCH_ASSOC);
        $rs = $conn->Execute($sql);
		if ($rs===false)	return new soap_fault('Server', '', 'Error en la consulta de aplicaciones interfaz.');
		if ($rs->RecordCount() == 0)
        {
            $cadError[] = 'Codigo aplicativo inexistente.';
            $validaOk = false;
        }
        else
        {
            if ($rs->fields['ESTADO'] == 0)
            {
                $cadError[] = 'Codigo aplicativo inactivo.';
                $validaOk = false;
            }
            else
            {
                $depe_destino = $rs->fields['DEPEN'];
                $sql = "SELECT USUA_DOC as DOC_JEFE_DEPE_DESTINO FROM USUARIO WHERE DEPE_CODI=$depe_destino AND USUA_CODI=1";
                $rs = $conn->Execute($sql);
                if ($rs===false)	return new soap_fault('Server', '', 'Error en la consulta de usuario jefe.');
                if ($rs->RecordCount() == 0)
                {
                    return new soap_fault('Server', '', 'La dependencia destino no tiene configurado un Jefe.');
                }
                $usua_docu_jefe = $rs->fields['DOC_JEFE_DEPE_DESTINO'];
            }
        }
        //b. validamos el usuario radicador.
        $sql = "select u.usua_codi, u.depe_codi, u.usua_esta, u.usua_prad_tp2, u.codi_nivel, u.usua_doc, d.depe_rad_tp2
                from usuario u
                    inner join dependencia d on u.depe_codi=d.depe_codi
                where usua_login='$usrRadicador'";
        $rs = $conn->Execute($sql);
		$ADODB_COUNTRECS = false;
		if ($rs===false)	return new soap_fault('Server', '', 'Error en la consulta de usuarios.');
		if ($rs->RecordCount() == 0)
        {
            $cadError[] = 'Usuario radicador inexistente.';
            $validaOk = false;
        }
        else
        {
            if ($rs->fields['USUA_ESTA'] == 0)
            {
                $cadError[] = 'Usuario radicador inactivo.';
                $validaOk = false;
            }
            if ($rs->fields['USUA_PRAD_TP2'] == 0)
            {
                $cadError[] = 'Usuario radicador no tiene permisos para radicacion de entrada.';
                $validaOk = false;
            }

            if (is_null($rs->fields['DEPE_RAD_TP2']))
            {
                $cadError[] = 'Usuario radicador no tiene configurada la dependencia para radicacion de entrada.';
                $validaOk = false;
            }

            $depe_radi = $rs->fields['DEPE_CODI'];
            $usua_radi = $rs->fields['USUA_CODI'];
            $usua_docu = $rs->fields['USUA_DOC'];
            $usua_nivel = $rs->fields['CODI_NIVEL'];
            $depe_radi_entrada = $rs->fields['DEPE_RAD_TP2'];
        }
        if ($validaOk)
        {
            //1. Validar subida de archivo.
            //  POR HACER ************************
            //2. Generamos radicado.
            //a. Crear registro en tabla radicado.
            $datos_r['CARP_PER'] = 0;
            $datos_r['CARP_CODI'] = 0;
            $datos_r['TDOC_CODI'] = 0;
            $datos_r['RA_ASUN'] = stripcslashes(substr($AsuntoRadicado, 0, 350));
            $datos_r['RADI_PATH'] = 'null';
            $datos_r['TRTE_CODI'] = $Tercero;
            $datos_r['MREC_CODI'] = 3;   //Medio de recepcion
            $datos_r['EESP_CODI'] = 'null';   //Identificacion 3a pestaï¿?a
            $datos_r['RADI_FECH_OFIC'] = $conn->DBDate($fechaRadicado);
            $datos_r['RADI_USUA_ACTU'] = 1;
            $datos_r['RADI_DEPE_ACTU'] = $depe_destino;
            $datos_r['RADI_FECH_RADI'] = $conn->sysTimeStamp;
            $datos_r['RADI_USUA_RADI'] = $usua_radi;
            $datos_r['RADI_DEPE_RADI'] = $depe_destino;
            $datos_r['CODI_NIVEL'] = $usua_nivel;
            $datos_r['FLAG_NIVEL'] = 1;
            $datos_r['RADI_LEIDO'] = 0;
            $datos_r['SGD_APLI_CODIGO'] = $cod_app;
            $datos_r['SGD_APLI_ENLACE'] = htmlspecialchars(stripcslashes(substr($referencia, 0, 16)));
            /// Iniciamos Radicacion ///
            $secNew = $conn->GenID("SECR_TP2_$depe_radi_entrada");
            if ($secNew == FALSE)
            {   $conn->CompleteTrans();
                return new soap_fault('Server', '', "Error al consultar secuencia. <!-- SECR_TP2_$depe_radi_entrada-->");
            }
            $newRadicado = date("Y") . str_pad($depe_radi,3,"0", STR_PAD_LEFT) . str_pad($secNew, 6, "0", STR_PAD_LEFT) . "2";
            $datos_r['RADI_NUME_RADI'] = $newRadicado;
            $codigo_seguridad = 1;
            
            $tabla = 'RADICADO';
            //$ok_r = $conn->AutoExecute($tabla, $datos_r, 'INSERT', false, false, false);
            
            $sql_r = "INSERT INTO RADICADO ".
                    "(CARP_PER,CARP_CODI,TDOC_CODI,RA_ASUN,TRTE_CODI,MREC_CODI,RADI_FECH_OFIC,RADI_USUA_ACTU,RADI_DEPE_ACTU,RADI_FECH_RADI,RADI_USUA_RADI,RADI_DEPE_RADI,CODI_NIVEL,FLAG_NIVEL,RADI_LEIDO,SGD_APLI_CODIGO,SGD_APLI_ENLACE,RADI_NUME_RADI) ". //si desea agregar los rad de entrada como privado agregue la variable $codigo_seguridad y tambien el campo sgd_spub_codigo
                    "VALUES ".
                    "(0, 0, 0, '".stripcslashes(substr($AsuntoRadicado, 0, 350))."', $Tercero, 3, ".$conn->DBDate($fechaRadicado).", 1, $depe_destino, ".$conn->sysTimeStamp.", $usua_radi, $depe_destino, $usua_nivel, 1, 0, $cod_app, '".htmlspecialchars(stripcslashes(substr($referencia, 0, 16)))."',$newRadicado)";
            $ok_r = $conn->Execute($sql_r);
            
            
            if ($ok_r === FALSE)
            {   $conn->CompleteTrans();
                return new soap_fault('Server', '', "Error en la insercion de radicado. <!-- ".$sql_r." -->");
            }
            else
            {
                //b. Crear registro en tabla historico.
                $datos_h["RADI_NUME_RADI"] = $newRadicado;
                $datos_h["DEPE_CODI"] = $depe_radi;
                $datos_h["USUA_CODI"] = $usua_radi;
                $datos_h["USUA_CODI_DEST"] = 1;
                $datos_h["DEPE_CODI_DEST"] = $depe_destino;
                $datos_h["USUA_DOC"] = $usua_docu;
                $datos_h["HIST_DOC_DEST"] = $usua_docu_jefe;
                $datos_h["SGD_TTR_CODIGO"] = 2;
                $datos_h["HIST_OBSE"] = 'Radicacion Via Web Service';
                $datos_h["HIST_FECH"] = $conn->sysTimeStamp;
                $tabla = 'HIST_EVENTOS';
                //$sql_h = $conn->GetInsertSQL($tabla, $datos_h, false, false);
                
                 $sql_h = "INSERT INTO HIST_EVENTOS ".
                         "(RADI_NUME_RADI,DEPE_CODI,USUA_CODI,USUA_CODI_DEST,DEPE_CODI_DEST,USUA_DOC,HIST_DOC_DEST,SGD_TTR_CODIGO,HIST_OBSE,HIST_FECH) ".
                         "VALUES ".
                         "($newRadicado, $depe_radi, $usua_radi, 1,$depe_destino, '$usua_docu', '$usua_docu_jefe', 2, ' ', ".$conn->sysTimeStamp.")";
                 
                $ok_h = $conn->Execute($sql_h);
                if ($ok_h === FALSE)
                {   $conn->CompleteTrans();
                    return new soap_fault('Server', '', "Error en la insercion de historico. <!-- $sql_h -->");
                }
                else
                {
                    //c. Crear registro en tabla de tercero.
                    switch ($TipoTercero)
                    {
                        case 1:
                        {
                            $secuencia = $conn->GenID("SEC_CIU_CIUDADANO");
                            if ($secuencia === FALSE)
                            {   $conn->CompleteTrans();
                                return new soap_fault('Server', '', 'Error al generar secuencia de ciudadanos.');
                            }
                            $datos_t['SGD_CIU_CODIGO'] = $secuencia;
                            $sgd_ciu_codigo = $secuencia;
                            $tabla = 'SGD_CIU_CIUDADANO';
                        }break;
                        case 3:
                        {
                            $secuencia = $conn->GenID("SEC_OEM_OEMPRESAS");
                            if ($secuencia === FALSE)
                            {   $conn->CompleteTrans();
                                return new soap_fault('Server', '', 'Error al generar secuencia de empresas.');
                            }
                            $datos_t['SGD_OEM_CODIGO'] = $secuencia;
                            $sgd_oem_codigo = $secuencia;
                            $tabla = 'SGD_OEM_OEMPRESAS';
                        }break;
                        default:
                            break;
                    }
                    $sql_t = $conn->GetInsertSQL($tabla, $datos_t, $magicq=false, $force_type=false);
                    $ok_t = $conn->Execute($sql_t);

                    if ($ok_t === FALSE)
                    {   $conn->CompleteTrans();
                        return new soap_fault('Server', '', "Error en la inserción de tercero. <!-- $sql_t --> ");
                    }
                    else
                    {   //d. Crear registro en tabla sgd_dir_drecciones.
                        $nextval = $conn->GenID("sec_dir_direcciones");
                        if ($nextval === FALSE)
                        {   $conn->CompleteTrans();
                            return new soap_fault('Server', '', 'Error al generar secuencia de direcciones.');
                        }
                        $ADODB_FORCE_TYPE = ADODB_FORCE_NULL;
                        $grbNombresUs1 = substr(trim($NombreTercero)." ".trim($PrimerApellidoTercero)." ".trim($SegundoApellidoTercero), 0, 900) ;
                        $datos_d = array();
                        $datos_d['SGD_TRD_CODIGO'] = $sgdTrd;
                        $datos_d['SGD_DIR_NOMREMDES'] = $grbNombresUs1;
                        $datos_d['SGD_DIR_TDOC'] = $TipoIDTercero;
                        $datos_d['SGD_DIR_DOC'] = $NumeroIDTercero;
                        $datos_d['MUNI_CODI'] = 'null';
                        $datos_d['DPTO_CODI'] = 'null';
                        $datos_d['ID_PAIS'] = 'null';
                        $datos_d['ID_CONT'] = 'null';
                        $datos_d['SGD_DOC_FUN'] = $sgd_fun_codigo;
                        $datos_d['SGD_CIU_CODIGO'] = $sgd_ciu_codigo;
                        $datos_d['SGD_OEM_CODIGO'] = $sgd_oem_codigo;
                        $datos_d['SGD_ESP_CODI'] = $sgd_esp_codigo;
                        $datos_d['RADI_NUME_RADI'] = $newRadicado;
                        $datos_d['SGD_SEC_CODIGO'] = 0;
                        $datos_d['SGD_DIR_DIRECCION'] = $DireccionTercero;
                        $datos_d['ID_CONT'] = $idCont;
                    	$datos_d['ID_PAIS'] = $idPais;
                    	$datos_d['MUNI_CODI'] = $idMpio;
                    	$datos_d['DPTO_CODI'] = $idDpto;
                        $datos_d['SGD_DIR_TELEFONO'] = 'null';
                        $datos_d['SGD_DIR_MAIL'] = $CorreoElectronicoTercero;
                        $datos_d['SGD_DIR_TIPO'] = 1;
                        $datos_d['SGD_DIR_CODIGO'] = $nextval;
                        $record['SGD_DIR_NOMBRE'] = $otro_us1;
                        $tabla = "SGD_DIR_DRECCIONES";
                        $sql_d = $conn->GetInsertSQL($tabla, $datos_d, false, false);
                        $ok_d = $conn->Execute($sql_d);
                        if ($ok_d === FALSE)
                        {   $conn->CompleteTrans();
                            return new soap_fault('Server', '', "Error en la insercion de tercero.. <!-- $sql_d -->");
                        }
                    }
                }
            }
            $conn->CompleteTrans();
            if ($ok_r && $ok_h && $ok_t && $ok_d)
            {
                return $newRadicado;
            }
            else
                return false;
        }
        else
        return new soap_fault('Client', '', 'Los siguientes errores fueron hallados:<br>'.implode('<br>',$cadError));
    }
}

/**
 * Funcion para comprobar una direccion de correo.
 * @author  Alfredo Fernoandez  (http://www.magios.com) - 24/12/2002
 * @param   string $email Correo electronico.
 * @return  boolean
 * @access private
 */
function comprobar_email($email)
{
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@"))
    {
        if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"$")) && (!strstr($email," ")))
        {   //miro si tiene caracter .
            if (substr_count($email,".")>= 1)
            {   //obtengo la terminacion del dominio
                $term_dom = substr(strrchr ($email, '.'),1);
                //compruebo que la terminacion del dominio sea correcta
                if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) )
                {   //compruebo que lo de antes del dominio sea correcto
                    $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                    $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                    if ($caracter_ult != "@" && $caracter_ult != ".")
                    {
                        $mail_correcto = 1;
   }    }   }   }   }
   else
   {
       $mail_correcto = (trim($email) == '') ? 1 : 0;
   }
    if ($mail_correcto==1)
       return true;
    else
       return false;
}

/**
 * Funcion para comprobar una fecha.
 * @author http://blog.patoroco.net/2007/09/funcion-is_date/
 * @param date Fecha enviada, formato YYYY-MM-DD
 * @return boolean true si tiene el formato en caso contrario false.
 * @access private
 */
function is_date($fecha)
{   $band = TRUE;
    //Comprueba si la cadena introducida es de la forma Y/m/D (1920/04/15)
    if (ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $bloques))
    {
        if (($bloques[2]>12)|($bloques[2]<1))
        {
            $band = FALSE;
        }
        if (($bloques[2]==4)|($bloques[2]==6)|($bloques[2]==9)|($bloques[2]==11))
        {
            $dias_mes = 30;
        }else
        {
            if ($bloques[2]==2)
            {   //febrero
                if((($bloques[1]%4==0)&(!($bloques[1]%100==0)))|($bloques[1]%400==0))
                {
                    $dias_mes = 29;
                }else{
                    $dias_mes = 28;
                }
            }else
            {
                $dias_mes = 31;
            }
        }
        if (($bloques[3]<1)|($bloques[3]>$dias_mes))
        {
            $band = FALSE;
        }
    }
    else
    {
        $band = FALSE;
    }
    return $band;
}

/**
 * Mï¿?todo que anexa un documento a un radicado.
 * @param <base64binary> $archivo   Archivo encodado a base64. Obligatorio.
 * @param <string> $nombreArchivo   Nombre del archivo que se estï¿? anexando. Obligatorio.
 * @param <long> $radicado  Codigo Orfeo al cual se anexarï¿? el documento. Obligatorio.
 * @param <string> $usrRadicador    Login del usuario preestablecido para realizar la radicaciï¿?n a travï¿?s del webservice. Obligatorio.
 * @param <boolean> $principal  True se anexa como imagen principal al $radicado, False crearï¿? un documento anexo.
 * @return <boolean> Indica si se llevï¿? a cabo exitosamente la carga y actualizaciï¿?n del documento en el radicado.
 */
function anexarArchivo($archivo, $nombreArchivo, $radicado, $usrRadicador, $principal=false)
{
    if ( empty($archivo) || empty($nombreArchivo) || empty($radicado) || empty($usrRadicador))
    {
        return new soap_fault('Client', '', "Faltan datos basicos.");
    }
    else
    {
        $validaOk = true;
        $cadError = array();

        if (is_numeric($radicado))
        {
            require($GLOBALS['pathOrfeo']."/config.php");
            define('ADODB_ASSOC_CASE', 1);
            require("adodb.inc.php");
            $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
            $dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
            $conn = NewADOConnection($dsn);
            ////// VALIDACION DE CONEXION //////
            if ($conn===false)	return new soap_fault('Server', '', 'Error de Conexion a BD.');
            ////// VALIDACION DE USUARIO //////
            $sql = "select u.usua_esta from usuario u where usua_login='$usrRadicador'";
            $ADODB_COUNTRECS = true;
            $rs = $conn->Execute($sql);
            $ADODB_COUNTRECS = false;
            if ($rs===false)	return new soap_fault('Server', '', "Error en la verificacion de usuario $usrRadicador.");
            if ($rs->RecordCount() == 0)
            {
                $cadError[] = 'Usuario radicador inexistente.';
                $validaOk = false;
            }
            else
            {
                if ((int)$rs->fields['USUA_ESTA'] === 0)
                {
                    $cadError[] = 'Usuario radicador inactivo.';
                    $validaOk = false;
                }
            }
            ////// VALIDACION DE RADICADO //////
            $query = "SELECT RADI_PATH FROM RADICADO WHERE RADI_NUME_RADI=$radicado";
            $ADODB_COUNTRECS = true;
            $rs = $conn->Execute($query);

            if ($rs->RecordCount() == 0)
            {
                $cadError[] = 'Radicado no existe.';
                $validaOk = false;
            }
            else
            {
                // creamos ruta a bodega
                $ruta = $GLOBALS['rutaBodega']."/".substr($radicado,0,4)."/".substr($radicado,4,3)."/";
                $ruta .= ($principal) ? '' : "docs/";
                ///// Prevalidaciones de extension
                $tmp_extension = explode('.', $nombreArchivo);
                $extension = strtolower($tmp_extension[ count($tmp_extension) - 1]);
                //$nueva_extension = (count($tmp_extension)==1) ? '' : '.'.$extension;
                $fp = @fopen("{$ruta}{$nombreArchivo}", "w");
                if ($fp == FALSE)
                {
                    $cadError[] = 'Fallo al crear archivo en bodega.';
                    $validaOk = false;
                }
                else
                {   $bytes = base64_decode($archivo);
                    $anex_tamano = fwrite($fp,$bytes);
                    fclose($fp);
                }

                //Si es imagen principal de un radicado....
                if ($principal)
                {
                    if ($extension == 'pdf' || $extension == 'tif')
                    {   //Si no tiene imagen asignada...
                        if (empty($rs->fields['RADI_PATH']))
                        {
                            $ruta_query = "/".substr($radicado,0,4)."/".substr($radicado,4,3)."/$radicado.$extension";
                            $query = "UPDATE RADICADO SET RADI_PATH='$ruta_query' WHERE RADI_NUME_RADI=$radicado";
                            $nuevoNombreArchivo = "$radicado.$extension";
                        }
                        else
                        {
                            $cadError[] = 'Radicado ya posee imagen.';
                            $validaOk = false;
                        }
                    }
                    else
                    {
                        $cadError[] = 'El documento de imagen para radicados debe ser pdf o tif.';
                        $validaOk = false;
                    }
                }
                else
                {
                    $descripcion = 'Archivo subido via webservice.';
                    ////// VALIDACION DE SECUENCIA EN ANEXOS //////
                    $query = "SELECT COUNT(1) AS NUM_ANEX FROM ANEXOS WHERE ANEX_RADI_NUME=$radicado";
                    $cnt_actual_anexos = $conn->GetOne($query) + 1;
                    $query = "SELECT max(ANEX_NUMERO) AS NUM_ANEX FROM ANEXOS WHERE ANEX_RADI_NUME=$radicado";
                    $max_secuencia_anexos = $conn->GetOne($query) + 1;
                    $anex_numero = ($cnt_actual_anexos > $max_secuencia_anexos) ? $cnt_actual_anexos : $max_secuencia_anexos;
                    $anex_codigo = $radicado."_".substr("00000".$anex_numero,-5);
                    $query = "SELECT ANEX_TIPO_CODI FROM ANEXOS_TIPO WHERE ANEX_TIPO_EXT='$extension'";
                    $tmp_anex_tipo = $conn->GetOne($query);
                    $anex_tipo = empty($tmp_anex_tipo) ? "0" : $tmp_anex_tipo;
                    $fechaAnexado = $conn->OffsetDate(0,$conn->sysTimeStamp);
                    $query = "INSERT INTO ANEXOS
                                (ANEX_CODIGO, ANEX_RADI_NUME, ANEX_TIPO, ANEX_TAMANO, ANEX_SOLO_LECT,
                                ANEX_CREADOR, ANEX_DESC, ANEX_NUMERO, ANEX_NOMB_ARCHIVO, ANEX_ESTADO,
                                SGD_REM_DESTINO, ANEX_FECH_ANEX, ANEX_BORRADO)
                            VALUES
                                ('$anex_codigo', $radicado, $anex_tipo, ".round(($anex_tamano/1024),2).", 'n',
                                '$usrRadicador','$descripcion', $anex_numero, '$anex_codigo.$extension', 0,
                                1, $fechaAnexado, 'N')";

                    $nuevoNombreArchivo = "$anex_codigo.$extension";
                }
            }
            if ($validaOk)
            {
                $rs = $conn->Execute($query);
                $ok_r = rename("{$ruta}{$nombreArchivo}", "{$ruta}{$nuevoNombreArchivo}");
                if ($rs===false || $ok_r===false)	return new soap_fault('Server', '', "Error en la actualizacion en BD. <!-- $ok_r -->");
                return ($rs) ? $validaOk : $rs;
            }
            else
                return new soap_fault('Client', '', 'Los siguientes errores fueron hallados:<br>'.implode('<br>',$cadError));
        }
        else
        {
            return new soap_fault('Client', '', 'Radicado debe ser numerico.');
        }
    }
}

if (isset($HTTP_RAW_POST_DATA))
{
	$input = $HTTP_RAW_POST_DATA;
}
else
{
	$input = implode("\r\n", file('php://input'));
}
$objServer->service($input);
exit;
?>
