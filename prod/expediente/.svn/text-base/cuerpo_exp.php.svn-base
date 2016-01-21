<?php
session_start(); 
error_reporting(7);
$ruta_raiz = "..";
if(!$_SESSION['dependencia'] or !$_SESSION['tpDepeRad']) include "$ruta_raiz/rec_session.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = new ConnectionHandler($ruta_raiz);	 
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
if(!$tipo_archivo) $tipo_archivo = 0;
/*
 *  Modificado: 22-Septiembre-2006 Supersolidaria
 *  Ajuste para eliminar el registro correspondiente al radicado excluido del expediente en
 * la tabla SGD_EXP_EXPEDIENTE.
 */
// Si confirma la exlusi�n del radicado
if( $_GET['excluir'] == 1 && $_GET['radExcluido'] != "" && $_GET['expedienteExcluir'] != "" )
{
    include "$ruta_raiz/include/query/expediente/queryExcluirRadicado.php";	
	//$db->conn->debug = true;
    $rsExcluirRadicado = $db->conn->query( $sqlExcluirRadicado );
}

function getUbicacion($param)
{
	return true;	
}

$fechah=date("dmy") . "_". time("h_m_s");
$encabezado = session_name()."=".session_id()."&buscar_exp=$buscar_exp&buscar_rad=$buscar_rad&krd=$krd&tipo_archivo=$tipo_archivo&nomcarpeta=$nomcarpeta&buscar_isla=$buscar_isla&buscar_estante=$buscar_estante";
?>
<html>
<head>
<meta http-equiv="Cache-Control" content="cache">
<meta http-equiv="Pragma" content="public">
<script type="text/javascript">
function sel_dependencia()
{
	document.write("<form name=forma_b_correspondencia action='cuerpo_exp.php?<?=$encabezado?>'  method=post>");
	depsel = form1.dep_sel.value ;
	document.write("<input type=hidden name=depsel value="+depsel+">");
	document.write("<input type=hidden name=estado_sal  value=3>");
	document.write("<input type=hidden name=estado_sal_max  value=3>");
	document.write("<input type=hidden name=fechah value='<?=$fechah?>'>");
	document.write("</form>");
	forma_b_correspondencia.submit();
}
   
   
//  Modificado: 02-Octubre-2006 Supersolidaria
//  Funcion para confirmar la exclusi�n de radicados.
//
function confirmaExcluir( radicado, expediente )
{
	confirma = confirm( 'Confirma que el radicado ' + radicado + ' ya fue excluido fisicamente del expediente ' + expediente + '?' );
	if( confirma )
	{
		document.form1.action = "cuerpo_exp.php?radExcluido="+radicado+"&expedienteExcluir="+expediente+"&excluir=1";
		document.form1.submit();
	}
}
</script>
<link rel="stylesheet" href="../estilos/orfeo.css">
<?php
if(!$estado_sal)   {$estado_sal=2;}
if(!$estado_sal_max) $estado_sal_max=3; 
$accion_sal = "Marcar como Archivado Fisicamente";
$pagina_sig = "envio.php"; 
//if(!$dep_sel) $dep_sel = $dependencia;
$buscar_exp = trim($buscar_exp);
$buscar_rad = trim($buscar_rad);
if ($dep_sel==0) $wdep_sel = " d.depe_codi is not null ";
else $wdep_sel = " d.depe_codi = $dep_sel ";
$dependencia_busq1= " and d.sgd_exp_estado=$tipo_archivo and $wdep_sel  and (upper(d.sgd_exp_numero) like '%$buscar_exp%' and upper(cast(d.RADI_NUME_RADI AS varchar(100))) like '%$buscar_rad%'";
$dependencia_busq2= " and d.sgd_exp_estado=$tipo_archivo and $wdep_sel and (upper(d.sgd_exp_numero) like '%$buscar_exp%' and upper(d.RADI_NUME_RADI) like '%$buscar_rad%' ";	
if($buscar_isla=="" and $buscar_estante=="")
{
	$dependencia_busq1.=")";
	$dependencia_busq2.=")";
}
else{
if($buscar_estante==""){
	$dependencia_busq1.="and d.sgd_exp_isla='$buscar_isla')";
	$dependencia_busq2.="and d.sgd_exp_isla='$buscar_isla')";
}
elseif($buscar_isla=="")
{
	$dependencia_busq1.="and d.sgd_exp_estante='$buscar_estante')";
	$dependencia_busq2.="and d.sgd_exp_estante='$buscar_estante')";
}
else
{
	$dependencia_busq1.="and d.sgd_exp_isla='$buscar_isla' and d.sgd_exp_estante='$buscar_estante')";
	$dependencia_busq2.="and d.sgd_exp_isla='$buscar_isla' and d.sgd_exp_estante='$buscar_estante')";
}
}
$tbbordes = "#CEDFC6";
$tbfondo = "#FFFFCC";
if(!$orno){$orno=1;}
$imagen="flechadesc.gif";
?> 
<script type="text/javascript">
// Esta funcion esconde el combo de las dependencia e informados 
//Se activan cuando el menu envie una seal de cambio.
function window_onload()
{
	form1.depsel.style.display = '';
	form1.enviara.style.display = '';
	form1.depsel8.style.display = 'none';
	form1.carpper.style.display = 'none';
	setVariables();
	setupDescriptions();
}

// Cuando existe una sean de cambio el program ejecuta esta funcion mostrando el combo seleccionado
function changedepesel()
{
	form1.depsel.style.display = 'none';
	form1.carpper.style.display = 'none';
	form1.depsel8.style.display = 'none';
	if(form1.enviara.value==10)
	{
		form1.depsel.style.display = 'none';
		form1.carpper.style.display = '';
		form1.depsel8.style.display = 'none';
	}
	if(form1.enviara.value==9 )
	{
		form1.depsel.style.display = '';
		form1.carpper.style.display = 'none';
		form1.depsel8.style.display = 'none';
	}
	if(form1.enviara.value==8 )
	{
		form1.depsel.style.display = 'none';
		form1.depsel8.style.display = '';
		form1.carpper.style.display = 'none';
	}
}

// Funcion que activa el sistema de marcar o desmarcar todos los check
function markAll()
{
if(form1.marcartodos.checked==1)
for(i=4;i<form1.elements.length;i++)
form1.elements[i].checked=1;
else
    for(i=4;i<form1.elements.length;i++)
  	form1.elements[i].checked=0;
}
<?php
   //include "libjs.php";
	 function tohtml($strValue)
{
  return htmlspecialchars($strValue);
}
?>
</script>
<style type="text/css">
.textoOpcion {  font-family: Arial, Helvetica, sans-serif; font-size: 8pt; color: #000000; text-decoration: underline}
</style>
</head>
<body bgcolor="#FFFFFF" topmargin="0" >
<div id="object1" style="position:absolute; visibility:show; left:10px; top:-50px; width=80%; z-index:2" > 
  <p>Cuadro de Hist&oacute;rico</p>
</div>
<?php
 /* 
 PARA EL FUNCIONAMIENTO CORRECTO DE ESTA PAGINA SE NECESITAN UNAS VARIABLE QUE DEBEN VENIR 
 carpeta  "Codigo de la carpeta a abrir"
 nomcarpeta "Nombre de la Carpeta"
 tipocarpeta "Tipo de Carpeta  (0,1)(Generales,Personales)"
 

 seleccionar todos los checkboxes
*/

$img1="";$img2="";$img3="";$img4="";$img5="";$img6="";$img7="";$img8="";$img9="";
IF($ordcambio){IF($ascdesc=="DESC" ){$ascdesc="";	$imagen="flechaasc.gif";}else{$ascdesc="DESC";$imagen="flechadesc.gif";}}
if($orno==1){$order=" d.sgd_exp_numero $ascdesc";$img1="<img src='../iconos/$imagen' border=0 alt='$data'>";}
if($orno==2){$order=" a.radi_nume_radi $ascdesc";$img2="<img src='../iconos/$imagen' border=0 alt='$data'>";}
if($orno==3){$order=" a.radi_fech_radi $ascdesc";$img3="<img src='../iconos/$imagen' border=0 alt='$data'>";}
if($orno==4){$order=" a.ra_asun $ascdesc";$img4="<img src='../iconos/$imagen' border=0 alt='$data'>";}
if($orno==5){$order=" d.sgd_exp_estado $ascdesc,a.radi_nume_radi ";$img5="<img src='../iconos/$imagen' border=0 alt='$data'>";}
if($orno==6){$order=" f.usua_nomb $ascdesc";$img6="<img src='../iconos/$imagen' border=0 alt='$data'>";}
if($orno==9){$order=" f.usua_nomb $ascdesc";$img9="<img src='../iconos/$imagen' border=0 alt='$data'>";}
if($orno==11){$order=" d.sgd_exp_fech $ascdesc";$img11="<img src='../iconos/$imagen' border=0 alt='$data'>";}
if($orno==12){$order=" d.sgd_exp_fech_arch $ascdesc";$img12="<img src='../iconos/$imagen' border=0 alt='$data'>";}
if($tipo_archivo==0){$img7=" <img src='../iconos/flechanoleidos.gif' border=0 alt='$data'> ";}

if($tipo_archivo==1){$img7=" <img src='../iconos/flechanoleidos.gif' border=0 alt='$data'> ";}		 		 

$datosaenviar = "buscar_exp=$buscar_exp&buscar_rad=$buscar_rad&fechaf=$fechaf&tipo_carp=$tipo_carp&ascdesc=$ascdesc&orno=$orno&buscar_isla=$buscar_isla&buscar_estante=$buscar_estante";
$encabezado = session_name()."=".session_id()."&buscar_exp=$buscar_exp&buscar_rad=$buscar_rad&krd=$krd&fechah=$fechah&ascdesc=$ascdesc&dep_sel=$dep_sel&tipo_archivo=$tipo_archivo&nomcarpeta=$nomcarpeta&buscar_isla=$buscar_isla&buscar_estante=$buscar_estante&orno=";
$fechah=date("dmy") . "_". time("h_m_s");

$check=1;
$fechaf=date("dmy") . "_" . time("hms");
$numeroa=0;$numero=0;$numeros=0;$numerot=0;$numerop=0;$numeroh=0;

/** Instruccion que realiza la consulta de radicados segun criterios
 * Tambien observamos que se encuentra la varialbe $carpetaenviar que maneja la carpeta 11.
 */
$limit = ""; 
$sqlfecha = $db->conn->SQLDate("d-m-Y H:i A","a.RADI_FECH_RADI");
$fecha_hoy = Date("Y-m-d");
$sqlFechaHoy=$db->conn->DBDate($fecha_hoy);			
include "$ruta_raiz/include/query/expediente/queryCuerpo_exp.php";	
//$db->conn->debug = true;
$rs=$db->conn->query($isql);
$nombusuario = $rs->fields["USUA_NOMB"];
$dependencianomb = $rs->fields["DEPE_NOMB"];
$carpeta=200;
$nomcarpeta = "Expedientes";
include "../envios/paEncabeza.php";
$ancho = ($tipo_archivo==0) ?  20 : 30;
?>
<form name='form1' action='cuerpo_exp.php?<?=$encabezado&$orno ?>' method="post"> 
<table WIDTH='100%' class='borde_tab' valign='top' cellspacing="0">
<tr class="tablas">
	<td width='<?=$ancho?>%' align="left">
		Buscar Expediente <input type=text name=buscar_exp value='<?=$buscar_exp?>' class="tex_area">
		<br>
		&nbsp; Buscar Radicado &nbsp;&nbsp;&nbsp;
		<input type=text name=buscar_rad value='<?=$buscar_rad?>' class="tex_area">
	</td>
	<td width='20%' align="left">
		<input type=submit value='Buscar' name=Enviar valign='middle' class='botones'>
	</td>
	<td width='20%' align="left" >
  		<b>Dependencia que pide el archivo del documento</b>
<?php
error_reporting(7);
$query="select depe_nomb,depe_codi from DEPENDENCIA ORDER BY DEPE_NOMB";
$rs1=$db->conn->query($query);
print $rs1->GetMenu2('dep_sel',$dep_sel,"0:--- TODAS LAS DEPENDENCIAS ---",false,"","  class=select onChange='submit();'");	  
?>
	</td>
</tr>
</table>
<table><tr><td></td></tr></table>
<table><tr><td></td></tr></table>
<table width='100%' class='borde_tab'>
<tr>
	<td  align='left' height="40" class=titulos5>
		Listar Por:
    	<a href='cuerpo_exp.php?<?=$encabezado.$orno?>&tipo_archivo=0' alt='Ordenar Por Leidos'><span class='leidos'>
<?php
if ($tipo_archivo==0) echo  "$img7"; 
?>
		Por Archivar</span></a> 
<?php 
if ($tipo_archivo==1)  echo "$img7"; 
?>
		<a href='cuerpo_exp.php?<?=$encabezado.$orno?>&tipo_archivo=1' class="no_leidos" alt='Ordenar Por Leidos'><span class='tpar'> 
<?php
if ($tipo_archivo==1)	echo "<b>"; else echo "</b>";
?>  
		Archivados</span></a><span class='tparr'>
<!-- 
/*
*  Modificado: 21-Septiembre-2006 Supersolidaria
*  Ajuste para ver los radicados excluidos de un expediente.
*/
-->
		<a href='cuerpo_exp.php?<?=$encabezado.$orno?>&tipo_archivo=2' alt='Ordenar Por Leidos'><span class='porExcluir'>
<?php
if ($tipo_archivo==2) echo  "$img7"; 
?>
		Por Excluir</span></a><br>
	</td>
</tr>
</table>
<table width='100%' class='borde_tab'>
<tr> 
	<td class="grisCCCCCC"> 
		<table cellspacing="3"  WIDTH=100% class='borde_tab' align='center' >
		<tr  class="titulos5"> 
			<td  align="center">
				<a href='cuerpo_exp.php?<?=$encabezado ?>1&ordcambio=1' class='textoOpcion' alt='Seleccione una busqueda'></a>
				<a href='cuerpo_exp.php?<?=$encabezado ?>2&ordcambio=1' class='textoOpcion' alt='Seleccione una busqueda'>
				<?=$img2 ?> Radicado Entrada
				</a>
				<a href='cuerpo_exp.php?<?=$encabezado ?>1&ordcambio=1' class='textoOpcion' alt='Seleccione una busqueda'></a>
			</td>
			<td width='18%' align="center">
				<a href='cuerpo_exp.php?<?=$encabezado ?>3&ordcambio=1' class='textoOpcion' alt='Seleccione una busqueda'> 
				<?=$img3 ?> Fecha Radicado
				</a>
			</td>
			<td width='10%' align="center">
				<a href='cuerpo_exp.php?<?=$encabezado ?>2&ordcambio=1' class='textoOpcion' alt='Seleccione una busqueda'></a>
				<a href='cuerpo_exp.php?<?=$encabezado ?>1&ordcambio=1' class='textoOpcion' alt='Seleccione una busqueda'>
				<?=$img1 ?>
				Expediente
				</a>
			</td>
			<td width='10%' align="center">
				<a href='cuerpo_exp.php?<?=$encabezado ?>2&ordcambio=1' class='textoOpcion' alt='Seleccione una busqueda'></a>
				<a href='cuerpo_exp.php?<?=$encabezado ?>11&ordcambio=1' class='textoOpcion' alt='Seleccione una busqueda'>
				<?=$img11 ?>
				Fecha Clasificaci&oacute;n
				</a>
			</td>
			<td width='20%' align="center">
				<a href='cuerpo_exp.php?<?=$encabezado ?>4&ordcambio=1' class='textoOpcion'  alt='Seleccione una busqueda'> 
				<?=$img4 ?> Descripci&oacute;n
				</a>
			</td>
			<td width='15%' align="center">
				<a href='cuerpo_exp.php?<?=$encabezado ?>5&ordcambio=1' class='textoOpcion'  alt='Seleccione una busqueda'>
				<?=$img5 ?>
				Archivado ?
				</a>
			</td>
			<td width='15%' align="center">
				<a href='cuerpo_exp.php?<?=$encabezado ?>12&ordcambio=1' class='textoOpcion'  alt='Seleccione una busqueda'>
				<?=$img12 ?>
				Fecha de Archivo
				</a>
			</td>					
<!--
/*
 *  Modificado: 22-Septiembre-2006 Supersolidaria
 *  Ajuste para incluir un bot�n que permite confirmar la exclusi�n de un radicado.
 */
-->
<?php
if( $tipo_archivo == 2 )
{
?>
			<td  width='15%' align="center">
        		EXCLUIR
    		</td>
<?php
}
?>
		</tr>
<?php
$row = array();
$i = 1;
$ki=0;
// Comienza el ciclo para mostrar los documentos de la carpeta predeterminada.
$registro=$pagina*20;
while(!$rs->EOF)
{
	if($ki>=$registro and $ki<($registro+20))
	{
		$data = trim($rs->fields["RADI_NUME_RADI"]);
		$numdata =  trim($rs->fields["CARP_CODI"]);
		$plg_codi = $rs->fields["PLG_CODI"];
		$plt_codi = $rs->fields["PLT_CODI"];			
		$num_expediente = $rs->fields["SGD_EXP_NUMERO"];
		$imagen_rad = $rs->fields["RADI_PATH"];
		$usuario_actual = $rs->fields["USUA_NOMB"];
		$dependencia_actual = $rs->fields["DEPE_NOMB"];			
		$estado = $rs->fields["SGD_EXP_ESTADO"];
		$fecha_archivo = $rs->fields["SGD_EXP_FECH_ARCH"];
		$fecha_clasificacion = $rs->fields["SGD_EXP_FECH"];
	    /*
	     *  Modificado: 22-Septiembre-2006 Supersolidaria
	     *  Ajuste para determinar si un radicado hab�a sido archivado antes de ser excluido de
	     *  un expediente.
	     */
		if( $estado == 0 )
	    {
	        $estado_nomb = "No";
	    }
	    else if( $estado == 2 && $fecha_archivo != "" )
	    {
	        $estado_nomb = "Si";
	    }
	    else if( $estado == 2 && $fecha_archivo == "" )
	    {
	        $estado_nomb = "No";
	    }
	    else
	    {
	        $estado_nomb = "Si";
	    }
		
		if($plt_codi==2){$img_estado = "<img src='../imagenes/docRadicado.gif'  border=0>"; }
		if($plt_codi==3){$img_estado = "<img src='../imagenes/docImpreso.gif'  border=0>"; }			
		if($plt_codi==4){$img_estado = "<img src='../imagenes/docEnviado.gif ' border=0>"; }			
		if($rs->fields["SGD_TPR_CODIGO"]==9999)
		{
			if($plt_codi==2){$img_estado = "<img src=../imagenes/docRecibido.gif  border=0>"; }
			if($plt_codi==2){$img_estado = "<img src=../imagenes/docRadicado.gif  border=0>"; }
			if($plt_codi==3){$img_estado = "<img src=../imagenes/docImpreso.gif  border=0>"; }
			if($plt_codi==4){$img_estado = "<img src=../imagenes/docEnviado.gif  border=0>"; }			
		
			$dep_radicado = substr($rs->fields["RADI_NUME_RADI"],4,3);
			$ano_radicado = substr($rs->fields["RADI_NUME_RADI"],0,4);
			
			$ref_pdf = "bodega/$ano_radicado/$dep_radicado/docs/$ref_pdf";
			$tipo_sal = "Archivo";
			$ref_pdf_salida = "<a href='../bodega/$ano_radicado/$dep_radicado/docs/$ref_pdf' alt='Radicado de Salida $rad_salida'>$img_estado</a>";
		}
		else
		{
			$tipo_sal = "Plantilla";			
			$ref_pdf_salida = "<a href='../$ref_pdf' alt='Radicado de Salida $rad_salida'>$img_estado</a>";
		}
		//$ref_pdf_salida = "<a href='imprimir_pdf_frame?".session_name()."=".session_id() . "&ref_pdf=$ref_pdf&numrad=$numrad'>$img_estado </a>";
    	if($data =="") $data = "NULL";
		error_reporting(7);
	 	$numerot = $row1["num"];
	 	if($estado==0)	{$leido="";} else {$leido="";}
	 	if($i==1){
	    	$leido ="listado1";
			$i=2;
	 	}else{
	    	$leido ="listado2";
			$i=1;
	 	}
	     /*
	     *  Modificado: 22-Septiembre-2006 Supersolidaria
	     *  Ajuste para identifiar con otro color los radicados excluidos de un expediene.
	     */
	     // Por Archivar
	     $var_dump="";
	     if( $estado == 0 )
	     {
	        $class = "leidos";
	     }
	     else if( $estado == 1 )
	     {
	        $class = "no_leidos";
	        $var_dump = "&ent=1";
	     }
	     // Por Excluir
	     else if( $estado == 2 )
	     {
	        $class = "porExcluir";
	     }
	     
	     if($rs->fields["RADI_PATH"]!="")
	     {
		 	$urlimagen = "<a href='../pool_anh".$rs->fields["RADI_PATH"]."'><span class='".$class."'>$data</span></a>";
	     }
	     else
    	 	 $urlimagen = "<span class='".$class."'>$data</span>";
?> 
		<tr class='<?=$leido?>'> 
<?php
$radi_tipo_deri = $rs->fields["RADI_TIPO_DERI"];
$radi_nume_deri = $rs->fields["RADI_NUME_DERI"];
?>    
			<td class='<?=$leido ?>' align="right" width="12%"><span class='<?php print $class; ?>'><?=$urlimagen?></span>
<?php
$radi_nomb=$rs->fields["NOMBRES"] ;
?>                    
			</td>
			<td class='<?=$leido ?>' width="10%" align="right">
<?php $ruta_raiz=".."; ?>
				<a href='../verradicado.php?<?=$encabezado.$var_dump."&num_expediente=$num_expediente&verrad=$data&carpeta_per=0&carpeta=8&nombcarpeta=Expedientes"?>' >
				<span class='<?php print $class; ?>'>
    			<?=$rs->fields["FECHA"]?></span>
				</a>
			</td>
			<td class='<?=$leido?>' width="18%">
				<span class='<?php print $class; ?>'><?=$num_expediente?></span>
			</td>
			<td class='<?=$leido ?>' width="20%">
				<span class='<?php print $class; ?>'><?=$fecha_clasificacion?></span>
			</td>
			<td class='<?=$leido ?>' width="20%">
				<span class='<?php print $class; ?>'><?=$rs->fields["RA_ASUN"] ?>
			</span>
			</td>
			<td class='<?=$leido ?>' width="15%" align="center">
				<a href='../archivo/datos_expediente.php?<?=$encabezado.$var_dump."&ent=1&num_expediente=$num_expediente&nurad=$data"?>' class='vinculos'>
				<span class='<?php print $class; ?>'><?=$estado_nomb?></span>
				</a>
			</td>
			<td class='<?=$leido ?>' width="20%">
				<span class='<?php print $class; ?>'><?=$fecha_archivo?></span>
			</td>
<?php
	if( $estado == 2 )
	{
?>
			<td class='<?=$leido ?>' width="20%">
				<span class='<?php print $class; ?>'>
				<div align="center">
					<!--
					  <a href="cuerpo_exp.php?radExcluido=<?php print $data; ?>&expedienteExcluir=<?php print $num_expediente; ?>&excluir=1">
					-->
				<a href="javascript:confirmaExcluir( '<?php print $data; ?>', '<?php print $num_expediente; ?>' );">
				<img src="<?php print $ruta_raiz; ?>/iconos/rad_excluido.png" border="0" height="14" width="25">
				</a>
				</div>  
				</span>
			</td>
<?php
	}
	
	if($check<=20)
	{
		$check=$check+1;
	}
?>
		</tr>
<?php
	}
	$ki=$ki+1;
	$rs->MoveNext();
}
?> 
		</table>
	</td>
</tr>
</table>
</form>
<table border=0 cellspace=2 cellpad=2 WIDTH=100% class='borde_tab' align='center'>
<tr align="center"> 
	<td>
<?php	 		
// Se calcula el numero de | a mostrar
$rs=$db->query($isqlCount);
$numerot = $rs->fields["CONTADOR"];
$paginas = ($numerot / 20);
?>
		<span class='vinculos'>P&aacute;ginas </span>
<?php
if(intval($paginas)<=$paginas)
{$paginas=$paginas;}
else{$paginas=$paginas-1;}
// Se imprime el numero de Paginas.
for($ii=0;$ii<$paginas;$ii++)
{
	 if($pagina==$ii)
	 {$letrapg="<font color=green size=3>";}else{$letrapg="";}
	 echo " <a href='cuerpo_exp.php?pagina=$ii&$encabezado$var_dump$orno'><span class=leidos>$letrapg".($ii+1)."</span></font></a>\n";
}
echo "<input type=hidden name=check value=$check>";
?>	</td>
</tr>
</table>
<form name=jh >
	<input type=hidDEN name=jj value=0>
	<input type=hidDEN name=dS value=0>
</form>
</body>
</html>