<?php
session_start();
$ruta_raiz = "../..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
if($db)
{
        //$db->conn->debug=true;
	!$expNum?($expNum= $_GET['expNum']?$_GET['expNum']:$_POST['expNum']):0;
	!$btn_accion?($btn_accion= $_GET['btn_accion']?$_GET['btn_accion']:$_POST['btn_accion']):0;
	include("$ruta_raiz/include/tx/Expediente.php");
	$expediente = new Expediente($db);
	$expediente->getExpediente($expNum);
        switch ($db->driver)
        {
                case 'postgres':
                        $fechaLimiteVencimiento=" ".$db->conn->SQLDate('Y-m-d', 'p.PRES_FECH_PRES')."::date + cast((cast(par.PARAM_VALOR as integer) + (cast(par.PARAM_VALOR as integer)/2 ))||' days' as interval) ";
                        $diasEspera=" date_part('days', ".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI)";
                    break;
                case 'oracle':
                case 'oci8':
                case 'oci805':
                case 'oci8po':
                case 'ocipo':
                      $fechaLimiteVencimiento="  (p.PRES_FECH_PRES + par.PARAM_VALOR  + (par.PARAM_VALOR /2 )) ";
                      $diasEspera= " cast((".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI)as number(3)) ";
                    break;
                case 'mssql':
                default:
                        $fechaLimiteVencimiento=" ".$db->conn->SQLDate('Y/m/d', 'p.PRES_FECH_PRES')."::date + cast((cast(par.PARAM_VALOR as integer) + (cast(par.PARAM_VALOR as integer)/2 ))||' days' as interval) ";
                break;
        }
	if ($btn_accion)
	{   
		switch($btn_accion)
		{
			case 'Renovar':
				include("$ruta_raiz/class_control/class_gen.php");
				$objFec = new CLASS_GEN();
				$regList=implode(',',array_keys($checkValue));
				$sql="select p.pres_id, p.pres_fech_renovacion1 ,p.sgd_exp_numero,$fechaLimiteVencimiento as fecLimite,par.PARAM_VALOR AS DIASVENCIMIENTO from prestamo p 
				      join sgd_parametro par on par.PARAM_NOMB='PRESTAMO_DIAS_PREST'
					  where p.pres_id in ($regList) ";
				$rs=$db->conn->Execute($sql);
				if($rs and !$rs->EOF)
				{
					while(!$rs->EOF)
					{
						$limiteVencimiento=$rs->fields['FECLIMITE'];
						$vencimiento=$objFec->suma_fechas(date('d-m-Y'),((int) $rs->fields['FECLIMITE']/2));
						$fLim=str_ireplace('-','',$limiteVencimiento);
						$fVec=str_ireplace('-','',$vencimiento);
						$fLim=(int)$fLim;
						$fVec=(int)$fVec;
						if($fVec>$fLim)$setFec=$limiteVencimiento;
						else $setFec=$vencimiento;
						$set="pres_fech_renovacion1=".$db->conn->OffsetDate(0,$db->conn->sysTimeStamp);
						$sqlUp="update prestamo set $set , pres_fech_venc='$setFec' where pres_id=".$rs->fields['PRES_ID'];
						$rsUP=$db->conn->Execute($sqlUp);
						$rs->MoveNext();
					}
					$sqlPRES_FECH_PEDI=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PEDI");
					$sqlPRES_FECH_CANC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_CANC");
                                        $sqlPRES_FECH_DEVO=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_DEVO");
					$sqlPRES_FECH_PRES=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PRES");
					$sqlPRES_FECH_VENC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_VENC");
					$sSQL="select p.PRES_ID as PRESTAMO_ID, p.SGD_EXP_NUMERO as EXPEDIENTE, carp.sgd_carpeta_numero as CARPETA, carp.sgd_carpeta_nfolios as NFOLIOS, 
				                p.USUA_LOGIN_ACTU as LOGIN, D.DEPE_NOMB as DEPENDENCIA,".$sqlPRES_FECH_PEDI." as F_SOLICITUD,".$sqlPRES_FECH_VENC." as F_VENCIMIENTO,".
				                $sqlPRES_FECH_CANC." as F_CANCELACION,".$sqlPRES_FECH_PRES." as F_PRESTAMO,".$sqlPRES_FECH_DEVO." as F_DEVOLUCION,
				                G.PARAM_VALOR as REQUERIMIENTO, E.PARAM_VALOR as ESTADO,p.PRES_ESTADO as ID_ESTADO,p.PRES_REQUERIMIENTO, $diasEspera as DIASSOL,$fechaLimiteVencimiento as feclimite
				            from
						      	 PRESTAMO p
						      	 join DEPENDENCIA D on D.DEPE_CODI=p.DEPE_CODI
						      	 join SGD_PARAMETRO E on E.PARAM_CODI=p.PRES_ESTADO
						      	 join SGD_PARAMETRO G on G.PARAM_CODI=p.PRES_REQUERIMIENTO
						      	 join sgd_parametro par on par.PARAM_NOMB='PRESTAMO_DIAS_PREST'
						      	 left join SGD_CARPETA_EXPEDIENTE carp on carp.SGD_CARPETA_ID=p.SGD_CARPETA_ID
				            where
				                p.PRES_ESTADO in (2) and
				                E.PARAM_NOMB='PRESTAMO_ESTADO' and 
					 		    G.PARAM_NOMB='PRESTAMO_REQUERIMIENTO' and
				   		 		E.PARAM_NOMB='PRESTAMO_ESTADO' and p.PRES_ID in ($regList)";
				     //$db->conn->debug=true;
				     $rs=$db->query($sSQL);
				     if($rs && !$rs->EOF)
				     {
					      $tblPrestados="<table width='100%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'>";
						  $tblPrestados.="<tr><td class='titulos2' colspan='11'>EXPEDIENTES RENOVADOS</td></tr>";
					      $tblPrestados.="<tr class='titulos3' align='center' valign='middle'>";
					      $tblPrestados.="<td><font class='titulos3'>Expediente</font></td>";	 
					      $tblPrestados.="<td><font class='titulos3'>Fecha<br>Prestamo</font></td>";	
					      $tblPrestados.="<td><font class='titulos3'>Fecha<br>Vencimiento</font></td>";	 
					      $tblPrestados.="<td><font class='titulos3'>Fecha<br>Bloqueo</font></td>";
					      $tblPrestados.="<td><font class='titulos3'>Requerimiento</font></td>";	
					      $iCounter = 0;
					         // Display result
					      while($rs && !$rs->EOF) 
					      {
					      		 $ncar="";
					             $iCounter++;		 
							     if (strcasecmp($krd,$rs->fields["LOGIN"])==0 && $rs->fields["ID_ESTADO"]==1) { 
							        $accion="<a href=\"javascript: cancelar(".$rs->fields["PRESTAMO_ID"]."); \">Cancelar Solicitud</a>";
							     }
					             if($iCounter%2==0){ $tipoListado="class=\"listado2\""; }
					             else              { $tipoListado="class=\"listado1\""; }
					             if($rs->fields["CARPETA"])$ncar=" No. ".$rs->fields["CARPETA"];
					             $tblPrestados.="<tr $tipoListado align='center'>";
					             $tblPrestados.="<td class='leidos'>".$rs->fields["EXPEDIENTE"]."</td>"; 
					             $tblPrestados.="<td class='leidos'>".$rs->fields["F_PRESTAMO"]."</td>";
					             $tblPrestados.="<td class='leidos'>".$rs->fields["F_VENCIMIENTO"]."</td>";	 
					             $tblPrestados.="<td class='leidos'>".$rs->fields["FECLIMITE"]."</td>";	 
					             $tblPrestados.="<td class='leidos'>".$rs->fields["REQUERIMIENTO"].$ncar."</td>";
					             $rs->MoveNext();   
						     }	
						    $tblPrestados.=" <tr  align='center'><td class='titulos3' colspan='11' align='center'><input type='submit' class='botones' value='Cerrar' onClick='window.close();'></td></tr></table><br>";
				        }
				}
				break;
			case 'Cancelar':
				
				break;
		}
		$selCarpetas=0;
	}

}
?>
<html>
<head>
<script language="javascript" src="../js/funciones.js"></script>
<script language="JavaScript">

</script>
<title>Orfeo - Confirmacion de Renovaci&oacute;n.</title>
<link href="<?=$ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="frmSolPrest" method="post" action="<?= $_SERVER['PHP_SELF']?>?expNum=<?=$expNum?>&krd=<?=$krd?>">
<?=$tblPrestados?>
</form>
</body>
</html>