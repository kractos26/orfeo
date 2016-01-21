<?
session_start();
$ruta_raiz = ".."; 
$dependencia = $_SESSION['dependencia'];
$codusuario = $_SESSION['codusuario'];
if (!isset($_SESSION['dependencia']))  include "$ruta_raiz/rec_session.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler($ruta_raiz);	 
//$db->conn->debug=true;
?>
<html>
<head>

<title>HISTORICO ARCHIVO CENTRAL</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body >
<table width="1024" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr bgcolor="#006699">
    <td class="titulos4" colspan="6" ><center>HISTORICO ARCHIVO CENTRAL </center></td>
	 </tr>
</table>

<?php
	require_once("$ruta_raiz/class_control/Transaccion.php");
	require_once("$ruta_raiz/class_control/Dependencia.php");
	require_once("$ruta_raiz/class_control/usuario.php");
	$trans = new Transaccion($db);
	$objDep = new Dependencia($db);
	$objUs = new Usuario($db);
	$isql = "select USUA_NOMB from usuario where depe_codi=$dependencia and usua_codi=$codusuario";
	$rs = $db->query($isql);			      	   
	$usuario_actual = $rs->fields["USUA_NOMB"];
//include_once "$ruta_raiz/flujoGrafico.php";
?>
<center>
<table  width="1024" align="center" border="0" cellpadding="0" cellspacing="1" class="borde_tab" >
  <tr   align="center">
    <td class="titulos2" height="24">DEPENDENCIA </td>
    <td  class="titulos2" height="24">FECHA</td>
     <td class="titulos2" height="24">TRANSACCION </td>  
    <td  class="titulos2" height="24" >USUARIO</td>
    <td  height="24" class="titulos2">COMENTARIO</td>
  </tr>
  <?php
	$sqlFecha = $db->conn->SQLDate("Y-m-d h:i:s a","ha.HIST_FECH");
 	$isql = "SELECT $sqlFecha as HIST_FECH,
			ha.DEPE_CODI,
			ha.USUA_CODI,
			ha.HIST_OBSE as HIST_OBSERVA,
			ha.USUA_DOC,
			ha.SGD_TTR_CODIGO,
			$sqlFecha as FECHA
		FROM SGD_ARCHIVO_HIST ha
		WHERE 	ha.SGD_ARCHIVO_RAD like  '$rad'
		ORDER BY ha.HIST_FECH DESC";  

	$i=1;
	$rs = $db->query($isql);
if($rs)
{
	
    while(!$rs->EOF)
	 {
		$data = "NULL";
		$usua_doc_hist = $rs->fields["USUA_DOC"];
		$usua_codi = $rs->fields["USUA_CODI"];
		$depe_codi = $rs->fields["DEPE_CODI"];
		$codTransac = $rs->fields["SGD_TTR_CODIGO"];
		$descTransaccion = $rs->fields["SGD_TTR_DESCRIP"];
    if(!$codTransac) $codTransac = "0";
		$trans->Transaccion_codigo($codTransac);
		$objUs->usuarioDocto($usua_doc_hist);
		$objDep->Dependencia_codigo($depe_codi);

		if($i==1)
			{
		?>
  <tr class='tpar'> <?  
		    $i=1;
			}
			 ?>
    <td class="listado2" >
	<?=$objDep->getDepe_nomb()?></td>
    <td class="listado2">
	<?
			$expFechaHist = $rs->fields["HIST_FECH"];
			echo $expFechaHist;
	?>
 </td>
<td class="listado2"  >
  <?=$trans->getDescripcion()?>
</td>
<td class="listado2"  >
   <?=$objUs->get_usua_nomb()?>
</td>
<td class="listado2" width="200"><?=$rs->fields["HIST_OBSERVA"]?></td>
  </tr>
  <?
	$rs->MoveNext();
  	}
}
  // Finaliza Historicos
	?>
	<tr>
	<td colspan="5" align="center"><a href='busqueda_central.php?<?=session_name()?>=<?=trim(session_id())?>krd=<?=$krd?>&Buscar'><input name='Regresar' align="middle" type="button" class="botones" id="envia22" value="Regresar" ></td>
	</tr>
</table>

</body>
</html>
