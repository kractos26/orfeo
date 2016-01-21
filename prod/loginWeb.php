<html><?php
/** FORMULARIO DE LOGIN A ORFEO
  * Aqui se inicia session 
	* @PHPSESID		String	Guarda la session del usuario
	* @db 					Objeto  Objeto que guarda la conexion Abierta.
	* @iTpRad				int		Numero de tipos de Radicacion
	* @$tpNumRad	array 	Arreglo que almacena los numeros de tipos de radicacion Existentes
	* @$tpDescRad	array 	Arreglo que almacena la descripcion de tipos de radicacion Existentes
	* @$tpImgRad	array 	Arreglo que almacena los iconos de tipos de radicacion Existentes
	* @query				String	Consulta SQL a ejecutar
	* @rs					Objeto	Almacena Cursor con Consulta realizada.
	* @numRegs		int		Numero de registros de una consulta
	*/
    $fechah = date("Ymd") . "T" . time("h_m_s");
	$ruta_raiz = ".";
	$usua_nuevo=3;
	error_reporting(0);
if ($krd)
	{
	$recOrfeo="loginWeb";
	include "$ruta_raiz/session_orfeo.php";
	if($usua_nuevo==0)
		{
			
			include($ruta_raiz."/contraxx.php");
			$ValidacionKrd = "NOOOO";
			if($j=1) die("<center> -- </center>");
		}
  }
	$krd = strtoupper($krd);
	$datosEnvio = "$fechah&".session_name()."=".trim(session_id())."&krd=$krd";
?><head>
<title>.:: ORFEO, M&oacute;dulo de validaci&oacute;n::.</title>
<link href="estilos_totales.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="imagenes/arpa.gif">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
  } if (errors) alert('Asegurese de entrar usuario y password correctos:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<script>
function loginTrue()
{
	document.formulario.submit();
}
</script>
</head>
<body bgcolor="#336699" leftmargin="0" topmargin="0">	


<table width="125" border="0" align="left">
<form name=formulario action='index_frames.php?fechah=<?=$datosEnvio?>'  method=post target="Orfeo<?="krd=$krd&fechah=$fechah"?>" >
<input type="hidden" name="orno" value="1">
<?
if($ValidacionKrd=="Si")	
{
?>
<script>
loginTrue();
</script>
<?
}
?>
<input type="hidden" name="ornot" value="1">
</form>
<form action="loginWeb.php?fechah=<?=$fechah?>" method="post" onSubmit="MM_validateForm('krd','','R','drd','','R');return document.MM_returnValue" name="form33">
<form action="loginWeb.php?fechah=<?$fechah ?>" method="post" autocomplete="off" onSubmit="MM_validateForm('krd','','R','drd','','R');return document.MM_returnValue" target="login" >
  <tr>
  <td align="left" bgcolor="#336699">      
	<input type=hidden name=tipo_carp value=0>
	<input type=hidden name=carpeta value=0>
	<input type=hidden name=order value='radi_nume_radi'>
	<tr align="center">
		<td height="30" align="right"><font size="3"><b><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">Usuario</font></b></font></td>
		<td height="30"><input type="text" name="krd" size="8" autocomplete="off" ></td>
	</tr>
	<tr align="center">
		<td width="36%" height="30" align="right"> <font size="3"><b><font size="3" face="Arial, Helvetica, sans-serif"> </font><font size="3" face="Arial, Helvetica, sans-serif"> </font><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">Clave</font></b></font></td>
		<td width="64%" height="30"><input type=password name="drd" autocomplete="off" size="8"></td>
	</tr>
	<tr align="center">
		<td colspan="2">
			<input name="Submit" type="submit" class="ebuttons2" value="INGRESAR">
		</td>
	</tr>
	</td></tr></form></form>
</table>
</body>
</html>