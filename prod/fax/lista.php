<?php
error_reporting(0);
$krdAnt = $krd;
session_start(); 
if(!$krd)  $krd = $krdAnt;
$ruta_raiz = "..";
if (!$dependencia)   include "../rec_session.php";
error_reporting(7);
$fechah = date("ymd") ."_". time("hms");
?> 
<head>
<html>
<head>
  <title>lista</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <link rel="stylesheet" type="text/css" href="../estilos/orfeo.css">
  <script language="JavaScript">
	function outbox()
	{
		parent.formulario.location.href="send.php";
	}
  </script>
</head>
<body vlink="#6666CC" alink="#6666CC" link="#6666CC">
<?php include("functions.php"); ?>
<table width="100%" border="0" class=borde_tab>
<tr class=titulos5>
	<td>Faxes</td>
</tr>
</table>
<table width="100%" border="0" class=borde_tab>
<tr class=listado1>
	<td>
		<img src="../iconos/folder_open.gif" width="20" height="20" border="0">
		<a href="form.php?lista=inbox&<?=session_name()."=".session_id() ?>&krd=<?=$krd?>&<? echo "fechah=$fechah&usr=".md5($dep)."&primera=1&ent=2&depende=$dependencia"; ?>" ssh="Tiene <?php print " ()";?> fax(es) nuevo(s) " class="etextomenu" target="formulario">
Entrada<?php print " ()";?>
	</a>
      </td>
    </tr>
    <tr class=listado1>
       <td><img src="../iconos/folder_open.gif" width="20" height="20" border="0">
      <a href="form.php?lista=outbox&<?=session_name()."=".session_id() ?>&krd=<?=$krd?>&<? echo "fechah=$fechah&usr=".md5($dep)."&primera=1&ent=2&depende=$dependencia"; ?>" class="etextomenu" ssh="Faxes Enviados" target="formulario">Salida</a></td>
    </tr>
    <tr class=listado1>
    	<td><img src="../iconos/folder_open.gif" width="20" height="20" border="0">
      <a href="form.php?lista=process&<?=session_name()."=".session_id() ?>&krd=<?=$krd?>&<? echo "fechah=$fechah&usr=".md5($dep)."&primera=1&ent=2&depende=$dependencia"; ?>" class="etextomenu" ssh="Faxes en Proceso de Envio" target="formulario">En Proceso</a></td>
    </tr>
    <tr class=listado1>
    	<td><img src="../iconos/folder_open.gif" width="20" height="20" border="0">
      <a href="http://172.16.1.168/fax/form.php?<?=session_name()."=".session_id() ?>&krd=<?=$krd?>&<? echo "fechah=$fechah&usr=".md5($dep)."&primera=1&ent=2&depende=$dependencia"; ?>"  ssh="Enviar Fax" onclick="outbox();" class="etextomenu" target="formulario">Fax</a></td>
    </tr>
    <tr class=listado1>
      <td>
      	<img src="../iconos/folder_open.gif" width="20" height="20" border="0">
      	<a href="form.php?lista=faxStat&<?=session_name()."=".session_id() ?>&krd=<?=$krd?>&<? echo "fechah=$fechah&usr=".md5($dep)."&primera=1&ent=2&depende=$dependencia"; ?>" ssh="Estado de Modem " class="etextomenu" target="formulario">
		Estado de Modem
	</a>
      </td>
    </tr>
 <tr class=listado1>
      <td>
      	<img src="../iconos/folder_open.gif" width="20" height="20" border="0">
      	<a href="form.php?lista=historico&<?=session_name()."=".session_id() ?>&krd=<?=$krd?>&<? echo "fechah=$fechah&usr=".md5($dep)."&primera=1&ent=2&depende=$dependencia"; ?>" ssh="Tiene <?php print " ()";?> fax(es) nuevo(s) " class="etextomenu" target="formulario">
		Fax Historico<?php print " ()";?>
	</a>
      </td>
    </tr>
  </tbody>
</table>
</body>
</html>