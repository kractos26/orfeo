<?
session_start();
$ruta_raiz = "..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
date("m")==1?$ano_ini = date("Y")-1:$ano_ini = date("Y");
$mes_ini = substr("00".(date("m")-1),-2);
if ($mes_ini==0) {$ano_ini==$ano_ini-1; $mes_ini="12";}
$dia_ini = date("d");
if(!$fecha_ini) $fecha_ini = "$ano_ini/$mes_ini/$dia_ini";
$fecha_busq = date("Y/m/d") ;
if(!$fecha_fin) $fecha_fin = $fecha_busq;
if($db)
{        
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
				
				if($txtLogin)			  $where.=" and p.USUA_LOGIN_ACTU='".strtoupper($txtLogin)."'";
				if($dependenciaSel!=99999)$where.=" and p.DEPE_CODI=$dependenciaSel";
				if($selUsu)				  $where.=" and p.USUA_LOGIN_ACTU='".strtoupper($selUsu)."'";
				if($selRequerimiento)	  $where.=" and p.PRES_REQUERIMIENTO=$selRequerimiento";
				if($selEstado)
				{			  
					if($selEstado==-1)$where.=" and p.PRES_ESTADO=2 and p.PRES_FECH_VENC <".$db->conn->sysTimeStamp;
					else if($selEstado==1) $where.=" and p.PRES_ESTADO=$selEstado and ".$db->conn->SQLDate('Y/m/d', 'PRES_FECH_PEDI')." BETWEEN '$fecha_ini' AND '$fecha_fin'";
					else if($selEstado==2) $where.=" and p.PRES_ESTADO=$selEstado and ".$db->conn->SQLDate('Y/m/d', 'PRES_FECH_PRES')." BETWEEN '$fecha_ini' AND '$fecha_fin'";
					else if($selEstado==3) $where.=" and p.PRES_ESTADO=$selEstado and ".$db->conn->SQLDate('Y/m/d', 'PRES_FECH_DEVO')." BETWEEN '$fecha_ini' AND '$fecha_fin'";
					else if($selEstado==4) $where.=" and p.PRES_ESTADO=$selEstado and ".$db->conn->SQLDate('Y/m/d', 'PRES_FECH_CANC')." BETWEEN '$fecha_ini' AND '$fecha_fin'";
					else if($selEstado==6) $where.=" and p.PRES_ESTADO =6 and PRES_FECH_VENC >".$db->conn->sysTimeStamp;
					else if($selEstado==7) $where.=" and p.PRES_ESTADO =7 and PRES_FECH_VENC >".$db->conn->sysTimeStamp;
				}
				if($txtExpediente)		  $where=" and p.SGD_EXP_NUMERO='$txtExpediente'";
				$diasEspera=" date_part('days', ".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI)";
				$sSQL="select distinct p.sgd_exp_numero as EXPEDIENTE , d.depe_nomb, E.param_valor, u.usua_nomb as usuariosol, d1.dep_sigla AS depesol
						    ,".$db->conn->SQLDate('Y-m-d', 'p.PRES_FECH_PEDI')." as fecsol
					   from PRESTAMO p
					   join SGD_SEXP_SECEXPEDIENTES exp ON exp.sgd_exp_numero=p.sgd_exp_numero
					   join DEPENDENCIA d on d.depe_codi= exp.depe_codi
					   join usuario u on p.usua_login_actu=u.usua_login
					   join dependencia d1 on d1.depe_codi=p.depe_codi
					   join SGD_PARAMETRO E on E.PARAM_NOMB='PRESTAMO_ESTADO' and E.PARAM_CODI=p.PRES_ESTADO
					   join (select max(p1.pres_fech_pedi) as fecha, p1.sgd_exp_numero as expediente from prestamo p1 group by p1.sgd_exp_numero ) fec on fec.fecha=p.pres_fech_pedi and p.sgd_exp_numero=fec.expediente
					   WHERE p.sgd_exp_numero is not null $where ";
			    //$db->conn->debug=true;
			     $rs=$db->query($sSQL);
			     if($rs && !$rs->EOF)
			     {
				      $tblPrestados="<center><table width='60%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'>";
					  $tblPrestados.="<tr><td class='titulos2' colspan='11'>LISTADO EXPEDIENTES</td></tr>";
				      $tblPrestados.="<tr class='titulos3' align='center' valign='middle'>";
				      $tblPrestados.="<td><font class='titulos3'>Dependencia</font></td>";
				      $tblPrestados.="<td><font class='titulos3'>Fecha<br>Solicitud</font></td>";
				      $tblPrestados.="<td><font class='titulos3'>Expediente</font></td>";
				      $tblPrestados.="<td><font class='titulos3'>Estado</font></td>";
				      $tblPrestados.="<td><font class='titulos3'>Solicitante</font></td>";	 
				      $tblPrestados.="<td><font class='titulos3'></font></td>";	 
				      $iCounter = 0;
				         // Display result
				      while($rs && !$rs->EOF) 
				      {
				             $iCounter++;		 
						     if (strcasecmp($krd,$rs->fields["LOGIN"])==0 && $rs->fields["ID_ESTADO"]==1) { 
						        $accion="<a href=\"javascript: cancelar(".$rs->fields["PRESTAMO_ID"]."); \">Cancelar Solicitud</a>";
						     }
				             if($iCounter%2==0){ $tipoListado="class=\"listado2\""; }
				             else              { $tipoListado="class=\"listado1\""; }
				             if($rs->fields["CARPETA"])$ncar=" No. ".$rs->fields["CARPETA"];
				             $tblPrestados.="<tr $tipoListado align='center'>";
				             $tblPrestados.="<td class='leidos'>".$rs->fields["DEPE_NOMB"]."</td>";
				             $tblPrestados.="<td class='leidos'>".$rs->fields["FECSOL"]."</td>";
				             $tblPrestados.="<td class='leidos'>".$rs->fields["EXPEDIENTE"]."</td>"; 
				             $tblPrestados.="<td class='leidos'>".$rs->fields["PARAM_VALOR"]."</td>"; 
				             $tblPrestados.="<td class='leidos'>".$rs->fields["DEPESOL"]."-".$rs->fields["USUARIOSOL"]."</td>"; 
				             $tblPrestados.="<td class='leidos'><a href=\"javascript:verHistoria('".$rs->fields["EXPEDIENTE"]."');\">Ver Historia</a></td>";
				             $rs->MoveNext();   
					    }	
					    $tblPrestados.="<tr><td colspan='5'><center><input type='button' value='Imprimir' name='imprimir'  class='botones' onclick='window.print();'></center></td></tr></table><br>";
					    
			     }
				break;
		    case 'combo':
				include "$ruta_raiz/class_control/usuario.php";
				$objUsu = new Usuario($db);
				die($objUsu->usuarioDep($dep));
				break;	
			case 'Historia':
				// Nombre de la transacci�n
	            $sqlEstadoVis[0]=" 1 "; //Solicitado
	            $sqlEstadoVis[1]=" 2 "; //Pr�stado
	            $sqlEstadoVis[2]=" 3 "; //Devuelto sin registro del usuario que hizo la transacci�n
	            $sqlEstadoVis[3]=" 4 "; //Cancelado con registro del usuario que hizo la transacci�n
	            $sqlEstadoVis[4]=" 5 "; //Pr�stamo Indefinido
	            $sqlEstadoVis[5]=" 4 "; //Cancelado sin registro del usuario que hizo la transacci�n
	            $sqlEstadoVis[6]=" 3 "; //Devuelto con registro del usuario que hizo la transacci�n
	            // Estado que define la transacci�n en la consulta
	            $sqlEstadoVis[7]=" 6 ";
	            $sqlEstadoVis[8]=" 7 ";
	            
	            $sqlEstado[0]=" (1,2,3,4,5) ";   //Solicitado
	            $sqlEstado[1]=" (2,5,3) and P.PRES_FECH_VENC is not null "; //Pr�stado
	            $sqlEstado[2]=" (3) ";           //Devuelto sin usuario
	            $sqlEstado[3]=" (4) ";           //Cancelado con usuario
	            $sqlEstado[4]=" (5,2,3) and P.PRES_FECH_VENC is null ";     //Pr�stamo Indefinido
	            $sqlEstado[5]=" (5) ";           //Cancelado sin Usuario
	            $sqlEstado[6]=" (3) ";           //Devuelto con usuario
	            
	            $sqlEstadoVis[7]=" (2) AND P.PRES_FECH_RENOVACION1 IS NOT NULL AND P.PRES_FECH_RENOVACION2 IS NULL";
	            
	            
                    $sqlPRES_FECH_PEDI=$db->conn->SQLDate("Y-m-d h:i:s A","P.PRES_FECH_PEDI");
                    $sqlPRES_FECH_PRES=$db->conn->SQLDate("Y-m-d h:i:s A","P.PRES_FECH_PRES");
                    $sqlPRES_FECH_CANC=$db->conn->SQLDate("Y-m-d h:i:s A","P.PRES_FECH_CANC");
                    $sqlPRES_FECH_DEVO=$db->conn->SQLDate("Y-m-d h:i:s A","P.PRES_FECH_DEVO");
                    $sqlPRES_FECH_RENOV1=$db->conn->SQLDate("Y-m-d h:i:s A","P.PRES_FECH_RENOVACION1");

	            $sqlFecha[0]=$sqlPRES_FECH_PEDI; //Solicitado
	            $sqlFecha[1]=$sqlPRES_FECH_PRES; //Prestado
	            $sqlFecha[2]=$sqlPRES_FECH_DEVO; //Devuelto sin usuario
	            $sqlFecha[3]=$sqlPRES_FECH_CANC; //Cancelado 
	            $sqlFecha[4]=$sqlPRES_FECH_PRES; //Pr�stamo Indefinido
	            $sqlFecha[5]=$sqlPRES_FECH_CANC; //Cancelado sin Usuario
	            $sqlFecha[6]=$sqlPRES_FECH_DEVO; //Devuelto con usuario
	            $sqlFecha[7]=$sqlPRES_FECH_RENOV1;
	           
	            
	            $sqlUsuario[0]=" P.USUA_LOGIN_ACTU "; //Solicitado
	            $sqlUsuario[1]=" P.USUA_LOGIN_PRES "; //Pr�stado
	            $sqlUsuario[2]=" P.USUA_LOGIN_ACTU and P.USUA_LOGIN_RX is null "; //Devuelto sin usuario
	            $sqlUsuario[3]=" P.USUA_LOGIN_CANC "; //Cancelado   
	            $sqlUsuario[4]=" P.USUA_LOGIN_PRES "; //Prestamo Indefinido
	            $sqlUsuario[5]=" '' ";                //Cancelado sin usuario
	            //$sqlUsuario[6]="  and  "; //Devuelto con usuario
	            // Comentario
	            $sqlDesc[0]=" '' ";         //Solicitado
	            $sqlDesc[1]=" P.PRES_DESC ";//Prestado
	            $sqlDesc[2]=" P.DEV_DESC "; //Devuelto sin usuario
	            $sqlDesc[3]=" P.CANC_DESC ";         //Cancelado            
	            $sqlDesc[4]=" P.PRES_DESC ";//Prestamo Indefinido
	            $sqlDesc[5]=" P.CANC_DESC ";         //Cancelado sin usuario
	            $sqlDesc[6]=" P.DEV_DESC "; //Devuelto con usuario
	            // Construcci�n de la consulta	
	            $sSQLTot=""; // consulta definitiva
	            for($i=0; $i<7; $i++)
	            {
	               // Manejo de cancelado con y sin usuario
	               if ($i==5) {
	                  $selectUsuario=" '' as USUARIO,";
	                  $selectDepe=" '' as DEPENDENCIA,";
	                  $fromUsuario="";
	                  $fromDepe="";
	                  $whereUsua=" P.USUA_LOGIN_CANC='' and ";
	                  $whereDepe="";
	               }
	               else
	               {
	               	  $whereUsua=" U.USUA_LOGIN=".$sqlUsuario[$i];
	                  $whereDepe=" D.DEPE_CODI=U.DEPE_CODI ";
	                  $selectUsuario=" U.USUA_NOMB as USUARIO,";
	                  $selectDepe=" D.DEPE_NOMB as DEPENDENCIA,"; 
	                  $fromUsuario="join USUARIO U on $whereUsua ";
	                  if($i==6) 
	                  { 
	                  	$selectUsuario="U.USUA_NOMB||'(Devuelve) <br>'||UR.USUA_NOMB||'(Recepciona) ' as USUARIO,"; //Devuelto con usuario
	                    $fromUsuario="join USUARIO U on U.USUA_LOGIN=P.USUA_LOGIN_ACTU
	                    			  join USUARIO UR on UR.USUA_LOGIN= P.USUA_LOGIN_RX"; //Devuelto con usuario
	                  } 
	                  $fromDepe ="join DEPENDENCIA D on  $whereDepe ";
	                  
	               }
	
	               $sSQL[$i]="select 
	                             ".$selectDepe."
	                             ".$sqlFecha[$i]." as FECHA,
	                             E.PARAM_VALOR as TRANSACCION,
	                             ".$selectUsuario."
	                             R.PARAM_VALOR as COMENTARIO1,
	                             ".$sqlDesc[$i]." as COMENTARIO2,
	                             carp.sgd_carpeta_numero AS CARPETA,
	                             ncar.cantidad as cantidadCarpetas
	                          from 
	                             PRESTAMO P
	                             ".$fromUsuario."
	                             ".$fromDepe."
	                             join SGD_PARAMETRO E on E.PARAM_NOMB='PRESTAMO_ESTADO' and E.PARAM_CODI=".$sqlEstadoVis[$i]."
	                             join SGD_PARAMETRO R on R.PARAM_NOMB='PRESTAMO_REQUERIMIENTO' and R.PARAM_CODI=P.PRES_REQUERIMIENTO
	                             left join SGD_CARPETA_EXPEDIENTE carp on carp.sgd_carpeta_id=P.sgd_carpeta_id 
	                             join (select sgd_exp_numero, count(*) as cantidad from sgd_carpeta_expediente  group by sgd_exp_numero) ncar on ncar.sgd_exp_numero=p.sgd_exp_numero
	                          where 
	                          	 P.PRES_ESTADO in ".$sqlEstado[$i]."
	                          	 and  P.SGD_EXP_NUMERO='$exp'";
	               if($i!=0){ $sSQLTot.="union all "; }
	               $sSQLTot.=$sSQL[$i]; 
	            }		
	            $sSQLTot.=" order by 2 desc"; 
	            //$db->conn->debug=true;
	            $rs=$db->query($sSQLTot);
			     if($rs && !$rs->EOF)
			     {
				      $v = "<br><input name='checkAll' value='checkAll' onclick='markAll();' checked='checked' type='checkbox'>";
				      $tblHis="<table width='100%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'>";
					  $tblHis.="<tr><td class='titulos2' colspan='11'>EXPEDIENTE No: $exp</td></tr>";
				      $tblHis.="<tr class='titulos3' align='center' valign='middle'>";
				      $tblHis.="<td><font class='titulos3'>DEPENDENCIA</font></td>";	 
				      $tblHis.="<td><font class=titulos3'>FECHA</font></td>";	 
				      $tblHis.="<td><font class='titulos3'>TRANSACCI&Oacute;N</font></td>";		 
				      $tblHis.="<td><font class=titulos3>USUARIO</font></td>";	 
				      $tblHis.="<td><font class='titulos3'>COMENTARIO</font></td>";		 
				      $iCounter = 0;
				         // Display result
				      while($rs && !$rs->EOF) 
				      {
				      		 
				             $iCounter++;		 
                                             if (strcasecmp($krd,$rs->fields["LOGIN"])==0 && $rs->fields["ID_ESTADO"]==1) {
                                                $accion="<a href=\"javascript: cancelar(".$rs->fields["PRESTAMO_ID"]."); \">Cancelar Solicitud</a>";
                                             }
				             if($iCounter%2==0){ $tipoListado="class=\"listado2\""; }
				             else              { $tipoListado="class=\"listado1\""; }
				             if($rs->fields["CARPETA"])$ncar=" No. ".$rs->fields["CARPETA"];
				             else $ncar=" con ".$rs->fields["CANTIDADCARPETAS"]." Carpeta(s)";
				             $tblHis.="<tr $tipoListado align='center'>";
				             $tblHis.="<td class='leidos'>".$rs->fields["DEPENDENCIA"]."</td>"; 
				             $tblHis.="<td class='leidos'>".$rs->fields["FECHA"]."</td>";	 
				             $tblHis.="<td class='leidos'>".$rs->fields["TRANSACCION"]." por: </td>"; 
				             $tblHis.="<td class='leidos'>".$rs->fields["USUARIO"]."</td>";
				             $tblHis.="<td class='leidos'>".$rs->fields["COMENTARIO1"]." $ncar :".$rs->fields["COMENTARIO2"]."</td>";	  
				             $rs->MoveNext();   
					     }	
					    $tblPrestados.="</table><br>";
			     }
	            
				break;	
		}
	}
	$sql = "SELECT param_valor, param_codi from sgd_parametro where param_nomb='PRESTAMO_REQUERIMIENTO' AND param_codi > 3";
	$rs = $db->conn->execute($sql);
	$slcReq = $rs->GetMenu2('selRequerimiento', $selRequerimiento, "0:Todos los Requerimientos",false,0," id='selRequerimiento' class=select ");
	$sql = "SELECT param_valor, param_codi from sgd_parametro where param_nomb='PRESTAMO_ESTADO' and  param_codi not in (5,6)";
	$rs = $db->conn->execute($sql);
	$slcEstado = $rs->GetMenu2('selEstado', $selEstado, "0:Todos los Estados",false,0," id='selEstado' class=select");
	$sql = "SELECT d.dep_sigla ".$db->conn->concat_operator."'-'".$db->conn->concat_operator." d.DEPE_NOMB, d.DEPE_CODI FROM DEPENDENCIA d where depe_estado=1  $whereSecc ORDER BY 1";
	$rs = $db->conn->execute($sql);
	$selDep = $rs->GetMenu2('dependenciaSel', $dependenciaSel, $blank1stItem ,false,0," id='dependenciaSel' class=select onChange='combos(this)'");
}
?>
<html>
<head>
<link href="../estilos/orfeo.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="javascript" src="../js/funciones.js"></script>
<script language="javascript" src="../js/ajax.js"></script>
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript">
var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "frmReport", "fecha_ini","btnDate1","<?=$fecha_ini?>",scBTNMODE_CUSTOMBLUE);
var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "frmReport", "fecha_fin","btnDate2","<?=$fecha_fin?>",scBTNMODE_CUSTOMBLUE);
</script>

<script language="JavaScript">
function regresar()
{
	window.document.frmReport.action ='<?=$ruta_raiz?>/prestamo/menu_prestamo.php?krd=<?=$krd?>';
	window.document.frmReport.submit();
}



function combos()
{	
	var obj=document.getElementById('dependenciaSel')
	var objD = document.getElementById('cmbUsu');
	if(obj.value!='99999')
	{
		if(xmlHttp) 
		{
		  xmlHttp.open("GET", "./consultarHistoriaPrestamo.php?accion=combo&dep="+obj.value);
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
function verHistoria(exp)
{
	var aux=window.document.frmReport.action
	window.document.frmReport.target='HistPrest'
	window.document.frmReport.action = './consultarHistoriaPrestamo.php?accion=Historia&exp='+exp;
	window.document.frmReport.submit();
	window.document.frmReport.target='_self';
	window.document.frmReport.action=aux;
}
</script>
<title>Orfeo - Transferecnia de Carpetas.</title>
</head>
<body onload="document.getElementById('txtExpediente').focus();">
<div id="spiffycalendar" class="text"></div>
<form name="frmReport" method="post" action="<?= $_SERVER['PHP_SELF']?>?expNum=<?=$expNum?>&krd=<?=$krd?>" >
<?if($tblHis)echo $tblHis;
else{?>
<table width="60%" align="center" border=0 cellpadding=0 cellspacing=2 class='borde_tab'>
		<tbody>
		<tr>
			<td  class="titulos4" colspan="2">GENERACI&Oacute;N DE REPORTES: PRESTAMO DE EXPEDIENTES </td>
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
		<tr>
			<td class="titulos5">Requerimiento</td>
			<td class="listado5"><?=$slcReq?></td>
		</tr>
		<tr>
			<td class="titulos5">Estado</td>
			<td class="listado5"><?=$slcEstado?></td>
		</tr>
		<tr>
			<td class="titulos5">Desde Fecha (yyyy/mm/dd)</td>
			<td class="listado5">
				<script language="javascript">
					dateAvailable.writeControl();
					dateAvailable.dateFormat="yyyy/MM/dd";
				</script>
			</td>
		</tr>
		<tr>
			<td class="titulos5">Hasta Fecha (yyyy/mm/dd)</td>
			<td class="listado5">
				<script language="javascript">
					dateAvailable1.writeControl();
					dateAvailable1.dateFormat="yyyy/MM/dd";
				</script>
			</td>
		</tr>
		<tr bordercolor="#FFFFFF">
			<td colspan="2" class="listado2">
				<center><input name="accion" type="submit" class="botones" id="accion" value="Buscar">
				&nbsp;<input name="accion" type="button" class="botones" id="accion" value="Regresar" onClick="regresar();"></center>
			</td>
   		</tr>
		</tbody> 
		</table>
		<?=$tblPrestados;}?>
		</form>
</body>
<script>setTimeout("combos()",0);</script>
</html>