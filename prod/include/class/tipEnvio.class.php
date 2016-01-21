<?PHP
/**
 * Clase donde gestionamos Tipos de Soporte.
 *
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.0
 * @author Desarrollo por Grupo Iyunxi Ltda auspiciado por la Fiscalia General de la Nación.
 */
class tipEnvio
{
private $cnn;	//Conexion a la BD.
private $flag;	//Bandera para usos varios.
private $vector;//Vector con los datos.

/**
 * Constructor de la classe.
 *
 * @param ConnectionHandler $db
 */
function __construct($db)
{
	$this->cnn = $db;
	$this->cnn->SetFetchMode(ADODB_FETCH_ASSOC);
}

/**
 * Agrega un nuevo Motivo de Devolucion.
 *
 * @param array $datos  Vector asociativo con todos los campos y sus valores.
 * @return boolean $flag False on Error /
 */
function SetInsDatos($datos)
{
	return $this->flag;
}

/**
 * Modifica datos a un Motivo de devolución.
 *
 * @param array $datos  Vector asociativo con todos los campos y sus valores.
 * @return boolean $flag False on Error /
 */
function SetModDatos($datos)
{	
	return $this->flag;
}

/**
 * Elimina un sector.
 *
 * @param  int $dato  Id del causal a eliminar.
 * @return boolean $flag False on Error /
 */
function SetDelDatos($dato)
{
	$sql = "SELECT COUNT(*) FROM RADICADO WHERE MREC_CODI =".$dato;
	if ($this->cnn->GetOne($sql) > 0)
	{
		$this->flag = 0;
	}
	else 
	{
		$this->cnn->BeginTrans();
		$ok = $this->cnn->Execute('DELETE FROM MEDIO_RECEPCION WHERE MREC_CODI='.$dato);
		if($ok)
		{
			$this->cnn->CommitTrans();
			$this->flag = true;
		}
		else
		{
			$this->cnn->RollbackTrans() ;
			$this->flag = false;
		}
	}
	return $this->flag;
}

/**
 * Retorna un combo con las opciones de la tabla vector todos los tipos de envios.
 * 
 * @param  boolean Habilita/Deshabilita la 1a opcion SELECCIONE.
 * @param  boolean Habilita/Deshabilita la validacion Onchange hacia una funcion llamada Actual().
 * @return string Cadena con el combo - False on Error.
 */
function Get_ComboOpc($dato1, $dato2,$slc_cmb2=0, $tipoEntrada=1, $tipoSalida=1, $tipoPQR=1)
{	
	$sqwte = ($tipoEntrada == 0) ? "MREC_REC=0" : " MREC_REC=1 ";
	$sqlts = ($tipoSalida == 0) ? "" : " OR MREC_ENV=1 ";
	$sqltp = ($tipoPQR == 0) ? "" : " OR MREC_PQR=1";
        $sqlWhere=" WHERE $sqwte $sqlts $sqltp";
        
	$sql = "Select MREC_DESC, MREC_CODI, MREC_ENV, MREC_REC, MREC_PQR from MEDIO_RECEPCION ORDER BY 2";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->flag = false;
	else
	{
		($dato1) ? $tmp1="0:&lt;&lt;SELECCIONE&gt;&gt;" : $tmp1 = false;
		($dato2) ? $tmp2="Onchange='Actual()'" : $tmp2 = '';
		$this->flag = $rs->GetMenu2('slc_cmb2',$slc_cmb2,$tmp1,false,false,"id='slc_cmb2' class='select' $tmp2");
		unset($rs); unset($tmp1); unset($tmp2);
	}
	return $this->flag;
}

/**
 * Retorna un vector.
 *
 * @return Array Vector numérico con los datos - False on error.
 */
function Get_ArrayDatos()
{	
	$sql = "Select e.MREC_DESC, e.MREC_CODI, e.MREC_ENV,MREC_REC,MREC_PQR, e.ENVIO_DIRECTO , m.sgd_fenv_codigo
                from MEDIO_RECEPCION  e
                left join sgd_mtr_mrecfenv m on m.mrec_codi=e.mrec_codi
                ORDER BY 2";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->vector = false;
	else
	{	$it = 0;
			$vdptosv[$it]['ID'] = "";
			$vdptosv[$it]['NOMBRE'] = "";
			$vdptosv[$it]['ENVIO'] = "";
			$vdptosv[$it]['RECEPCION'] = "";
                        $vdptosv[$it]['PQR'] = "";
			$vdptosv[$it]['ENVDIRECTO'] = "";
                        $vdptosv[$it]['FENV_CODIGO'] = "";
			$it += 1;
		while (!$rs->EOF)
		{	$vdptosv[$it]['ID'] = $rs->fields['MREC_CODI'];
			$vdptosv[$it]['NOMBRE'] = $rs->fields['MREC_DESC'];
			$vdptosv[$it]['ENVIO'] = $rs->fields['MREC_ENV'];
			$vdptosv[$it]['RECEPCION'] = $rs->fields['MREC_REC'];
                        $vdptosv[$it]['PQR'] = $rs->fields['MREC_PQR'];
			$vdptosv[$it]['ENVDIRECTO'] = $rs->fields['ENVIO_DIRECTO'];
                        $vdptosv[$it]['FENV_CODIGO'] = $rs->fields['SGD_FENV_CODIGO'];
			$it += 1;
			$rs->MoveNext();
		}
		$rs->Close();
		$this->vector = $vdptosv;
		unset($rs); unset($sql);
	}
	return $this->vector;
}
}
?>