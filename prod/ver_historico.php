<html>
<head>
<title>Untitled</title>
<link rel="stylesheet" href="estilos/"<?=$_SESSION["ESTILOS_PATH"]."/orfeo.css"?>>
</head>
<body >
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="borde_tab">
  <tr > 
    <td class="titulosenca2" colspan="6" >HIST&Oacute;RICO </td>
  </tr>
</table>
<?php
	   require_once("$ruta_raiz/class_control/Transaccion.php");
		 require_once("$ruta_raiz/class_control/Dependencia.php");
		 require_once("$ruta_raiz/class_control/usuario.php");
	   error_reporting(7);
	   $trans = new Transaccion($db);
	   $objDep = new Dependencia($db);
	   $objUs = new Usuario($db);
	   $isql = "select USUA_NOMB from usuario where depe_codi=$radi_depe_actu and usua_codi=$radi_usua_actu";
           echo $isql;
	   $rs = $db->query($isql);			      	   
	   $usuario_actual = $rs->fields["USUA_NOMB"];
	   $isql = "select DEPE_NOMB from dependencia where depe_codi=$radi_depe_actu";
	   $rs = $db->query($isql);			      	   
	   $dependencia_actual = $rs->fields["DEPE_NOMB"];
	   $isql = "select USUA_NOMB from usuario u 
                    join hist_eventos h on u.usua_doc=h.usua_doc
                    where h.radi_nume_radi=$verrad and sgd_ttr_codigo in (2,30) ";
	   $rs = $db->query($isql);			      	   
	   $usuario_rad = $rs->fields["USUA_NOMB"];
	   $isql = "select DEPE_NOMB from dependencia where depe_codi=$radi_depe_radicacion";
	   $rs = $db->query($isql);			      	   
	   $dependencia_rad = $rs->fields["DEPE_NOMB"];
	   $isql = "select DEPE_NOMB from dependencia where depe_codi=$radi_depe_radi";
	   $rs = $db->query($isql);			      	   
	   $dependencia_asig = $rs->fields["DEPE_NOMB"];
?>
<table  width="100%"  align="center"  border="0" cellpadding="0" cellspacing="5" class="borde_tab"  >
  <tr   align="left">
    <td width=10% class="titulos2" height="24">USUARIO ACTUAL</td>
    <td  width=15% class="listado2" height="24" align="left"><?=$usuario_actual?></td>
    <td width=10% class="titulos2" height="24">DEPENDENCIA ACTUAL</td>
    <td  width=15% class="listado2" height="24"><?=$dependencia_actual?></td>
  </tr>
  <tr   align="left">
    <td  class="titulos2" height="24">DEPENDENCIA ASIGNADA</td>
    <td  class="listado2" height="24" align="left" colspan="3"><?=$dependencia_asig?></td>
  </tr>
    <tr  class='etextomenu' align="left">
    <td width=10% class="titulos2" height="24">USUARIO RADICADOR </td>
    <td  width=15% class="listado2" height="24"><?=$usuario_rad?></td>
    <td width=10% class="titulos2" height="24">DEPENDENCIA DE RADICACI&Oacute;N </td> 
    <td  width=15% class="listado2" height="24"><?=$dependencia_rad?></td>
  </tr>
 </table>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="25" class="titulos4">FLUJO HIST&Oacute;RICO DEL DOCUMENTO</td>
  </tr>
</table>
<table  width="100%" align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab" >
  <tr   align="center">
    <td width=10% class="titulos2" height="24">DEPENDENCIA </td>
    <td  width=5% class="titulos2" height="24">FECHA</td>
     <td  width=15% class="titulos2" height="24">TRANSACCI&Oacute;N </td>  
    <td  width=15% class="titulos2" height="24" >US. ORIGEN</td>
		<?
		 /** Esta es la columna que se elimino de forma Temporal  USUARIO - DESTINO
			 * <td  width=15% class="grisCCCCCC" height="24" ><font face="Arial, Helvetica, sans-serif"> US. DESTINO</font></td>
			 */
		?>
    <td  width=40% height="24" class="titulos2">COMENTARIO</td>
  </tr>
  <?
  $sqlFecha = $db->conn->SQLDate("d-m-Y H:i A","a.HIST_FECH");

	$isql = "select $sqlFecha AS HIST_FECH1
      , a.DEPE_CODI
			, a.USUA_CODI
			,a.RADI_NUME_RADI
			,a.HIST_OBSE 
			,a.USUA_CODI_DEST
			,a.USUA_DOC
			,a.HIST_OBSE
			,a.SGD_TTR_CODIGO
			from hist_eventos a
		 where 
			a.radi_nume_radi =$verrad
			order by hist_fech desc ";  

	$i=1;
        
	$rs = $db->query($isql);
	IF($rs)
	{
    while(!$rs->EOF)
	 {
		$usua_doc_dest = "";
		$usua_doc_hist = "";
		$usua_nomb_historico = "";
		$usua_destino = "";
		$numdata =  trim($rs->fields["CARP_CODI"]);
		if($data =="") $rs1->fields["USUA_NOMB"];
	   		$data = "NULL";
		$numerot = $rs->fields["NUM"];
		$usua_doc_hist = $rs->fields["USUA_DOC"];
		$usua_codi_dest = $rs->fields["USUA_CODI_DEST"];
		$usua_dest=intval(substr($usua_codi_dest,3,3));
		$depe_dest=intval(substr($usua_codi_dest,0,3));
		$usua_codi = $rs->fields["USUA_CODI"];
		$depe_codi = $rs->fields["DEPE_CODI"];
		$codTransac = $rs->fields["SGD_TTR_CODIGO"];
		$descTransaccion = $rs->fields["SGD_TTR_DESCRIP"];
    if(!$codTransac) $codTransac = "0";
		$trans->Transaccion_codigo($codTransac);
		$objUs->usuarioDocto($usua_doc_hist);
		$objDep->Dependencia_codigo($depe_codi);

		error_reporting(7);
		if($carpeta==$numdata)
			{
			$imagen="usuarios.gif";
			}
		else
			{
			$imagen="usuarios.gif";
			}
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
	<?=$rs->fields["HIST_FECH1"]?>
 </td>
<td class="listado2"  >
  <?=$trans->getDescripcion()?>
</td>
<td class="listado2"  >
   <?=$objUs->get_usua_nomb()?>
</td>
		<?
		 /**
			 *  Campo qque se limino de forma Temporal USUARIO - DESTINO 
			 * <td class="celdaGris"  >
			 * <?=$usua_destino?> </td> 
			 */
		?>
			 <td class="listado2"><?=$rs->fields["HIST_OBSE"]?></td>
  </tr>
  <?
	$rs->MoveNext();
  	}
}
  // Finaliza Historicos
	?>
</table>
  <?
  //empieza datos de envio
include "$ruta_raiz/include/query/queryver_historico.php";

$isql = "select $numero_salida from anexos a where a.anex_radi_nume=$verrad";
$rs = $db->query($isql);			      	   	
$radicado_d= "";
while(!$rs->EOF)
	{
		$valor = $rs->fields["RADI_NUME_SALIDA"];
		if(trim($valor))
		   {
		      $radicado_d .= "'".trim($valor) ."', ";
		   }
		$rs->MoveNext();   		  
	}  

$radicado_d .= "$verrad";
error_reporting(7);

include "$ruta_raiz/include/query/queryver_historico.php";
$sqlFechaEnvio = $db->conn->SQLDate("d-m-Y H:i A","a.SGD_RENV_FECH");
$isql = "select $sqlFechaEnvio AS SGD_RENV_FECH,
		a.DEPE_CODI,
		a.USUA_DOC,
		a.RADI_NUME_SAL,
		a.SGD_RENV_NOMBRE,
		a.SGD_RENV_DIR,
		a.SGD_RENV_MPIO,
		a.SGD_RENV_DEPTO,
		a.SGD_RENV_PLANILLA,
		b.DEPE_NOMB,
		c.SGD_FENV_DESCRIP,
		$numero_sal,
		a.SGD_RENV_OBSERVA,
		a.SGD_DEVE_CODIGO
		from sgd_renv_regenvio a, dependencia b, sgd_fenv_frmenvio c
		where
		a.radi_nume_sal in($radicado_d)
		AND a.depe_codi=b.depe_codi
		AND a.sgd_fenv_codigo = c.sgd_fenv_codigo and a.sgd_renv_planilla != '00'
		order by a.SGD_RENV_FECH desc ";
$rs = $db->query($isql);
?>
 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
  <tr>
    <td height="25" class="titulos4">DATOS DE ENV&Iacute;O</td>
  </tr>
</table>
<table width="100%"  align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab" >
  <tr  align="center">
    <td width=10% class="titulos2" height="24">RADICADO </td>
    <td width=10% class="titulos2" height="24">DEPENDENCIA</td>
    <td  width=15% class="titulos2" height="24">FECHA </td>
    <td  width=15% class="titulos2" height="24">DESTINATARIO</td>      
    <td  width=15% class="titulos2" height="24" >DIRECCI&Oacute;N </td>
    <td  width=15% class="titulos2" height="24" >DEPARTAMENTO </td>
    <td  width=15% class="titulos2" height="24" >MUNICIPIO</td>
    <td  width=15% class="titulos2" height="24" >TIPO DE ENV&Iacute;O</td>
    <td  width=5% height="24" class="titulos2"> N&Uacute;MERO DE GU&iacute;A</td>
    <td  width=15% height="24" class="titulos2">OBSERVACIONES O DESC DE ANEXOS</td>      
  </tr>
  <?php
$i=1;
while(!$rs->EOF)
	{
	$radDev = $rs->fields["SGD_DEVE_CODIGO"];
	$radEnviado = $rs->fields["RADI_NUME_SAL"];
	if($radDev)
	{
		$imgRadDev = "<img src='$ruta_raiz/imagenes/devueltos.gif' alt='Documento Devuelto por empresa de Mensajeria' title='Documento Devuelto por empresa de Mensajeria'>";
	}else
	{
		$imgRadDev = "";
	}
	$numdata =  trim($rs->fields["CARP_CODI"]);
	if($data =="") 
		$data = "NULL";
	//$numerot = $rs->RecordCount();
	if($carpeta==$numdata)
		{
		$imagen="usuarios.gif";
		}
	else
		{
		$imagen="usuarios.gif";
		}
	if($i==1)
		{
   ?>
  <tr > <?  $i=1;
			}
			 ?>
    <td class="listado2" >
	<?=$imgRadDev?><?=$radEnviado?></td>
    <td class="listado2" >
	<?=$rs->fields["DEPE_NOMB"]?></td>
    <td class="listado2">
	<?
		echo "<a class=vinculos href='./verradicado.php?verrad=$radEnviado&krd=$krd' target='verrad$radEnviado'><span class='timpar'>".$rs->fields["SGD_RENV_FECH"]."</span></a>";
	?> </td>
    <td class="listado2">
	<?=$rs->fields["SGD_RENV_NOMBRE"]
	?> </td>
    <td class="listado2"  >
	<?=$rs->fields["SGD_RENV_DIR"]?> </td>
    <td class="listado2"  >
	 <?=$rs->fields["SGD_RENV_DEPTO"] ?> </td>
    <td class="listado2"  >
	 <?=$rs->fields["SGD_RENV_MPIO"] ?> </td>
    <td class="listado2"  >
	 <?=$rs->fields["SGD_FENV_DESCRIP"] ?> </td>
    <td class="listado2"  >
	 <?=$rs->fields["SGD_RENV_PLANILLA"] ?> </td>
    <td class="listado2"  >
	 <?=$rs->fields["SGD_RENV_OBSERVA"] ?> </td>
  </tr>
  <?
	$rs->MoveNext();  
  }

  // Finaliza Historicos
	?>
</table>
</body>
</html>