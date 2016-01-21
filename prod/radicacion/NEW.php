
<?php
$krdOld = $krd;
session_start();
error_reporting(7);
$ruta_raiz = "..";
if(!isset($_SESSION['dependencia']) and !isset($_SESSION['cod_local']))	include "../rec_session.php";
$ruta_raiz = "..";
define('ADODB_ASSOC_CASE', 1);
include_once "../include/db/ConnectionHandler.php";
include_once "../class_control/AplIntegrada.php";
include_once "../include/class/DatoOtros.php";
$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug=true;
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
include "crea_combos_universales.php";
$objApl = new AplIntegrada($db);
$objTipo3=new DatoOtros($db->conn);

$sqlMotModif = "select motivo_modificacion_descrip, motivo_modificacion_codigo from motivo_modificacion order by motivo_modificacion_descrip";
$rs_motModificacion = $db->conn->Execute($sqlMotModif);
$sls_motModificacion = $rs_motModificacion->GetMenu2('sls_motModificacion', $sls_motModificacion, false, false, "id='sls_motModificacion' class='select'<option value=0> --Seleccione un Motivo-- </option>");

$motModificacionCodi = $_POST[sls_motModificacion];

if($nurad)
{
	$nurad=trim($nurad);
	$ent = substr($nurad,-1);
}
$no_tipo = "true";

if ($tip3img[1][$ent])
{
        if($objTipo3->getTip3Habilitado($ent, 1))$tamanoImg=110;
        else $tamanoImg=0;
	$imgTp1 = str_replace(".jpg", "",$tip3img[1][$ent]);
	$descTp1 = "alt='".$tip3desc[1][$ent]."' title='".$tip3desc[1][$ent]."'";
	$nombreTp1 = $tip3Nombre[1][$ent];
	$pestana1 ="<a href='#'  onClick='pestanas(1);' class='etextomenu'><img src='../img/tip3/$imgTp1.jpg' width='$tamanoImg' height='25' border='0' id=remitente $descTp1><img src='../img/tip3/".$imgTp1."S.jpg' width='$tamanoImg' height='25' border='0' id=remitente_R $descTp1></a>";
}

if ($tip3img[2][$ent])
{
        if($objTipo3->getTip3Habilitado($ent, 2))$tamanoImg=110;
        else $tamanoImg=0;
	$imgTp2 = str_replace(".jpg", "",$tip3img[2][$ent]);
	$descTp2 = "alt='".$tip3desc[2][$ent]."' title='".$tip3desc[2][$ent]."'";
	$nombreTp2 = $tip3Nombre[2][$ent];
	$pestana2= "<a href='#'  onClick='pestanas(2);' class='etextomenu'><img src='../img/tip3/$imgTp2.jpg' width='$tamanoImg' border='0'  id=predio $descTp2><img src='../img/tip3/".$imgTp2."S.jpg' width='$tamanoImg' border='0'  id=predio_R $descTp2></a>";
}

if ($tip3img[3][$ent])
{
        if($objTipo3->getTip3Habilitado($ent, 3))$tamanoImg=110;
        else $tamanoImg=0;
	$imgTp3 = str_replace(".jpg", "",$tip3img[3][$ent]);
	$descTp3 = "alt='".$tip3desc[3][$ent]."' title='".$tip3desc[3][$ent]."'";
	$nombreTp3 = $tip3Nombre[3][$ent];
	$pestana3 = "<a href='#'  onClick='pestanas(3);' class='etextomenu'><img src='../img/tip3/$imgTp3.jpg' width='$tamanoImg' height='25' border='0'  id=empresa $descTp3><img src='../img/tip3/".$imgTp3."S.jpg' width='$tamanoImg' height='25' border='0' id=empresa_R $descTp3></a>";
}
     
?>
<html>
<head>
<title>.:: Orfeo Modulo de Radicaci&acuoteo;n::.</title>
<meta http-equiv="expires" content="99999999999">
<link rel="stylesheet" href="../estilos/orfeo.css" type="text/css">
<SCRIPT Language="JavaScript" SRC="../js/crea_combos_2.js"></SCRIPT>
<script LANGUAGE="JavaScript">
closetime = 0; // Cantidad de segundos a esperar para abrir la ventana nueva
dato1 = 333;
<?php
// Convertimos los vectores de los paises, dptos y municipios creados en crea_combos_universales.php a vectores en JavaScript.
echo arrayToJsArray($vpaisesv, 'vp');
echo arrayToJsArray($vdptosv, 'vd');
echo arrayToJsArray($vmcposv, 'vm');
?>
function niveldeseguridad()
{  
   document.getElementById('nivelradicar').value= document.getElementById('nivelRad').value ;
}
function cambIntgAp(valor)
{	fecha_hoy =  '<?=date('Y')."/".date('m')."/".date('d')?>';
	if (valor!=0)
	{
		if  (document.formulario.fecha_gen_doc.value.length==0)
			document.formulario.fecha_gen_doc.value=fecha_hoy;
	}
	else
		document.formulario.fecha_gen_doc.value="";
}


function radicar_doc()
{	if(fechf ("formulario",16)=="ok")
	{
		if (
		document.formulario.documento_us1.value == 0 ||
		document.formulario.muni_us1.value == 0 ||
		document.formulario.direccion_us1.value == 0 ||
		document.formulario.coddepe.value == 0
        )
		{
			alert("El tipo de Documento, Remitente/Destinatario, Direccion y Dependencia son obligatorios ");
		}
        else if(document.formulario.asu.value.length <6)
        {
            alert("Debe llenar el campo asunto con minimo 6 caracteres"+"(Digitos:"+document.formulario.asu.value.length+")");
        }
        else if(!maxlengt_tx(350))return false;
		else
		{
			document.formulario.submit();
        }	
    }	
}

function modificar_doc()
{
    if(fechf ("formulario",16)=="ok")
    {
        if (!document.formulario.documento_us1.value)
            {
                    alert("Remitente/Destinatario y Asunto son obligatorios ");
            }
        else if(document.formulario.asu.value.length <6)
        {
            alert("Debe llenar el campo asunto con minimo 6 caracteres"+"(Digitos:"+document.formulario.asu.value.length+")");
        }
        else if(!maxlengt_tx(350))return false;
            else
            {
                    document.formulario.submit();
            }
    }
}

function pestanas(pestana)
{
 <?php
   //if($ent==1) $ver_pestana="none"; else $ver_pestana="";
   if($ent==1) $ver_pestana=""; else $ver_pestana="";
  ?>
   document.getElementById('remitente').style.display = "";
   document.getElementById('remitente_R').style.display = "none";
<?php
if ($tip3img[2][$ent])
{
	echo "document.getElementById('predio').style.display = '$ver_pestana';";
	echo "document.getElementById('predio_R').style.display = 'none';";
}
if ($tip3img[3][$ent])
{
	echo "document.getElementById('empresa').style.display = '$ver_pestana';";
	echo "document.getElementById('empresa_R').style.display = 'none';";
}
?>
   if(pestana==1) {
   document.getElementById('pes1').style.display = "";
   document.getElementById('remitente').style.display = "none";
   document.getElementById('remitente_R').style.display = "";
   }else
   {
    document.getElementById('pes1').style.display = "none";
   }
  if(pestana==2)
  {
  document.getElementById('pes2').style.display = "";
   document.getElementById('predio').style.display = "none";
   document.getElementById('predio_R').style.display = "";
  }else{document.getElementById('pes2').style.display = "none";}
  if(pestana==3) {
  document.getElementById('pes3').style.display = "";
   document.getElementById('empresa').style.display = "none";
   document.getElementById('empresa_R').style.display = "";
  }
  else
  {document.getElementById('pes3').style.display = "none";}
}

function pb1()
{	dato1 = document.forma.no_documento.value;
}

function Start(URL, WIDTH, HEIGHT)
{	windowprops = "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=1100,height=550";
	preview = window.open(URL , "preview", windowprops);
}

function doPopup()
{	url = "popup.htm";
	width = 800; // ancho en pixels
	height = 320; // alto en pixels
	delay = 2; // tiempo de delay en segundos
	timer = setTimeout("Start(url, width, height)", delay*1000);
}
function buscar_usuario()
{	document.write('<form target=Buscar_Usuario name=formb action=buscar_usuario.php?envio_salida=true&ent=<?=$ent?> method=POST>************');
	document.write("<input type='hidden' name=no_documento value='" + documento +"'>");
	document.write("</form> ");
}

function regresar()
{	i=1;
}
function maxlengt_tx(maxchars)
{
	if(document.formulario.asu.value.length > maxchars)
 	{
 		alert('Demasiados caracteres en el texto asunto, solo se permiten '+ maxchars);
   	return false;
 	}
 	else	return true;

}
</script>
</head>
<body bgcolor="#FFFFFF" onLoad="pestanas(1);">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<?php
error_reporting(7);
$nurad = trim($nurad);
// aqui se busca el radicado para editar si viene la variable $Buscar
if($Buscar)
{
	$docDia = $db->conn->SQLDate('d','a.RADI_FECH_OFIC');
	$docMes = $db->conn->SQLDate('m','a.RADI_FECH_OFIC');
	$docAno = $db->conn->SQLDate('Y','a.RADI_FECH_OFIC');
        
        $radDia = $db->conn->SQLDate('d','a.RADI_FECH_RADI');
	$radMes = $db->conn->SQLDate('m','a.RADI_FECH_RADI');
	$radAno = $db->conn->SQLDate('Y','a.RADI_FECH_RADI');
        
	$fRad = $db->conn->SQLDate('Y/m/d','a.RADI_FECH_RADI');
	if (!$nurad || strlen(trim($nurad))==0)
	$nurad="NULL";
	$query = "select a.*
				,$docDia AS DOCDIA
				,$docMes AS DOCMES
				,$docAno AS DOCANO
                                ,$radDia AS RADDIA
				,$radMes AS RADMES
				,$radAno AS RADANO
				,a.EESP_CODI
				,a.RA_ASUN
				,$fRad AS FECHA_RADICADO
			from radicado a
			where a.radi_nume_radi=$nurad";
	$rs=$db->conn->query($query);
	$varQuery = $query;
	$busqueda=$nurad;
	if(!$rs->EOF and is_numeric($busqueda))
	{
		if($cursor)
		{
			$Submit4 = "Modificar";
		}
		if ($_POST["radexp"]==1)	//Si viene de modificacion express
		{
			if ($rs->fields['RADI_USUA_ACTU']!=0)	//Si tiene propietario (significa que ya fue modificado)
			{	die ("<table width='75%' class=borde_tab celspacing=5 align='center'><tr><td class='titulosError' align='center'>Radicado r&aacute;pido fue modificado. Su modificaci&oacute;n est&aacute; restringida.</td></tr></table>");	}
			else
			{	$radi_usua_actu=1;			
			}	//Asignele nuevo usuario al jefe de la dependencia
		}
		$asu=$rs->fields["RA_ASUN"];
		$tip_doc =$rs->fields["TDID_CODI"];
		$radicadopadre=$rs->fields["RADI_NUME_DERI"];
		$ane= $rs->fields["RADI_DESC_ANEX"];
		$codep=$rs->fields["DEPTO_CODI"];
		$pais=$rs->fields["RADI_PAIS"];
		$carp_codi = $rs->fields["CARP_CODI"];
		$cuentai = $rs->fields["RADI_CUENTAI"];
		$carp_per = $rs->fields["CARP_PER"];
		$depende=$rs->fields["RADI_DEPE_ACTU"];
		$tip_rem=$rs->fields["TRTE_CODI"]+1;
		$tdoc=$rs->fields["TDOC_CODI"];
		$med =$rs->fields["MREC_CODI"];
		$cod=$rs->fields["MUNI_CODI"];
		$coddepe=$rs->fields["RADI_DEPE_RADI"];
		$codusuarioActu=$rs->fields["RADI_USUA_RADI"];
		$radi_usua_actu=$rs->fields["RADI_USUA_ACTU"];
		//$coddepe=$rs->fields["RADI_DEPE_ACTU"];
		$fechproc12=$rs->fields["DOCDIA"];
		$fechproc22=$rs->fields["DOCMES"];
		$fechproc32=$rs->fields["DOCANO"];
                
                $ddate=$rs->fields["RADDIA"];
		$mdate=$rs->fields["RADMES"];
		$adate=$rs->fields["RADANO"];
                
		$fechaRadicacion=$rs->fields["FECHA_RADICADO"];
		$espcodi =$rs->fields["EESP_CODI"];
		$fecha_gen_doc = "$fechproc32/$fechproc22/$fechproc12";
		include "busca_direcciones.php";
	}
	else
	{
		echo "<p><center><table width='90%' class=borde_tab celspacing=5><tr><td class=titulosError><center>No se han encontrado registros con numero de radicado <font color=blue>$nurad</font> <br>Revise el radicado escrito, solo pueden ser Numeros de 14 digitos <br><p><hr><a href='edtradicado.php?fechaf=$fechaf&krd=$krd&drde=$drde'><font color=red>Intente de Nuevo</a></center></td></tr></table></center>";
		if(!$rsJHLC) die("<hr>");
	}
}

if(!$ddate || !$mdate || !$adate){
    
$ddate=date('d');
$mdate=date('m');
$adate=date('Y');
}
$hora=date('H:i:s');
$fechaf =$date.$mdate.$adate.$hora;
// Fin de Busqueda del Radicado para editar
?>

<?php
if($rad1 or $rad0 or $rad2)
{
	if($rad1) $tpRadicado = "1";
	if($rad2) $tpRadicado = "2";
	if($rad0) $tpRadicado = "0";
	echo "<input type=hidden name=tpRadicado value=$tpRadicado>";
	$docDia = $db->conn->SQLDate('D','a.RADI_FECH_OFIC');
	$docMes = $db->conn->SQLDate('M','a.RADI_FECH_OFIC');
	$docAno = $db->conn->SQLDate('Y','a.RADI_FECH_OFIC');
        $fRad = $db->conn->SQLDate('Y/m/d','a.RADI_FECH_RADI');
	if (!$radicadopadre || strlen(trim($radicadopadre))==0)
	$radicadopadre="NULL";
	$query = "select a.*, 
				$docDia AS DOCDIA,
				$docMes AS DOCMES,
				$docAno AS DOCANO,
				a.EESP_CODI
                                ,$fRad AS FECHA_RADICADO
			from radicado a
			where a.radi_nume_radi=$radicadopadre";
	$varQuery = $query;
	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	$rs=$db->conn->query($query);
	if(!$rs->EOF)
	{
		echo "<!-- No hay datos: $query -->";
	}
	if(!$Buscar and !$Submit4)
	{
		$varQuery = $query;
		$comentarioDev = 'Entro a Anexar un radicado ';
		$cuentaii =$rs->fields["RADI_CUENTAI"];
		if($cuentaii){$cuentai=$cuentaii;}
		$pnom=$rs->fields["RADI_NOMB"];
		$papl=$rs->fields["RADI_PRIM_APEL"];
		$sapl=$rs->fields["RADI_SEGU_APEL"];
		$numdoc=$rs->fields["RADI_NUME_IDEN"];
		$asu=$rs->fields["RA_ASUN"];
		$tel=$rs->fields["RADI_TELE_CONT"];
		$rem2=$rs->fields["RADI_REM"];
		$adress=$rs->fields["RADI_DIRE_CORR"];
	}
	//$depende=$rs->fields["RADI_DEPE_ACTU"];
	$radi_usua_actu_padre=$rs->fields["RADI_USUA_ACTU"];
	$radi_depe_actu_padre=$rs->fields["RADI_DEPE_ACTU"];
	$tip_doc =$rs->fields["TDID_CODI"];
	$ane= $rs->fields["RADI_DESC_ANEX"];
	$cod=$rs->fields["MUNI_CODI"];
	$codep=$rs->fields["DPTO_CODI"];
	$pais=$rs->fields["RADI_PAIS"];
	$espcodi=$rs->fields["EESP_CODI"];
        //$fechaRadicacion=$rs->fields["FECHA_RADICADO"];
	if($noradicar2)
	{
		$fecha_gen_doc = $rs->fields["DOCANO"] ."/".$rs->fields["DOCMES"] ."/".$rs->fields["DOCDIA"];
		$fechproc12=$rs->fields["DOCDIA"];
		$fechproc22=$rs->fields["DOCMES"];
		$fechproc32=$rs->fields["DOCANO"];
	}
	$ruta_raiz = "..";
	$no_tipo = "true";
	include "busca_direcciones.php";
}
if(strlen($radicadopadre)==14)
{
    if($rad1)
    {
            $encabezado = "<center><b>Copia de datos del Radicado  $radicadopadre ";
            $tipoanexo = "1";
    }
    if($rad0)
    {
            $encabezado = "<center><b>Anexo de $radicadopadre ";
            $tipoanexo = "0";
            $radicadopadre_exist=1;
    }
    if($rad2)
    {
            $encabezado = "<center><b>Documento Asociado de $radicadopadre ";
            if(!$Submit4 and !$Submit3){$cuentai = "";}
            $tipoanexo = "2";
            $radicadopadre_exist=1;
    }
}
if($noradicar1)
$radicadopadre_exist=0;
?>
<script language="javascript">
<?php
$bandFech=false;
if(!$fecha_gen_doc || $fecha_gen_doc=='//')
{	
    $fecha_busq = date("Y/m/d");
    $fecha_gen_doc = $fecha_busq;
    $bandFech=true;
}
?>
var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "formulario", "fecha_gen_doc","btnDate1","<?=$fecha_gen_doc?>",scBTNMODE_CUSTOMBLUE);
</script>
<script>

function procEst2(formulario,tb)
{	var lista = document.formulario.codep.value;
	i = document.formulario.codep.value;
	if (i != 0) {
		var dropdownObjectPath = document.formulario.tip_doc;
		var wichDropdown = "tip_doc";
		var d=tb;
		var withWhat = document.formulario.codep.value;
		populateOptions2(wichDropdown, withWhat,tb);
}	}

function populateOptions2(wichDropdown, withWhat,tbres)
{	r = new Array;
	i=0;
	if (withWhat == "2")
	{	r[i++]=new Option("NIT", "1");
	}
	if (withWhat == "1")
	{	document.formulario.submit();
		r[i++]=new Option("NIT","4");
		r[i++]=new Option("NUIR","5");
	}
	if (withWhat == "3")
	{	r[i++]=new Option("CC", "0");
		r[i++]=new Option("CE", "2");
		r[i++]=new Option("TI", "1");
		r[i++]=new Option("PASAPORTE", "3");
	}
	if (i==0)
	{	alert(i + " " + "Error!!!");
	}
	else
	{
		dropdownObjectPath = document.formulario.tip_doc;
		eval(document.formulario.tip_doc.length=r.length);
		largestwidth=0;
		for (i=0; i < r.length; i++)
		{
			eval(document.formulario.tip_doc.options[i]=r[i]);
			if (r[i].text.length > largestwidth)
			{	largestwidth=r[i].text.length;
			}
		}
		eval(document.formulario.tip_doc.length=r.length);
}	}

function vnum(formulario,n)
{
	valor = formulario.elements[n].value;
	if (isNaN(valor))
	{
		alert ("Dato incorrecto..");
		formulario.elements[n].value="";
		formulario.elements[n].focus();
		return false;
	}
	else
		return true;
}

function fech(formulario,n)
{
	m=n-1;
	s=m-1;
	var f=document.formulario.elements[n].value;
	var meses=parseInt(document.formulario.elements[m].value);
	eval(lona=document.formulario.elements[n].length);
	eval(lonm=document.formulario.elements[m].length);
	eval(lond=document.formulario.elements[s].length);
	if(lona==44 || lonm==44 || lond==44)
	{
		alert("Fecha incorrecta  debe ser DD/MM/AAAA !!!");
		document.formulario.elements[s].value="";
		document.formulario.elements[m].value="";
		document.formulario.elements[n].value="";
		document.formulario.elements[s].focus();
	}
	else
	{	if ((f%4)==0)
		{	if(document.formulario.elements[m].value<13)
			{	switch(meses)
				{	case 12 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 11 : if(document.formulario.elements[s].value>30)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 10 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 9 : if(document.formulario.elements[s].value>30)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 8 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 7 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 6 : if(document.formulario.elements[s].value>30)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 5 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 4 : if(document.formulario.elements[s].value>30)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 3 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 2 : if(document.formulario.elements[s].value>29)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 1 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
			}	}
			else {alert("Fecha mes inexistente!!");
			document.formulario.elements[s].value="";
			document.formulario.elements[m].value="";
			document.formulario.elements[n].value="";
			document.formulario.elements[s].focus();
		}	}
		else 
		{	if(document.formulario.elements[m].value<13)
			{	switch(meses)
				{	case 12 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 11 : if(document.formulario.elements[s].value>30)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 10 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 9 : if(document.formulario.elements[s].value>30)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 8 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 7 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 6 : if(document.formulario.elements[s].value>30)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 5 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 4 : if(document.formulario.elements[s].value>30)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 3 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 2 : if(document.formulario.elements[s].value>28)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
					case 1 : if(document.formulario.elements[s].value>31)
					{
						alert ("Fecha incorrecta..");
						document.formulario.elements[s].value="";
						document.formulario.elements[m].value="";
						document.formulario.elements[n].value="";
						document.formulario.elements[s].focus();
						return false;
					}break;
			}	}
			else
			{	alert("Fecha mes inexistente!!");
				document.formulario.elements[s].value="";
				document.formulario.elements[m].value="";
				document.formulario.elements[n].value="";
				document.formulario.elements[s].focus();
}	}	}	}
function NewWindow(mypage,myname,w,h,pos,infocus)
{
    if(pos=="random")	{myleft=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;mytop=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
    if(pos=="center")	{myleft=(screen.width)?(screen.width-w)/2:100;mytop=(screen.height)?(screen.height-h)/2:100;}
    else if((pos!='center' && pos!="random") || pos==null){myleft=0;mytop=20}
    settings="width=" + w + ",height=" + h + ",top=" + mytop + ",left=" + myleft + ",scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no";
    win=window.open(mypage,myname,settings);
    win.focus();
}
var contadorVentanas=0
function fechf(formulario,n)
{	
    fech1 = "<?if(!$fechaRadicacion)echo date('Y/m/d'); else echo $fechaRadicacion;?>";
    fech1 = parseInt(fech1.replace(/\//g, ""));
    fech2 = document.formulario.fecha_gen_doc.value;
    fech2 = parseInt(fech2.replace(/\//g, ""));
    dif=fech1 - fech2;
     if(dif<0)
    {
        alert("Verifique la fecha del documento !!, es Una fecha Superior a la Del dia de <?if($bandFech)echo "Hoy"; else echo "la Radicacion" ?>");
        return "asdfa";
    }
    else return "ok";
  
}
</script>
<?php
if ($Buscar1)
{
	include "busca_direcciones.php";
}
$var_envio=session_name()."=".trim(session_id())."&krd=$krd&ent=$ent&carp_per=$carp_per&carp_codi=$carp_codi&rad=$nurad&coddepe=$coddepe&depende=$depende&dependencia=$dependencia";
?>
<form action='NEW.php?<?=$var_envio?>'  method="post" name="formulario" id="formulario" class="borde_tab">
<INPUT TYPE=HIDDEN NAME=radicadopadre value='<?=$radicadopadre ?>'>
<input type=hidden name=tipoanexo value='<?=$tipoanexo ?>'>
<input type=hidden name='noradicar' value='<?=$noradicar ?>'>
<input type=hidden name='noradicar1' value='<?=$noradicar1 ?>'>
<input type=hidden name='noradicar2' value='<?=$noradicar2 ?>'>
<input type=hidden name='atrasRad0' value='<?=$rad0 ?>'>
<input type=hidden name='atrasRad1' value='<?=$rad1 ?>'>
<input type=hidden name='atrasRad2' value='<?=$rad2 ?>'>
<input type=hidden name='faxPath' value='<?=$faxPath ?>'>
<input type="hidden" name="nivelradicar" id="nivelradicar" value=""/>
<?php
if($tpRadicado) {echo "<input type=hidden name=tpRadicado value=$tpRadicado>";}
?>
<table width="99%"  border="0" align="center" cellpadding="4" cellspacing="5" class="borde_tab">
<tr>
	<td width="6" class="titulos2"><a href='./NEW.php?<?=session_name()."=".session_id()?>&rad2=Asociado&krd=<?=$krd?>&ent=<?=$ent?>&rad1=<?=$atrasRad1?>&rad2=<?=$atrasRad2?>&rad0=<?=$atrasRad0?>&radicadopadre=<?=$radicadopadre?>&noradicar=<?=$noradicar?>&noradicar1=<?=$noradicar1?>&noradicar2=<?=$noradicar2?>'>Atras</a></td>
	<td width="94%" align="center" valign="middle" class="titulos2"><b>
<?php
      $query = "select SGD_TRAD_CODIGO, SGD_TRAD_DESCR from sgd_trad_tiporad where SGD_TRAD_CODIGO=$ent";
      $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
      $rs=$db->conn->query($query);
      $tRadicacionDesc = $rs->fields["SGD_TRAD_DESCR"];
?>
		M&Oacute;DULO DE RADICACI&Oacute;N
      <?=$tRadicacionDesc?>
      (Dep
      <?=$_SESSION['dependencia'] ?>
      ->
      <?=$tpDepeRad[$ent]?>
      )</b>
<?php 
if($nurad)
{	
	if(substr($nurad,-1)==='2')
	{
		$ses = session_name()."=".session_id();
		echo "<b>Rad No. <a href=\"javascript:NewWindow('$ruta_raiz/radicacion/gen_etiqueta.php?r=".base64_encode($nurad.'%')."&$ses','popup_ver_estiquer',350,150,'center','front');\">" . $nurad."</a>";
	}
	else
		echo "<b>Rad No. " . $nurad;
    $ent = substr($nurad,-1);
}
?>
		<br>
<?=$encabezado ?>
	</td>
</tr>
</table>
<table  width=99% border="0" align="center" cellspacing="1" cellpadding="4" class="borde_tab" >
<tr valign="middle">
	<td class="titulos5" width="15%" align="right">
		<font color="" face="Arial, Helvetica, sans-serif">
                <span class="titulos5">Fecha de Radicaci&oacute;n: aaaa/mm/dd</span></font>
	</td>
	<td class="listado5" width="15%"><font color="" face="Arial, Helvetica, sans-serif">
		<input name="fechproc1" type="text"  readonly="true" id="fechproc13" size="4" maxlength="2" value="<?php echo $adate;?>" class="tex_area">/
		<input name="fechproc2" type="text"  readonly="true" id="fechproc23" size="2" maxlength="2" value="<?php echo $mdate;?>" class="tex_area">/
		<input name="fechproc3" readonly="true" type="text" id="fechproc33" size="2" maxlength="4" value="<?php echo $ddate;?>" class="tex_area">
		</font>
	</td>
	<td width="15%" class="titulos5" align="right">
		<font color="" face="Arial, Helvetica, sans-serif" class="titulos5">Fecha Doc. aaaa/mm/dd </font>
	</td>
	<td width="15%" class="listado5"><font color="" face="Arial, Helvetica, sans-serif">
		<script language="javascript">
			dateAvailable1.date = "<?=$fecha_gen_doc;?>";
			dateAvailable1.writeControl();
			dateAvailable1.dateFormat="yyyy/MM/dd";
		</script>
		</font> <font color="" face="Arial, Helvetica, sans-serif"></font>
	</td>
	<td width="15%" class="titulos5" align="right">Cuenta Interna, Oficio, Referencia</td>
	<td width="15%" class="listado5">
		<font face="Arial, Helvetica, sans-serif">
		<input name="cuentai" type="text"  maxlength="22" class="tex_area" value='<?php echo $cuentai; ?>' >
		</font>
	</td>
</tr>
</table>
<table width="600" border="0" cellspacing="0" cellpadding="2">
<tr>
	<td height="1"><input name="VERIFICAR" type='hidden' class="ebuttons2" value="Verifique Radicaci&oacute;n"></td>
</tr>
</table>
<table width="99%" align="center" border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom">
	<td height="10">
		<table width="99%" align="center" border="0" cellspacing="0" cellpadding="0">
		<tr>
<?php
	if($ent!=2) $img_remitente = "destinatario"; 
	else $img_remitente = "remitente";
?>
			<td width="523"  valign="bottom"><?=$pestana1.$pestana2.$pestana3?></td>
<?php
	if($ent!=2) $busq_salida="true"; 
	else  $busq_salida="";
?>
			<td width="183" align="right" valign="bottom"> <input type="button" name="Button" value="BUSCAR" class="botones_funcion" onClick="Start('buscar_usuario.php?krd=<?=$krd?>&nombreTp1=<?=$nombreTp1?>&nombreTp2=<?=$nombreTp2?>&nombreTp3=<?=$nombreTp3?>&busq_salida=<?=$busq_salida?>&ent=<?=$ent?>',1024,400);">
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr valign="top">
<td height="95" class="titulos5"> <BR>
<?php
for($i=1;$i<=3;$i++)
{
	if($i==1)
	{
		$nombre = $nombre_us1;
		$documento = $documento_us1;
		$papel = $prim_apel_us1;
		$grbNombresUs1 = trim($nombre_us1) . " " . trim($prim_apel_us1) . " ". trim($seg_apel_us1);
		$sapel = $seg_apel_us1;
		$tel = $telefono_us1;
		$dir = $direccion_us1;
		$mail = $mail_us1;
		$muni = $muni_us1;
		$codep = $codep_us1;
		$idp = $idpais1;
		$idc = $idcont1;
		$tipo = $tipo_emp_us1;
		$cc_documento = $cc_documento_us1;
		$otro = $otro_us1;
	}
	if($i==2)
	{
		$nombre = $nombre_us2;
		$documento = $documento_us2;
		$cc_documento = $cc_documento_us2;
		$papel = $prim_apel_us2;
		$sapel = $seg_apel_us2;
		$grbNombresUs2 = trim($nombre_us2) . " " . trim($prim_apel_us2) . " ". trim($seg_apel_us2);
		$tel = $telefono_us2;
		$dir = $direccion_us2;
		$mail = $mail_us2;
		$muni = $muni_us2;
		$codep = $codep_us2;
		$idp = $idpais2;
		$idc = $idcont2;
		$tipo = $tipo_emp_us2;
		$otro = $otro_us2;
	}
	if($i==3)
	{
		$nombre = $nombre_us3;
		$documento = $documento_us3;
		$cc_documento = $cc_documento_us3;
		$grbNombresUs3 = trim($nombre_us3) . " " . trim($prim_apel_us3) . " ".trim($seg_apel_us3);
		$papel = $prim_apel_us3;
		$sapel = $seg_apel_us3;
		$tel = $telefono_us3;
		$dir = $direccion_us3;
		$mail = $mail_us3;
		$muni = $muni_us3;
		$codep = $codep_us3;
		$idp = $idpais3;
		$idc = $idcont3;
		$tipo = $tipo_emp_us3;
		$otro = $otro_us3;
	}
	if($tipo==1 or $i==3)
	{
		$lbl_nombre = "Raz&oacute;n Social";
		$lbl_apellido = "Sigla";
		$lbl_nombre2 = "Rep. Legal";
	}
	else
	{
		$lbl_nombre = "Nombres";
		$lbl_apellido = "Primer Apellido";
		$lbl_nombre2 = "Segundo Apellido";
	}
	$bloqEdicion="";
	if ($i==3)
		$bloqEdicion = "readonly='true'";
?>
<table border=0 width=100%  name='pes<?=$i?>' id='pes<?=$i?>' class="borde_tab" align="center" cellpadding="0" cellspacing="5">
<tr class=listado2>
	<td class="titulos5" height="25" align="right">C&oacute;digo</td>
	<td bgcolor="#FFFFFF" height="25" class="listado5">
		<input type=text name='documento_us<?=$i ?>' value='<?=$documento?>' readonly="true" class="tex_area">
		<input type=text name='cc_documento_us<?=$i?>' value='<?=$cc_documento?>' readonly="true" class="tex_area">
	</td>
	<td class="titulos5" height="25" align="right"><font face="Arial, Helvetica, sans-serif" class="etextomenu">Tipo</font></td>
	<td width="45%" height="25" bgcolor="#FFFFFF" class="listado5">
	<select name="tipo_emp_us<?=$i?>" class="select">
	<?php
	if($i==1){if($tipo_emp_us1==0){$datos = " selected ";}else{$datos= "";}}
	if($i==2){if($tipo_emp_us2==0){$datos = " selected ";}else{$datos= "";}}
	if($i==3){if($tipo_emp_us3==0){$datos = " selected ";}else{$datos= "";}}
	?>
	<option value=0 <?=$datos ?>>PERSONA NATURAL</option>-->
	<?php
	if($i==1){if($tipo_emp_us1==1){$datos = " selected ";}else{$datos= "";}}
	if($i==2){if($tipo_emp_us2==1){$datos = " selected ";}else{$datos= "";}}
	if($i==3){if($tipo_emp_us3==1){$datos = " selected ";}else{$datos= "";}}
	?>
	<option value=1 <?=$datos ?>>REMITENTE / TERCERO  </option>
	
        <?php
	if($i==1){if($tipo_emp_us1==2){$datos = " selected ";}else{$datos= "";}}
	if($i==2){if($tipo_emp_us2==2){$datos = " selected ";}else{$datos= "";}}
	if($i==3){if($tipo_emp_us3==2){$datos = " selected ";}else{$datos= "";}}
 	?>
	<option value=2 <?=$datos ?>>EMPRESAS  </option>
	
        <?php
	if($i==1){if($tipo_emp_us1==6){$datos = " selected ";}else{$datos= "";}}
	if($i==2){if($tipo_emp_us2==6){$datos = " selected ";}else{$datos= "";}}
	if($i==3){if($tipo_emp_us3==6){$datos = " selected ";}else{$datos= "";}}
	?>
	<option value=6 <?=$datos ?>>FUNCIONARIOS  </option>
	</select>
	<font color="">
		<input type='hidden' name='depende22' value="<?php echo $depende;?>">
	</font>
	</td>
</tr>
<tr class=e_tablas>
	<td width="13%" class="titulos5" height="25" align="right">
		<font face="Arial, Helvetica, sans-serif" class="etextomenu"><?=$lbl_nombre ?></font>
	</td>
	<td width="30%" bgcolor="#FFFFFF" height="25" class="listado5">
		<INPUT type=text name='nombre_us<?=$i ?>' value='<?=$nombre ?>'  readonly="true"  class="tex_area" size=40>
	</td>
	<td width="12%" class="titulos5" height="25" align="right"><font face="Arial, Helvetica, sans-serif" class="etextomenu"><?=$lbl_apellido ?></font></td>
	<td colspan="3" bgcolor="#FFFFFF" height="25" class="listado5">
<?php
if($i==4)
{	$ADODB_COUNTRECS = true;
	$query ="select PAR_SERV_NOMBRE,PAR_SERV_CODIGO FROM PAR_SERV_SERVICIOS order by PAR_SERV_NOMBRE";
	$rs=$db->conn->query($query);
	$numRegs = "! ".$rs->RecordCount();
	$varQuery = $query;
	print $rs->GetMenu2("sector_us$i", "sector_us$i", "0:-- Seleccione --", false,"","onChange='procEst(formulario,18,$i )' class='ecajasfecha'");
	$ADODB_COUNTRECS = false;
?>
	<select name="sector_us<?=$i ?>" class="select">
<?php
while(!$rs->EOF)
{
	$codigo_sect = $rs->fields["PAR_SERV_CODIGO"];
	$nombre_sect = $rs->fields["PAR_SERV_NOMBRE"];
	echo "<option value=$codigo_sect>$nombre_sect</option>";
	$rs->MoveNext();
}
?>
	</select>
<?php
}
else
{
?>
	<INPUT type=text name='prim_apel_us<?=$i ?>' value='<?=$papel ?>' class="tex_area"  readonly="true"  size="40">
<?php
}
?>
	</td>
</tr>
<tr class=e_tablas>
	<td width="13%" class="titulos5" height="25" align="right">
		<font face="Arial, Helvetica, sans-serif" class="etextomenu"><?=$lbl_nombre2 ?></font>
	</td>
	<td width="30%" bgcolor="#FFFFFF" height="25" class="listado5">
		<input type=text name='seg_apel_us<?=$i ?>' value='<?=$sapel ?>'  readonly="true"  class="tex_area" size=40>
	</td>
	<td width="12%" class="titulos5" height="25" align="right">
		<font face="Arial, Helvetica, sans-serif" class="etextomenu">Tel&eacute;fono</font>
	</td>
	<td  colspan="3" bgcolor="#FFFFFF" height="25" class="listado5">
		<input type=text name='telefono_us<?=$i ?>' value='<?=$tel ?>' <?=$bloqEdicion?>  class="tex_area">
	</td>
</tr>
<tr class=e_tablas>
	<td width="13%" class="titulos5" height="25" align="right">
		<font face="Arial, Helvetica, sans-serif" class="etextomenu">Direcci&oacute;n</font>
	</td>
	<td width="30%" bgcolor="#FFFFFF" height="25" class="listado5">
		<INPUT type=text name='direccion_us<?=$i ?>' value='<?=$dir ?>' <?=$bloqEdicion?>  class="tex_area" size=40>
	</td>
	<td width="12%" class="titulos5" height="25" align="right">
		<font face="Arial, Helvetica, sans-serif" class="etextomenu">Mail</font></td>
	<td  colspan="3" bgcolor="#FFFFFF" height="25" class="listado5">
		<INPUT type=text name='mail_us<?=$i ?>' value='<?=$mail ?>' <?=$bloqEdicion?>  class="tex_area" size=40>
	</td>
</tr>
<?php
if($i!=3)
{
?>
<tr class=e_tablas>
	<td width="13%" class="titulos5" height="25" align="right" ><font face="Arial, Helvetica, sans-serif" class="etextomenu">Dignatario</font></td>
	<td bgcolor="#FFFFFF" height="25" class="listado5" colspan="3">
		<INPUT type='text' name='otro_us<?=$i ?>' value="<?php echo htmlspecialchars(stripcslashes($otro)); ?>" class='tex_area' size='60' maxlength='50'>
	</td>
</tr>
<?php
}
?>
<tr class=e_tablas>
	<td width="13%" class="titulos5" height="25" align="right"><font face="Arial" class="etextomenu">Continente</font></td>
	<td width="20%" bgcolor="#FFFFFF" height="25" class="listado5">
<?php
/*  En este segmento trabajaremos macrosusticion, lo que en el argot php se denomina Variables variables.
*	El objetivo es evitar realizar codigo con las mismas asignaciones y comparaciones cuya diferencia es el
*	valor concatenado de una variable + $i.
*/
$var_cnt = "idcont".$i;
$var_pai = "idpais".$i;
$var_dpt = "codep_us".$i;
$var_mcp = "muni_us".$i;

/*	Se crean las variables cuyo contenido es el valor por defecto para cada combo, esto segun el siguiente orden:
*	1. Se pregunta si existe idcont1, idcont2 e idcont3 (segun iteraccion del ciclo), si es asi se asigna a $contcodi.
*	2. Sino existe (osea que no viene de buscar_usuario.php) se pregunta si existe "localidad" y se asigna el
*	   respectivo codigo; de ser negativa la "localidad", $contcodi toma el valor de 0. Esto para cada
*	   variable de continente, pais, dpto y mncpio respectivamente.
*/

(${$var_cnt}) ? $contcodi = ${$var_cnt} : ($_SESSION['cod_local'] ? $contcodi = (substr($_SESSION['cod_local'],0,1)*1) : $contcodi = 0 ) ;
(${$var_pai}) ? $paiscodi = ${$var_pai} : ($_SESSION['cod_local'] ? $paiscodi = (substr($_SESSION['cod_local'],2,3)*1) : $paiscodi = 0 ) ;
(${$var_dpt}) ? $deptocodi = ${$var_dpt} : ($_SESSION['cod_local'] ? $deptocodi = $paiscodi."-".(substr($_SESSION['cod_local'],6,3)*1) : $deptocodi = 0 ) ;
(${$var_mcp}) ? $municodi = ${$var_mcp} : ($_SESSION['cod_local'] ? $municodi = $deptocodi."-".substr($_SESSION['cod_local'],10,3)*1 : $municodi = 0 ) ;

//	Visualizamos el combo de continentes.
echo $Rs_Cont->GetMenu2("idcont$i",$contcodi,"0:<< seleccione >>",false,0," id=\"idcont$i\" CLASS=\"select\" onchange=\"cambia(this.form, 'idpais$i', 'idcont$i')\" ");
$Rs_Cont->Move(0);
?>
	</td>
	<td width="20%" class="titulos5" height="25" align="right"><font face="Arial" class="etextomenu">Pa&iacute;s</font></td>
	<td  colspan="3" bgcolor="#FFFFFF" height="25" class="listado5">
<?php
//	Visualizamos el combo de paises.
echo "<SELECT NAME=\"idpais$i\" ID=\"idpais$i\" CLASS=\"select\" onchange=\"cambia(this.form, 'codep_us$i', 'idpais$i')\">";
while (!$Rs_pais->EOF and !( $Submit4))
{
	if ($_SESSION['cod_local'] and ($Rs_pais->fields['ID0'] == $contcodi))	//Si hay local Y pais pertenece al continente.
	{
	($paiscodi == $Rs_pais->fields['ID1'])? $s = " selected='selected'" : $s = "";
	echo "<option".$s." value='".$Rs_pais->fields['ID1']."'>".$Rs_pais->fields['NOMBRE']."</option>";
	}
	$Rs_pais->MoveNext();
}
echo "</SELECT>";
$Rs_pais->Move(0);
?>
	</td>
<tr>
	<td width="20%" class="titulos5" height="25" align="right">
		<font face="Arial" class="etextomenu">Departamento</font>
	</td>
	<td width="20%" bgcolor="#FFFFFF" height="25" class="listado5">
<?php
echo "<SELECT NAME=\"codep_us$i\" ID=\"codep_us$i\" CLASS=\"select\" onchange=\"cambia(this.form, 'muni_us$i', 'codep_us$i')\">";
while (!$Rs_dpto->EOF and !( $Submit4))
{	if ($_SESSION['cod_local'] and ($Rs_dpto->fields['ID0'] == $paiscodi))	//Si hay local Y dpto pertenece al pais.
	{	($deptocodi == $Rs_dpto->fields['ID1'])? $s = " selected='selected'" : $s = "";
		echo "<option".$s." value='".$Rs_dpto->fields['ID1']."'>".$Rs_dpto->fields['NOMBRE']."</option>";
	}
	$Rs_dpto->MoveNext();
}
echo "</SELECT>";
$Rs_dpto->Move(0);
?>
	</td>
	<td width="20%" class="titulos5" height="25" align="right"><font face="Arial" class="etextomenu">Municipio</font></td>
	<td  colspan="3" bgcolor="#FFFFFF" height="25" class="listado5">
<?php
echo "<SELECT NAME=\"muni_us$i\" ID=\"muni_us$i\" CLASS=\"select\" >";
while (!$Rs_mcpo->EOF and !( $Submit4))
{	if ($_SESSION['cod_local'])	//Si hay local
	{	($municodi == $Rs_mcpo->fields['ID1'])? $s = " selected='selected'" : $s = "";
		echo "<option".$s." value='".$Rs_mcpo->fields['ID1']."'>".$Rs_mcpo->fields['NOMBRE']."</option>";
	}
	$Rs_mcpo->MoveNext();
}
echo "</SELECT>";

$Rs_mcpo->Move(0);
$municodi=0;$muninomb="";$deptocodi=0;
?>
</td>
</tr>
<tr><td width="20%" class="titulos5" height="25" align="right">Nivel de Seguridad</td>
<td>
    <select name='nivelRad' id='nivelRad' class='select' onchange="niveldeseguridad();">
        <option value="0">P&uacute;blico</option>
        <option value="1">Privado</option>
        <option value="2">Dependencia</option>
    </select>
    
    <?php
//crea combo de tipos de niveles
?>
    
</td>
</tr>

</table>
<?php
}
unset($contcodi);
unset($paiscodi);
unset($deptocodi);
unset($municodi);
?>
<table width=100% border="0" class="borde_tab" align="center">
<tr>
	<td  class="titulos5" width="25%" align="right" >
		<font color="" face="Arial, Helvetica, sans-serif" class="etextomenu">Asunto</font>
	</td>
	<td width="75%" class="listado5" >
		<textarea name="asu" id="asu" cols="100" class="tex_area" rows="2"><?php echo htmlspecialchars(stripcslashes($asu)); ?></textarea>
	</td>
</tr>
</table>
<table width=100% border="0" cellspacing="2" cellpadding="3" class="borde_tab" align="center">
<tr>
	<td width="25%" height="26"    class="titulos5" align="right">
		<font color="" face="Arial, Helvetica, sans-serif" class="etextomenu">
<?php
if($ent==2) { print "Medio Recepci&oacute;n";$where_medio=" MREC_REC=1 ";}
else {print "Medio Env&iacute;o"; $where_medio=" MREC_ENV=1 ";}

/** Si la variable $faxPath viene significa que el tipo de recepcion es fax
* Por eso $med se coloca en 2
*/
if($faxPath) $med=2;
?>
	</font>
</td>
<td width="25%" valign="top" class="listado5"><font color="">
<?php
$query = "Select MREC_DESC, MREC_CODI from MEDIO_RECEPCION where $where_medio ORDER BY 1";
$rs=$db->conn->query($query);
$varQuery = $query;
if($rs)
{
	print $rs->GetMenu2("med", $med, "$opcMenu", false,"","class='select' " );
}
?>
</font>
</td>
<?php
$parametroTip = False;
if ($parametroTip == True)
{
  ?>
	<td width="25%"  class="titulos5" align="right"> <font face="Arial, Helvetica, sans-serif" class="etextomenu">Tipo Doc</font>
	</td>
	<td width="25%" valign="top" class="listado5"> <font color="">
	<input name="hoj" type=hidden value="<? echo $hoj; ?>">
	<?php
	$query = "select  SGD_TPR_DESCRIP,SGD_TPR_CODIGO from SGD_TPR_TPDCUMENTO WHERE SGD_TPR_TPUSO='$ent' OR SGD_TPR_TPUSO='4' ORDER BY SGD_TPR_DESCRIP ";
	$query = "select SGD_TPR_DESCRIP,SGD_TPR_CODIGO from SGD_TPR_TPDCUMENTO WHERE SGD_TPR_TP$ent='1' ORDER BY SGD_TPR_DESCRIP ";
	$opcMenu = "0:-- Seleccione un tipo --";
	$fechaHoy = date("Y-m-d");
	$fechaHoy = $fechaHoy . "";
	if((!$Submit3 and !$Submit4 and !$ModificarR) or $fechaRadicacion==$fechaHoy or !$fechaRadicacion)
	{
	}
	else
	{
		$query = "select  SGD_TPR_DESCRIP,SGD_TPR_CODIGO from SGD_TPR_TPDCUMENTO WHERE SGD_TPR_CODIGO=$tdoc ";
		$opcMenu = "";
	}
	$ADODB_COUNTRECS = true;
	$rs=$db->conn->query($query);
	if ($rs && !$rs->EOF )
	{	$numRegs = "!".$rs->RecordCount();
		$varQuery = $query;
		print $rs->GetMenu2("tdoc", $tdoc, "$opcMenu", false,"","class='ecajasfecha' " );
	}
	$ADODB_COUNTRECS = false;
?>
</font>
	</td>
<?php
}
else
{
	$tdoc =0;
}
?>
</tr>
</table>
<table width=100% border="0" cellspacing="2" cellpadding="3" class="borde_tab" align="center">
<tr>
	<td  class="titulos5" width="25%" align="right">
		<font color="" face="Arial, Helvetica, sans-serif" class="etextomenu">Anexos</font>
	</td>
	<td width="75%" class="listado5">
		<font color="" face="Arial, Helvetica, sans-serif">
		<input name="ane" id="ane" type="text" size="70" maxlength="99" class="tex_area" value="<?php echo htmlspecialchars(stripcslashes($ane));?>">
		</font>
	</td>
</tr>
<tr>
	<td class="titulos5" width="25%" align="right">
		<font color="" face="Arial, Helvetica, sans-serif" class="etextomenu">Dependencia</font>
	</td>
	<td colspan="3" width="75%" class="listado5">
    <font color="" face="Arial, Helvetica, sans-serif">


<?php
    // Busca las dependencias existentes en la Base de datos...
    if($radi_depe_actu_padre and $tipoanexo==0 and !$coddepeinf)  $coddepe = $radi_depe_actu_padre;
    if(!$coddepe)
    {
    	$coddepe=$dependencia;
    }
    /** Solo los documentos de entrada (ent=2) muestra la posibilidad de redireccion a otras dependencias
	* @queryWhere String opcional para la consulta.
	*/
	if($ent!=2) 
        {
            $cat_depe = 'd.DEPE_NOMB';
            $queryWhere =" where d.depe_codi=$dependencia and d.depe_estado = 1 " ;
            $order =" d.DEPE_NOMB";
        }
        else 
        {   
            $cat_depe = $db->conn->concat('d.dep_sigla',"' - '",'d.DEPE_NOMB');
            $queryWhere = " where d.depe_estado = 1 and u.usua_codi=1";
            $order =" dep_sigla ";
        }
        
    $query = "select distinct $cat_depe,d.DEPE_CODI,$order from dependencia d
               join usuario u  on u.depe_codi=d.depe_codi
              $queryWhere order by 3 ";
    $ADODB_COUNTRECS = true;
    $rs=$db->conn->query($query);
    $numRegs = "!".$rs->RecordCount();
    $varQuery = $query;
    $comentarioDev = "Muestra las dependencias";
    print $rs->GetMenu2("coddepe", $coddepe, "0:-- Seleccion una Dependencia --", false,"","class='select'");
    $ADODB_COUNTRECS = false;
?>
    </font>
	</td>
</tr>
<?php 
if(!$Submit3 and !$Submit4)
{
?>

<?php
}
else
{    
        /*
         * Muestra el combo de motivos de modificacion
         */
        
    
?>
<tr>
	<td  class="titulos5" width="25%" align="right">
		<font color="" face="Arial, Helvetica, sans-serif" class="etextomenu">Motivo de Modificaci&oacute;n</font>
	</td>
        
	<td width="75%" class="listado5">
		<font color="" face="Arial, Helvetica, sans-serif">
                    <? echo $sls_motModificacion;?>
                </font>
	</td>
</tr>

<?php
}
?>

<?php
// Comprueba si el documento es una radicaci�n nueva de entrada....
if($tipoanexo==0 and $radicadopadre and !$radicadopadreseg and (!$Submit3  and !$Submit4))
{
?>
<tr>
	<td class="titulos5" width="25%" align="right">
		<font color="" face="Arial, Helvetica, sans-serif" class="etextomenu">Usuario Destino</font>
	</td>
	<td colspan="3" width="75%" class="listado5">
<?php
if($radi_depe_actu_padre==999)
{
	echo "<font color=red >Documento padre se encuentra en Archivo</font>";
}
elseif($radi_depe_actu_padre and $rad0)
{
	$query= "select USUA_NOMB, USUA_CODI from usuario where depe_codi=$radi_depe_actu_padre and usua_codi=$radi_usua_actu_padre";
	$ADODB_COUNTRECS = true;
	$rs=$db->conn->query($query);
	$numRegs = "!".$rs->RecordCount();
	$ADODB_COUNTRECS = false;
	$varQuery = $query;
	$comentarioDev = "Muestra las dependencias";
	$usuario_padre = $rs->fields["USUA_NOMB"];
	$cod_usuario_inf = $rs->fields["USUA_CODI"];
	echo "$usuario_padre";
	$coddepeinf = $radi_depe_actu_padre;
	$informar_rad = "Informar";
	$observa_inf = "(Se ha generado un anexo pero ha sido enviado a la dependencia $coddepe)";
?>
		<input type=hidden name=radi_depe_actu_padre value="<?=$radi_depe_actu_padre?>">
		<input type=hidden name=coddepeinf value="<?=$coddepeinf?>">
		<input type=hidden name=cod_usuario_inf value="<?=$cod_usuario_inf?>">
<?php
}
?>
	</td>
</tr>
<?php
}

?>


<tr align="center">
         
	<td height="23" colspan="4" class="listado5"> <font color="" face="Arial, Helvetica, sans-serif">
           
<?php
echo "<!-- Dependencia - Usuario Actual  $coddepe / $radi_usua_actu  -->";
include "$ruta_raiz/include/tx/Tx.php";
include("../include/tx/Radicacion.php");
include("../class_control/Municipio.php");
$hist = new Historico($db);
$Tx = new Tx($db);

if($Submit3=="Radicar")
{
	$ddate=date("d");
	$mdate=date("m");
	$adate=date("Y");
	$fechproc4=substr($adate,2,4);
	$fechrd=$ddate.$mdate.$fechproc4;
	if($fechproc12=='')
	{
		$fechproc12=date('d');
		$fechproc22=date('m');
		$fechproc32=date('y');
	}
	$fechrdoc=$fecha_gen_doc;
	$apl .="";$apl=trim(substr($apl,0,50));
	$sapl .="";$sapl=trim(substr($sapl,0,50));
	$pnom .="";$pnom =trim(substr($pnom,0,89));
	$adress .="";
	$tip_rem +=0;
	$tip_doc +=0;
	$numdoc .='';$numdoc =trim(substr($numdoc,0,13));
	$long=strlen($cod);
	$codep +=0;
	$tel +=0;
	$cod +=0;
	$radicadopadre .='';
	$asu.='';
	$tip_rem=$tip_rem-1;
	$rem2.='';
	$dep +=0;
	$hoj +=0;
	$codieesp +=0;
	$ane .='';
	$med +=0;
	$acceso = 1;
	if($acceso==0)
	{}
	else
	{	if($tip_rem<0)
		{	$tip_rem=0;	}
		if(!$documento_us3)
		{	$documento_us3=0;	}
		/**  En esta linea si la dependencia es 999 ke es la dep. de salida envia el radicado a una
		*	 carpeta con el codigo de los dos primeros digitos de la dependencia
		*/
		if($ent != 2)
		{
			$carp_codi =$ent;
			$carp_per = "0";
			$radi_usua_actu = $codusuario;
		}
		else
		{
			$carp_codi ="0";
			$carp_per = "0";
			if($cod_usuario_inf!=1 and $coddepeinf==$coddepe)
			{
				$radi_usua_actu = $cod_usuario_inf;
			}
			else
			{
				$radi_usua_actu = 1;
		}	}
		if(!$radi_usua_actu and $ent == 2) $radi_usua_actu = $codusuario;
		if(!$radi_usua_actu) $radi_usua_actu = 1;
		if($coddepe==999)
		{
			$carp_codi=substr($dependencia,0,2);
			$carp_per=1;
			$radi_usua_actu = 1;
		}
		if(!$radi_usua_actu) $radi_usua_actu==1;
		if($radi_usua_actu_padre and $radi_depe_actu_padre)
		{
			$radi_usua_actu= "$radi_usua_actu_padre";
			$coddepe= "$radi_depe_actu_padre";
		}
		// Buscamos Nivel de Usuario Destino
		error_reporting(7);
		$tmp_mun = new Municipio($db);
		$tmp_mun->municipio_codigo($codep_us1,$muni_us1);
		$rad = new Radicacion($db);
               
                $rad->nivelRad = ($_POST['nivelradicar']== null)?0:$_POST['nivelradicar'];
             
		$rad->radiTipoDeri = $tpRadicado;
		$rad->radiCuentai = "'".trim($cuentai)."'";
		$rad->eespCodi =  $documento_us3;
		$rad->mrecCodi =  $med; // "dd/mm/aaaa"
                
		$rad->radiFechOfic =  $fecha_gen_doc;
		if(!$radicadopadre)  $radicadopadre = null;
		$rad->radiNumeDeri = trim($radicadopadre);
		$rad->radiPais =  $tmp_mun->get_pais_codi();
		$rad->descAnex = $ane;
		$rad->raAsun = $asu;
		$rad->radiDepeActu = $coddepe;
		$rad->radiDepeRadi = $coddepe;
		$rad->radiUsuaActu = $radi_usua_actu ;
		$rad->trteCodi =  $tip_rem;
		$rad->tdocCodi=$tdoc;
		$rad->tdidCodi=$tip_doc;
		$rad->carpCodi = $carp_codi;
		$rad->carPer = $carp_per;
		$rad->trteCodi=$tip_rem;
		$rad->ra_asun = htmlspecialchars(stripcslashes($asu));
		$rad->radiPath = 'null';
		if (strlen(trim($aplintegra)) == 0)
		$aplintegra = "0";
		$rad->sgd_apli_codi = $aplintegra;
		$codTx = 2;
		$flag = 1;
		$noRad = $rad->newRadicado($ent, $tpDepeRad[$ent]);
		if ($noRad=="-1")
			die("<hr><b><font color=red><center>Error no genero un Numero de Secuencia o Inserto el radicado<br>SQL </center></font></b><hr>");
	
		if(!$noRad) echo "<hr>RADICADO GENERADO <HR>$noRad<hr>";
		$radicadosSel[0] = $noRad;
		$hist->insertarHistorico($radicadosSel,  $dependencia , $codusuario, $coddepe, $radi_usua_actu, " ", $codTx);
		$nurad = $noRad;
		echo "<INPUT TYPE=HIDDEN NAME=nurad value=$nurad>";
		echo "<INPUT TYPE=HIDDEN NAME=flag value=$flag>";
		if($noRad)
		{
			$var_envio = session_name()."=".session_id()."&faxPath&leido=no&krd=$krd&verrad=$nurad&ent=$ent";
	?>
			</p><center><img src='../iconos/img_alerta_2.gif'><font face='Arial' size='3'><b>
			Se ha generado el radicado No.<b></font>
			<font face='Arial' size='4' color='red'><b><u>
			<?php if(substr($nurad,-1)==='2')
			{
				$ses = session_name()."=".session_id();
				echo "<a href=\"javascript:NewWindow('$ruta_raiz/radicacion/gen_etiqueta.php?r=".base64_encode($nurad.'%')."&$ses','popup_ver_estiquer',350,150,'center','front');\">" . $nurad."</a>";
			}
			else
				echo  $nurad;
			?>
			</u></b></font><br>
			<font face='Arial' size='4' color='red'>
<?php
			if($faxPath)
			{
				$varEnvio = session_name()."=".session_id()."&faxPath&leido=no&krd=$krd&faxPath=$faxPath&nurad=$nurad&ent=$ent";
?>
				<center>
				<input class="botones_largo" value ="SUBIR IMAGEN DE FAX" type=button target= 'UploadFax' onclick="window.open('uploadFax.php?<?=$varEnvio?>','Cargar Archivos de Fax', 'height=300, width=400,left=350,top=300')">
				</center>
<?php
			}
		}
		else
		{
			echo "<font color=red >Ha ocurrido un Problema<br>Verfique los datos e intente de nuevo</font>";
		}
		$sgd_dir_us2=2;
		$conexion = $db;
		error_reporting(7);
		include "grb_direcciones.php";
		$verradicado = $nurad;
		echo "<script>window.open('../verradicado.php?verrad=$nurad&var_envio=$var_envio".$datos_envio."&datoVer=985&ruta_raiz=".$ruta_raiz."', 'Modificaci&oacute;n_de_Datos', 'height=700,width=650,scrollbars=yes');</script>";
	}
	echo  "<INPUT TYPE=HIDDEN NAME=nurad value=$nurad>";
	echo  "<INPUT TYPE=HIDDEN NAME=codusuarioActu value=$codusuarioActu>";
	echo  "<INPUT TYPE=HIDDEN NAME='codieesp' value='$codieesp'>";
	echo "<INPUT TYPE=HIDDEN NAME='flag' value='$flag'>";
}
$vector = $coddepeinf;
if($vector)
{
	error_reporting(0);
	include_once("../class_control/Dependencia.php");
	$classDepen = new Dependencia($db);
	foreach ($vector as $key => $coddepeinf)
	{
		if($coddepeinf and ($coddepeinf!=999) and ($Submit3 or $Submit4)  )
		{
			$flag=0;
			if(($coddepeinf!=$coddepe or ($cod_usuario_inf!=1 and $coddepeinf==$coddepe)) and $Submit3 and $ent==2)
			{
				/**
				* INFORMACION DE ENVIO DE UN RADICADO EL CUAL EL PADRE ESTA EN UNA DEPENDENCIA DIFERENTE
				* $observa_add   contiene el mensaje que se enviara al informado
				* El mensaje cambia dependiendo a la persona que va.
				* Si va a un funcinario le informa al jefe de lo contrario informa a la otra dependencia
				**/
				if($cod_usuario_inf!=1 and $coddepeinf==$coddepe and $ent==2)
				{
					$observa_inf = "El documento Anexo del Radicado $radicadopadre se envio directamente al funcionario";
					$cod_usuario_inf = 1;
				}
				else
				{
					$observa_inf = "El documento Anexo del Radicado $radicadopadre se envio a la dep. $coddepe";
					$cod_usuario_inf = 1;
				}
			}
			else
			{
				if(!$Submit4)
				{
					$observa_add = "";
					$coddepeinf="";
				}
			}
			/** AQUI SE ENTRA A MODIFICAR EL RADICADO
			*
			*/
			if(($coddepeinf or (!$Submit4 and $coddepeinf!=$coddepe)) )
			{
				/**
				*	La siguiente decicion pregunta si la dependencia con la cual sale el radicado es
				* a misma que se pretende informar, ademas si es el jefe. En este caso no informa.
				*/
				$observa = "$observa_inf";
				if(!$cod_usuario_inf) $cod_usuario_inf=1;
				$nombTx = "Informar Documentos";
				$radicadoSel[0] = $nurad;
				$txSql = $Tx->informar($radicadoSel, $krd,$coddepeinf,$dependencia, $cod_usuario_inf,$codusuario, $observa, $_SESSION['usua_doc']);
				if (!$txSql)
				{
					$classDepen->Dependencia_codigo($coddepeinf);
					$depInfor = $depInfor.", ".$classDepen->depe_nomb;
				}
				$flagHistorico = true;
	}	}	}
	if ($depInfor)
		echo "<center><font color=red>No se pudo informar a:</font></center><BR><H2><center><font color=red>". substr($depInfor, 1)."</font></center></H2><BR><center><font color=red>No tienen usuarios Creados</font></center>";
}
$coddepeinf = $vector;
if($Submit4 and !$Buscar)
{
	$secuens=str_pad($consec,6,"0",STR_PAD_LEFT);
	$fechproc4=substr($adate,2,4);
	$fechrd=$ddate.$mdate.$fechproc4;
	$fechrdoc=$fechproc12.$fechproc22.$fechproc32;
	$apl .=' ';$apl=trim(substr($apl,0,50));
	$sapl .=' ';$sapl=substr($sapl,0,50);
	$pnom .=' ';$pnom =substr($pnom,0,89);
	$adress .=' ';
	$tip_rem +=0;$tip_doc +=0;$numdoc .='';$numdoc =trim(substr($numdoc,0,13));
	$codieesp +=0;$radicadopadre +=0;$long=strlen($cod);
	$codep +=0;$tel +=0;$cod +=0;$asu.='';$tip_rem=$tip_rem-1;
	$rem2.='';
	$dep +=0;
	$hoj +=0;
	$ane .='';
	$med +=0;
	if($tip_rem<0)
	{
		$tip_rem=0;
	}
	if(!$documento_us3)
	{
		$documento_us3 = 0;
	}
	/**  En esta linea si la dependencia es 999 ke es la dep. de salida envia el radicado a una
	*	 carpeta con el codigo de los dos primeros digitos de la dependencia
	*/
	$carp_codi=$ent;
	$carp_per=0;
	//if(!$radi_usua_actu) $radi_usua_actu = 1;
        
	if($depende==999)
	{
		$carp_codi=substr($dependencia,0,2);
		$carp_per=1;
		$radi_usua_actu = 1;
		$coddepe=$depende;
	}
	else {
            if($coddepe!=$_POST['depende'] or !$radi_usua_actu) {
                $aux=$radi_usua_actu;
                $radi_usua_actu=1;
            }
            if($aux!=1 and $aux and  !$_POST['depende'])$radi_usua_actu=$aux;
        }
	$rad = new Radicacion($db);
        
	$rad->radiTipoDeri = $tpRadicado;
	$rad->radiCuentai = "'$cuentai'";
	$rad->eespCodi =  $documento_us3;
	$rad->mrecCodi =  $med;
	$rad->radiFechOfic =  $fecha_gen_doc;
	if(!$radicadopadre)  $radicadopadre = null;
	$rad->radiNumeDeri = $radicadopadre;
	$rad->radiPais =  "'$pais'";
	$rad->descAnex = $ane;
	$rad->raAsun = $asu;
	$rad->radiDepeActu = $coddepe ;
	$rad->radiUsuaActu = $radi_usua_actu ;
	$rad->trteCodi =  $tip_rem;
	$rad->tdocCodi=$tdoc;
	$rad->tdidCodi=$tip_doc;
	$rad->carPer = $carp_per;
	$rad->trteCodi=$tip_rem;
	$rad->ra_asun = $asu;
        $rad->nivelRad = ($_POST['nivelradicar']== null)?0:$_POST['nivelradicar'];
	if (strlen(trim($aplintegra)) == 0)
	$aplintegra = "0";
        $rad->radiDepeRadi = $_POST["coddepe"];
	($_POST['radexp'])?$rad->radiDepeRadi = $_POST["coddepe"]:0;
	$rad->sgd_apli_codi = $aplintegra;
	$resultado = $rad->updateRadicado($nurad);
	$conexion = $db;
	include "grb_direcciones.php";
              
	if($resultado)
	
       echo "<script>window.open('../verradicado.php?verrad=$nurad&var_envio=$var_envio".$datos_envio."&datoVer=985&ruta_raiz=".$ruta_raiz."', 'Modificaci&oacute;n_de_Datos', 'height=700,width=650,scrollbars=yes');</script>";
            
               {
		echo "<center><font color=green>Radicado No $nurad fue Modificado Correctamente, </font></center>";
		$isqDep = "select DEPE_NOMB from dependencia where depe_codi=".$_POST["coddepe"];
                 $rsDep = $db->conn->Execute($isqDep);
                 
                 $sqlMotMod = "select motivo_modificacion_descrip as descrip from motivo_modificacion where motivo_modificacion_codigo = $motModificacionCodi";
                 $rs_MotModif = $db->conn->Execute($sqlMotMod);
                 $descripMotModif = $rs_MotModif->fields['DESCRIP'];

                $dependencia_asig = $rsDep->fields["DEPE_NOMB"];
		$radicadosSel[] = $nurad;
		($_POST['radexp'])?	$codTx = 60:$codTx = 11;
		$hist->insertarHistorico($radicadosSel,  $dependencia , $codusuario, $coddepe, $radi_usua_actu, "Modificacion Documento, Motivo de Modificacion: $descripMotModif.  Dependencia Asignada:  $dependencia_asig", $codTx);
                //$hist->insertarHistorico($radicadosSel);
        }

	if($borrarradicado)
	{
		$flag=0;
		$observa = "Se borro de Inf. ($krd)";
		$depbrr = substr($borrarradicado,0,3);
		$fechbrr = substr($borrarradicado,3,20);
		$data6 = substr($borrarradicado,3,50);
		$radicadosSel [0] = $nurad;
		$nombTx = "Borrar Informados";
		$codTx = 7;
		//$txSql = $rs->borrarInformado( $radicadosSel, $krd,$depbrr,$dependencia,$usCodSelect, $codusuario);
		$isql_inf= "delete from informados where depe_codi=$depbrr and radi_nume_radi=$nurad and info_desc like '%$data6%'";
		$rs=$db->conn->query($isql_inf);
		$hist->insertarHistorico($radicadosSel,  $dependencia , $codusuario, $coddepe, $radi_usua_actu, $observa, $codTx);
		if($flag==1)
		{
			echo "No se ha borrado la inf. de la dependencia $depbrr<br>";
		}else
		{
			echo "<font color=red><center>Se ha borrado un Inf. y registrado en eventos</center><br></font><br>";
		}
	}
}

echo "<INPUT TYPE=HIDDEN NAME=codusuarioActu value=$codusuarioActu>";
echo "<INPUT TYPE=HIDDEN NAME=radicadopadre value=$radicadopadre>";
echo "<INPUT TYPE=HIDDEN NAME=radicadopadreseg value=2>";
echo "<INPUT TYPE=HIDDEN NAME='codieesp' value='$codieesp'>";
echo "<INPUT TYPE=HIDDEN NAME='consec' value='$consec'>";
echo "<INPUT TYPE=HIDDEN NAME='seri_tipo' value='$seri_tipo'>";
echo "<INPUT TYPE=HIDDEN NAME='radi_usua_actu' value='$radi_usua_actu'>";
echo "<INPUT TYPE=HIDDEN NAME='radexp' value='".$_POST['radexp']."'>";
if(!$Submit3 and !$Submit4)
{
?>
	<center><input type='button' onClick='radicar_doc()' name='Submit33' value='Radicar' class="botones_largo">
	<input type='hidden'  name='Submit3' value='Radicar' class='ebuttons2'></center>
	</font>
<?php
}
else
{         
	include("hojaResumenPDF.php");
	$objHoja=new HojaResumenPDF($db);
	$objHoja->creaHoja($nurad);
	$varEnvio = session_name()."=".session_id()."&faxPath&leido=no&krd=$krd&faxPath=$faxPath&verrad=$nurad&nurad=$nurad&ent=$ent";
        
        
?>
  
       <center>   <input type='button' onClick='modificar_doc()' name='Submit44' value='MODIFICAR DATOS' class="botones_largo">
	<font face='Arial' size='2' color='red'><b><u>
	<a href="<?=$objHoja->enlacePDF()?>" class=vinculos>Ver Hoja Resumen </a>
	</u></b></font><br>
	<input type='hidden'  name='Submit4' value='MODIFICAR DATOS' class='ebuttons2'>
	<input type='hidden' name='nurad' value='<?=$nurad?>'></center>
<?php
}
?>
	</td>
</tr>
<?php
/** Aki valida si ya radico para dejar informar o Anexat archivos para ras. de Salida.
*/
if(($Submit4 or $Submit3) AND !$Buscar)
{
	if($ent==1 and !$Submit3)
	{
?>
<tr bgcolor=white>
	<td class="titulos5" colspan="5" align="center">
		<font color="" face="Arial, Helvetica, sans-serif" class="etextomenu">
	</td>
</TR>
<TR>
	<TD colspan="5">
<?php
		$ruta_raiz = "..";
		$radicar_documento = "true";
		if($num_archivos==1 and $radicado=="false")
		{
			$generar_numero = "no";
			$vp = "n";
			$radicar_a="$nurad";
			error_reporting(0);
		}
?>
	</TD>
</tr>
<?php
	}
?>
<tr bgcolor=white>
	<td class="titulos5">Informar a </td>
	<td class="listado5">
<?php
	$query ="select distinct d.DEPE_NOMB, d.DEPE_CODI from DEPENDENCIA d
                     join usuario u on u.depe_codi=d.depe_codi
                    where u.usua_codi=1 
              ORDER BY 1";
	$rs=$db->conn->query($query);
	$varQuery = $query;
	print $rs->GetMenu2("coddepeinf", $coddepeinf, false, true,5," class='select'" );
?>
	</td>
</tr>
</table>
<table border=0  width=100% class="borde_tab">
<tr>
	<td></td>
	<td class="titulos5">
		<b>SE HA INFORMADO A:<b></td><td class=listado2>Seleccione un doc. de Informado para borrar
	</td>
</tr>
</table>
<table border=0 class='borde_tab' width=100%>
<?php
	$query2 = "select b.depe_nomb,
					a.INFO_DESC,
					b.DEPE_NOMB,
					a.DEPE_CODI,
					a.info_fech as INFO_FECH,
					INFO_DESC
				from informados a,dependencia b
				where a.depe_codi=b.depe_codi and a.radi_nume_radi=$nurad
				order by info_fech desc ";
	$k = 1;
	$rs=$db->conn->query($query2);
	if ($rs)
	{
		while (!$rs->EOF)
		{	$data = $rs->fields['INFO_DESC'];
			$data2 = $rs->fields['DEPE_NOMB'];
			$data3 = $rs->fields['DEPE_CODI'];
			$data4 = date("dMy",$rs->fields['INFO_FECH']);
			// Modificado SGD 11-Jul-2007
			//$data5 = date("d-m-Y",$rs->fields['INFO_FECH']);
			$data5 = date( "d-m-Y", $db->conn->UnixTimeStamp( $rs->fields['INFO_FECH'] ) );
			$data6 = $db->conn->UnixTimeStamp( $rs->fields['INFO_DESC'] );
?>
<tr class='listado5'>
	<td><input type='radio' name='borrarradicado' value='<?=$data3.$data6?>'></td>
	<td class="listado5"><b><?=$data?></td><td class="listado5"> <center><?=$data2?></td><td class="listado5"><?=$data5?></td></tr>
<?php
			$k = $k +1;
			$rs->MoveNext();
		}
	}
	$verrad = $nurad;
?>
<tr><td></td></tr>
<?php
}
?>
</table>
<input type='hidden' name='depende' value='<?php echo $depende; ?>'><BR>
</td>
</tr>
</table>
<br>
</form>
<?php
$verrad = $nurad;
$radi = $nurad;
$contra = $drde;
$tipo = 1;
if($Submit3 or $Submit4 or $rad0 or $rad1 or $rad2)
{	echo "<script language='JavaScript'>";
	for ($i=1; $i<=3; $i++)
	{	$var_pai = "idpais".$i;
		$var_dpt = "codep_us".$i;
		$var_mcp = "muni_us".$i;
		$muni_tmp = ${$var_mcp};
		if (!(is_null($muni_tmp)))
		{	echo "\n";
			echo "cambia(document.formulario, 'idpais$i', 'idcont$i');
					formulario.idpais$i.value = ${$var_pai};
				  	cambia(document.formulario, 'codep_us$i', 'idpais$i');
				  	formulario.codep_us$i.value = '${$var_dpt}';
				  	cambia(document.formulario, 'muni_us$i', 'codep_us$i');
				  	formulario.muni_us$i.value = '${$var_mcp}';";
		}
	}
	echo "</script>";
}
?>
</body>
</html>
