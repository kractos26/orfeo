<?
class ARCHIVO_ORFEO
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
var $exp_edificio;
var $usua_arch;
var $exp_fech_arch;
var $exp_cd;
var $exp_nref;
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

function ARCHIVO_ORFEO(& $db)
{
	$this->cursor = & $db;
	$this->db = & $db;
	$this->fecha_hoy = Date("Y-m-d");
	$this->sqlFechaHoy=$this->db->conn->OffsetDate(0,$this->db->conn->sysTimeStamp);
}

	 // FUNCION PARA LEER DE LA BD
function consulta_exp($radicado)
{
	$query="select SGD_EXP_NUMERO,RADI_NUME_RADI,SGD_EXP_ESTADO,SGD_EXP_SUBEXPEDIENTE from SGD_EXP_EXPEDIENTE where RADI_NUME_RADI = $radicado";
	$rs=$this->cursor->conn->Execute($query);
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
   /**
    * Fecha de modificaci�n: 29-Junio-2006
    * Modificador: Supersoldiaria
    * Se aactualizan los datos del registro que cumpla la condici�n RADI_NUME_RADI y SGD_EXP_NUMERO
    */

 function modificar_expediente($radicado,$num_expediente,$exp_titulo,$exp_caja,$exp_carpeta,$exp_subexpediente,$exp_archivo,$exp_unicon,$exp_fechaIni,$exp_fechaFin,$exp_folio,$exp_rete,$exp_entrepa,$exp_edificio,$usua_arch,$CD,$NREF,$farch)
 {
	$estado_expediente =0;
	$record["SGD_EXP_TITULO"]="'".$exp_titulo."'";
	$record["SGD_EXP_CAJA"]="'".$exp_caja."'";
	$record["SGD_EXP_CARPETA"]="'".$exp_carpeta."'";
	$record["SGD_EXP_ESTADO"]='1';
	if($farch=="")$record["SGD_EXP_FECH_ARCH"]=$this->db->conn->OffsetDate(0,$this->db->conn->sysTimeStamp);
	else $record["SGD_EXP_FECH_ARCH"]="'".$farch."'";
	$record["SGD_EXP_ARCHIVO"]="'".$exp_archivo."'";
	$record["SGD_EXP_UNICON"]="'".$exp_unicon."'";
	$record["SGD_EXP_FECH"]="'".$exp_fechaIni."'";
	if($exp_fechaFin!="")$record["SGD_EXP_FECHFIN"]="'".$exp_fechaFin."'";
	$record["SGD_EXP_FOLIOS"]="'".$exp_folio."'";
	$record["SGD_EXP_EDIFICIO"]="'".$exp_edificio."'";
	$record1["RADI_NUME_RADI"] = $radicado;
	$record1["SGD_EXP_NUMERO"]="'".$num_expediente."'";
	$record["SGD_EXP_SUBEXPEDIENTE"]="'".$exp_subexpediente."'";
	$record["SGD_EXP_RETE"]="'".$exp_rete."'";
	$record["SGD_EXP_ENTREPA"]="'".$exp_entrepa."'";
	$record["RADI_USUA_ARCH"]="'".$usua_arch."'";
	$record["SGD_EXP_CD"]="'".$CD."'";
	$record["SGD_EXP_NREF"]="'".$NREF."'";
     //  $this->cursor->conn->debug=true;

	$rs= $this->cursor->update("sgd_exp_expediente", $record, $record1);
	return $rs;
}


function datos_expediente($num_expediente,$nurad)
{
	$estado_expediente =0;
	$query="select max(SGD_EXP_CARPETA) as TT from sgd_exp_expediente
			WHERE SGD_EXP_NUMERO='$num_expediente' group by SGD_EXP_NUMERO ";
	$rs=$this->cursor->conn->Execute($query);
	if (!$rs)
	{
		echo 'No tiene un Numero de expediente<br>';
	}else
	{
		$this->exp_num_carpetas = $rs->fields["TT"];
	}
	$query="select E.SGD_SEXP_NOMBRE as TITULO,
		D.SGD_EXP_CAJA,
		D.SGD_EXP_SUBEXPEDIENTE,
		D.SGD_EXP_ESTADO,
		D.SGD_EXP_ARCHIVO,
		D.SGD_EXP_UNICON,
		D.SGD_EXP_FECH,
		D.SGD_EXP_FECHFIN,
		D.SGD_EXP_FOLIOS,
		D.SGD_EXP_RETE,
		D.SGD_EXP_ENTREPA,
		D.SGD_EXP_EDIFICIO,
		D.SGD_EXP_CD,
		D.SGD_EXP_NREF,
		D.SGD_EXP_FECH_ARCH
		from sgd_exp_expediente D
			left join sgd_sexp_secexpedientes E on E.sgd_exp_numero = D.sgd_exp_numero     
		WHERE
		D.SGD_EXP_NUMERO='$num_expediente' and D.sgd_exp_estado=1 and D.radi_nume_radi=$nurad";
		//$this->cursor->conn->debug=true;
	$rs=$this->cursor->conn->Execute($query);
	$this->cursor->conn->Execute($query);
	if (!$rs->EOF)
	{
		$this->exp_estado = $rs->fields["SGD_EXP_ESTADO"];
		$this->exp_titulo = $rs->fields["TITULO"];
		$this->exp_caja = $rs->fields["SGD_EXP_CAJA"] ;
		$this->exp_subexpediente = $rs->fields["SGD_EXP_SUBEXPEDIENTE"] ;
		$this->exp_archivo = $rs->fields['SGD_EXP_ARCHIVO'] ;
		$this->exp_folio = $rs->fields['SGD_EXP_FOLIOS'] ;
		$this->exp_rete = $rs->fields['SGD_EXP_RETE'] ;
		$this->exp_entrepa = $rs->fields['SGD_EXP_ENTREPA'] ;
		$this->exp_edificio = $rs->fields['SGD_EXP_EDIFICIO'] ;
		$this->exp_cd = $rs->fields['SGD_EXP_CD'] ;
		$this->exp_nref = $rs->fields['SGD_EXP_NREF'] ;
		$this->exp_unicon = $rs->fields['SGD_EXP_UNICON'] ;
		$this->exp_fechaIni = $rs->fields['SGD_EXP_FECH'];
		$this->exp_fechaFin = $rs->fields['SGD_EXP_FECHFIN'];
		$this->exp_fech_arch = $rs->fields['SGD_EXP_FECH_ARCH'];
		$rsa=$this->cursor->conn->Execute("select SGD_EXP_CARPETA from sgd_exp_expediente where radi_nume_radi = $nurad and sgd_exp_numero = '$num_expediente'");
		$this->exp_carpeta = $rsa->fields["SGD_EXP_CARPETA"] ;
	}
	else
	{
		echo "<br>No se encontraron datos del expediente<br>";
	}
}
}
?>