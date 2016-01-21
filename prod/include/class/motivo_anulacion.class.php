<?php

/**
 * Clase donde gestionamos informacion referente a las Tablas Tematicas.
 *
 * @copyright Sistema de Gestion Documental ORFEO
 * @version 1.0
 * @author Desarrollado por Ing. Ivan Dario Posada para OPAIN S.A. .
 */
class motivo_anulacion {

    private $cnn; //Conexion a la BD.
    private $flag; //Bandera para usos varios
    private $vector; //Vector con los datos.

    /**
     * Constructor de la classe.
     *
     * @param ConnectionHandler $db
     */

    function __construct($db) {
        $this->cnn = $db;
        $this->cnn->SetFetchMode(ADODB_FETCH_ASSOC);
    }

    /**
     *
     * @param type $datos
     * @return type 
     */
    function SetInsDatos($datos) {
        return $this->flag;
    }

    /**
     *
     * @param type $datos
     * @return type 
     */
    function SetModDatos($datos) {
        return $this->flag;
    }

    /**
     *
     * @param type $dato 
     */
    function SetDelDatos($dato) {
        $sql = "SELECT COUNT(*) FROM SGD_ANU_ANULADOS WHERE motivo_anulacion_codigo =" . $dato;

        if ($this->cnn->GetOne($sql) > 0) {
            $this->flag = 0;
        } else {
            $this->cnn->BeginTrans();
            $ok = $this->cnn->Execute("DELETE FROM motivo_anulacion WHERE motivo_anulacion_codigo=" . $dato);
            if ($ok) {
                $this->cnn->CommitTrans();
                $this->flag = true;
            } else {
                $this->cnn->RollbackTrans();
                $this->flag = false;
            }
        }
        return $this->flag;
    }

    function Get_ComboOpc($dato1, $dato2)
    {
        $sql = "SELECT motivo_anulacion_descrip AS DESCRIP, motivo_anulacion_codigo AS ID FROM motivo_anulacion ORDER BY 1";
        $rs = $this->cnn->Execute($sql);
        if (!$rs)
            $this->flag = false;
        else {
            ($dato1) ? $tmp1 = "0:&lt;&lt;SELECCIONE&gt;&gt;" : $tmp1 = false;
            ($dato2) ? $tmp2 = "Onchange='Actual()'" : $tmp2 = '';
            $this->flag = $rs->GetMenu('slc_cmb2', false, $tmp1, false, false, "id='slc_cmb2' class='select' $tmp2");
            unset($rs);
            unset($tmp1);
            unset($tmp2);
        }
        return $this->flag;
    }
    
    
    function Get_ArrayDatos()
    {	
	$sql = "SELECT motivo_anulacion_descrip AS DESCRIP, motivo_anulacion_codigo AS ID FROM motivo_anulacion ORDER BY 1";
	$rs = $this->cnn->Execute($sql);
	if (!$rs)
		$this->vector = false;
	else
	{	$it = 0;
		while (!$rs->EOF)
		{	$vdptosv[$it]['ID'] = $rs->fields['ID'];
			$vdptosv[$it]['NOMBRE'] = $rs->fields['DESCRIP'];
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
