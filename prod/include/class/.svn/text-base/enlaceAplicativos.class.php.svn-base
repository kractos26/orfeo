<?PHP
/**
 * Clase donde gestionamos informacion referente a los aplicativos que enlazan
 * con Orfeo.
 *
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.0
 * @author Grupo Iyunxi Ltda
 */
class enlaceAplicativos
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
 * Agrega un nuevo tipo de aplicativo.
 *
 * @param array $datos  Vector asociativo con todos los campos y sus valores.
 * @return boolean $flag False on Error /
 */
function SetInsDatos($datos)
{
    if ( count($datos) !=4 || !is_int((integer)$datos['txtId']) ||
        !is_int((integer)$datos['slcEstado']) || strlen($datos['txtModelo']>30) )
        $this->flag = false;
    else
    {
        $sql = "insert into SGD_APLICACIONES (SGD_APLI_CODIGO, SGD_APLI_DESCRIP, SGD_APLI_ESTADO, SGD_APLI_DEPE) ";
        $sql.= "values (".$datos['txtId'].",'".$datos['txtModelo']."',".$datos['slcEstado'].",".$datos['slcDepe'].")";
        $this->flag = $this->cnn->Execute($sql);
    }
	return $this->flag;
}

/**
 * Modifica datos a un tipo de aplicativo.
 *
 * @param array $datos  Vector asociativo con todos los campos y sus valores.
 * @return boolean $flag False on Error /
 */
function SetModDatos($datos)
{	
    if ( count($datos) !=4 || !is_int((integer)$datos['txtId']) ||
        !is_int((integer)$datos['slcEstado']) || strlen($datos['txtModelo']>30) )
        $this->flag = false;
    else
    {
        $sql =  "update SGD_APLICACIONES set SGD_APLI_DESCRIP = '".$datos['txtModelo']."', ";
		$sql.=  "SGD_APLI_ESTADO = ".$datos['slcEstado'].",SGD_APLI_DEPE = ".$datos['slcDepe'].
                " where SGD_APLI_CODIGO=".$datos['txtId'];
        $this->flag = $this->cnn->Execute($sql);
    }
	return $this->flag;
}

/**
 * Elimina un aplicativo, siempre y cuando no haya asociaciones a él.
 *
 * @param  int $dato  Id del causal a eliminar.
 * @return boolean $flag False on Error /
 */
function SetDelDatos($dato)
{
    if (is_int((integer)$dato))
    {
        $sql = "SELECT COUNT(*) FROM RADICADO WHERE SGD_APLI_CODIGO = $dato";
        if ($this->cnn->GetOne($sql) > 0)
        {
            $this->flag = false;
        }
        else
        {
            $this->cnn->BeginTrans();
            $ok = $this->cnn->Execute('DELETE FROM SGD_APLICACIONES WHERE SGD_APLI_CODIGO='.$dato);
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
 * Retorna un combo con las opciones de la tabla enlaceAplicativos.
 * 
 * @param $dato1 boolean Habilita/Deshabilita la 1a opcion SELECCIONE.
 * @param $dato2 boolean Muestra SOLO los registros activos ?.
 * @return string Cadena con el combo - False on Error.
 */
function Get_ComboOpc($dato1=true, $dato2=true)
{
    ($dato2) ? $tmp="WHERE SGD_APLI_ESTADO=1" : $tmp = "";
	$sql = "SELECT SGD_APLI_DESCRIP AS DESCRIP,
                    SGD_APLI_CODIGO AS ID,
                    SGD_APLI_ESTADO AS ESTADO,
                    SGD_APLI_DEPE AS DEPENDENCIA 
            FROM SGD_APLICACIONES $tmp ORDER BY 1";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->flag = false;
	else
	{
		($dato1) ? $tmp1="0:&lt;&lt;SELECCIONE&gt;&gt;" : $tmp1 = false;
		$this->flag = $rs->GetMenu('slc_cmb2',false,$tmp1,false,false,"id='slc_cmb2' class='select' onChange=Actual()");
		unset($rs); unset($tmp1); unset($tmp2);
	}
	return $this->flag;
}

/**
 * Retorna un vector
 *
 * @return Array Vector numerico con los datos - False on error.
 */
function Get_ArrayDatos()
{	
	$sql = "SELECT SGD_APLI_DESCRIP AS DESCRIP,
                    SGD_APLI_CODIGO AS ID,
                    SGD_APLI_ESTADO AS ESTADO,
                    SGD_APLI_DEPE AS DEPENDENCIA 
            FROM SGD_APLICACIONES ORDER BY 1";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->vector = false;
	else
	{	$it = 0;
		while (!$rs->EOF)
		{	$vdptosv[$it]['ID'] = $rs->fields['ID'];
			$vdptosv[$it]['NOMBRE'] = $rs->fields['DESCRIP'];
            $vdptosv[$it]['ESTADO'] = $rs->fields['ESTADO'];
            $vdptosv[$it]['DEPENDENCIA'] = $rs->fields['DEPENDENCIA'];
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