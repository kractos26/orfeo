<?
/*  Visualizador de Listados.
*	Creado por: Ing. Hollman Ladino Paredes.
*	Para el proyecto ORFEO.
*
*	Permite la visualizacion general de paises, departemntos, municipios, tarifas, etc.
*	Es una idea basica. Aun esta bajo desarrollo.
*/
session_start();
GLOBAL $gSQLMaxRows;
$ruta_raiz="../..";
include("$ruta_raiz/config.php"); 		// incluir configuracion.
include($ADODB_PATH.'/adodb.inc.php');
include($ADODB_PATH.'/tohtml.inc.php');
$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
$ADODB_COUNTRECS = false;

$error = 0;
$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
$conn = NewADOConnection($dsn);
//$conn->debug=1;

switch ($_GET['var'])
{	case 'tar'	:
		{	$titulo = "LISTADO GENERAL DE TARIFAS";
			$tit_columnas = array('Forma Envio','Nal / InterNal.','C&oacute;d. Tarifa','Desc. Tarifa','Valor Local/America','Valor Nal./Resto');
			$valor1 = $conn->IfNull('SGD_TAR_TARIFAS.SGD_TAR_VALENV1', 'SGD_TAR_TARIFAS.SGD_TAR_VALENV1G1');
			$valor2 = $conn->IfNull('SGD_TAR_TARIFAS.SGD_TAR_VALENV2', 'SGD_TAR_TARIFAS.SGD_TAR_VALENV2G2');
			$isql =	"SELECT SGD_FENV_FRMENVIO.SGD_FENV_DESCRIP, SGD_CLTA_CLSTARIF.SGD_CLTA_CODSER, SGD_CLTA_CLSTARIF.SGD_TAR_CODIGO, SGD_CLTA_CLSTARIF.SGD_CLTA_DESCRIP, 
                      $valor1 AS VALOR1, $valor2 AS VALOR2 
					FROM SGD_CLTA_CLSTARIF, SGD_TAR_TARIFAS, SGD_FENV_FRMENVIO 
					WHERE SGD_CLTA_CLSTARIF.SGD_FENV_CODIGO = SGD_TAR_TARIFAS.SGD_FENV_CODIGO AND 
                      SGD_CLTA_CLSTARIF.SGD_TAR_CODIGO = SGD_TAR_TARIFAS.SGD_TAR_CODIGO AND 
                      SGD_CLTA_CLSTARIF.SGD_CLTA_CODSER = SGD_TAR_TARIFAS.SGD_CLTA_CODSER AND
					  SGD_CLTA_CLSTARIF.SGD_FENV_CODIGO = SGD_FENV_FRMENVIO.SGD_FENV_CODIGO
					ORDER BY SGD_CLTA_CLSTARIF.SGD_CLTA_CODSER, SGD_CLTA_CLSTARIF.SGD_FENV_CODIGO, 
					SGD_CLTA_CLSTARIF.SGD_TAR_CODIGO";			
		}break;
	case 'pai'	:
		{	$titulo = "LISTADO GENERAL DE PAISES";
			$tit_columnas = array('Continente','Id Pa&iacute;s','Nombre Pa&iacute;s');
			$isql =	"SELECT SGD_DEF_CONTINENTES.NOMBRE_CONT, SGD_DEF_PAISES.ID_PAIS, SGD_DEF_PAISES.NOMBRE_PAIS 
					FROM SGD_DEF_PAISES, SGD_DEF_CONTINENTES WHERE SGD_DEF_PAISES.ID_CONT = SGD_DEF_CONTINENTES.ID_CONT
					ORDER BY SGD_DEF_CONTINENTES.NOMBRE_CONT, SGD_DEF_PAISES.NOMBRE_PAIS";
			
		}break;
	case 'tpr'	:
		{	$titulo = "LISTADO GENERAL DE TIPOS DE RADICADOS";
			$tit_columnas = array('Id T.R.','Nombre','Genera Rad. Salida?','D&iacute;as Bloqueo.');
			$isql =	'SELECT SGD_TRAD_CODIGO as "Id T.R.", SGD_TRAD_DESCR as "Nombre", 
					SGD_TRAD_GENRADSAL as "Genera Rad. Salida?", SGD_TRAD_DIASBLOQUEO as "Dias Bloqueo" 
					FROM SGD_TRAD_TIPORAD ORDER BY SGD_TRAD_CODIGO';
		}break;
	case 'fnv'	:
		{	$titulo = "LISTADO GENERAL DE FORMAS DE ENVIO";
			$tit_columnas = array('Id','Nombre','Estado','Genera Planilla?');
			$isql =	"SELECT SGD_FENV_CODIGO, SGD_FENV_DESCRIP,
					 (CASE WHEN SGD_FENV_ESTADO = 0 THEN 'INACTIVO' WHEN SGD_FENV_ESTADO = 1 THEN 'ACTIVO' END),
					 (CASE WHEN SGD_FENV_PLANILLA = 0 THEN 'NO' WHEN SGD_FENV_PLANILLA = 1 THEN 'SI' END) 
					FROM SGD_FENV_FRMENVIO ORDER BY SGD_FENV_DESCRIP";
		}break;
	case 'lcd'	:
		{	$titulo = "LISTADO GENERAL DE RESOLUCIONES";
			$tit_columnas = array('Id','Resoluci&oacute;n');
			$isql =	"SELECT SGD_TRES_CODIGO, SGD_TRES_DESCRIP FROM SGD_TRES_TPRESOLUCION ORDER BY SGD_TRES_CODIGO";
			
		}break;
	case 'dpt'	:
		{	$titulo = "LISTADO GENERAL DE DEPARTAMENTOS";
			$tit_columnas = array('Continente','Nombre Pa�s','Id Dpto','Nombre Dpto');
			$isql =	"SELECT SGD_DEF_CONTINENTES.NOMBRE_CONT, SGD_DEF_PAISES.NOMBRE_PAIS, DEPARTAMENTO.DPTO_CODI, DEPARTAMENTO.DPTO_NOMB
					FROM SGD_DEF_PAISES, SGD_DEF_CONTINENTES, DEPARTAMENTO 
					WHERE SGD_DEF_PAISES.ID_CONT = SGD_DEF_CONTINENTES.ID_CONT AND 
						SGD_DEF_PAISES.ID_PAIS = DEPARTAMENTO.id_pais AND 
						SGD_DEF_PAISES.ID_CONT = DEPARTAMENTO.id_cont
					ORDER BY SGD_DEF_CONTINENTES.NOMBRE_CONT, SGD_DEF_PAISES.NOMBRE_PAIS, DEPARTAMENTO.DPTO_NOMB";			
		}break;
	case 'dpc'	:
		{	$titulo = "LISTADO GENERAL DE DEPENDENCIAS";

			$tit_columnas = array('Id','Nombre','Sigla','Estado','Nombre Dpto');
			$isql =	"SELECT DEPE_CODI, DEPE_NOMB, DEP_SIGLA, DEPE_ESTADO	
					FROM DEPENDENCIA 
					ORDER BY DEPE_CODI";	
		}break;
	case 'cau'	:
		{	$titulo = "LISTADO GENERAL DE CAUSALES";
			$tit_columnas = array('Id','Nombre');
			$isql =	"SELECT SGD_CAU_CODIGO, SGD_CAU_DESCRIP FROM SGD_CAU_CAUSAL ORDER BY 1";
		}break;
	case 'mdv'	:
		{	$titulo = "LISTADO GENERAL DE MOTIVOS DE DEVOLUCI&Oacute;N";
			$tit_columnas = array('Id','Nombre');
			$isql = 'SELECT SGD_DEVE_CODIGO AS "ID", SGD_DEVE_DESC AS "MOTIVO" FROM SGD_DEVE_DEV_ENVIO ORDER BY 1';
		}break;
	case 'tma'	:
		{	$titulo = "LISTADO GENERAL DE TEMAS";
			$tit_columnas = array('Id','Nombre','Dependencia Vinculada');
			$isql =	"SELECT t.SGD_TMA_CODIGO, t.SGD_TMA_DESCRIP, d.DEPE_NOMB 
					FROM DEPENDENCIA d, SGD_TMA_TEMAS t, SGD_TMD_TEMADEPE td
					WHERE td.SGD_TMA_CODIGO=t.SGD_TMA_CODIGO AND td.depe_codi=d.depe_codi
					ORDER BY t.SGD_TMA_DESCRIP, d.DEPE_NOMB";
		}break;
	case 'ctt'	:
		{	$titulo = "LISTADO GENERAL DE CONTACTOS";
			$tit_columnas = array('Tipo Contacto','Empresa/Entidad','Id Contacto','Nombre Contacto','Cargo Contacto','Telefono Contacto');
			$isql =	"SELECT  CASE WHEN c.CTT_ID_TIPO = 0 THEN 'Entidad' WHEN c.CTT_ID_TIPO = 1 THEN 'Otras Emp.' END as TIPO,b.NOMBRE_DE_LA_EMPRESA,c.CTT_ID, c.CTT_NOMBRE, c.CTT_CARGO, c.CTT_TELEFONO
					FROM SGD_DEF_CONTACTOS c, BODEGA_EMPRESAS b
					WHERE c.CTT_ID_EMPRESA = b.IDENTIFICADOR_EMPRESA AND c.CTT_ID_TIPO=0
					UNION 
					SELECT  CASE WHEN c.CTT_ID_TIPO = 0 THEN 'Entidad' WHEN c.CTT_ID_TIPO = 1 THEN 'Otras Emp.' END as TIPO, 	b.SGD_OEM_OEMPRESA,c.CTT_ID, c.CTT_NOMBRE, c.CTT_CARGO, c.CTT_TELEFONO
					FROM SGD_DEF_CONTACTOS c, SGD_OEM_OEMPRESAS b
					WHERE c.CTT_ID_EMPRESA = b.SGD_OEM_CODIGO AND c.CTT_ID_TIPO=1
					ORDER BY 1,2,4";			
		}break;
	case 'bge'	:
		{	$titulo = "LISTADO GENERAL DE ESP";
			$tit_columnas = array('Empresa','Sigla','Correo E', 'Tel&eacute;fonos' , 'NIT', 'NIUR', 'Id Empresa');
			$isql =	"SELECT NOMBRE_DE_LA_EMPRESA, SIGLA_DE_LA_EMPRESA, EMAIL, TELEFONO_1, NIT_DE_LA_EMPRESA,
					NUIR, IDENTIFICADOR_EMPRESA 
					FROM BODEGA_EMPRESAS
					ORDER BY 7";
			
		}break;
	case 'sts'	:
		{	$titulo = "LISTADO GENERAL DE SECTORES";
			$tit_columnas = array('Id Sector','Nombre');
			$isql =	"SELECT PAR_SERV_SECUE, PAR_SERV_NOMBRE FROM PAR_SERV_SERVICIOS ORDER BY PAR_SERV_SECUE";
			
		}break;
	case 'dpc'	:
		{	$titulo = "LISTADO GENERAL DE DEPENDENCIAS";
			$tit_columnas = array('Id','Nombre','Sigla','Estado','Nombre Dpto');
			$isql =	"SELECT DEPE_CODI, DEPE_NOMB, DEP_SIGLA, DEPE_ESTADO	
				FROM DEPENDENCIA ORDER BY DEPE_CODI";	
		}break;
        case 'eap':
                {
                    $titulo = "LISTADO GENERAL DE APLICACIONES ENLAZADAS CON ORFEO";
                                $tit_columnas = array('Id','Nombre','Estado','Dependencia Responsable');
                                $isql =	"SELECT SGD_APLI_CODIGO AS ID,
                                SGD_APLI_DESCRIP AS DESCRIP,
                                CASE SGD_APLI_ESTADO WHEN 0 THEN 'Inactiva' WHEN 1 THEN 'Activa' END as ESTADO,
                                DEPE_NOMB AS DEPENDENCIA
                            FROM SGD_APLICACIONES INNER JOIN DEPENDENCIA ON DEPE_CODI=SGD_APLI_DEPE
                            ORDER BY 1";
                }break;
        case 'mime'	:
		{
			$titulo = "LISTADO GENERAL DE TIPOS DE ARCHIVOS";
			$tit_columnas = array('Id','Extensi&oacute;n','Descripci&oacute;n');
			$isql =	"SELECT ANEX_TIPO_CODI as Id, ANEX_TIPO_EXT as Exte, ANEX_TIPO_DESC as Responsable FROM ANEXOS_TIPO ORDER BY 1";

		}break;
         case 'msa':
                {
                    $titulo = "LISTADO GENERAL DE MEDIOS DE SOPORTE";
                                $tit_columnas = array('Id','Nombre','Estado');
                                $isql =	"SELECT SGD_MSA_CODIGO AS ID,
                                SGD_MSA_DESCRIP AS DESCRIP,
                                CASE WHEN SGD_MSA_ESTADO = 0 THEN 'Inactiva' WHEN SGD_MSA_ESTADO = 1 THEN 'Activa' END as ESTADO
                            FROM SGD_MSA_MEDSOPARCHIVO ORDER BY 1";
                }break;
        case 'ate'      :
                {
                        $titulo = "LISTADO GENERAL DE TIPOS DE RECEPCION Y ENVIOS";
                        $tit_columnas = array('Id','Nombre','Tipo');
                        $isql = "SELECT MREC_CODI as Id,MREC_DESC as Descripcion,  case  when MREC_ENV=1 AND MREC_REC = 1  THEN 'Recepcion Y Envio'when MREC_ENV=1 then 'Envio ' when MREC_REC = 1 then 'Recepcion'  end  as Envio FROM MEDIO_RECEPCION ORDER BY 1";

                }break;
	case 'mtd':
                {
                    $titulo = "LISTADO GENERAL DE METADATOS";
                    $tit_columnas = array('Id','Nombre','Descripcion','Estado','Tipo_Documental','Serie','Subserie');
                    $isql =	"SELECT M.SGD_MTD_CODIGO AS ID, ".
				       			"M.SGD_MTD_NOMBRE AS NOMBRE, M.SGD_MTD_DESCRIP AS DESCRIP, ".
       							"CASE M.SGD_MTD_ESTADO WHEN 0 THEN 'Inactiva' WHEN 1 THEN 'Activa' END as ESTADO, ".
                    			"D.SGD_TPR_DESCRIP AS TIPO_DOCUMENTAL, S.SGD_SRD_DESCRIP AS SERIE, B.SGD_SBRD_DESCRIP AS SUBSERIE ".
							"FROM SGD_MTD_METADATOS M ".
								"LEFT JOIN SGD_TPR_TPDCUMENTO D ON D.SGD_TPR_CODIGO=M.SGD_TPR_CODIGO ".
								"LEFT JOIN SGD_SRD_SERIESRD S ON S.SGD_SRD_CODIGO=M.SGD_SRD_CODIGO ".
								"LEFT JOIN SGD_SBRD_SUBSERIERD B ON B.SGD_SRD_CODIGO=M.SGD_SRD_CODIGO AND B.SGD_SBRD_CODIGO=M.SGD_SBRD_CODIGO ". 
							"ORDER BY M.SGD_MTD_NOMBRE";
                }break;
            
            /*
             * Genera Listado de Detalles Causal
             */
         case 'detcau':
                 {
                    $titulo = "LISTADO GENERAL DE DETALLES CAUSAL";
                                $tit_columnas = array('Causal','Codigo Detalle' ,'Detalle Causal','Estado');
                                $isql = "SELECT SGD_CAU_CAUSAL.SGD_CAU_DESCRIP,SGD_DCAU_CAUSAL.SGD_DCAU_CODIGO, SGD_DCAU_CAUSAL.SGD_DCAU_DESCRIP,  SGD_DCAU_CAUSAL.SGD_DCAU_ESTADO
                                        FROM SGD_DCAU_CAUSAL, SGD_CAU_CAUSAL WHERE SGD_DCAU_CAUSAL.SGD_CAU_CODIGO = SGD_CAU_CAUSAL.SGD_CAU_CODIGO
                                        ORDER BY SGD_CAU_CAUSAL.SGD_CAU_DESCRIP";
                 }break;
             /*
              * Genera Listado de los Motivos de Anulacion
              */
          case 'motanu':
                  {
                     $titulo = "LISTADO GENERAL DE MOTIVOS DE ANULACION";    
                                $tit_columnas= array('Codigo','Detalle Motivo Anulacion');
                                $isql= "SELECT motivo_anulacion_codigo AS Id, motivo_anulacion_descrip AS Descript FROM motivo_anulacion ORDER BY motivo_anulacion_codigo";   
                  }break;
         
          case 'motmodif':
                  {
                    $titulo = "LISTADO GENERAL DE MOTIVOS DE MODIFICACION";
                                $tit_columnas = array('C&oacute;digo','Detalle Motivo Modificaci&oacute;n');
                                $isql = "SELECT motivo_modificacion_codigo AS Id, motivo_modificacion_descrip AS Descript FROM motivo_modificacion ORDER BY motivo_modificacion_codigo";
                                
                  }break; 

	default		:
		{	$titulo ="LISTADO GENERAL DE MUNICIPIOS";
			$isql   ="SELECT c.NOMBRE_CONT, p.NOMBRE_PAIS, d.DPTO_NOMB, m.MUNI_CODI, m.MUNI_NOMB
                      FROM MUNICIPIO m
                      JOIN SGD_DEF_CONTINENTES c ON c.ID_CONT= m.ID_CONT
                      JOIN SGD_DEF_PAISES      p ON m.ID_PAIS = p.ID_PAIS and p.ID_CONT=m.ID_CONT
                      JOIN DEPARTAMENTO        d ON m.DPTO_CODI = d.DPTO_CODI and m.ID_PAIS = d.ID_PAIS and d.ID_CONT= m.ID_CONT
					  ORDER BY c.NOMBRE_CONT, p.NOMBRE_PAIS, d.DPTO_NOMB, m.MUNI_NOMB ";
		}break;
}

//$conn->debug=true;
$ADODB_COUNTRECS=true;
$Rs_clta = $conn->Execute($isql); 
$ADODB_COUNTRECS=false;
$gSQLMaxRows = $Rs_clta->RecordCount();
?>
<html>
<head>
<title><?= $titulo ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?
switch ($_GET['var'])
{	case 'tar'	:
	case 'pai'	:
	case 'tpr'	:
	case 'fnv'	:
	case 'lcd'	:
	case 'dpt'	:
	case 'dpc'	:
	case 'cau'	:
	case 'mdv'	:
	case 'tma'	:
	case 'ctt'	:
	case 'bge'	:
	case 'sts'	:
	case 'dpc'	:
        case 'eap'      :
        case 'mime'     :
        case 'ate'     :
        case 'msa'      :
        case 'mtd'      :
        case 'detcau'   :
        case 'motanu'   :
        case 'motmodif' :    
		{
			$html = rs2html($Rs_clta,'border=1 cellpadding=0 align=center',$tit_columnas,true,false);
			$pos1 = strpos($html,"</TABLE>\n\n");
			$cnt_tmp = substr_count($html,"</TH>\n</tr>");
			if($cnt_tmp > 1)
			while(--$cnt_tmp)
			{
				$pos1 = strpos($html,"</TABLE>\n\n");
				$pos2 = strpos($html,"</TH>\n</tr>",$pos1)+11;
				$html = substr($html,0,$pos1) . substr($html,$pos2,strlen($html));
			}
			echo $html;
		}break;
	default		: 
		{			
			include($ADODB_PATH.'/adodb-pager.inc.php');
			$pager = new ADODB_Pager($conn,$isql);
			$pager->Render($rows_per_page=20);
			break;
		}
}
$Rs_clta->Close();
?>
</body>
</html>
