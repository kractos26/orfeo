<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Motivo_modificacion
 *
 * @author opain
 */
class Motivo_modificacion {
    private $cnn; //Conexion a la BD.
    private $flag; //Bandera para usos varios
    private $vector; //Vector con los datos.
    
    function __construct($db) {
        $this->cnn = $db;
        $this->cnn->SetFetchMode(ADODB_FETCH_ASSOC);
    }
    
    function SetInsDatos($datos) {
        return $this->flag;
    }
    
    function SetDelDatos($dato) {
        $sql = "SELECT COUNT(*) FROM motivo_modificacion WHERE motivo_modificacion_codigo =" . $dato;

        if ($this->cnn->GetOne($sql) > 0) {
            $this->cnn->BeginTrans();
            $ok = $this->cnn->Execute("DELETE FROM motivo_modificacion WHERE motivo_modificacion_codigo=" . $dato);
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
        $sql = "SELECT motivo_modificacion_descrip AS DESCRIP, motivo_modificacion_codigo AS ID FROM motivo_modificacion ORDER BY 1";
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
	$sql = "SELECT motivo_modificacion_descrip AS DESCRIP, motivo_modificacion_codigo AS ID FROM motivo_modificacion ORDER BY 1";
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
