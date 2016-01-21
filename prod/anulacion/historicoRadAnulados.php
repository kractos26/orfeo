<?php
session_start();
error_reporting(0);
$ruta_raiz = "..";
if (!$_SESSION['dependencia'] and !$_SESSION['depe_codi_territorial'])	include "../rec_session.php";
if(!$fecha_busq) $fecha_busq=date("Y-m-d");
if(!$fecha_busq2) $fecha_busq2=date("Y-m-d");
include('../config.php');
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");	 
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);		
    //Busqueda
	$whereTpAnulacion = " b.sgd_eanu_codigo = 2 ";

	$busqRadicados=trim($busqRadicados);	
	if ($busqRadicados){
		$textElements=split(",",$busqRadicados);
		$i=0;
		foreach ($textElements as $item) {
			$item=trim($item);
			if($item){ 
				if($i>0){ $busq_and.=" or "; } 
				$busq_and.=" b.radi_nume_radi like '%$item' "; 
				$i++;
			}			
		} 
 	    $whereRadicado=" and ($busq_and) ";
	} 
	
	if($dep_sel){
 	    $whereDepSel=" and substr(b.radi_nume_radi,5,3)='$dep_sel' ";
	}	
	
	if($tipoRadicado){
 	    $whereTipoRadicado=" and substr(b.radi_nume_radi,-1)='$tipoRadicado' ";
	}	
		
?>
<head>
   <link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body>
  <form name="new_product"  action='historicoRadAnulados.php?<?=session_name()."=".session_id()."&krd=$krd"?>' method=post>
	<TABLE width="400" class='borde_tab' cellspacing="5" align="center">
		<TR>
		    <TD height="30" valign="middle" colspan="2" class='titulos4' align="center">REPORTE RADICADOS ANULADOS</td>
		</tr>
		<tr>
		    <TD height="26" class='titulos2' width="200">Dependencia</TD>
		    <TD valign="top" align="left"  class='listado2'>
		<?php	
		include_once "$ruta_raiz/include/query/envios/queryPaencabeza.php";			
		$sqlConcat = $db->conn->Concat($db->conn->substr."($conversion,1,5) ", "'-'",$db->conn->substr."(depe_nomb,1,30) ");
		$sql = "select $sqlConcat ,depe_codi from dependencia 
						order by depe_codi";
		$rsDep = $db->conn->Execute($sql);
		if(!$depeBuscada) $depeBuscada=$dependencia;
		print $rsDep->GetMenu2("dep_sel","$dep_sel",false, false, 0," class='select'><option value=0>--- TODAS LAS DEPENDENCIAS --- </option");
		?>    
	 		</TD>
	    </tr>		
		<tr>
		    <TD height="26" class='titulos2'>Tipo Radicacion</TD>
		    <TD valign="top" align="left"  class='listado2'>
		<?php
			$sqlTR = "select upper(sgd_trad_descr),sgd_trad_codigo 
			          from sgd_trad_tiporad 
			          where sgd_trad_codigo != 2 
					  order by sgd_trad_codigo";
			$rsTR = $db->conn->Execute($sqlTR);
			print $rsTR->GetMenu2("tipoRadicado","$tipoRadicado",false, false, 0," class='select'> <option value=0>--- TODOS LOS TIPOS --- </option");
		?>    
	 		</TD>
	    </tr>
		<tr title="Para el caso de varios radicados separar por coma">
		    <TD height="26" class='titulos2'>Radicado(s)</TD>
		    <TD valign="top" align="left"  class='listado2'>
        	<input name="busqRadicados" type="text" size="50" class="tex_area" value="<?=$busqRadicados?>">
	 		</TD>
	    </tr>		
		<tr>
		    <td height="26" colspan="2" valign="top" class='titulos2'> 
		    <center><INPUT TYPE=submit name=generar_informe title='Realizar Busqueda' value="Buscar" class=botones ></center>
			</td>
		</tr>
	</TABLE><br>
  </form>	
<HR>
<br>
<TABLE width="800" align="center" cellspacing="0" cellpadding="0" class="borde_tab">
        <tr class="tablas">
          <TD height="30" valign="middle" colspan="2"  class='titulos4' align="center">RESULTADOS</td>
		</tr>
		<tr>
		    <TD colspan="2" align="center">
  <?php
	//Orden en el que se presentan los resultados
	if(trim($orderTipo)=="") $orderTipo="DESC";
    if($orden_cambio==1){
	   if(trim($orderTipo)!="DESC"){ $orderTipo="DESC"; }
	   else { $orderTipo="ASC"; }
	}		
	if(strlen($orderNo)==0) {
		$orderNo="0";
		$order = 1;
	}
	else{ $order = $orderNo +1; }		
	
	//Link resultados
	$encabezado = "".session_name()."=".session_id()."&krd=$krd&depeBuscada=$depeBuscada&accion_sal=$accion_sal&filtroSelect=$filtroSelect&dep_sel=$dep_sel&tpAnulacion=$tpAnulacion&nomcarpeta=$nomcarpeta&orderTipo=$orderTipo&orderNo=";
    $linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";		
	
	//Resultados
	$sqlFecha = $db->conn->SQLDate("Y-m-d A h:i","b.RADI_FECH_RADI");  	
	$sqlFechaAnul = $db->conn->SQLDate("Y-m-d A h:i","d.sgd_anu_fech");  	
	$sqlFechaSolAnul = $db->conn->SQLDate("Y-m-d A h:i","d.SGD_ANU_SOL_FECH");  		
	include "$ruta_raiz/include/query/anulacion/querycuerpo_HistoricoRadAnulados.php";
	
	$rs=$db->conn->Execute($isql);	
	if ($rs->EOF and $busqRadicados)  {
		echo "<hr><center><b><span class='alarmas'>
		      No se encuentra ningun radicado con el criterio de busqueda
			  </span></center></b></hr>";
	} 
	else{
   	   $db->conn->debug = false;
	   $pager = new ADODB_Pager($db,$isql,'adodb', true,$orderNo,$orderTipo);
	   $pager->checkAll = false;
	   $pager->checkTitulo = true; 
	   $pager->toRefLinks = $linkPagina;
	   $pager->toRefVars = $encabezado;
	   $pager->Render($rows_per_page=20,$linkPagina,$checkbox=chkEnviar);	   
	}				
?>		
			</td>
		</tr>
	</TABLE>
</body>
</html>
