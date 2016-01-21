<?php
/*  CLASS jhrtf
 *  @autor JAIRO LOSADA - SIXTO
 *  @fecha 2003/10/16
 *  @version 0.1
 *  Permite hacer combinacion de correspondencia desde php con filas rtf-
 *  @VERSION 0.2
 *  @fecha 2004/01/22
 *  Se anade combinacion masiva
 *  @fecha 2004/08/30
 *  Se anaden las funciones:
 *  setTipoDocto(),verListado(),setDefinitivo(),mostrarError(),getNumColEnc(),validarEsp(),validarLugar(),validarTipo()
 *  validarRegistrosObligsCsv(),hayError(),cargarOblPlant(),cargarObligCsv(),cargarCampos(),validarArchs()
 *
 */
require_once("$ruta_raiz/include/pdf/class.ezpdf.inc");
require_once("$ruta_raiz/class_control/Esp.php");
require_once("$ruta_raiz/class_control/Dependencia.php");
require_once("$ruta_raiz/include/tx/Historico.php");
require_once("$ruta_raiz/class_control/Radicado.php");
require_once("$ruta_raiz/include/tx/Expediente.php");
require_once("$ruta_raiz/include/tx/Flujo.php");
require_once("$ruta_raiz/include/tx/Radicacion.php");



class jhrtf {

    var $archivo_insumo; // Ubicacion fisica del archivo que indica como habra de realizarce la combinacion
    var $alltext;        // ubicacion fisica del archivo a convertir
    var $texto_masivo; 	 // utilizado para combinar el vualquier texto
    var $encabezado;
    var $datos;
    var $ruta_raiz;
    var $definitivo;
    var $codigo_envio;
    var $radi_nume_grupo;
    //Contiene los campos obligatorios del archivo CSV
    var $camObligCsv;
    //Contiene los campos obligatorios de la plantilla
    var $camObligPlantilla;
    //Contiene los posibles errores hallados en el encabezado
    var $errorEncab;
    //Contiene los posibles errores hallados en la plantilla
    var $errorPlant;
    //Contiene los posibles errores hallados en los lugares referenciados en el CSV
    var $errorLugar;
    //Contiene los posibles errores hallados en las ESP referenciados en el CSV
    var $errorESP;
    //Contiene los posibles errores de completitud del CSV
    var $errorComplCsv;
    //Contiene los posibles errores del campo tipo de registro del CSV
    var $errorTipo;
    //Contiene los posibles errores del campo direccion del CSV
    var $errorDir;
    //Contiene los posibles errores del campo es anexo de un radicado
    var $errorRadAnexo;
    //Contiene los posibles errores del campo nombre del CSV
    var $errorNomb;
    var $arcPDF;
    //Contiene el path del archivo plantilla
    var $arcPlantilla;
    //Contiene el path del archivo CSV
    var $arcCSV;
    //Contiene el path del archivo Final
    var $arcFinal;
    //Contiene el path del archivo Temporal

    var $arcTmp;
    var $conexion;
    var $pdf;
    var $arregloEsp;
    var $arrCodDepto;
    var $arrCodMuni;
    var $arrCodPais;
    var $arrCodCont;
    var $tipoDocto;
    var $btt;       // Guarda la el objeto CLASS_CONTROL
    var $rad;       // Guarda la el objeto radicacion 
    var $handle; 	 // Almacena la conexion que permite efectuar algunas labores de masiva
    var $resulComb; // Almacena el resultado obtenido en la combinacion masiva
    var $objExp;

    var $codProceso;
    var $codFlujo;
    var $codArista;

    var $radarray;
    var $carpetaBodega;
    
    /**
     * Constructor que carga en la clase los parametros relevantes del proceso de combinación de documentos
     * @param	$archivo_insumo	string	es el path hacia el archivo que contiene los ratos de la combinaci�n
     * @param	$ruta_raiz	string	es el path hacia la raiz del directorio de ORFEO
     * @param	$arcPDF	string	es el path hacia el archivo PDF que habr� de mostrar el resultado de la combinaci�n
     * @param	$db	ConnectionHandler	Manejador de la conexi�n con la base de datos
     */
    function jhrtf($archivo_insumo,$ruta_raiz,$arcPDF,&$db){
        $this->arcCSV      = $archivo_insumo;
        $this->ruta_raiz   = $ruta_raiz;
        $this->arcPDF      = $arcPDF;
        $this->conexion    = $db;
        
        $this->setConexion($db);
        
        include "$ruta_raiz/config.php";
        $this->carpetaBodega = $carpetaBodega;
        
    }


    /**
     * Funcion que carga en la clase el manejador de conexion con la base de datos, en caso de ser necesario
     * @param	$db	ConnectionHandler	Manejador de la conexi�n con la base de datos
     */
    function setConexion($db){	
        $this->conexion = $db;	
    }


    /*
     * Funcion encargada de gestionar en la base de datos la transaccion 
     * que implica la combinacion del documento, desde el archivo CSV
     * @param	$dependencia	string	es la dependencia del usuario que realiza la combinacion
     * @param	$codusuario	string	es el codigo del usuario que realiza la combinacion
     * @param	$usua_doc	string	es numero del documento del usuario que realiza la combinacion
     * @param	$usua_nomb	string	es el nombre del usuario que realiza la combinacion
     * @param	$depe_codi_territorial	string	es el nombre de la territorial a la que 
     * pertenece el usuario usuario que realiza la combinacion
     */

    function combinar_csv($dependencia,$codusuario,$usua_doc,$usua_nomb,$depe_codi_territorial,$codiTRD,$tipoRad){

        //Var que contiene el arreglo de radicados genrados a partir de la masiva
        $arrRadicados =  array();

        //Instancia de la dependencia
        $objDependecia = new Dependencia($this->conexion);
        $objDependecia->Dependencia_codigo($dependencia);
        $tdocumental =  $this->tipoDocto;
        //Inicializa el pdf
        $this->pdf = new Cezpdf("LEGAL","landscape");
        $objHist   = new Historico($this->conexion);
        $year      = date("Y");
        $day       = date("d");
        $month     = date("m");
        // orientacion izquierda
        $orientCentro = array("left"=>0);
        // justificacion centrada
        $justCentro = array("justification"=>"center");
        $estilo1 = array("justification"=>"left","leading"=>8);
        $estilo2 = array("left"=>0,"leading"=>12);
        $estilo3 = array("left"=>0,"leading"=>15);
        $this->pdf->ezSetCmMargins(1,1,3,2);//top,botton,left,right
        /* Se establece la fuente que se utilizara para el texto. */

        $this->pdf->selectFont($this->ruta_raiz."/include/pdf/fonts/Times-Roman.afm");
        $this->pdf->ezText("LISTADO DE RADICACION MASIVA\n",15,$justCentro);
        $this->pdf->ezText("Dependencia: $dependencia \n" ,12,$estilo2);
        $this->pdf->ezText("Usuario Responsable: $usua_nomb \n" ,12,$estilo2);
        $this->pdf->ezText("Fecha: $day-$month-$day \n" ,12,$estilo2);
        $this->pdf->ezText($txtformat,12,$estilo2);

        $data     = array();
        $columna  = array();
        $contador = 0;
        require_once $this->ruta_raiz."/class_control/class_controlExcel.php";
        $this->btt = new CONTROL_ORFEO($this->conexion);
        $this->rad = new Radicacion($this->conexion);

        echo "<table border=0 width 80% cellpadding='0' cellspacing='5' class='borde_tab' >";
        echo "<tr>
            <td class='titulos4'>Registro</td>
            <td class='titulos4'>Radicado</td>
            <td class='titulos4'>Nombre</td>
            <td class='titulos4'>Direccion</td>
            <td class='titulos4'>Depto</td>
            <td class='titulos4'>Municipio</td>
            <td class='titulos4'>Expediente</td>
            </tr>";

        //Referencia el archivo a abrir
        $ruta = $this->ruta_raiz."/".$this->carpetaBodega."masiva/".$this->arcCSV;
        clearstatcache();
        $fp=fopen($ruta,'r');  //wb 2 r

        if ($fp){
            //Recorre el arrego de los datos
            for($ii=0; $ii < count ($this->datos) ; $ii++){   
                $i=0;
                $numeroExpediente = "";
                // Aqui se accede a la clase class_control para actualizar expedientes.
                $ruta_raiz = $this->ruta_raiz;

                // Por cada etiqueta de los campos del encabezado del CSV efecta un reemplazo
                foreach($this->encabezado as $campos_d){
                    if (strlen(trim($this->datos[$ii][$i]))<1 )
                        $this->datos[$ii][$i]="<ESPACIO>";

                    //Agregamos los radicados de manera automatica
                    //El usuario envia el csv con los demas datos y 
                    //se realiza la radicacion asignando los nuevos radicados
                    $dato_r = trim($this->datos[$ii][$i]);
                    $dato_r = mb_strtoupper(trim($dato_r),'UTF-8');
                    $dato_r = str_replace(array("\r\n", "\n", "\r", "\t"),'',$dato_r);

                    if($campos_d=="*TIPO*") $tip_doc                    = $dato_r;
                    if($campos_d=="*NOMBRE*") $nombre                   = $dato_r;
                    if($campos_d=="*DOCUMENTO*") $doc_us1               = $dato_r;
                    if($campos_d=="*NOMBRE*") $nombre_us1               = $dato_r;
                    if($campos_d=="*PRIM_APEL*") $prim_apell_us1        = $dato_r;
                    if($campos_d=="*SEG_APEL*") $seg_apell_us1          = $dato_r;
                    if($campos_d=="*DIGNATARIO*") $otro_us1             = $dato_r;
                    if($campos_d=="*CARGO*") $cargo_us1                 = $dato_r;
                    if($campos_d=="*DIR*") $direccion_us1               = $dato_r;
                    if($campos_d=="*TELEFONO*") $telefono_us1           = $dato_r;
                    if($campos_d=="*MUNI*") $muni_codi                  = $dato_r;
                    if($campos_d=="*DEPTO*") $dpto_codi                 = $dato_r;
                    if($campos_d=="*ASUNTO*") $asu                      = $dato_r;
                    if($campos_d=="*ID*") $sgd_esp_codigo               = $dato_r;
                    if($campos_d=="*DESC_ANEXOS*") $desc_anexos         = $dato_r;
                    if($campos_d=="*MUNI_NOMBRE*") $muni_nombre         = $dato_r;
                    if($campos_d=="*DEPTO_NOMBRE*") $dpto_nombre        = $dato_r;
                    if($campos_d=="*PAIS_NOMBRE*") $pais                = $dato_r;
                    if($campos_d=="*TIPO_DOC*") $tdoc                   = $dato_r;
                    if($campos_d=="*NUM_EXPEDIENTE*") $numeroExpediente = $dato_r;


                    //Duplican campos para masiva con copia
                    if($campos_d=="*TIPO2*") $tip_doc2                    = $dato_r;
                    if($campos_d=="*NOMBRE2*") $nombre2                   = $dato_r;
                    if($campos_d=="*DOCUMENTO2*") $doc_us12               = $dato_r;
                    if($campos_d=="*NOMBRE2*") $nombre_us12               = $dato_r;
                    if($campos_d=="*PRIM_APEL2*") $prim_apell_us12        = $dato_r;
                    if($campos_d=="*SEG_APEL2*") $seg_apell_us12          = $dato_r;
                    if($campos_d=="*DIGNATARIO2*") $otro_us12             = $dato_r;
                    if($campos_d=="*CARGO2*") $cargo_us12                 = $dato_r;
                    if($campos_d=="*DIR2*") $direccion_us12               = $dato_r;
                    if($campos_d=="*TELEFONO2*") $telefono_us12           = $dato_r;
                    if($campos_d=="*MUNI2*") $muni_codi2                  = $dato_r;
                    if($campos_d=="*DEPTO2*") $dpto_codi2                 = $dato_r;
                    if($campos_d=="*ASUNTO2*") $asu2                      = $dato_r;
                    if($campos_d=="*ID2*") $sgd_esp_codigo2               = $dato_r;
                    if($campos_d=="*DESC_ANEXOS2*") $desc_anexos2         = $dato_r;
                    if($campos_d=="*MUNI_NOMBRE2*") $muni_nombre2         = $dato_r;
                    if($campos_d=="*DEPTO_NOMBRE2*") $dpto_nombre2        = $dato_r;
                    if($campos_d=="*PAIS_NOMBRE2*") $pais2                = $dato_r;
                    if($campos_d=="*TIPO_DOC2*") $tdoc2                   = $dato_r;
                    if($campos_d=="*NUM_EXPEDIENTE2*") $numeroExpediente2 = $dato_r;

                    if(!empty($tip_doc2) && !empty($muni_nombre2)){
                        $dir2 = True; 
                    }

                    $tipo_anexo    = "0";
                    $cuentai       = "";
                    $documento_us3 = "";
                    $med           = "1";
                    $fec           = NULL;

                    if($campos_d=="*ESP_CODIGO*") {
                        $codigoESP = $dato_r;
                        if ($codigoESP =="<ESPACIO>" )
                        {
                            $codigoESP = null;
                        }
                    }
                    if($campos_d=="*RAD_ANEXO*")
                    {	$radicadopadre =$dato_r;
                    $tipoanexo = 0;
                    if ($radicadopadre =="<ESPACIO>" )
                    {	$radicadopadre = "";
                    $tipoanexo = "";
                    }
                    }
                    else
                    {	$radicadopadre="";	}


                    $ane="";
                    $carp_codi="12";
                    $i++;
                }

                $tip_rem="1";

                // Si no se especifico el tipo de documento
                IF(!$tdoc) $tdoc=0;
                $this->validarLugar();

                // Si no se especifico el tipo de documento
                IF(!$tdoc2) $tdoc2=0;

                if($dir2){
                    $this->validarLugar2();
                }
                $pais_codi  = $this->arrCodPais[$pais.$dpto_nombre.$muni_nombre];

                if($dir2){
                    $pais_codi2 = $this->arrCodPais[$pais2.$dpto_nombre2.$muni_nombre2];
                }

                if($pais_codi==''){
                    $pais_codi = '170';
                }

                if($dir2){
                    if($pais_codi2==''){
                        $pais_codi2 = '170';
                    }
                }

                $dpto_codi    = $pais_codi."-".$this->arrCodDepto[$dpto_nombre];
                $muni_codi    = $dpto_codi."-".$this->arrCodMuni[$dpto_nombre.$muni_nombre];

                if($dir2){
                    $dpto_codi2   = $pais_codi2."-".$this->arrCodDepto2[$dpto_nombre2];
                    $muni_codi2   = $dpto_codi2."-".$this->arrCodMuni2[$dpto_nombre2.$muni_nombre2];
                }

                $tmp_objMuni  = new Municipio($this->conexion);//Creamos esto para traer el codigo del continente y transmitirlo
                $tmp_objMuni->municipio_codigo($dpto_codi,$muni_codi);//por las diferentes tablas.
                $cont_codi    = $tmp_objMuni->get_cont_codi();
                $muni_codi    = $cont_codi."-".$muni_codi;
                if($dir2){
                    $tmp_objMuni2 = new Municipio($this->conexion);	//Creamos esto para traer el codigo del continente y transmitirlo
                    $tmp_objMuni2->municipio_codigo($dpto_codi2,$muni_codi2);//por las diferentes tablas.
                    $cont_codi2   = $tmp_objMuni2->get_cont_codi();
                    $muni_codi2   = $cont_codi2."-".$muni_codi2;
                }

                //Se agregan las dos variables siguientes, para corregir 
                //el error que se estaba presentando en la radicación masiva
                $codigo_depto =  $this->arrCodDepto[$dpto_nombre];
                $codigo_muni = $this->arrCodMuni[$dpto_nombre.$muni_nombre];
                //Fin Variables agregadas

                //Se agregan las dos variables siguientes, para corregir 
                //el error que se estaba presentando en la radicación masiva
                if($dir2){
                    $codigo_depto2 = $this->arrCodDepto2[$dpto_nombre2];
                    $codigo_muni2  = $this->arrCodMuni2[$dpto_nombre2.$muni_nombre2];
                }
                //Fin Variables agregadas

                $muni_us1  = $muni_codi;
                $codep_us1 = $dpto_codi;

                $nombre_us = "$nombre_us1 $prim_apell_us1 $seg_apell_us1";

                if($dir2){
                    $muni_us12  = $muni_codi2;
                    $codep_us12 = $dpto_codi2;
                    $nombre_us2 = "$nombre_us12 $prim_apell_us12 $seg_apell_us12";
                }

                unset($tmp_objMuni);
                $documento_us3 = $codigoESP;
                if(!$documento_us3)
                    $documento_us3 = null;

                $rad                                = new Radicacion($this->conexion);
                $rad->radiTipoDeri                  = $tipoanexo;
                $rad->radiCuentai                   = "'$cuentai'";
                $rad->eespCodi                      = $documento_us3;
                $rad->mrecCodi                      = $med;
                $rad->radiFechOfic                  = $fec;
                $rad->radiNumeDeri                  = null;
                $rad->radiPais                      = "$pais";
                $rad->descAnex                      = $ane; 
                $rad->raAsun                        = substr(htmlspecialchars(stripcslashes($asu)),0,349); 
                $rad->radiDepeRadi                  = $dependencia;
                $rad->radiDepeActu                  = $dependencia;
                $rad->radiUsuaActu                  = $codusuario;
                $rad->trteCodi                      = 0;
                if(!$tdocumental) $tdocumental=0;  
                $rad->tdocCodi                      = $tdocumental;     
                if(!$tip_doc) $tip_doc=0;          
                $rad->tdidCodi                      = $tip_doc;
                $rad->nofolios                      = 1;
                $rad->noanexos                      = 0;
                $rad->carpCodi                      = 5;
                $rad->carpPer                       = 1;
                $rad->trteCodi                      = 0;
                $rad->ra_asun                       = $asu;
                $rad->sgd_apli_codi                 = 0;
                $rad->radiPath = ''; 
                $codTx = 2;
                $flag  = 1;

                $tpDepeRad   = $_SESSION["tpDepeRad"];

                $nurad = $rad->newRadicado($tipoRad, $tpDepeRad[$tipoRad]);

                $this->radarray[] = $nurad;

                if(strlen($numeroExpediente)>=10){
                    $this->objExp = new Expediente($this->conexion);
                    $resultadoExp = $this->objExp->insertar_expediente($numeroExpediente, 
                        $nurad , 
                        $dependencia, 
                        $codusuario, 
                        $usua_doc);


                    $observa = "Por Rad. Masiva.";
                    if($this->codProceso){
                        $radicados[] = $nurad;
                        $tipoTx = 50;
                        $objFlujo = new Flujo($this->conexion,$this->codProceso,$usua_doc);
                        $expEstadoActual = $objFlujo->actualNodoExpediente($numeroExpediente);
                        $objFlujo->cambioNodoExpediente($numeroExpediente,
                            $nurad,
                            $this->codFlujo,
                            $this->codArista,
                            1,
                            $observa,
                            $this->codProceso);
                    }
                }

                $nombre_us1    = trim($nombre_us1);
                $direccion_us1 = trim($direccion_us1);

                $nombre_us12    = trim($nombre_us12);
                $direccion_us12 = trim($direccion_us12);
                if($tip_doc==2){	
                    $codigo_us = $this->btt->grabar_usuario($doc_us1,
                        $nombre_us1,
                        $direccion_us1,
                        $prim_apell_us1,
                        $seg_apell_us1,
                        $telefono_us1,
                        $mail_us1,
                        $codigo_depto,
                        $codigo_muni);
                    $tipo_emp_us1  = 0;
                    $documento_us1 = $codigo_us;
                }
                //copia
                if($tip_doc2==2){	
                    $codigo_us2 = $this->btt->grabar_usuario($doc_us12,
                        $nombre_us12,
                        $direccion_us12,
                        $prim_apell_us12,
                        $seg_apell_us12,
                        $telefono_us12,
                        $mail_us12,
                        $codigo_depto2,
                        $codigo_muni2);
                    $tipo_emp_us12  = 0;
                    $documento_us12 = $codigo_us2;
                }

                if($tip_doc==1){	
                    $codigo_oem=$this->arregloOem[$nombre_us1];  //Agregada 24 Noviembre por Lucia Ojeda
                    if(!$codigo_oem > 0) 						 //Agregada 24 Noviembre por Lucia Ojeda
                        $codigo_oem = $this->btt->grabar_oem($doc_us1,
                            $nombre_us1,
                            $direccion_us1,
                            $prim_apell_us1,
                            $seg_apell_us1,
                            $telefono_us1,
                            $mail_us1,
                            $codigo_depto,
                            $codigo_muni);
                    $tipo_emp_us1  = 2;
                    $documento_us1 = $codigo_oem;
                }

                //copia
                if($tip_doc2==1){	
                    $codigo_oem2=$this->arregloOem[$nombre_us12]; 
                    if(!$codigo_oem2 > 0) 						 
                        $codigo_oem2 = $this->btt->grabar_oem($doc_us12,
                            $nombre_us12,
                            $direccion_us12,
                            $prim_apell_us12,
                            $seg_apell_us12,
                            $telefono_us12,
                            $mail_us12,
                            $codigo_depto2,
                            $codigo_muni2);
                    $tipo_emp_us12  = 2;
                    $documento_us12 = $codigo_oem2;
                }

                if($tip_doc==0){
                    $sgd_esp_codigo = $this->arregloEsp[$nombre_us1];
                    $tipo_emp_us1   = 1;
                    $documento_us1  = $sgd_esp_codigo;
                }

                //copia
                if($tip_doc2==0){
                    $sgd_esp_codigo2 = $this->arregloEsp[$nombre_us12];
                    $tipo_emp_us12   = 1;
                    $documento_us12  = $sgd_esp_codigo2;
                }

                $documento_us2 = "";
                $documento_us3 = "";

                $cc_documento_us1="documento";
                $grbNombresUs1 = trim($nombre_us1) . " " . trim($prim_apel_us1) . " ". trim($seg_apel_us1);

                //copia
                $documento_us22 = "";
                $documento_us32 = "";

                $cc_documento_us12="documento";
                $grbNombresUs12 = trim($nombre_us12) . " " . trim($prim_apel_us12) . " ". trim($seg_apel_us12);

                $conexion = & $this->conexion;
                include "$ruta_raiz/radicacion/grb_direcciones.php";

                // En esta parte registra el envio en la tabla SGD_RENV_REGENVIO
                if (!$this->codigo_envio){	
                    $isql = "select max(SGD_RENV_CODIGO) as MAX FROM SGD_RENV_REGENVIO";
                    $rs=$this->conexion->query($isql);

                    if  (!$rs->EOF)
                        $nextval=$rs->fields['MAX'];
                    $nextval++;
                    $this->codigo_envio = $nextval;

                    if(empty($this->radi_nume_grupo)){
                        $this->radi_nume_grupo = $nurad;
                    }

                    $radi_nume_grupo = $this->radi_nume_grupo;
                }else{
                    $nextval = $this->codigo_envio;	
                }

                $dep_radicado  = substr($verrad_sal,4,3);
                $carp_codi     = substr($dep_radicado,0,2);
                $dir_tipo      = 1;
                $nombre_us     = mb_substr(trim($nombre_us),0,100, 'UTF-8');
                $direccion_us1 = mb_substr(trim($direccion_us1),0,200, 'UTF-8');

                $isql = "INSERT INTO SGD_RENV_REGENVIO (
                    USUA_DOC, 
                    SGD_RENV_CODIGO, 
                    SGD_FENV_CODIGO, 
                    SGD_RENV_FECH,
                    RADI_NUME_SAL, 
                    SGD_RENV_DESTINO, 
                    SGD_RENV_TELEFONO, 
                    SGD_RENV_MAIL, 
                    SGD_RENV_PESO, 
                    SGD_RENV_VALOR,
                    SGD_RENV_CERTIFICADO, 
                    SGD_RENV_ESTADO, 
                    SGD_RENV_NOMBRE, 
                    SGD_DIR_CODIGO, 
                    DEPE_CODI, 
                    SGD_DIR_TIPO,
                    RADI_NUME_GRUPO, 
                    SGD_RENV_PLANILLA, 
                    SGD_RENV_DIR, 
                    SGD_RENV_PAIS, 
                    SGD_RENV_DEPTO, 
                    SGD_RENV_MPIO,
                    SGD_RENV_TIPO, 
                    SGD_RENV_OBSERVA,
                    SGD_DEPE_GENERA)
                    VALUES
                    ($usua_doc, 
                    $nextval, 
                    0, 
                    ".$this->btt->sqlFechaHoy.", 
                    $nurad, 
                    '$muni_nomb', 
                    '$telefono_us1', 
                    '$mail','',
                    '$valor_unit', 
                    0, 
                    1, 
                    '$nombre_us', 
                    NULL, 
                    $dependencia, 
                    '$dir_tipo', 
                    ".$this->radi_nume_grupo.", 
                    '00',
                    '$direccion_us1', 
                    '$pais',
                    '$dpto_nombre', 
                    '$muni_nombre', 
                    1, 
                    'Masiva grupo ".$this->radi_nume_grupo."',
                    $dependencia) ";

                $rs=$this->conexion->query($isql);

                if (!$rs){	
                    $this->conexion->conn->RollbackTrans();
                    die ("<span class='etextomenu'>No se ha 
                        podido insertar la informacion en SGD_RENV_REGENVIO:1");
                }


                // En esta parte registra el envio en la tabla SGD_RENV_REGENVIO para 
                // la direccion 2
                if($dir2){
                    $isql = "SELECT MAX(SGD_RENV_CODIGO) AS MAX FROM SGD_RENV_REGENVIO";
                    $rs=$this->conexion->query($isql);

                    if  (!$rs->EOF)
                        $nextval=$rs->fields['MAX'];
                    $nextval++;
                    $this->codigo_envio = $nextval;

                    $dep_radicado  = substr($verrad_sal,4,3);
                    $carp_codi     = substr($dep_radicado,0,2);
                    $dir_tipo      = 1;
                    $nombre_us     = substr(trim($nombre_us2),0,29);
                    $direccion_us12 = substr(trim($direccion_us12),0,29);

                    $isql = "INSERT INTO SGD_RENV_REGENVIO (
                        USUA_DOC, 
                        SGD_RENV_CODIGO, 
                        SGD_FENV_CODIGO, 
                        SGD_RENV_FECH,
                        RADI_NUME_SAL, 
                        SGD_RENV_DESTINO, 
                        SGD_RENV_TELEFONO, 
                        SGD_RENV_MAIL, 
                        SGD_RENV_PESO, 
                        SGD_RENV_VALOR,
                        SGD_RENV_CERTIFICADO, 
                        SGD_RENV_ESTADO, 
                        SGD_RENV_NOMBRE, 
                        SGD_DIR_CODIGO, 
                        DEPE_CODI, 
                        SGD_DIR_TIPO,
                        RADI_NUME_GRUPO, 
                        SGD_RENV_PLANILLA, 
                        SGD_RENV_DIR, 
                        SGD_RENV_PAIS, 
                        SGD_RENV_DEPTO, 
                        SGD_RENV_MPIO,
                        SGD_RENV_TIPO, 
                        SGD_RENV_OBSERVA,
                        SGD_DEPE_GENERA)
                        VALUES
                        ($usua_doc, 
                        $nextval, 
                        0, 
                        ".$this->btt->sqlFechaHoy.", 
                        $nurad, 
                        '$muni_nomb', 
                        '$telefono_us1', 
                        '$mail',
                        '',
                        '$valor_unit', 
                        0, 
                        1, 
                        '$nombre_us', 
                        NULL, 
                        $dependencia, 
                        '$dir_tipo', 
                        ".$this->radi_nume_grupo.", 
                        '00',
                        '$direccion_us1', 
                        '$pais',
                        '$dpto_nombre', 
                        '$muni_nombre', 
                        1, 
                        'Masiva grupo ".$this->radi_nume_grupo."',
                        $dependencia) ";

                    $rs=$this->conexion->query($isql);

                    if (!$rs){	
                        $this->conexion->conn->RollbackTrans();
                        die ("<span class='etextomenu'>No se ha podido isertar la informacion en SGD_RENV_REGENVIO :2");
                    }
                }

                /*
                 * Registro de la clasificacion TRD
                 */
                $isql = "INSERT INTO SGD_RDF_RETDOCF(
                    USUA_DOC, 
                    SGD_MRD_CODIGO, 
                    SGD_RDF_FECH, 
                    RADI_NUME_RADI, 
                    DEPE_CODI, 
                    USUA_CODI)
                    VALUES($usua_doc, 
                    $codiTRD,
                    ".$this->btt->sqlFechaHoy.", 
                    $nurad, 
                    '$dependencia', 
                    $codusuario )";

                $rs=$this->conexion->query($isql);

                if(!$rs){
                    $this->conexion->conn->RollbackTrans();
                    die ("<span class='etextomenu'>No se ha podido isertar la informaci&ocute;n en SGD_RENV_REGENVIO");
                }

                $contador = $ii + 1;

                echo "
                    <tr>
                    <td class='listado2'> $contador </td>
                    <td class='listado2'> $nurad </td>
                    <td class='listado2'> $nombre_us </td>
                    <td class='listado2'> $direccion_us1 </td>
                    <td class='listado2'> $dpto_nombre</td>
                    <td class='listado2'> $muni_nombre</td>
                    <td class='listado2'> $numeroExpediente </td>
                    </tr>";

                if($dir2){
                    echo "
                        <tr>
                        <td class='listado2'>$contador cc</td>
                        <td class='listado2'></td>
                        <td class='listado2'>$nombre_us2</td>
                        <td class='listado2'>$direccion_us12</td>
                        <td class='listado2'>$dpto_nombre2</td>
                        <td class='listado2'>$muni_nombre2</td>
                        <td class='listado2'>$numeroExpediente2</td>
                        </tr>";
                }

                if( connection_status()!=0 ){
                    echo "<h1>Error de conexión</h1>";
                    $objError = new CombinaError (NO_DEFINIDO);
                    echo ($objError->getMessage());
                    die;		
                }


                $nombre_us      = $this->presentacion($nombre_us);
                $direccion_us1  = $this->presentacion($direccion_us1);
                $dpto_nombre    = $this->presentacion($dpto_nombre);
                $muni_nombre    = $this->presentacion($muni_nombre);

                $nombre_us2     = $this->presentacion($nombre_us2);
                $direccion_us12 = $this->presentacion($direccion_us12);
                $dpto_nombre2   = $this->presentacion($dpto_nombre2);
                $muni_nombre2   = $this->presentacion($muni_nombre2);

                $data =  array_merge ($data,array (array('#'=>$contador,
                    'Radicado'=>$nurad,
                    'Nombre'=>$nombre_us,
                    'Direccion'=>$direccion_us1,
                    'Departamento'=> $dpto_nombre,
                    'Municipio'=>$muni_nombre)
                )
            );

                if($dir2){
                    $contador++;
                    $data =  array_merge ($data,array (array('#'=>$contador,
                        'Radicado'=>$nurad,
                        'Nombre'=>$nombre_us2,
                        'Direccion'=>$direccion_us12,
                        'Departamento'=>$dpto_nombre2,
                        'Municipio'=>$muni_nombre2)
                    )
                );
                }

                $arrRadicados[]=$nurad;

            }
            $queryUpdate = "update SGD_MASIVA_EXCEL set SGD_MASIVA_RADICADA = 1 where '$nurad' in ( SGD_MASIVA_RANGOINI , SGD_MASIVA_RANGOFIN ) AND SGD_MASIVA_DEPENDENCIA = $dependencia";

            $rs=$this->conexion->query( $queryUpdate );
            if (!$rs)
            {	$this->conexion->conn->RollbackTrans();
            die ("<span class='etextomenu'>No se ha podido insertar la informaci&oacute;n de la secuencia '$nurad' con: $queryUpdate");
            }

            fclose($fp);
            echo "</table>";
            echo "<span class='info'>Numero de registros $contador</span>";
            $this->pdf->ezTable($data);
            $this->pdf->ezText("\n",15,$justCentro);
            $this->pdf->ezText("Total Registros $contador \n",15,$justCentro);
            $pdfcode = $this->pdf->ezOutput();
            $fp=fopen($this->arcPDF,'wb');
            fwrite($fp,$pdfcode);
            fclose($fp);

            $objHist->insertarHistorico($arrRadicados,
                $dependencia,
                $codusuario,
                $dependencia,
                $codusuario,
                "Radicado insertado del grupo de masiva $radi_nume_grupo",
                30);

            $this->resulComb = $data;
            $fileExito = "$ruta_raiz/".$this->carpetaBodega."masiva/$archInsumo.ok";
            $fp=fopen($fileExito,'wb');
            fwrite($fp,"Exito");
            fclose($fp);

        }
        else exit("No se pudo crear el archivo $this->archivo_insumo");
    }



    function cargar_csv(){

        $fc = file_get_contents($this->ruta_raiz . "/".$this->carpetaBodega."masiva/" . $this->arcCSV);
        $encodi   = $this->codificacion($fc);

        if ($fc)
        {
            if($encodi == 3)
            {
                $fc = iconv('iso-8859-1','utf-8',$fc);
            }


            $lines = split("\n", $fc);
            array_pop($lines);
            $contenidoCSV = $lines;

            $line         =  $contenidoCSV[0];
            $comaPos      = stripos($line , ",");
            $puntocomaPos = stripos($line , ";");
            if($comaPos){
                $separador = ",";
            }elseif ($puntocomaPos) {
                $separador = ";";
            }else{
                die("Separador en archivo CSV inv&aacute;lido.");
            }

            $this->alltext_csv = "";
            $this->encabezado  = array();
            $this->datos       = array();
            $j                 = 1;
            isset($numEncabe);
            isset($numEndato);

            $this->encabezado = str_getcsv(array_shift($lines),$separador);

            $numEncabe = count($this->encabezado);

            foreach ($lines as $line){
                $j++;
                $this->datos[] = str_getcsv($line,$separador);
                $numEndato   = count(str_getcsv($line,$separador));

                if($numEncabe != $numEndato){
                    $this->errorLugar[] = "Linea ".$j." existe una error con una coma(,) ó un enter, eliminela.";
                }
            }
        }else{
            echo "<BR> No hay un archivo csv llamado *". $this->ruta_raiz . "/".$this->carpetaBodega."masiva/" . $this->arcCSV."*";
        }
    }	


    /**
     * Gestiona la validacion de las archivos que intervienen en el 
     * proceso antes de invocar esta funcion debe haberse invocado 	cargar_csv() y abrir();
     */

    function validarArchs() {	
        $this->cargarObligCsv();
        //Recorre los campos abligatorios buscando que cada uno de ellos se encuentre en el emcabezado del archivo CSV

        for($i=0; $i < count ($this->camObligCsv) ; $i++)
        {  	
            $sw=0;
            foreach($this->encabezado[0] as $campoEnc){
                if ("*".$this->camObligCsv[$i]."*" == $campoEnc){
                    $sw=1;
                }
            }
            if ($sw==0){
                $this->errorEncab[]=$this->camObligCsv[$i];
            }
        }
        $this->validarTipo();
        $this->validarRegistrosObligsCsv();
        $this->validarLugar();
        $this->validarEsp();
        $this->validarDireccion();
        $this->validarNombre();
        $this->validarSiAnexo();
    }


    /**
     * Carga los campos obligatorios del tipo de archivo enviado como par�metro y lo hace en el arreglo referenciado en el arreglo definido como par�metro
     * @param $tipo     	es el tipo de archivo de masiva
     * @param $arreglo   es el arreglo donde han de quedar los capos abligatorios
     */
    function cargarCampos($tipo,$arreglo){	
        $q  = "select * from sgd_cob_campobliga where sgd_tidm_codi = $tipo";
        $rs = $this->conexion->query($q);

        while  (!$rs->EOF){	
            $arreglo[]=$rs->fields['SGD_COB_LABEL'];
            $rs->MoveNext();
        }	
    }


    /**
     * Carga los campos obligatorios del tipo de archivo 2 o CSV
     */
    function cargarObligCsv()
    {	$this->cargarCampos(2,$this->camObligCsv);	}


    /**
     * Carga los campos obligatorios del tipo de archivo 1 o Plantilla
     */
    function cargarOblPlant()
    {	$this->cargarCampos(1,$this->camObligPlant);	}


    /**
     * Pregunta si existe alg�ntipo de error, que puede ser de emcabezado, pantilla, lugar, ESP,de completitud del CSV, o del tipo de registro, antes de llamar esta funci�n se debi� validar mediante  validarArchs(). En caso de error retorna true, de lo contrario falso.
     * @return	boolean
     */
    function hayError(){
        if (count($this->errorEncab)>0||count($this->errorPlant)>0||count($this->errorLugar)>0||count($this->errorESP)>0||
            count($this->errorComplCsv)>0|| count($this->errorTipo)>0 || count($this->errorDir)>0 || count($this->errorNomb)>0 ||
            count($this->errorRadAnexo)>0 )
            return true;
        else
            return false;
    }


    /**
     * Busca si los campos obligatorios est�n completos en todos los registros del archivo CSV
     * Si existe alg�n error lo registra en el arreglo errorComplCsv
     */
    function validarRegistrosObligsCsv(){	//Recorre todos los registros del CSV
        for($i=0; $i < count ($this->datos) ; $i++)
        {	//Recorre todos campos obligatorios del CSV y los busca en cada registro
            for($j=0; $j < count ($this->camObligCsv) ; $j++){	
                $col= $this->getNumColEnc($this->camObligCsv[$j]);
                $dato = $this->datos[$i][$col];
                //Si no halla algun campo obligatorio lo pone en el arreglo de errores
                if (strlen($dato)==0){	
                    $this->errorComplCsv[]="REG ".($i+1).": " .$this->camObligCsv[$j];
                }	
            }	
        }	
    }

    /**
     * Busca si se ha de generar radicados como anexos, validando que el radicado 
     * relacionado exista. Para esto debe existir una columna en el archivo csv llamada *RAD_ANEXO*
     * Si existe alg�n error lo registra en el arreglo errorRadAnexo
     */

    function validarSiAnexo(){	
        $colRadAnexo= $this->getNumColEnc("RAD_ANEXO");
        if ($colRadAnexo!=-1){	
            $objRadicado = new Radicado($this->conexion);
            //Recorre todos los registros del CSV
            for($i=0; $i < count ($this->datos) ; $i++){	
                $dato = $this->datos[$i][$colRadAnexo];
                //Si la columna que contiene el campo RAD_ANEXO se refiere a un radicado que no existe
                if ( strlen (trim($dato)) > 0 && !$objRadicado->radicado_codigo($dato))
                {
                    $this->errorRadAnexo[]="REG ".($i+1).": $dato";
                }	
            }	
        }	
    }


    /**
     * Busca si el campo obligatorio TIPO existe correctamente  en todos los registros del archivo CSV
     * Si existe algun error lo registra en el arreglo errorTipo
     */
    function validarTipo(){	
        $colTipo= $this->getNumColEnc("TIPO");
        //Recorre todos los registros del CSV
        for($i=0; $i < count ($this->datos) ; $i++){	
            $dato = $this->datos[$i][$colTipo];
            //Si la columna que contiene el campo TIPO no es correcta la referencia en en arreglo errorTipo
            if ($dato!="0"&&$dato!="1"&&$dato!="2" ){	
                $this->errorTipo[]="REG ".($i+1).": ";
            }	
        }	
    }


    /**
     * Busca si los lugares referenciados en el archivo CSV son vaildos. Si existe alg�n error lo registra en el arreglo errorLugar
     */
    function validarLugar(){	
        $colDepto= $this->getNumColEnc("DEPTO_NOMBRE");
        $colMuni = $this->getNumColEnc("MUNI_NOMBRE");
        $colPais = $this->getNumColEnc("PAIS_NOMBRE");
        //Recorre todos los registros del CSV
        for($i=0; $i < count ($this->datos) ; $i++)
        {	
            $codifica  = "UTF-8";
            $dato_pais = mb_strtoupper(trim($this->datos[$i][$colPais]),$codifica);
            $dato_muni = mb_strtoupper(trim($this->datos[$i][$colMuni]),$codifica);
            $dato      = mb_strtoupper(trim($this->datos[$i][$colDepto]),$codifica);

            if(empty($dato_pais)){
                $dato_pais = 'COLOMBIA';
            }

            $q3 = "select * from SGD_DEF_PAISES where NOMBRE_PAIS='$dato_pais'";
            $rs = $this->conexion->query($q3);

            if($rs)
            {	
                $codigoPais= empty($rs->fields['ID_PAIS'])? 170 : $rs->fields['ID_PAIS'];	
                $codigoCont=$rs->fields['ID_CONT']; 
                $q= "select * from departamento where dpto_nomb='$dato' and ID_PAIS=$codigoPais";
                $rs = $this->conexion->query($q);
                //Valida si el departamento es valido
                if  (!$rs->EOF)
                {	
                    $codigoDepto=$rs->fields['DPTO_CODI'];	
                    $q2= "select * from municipio where muni_nomb='$dato_muni' and dpto_codi=$codigoDepto and ID_PAIS=$codigoPais";
                    $rs=$this->conexion->query($q2);

                    //Valida si el municipio es valido
                    if  ($rs->EOF)
                        $this->errorLugar[]="REG ".($i+2).": $dato_muni ";
                    else
                    {	
                        $codigoMuni=$rs->fields['MUNI_CODI'];	
                        $this->arrCodDepto[$dato]=$codigoDepto;
                        $this->arrCodMuni[$dato.$dato_muni]=$codigoMuni;
                        $this->arrCodPais[$dato_pais.$dato.$dato_muni]=$codigoPais;
                        $this->arrCodCont[$codigoCont.$dato_pais.$dato.$dato_muni]=$codigoCont;
                    }
                }
                else
                {	
                    $this->errorLugar[]="REG ".($i+2).": $dato ";
                }
            }
            else
            {	$this->errorLugar[]="REG ".($i+2).": $dato_pais ";
            }
        }
    }

    function validarLugar2(){	
        $colDepto= $this->getNumColEnc("DEPTO_NOMBRE2");
        $colMuni= $this->getNumColEnc("MUNI_NOMBRE2");
        $colPais=$this->getNumColEnc("PAIS_NOMBRE2");
        //Recorre todos los registros del CSV
        for($i=0; $i < count ($this->datos) ; $i++){	

            $dato_pais = mb_strtoupper(trim($this->datos[$i][$colPais]),'UTF-8');
            $dato_muni = mb_strtoupper(trim($this->datos[$i][$colMuni]),'UTF-8');
            $dato      = mb_strtoupper(trim($this->datos[$i][$colDepto]),'UTF-8');

            if(empty($dato_pais)){
                $dato_pais = 'COLOMBIA';
            }

            $q3= "select * from SGD_DEF_PAISES where NOMBRE_PAIS='$dato_pais'";
            $rs=$this->conexion->query($q3);

            if ($rs){
                $codigoPais=$rs->fields['ID_PAIS'];	
                $codigoCont=$rs->fields['ID_CONT']; 
                $q= "select * from departamento where dpto_nomb='$dato' and ID_PAIS=$codigoPais";
                $rs=$this->conexion->query($q);
                //Valida si el departamento es volido
                if  (!$rs->EOF)
                {	$codigoDepto=$rs->fields['DPTO_CODI'];	

                $q2= "select * from municipio where muni_nomb='".$dato_muni."' and dpto_codi=$codigoDepto and ID_PAIS=$codigoPais";
                $rs=$this->conexion->query($q2);

                //Valida si el municipio es valido
                if  ($rs->EOF)
                    $this->errorLugar[]="REG ".($i+1).": $dato_muni ";
                else
                {	$codigoMuni=$rs->fields['MUNI_CODI'];	
                $this->arrCodDepto2[$dato]=$codigoDepto;
                $this->arrCodMuni2[$dato.$dato_muni]=$codigoMuni;
                $this->arrCodPais2[$dato_pais.$dato.$dato_muni]=$codigoPais;
                $this->arrCodCont2[$codigoCont.$dato_pais.$dato.$dato_muni]=$codigoCont;
                }
                }
                else{	$this->errorLugar[]="REG ".($i+1).": $dato ";
                }
            }
            else{	$this->errorLugar[]="REG ".($i+1).": $dato_pais ";
            }
        }
    }


    /**
     * Busca si las ESP referenciadas en el archivo CSV son v�ildas. Si existe alg�n error lo registra en el arreglo errorESP
     */
    function validarEsp(){	
        $colESP= $this->getNumColEnc("NOMBRE");
        $colTipo= $this->getNumColEnc("TIPO");
        $esp = new Esp($this->conexion);

        //Recorre todos los registros del CSV
        for($i=0; $i < count ($this->datos) ; $i++){	
            if ($this->datos[$i][$colTipo]==0)
            {	$dato = $this->datos[$i][$colESP];
            //$dato_muni = $this->datos[$i][$colMuni];

            //Valida si la ESP v�lida
            if ($esp->Esp_nombre($dato))
            {	$this->arregloEsp[$dato]=$esp->getId();	}
            else
            {	$this->errorESP[]="REG ".($i+1).": $dato ";
            }	
            }	
        }	
    }


    /**
     * Valida que el campo de Nombre, 1er y 2o Apellido existan. Si existe alg�n error lo registra en el arreglo errorDireccion
     */

    function validarNombre(){
        $colNomb= $this->getNumColEnc("NOMBRE");
        $colPrimApe= $this->getNumColEnc("PRIM_APEL");
        $colsegApe= $this->getNumColEnc("SEG_APEL");

        //Recorre todos los registros del CSV
        for($i=0; $i < count ($this->datos) ; $i++){
            $dato = $this->datos[$i][$colNomb];

            if ($colPrimApe!=-1)
                $dato = $dato." ".$this->datos[$i][$colPrimApe];

            if ($colsegApe!=-1)
                $dato = $dato." ".$this->datos[$i][$colsegApe];

            if (strlen($dato)>95)
                $this->errorNomb[]="REG ".($i+1).": $dato ";
        }	
    }


    /**
     * Valida que el campo de direcci�n no exceda el m�ximo permitido. Si existe alg�n error lo registra en el arreglo errorDireccion
     */
    function validarDireccion(){
        $colDir= $this->getNumColEnc("DIR");

        //Recorre todos los registros del CSV
        for($i=0; $i < count ($this->datos) ; $i++)
        {
            $dato = $this->datos[$i][$colDir];
            if (strlen($dato)>95)
                $this->errorDir[]="REG ".($i+1).": $dato ";
        }	
    }


    /**
     * Retorna el n�mero de columna en que se encuentra el encabezado que le llegue como par�metro. Si no existe retorna -1
     * @param $nombCol		es el nombre de la columna o encabezado
     * @return   integer
     */
    function getNumColEnc($nombCol){	
        $i=-1;
        $sw=0;
        //Recorre todo el encabezado
        foreach($this->encabezado as $campoEnc){
            $i++;

            if ("*".$nombCol."*" == $campoEnc){
                $sw=1;
                break;
            }

        }
        if ($sw==1)
            return($i);
        else
            return -1;
    }


    /**
     * Muestra los errores presentados en la validaci�n de los archivos
     */
    function mostrarError(){	
        $auxErrrEnca = $this->errorEncab;
        $auxErrPlant = $this->errorPlant;
        $auxErrLugar = $this->errorLugar;
        $auxErrESP = $this->errorESP;
        $auxErrCmpCsv = $this->errorComplCsv;
        $auxErrorTipo = $this->errorTipo;
        $auxErrorDir = $this->errorDir;
        $auxErrorNom = $this->errorNomb;
        $auxErrorAnexo = $this->errorRadAnexo;
        $ruta_raiz = "../..";
        include "$ruta_raiz/radsalida/masiva/error_archivo.php";
    }


    /**
     * Cambia el valor  del atributo que indica si se trata de ina combinaci�n definitiva
     * @param $arg		nuevo valor de la variable, puede ser "si" o "no"
     */
    function setDefinitivo($arg){
        $this->definitivo=$arg;
    }


    /**
     * Cambia el valor del atributo que indica la caracter�stica de los documentos a combinar
     * @param $tipo		nuevo valor de la variable
     */
    function setTipoDocto($tipo){	
        $this->tipoDocto=$tipo;	
    }


    /**
     * Carga los datos del archivo insumo para la generaci�n de masiva
     */
    function cargarInsumo(){
        $fp=fopen("$this->ruta_raiz/".$this->carpetaBodega."masiva/$this->archivo_insumo",'r');
        $i=0;
        while (!feof($fp))
        {	$i++;
        $buffer = fgets($fp, 4096);
        if ($i==1)
        {   $this->arcPlantilla =  trim(substr($buffer,strpos($buffer,"=")+1,strlen($buffer)-strpos($buffer,"=")));
        }
        if ($i==2)
        {   $this->arcCSV =  trim(substr($buffer,strpos($buffer,"=")+1,strlen($buffer)-strpos($buffer,"=")));
        }
        if ($i==3)
        {	$this->arcFinal =  trim(substr($buffer,strpos($buffer,"=")+1,strlen($buffer)-strpos($buffer,"=")));
        }
        if ($i==4)
        {	$this->arcTmp =  trim(substr($buffer,strpos($buffer,"=")+1,strlen($buffer)-strpos($buffer,"=")));
        }
        }
        fclose ($fp);
    }

    /**
     * Retorna el path del archivo insumo para masiva
     */
    function getInsumo(){	
        return($this->archivo_insumo);	
    }


    /**
     *
     * Deshace  una la transacci�n de correspondencia masiva en caso de no terminar satisfactoriamente
     */
    function deshacerMasiva(){	
        $this->conexion->conn->RollbackTrans();	
    }


    /**
     *
     * Confirma  una la transacci�n de correspondencia masiva en caso de terminar satisfactoriamente
     */
    function confirmarMasiva(){
        return ($this->conexion->conn->CompleteTrans());
    }


    /**
     * Funcion que retorna la ruta del csv con los numeros de radicado
     * para que el usuario realize la combinacion en word.
     */
    function final_csv(){
        $path = $this->ruta_raiz."/".$this->carpetaBodega."masiva/";
        $ruta = $path.$this->arcCSV;
        $final= $path.'comp'.$this->arcCSV;
        $linea= null;
        $m    = 0;

        clearstatcache();
        $fp	  = fopen($ruta,'r');
        $fd   = fopen($final, "w"); 

        fwrite($fp, 'header(\'Content-Type: application/csv; charset=iso-8859-1\');');

        while ($linea= fgets($fp,1024)){
            $linea = str_replace(',',";",$linea);
            $linea = str_replace("\"",'',$linea);

            if(empty($m)){
                $linea = "*RAD_S*; *F_RAD_S*;".$linea; 
            }else{
                $nmrad = $this->radarray[$m - 1];
                $hoy   = date('Y - m - d');
                $linea = " $nmrad;".$hoy.";".$linea; 
            }

            fwrite ($fd, $linea); 
            $m++;
        }

        fclose($fd); //aqui estoy cerrando el archivo.txt
        return $final; //aqui muestro la ruta donde se creo y guardo el archivo.txt
    }

    function codificacion($texto){

        define("UTF_8", 1);
        define("ASCII", 2);
        define("ISO_8859_1", 3);

        $c = 0;
        $ascii = true;
        for ($i = 0;$i<strlen($texto);$i++) {
            $byte = ord($texto[$i]);
            if ($c>0) {
                if (($byte>>6) != 0x2) {
                    return ISO_8859_1;
                } else {
                    $c--;
                }
            } elseif ($byte&0x80) {
                $ascii = false;
                if (($byte>>5) == 0x6) {
                    $c = 1;
                } elseif (($byte>>4) == 0xE) {
                    $c = 2;
                } elseif (($byte>>3) == 0x1E) {
                    $c = 3;
                } else {
                    return ISO_8859_1;
                }
            }
        }
        return ($ascii) ? ASCII : UTF_8;
    }

    function presentacion($item){

        $item = utf8_decode($item);

        if(strlen($item) > 45) {
            $item = $item."";
            $item = substr_replace($item,"\n",45,0);
        }

        return $item;
    }

}
?>
