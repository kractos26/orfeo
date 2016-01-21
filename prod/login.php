<?php
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
$fechah = date("dmy") . "_" . time("hms");
$ruta_raiz = ".";
$usua_nuevo=3;
error_reporting(0);
include_once("config.php");
 	
if ($krd)
{

	include "$ruta_raiz/session_orfeo.php";
	require_once("$ruta_raiz/class_control/Mensaje.php");
	//$db->conn->debug = true;

	if($usua_nuevo==0)
	{
		include($ruta_raiz."/contraxx.php");
		$ValidacionKrd = "NOOOO";
		die("<center> -- </center>");
	}
}
$krd = strtoupper($krd);
$datosEnvio = "$fechah&".session_name()."=".trim(session_id())."&krd=$krd&swLog=1";
?>
<head>
<title>.:: ORFEO, M&oacute;dulo de validaci&oacute;n::.</title>
<link href="estilos/orfeo.css" rel="stylesheet" type="text/css">
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
  for (i=0; i<args.length-2; i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
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
// Script Source: CodeLifter.com
// Copyright 2003
// Do not remove this header
//-->
</script>
<script>
isIE=document.all;
isNN=!document.all&&document.getElementById;
isN4=document.layers;
isHot=false;
var tempX = 0;
var tempY = 0;
//alert(isN4);
function ddInit(e){
  
  hotDog=isIE ? event.srcElement : e.target;  
  topDog=isIE ? "BODY" : "HTML";
  
  //capa = 
   
  
 
  while (hotDog.id.indexOf("Mensaje")==-1&&hotDog.tagName!=topDog){
    hotDog=isIE ? hotDog.parentElement : hotDog.parentNode;
  }  
  size=hotDog.id.length;
  capa = (hotDog.id.substring(size-1,size)); //returns "exce"
  whichDog=isIE ? document.all.theLayer : document.getElementById("capa"+capa); 
  if (hotDog.id.indexOf("Mensaje")!=-1){
  	 
    offsetx=isIE ? event.clientX : e.clientX;
    offsety=isIE ? event.clientY : e.clientY;
    nowX=parseInt(whichDog.style.left);
    nowY=parseInt(whichDog.style.top);
    ddEnabled=true;
    document.onmousemove=dd;
  }
}

function dd(e){
  
  if (!ddEnabled) return;
  whichDog.style.left=isIE ? nowX+event.clientX-offsetx : nowX+e.clientX-offsetx; 
  whichDog.style.top=isIE ? nowY+event.clientY-offsety : nowY+e.clientY-offsety;
  return false;  
}

function ddN4(layer){
	
 isHot=true;
 // if (!isN4) return;
  if (document.layers) isN4=document.layers
   	else if (document.all)  isN4= document.all[layer];
  		else if (document.getElementById)  isN4= document.getElementById(layer); 

  N4 = document.getElementById(layer); 
  
  //alert (document.all);		
 if (document.all) 
  	alert ("hay documento ");
 // N4 = isN4;
 // alert (document.layers);
   //alert ("va...");
  // alert (N4); 
  window.captureEvents(Event.MOUSEDOWN|Event.MOUSEUP);
   N4.onmousedown=function(e){
   tempX = e.pageX;
   tempY = e.pageY;   	
   
    
  }
  
  isN4.onmousemove=function(e){
  	
    if (isHot){
      if (document.layers){ document.layers[layer].left = e.pageX-tempX;}
	  else if (document.all){document.all[layer].style.left=e.pageX-tempX;}
	  else if (document.getElementById){document.getElementById(layer).style.left=e.pageX-tempX; }
	  // Set ver 
	 if (document.layers){document.layers[layer].top = e.pageY-tempY;}
	 else if (document.all){document.all[layer].style.top=e.pageY-tempY;}
	 else if (document.getElementById){document.getElementById(layer).style.top=e.pageY-tempY}

	 // N4.moveBy( e.pageX-tempX,e.pageY-tempY);
      return false;
    }
  }
  N4.onmouseup=function(){
   // N4.releaseEvents(Event.MOUSEMOVE);
  }
}

function hideMe(layer){
	
  if (document.layers) document.layers[layer].visibility = 'hide';
   	else if (document.all)  	document.all[layer].style.visibility = 'hidden';
  		else if (document.getElementById) document.getElementById(layer).style.visibility = 'hidden'; 
}

function showMe(layer){
  if (document.layers) document.layers[layer].visibility = 'show';
   	else if (document.all)  	document.all[layer].style.visibility = 'visible';
  		else if (document.getElementById) document.getElementById(layer).style.visibility = 'visible';   	
}

document.onmousedown=ddInit;
document.onmouseup=Function("ddEnabled=false");

</script>
<script>
function loginTrue()
{
	document.formulario.submit();
}
</script>
</head>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	color: #387c44;
	background-color: #FFFFFF;
}
-->
</style>
<body valign=center onLoad='document.getElementById("krd").focus();'>	

<br><br>
<form name=formulario action='index_frames.php?fechah=<?=$datosEnvio?>'  method=post >
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
<form action="login.php" method="post" onSubmit="MM_validateForm('krd','','R','drd','','R');return document.MM_returnValue" name="form33">
<table align="center" width="580" height="500" border="0" background="imagenes/index_web_login.jpg">
<tr align="center" >
	<td height="15%"><font color="white" face="Verdana" size="3" >Sistema de Gesti&oacute;n Documental</font></td>
</tr>
<tr align="center">
	<td height="65%" valign="top"><br><br><br><br><br><br><br><br>
		<table border="0" cellpadding="0" cellspacing="5" align="center">
		<tr>
			<td class="titulos2" align="center">USUARIO</td>
			<td class="titulos2" align="center">CONTRASE&Ntilde;A</td>
		</tr>
		<tr align="left">
			<td width="50%" align="center"> 
				<font size="3" face="Arial, Helvetica, sans-serif">
				<input type="text" id='krd' name="krd" size="13" class="tex_area">
				</font>
			</td>
			<td width="50%" align="center" >
				<b><font size="3" face="Arial, Helvetica, sans-serif">
				<input type=password name="drd" id="drd" size="13" class="tex_area">
				</font></b>
			</td>
		</tr>
		<tr>
			<td colspan="2" height="35" align="center">
				<input type=hidden name=tipo_carp value=0>
				<input type=hidden name=carpeta value=0>
				<input type=hidden name=order value='radi_nume_radi'>
				<input name="Submit" type="submit" class="botones" value="INGRESAR">
				<input type="reset" value="BORRAR" class="botones" name="reset">
			</td>
		</tr>
                <tr>
			<td colspan="2" height="35" align="center">
				<?php if(isset($ambiente)){?>
                                    <font size="3" style="color: #FF7D27" ><?php echo $ambiente?></font>
                                <?php } ?>
			</td>
		</tr>
                <tr>
                    
			<td colspan="2" align="center">
                            <img src="logoEntidadLogin.png" <?php echo $dimencionLogoLogin?> />
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td height="30%" align="center">
		<font face="Arial Narrow" style="font-weight: bold;color:white;" size="2"><?= $entidad_largo ?></font> <br> 
		<font face="Arial Narrow" style="color:white;" size="2">Rep&uacute;blica de Colombia</font>
	</td>
</tr>
</table>
</form>
</body>
</html>
