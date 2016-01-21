<?
session_start();
$verrad = "";
$ruta_raiz = "..";
if (!$dependencia and !$depe_codi_territorial)include "../rec_session.php";

if (!$dep_sel) $dep_sel = $dependencia;
$depeBuscada =$dep_sel; 
?>
<html>
<head>
<title>Untitled Document</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body>
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="js/spiffyCal/spiffyCal_v2_1.css">
<?
 $ruta_raiz = "..";
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
 $db = new ConnectionHandler("$ruta_raiz");
 if(!$dep_sel) $dep_sel = $dependencia;
 $depeBuscada = $dep_sel;

if($generar_listado and !$cancelarAnular)
{
    $indi_generar = "SI";
}
else
{
    $indi_generar = "NO";
}
 if($indi_generar=="SI")
 {
	$encabezado = "".session_name()."=".session_id()."&krd=$krd&num=$num&hora_ini=$hora_ini&hora_fin=$hora_fin&minutos_ini=$minutos_ini&minutos_fin=$minutos_fin&tip_radi=$tip_radi&fecha_busqH=$fecha_busqH&fecha_busq=$fecha_busq&dep_sel=$dep_sel&filtroSelect=$filtroSelect&nomcarpeta=$nomcarpeta&indi_generar=$indi_generar";
    $linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";
    $encabezado = "".session_name()."=".session_id()."&adodb_next_page=1&krd=$krd&num=$num&hora_ini=$hora_ini&hora_fin=$hora_fin&minutos_ini=$minutos_ini&minutos_fin=$minutos_fin&tip_radi=$tip_radi&fecha_busqH=$fecha_busqH&fecha_busq=$fecha_busq&dep_sel=$dep_sel&filtroSelect=$filtroSelect&nomcarpeta=$nomcarpeta&orderTipo=$orderTipo&orderNo=";
 ?>
<script>
function Marcar()
{
	marcados = 0;
	for(i=2;i<document.gen_lisDefi.elements.length;i++)
	{
			if(document.gen_lisDefi.elements[i].checked==1)
			{
				marcados++;
			}
	}
	if(marcados>=1)
	{
	  document.gen_lisDefi.submit();
	}
	else
	{
		alert("Debe marcar un elemento");
	}
}
function markAll()
{
    if(document.gen_lisDefi.elements['checkAll'].checked)
    {
        for(i=1;i<document.gen_lisDefi.elements.length;i++)
        {
            if(document.gen_lisDefi.elements[i].name.slice(0, 10)=='checkValue')
            {
                document.gen_lisDefi.elements[i].checked=1;
            }
        }
    }
    else
    {
        for(i=1;i<document.gen_lisDefi.elements.length;i++)
        {
            document.gen_lisDefi.elements[i].checked=0;
        }
    }
}
</script>

<?
if(strlen($orderNo)==0)  
	{
		$orderNo="2";
		$order = 3;
	}else
	{
		$order = $orderNo +1;
	}
//$db->conn->debug=true;
	//Condicion Dependencia
        if($dep_sel!=9999){
	$dependencia_busq2 = " and c.radi_depe_radi = '$dep_sel'";}
	//Construccion Condicion de Fechas//
	$fecha_ini = $fecha_busq;
	$fecha_fin = $fecha_busqH;
	$fecha_ini = mktime($hora_ini,$minutos_ini,00,substr($fecha_busq,5,2),substr($fecha_busq,8,2),substr($fecha_busq,0,4));
	$fecha_fin = mktime($hora_fin,$minutos_fin,59,substr($fecha_busqH,5,2),substr($fecha_busqH,8,2),substr($fecha_busqH,0,4));
	
	$where_fecha = " and a.sgd_fech_impres BETWEEN
		".$db->conn->DBTimeStamp($fecha_ini)." and ".$db->conn->DBTimeStamp($fecha_fin) ;
	//Condicion Tipo Radicacion
	
	$where_tipRadi .= " and (a.ANEX_ESTADO =3 or (mr.envio_directo=1 and a.ANEX_ESTADO = 4))";
	include "$ruta_raiz/include/query/envios/queryParamListaImpresos.php";
	$rs=$db->conn->Execute($isql);
	if (!$rs->EOF)  {
?>	
	 <table border=0 cellspace=2 cellpad=2 WIDTH=50%  class="t_bordeGris">
	    <tr><td colspan="2" class="titulos4">GENERACI&Oacute;N LISTADO DE ENTREGA</td></tr>
		<tr>
		  <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">FECHA INICIAL :
		  </td>
	        <td  width="65%" height="25" class="listado2_no_identa">
	             <?=$fecha_busq ." ". $hora_ini." : ".$minutos_ini.":00"?>
	        </td>
	    </tr>
		<tr>
		  <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">FECHA FINAL :
		  </td>
	        <td  width="65%" height="25" class="listado2_no_identa">
	            <?=$fecha_busqH." ". $hora_fin." : ".$minutos_fin .":59"?>
	        </td>
	    </tr>
		<tr>
		  <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">FECHA GENERACI&Oacute;N :
		  </td>
	        <td  width="65%" height="25" class="listado2_no_identa">
	            <? echo date("Y-m-d - H:i:s"); ?>
	        </td>
	    </tr>	
		</table>
	
	<form name=gen_lisDefi  action='generaListaImpresos.php?<?=$encabezado?>' method="post">
	<table border=0 cellspace=2 cellpad=2 WIDTH=50%  class="t_bordeGris" >
	<tr tr align= "right">
    <td width="1120" height="26" colspan="2" valign="top" class="titulos2"> 
	
		<INPUT TYPE=submit name=gen_lisDefi Value=' Confirmar ' class=botones id=Confirmar onclick="Marcar();">
	   	<INPUT TYPE=submit name=cancelarListado value=Cancelar class=botones></td></tr>
	</table>
	
<?
		$pager = new ADODB_Pager($db,$isql,'adodb', true,$orderNo,$orderTipo);
		$pager->checkAll = false;
  		$pager->checkTitulo = true; 
		$pager->toRefLinks = $linkPagina;
		$pager->toRefVars = $encabezado;
		$pager->Render($rows_per_page=1000,$linkPagina,$checkbox=chkEnviar);
	} 
	else{
		echo "<hr><center><b><span class='alarmas'>No se encuentra ningun radicado con el criterio de seleccion</span></center></b></hr>";
	}
?>	
 </form>
<?
}
else
{
echo "<hr><center><b><span class='alarmas'>Operacion CANCELADA</span></center></b></hr>";
}
?>
</body>

</html>
