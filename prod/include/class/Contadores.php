<?php
/**
 * Realiza conteos de radicados.
 */
class Contadores 
{
	var $cursor;
	var $dr;	//guarda el complemento del query para validacion de dias restantes.
	/**
	 * Constructor de la clase.
	 *
	 * @param ConnectionHandler $db
	 * @return Contadores
	 */
	function Contadores($db) 
	{
            
		$this->cursor = $db;
                //$this->cursor->conn->debug=true;
		switch ($this->cursor->driver)
		{
                        case 'postgres':
                                $this->fechaLimiteVencimientoExp=" ".$this->cursor->conn->SQLDate('Y/m/d', 'p.PRES_FECH_PRES')."::date + cast((cast(par.PARAM_VALOR as integer) + (cast(par.PARAM_VALOR as integer)/2 ))||' days' as interval) ";
//                                $this->dr = " diashabiles((sumadiashabiles(cast(radi_fech_radi as date),c.sgd_tpr_termino)),cast(".$this->cursor->conn->sysTimeStamp." as date))";
                                $this->dr = " diashabiles((sumadiashabiles(radi_fech_radi, c.sgd_tpr_termino)),".$this->cursor->conn->sysTimeStamp.")";
                            break;
			case 'oracle':
			case 'oci8':
                        case 'oci8po':
			case 'oci805':
			case 'ocipo':
                            $this->fechaLimiteVencimientoExp="  (p.PRES_FECH_PRES + par.PARAM_VALOR  + (par.PARAM_VALOR /2 )) ";
                            $this->dr = " diashabiles((sumadiashabiles(cast(radi_fech_radi as date),c.sgd_tpr_termino)),cast(".$this->cursor->conn->sysTimeStamp." as date))";
                            break;
                        case 'mssql':
			default:
                            $this->dr = " diashabiles((sumadiashabiles(cast(radi_fech_radi as date),c.sgd_tpr_termino)),cast(".$this->cursor->conn->sysTimeStamp." as date))";
			break;
		}
		
	}
	
	/**
	 * Retorna el numero de radicados que se vencen el dia de "hoy".
	 *
	 * @param unknown_type $codDepe
	 * @return unknown
	 */
	function getContadorJefe($codDepe)
	{
		$query = "SELECT COUNT(radi_nume_radi) as CONTADOR FROM RADICADO r INNER JOIN SGD_TPR_TPDCUMENTO c ON c.SGD_TPR_CODIGO = r.TDOC_CODI ";
		$query.= "WHERE r.radi_depe_actu=$codDepe  and ".$this->dr." = 0";
		$rs=$this->cursor->query($query);
		$retorno = 0;
		if  (!$rs->EOF)
		{
			$retorno=$rs->fields["CONTADOR"];
		}
		return ($retorno);
	}

	function getContador($codDepe, $codusuario, $numdias)
	{
		$query = "SELECT COUNT(radi_nume_radi) as CONTADOR FROM RADICADO r INNER JOIN SGD_TPR_TPDCUMENTO c On c.SGD_TPR_CODIGO = r.TDOC_CODI ";
		$query.= "Where r.RADI_DEPE_ACTU = $codDepe and RADI_USUA_ACTU = $codusuario  and ".$this->dr." = $numdias";
		$rs=$this->cursor->query($query);
		$retorno = 0;
		if  (!$rs->EOF)
		{
			$retorno=$rs->fields["CONTADOR"];
		}
		return ($retorno);
	}
	
	/**
	 * Retorna la cantidad de radicados a vencer en 2, 1 y el dia de consulta.
	 *
	 * @param integer $codDepe
	 * @param integer $codusuario
	 * @return integer $retorno
	 */
	function getContadorRad($codDepe, $codusuario)
	{
		$query = "SELECT COUNT(radi_nume_radi) as CONTADOR FROM RADICADO r INNER JOIN SGD_TPR_TPDCUMENTO c On c.SGD_TPR_CODIGO = r.TDOC_CODI ";
		$query.= "Where r.RADI_DEPE_ACTU = $codDepe and (".$this->dr." = 0 or ".$this->dr." = 1 or ".$this->dr." = 2) and RADI_USUA_ACTU = $codusuario ";
		$rs=$this->cursor->query($query);
		$retorno = 0;
		if  (!$rs->EOF)
		{
			$retorno=$rs->fields["CONTADOR"];
		}
		return ($retorno);
	}
	
	function getRadicados($codDepe, $codusuario, $numdias)
	{
		$query = "Select r.radi_nume_radi From RADICADO r Inner Join SGD_TPR_TPDCUMENTO c On c.SGD_TPR_CODIGO = r.TDOC_CODI ";
		$query.= "Where r.RADI_DEPE_ACTU = $codDepe and RADI_USUA_ACTU = $codusuario  and ".$this->dr." = $numdias ";
		$rs = $this->cursor->query($query);
		$retorno = array();
		if  (!$rs->EOF)
		{
			$i = 0;
			while ( $arr = $rs->fetchRow() )
			{
				$retorno[$i] = $arr["RADI_NUME_RADI"];
				$i++;
			}
		}
		return ($retorno);
	}
	
	function getRadicadosJefe($codDepe)
	{
		$query = "Select r.radi_nume_radi From RADICADO r Inner Join SGD_TPR_TPDCUMENTO c On c.SGD_TPR_CODIGO = r.TDOC_CODI ";
		$query.= "where r.RADI_DEPE_ACTU = $codDepe  and ".$this->dr." = 0 ";
		$rs = $this->cursor->query($query);
		$retorno = array();
		if  (!$rs->EOF)
		{
			$i = 0;
			while ( $arr = $rs->fetchRow() )
			{
				$retorno[$i] = $arr["RADI_NUME_RADI"];
				$i++;
			}
		}
		return ($retorno);
	}
	
	function getExpPresVencidos($krd,$estado)
	{
		
		if($estado==0)
		{
			$whereFec=" and ".$this->cursor->conn->sysTimeStamp." between p.PRES_FECH_VENC and  $this->fechaLimiteVencimientoExp ";
		}
		else if ($estado==1)
		{
			$whereFec=" and ".$this->cursor->conn->sysTimeStamp." > $this->fechaLimiteVencimientoExp ";
		}
		$query = "SELECT p.PRES_ID,".$this->cursor->conn->SQLDate('Y/m/d', 'p.PRES_FECH_VENC')." AS VENCIMIENTO, CASE p.PRES_REQUERIMIENTO WHEN 1 THEN 'DOCUMENTO DEL RADICADO No: '|| p.RADI_NUME_RADI WHEN 2 THEN 'ANEXO DEL RADICADO No: '|| p.RADI_NUME_RADI WHEN 3 THEN 'ANEXO Y DOCUMENTO DEL RADICADO No: '|| p.RADI_NUME_RADI WHEN 4 THEN 'EXPEDIENTE COMPLETO No: '|| p.SGD_EXP_NUMERO  WHEN 5 THEN 'No EXPEDIENTE: '|| p.SGD_EXP_NUMERO || ' CARPETA No:'||car.SGD_CARPETA_NUMERO END as OBJETO
				  FROM PRESTAMO p 
				  LEFT JOIN SGD_CARPETA_EXPEDIENTE car ON car.SGD_CARPETA_ID=p.SGD_CARPETA_ID 
				  JOIN SGD_PARAMETRO par ON par.PARAM_NOMB='PRESTAMO_DIAS_PREST'
				  WHERE p.USUA_LOGIN_ACTU='$krd' and p.PRES_ESTADO = 2 $whereFec";
		$rs = $this->cursor->query($query);
		$retorno = array();
		if($rs && !$rs->EOF)
		{
			$i = 0;
			while ( $arr = $rs->fetchRow() )
			{
				$retorno[$i]["PRES_ID"] = $arr["PRES_ID"];
				$retorno[$i]["OBJETO"] = $arr["OBJETO"];
				$retorno[$i]["VENCIMIENTO"] = $arr["VENCIMIENTO"];
				$i++;
			}
		}
		return ($retorno);
	}
	

	
}