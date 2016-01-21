<?php
session_start();
$ruta_raiz = "../..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
if($db)
{	//$db->conn->debug=true;
	!$expNum?($expNum= $_GET['expNum']?$_GET['expNum']:$_POST['expNum']):0;
	!$btn_accion?($btn_accion= $_GET['btn_accion']?$_GET['btn_accion']:$_POST['btn_accion']):0;

        switch($db->driver)
        {
                case 'postgres':
                                $fechaLimiteVencimiento=" ".$db->conn->SQLDate('Y/m/d', 'p.PRES_FECH_PRES')."::date + cast((cast(par.PARAM_VALOR as integer) + (cast(par.PARAM_VALOR as integer)/2 ))||' days' as interval) ";
                        break;
                case 'oci8':
                case 'oci8po':
                                $fechaLimiteVencimiento="  (p.PRES_FECH_PRES + par.PARAM_VALOR  + (par.PARAM_VALOR /2 )) ";
                        break;
                default:

        }
	
	$whereFec=" and ".$db->conn->sysTimeStamp." > $fechaLimiteVencimiento ";
	$query = "SELECT p.PRES_ID,".$db->conn->SQLDate('Y/m/d', 'p.PRES_FECH_VENC')." AS VENCIMIENTO, CASE p.PRES_REQUERIMIENTO WHEN 4 THEN 'EXPEDIENTE COMPLETO No: '|| p.SGD_EXP_NUMERO  WHEN 5 THEN 'No EXPEDIENTE: '|| p.SGD_EXP_NUMERO || ' CARPETA No:'||car.SGD_CARPETA_NUMERO END as OBJETO
				  FROM PRESTAMO p 
				  LEFT JOIN SGD_CARPETA_EXPEDIENTE car ON car.SGD_CARPETA_ID=p.SGD_CARPETA_ID 
				  JOIN SGD_PARAMETRO par ON par.PARAM_NOMB='PRESTAMO_DIAS_PREST'
				  WHERE p.USUA_LOGIN_ACTU='$krd' and p.PRES_ESTADO = 2  $whereFec";
	$rsVerif = $db->conn->Execute($query);
	if($rsVerif && !$rsVerif->EOF)
	{
		$tblSinPermiso="<html>
                              <head><title>Seguridad Expediente</title><link href='$ruta_raiz/estilos/orfeo.css' rel='stylesheet' type='text/css'>
                              <script language='JavaScript'>
								function regresar()
								{
									window.document.frmSolPrest.action = window.document.frmSolPrest.frmAnt.value+'?numExpediente=$expNum&numExpActual=$expNum&verrad=$verrad';
									window.document.frmSolPrest.submit();
								}
							  </script>
                              </head>
                              <body>
                              <form name='frmSolPrest' method='post' action='".$_SERVER['PHP_SELF']."?expNum=$expNum&krd=$krd'>
                              <input type='hidden' name='frmAnt' value='$frmAnt'>
                              <table border=0 width=100% align='center' class='borde_tab' cellspacing='0'>
                              <tr align='center' class='titulos2'>
                                <td height='15' class='titulos2'>!! PR&Eacute;STAMO VENCIDO !!</td>
                              </tr>
                              <tr >
                                  <td width='38%' class=listado5 ><center><p><font class='no_leidos'>NO TIENE PERMISOS PARA ACCEDER AL PR&Eacute;STAMO DEL EXPEDIENTE No. $expNum,<br>Ya que Actualmente tiene expedientes en pr&eacute;stamo cuya fecha de devoluci&oacute;n se encuentra vencida. Por favor realice la devoluci&oacute;n de los expedientes para acceder nuevamente a los servicios de pr&eacute;stamo.</font></p></center></td>
                              </tr>
                              <tr >
                                     <td height='15' class='titulos2'><center><input name='btn_accion' type='button' class='botones' id='btn_accion' value='Regresar' onClick='regresar();'></center></td>
                               </tr>
                               </table>
                               </form>
                               </body>
                               </html>";
		die($tblSinPermiso);
	}
	include("$ruta_raiz/include/tx/Expediente.php");
	$expediente = new Expediente($db);
	$expediente->getExpediente($expNum);
	if ($btn_accion)
	{   
		switch($btn_accion)
		{
			case 'Solicitar':
				if($_POST['slcTipo']==4)
				{	
					$sqlVerif="select * from prestamo where SGD_EXP_NUMERO='$expNum' and PRES_ESTADO=1";
					$rsVerif=$db->conn->Execute($sqlVerif);
					if($rsVerif and $rsVerif->EOF)
					{
						$sec=$db->conn->nextId('SEC_PRESTAMO');
						$sSQL = "insert into PRESTAMO(PRES_ID,SGD_EXP_NUMERO, USUA_LOGIN_ACTU, DEPE_CODI, PRES_FECH_PEDI, PRES_DEPE_ARCH, PRES_ESTADO,PRES_REQUERIMIENTO) values ". 
						$sSQL.= "($sec, '$expNum', '$krd',$dependencia	,".$db->conn->OffsetDate(0,$db->conn->sysTimeStamp).",'".$expediente->depCodi."',1,	".$_POST['slcTipo'].")";	  
		      			$rsIns=$db->conn->Execute($sSQL);
					}
				} 
				if($_POST['slcTipo']==5)
				{
					foreach($_POST['checkValue'] as $i=>$val)
					{
						$sqlVerif="select * from prestamo where SGD_CARPETA_ID=$val and PRES_ESTADO=1";
						$rsVerif=$db->conn->Execute($sqlVerif);
						if($rsVerif and $rsVerif->EOF)
						{
							$sec=$db->conn->nextId('SEC_PRESTAMO');
							$sSQL = "insert into PRESTAMO(PRES_ID,SGD_EXP_NUMERO,SGD_CARPETA_ID, USUA_LOGIN_ACTU, DEPE_CODI, PRES_FECH_PEDI, PRES_DEPE_ARCH, PRES_ESTADO,PRES_REQUERIMIENTO) values ". 
							$sSQL.= "($sec, '$expNum',$val, '$krd',$dependencia	,".$db->conn->OffsetDate(0,$db->conn->sysTimeStamp).",'".$expediente->depCodi."',1,	".$_POST['slcTipo'].")";	  
			      			$rsIns=$db->conn->Execute($sSQL);
			      			$sSQL="";
						}
					}
				} 
				break;
			case 'Cancelar':
				
					$sqlUp="update prestamo set pres_fech_canc= ".$db->conn->OffsetDate(0,$db->conn->sysTimeStamp).", usua_login_canc='$krd', pres_estado=4, canc_desc='Solicitud cancelada por el usuario solicitante' where pres_id=$idPrest";
					$rsup=$db->conn->Execute($sqlUp);
					
				break;
		}
		$selCarpetas=0;
	}
	
	$sqlPRES_FECH_PEDI=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PEDI");
	$sqlPRES_FECH_CANC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_CANC");
    $sqlPRES_FECH_DEVO=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_DEVO");
	$sqlPRES_FECH_PRES=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PRES");
	$sqlPRES_FECH_VENC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_VENC");
	$sSQL="select p.PRES_ID as PRESTAMO_ID, p.SGD_EXP_NUMERO as EXPEDIENTE, carp.sgd_carpeta_numero as CARPETA,
                p.USUA_LOGIN_ACTU as LOGIN, D.DEPE_NOMB as DEPENDENCIA,".$sqlPRES_FECH_PEDI." as F_SOLICITUD,".$sqlPRES_FECH_VENC." as F_VENCIMIENTO,".
                $sqlPRES_FECH_CANC." as F_CANCELACION,".$sqlPRES_FECH_PRES." as F_PRESTAMO,".$sqlPRES_FECH_DEVO." as F_DEVOLUCION,
                G.PARAM_VALOR as REQUERIMIENTO, E.PARAM_VALOR as ESTADO,p.PRES_ESTADO as ID_ESTADO,p.PRES_REQUERIMIENTO, u.USUA_NOMB
                ,ncar.cantidad as cantidadCarpetas
            from
		      	 PRESTAMO p
		      	 join DEPENDENCIA D on D.DEPE_CODI=p.DEPE_CODI
		      	 join SGD_PARAMETRO E on E.PARAM_CODI=p.PRES_ESTADO
		      	 join SGD_PARAMETRO G on G.PARAM_CODI=p.PRES_REQUERIMIENTO
		      	 left join SGD_CARPETA_EXPEDIENTE carp on carp.SGD_CARPETA_ID=p.SGD_CARPETA_ID
		      	 join USUARIO u ON u.USUA_LOGIN=p.USUA_LOGIN_ACTU
		      	 join (select sgd_exp_numero, count(*) as cantidad from sgd_carpeta_expediente  group by sgd_exp_numero) ncar on ncar.sgd_exp_numero=p.sgd_exp_numero
            where
		 		p.SGD_EXP_NUMERO='$expNum' and 
                p.PRES_ESTADO in (1,2,5) and
   		 		E.PARAM_NOMB='PRESTAMO_ESTADO' and 
		 		G.PARAM_NOMB='PRESTAMO_REQUERIMIENTO' ";
     //$db->conn->debug=true;
     $rs=$db->query($sSQL);
     if($rs && !$rs->EOF)
     {
	     /****************************/
	      $tblPrestados="<table width='100%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'>";
	      $tblPrestados.="<tr><td class='titulos2' colspan='9'>Estado de Reservas Vigentes<font class='menu_princ'> Expediente No: $expNum</font></td></tr>";
	      $tblPrestados.="<tr class='titulos3' align='center' valign='middle'>";
	      $tblPrestados.="<td><font class='titulos3'>Expediente</font></td>";	 
	      $tblPrestados.="<td><font class=titulos3'>Login</font></td>";	 
	      $tblPrestados.="<td><font class=titulos3'>Nombre</font></td>";
	      $tblPrestados.="<td><font class='titulos3'>Dependencia</font></td>";		 
	      $tblPrestados.="<td><font class=titulos3>Fecha<br>Solicitud</font></td>";	 
	      $tblPrestados.="<td><font class='titulos3'>Fecha<br>Vencimiento</font></td>";		 
	      $tblPrestados.="<td><font class='titulos3'>Requerimiento</font></td>";		 						
	      $tblPrestados.="<td><font class='titulos3'>Estado</font></td>";		 
	      $tblPrestados.="<td><font class='titulos3'>Accion</font></td></tr>";		 
	      $iCounter = 0;
	         // Display result
	      while($rs && !$rs->EOF) 
	      {
	      		 $ncar="";
	             $iCounter++;
	             $accion="";		 
			     if (strcasecmp($krd,$rs->fields["LOGIN"])==0 && $rs->fields["ID_ESTADO"]==1) { 
			        $accion="<a href=\"javascript: cancelar(".$rs->fields["PRESTAMO_ID"]."); \">Cancelar Solicitud</a>";
			     }
	             if($iCounter%2==0){ $tipoListado="class=\"listado2\""; }
	             else              { $tipoListado="class=\"listado1\""; }
	             if($rs->fields["CARPETA"])$ncar=" No. ".$rs->fields["CARPETA"];
	             else $ncar=" con ".$rs->fields["CANTIDADCARPETAS"]." Carpetas";
	             $tblPrestados.="<tr $tipoListado align='center'>";
	             $tblPrestados.="<td class='leidos'>".$rs->fields["EXPEDIENTE"]."</td>"; 
	             $tblPrestados.="<td class='leidos'>".$rs->fields["LOGIN"]."</td>";	 
	             $tblPrestados.="<td class='leidos'><font color=red>Solicitado por:".$rs->fields["USUA_NOMB"]."</font></td>";	 
	             $tblPrestados.="<td class='leidos'>".$rs->fields["DEPENDENCIA"]."</td>"; 
	             $tblPrestados.="<td class='leidos'>".$rs->fields["F_SOLICITUD"]."</td>";
	             $tblPrestados.="<td class='leidos'>".$rs->fields["F_VENCIMIENTO"]."</td>";	 
	             $tblPrestados.="<td class='leidos'>".$rs->fields["REQUERIMIENTO"].$ncar."</td>";	 						
	             $tblPrestados.="<td class='leidos'>".$rs->fields["ESTADO"]."</td>";	 
	             $tblPrestados.="<td class='leidos'>".$accion."</td></tr>";	 
	             $tipoReq=$rs->fields["PRES_REQUERIMIENTO"];
	             $rs->MoveNext();
		     }	
		    $tblPrestados.=" <tr  align='center'><td class='titulos3' colspan='9' align='center'><input type='submit' class='botones' value='Finalizar' onClick='regresar();'></td></tr></table><br>";
		    
     }
     /**
      * se genera la tabla con las carpetas disponibles del expediente
      */
	$sqlTbl="select ce.*
			 from sgd_carpeta_expediente ce
			 join sgd_sexp_secexpedientes exp on exp.sgd_exp_numero=ce.sgd_exp_numero
			 where ce.sgd_exp_numero='$expNum'  and ce.sgd_carpeta_id not in (select sgd_carpeta_id from prestamo where sgd_exp_numero='$expNum' and pres_estado in (1,2,5))
			order by sgd_carpeta_csc ";
	//$db->conn->debug=true;
	($rsTbl=$db->conn->Execute($sqlTbl)) ? $error = $error : $error = 8;
	if($rsTbl && !$rsTbl->EOF)
	{
		$contCarp=0;
		$colspan=6;
		$v = "<br><input name='checkAll' value='checkAll' onclick='markAll();'  type='checkbox'>";
		if($rsTbl->fields['SGD_SEXP_TIPOEXP']==2)$colspan=7;
		$tblCpr="<span id='tblCarp' style='display:none'><table width='100%' border=0 cellpadding=0 cellspacing=2 class='borde_tab''><tr><td colspan='$colspan' class='titulos2'><center>Carpetas Disponibles</center></td></tr>";
		$tblCpr.="<tr><td class='titulos2' align='center'>No. Consecutivo</td>";
		if($rsTbl->fields['SGD_SEXP_TIPOEXP']==2)$tblCpr.="<td class='titulos2' align='center'>Tipo Carpeta</td>";
		$tblCpr.="<td class='titulos2' align='center'>Descripci&oacute;n y/o Contenido</td><td class='titulos2' align='center'>No. Carpeta</td><td class='titulos2' align='center'>No. Folios</td><td class='titulos2' align='center'>No. Caja</td><td class='titulos2'>$v</td>";
		while(!$rsTbl->EOF)
		{
			$v = "<input name='checkValue[".$rsTbl->fields['SGD_CARPETA_ID']."]' value='".$rsTbl->fields['SGD_CARPETA_ID']."'  type='checkbox'>";
			$tblCpr.="<tr><td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_CSC']."</center></td>";
			if($rsTbl->fields['SGD_SEXP_TIPOEXP']==2)$tblCpr.="<td class='listado2'>".$rsTbl->fields['SGD_TIPO_CARPDESCRIP']."</td>";
			$tblCpr.="<td class='listado2'>".$rsTbl->fields['SGD_CARPETA_DESCRIPCION']."</td>";
			$tblCpr.="<td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_NUMERO']."</center></td>";
			$tblCpr.="<td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_NFOLIOS']."</center></td>";
			$tblCpr.="<td class='listado2'><center>".$rsTbl->fields['SGD_CARPETA_CAJA']."</center></td>";
            $tblCpr.="<td class='listado2'>$v</td></tr>";
            $rsTbl->MoveNext();
            $contCarp++;
		}
		$tblCpr.="</table><span><br>";
	}
	else $tblCpr="<span id='tblCarp' style='display:none'><table width='100%' border=0 cellpadding=0 cellspacing=2 class='borde_tab''><tr><td class='listado2'><center><font color='red' size='2'>El Expediente No tiene Carpetas creadas</font></center></td></tr></table></span>";

     //$arrTipExp=array('4'=>"Expediente Completo",'5'=>"Por Carpetas");
     if($iCounter && $tipoReq==5)$arrTipExp[5]="Por Carpetas";
     else $arrTipExp=array('4'=>"Expediente Completo",'5'=>"Por Carpetas");
     $slcTpExp="<select name='slcTipo' id='slcTipo' class='select' onChange=\"muestra();\">";
     //!$_POST['slcTipo']?$est='selected':$est='';
     $slcTpExp.="<option value=0 selected >Seleccione</option>";
     foreach($arrTipExp as $j=>$value)
     {
         //$slcTipo==$j?$est='selected':$est='';
	 	 $slcTpExp.="<option value=$j $est >$value</option>";
      }
     $slcTpExp.="</select>";
     
     $sqlDiasVenc="select param_valor from SGD_PARAMETRO where PARAM_NOMB='PRESTAMO_DIAS_PREST'";
     $rsDiasVenc=$db->conn->Execute($sqlDiasVenc);
     if($rsDiasVenc && !$rsDiasVenc->EOF)$diasVenc=$rsDiasVenc->fields['PARAM_VALOR'];
}



if ($error)
{	$msg = '<tr bordercolor="#FFFFFF">
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
	switch ($error)
	{	case 1:	
				$msg .= "";
				break;
	}
	$msg .=  '</td></tr>';
}
?>
<html>
<head>
<script language="javascript" src="../js/funciones.js"></script>
<script language="JavaScript">
function regresar()
{
	window.document.frmSolPrest.action = window.document.frmSolPrest.frmAnt.value+'?numExpediente=<?=$expNum?>&numExpActual=<?=$expNum?>&verrad=<?=$verrad?>';
	window.document.frmSolPrest.submit();
}
function markAll()
{
	if(document.frmSolPrest.elements['checkAll'].checked)
	{
		for(i=1;i<document.frmSolPrest.elements.length;i++)
		{
			if(document.frmSolPrest.elements[i].name.slice(0, 10)=='checkValue')
			{
				document.frmSolPrest.elements[i].checked=true;
			}
		}
	}
	else
		for(i=1;i<document.frmSolPrest.elements.length;i++)
		document.frmSolPrest.elements[i].checked=0;
}

function muestra()
{
	if( document.getElementById("tblCarp"))
	{   
	      ver = document.getElementById("tblCarp");
	      ver.style.display = "none";
	      if(document.getElementById("slcTipo").value==5){ 
	         ver.style.display = "";
	          
	      }
	} 
}
function validar()
{
	var msg='';
	var band=false;
	if(document.getElementById("slcTipo").value==5)
	{
		marcados = 0;
		for(i=0;i<document.frmSolPrest.elements.length;i++)
		{	
			if(document.frmSolPrest.elements[i].checked==1 )
			{
				if(document.frmSolPrest.elements[i].name!='checkAll')marcados++;
	        }
	        
	    }
	    if(marcados)band= true;
	    else 
	    {	msg='Debe seleccionar una carpeta\n';
	    	band= false;
	    }
	}
	if(document.getElementById("slcTipo").value==0)
	{
		msg +='Debe seleccionar el Requerimiento\n';
	    band=false;
	}
	if(msg) alert(msg);
	else
	{
		if(!confirm('Los pr\xE9stamos de los expedientes se har\xE1n por <?=$diasVenc?> d\xEDas calendario y podr\xE1n ser renovados por <?=((int) ($diasVenc/2))?>  d\xEDas  m\xE1s. Cumplido este tiempo el usuario deber\xE1 hacer entrega de los documentos f\xEDsicos al archivo; de lo contrario el sistema bloquear\xE1 su usuario para solicitar un nuevo pr\xE9stamo.'))
		{
			band=false;
		}
		else band=true;
	}
	return band;
	
}
function cancelar(id)
{
	window.document.frmSolPrest.action +='&btn_accion=Cancelar&idPrest='+id;
	window.document.frmSolPrest.submit();
}
</script>
<title>Orfeo - Solicitud de Pr&eacute;stamos.</title>
<link href="<?=$ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="frmSolPrest" method="post" action="<?= $_SERVER['PHP_SELF']?>?expNum=<?=$expNum?>&krd=<?=$krd?>">
<input type="hidden" name="frmAnt" value="<?=$frmAnt?>">
<input type="hidden" name="verrad" value="<?=$verrad?>">
<input type="hidden" name="expNum" id="expNum" value="<?=$expNum?>">

<?echo $tblPrestados;
if($contCarp){?>
<table class="borde_tab" width='100%'>
  <tr>
      <td class="titulos2" colspan="4"><center>RESERVAR</center></td>
  </tr>
  <tr>
     <td class='titulos2'>Expediente</td>
     <td class='listado2'><?=$expNum?></td>
	 <td class='titulos2'>Login</td>
	 <td class='listado2'><?=$krd?></td>
  </tr>
  <tr>
  	  <td class='titulos2'>Fecha Pedido</td>						
	  <td class='listado2'><?=Date("d-m-Y")?></td>
	  <td class='titulos2'>Dependencia</td>
	  <td class='listado2'><?=$_SESSION["depe_nomb"]?></td>
  </tr>
  <tr>
	   <td class='titulos2'>Accion</td>
	   <td class='listado2'>Solicitar</td>
	   <td class='titulos2'>Requiere</td>
	   <td class='listado2'><?=$slcTpExp?></td>
  </tr>
  <tr bordercolor="#FFFFFF">
	<td colspan="2" class="listado2">
		<center><input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Solicitar" onClick="return validar();"></center>
	</td>
	<td colspan="2" class="listado2">
		<center><input name="btn_accion" type="button" class="botones" id="btn_accion" value="Regresar" onClick="regresar();"></center>
	</td>
   </tr>
</table><br>
<?} echo $tblCpr?>
</form>
</body>
</html>
