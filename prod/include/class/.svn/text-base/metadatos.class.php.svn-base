<?PHP
/**
 * Clase donde gestionamos informacion referente a las etiquetas que enlazan Radicados.
 *
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.0
 * @author Grupo Iyunxi Ltda
 */
class etiquetas
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
 * Agrega una nueva etiqueta.
 *
 * @param array $datos  Vector asociativo con todos los campos y sus valores.
 * @return boolean $flag False on Error /
 */
function SetInsDatos($datos)
{
    if ( count($datos) != 7 || !is_int((integer)$datos['txtId']) || !is_int((integer)$datos['slcEstado']) 
    	|| strlen($datos['txtModelo']>32) || strlen($datos['txtDescrip']>320)
    	|| ( empty($datos['id_tipodoc']) && is_null($datos['idSerie']) && is_null($datos['idSubserie']))
    	|| ( is_null($datos['idSerie']) && is_null($datos['idSubserie']) )
		)
		{
        	$this->flag = false;
		}
    else
    {
    	$record["SGD_MTD_CODIGO"] = $datos['txtId'];
    	$record["SGD_MTD_NOMBRE"] = $datos['txtModelo'];
    	$record["SGD_MTD_DESCRIP"] = $datos['txtDescrip'];
    	$record["SGD_MTD_ESTADO"] = $datos['slcEstado'];
    	$record["SGD_MTD_OBLIG"] = 0;
    	$record["SGD_SRD_CODIGO"] = ($datos['idSerie']==0) ? null : $datos['idSerie'];
    	$record["SGD_SBRD_CODIGO"] = $datos['idSubserie'];
    	$record["SGD_TPR_CODIGO"] = $datos['id_tipodoc'];
    	$tabla = "SGD_MTD_METADATOS";
    	
    	$this->cnn->StartTrans();
    	$ok = $this->cnn->AutoExecute(&$tabla, $record, 'INSERT', false, false, true);
        $this->flag = $this->cnn->CompleteTrans();
    }
	return $this->flag;
}

/**
 * Modifica datos a una etiqueta.
 *
 * @param array $datos  Vector asociativo con todos los campos y sus valores.
 * @return boolean $flag False on Error /
 */
function SetModDatos($datos)
{	
if ( count($datos) != 7 || !is_int((integer)$datos['txtId']) || !is_int((integer)$datos['slcEstado']) 
    	|| strlen($datos['txtModelo']>32) || strlen($datos['txtDescrip']>320)
    	|| ( empty($datos['id_tipodoc']) && is_null($datos['idSerie']) && is_null($datos['idSubserie']))
    	|| ( is_null($datos['idSerie']) && is_null($datos['idSubserie']) )
		)
		{
        	$this->flag = false;
		}
    else
    {
    	$record["SGD_MTD_CODIGO"] = $datos['txtId'];
    	$record["SGD_MTD_NOMBRE"] = $datos['txtModelo'];
    	$record["SGD_MTD_DESCRIP"] = $datos['txtDescrip'];
    	$record["SGD_MTD_ESTADO"] = $datos['slcEstado'];
    	$record["SGD_MTD_OBLIG"] = 0;
    	$record["SGD_SRD_CODIGO"] = ($datos['idSerie']==0) ? null : $datos['idSerie'];
    	$record["SGD_SBRD_CODIGO"] = $datos['idSubserie'];
    	$record["SGD_TPR_CODIGO"] = $datos['id_tipodoc'];
    	$tabla = "SGD_MTD_METADATOS";
    	
    	$this->cnn->StartTrans();
    	$ok = $this->cnn->AutoExecute(&$tabla, $record, 'UPDATE', " SGD_MTD_CODIGO = ".$datos['txtId'], false, true);
        $this->flag = $this->cnn->CompleteTrans();
    }
	return $this->flag;
}

/**
 * Elimina un registro, siempre y cuando no haya asociaciones a �l.
 *
 * @param  int $dato  Id del causal a eliminar.
 * @return boolean $flag False on Error /
 */
function SetDelDatos($dato)
{
    if (is_int((integer)$dato))
    {
        $sql1 = "select count(sgd_mtd_codigo) from sgd_mmr_matrimetaradi where sgd_mtd_codigo = $dato";
        $sql2 = "select count(sgd_mtd_codigo) from sgd_mmr_matrimetaexpe where sgd_mtd_codigo = $dato";
        if ( ($this->cnn->GetOne($sql1) > 0) || ($this->cnn->GetOne($sql2) > 0) )
        {
            $this->flag = false;
        }
        else
        {
            $this->cnn->BeginTrans();
            $ok = $this->cnn->Execute('DELETE FROM SGD_MTD_METADATOS WHERE SGD_MTD_CODIGO='.$dato);
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
    }
    else
        $this->flag = false;
	return $this->flag;
}

/**
 * Retorna un combo con las opciones de la tabla sgd_etq_etiquetas.
 * 
 * @param $dato1 boolean Habilita/Deshabilita la 1a opcion SELECCIONE.
 * @param $dato2 boolean Muestra SOLO los registros activos ?.
 * @return string Cadena con el combo - False on Error.
 */
function Get_ComboOpc($dato1=true, $dato2=true)
{
    ($dato2) ? $tmp="WHERE SGD_ETQ_ESTADO=1" : $tmp = "";
	$sql = "SELECT SGD_MTD_NOMBRE AS NOMBRE,
                    SGD_MTD_CODIGO AS ID,
                    SGD_MTD_ESTADO AS ESTADO,
                    SGD_MTD_DESCRIP AS DESCRIP  
            FROM SGD_MTD_METADATOS $tmp ORDER BY 1";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->flag = false;
	else
	{
		($dato1) ? $tmp1="0:&lt;&lt;SELECCIONE&gt;&gt;" : $tmp1 = false;
		$this->flag = $rs->GetMenu('slc_etq2',false,$tmp1,false,false,"id='slc_etq2' class='select' onChange=Actual()");
		unset($rs); unset($tmp1); unset($tmp2);
	}
	return $this->flag;
}

/**
 * Retorna un vector
 * @param $cond Condicional WHERE para generar listado.
 * @return Array Vector numerico con los datos - False on error.
 */
function Get_ArrayDatos($cond=null)
{	
	$sql = "SELECT SGD_MTD_NOMBRE AS NOMBRE,
                    SGD_MTD_CODIGO AS ID,
                    SGD_MTD_ESTADO AS ESTADO,
                    SGD_MTD_DESCRIP AS DESCRIP,
                    SGD_MTD_OBLIG AS OBLIGATORIO,
                    SGD_SRD_CODIGO AS SERIE,
                    SGD_SBRD_CODIGO AS SUBSERIE,
                    SGD_TPR_CODIGO AS TDOC
            FROM SGD_MTD_METADATOS $cond ORDER BY 1";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->vector = false;
	else
	{	$it = 0;
		while (!$rs->EOF)
		{	$vdptosv[$it]['ID'] = $rs->fields['ID'];
			$vdptosv[$it]['NOMBRE'] = $rs->fields['NOMBRE'];
            $vdptosv[$it]['ESTADO'] = $rs->fields['ESTADO'];
            $vdptosv[$it]['DESCRIP'] = $rs->fields['DESCRIP'];
            $vdptosv[$it]['OBLIGATORIO'] = $rs->fields['OBLIGATORIO'];
            $vdptosv[$it]['SERIE'] = $rs->fields['SERIE'];
            $vdptosv[$it]['SUBSERIE'] = $rs->fields['SUBSERIE'];
            $vdptosv[$it]['TDOC'] = $rs->fields['TDOC'];
			$it += 1;
			$rs->MoveNext();
		}
		$rs->Close();
		$this->vector = $vdptosv;
		unset($rs); unset($sql);
	}
	return $this->vector;
}

/**
 * 
 * Actualiza o crea un registro de metadato relacionado con un radicado.
 * @param long $radicado
 * @param int $metadato
 * @param string $descripcion
 */
function setMetacado($radicado, $metadato, $descripcion) {
	if (	empty($radicado) || empty($metadato) || empty($descripcion)
		|| !is_numeric($radicado) || !is_numeric($metadato)
		)
	{
		$this->flag = false;
	} else {
		$table = "SGD_MMR_MATRIMETARADI";
		$vector['RADI_NUME_RADI'] = $radicado;
		$vector['SGD_MTD_CODIGO'] = $metadato;
		$vector['SGD_MMR_DATO'] = $descripcion;
		$this->cnn->StartTrans();
		$ok = $this->cnn->Replace(&$table,$vector, array('RADI_NUME_RADI','SGD_MTD_CODIGO'), true);
		$this->flag = $this->flag = $this->cnn->CompleteTrans();
	}
	return $this->flag;
}
}
?>