<?
session_start();
$ruta_raiz = "../..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
if($db)
{	//$db->conn->debug=true;
	if($_SESSION["usua_admin_archivo"]==1){
		$whereSecc="and D.DEPE_CODI_TERRITORIAL=".$_SESSION["depe_codi_territorial"];
		$blank1stItem = "99999:Todas las Dependencias de la Seccional";
	}
	else $blank1stItem = "99999:Todas las Dependencias";
	
	!$accion?($accion= $_GET['accion']?$_GET['accion']:$_POST['accion']):0;
	if($accion)
	{
		switch ($accion)
		{
			case 'Buscar':
				
				if($txtExpediente)$where=" and p.SGD_EXP_NUMERO='$txtExpediente'";
				if($txtLogin)$where.=" and p.USUA_LOGIN_ACTU='".strtoupper($txtLogin)."'";
				if($dependenciaSel!=99999)$where.=" and p.DEPE_CODI=$dependenciaSel";
				if($selUsu)$where.=" and p.USUA_LOGIN_ACTU='".strtoupper($selUsu)."'";
				$sqlPRES_FECH_PEDI=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PEDI");
				$sqlPRES_FECH_CANC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_CANC");
                                $sqlPRES_FECH_DEVO=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_DEVO");
				$sqlPRES_FECH_PRES=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PRES");
				$sqlPRES_FECH_VENC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_VENC");
                                switch($db->driver)
                                {
                                    case 'postgres':
                                                    $diasEspera=" date_part('days', ".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI)";
                                            break;
                                    case 'oci8':
                                    case 'oci8po':
                                                    $diasEspera= " cast((".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI) as number(3)) ";
                                            break;
                                    default:

                                }
				
				$sSQL="select p.PRES_ID as PRESTAMO_ID, p.SGD_EXP_NUMERO as EXPEDIENTE, carp.sgd_carpeta_numero as CARPETA,
			                p.USUA_LOGIN_ACTU as LOGIN, D.DEPE_NOMB as DEPENDENCIA,".$sqlPRES_FECH_PEDI." as F_SOLICITUD,".$sqlPRES_FECH_VENC." as F_VENCIMIENTO,".
			                $sqlPRES_FECH_CANC." as F_CANCELACION,".$sqlPRES_FECH_PRES." as F_PRESTAMO,".$sqlPRES_FECH_DEVO." as F_DEVOLUCION,
			                G.PARAM_VALOR as REQUERIMIENTO, E.PARAM_VALOR as ESTADO,p.PRES_ESTADO as ID_ESTADO,p.PRES_REQUERIMIENTO, $diasEspera as DIASSOL
			                ,ncar.cantidad as cantidadCarpetas
			            from
					      	 PRESTAMO p
					      	 join DEPENDENCIA D on D.DEPE_CODI=p.DEPE_CODI
					      	 join SGD_PARAMETRO E on E.PARAM_CODI=p.PRES_ESTADO
					      	 join SGD_PARAMETRO G on G.PARAM_CODI=p.PRES_REQUERIMIENTO
					      	 left join SGD_CARPETA_EXPEDIENTE carp on carp.SGD_CARPETA_ID=p.SGD_CARPETA_ID
					      	 join (select sgd_exp_numero, count(*) as cantidad from sgd_carpeta_expediente  group by sgd_exp_numero) ncar on ncar.sgd_exp_numero=p.sgd_exp_numero
			            where
			                p.PRES_ESTADO in (1) and
			   		 		E.PARAM_NOMB='PRESTAMO_ESTADO' and 
					 		G.PARAM_NOMB='PRESTAMO_REQUERIMIENTO'
					 		and p.SGD_EXP_NUMERO is not null
					 		$where 
					 		$whereSecc
					 	order by p.USUA_LOGIN_ACTU";
			     //$db->conn->debug=true;
			     $rs=$db->query($sSQL);
			     if($rs && !$rs->EOF)
			     {
				      $v = "<br><input name='checkAll' value='checkAll' onclick='markAll();' checked='checked' type='checkbox'>";
				      $tblPrestados="<table width='100%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'>";
					  $tblPrestados.="<tr><td class='titulos2' colspan='11'>EXPEDIENTES SOLICITADOS</td></tr>";
				      $tblPrestados.="<tr class='titulos3' align='center' valign='middle'>";
				      $tblPrestados.="<td><font class='titulos3'>Expediente</font></td>";	 
				      $tblPrestados.="<td><font class=titulos3'>Login</font></td>";	 
				      $tblPrestados.="<td><font class='titulos3'>Dependencia</font></td>";		 
				      $tblPrestados.="<td><font class=titulos3>Fecha<br>Solicitud</font></td>";	 
				      $tblPrestados.="<td><font class='titulos3'>Tiempo<br>Espera</font></td>";		 
				      $tblPrestados.="<td><font class='titulos3'>Requerimiento</font></td>";	
				      $tblPrestados.="<td><font class='titulos3'>No. Carpeta</font></td>";	 						
				      //$tblPrestados.="<td><font class='titulos3'>Estado</font></td>";		 
				      $tblPrestados.="<td><font class='titulos3'>$v</font></td></tr>";		 
				      $iCounter = 0;
				         // Display result
				      while($rs && !$rs->EOF) 
				      {
				      	     $ncar="";
				      		 $v = "<input name='checkValue[".$rs->fields['PRESTAMO_ID']."]' value='".$rs->fields["LOGIN"]."' checked='checked' type='checkbox'>";
				             $iCounter++;		 
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
				             $tblPrestados.="<td class='leidos'>".$rs->fields["DEPENDENCIA"]."</td>"; 
				             $tblPrestados.="<td class='leidos'>".$rs->fields["F_SOLICITUD"]."</td>";
				             $tblPrestados.="<td class='leidos'>".$rs->fields["DIASSOL"]."</td>";	 
				             $tblPrestados.="<td class='leidos'>".$rs->fields["REQUERIMIENTO"].$ncar."</td>";
				             $tblPrestados.="<td class='leidos'><center>".$rs->fields["CARPETA"]."</center></td>";						
				             //$tblPrestados.="<td class='leidos'>".$rs->fields["ESTADO"]."</td>";	 
				             $tblPrestados.="<td class='leidos'>".$v."</td></tr>";	 
				             $tipoReq=$rs->fields["PRES_REQUERIMIENTO"];
				             $rs->MoveNext();   
					     }	
					    $tblPrestados.=" <tr  align='center'><td class='titulos3' colspan='11' align='center'><input type='submit' class='botones' value='Prestar' onClick='return prestar();'>&nbsp;&nbsp;<input type='button' value='Imprimir' name='imprimir'  class='botones' onclick='window.print();'></td></tr></table><br>";
			     }
				 else
				 {
					 $tblPrestados="<center><table width='60%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'><tr><td class='listado5' colspan='2'><center><font color=red size=3>No existen Expedientes en solicitud de prestamo con el criterio de B&uacute;squeda</font></center></td></tr></table></center>";
				 }
				break;
			case 'combo':
				include "$ruta_raiz/class_control/usuario.php";
				$objUsu = new Usuario($db);
				die($objUsu->usuarioDep($dep));
				break;	
			case '':
				break;	
		}
	}
	$sql = "SELECT d.dep_sigla ".$db->conn->concat_operator."'-'".$db->conn->concat_operator." d.DEPE_NOMB, d.DEPE_CODI FROM DEPENDENCIA d where d.depe_estado=1 $whereSecc ORDER BY 1";
	$rs = $db->conn->execute($sql);
	$selDep = $rs->GetMenu2('dependenciaSel', $dependenciaSel,$blank1stItem ,false,0," id='dependenciaSel' class=select onChange='combos(this)'");
}
?>
<html>
<head>
<script language="javascript" src="../../js/funciones.js"></script>
<script language="javascript" src="../../js/ajax.js"></script>
<script language="JavaScript">
function regresar()
{
	window.document.frmSolPrest.action ='<?=$ruta_raiz?>/prestamo/menu_prestamo.php?krd=<?=$krd?>';
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
		document.frmSolPrest.elements[i].checked=false;
	
}

function validar()
{
	marcados = 0;
	var aux=0;
	var auxVal='';
	for(i=0;i<document.frmSolPrest.elements.length;i++)
	{	
		if(document.frmSolPrest.elements[i].checked==true )
		{
			
			
			if(document.frmSolPrest.elements[i].name!='checkAll')
			{
				marcados++;
				if(aux>0)auxVal = document.frmSolPrest.elements[aux].value
				else  auxVal = document.frmSolPrest.elements[i].value
				if(auxVal!=document.frmSolPrest.elements[i].value)
				{
					alert('Debe seleccionar registros de un solo Usuario');
					return false;
				}
				aux=i;
			}
			
	    }
	}
	if(marcados)return true;
	else 
	{	
		alert('Debe seleccionar un registro')
	    return false;
	}
}

function combos()
{	
	var obj=document.getElementById('dependenciaSel')
	var objD = document.getElementById('cmbUsu');
	if(obj.value!='99999')
	{
		if(xmlHttp) 
		{
		  xmlHttp.open("GET", "./prestar.php?accion=combo&dep="+obj.value);
		  xmlHttp.onreadystatechange = function()
		  {
			  if (xmlHttp.readyState == 4 && xmlHttp.status == 200) 
			  {
			  	objD.innerHTML = xmlHttp.responseText;
			  }
		  }
		  xmlHttp.send(null);
		}
	}
	else objD.innerHTML="<select name='selUsu'  class='select'><option value='0'>-TODOS LOS USUARIOS-</option></select>";
}
function prestar()
{
	if(validar())
	{
		window.document.frmSolPrest.action = './formEnvio.php?tipoEnvio=prestar';
		window.document.frmSolPrest.submit();
	}
	else return false
}
</script>
<title>Orfeo - Solicitud de Prestamos.</title>
<link href="<?=$ruta_raiz ?>/estilos/orfeo.css" rel="stylesheet" type="text/css">
</head>
<body onload="document.getElementById('txtExpediente').focus();">
<form name="frmSolPrest" method="post" action="<?= $_SERVER['PHP_SELF']?>?expNum=<?=$expNum?>&krd=<?=$krd?>">
<table width="60%" align="center" border=0 cellpadding=0 cellspacing=2 class='borde_tab'>
		<tbody>
		<tr>
			<td  class="titulos4" colspan="2">B&Uacute;SQUEDA: EXPEDIENTES SOLICITADOS PARA PRESTAR</td>
		</tr>
		<tr>
			<td class="titulos5">No Expediente:</td>
			<td class="listado5">
				<input class="tex_area" type="text" name="txtExpediente" id="txtExpediente" maxlength=""  size="" >
			</td>
		</tr>
		<tr>
			<td class="titulos5">Login de Usuario</td>
			<td class="listado5">
				<input class="tex_area" type="text" name="txtLogin" id="txtExpe" maxlength="" value="<?=$txtExpe?>">
			</td>
		</tr>
		<tr>
			<td class="titulos5">Dependencia</td>
			<td class="listado5"><?=$selDep?></td>
		</tr>
		<tr>
			<td class="titulos5">Usuario</td>
			<td class="listado5"><div id='cmbUsu'></div></td>
		</tr>
		<tr bordercolor="#FFFFFF">
			<td colspan="2" class="listado2">
				<center><input name="accion" type="submit" class="botones" id="accion" value="Buscar">
				&nbsp;<input name="accion" type="button" class="botones" id="accion" value="Regresar" onClick="regresar();"></center>
			</td>
   		</tr>
		</tbody> 
		</table>
		<?=$tblPrestados?>
		</form>
</body>
<script>setTimeout("combos()",0);</script>
</html>