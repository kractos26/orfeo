<?PHP
/**
 * Clase donde gestionamos informacion referente a medios de soporte en archivo.
 *
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.0
 * @author Grupo Iyunxi Ltda
 */
class medioSoporte
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
    //$this->cnn->debug=true;
	$this->cnn->SetFetchMode(ADODB_FETCH_ASSOC);
}

/**
 * Agrega un nuevo tipo de medio de soporte en archivo.
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
        $sql = "insert into SGD_MSA_MEDSOPARCHIVO (SGD_MSA_CODIGO, SGD_MSA_DESCRIP, SGD_MSA_ESTADO, SGD_MSA_SIGLA) ";
        $sql.= "values (".$datos['txtCodId'].",'".$datos['txtModelo']."',".$datos['slcEstado'].",'".$datos['txtSigla']."')";
        $this->flag = $this->cnn->Execute($sql);
        
    }
	return $this->flag;
}

/**
 * Modifica datos a un tipo de medio de soporte en archivo.
 *
 * @param array $datos  Vector asociativo con todos los campos y sus valores.
 * @return boolean $flag False on Error /
 */
function SetModDatos($datos)
{	//$this->cnn->debug=true;
    if ( count($datos) !=4 || !is_int((integer)$datos['txtId']) ||
        !is_int((integer)$datos['slcEstado']) || strlen($datos['txtModelo']>30) )
        $this->flag = false;
    else
    {
        $sql =  "update SGD_MSA_MEDSOPARCHIVO set SGD_MSA_DESCRIP = '".$datos['txtModelo']."', ";
		$sql.=  "SGD_MSA_ESTADO = ".$datos['slcEstado'].", SGD_MSA_SIGLA = '".$datos['txtSigla'].
                "' where SGD_MSA_CODIGO=".$datos['txtId'];
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
            $ok = $this->cnn->Execute('DELETE FROM SGD_MSA_MEDSOPARCHIVO WHERE SGD_MSA_CODIGO='.$dato);
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
 * @param $dato2 boolean Muestra SOLO los registros activos?.
 * @param $opcDefault string. Opcion por defecto seleccionada. Default false.
 * @param $atributos opciones adicionales de la etiqueta select
 * @return string Cadena con el combo - False on Error.
 */
function Get_ComboOpc($dato1=true, $dato2=true,$opcDefault=false, $atributos=false)
{
    ($dato2) ? $tmp="" : $tmp = "WHERE SGD_MSA_ESTADO=1";
	$sql = "SELECT SGD_MSA_DESCRIP AS DESCRIP,
                    SGD_MSA_CODIGO AS ID,
                    SGD_MSA_ESTADO AS ESTADO 
            FROM SGD_MSA_MEDSOPARCHIVO $tmp ORDER BY 1";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->flag = false;
	else
	{   $opc = ($opcDefault) ? $opcDefault : 0 ;
		($dato1) ? $tmp1="0:&lt;&lt;Seleccione&gt;&gt;" : $tmp1 = false;
		$this->flag = $rs->GetMenu2('slc_cmb2',$opc,$tmp1,false,false,"id='slc_cmb2' class='select' $atributos");
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
	$sql = "SELECT SGD_MSA_DESCRIP AS DESCRIP,
                    SGD_MSA_CODIGO AS ID,
                    SGD_MSA_ESTADO AS ESTADO,
                    SGD_MSA_SIGLA  AS SIGLA
            FROM SGD_MSA_MEDSOPARCHIVO ORDER BY 1";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->vector = false;
	else
	{	$it = 0;
		while (!$rs->EOF)
		{	$vdptosv[$it]['ID'] = $rs->fields['ID'];
			$vdptosv[$it]['NOMBRE'] = $rs->fields['DESCRIP'];
            $vdptosv[$it]['ESTADO'] = $rs->fields['ESTADO'];
            $vdptosv[$it]['SIGLA'] = $rs->fields['SIGLA'];
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