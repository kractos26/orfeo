<?php
session_start();

$ruta_raiz = ".";
    if (!$_SESSION['dependencia'])
        header ("Location: $ruta_raiz/cerrar_session.php");


foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;

if(isset($_GET["tipo_carp"]))  $tipo_carp = $_GET["tipo_carp"];

$krd            = $_SESSION["krd"];
$dependencia    = $_SESSION["dependencia"];
$usua_doc       = $_SESSION["usua_doc"];
$codusuario     = $_SESSION["codusuario"];
$tip3Nombre     = $_SESSION["tip3Nombre"];
$tip3desc       = $_SESSION["tip3desc"];
$tip3img        = $_SESSION["tip3img"];
$tpNumRad       = $_SESSION["tpNumRad"];
$tpPerRad       = $_SESSION["tpPerRad"];
$tpDescRad      = $_SESSION["tpDescRad"];
$tip3Nombre     = $_SESSION["tip3Nombre"];
$ESTILOS_PATH   = $_SESSION["ESTILOS_PATH"];

if(!isset($carpetano)){
    $carpetano = "";
}

$carpeta=$carpetano;
$tipo_carp = $tipo_carpp;
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");
error_reporting(7);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
?>
<html>
<head>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
<SCRIPT language="JavaScript" type="text/javascript" src="js/ajax.js"></SCRIPT>
<script>
// Variable que guarda la ultima opcion de la barra de herramientas de funcionalidades seleccionada
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function reload_window($carpetano,$carp_nomb,$tipo_carp)
{
	document.write("<form action=cuerpo.php?<?=session_name()."=".session_id()?>&krd=<?=$krd?>&ascdesc=desFc method=post name=form4 target=mainFrame>");
	document.write("<input type=hidden name=carpetano value=" + $carpetano + ">");
	document.write("<input type=hidden name=carp_nomb value=" + $carp_nomb + ">");
	document.write("<input type=hidden name=tipo_carpp value=" + $tipo_carp + ">");
	document.write("<input type=hidden name=tipo_carpt value=" + $tipo_carpt + ">");
	document.write("</form>");
	document.form4.submit();
}
selecMenuAnt=-1;
swVePerso = 0;
numPerso = 0;

function cambioMenu(img)
{
	MM_swapImage('plus' + img,'','imagenes/menuraya.gif',1);
	if (selecMenuAnt!=-1 && img!=selecMenuAnt)
		MM_swapImage('plus' + selecMenuAnt,'','imagenes/menu.gif',1);
	selecMenuAnt = img;

	if (swVePerso==1 && numPerso!=img){
		document.getElementById('carpersolanes').style.display="none";
		MM_swapImage('plus' + numPerso,'','imagenes/menu.gif',1);
		swVePerso=0;
	}
}

function verPersonales(img)
{
	if (swVePerso!=1){
		document.getElementById('carpersolanes').style.display="";
		swVePerso=1;
	}else{
		document.getElementById('carpersolanes').style.display="none";
		MM_swapImage('plus' + selecMenuAnt,'','imagenes/menu.gif',1);
		selecMenuAnt = img;
		swVePerso=0;
	}
	numPerso = img;
}

// the function handles the validation for any form field
function actualizarCarpetas(idx)
{
	// only continue if xmlHttp isn't void
	if (xmlHttp)
	{
		vl1 = encodeURIComponent(idx);
		var envio = "i="+vl1;
		if (envio.length > 0)
		{
			cache.push(envio);
		}

		// try to connect to the server
		try
		{
			// continue only if the XMLHttpRequest object isn't busy
			// and the cache is not empty
			if ((xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
				&& cache.length>0)
			{
				// get a new set of parameters from the cache
				var cacheEntry = cache.shift();
				// make a server request to validate the extracted data
				xmlHttp.open("POST", "menu/menuCarpetas.php", true);
				xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				xmlHttp.onreadystatechange = handleRequestStateChange;
				xmlHttp.send(cacheEntry);
			}
		}
		catch (e)
		{
			// display an error when failing to connect to the server
			displayError(e.toString());
		}
	}
}

// function that displays an error message
function displayError($message)
{
	// ignore errors if showErrors is false
	if (showErrors)
	{
		// turn error displaying Off
		showErrors = false;
		// display error message
		//alert("Error encountered: \n" + $message);
		// retry validation after 10 seconds
		setTimeout("actualizarCarpetas();", 10000);
	}
}

// read server's response
function readResponse()
{
	// retrieve the server's response
	var response = xmlHttp.responseText;
        var lonCarpetas=0;
        
	// server error?
	if (response.indexOf("ERRNO") >= 0
	|| response.indexOf("error:") >= 0
	|| response.length == 0)
	throw(response.length == 0 ? "Server error." : response);
	obj = document.getElementById('menuCarpetas');
	var verAlertas = response.substr(-1);
	texto=response;
    if(document.getElementById('menuArchivo') && texto.lastIndexOf('@A')>0)
	{
            objArch=document.getElementById('menuArchivo');
            lonCarpetas   = texto.lastIndexOf('@A');
            objArch.innerHTML = texto.substring(lonCarpetas+2,texto.length-1);
            texto=texto.substring(0,lonCarpetas);
	}
        
        if(document.getElementById('menuPrestamo') && texto.lastIndexOf('@P')>0)
        {
            objPrest=document.getElementById('menuPrestamo');
            lonCarpetas   = texto.lastIndexOf('@P');
            objPrest.innerHTML = texto.substring(lonCarpetas+2,texto.length-1);
            texto=texto.substring(0,lonCarpetas);
        }
        obj.innerHTML = texto.substring(0,texto.length-1);
	if (verAlertas==1) alertas('ffff');
	obj.style.display = 'block';
	//setTimeout("validate();", 500);
}

function alertas(NewWin)
{	var x = (screen.width - 300) / 2;
	var y = (screen.height - 130) / 2;
	SW=window.open('alertas.php',NewWin,'toolbar=no,menubar=no,location=no,resizable=no,status=no,width=300,height=130,scrollbars=no')
	SW.moveTo(x,y);
}
</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form action=correspondencia.php method="post" >
<?php
$fechah = date("dmy") . "_" . time("hms");
$carpeta = $carpetano;
// Cambia a Mayuscula el login-->krd -- Permite al usuario escribir su login en mayuscula o Minuscula
$numeroa=0;$numero=0;$numeros=0;$numerot=0;$numerop=0;$numeroh=0;
//Realiza la consulta del usuarios y de una vez cruza con la tabla dependencia
$isql = "select a.*,b.depe_nomb from usuario a,dependencia b
		where a.depe_codi=b.depe_codi AND USUA_LOGIN ='$krd' ";
$rs = $db->query($isql);
$phpsession = session_name()."=".session_id();
echo "<font size=1 face=verdana>";
// Valida Longin y contrasena encriptada con funcion md5()
if (trim($rs->fields["USUA_LOGIN"])==trim($krd))
{
	$contraxx=$rs->fields["USUA_PASW"];
	if (trim($contraxx))
	{
		$codusuario =$rs->fields["USUA_CODI"];
		$dependencianomb=$rs->fields["DEPE_NOMB"];
		$fechah = date("dmy") . "_" . time("hms");
		$contraxx=$rs->fields["USUA_PASW"];
		$nivel=$rs->fields["CODI_NIVEL"];
		$iusuario = " and us_usuario='$krd'";
		$perrad = $rs->fields["PERM_RADI"];
		$reload = ($rs->fields["USUA_TIMERELOAD"]) ? $rs->fields["USUA_TIMERELOAD"] : 2;
		//Adicionado as contador
		// si el usuario tiene permiso de radicar el prog. muestra los iconos de radicacion
		include "$ruta_raiz/menu/radicacion.php";
                include "$ruta_raiz/menu/menuPrimero.php";
		
		$db_tempo = $db;
		$tmpFresh = $reload*60*1000;
		echo "<script type='text/javascript'>
				setTimeout('actualizarCarpetas($i)',0);
				setInterval('actualizarCarpetas($i)',$tmpFresh);
			</script>";
		//include "$ruta_raiz/menu/menuCarpetas.php";
		$db = $db_tempo;
  }
}
//*********************TRANSACCIONES DEL CURSOR DE CONSULTA PRIMARIA**************************************************************************************************
if(!$db->imagen())
{
  $logo = "logoEntidad.gif";
}else{
  $logo = $db->imagen();
}
?>
<div id="menuCarpetas"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="t_bordeVerde">
	<tr align="center">
             <td width="125">
                    <a onclick="cambioMenu(<?=$i?>);" href='cuerpoTx.php?<?=$phpsession?>&fechah=<?php echo "$fechah&nomcarpeta=$data&tipo_carpt=0"; ?>' class="menu_princ" target="mainFrame" alt="Transaccines del Usuario">
                    Transacciones
                     </a>
                </td>
 <td height="35"><img width=80 src='<?=$logo?>' alt="Logo"></td> 
	</tr>
	<tr align="center">
		<td height="20">
			<font size="1" face="Verdana, Arial, Helvetica, sans-serif">
			Equipo:
<?php	// Coloca de direccion ip del equipo desde el cual se esta entrando a la pagina.
				echo $_SERVER['REMOTE_ADDR'];
			?></font>
		</td>
	</tr>

</table>
</form>

</body>
</html>