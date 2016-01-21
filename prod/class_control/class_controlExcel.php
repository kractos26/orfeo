<?
class CONTROL_ORFEO
{
var $cursor;
var $db;
var $num_expediente;  // Almacena el nume del expediente
var $num_subexpediente; //Almacena el numero del subexpediente
var $estado_expediente; // Almacena el estado 0 para organizaci� y 1 para indicar ke ya esta clasificado fisicamente en archivo
var $exp_titulo;
var $exp_asunto;
var $exp_item1;
var $exp_item2;
var $exp_caja;
var $exp_estado;
var $exp_estante;
var $exp_carpeta;
var $exp_archivo;
var $exp_unicon;
var $exp_fechaIni;
var $exp_fechaFin;
var $exp_folio;
var $exp_rete;
var $exp_entrepa;
var $exp_num_carpetas;
var $campos_tabla;
var $campos_vista;
var $campos_width;
var $campos_align;
var $tabla_html;
var $fecha_hoy;
var $sqlFechaHoy;
var $permiso;
/** 
  * Atributo
  * @param  $objExp objeto Contiene la clase expediente en /include/tx/Expediente.php
  * Fecha de modificaci�n: 20-AGOSTO-2006
  * Modificador: JLOSADA Y C$this->exp_archivo = $this->rs->fields['sgd_exp_archivo'] ;
		  $this->exp_unicon = $this->rs->fields['sgd_exp_unicon'] ;
		  $this->exp_fechaIni = $this->rs->fields['SGD_EXP_FECH']; 
		  $this->exp_fechaFin = $this->rs->fields['sgd_exp_fechfin'];MAURICIO SUPERSERVICOS
  */
var $objExp;
/** 
  * Atributo
  * @param  $exp_subexpediente int Contiene el n�mero del Subexpediente
  * Fecha de modificaci�n: 29-Junio-2006
  * Modificador: Supersolidaria
  */
  var $exp_subexpediente;

function CONTROL_ORFEO(& $db)
{
	$this->cursor = & $db;
	$this->db = & $db;	 
	$this->fecha_hoy = Date("Y-m-d");
	$this->sqlFechaHoy=$this->db->conn->OffsetDate(0,$this->db->conn->sysTimeStamp);
	$this->cursor->debug=true;
}

function consulta_per_arch($nombusuario)
{
         $isql = "select USUA_ADMIN_ARCHIVO from usuario where USUA_CODI =$nombusuario";
	$rs=$this->cursor->query($isql);
//$this->cursor->debug=true;
if (!$rs){

	$this->permiso=$rs->fields["USUA_ADMIN_ARCHIVO"];
}
}
	 // FUNCION PARA LEER DE LA BD
	function consulta_exp($radicado)
	{
		$query="select SGD_EXP_NUMERO,RADI_NUME_RADI,SGD_EXP_ESTADO,SGD_EXP_SUBEXPEDIENTE from SGD_EXP_EXPEDIENTE where RADI_NUME_RADI = $radicado";		 
		$rs=$this->cursor->query($query);
		if (!$rs){
			$this->num_expediente = $rs->fields["SGD_EXP_NUMERO"];
			$this->estado_expediente = $rs->fields["SGD_EXP_ESTADO"];
			$this->exp_subexpediente = $rs->fields["SGD_EXP_SUBEXPEDIENTE"];
		}
		else
		{
			echo 'No tiene un Numero de expediente<br>';
			$this->num_expediente = "";
			$num_expediente = "";
			
		}
		//$this->num_expediente = $num_expediente;
		return $num_expediente;
	}
	 // FIN FUNCION PARA LEER
	 // Funcion para insertar un expediente nuevo apartir de un numero de radicado
	 function insertar_expediente($num_expediente,$radicado,$depe_codi,$usua_codi,$usua_doc)
	 {
			$estado_expediente =0;
			$record["SGD_EXP_NUMERO"]="$num_expediente";
			$record["RADI_NUME_RADI"]="$radicado";				
			$record["SGD_EXP_FECH"]= $this->db->conn->OffsetDate(0,$this->db->conn->sysTimeStamp);
			$record["DEPE_CODI"]="$depe_codi";
			$record["USUA_CODI"]="$usua_codi";				
			$record["USUA_DOC"]="$usua_doc";
			$record["SGD_EXP_ESTADO"]="$estado_expediente";
			$rs=$this->cursor->insert("SGD_EXP_EXPEDIENTE",$record);
																			
			if ($rs==false){
					echo '<br>Lo siento no pudo agregar el expediente<br>';
			}else{
					echo "<br>Expediente Grabado Correctamente<br>";
			}
   }
   /** 
    * Fecha de modificaci�n: 29-Junio-2006
    * Modificador: Supersoldiaria
    * Se aactualizan los datos del registro que cumpla la condici�n RADI_NUME_RADI y SGD_EXP_NUMERO
    */
	 function modificar_expediente($radicado,$num_expediente,$exp_titulo,$exp_asunto,$exp_item1,$exp_item2,$exp_caja,$exp_estante,$exp_carpeta,$exp_subexpediente,$exp_archivo,$exp_unicon,$exp_fechaIni,$exp_fechaFin,$exp_folio,$exp_rete,$exp_entrepa)
	 {
			
			$estado_expediente =0;
			// $record["SGD_EXP_NUMERO"]="'".$num_expediente."'";
			$record["SGD_EXP_TITULO"]="'".$exp_titulo."'";
			$record["SGD_EXP_ASUNTO"]="'".$exp_asunto."'";
			$record["SGD_EXP_ITEM1"]="'".$exp_item1."'";
			$record["SGD_EXP_ITEM2"]="'".$exp_item2."'";
			$record["SGD_EXP_CAJA"]="'".$exp_caja."'";
			$record["SGD_EXP_ESTANTE"]="'".$exp_estante."'";
			$record["SGD_EXP_CARPETA"]="'".$exp_carpeta."'";
			$record["SGD_EXP_ESTADO"]='1';
			$record["SGD_EXP_FECH_ARCH"]=$this->db->conn->OffsetDate(0,$this->db->conn->sysTimeStamp);
			$record["SGD_EXP_ARCHIVO"]="'".$exp_archivo."'";
				$record["SGD_EXP_UNICON"]="'".$exp_unicon."'";
				$record["SGD_EXP_FECH"]="'".$exp_fechaIni."'";
				$record["SGD_EXP_FECHFIN"]="'".$exp_fechaFin."'";
				$record["SGD_EXP_FOLIOS"]="'".$exp_folio."'";
			$record1["RADI_NUME_RADI"] = $radicado;
            $record1["SGD_EXP_NUMERO"]="'".$num_expediente."'";
            $record["SGD_EXP_SUBEXPEDIENTE"]="'".$exp_subexpediente."'";
            $record["SGD_EXP_RETE"]="'".$exp_rete."'";
            $record["SGD_EXP_ENTREPA"]="'".$exp_entrepa."'";
//$this->cursor->debug=true;
			$rs= $this->cursor->update("sgd_exp_expediente", $record, $record1);
						
			return $rs;
     }	 
	 function datos_expediente($num_expediente)
	 {
		$estado_expediente =0;
			$query="select max(SGD_EXP_CARPETA) tt
				from sgd_exp_expediente
				WHERE
				SGD_EXP_NUMERO='$num_expediente'
				group by SGD_EXP_NUMERO ";
		$rs=$this->cursor->query($query);
		if (!$rs){
				echo 'No tiene un Numero de expediente<br>';
			}else{
				if ($rs->MoveNext()) $this->exp_num_carpetas = $rs->fields["tt"];
		}
			$query="select
				SGD_EXP_TITULO
				,SGD_EXP_ASUNTO
				,SGD_EXP_ITEM1
				,SGD_EXP_ITEM2
				,SGD_EXP_CAJA
				,SGD_EXP_ESTANTE
				,SGD_EXP_CARPETA
				,SGD_EXP_SUBEXPEDIENTE
				,SGD_EXP_ESTADO
				,SGD_EXP_ARCHIVO
				,SGD_EXP_UNICON
				,SGD_EXP_FECH
				,SGD_EXP_FECHFIN
				,SGD_EXP_FOLIOS
				,SGD_EXP_RETE
				,SGD_EXP_ENTREPA
				from sgd_exp_expediente
				WHERE
				SGD_EXP_NUMERO='$num_expediente'
				";
			$rs=$this->cursor->query($query);
				$this->cursor->query($query);
			if (!$rs->EOF){
				$this->exp_estado = $rs->fields["SGD_EXP_ESTADO"];
				$this->exp_titulo = $rs->fields["SGD_EXP_TITULO"];
				$this->exp_asunto =  $rs->fields["SGD_EXP_ASUNTO"] ;
				$this->exp_item1 = $rs->fields["SGD_EXP_ITEM1"];
				$this->exp_item2 = $rs->fields["SGD_EXP_ITEM2"] ;
				$this->exp_caja = $rs->fields["SGD_EXP_CAJA"] ;
				$this->exp_estante = $rs->fields["SGD_EXP_ESTANTE"] ;
				$this->exp_carpeta = $rs->fields["SGD_EXP_CARPETA"] ;
				$this->exp_subexpediente = $rs->fields["SGD_EXP_SUBEXPEDIENTE"] ;
				$this->exp_archivo = $rs->fields['SGD_EXP_ARCHIVO'] ;
				$this->exp_folio = $rs->fields['SGD_EXP_FOLIOS'] ;
				$this->exp_rete = $rs->fields['SGD_EXP_RETE'] ;
				$this->exp_entrepa = $rs->fields['SGD_EXP_ENTREPA'] ;
		  $this->exp_unicon = $rs->fields['SGD_EXP_UNICON'] ;
		  $this->exp_fechaIni = $rs->fields['SGD_EXP_FECH'];
		  $this->exp_fechaFin = $rs->fields['SGD_EXP_FECHFIN'];
			} else{
					echo "<br>No se encontraron datos del expediente<br>";
			}
		}

	 // Fin funci� de Inseci� de expediente.
	 // Funcion que consulta un envio de radicado...
	 function consulta_envio($radicado)
	 {
				 $query="select RADI_NUME_GRUPO,RADI_NUME_SAL from SGD_RENV_REGENVIO where RADI_NUME_GRUPO like '%$radicado%'";
				$rs=$this->cursor->query($query);				
				if (!$rs->EOF){
		              $grupo = "";
				 }else{
				   if ($rs->MoveNext())
				   {
					 $grupo = $rs->fields["RADI_NUME_SAL"];
				   }
				}
				//$this->num_expediente = $num_expediente;
				return "$grupo";
	 }


function radicar_salida($tipoanexo,$cuentai,$documento_us3 ,$med ,$fec,$radicadopadre,$codusuario,$tip_doc ,$ane,$pais,$asu,$coddepe,$carp_codi,$tip_rem,$numdoc,$tdoc,$muni_codi,$archivo,$usua_doc,$depe_codi_territorial)
{
	$sec=$this->cursor->nextId("sec_$depe_codi_territorial");
	if ($sec!=-1)
	{	$sec = str_pad($sec,6,"0",STR_PAD_left);
		$nurad = date("Y") . $coddepe . $sec ."1";
		$carp_codi = 5;
		$query="insert into radicado (radi_tipo_deri, radi_cuentai, eesp_codi, mrec_codi, radi_fech_ofic, radi_nume_deri, radi_usua_radi,
				tdid_codi, radi_desc_anex, radi_nume_hoja, radi_pais, ra_asun, radi_depe_radi, radi_usua_actu, carp_codi, radi_nume_radi,
				trte_codi, radi_nume_iden, radi_fech_radi, radi_depe_actu, tdoc_codi, esta_codi, dpto_codi, muni_codi, radi_path, carp_per)
				values
				('$tipoanexo','$cuentai','$documento_us3','$med',$this->sqlFechaHoy,'$radicadopadre','$codusuario','$tip_doc','$ane',0,
				'$pais','$asu','$coddepe','$codusuario','$carp_codi','$nurad','$tip_rem','$numdoc',$this->sqlFechaHoy,'$coddepe','$tdoc',
				9,'$dpto_codi','$muni_codi','$archivo',1)";
			$rs=$this->cursor->query($query);

			if (!$rs){
				$this->cursor->conn->RollbackTrans();
				die ("<span class='etextomenu'>No se ha podido insertar la informaci&oacute;n del nuevo radicado $nurad"); 
			}
							
		}else{
			$this->cursor->conn->RollbackTrans();
			die ("<span class='etextomenu'>No existe secuencia para la generaci&oacute;n del radicado (Territorial $depe_codi_territorial)");
		}
		return $nurad;
}

function radicar_salida_masiva($tipoanexo,$cuentai,$documento_us3 ,$med ,$fec,$radicadopadre,$codusuario,$tip_doc ,$ane,$pais,$asu,$coddepe,$tip_rem,$numdoc,$tdoc,$muni_codi,$archivo,$usua_doc,$depe_codi_territorial,$secRadicacion,$numeroExpediente='', $nurad)
{

$tmp = explode("-",$muni_codi);
$muni_codi = $tmp[3];
$dpto_codi = $tmp[2];
$pais_codi = $tmp[1];
$cont_codi = $tmp[0];
//$sec=$this->cursor->nextId($secRadicacion);
$carp_codi=5;
$carp_per=1;
		
if (strlen(trim($tipoanexo))==0)
	$tipoanexo='NULL';
else 
   $tipoanexo = "'$tipoanexo'";
		
if (!$documento_us3 or strlen(trim($documento_us3))==0)
	$documento_us3='NULL';
else 
	$documento_us3 = "'$documento_us3'";
		
if (!$med or strlen(trim($med))==0)
	$med='NULL';
else 
   $med = "'$med'";
		   
if (!$radicadopadre or strlen(trim($radicadopadre))==0)
	$radicadopadre='NULL';
else 
   $radicadopadre = "'$radicadopadre'";
		   
if ($sec!=-1)
{	
	/*$sec = str_pad($sec,6,"0",STR_PAD_LEFT);
	$nurad = date("Y").$coddepe.$sec.substr($secRadicacion,7,1);*/
	if(!$tdoc) $tdoc="0";
	$queryOld = "insert into radicado (radi_tipo_deri, radi_cuentai, eesp_codi, mrec_codi, radi_fech_ofic, radi_nume_deri,
			radi_usua_radi, tdid_codi, radi_desc_anex, radi_nume_hoja, radi_pais, ra_asun, radi_depe_radi, radi_usua_actu,
			carp_codi, radi_nume_radi, trte_codi, radi_nume_iden, radi_fech_radi, radi_depe_actu, tdoc_codi, esta_codi, 
			ID_CONT, ID_PAIS, dpto_codi, muni_codi, radi_path, carp_per)
			values
			($tipoanexo, '$cuentai', $documento_us3, $med, $this->sqlFechaHoy, $radicadopadre, '$codusuario', 
			'$tip_doc', '$ane', 0, '$pais', '$asu', '$coddepe', '$codusuario', '$carp_codi', '$nurad', '$tip_rem',
			'$numdoc', $this->sqlFechaHoy, '$coddepe', '$tdoc', '9', $cont_codi, $pais_codi, $dpto_codi, $muni_codi,
			'$archivo',$carp_per)";
	$query = "insert into radicado (radi_tipo_deri, radi_cuentai, eesp_codi, mrec_codi, radi_fech_ofic, radi_nume_deri,
			radi_usua_radi, tdid_codi, radi_desc_anex, radi_nume_hoja, radi_pais, ra_asun, radi_depe_radi, radi_usua_actu,
			carp_codi, radi_nume_radi, trte_codi, radi_nume_iden, radi_fech_radi, radi_depe_actu, tdoc_codi, esta_codi, 
			ID_CONT, dpto_codi, muni_codi, radi_path, carp_per)
			values
			($tipoanexo, '$cuentai', $documento_us3, $med, $this->sqlFechaHoy, $radicadopadre, '$codusuario', 
			'$tip_doc', '$ane', 0, '$pais', '$asu', '$coddepe', '$codusuario', '$carp_codi', '$nurad', '$tip_rem',
			'$numdoc', $this->sqlFechaHoy, '$coddepe', '$tdoc', '9', $cont_codi, $dpto_codi, $muni_codi,
			'$archivo',$carp_per)";	
	$rs=$this->cursor->query($query);
	if (!$rs)
	{	$this->cursor->conn->RollbackTrans();
		die ("<span class='etextomenu'>No se ha podido insertar la informaci&oacute;ndel nuevo radicado $nurad"); 
	}else{
		
		
	}
	
							
}
else
{	$this->cursor->conn->RollbackTrans();
	die ("<span class='etextomenu'>No existe secuencia para la generaci&oacute;n del radicado (Territorial $depe_codi_territorial)");
}
return $nurad;
}
	 
function grabar_usuario($no_documento,$nombre_us1,$direccion_us1,$prim_apell_us1,$seg_apell_us1,$telefono_us1,$mail_nus1,$codep_us,$muni_us)
{
	   		 
		 $nextval=$this->cursor->nextId("sec_ciu_ciudadano");
  
		if ($nextval==-1){
			$this->cursor->conn->RollbackTrans();
			die ("<span class='etextomenu'>No se encontr�la secuencia sec_ciu_ciudadano ");						   
		}
		 
		$muni_codi_aux=$codigoMun = explode('-', $muni_us);
		$codigo_pai = $codigoMun[1];
		$codigo_dep = $codigoMun[2];
		$codigo_mun = $codigoMun[3];
		//echo ("***$muni_us***");	
		
		$query = "INSERT INTO SGD_CIU_CIUDADANO(
								SGD_CIU_CEDULA    ,TDID_CODI,SGD_CIU_CODIGO,SGD_CIU_NOMBRE,SGD_CIU_DIRECCION,SGD_CIU_APELL1   ,SGD_CIU_APELL2    ,SGD_CIU_TELEFONO,SGD_CIU_EMAIL  ,DPTO_CODI   ,MUNI_CODI)
						   values ('$no_documento',2        ,$nextval      ,'$nombre_us1' ,'$direccion_us1','$prim_apell_us1','$seg_apell_us1','$telefono_us1','$mail_us1' ,'$codigo_dep','$codigo_mun')";
			$rs=$this->cursor->query($query);			
			
			if (!$rs){
				$this->cursor->conn->RollbackTrans();
				die ("<span class='etextomenu'>No se ha podido insertar la informaci� del nuevo usuario ($query)"); 
			}
			
			return $nextval;
	 }
	 function grabar_oem($no_documento,$nombre_us1,$direccion_us1,$prim_apell_us1,$seg_apell_us1,$telefono_us1,$mail_nus1,$codep_us,$muni_us)
	 {
	  $nextval=$this->cursor->nextId("sec_oem_oempresas");
  
		if ($nextval==-1){
			$this->cursor->conn->RollbackTrans();
			die ("<span class='etextomenu'>No se encontr�la secuencia sec_oem_oempresas ");						   
		}
		 $query =  "INSERT INTO SGD_OEM_OEMPRESAS(tdid_codi,SGD_OEM_CODIGO ,SGD_OEM_NIT    ,SGD_OEM_OEMPRESA,SGD_OEM_DIRECCION ,SGD_OEM_REP_LEGAL   ,SGD_OEM_TELEFONO,DPTO_CODI   ,MUNI_CODI)
		values (4        ,$nextval       ,'$no_documento','$nombre_us1'   ,'$direccion_us1'  ,'$prim_apell_us1'   ,'$telefono_us1' ,'$codep_us','$muni_us'  )";
		 $rs=$this->cursor->query($query);		
		 
		 if (!$rs){
				$this->cursor->conn->RollbackTrans();
				die ("<span class='etextomenu'>No se ha podido insertar la informaci� de OEM ($query)"); 
			}												
			return $nextval;
	 }
	 
	 function grabar_dir($tipo_rem,$nombre,$prim_apell,$seg_apell,$dignatario,$direccion,$depto,$muni,$radicado,$cod_usuario)
	 {
		$isql = "insert into SGD_DIR_DRECCIONES(MUNI_CODI         ,DPTO_CODI ,SGD_OEM_CODIGO    ,SGD_CIU_CODIGO ,SGD_ESP_CODI   ,RADI_NUME_RADI,SGD_SEC_CODIGO ,SGD_DIR_DIRECCION  ,SGD_DIR_TELEFONO ,SGD_DIR_MAIL,SGD_DIR_TIPO,SGD_DIR_CODIGO,SGD_DIR_NOMBRE)";
		$isql .= "                      values($muni              ,$depto    ,0                 ,0              ,$esp           ,$nurad        ,0              ,'$direccion'       ,'$telefono'      ,'$mail_us1' ,1           ,$nextval      ,'$nombre' )";
		$query="select sec_$coddepe.nextval as SEC from dual";
		if ($this->cursor->query($query)){
			$this->cursor->next_record();
			$sec = $this->cursor->f('sec');
				$sec = str_pad($sec,5,"0",STR_PAD_left);
			$nurad = date("Y") . $coddepe . $sec ."1";
			$carp_codi = 5;
			$query="insert into radicado(radi_tipo_deri  ,radi_cuentai,eesp_codi       ,mrec_codi  ,radi_fech_ofic,radi_nume_deri  ,radi_usua_radi,tdid_codi,radi_desc_anex,radi_nume_hoja,radi_pais,ra_asun ,radi_depe_radi,radi_usua_actu,carp_codi   ,radi_nume_radi,trte_codi ,radi_nume_iden,radi_fech_radi ,radi_depe_actu  ,tdoc_codi  ,esta_codi,dpto_codi ,muni_codi     ,radi_path,carp_per)
			values ('$tipoanexo','$cuentai'  ,'$documento_us3','$med'     ,$this->sqlFechaHoy       ,'$radicadopadre','$codusuario' ,'$tip_doc','$ane'        ,0             ,'$pais'  ,'$asu' ,'$coddepe'    ,1             ,'5'         ,'$nurad'      ,'$tip_rem','$numdoc'     ,$this->sqlFechaHoy        ,'$coddepe'      ,'$tdoc'    ,9        ,'$dpto_codi','$muni_codi','$archivo','1')";
			if (!$this->cursor->query($query)){
						echo "No se pudo realizar la consulta . . . ";
					}else{
						//echo "Se agrego el radicado correctamente . . . ";
				}
						//$this->num_expediente = $num_expediente;
				}
				return $nurad;
	 }
	 function tabla_sql($query)
	 {
	 error_reporting(7);
	$jh_db = $this->cursor->query($query);
	echo "<br>Numero de Registros " . $this->cursor->num_rows();
	$tabla_html = "<table border=1 width=100%>";
	echo "<table class='t_bordeGris' width=100%>";
	if ($jh_db)
	{
	echo "<tr class='textoOpcion'>";
	$tabla_html .= "<tr bgcolor='#D0D0FF'>";
	$iii = 0;
	foreach($this->campos_vista as $campos_d)
	{
	        $width = $this->campos_width[$iii];
		$tabla_html .=  "<td width='$width' bgcolor='#CCCCCC'><center>$campos_d</td>";
		echo "<td class='grisCCCCCC'  ><center>$campos_d</td>";
		$iii++;
	}
	$tabla_html .=  "</tr>";
	echo "</tr>";
	while($this->cursor->next_record())
	{
		$tabla_html .=  "<tr>";
		echo "<tr class='tparr'>";
		$iii = 0;

		foreach($this->campos_tabla as $campos_d)
		{
	
			switch  ($this->campos_align[$iii])
			{
			case "L":
				$align = "Left";
				break;
			case "C":
				$align = "Center";
				break;
			case "R":
				$align = "Right";
				break;
			default:
				$align = "Left";
				break;
			}
			error_reporting(7);
			
		$width = $this->campos_width[$iii];
		$width_max = intval(36 * $width / 250);	
		if(!$this->cursor->f($campos_d)) $dato = "-"; else $dato=substr($this->cursor->f($campos_d),0,$width_max);
		$tabla_html .=  "<td  align=$align width=".$this->campos_width[$iii]." height=23>$dato</td>";
		echo "<td class='t_bordeGris' align=$align>".$this->cursor->f($campos_d)."</td>";
		$iii++;
		}
		$tabla_html .=  "</tr>";
		echo "</tr>";
	//$this->num_expediente = $num_expediente;
	}
	$tabla_html .=  "</table>";
	
	$this->tabla_html = $tabla_html;
	echo "</table>";
	return $nextval;
     }

	 // Fin de funcion que consulta envio de radicado.
   }
  
   function insertaSecuencias( $secuenciaIni, $secuenciaFin, $intervaloSecuencia, $dependencia, $codusuario, $tipoRad )
	{
		
		$queryID = "select max(SGD_MASIVA_CODIGO) as ID from SGD_MASIVA_EXCEL";
		$rs=$this->cursor->query($queryID);
		
		if ( !$rs ){
			
		}else{
			$idSecuencia = $rs->fields["ID"] + 1;
//			echo "ID: $idSecuencia";
			
			$queryInsercion = "insert into SGD_MASIVA_EXCEL (SGD_MASIVA_CODIGO, SGD_MASIVA_RANGOINI, SGD_MASIVA_RANGOFIN, SGD_MASIVA_INTERVALO, 
								SGD_MASIVA_DEPENDENCIA, SGD_MASIVA_USUARIO, SGD_MASIVA_TIPORADICACION, SGD_MASIVA_RADICADA)";
			$queryInsercion .= "values( $idSecuencia, '$secuenciaIni', '$secuenciaFin', $intervaloSecuencia , $dependencia, $codusuario, $tipoRad, 0)";
			
			$rsInsercion = $this->cursor->query($queryInsercion);
			
			if( !$rsInsercion ){
				return false;
			}else {
				return  true;	
			}
			
		}
		
		
	} 
      
   }
?>