<?php
session_start();
error_reporting(0);
$ruta_raiz = "..";
if (!$_SESSION['dependencia'] and !$_SESSION['depe_codi_territorial'])	include "../rec_session.php";
if(!$fecha_busq) $fecha_busq=date("Y-m-d");
if(!$fecha_busq2) $fecha_busq2=date("Y-m-d");
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");	 
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
?>
<html>
<head>
   <link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body>
  <form name="new_product"  action='historicoActas.php?<?=session_name()."=".session_id()."&krd=$krd&fecha_h=$fechah"?>' method=post>
	<TABLE width="300" class='borde_tab' cellspacing="5" align="center">
		<TR>
		    <TD height="30" valign="middle" colspan="2" class='titulos4' align="center">REPORTE ACTAS DE ANULACION GENERADAS</td>
		</tr>
		<tr>
		    <TD height="26" class='titulos2' width="100">Tipo Radicacion</TD>
		    <TD valign="top" align="left"  class='listado2'>
		<?php
			$sqlTR = "select upper(sgd_trad_descr),sgd_trad_codigo 
			          from sgd_trad_tiporad 
			          where sgd_trad_codigo <> 2 
					  order by sgd_trad_codigo";
			$rsTR = $db->query($sqlTR);
			print $rsTR->GetMenu2("tipoRadicado","$tipoRadicado",false, false, 0," class='select'><option value=0>--- TODOS LOS TIPOS --- </option");
		?>    
	 		</TD>
	    </tr>
		<tr>
		    <td height="26" colspan="2" valign="top" class='titulos2'> 
		    <center><INPUT TYPE=submit name=generar_informe title='Ver Actas' value="Buscar" class=botones ></center>
			</td>
		</tr>
	</TABLE><br>
  </form>	
<HR>
<br>
<TABLE width="600" align="center" cellspacing="0" cellpadding="0" class="borde_tab">
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
		$orderNo="2";
		$order = 3;
	}
	else{ $order = $orderNo +1; }		
	$encabezado = "".session_name()."=".session_id()."&krd=$krd&depeBuscada=$depeBuscada&accion_sal=$accion_sal&filtroSelect=$filtroSelect&tipoRadicado=$tipoRadicado&nomcarpeta=$nomcarpeta&orderTipo=$orderTipo&orderNo=";
    $linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";		
		
	$sqlFechaAnul = $db->conn->SQLDate("Y-m-d A h:i","b.sgd_anu_fech");  
	include "$ruta_raiz/include/query/anulacion/querycuerpo_HistoricoActas.php";	
		
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