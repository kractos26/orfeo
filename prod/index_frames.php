<?php
error_reporting(0);
session_start();
$krd=strtoupper($krd);
$ruta_raiz = ".";
if(!isset($_SESSION['dependencia'])) include "./rec_session.php";

include_once($ruta_raiz.'/config.php'); 			// incluir configuracion.
include_once($ruta_raiz."/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
if ($db)
{
	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
	include($ruta_raiz."/include/class/Contadores.php");
	$contador = new Contadores($db);
	$numRadicadosUsu = $contador->getContadorRad($_SESSION['dependencia'], $_SESSION['codusuario']);
	$numRadicadosDepe = $contador->getContadorJefe($_SESSION['dependencia']);
	if ($_SESSION["codusuario"] == 1)
	{
		$vencidos = $contador->getContadorJefe($_SESSION['dependencia']);
	}
	$vencidos0= $contador->getContador($_SESSION['dependencia'], $_SESSION['codusuario'], 0);
	$vencidos1= $contador->getContador($_SESSION['dependencia'], $_SESSION['codusuario'], 1);
	$vencidos2= $contador->getContador($_SESSION['dependencia'], $_SESSION['codusuario'], 2);
	$expVencido=$contador->getExpPresVencidos($krd,0);
	$expVencidoBolqueado=$contador->getExpPresVencidos($krd,1);
	
	//$expVencido=$contador->getExpPresVencidos($krd,'7');
}
?>
<html>
<head>
<title>.:: Sistema de Gesti&oacute;n Documental ::.</title>
<link rel="shortcut icon" href="imagenes/arpa.gif">
<script>
function cerrar_ventana()
{	window.close();	}

function alerta()
{
<?php
$tableAlerta = "<html><head><title>ALERTA.</title><link rel='stylesheet' href='./estilos/$ESTILOS_PATH/orfeo.css'></head>";
$tableAlerta .="<script>";
$tableAlerta .="function markAll()";
$tableAlerta .="{";
$tableAlerta .="	if(document.frmSolPrest.elements['checkAll'].checked)";
$tableAlerta .="	{";
$tableAlerta .="		for(i=1;i<document.frmSolPrest.elements.length;i++)";
$tableAlerta .="		{";
$tableAlerta .="			if(document.frmSolPrest.elements[i].name.slice(0, 10)=='checkValue')";
$tableAlerta .="			{";
$tableAlerta .="				document.frmSolPrest.elements[i].checked=true;";
$tableAlerta .="			}";
$tableAlerta .="		}";
$tableAlerta .="	}";
$tableAlerta .="	else";
$tableAlerta .="		for(i=1;i<document.frmSolPrest.elements.length;i++)";
$tableAlerta .="		document.frmSolPrest.elements[i].checked=false;";
$tableAlerta .="}";
$tableAlerta .="function validar()";
$tableAlerta .="{";
$tableAlerta .="	marcados = 0;";
$tableAlerta .="	var aux=0;";
$tableAlerta .="	var auxVal='';";
$tableAlerta .="	for(i=0;i<document.frmSolPrest.elements.length;i++)";
$tableAlerta .="	{	";
$tableAlerta .="		if(document.frmSolPrest.elements[i].checked==true )";
$tableAlerta .="		{";
$tableAlerta .="			if(document.frmSolPrest.elements[i].name!='checkAll')";
$tableAlerta .="			{";
$tableAlerta .="				marcados++;";
$tableAlerta .="				if(aux>0)auxVal = document.frmSolPrest.elements[aux].value;";
$tableAlerta .="				else  auxVal = document.frmSolPrest.elements[i].value;";
$tableAlerta .="				if(auxVal!=document.frmSolPrest.elements[i].value)";
$tableAlerta .="				{";
$tableAlerta .="					alert('Debe seleccionar registros de un solo Usuario');";
$tableAlerta .="					return false;";
$tableAlerta .="				}";
$tableAlerta .="				aux=i;";
$tableAlerta .="			}";
$tableAlerta .="	    }";
$tableAlerta .="	}";
$tableAlerta .="	if(marcados)return true;";
$tableAlerta .="	else ";
$tableAlerta .="	{	";
$tableAlerta .="		alert('Debe seleccionar un registro');";
$tableAlerta .="	    return false;";
$tableAlerta .="	 }";
$tableAlerta .="}\<\/script\>";
$tableAlerta .="<body><form name='frmSolPrest' method='post' action='./expediente/prestamo/renovar.php?krd=$krd'><center><table border=1 class=t_bordeGris>";
//$tableAlerta .="<tr class='titulos4'><td colspan=3><h3>VENCIMIENTOS DE RADICADOS</h3></td></tr>";
if($vencidos > 0 || $numRadicadosUsu > 0 || $vencidos0>0 || $vencidos1>0 || $vencidos2>0)
	$tableAlerta .="<tr class='titulos4'><td colspan=3><h3>VENCIMIENTOS DE RADICADOS </h3></td></tr>";
if($vencidos > 0)
{
	$arreglo = array();
	$arreglo = $contador->getRadicadosJefe($_SESSION['dependencia']);
	$tableAlerta .="<tr class='titulos2' ><td colspan=3>Estimado Jefe:<br>En su dependencia tiene $vencidos Radicados para vencer hoy estos son:</td></tr>";
	foreach ( $arreglo as $numeroRadicado )
	{
		$tableAlerta .="<tr><td class=listado2 colspan=3>".$numeroRadicado."</td></tr>";
	}
}
if ($numRadicadosUsu > 0)
{
	$arreglo0 = array();
	$arreglo1 = array();
	$arreglo2 = array();
	$arreglo0 = $contador->getRadicados($_SESSION['dependencia'], $_SESSION['codusuario'], 0);
	$arreglo1 = $contador->getRadicados($_SESSION['dependencia'], $_SESSION['codusuario'], 1);
	$arreglo2 = $contador->getRadicados($_SESSION['dependencia'], $_SESSION['codusuario'], 2);
	
	if ($vencidos0>0)
	{
		$tableAlerta .="<tr class='titulos2'><td colspan=3>Tiene ".$vencidos0." Radicados Para Vencer Hoy:</td></tr>";
		foreach ( $arreglo0 as $numeroRadicado0 )
		{
			$tableAlerta.= "<tr><td class=listado2 colspan=3>".$numeroRadicado0."</td></tr>";
		}
	}
	if ($vencidos1>0)
	{
		$tableAlerta .="<tr class='titulos2'><td colspan=3>Tiene ".$vencidos1." Radicados Para Vencer Ma&ntilde;ana:</td></tr>";
		foreach ( $arreglo1 as $numeroRadicado1 )
		{
			$tableAlerta .= "<tr><td class=listado2 colspan=3>".$numeroRadicado1."</td></tr>";
		}
	}
	if ($vencidos2)
	{
		$tableAlerta .="<tr class='titulos2'><td colspan=3>Tiene ".$vencidos2." Radicados Para Vencer En 2 D&iacute;as:</td></tr>";
		foreach ( $arreglo2 as $numeroRadicado2 )
		{
			$tableAlerta .= "<tr><td class=listado2 colspan=3>".$numeroRadicado2."</td></tr>";
		}
	}
	
}
if(count($expVencido) || count($expVencidoBolqueado))
{
	$tableAlerta .="<tr class='titulos4'><td colspan=3><h3>VENCIMIENTOS DE EXPEDIENTES Y RADICADOS EN PRESTAMO</h3></td></tr>";
	if(count($expVencido))
	{
		if(count($expVencido)==1)$s="";else$s="s";
		$v = "<br><input name='checkAll' value='checkAll' onclick='markAll();' checked='checked' type='checkbox'>";
		$tableAlerta .="<tr class='titulos2' ><td colspan=3>Los siguientes Expedientes y Radicados est&aacute;n Vencidos y pueden ser renovados</td></tr>";//Tiene ".count($expVencido)." Expediente$s en Prestamo Vencido$s:</td><td>$v</td></tr>";
		$tableAlerta .="<tr class='titulos2'><td>DOCUMENTO</td><td>FECHA DE VENCIMIENTO</td><td>$v</td></tr>";
		foreach ( $expVencido as $numeroRadicado2=>$value )
		{
			$v = "<input name='checkValue[".$value["PRES_ID"]."]' value='".$value["PRES_ID"]."' checked='checked' type='checkbox'>";
			$tableAlerta .= "<tr><td class='listado2'  >".$value["OBJETO"]."</td><td class='listado2'  >".$value["VENCIMIENTO"]."</td><td class='listado2'>$v</td></tr>";
		}
		$tableAlerta .= "<tr><td class='listado2' colspan=3 ><center><input type=submit name=btn_accion value=Renovar class=botones onclick='return validar();'></center></td></tr>";
	}
	if(count($expVencidoBolqueado))
	{
		if(count($expVencidoBolqueado)==1)$s="";else$s="s";
		$tableAlerta .="<tr class='titulos2'><td colspan=3>Los siguientes Expedientes y Radicados est&aacute;n Vencidos y no puden ser renovados </td></tr>";//Tiene ".count($expVencidoBolqueado)." Expedientes Vencidos Bloqueados:</td></tr>";
		foreach ( $expVencidoBolqueado as $numeroRadicado2=>$value )
		{
			$tableAlerta .= "<tr><td class='listado2' colspan=3 >".$value["OBJETO"]."</td></tr>";
		}
	}
}


$tableAlerta .="</td></tr></table></form><p align=center><input type=button name=btn_close value=Cerrar class=botones onclick=window.close()></p></body></html>";
if (($vencidos0>0) || ($numRadicadosUsu > 0) || count($expVencido)>0 || count($expVencidoBolqueado)>0 || count($radVencidoBolqueado)>0)
{
?>
	var posx = (screen.availWidth/2)-240;
    var altoPantalla  = screen.availHeight;
	ventana = window.open(' Radicados ','Radicados Vencidos','left='+posx+',height='+altoPantalla+',menubar=no,scrollbars=yes,width=480');
	ventana.opener = self;
	ventana.document.write("<?php echo ($tableAlerta) ?>");
	ventana.document.close();
<?php
}
?>
}
</script>
</head>
<frameset rows="40,864*" frameborder="NO" border="0" framespacing="0" cols="*" onload="alerta();">
	<frame name="topFrame" scrolling="NO" noresize src='f_top.php?<?=session_name()."=".session_id()?>&fechah=<?=$fechah?>' >
	<frameset cols="175,947*" border="0" framespacing="0" rows="*">
    	<frame name='leftFrame' scrolling='AUTO' src='correspondencia.php?<?=session_name()."=".session_id()?>&fechah=<?=$fechah?>' marginwidth='0' marginheight='0' scrolling='AUTO'/>
<!--    	<frame name='mainFrame' src='alertas/index.php?<?=session_name()."=".session_id()?>&swLog=<?=$swLog?>&fechah=<?=$fechah?>&tipo_alerta=1' scrolling='AUTO'/>-->
        <frame name='mainFrame' src='paginaInicial.html' scrolling='AUTO'>
	</frameset>
	<noframes></noframes>
</frameset>
</html>