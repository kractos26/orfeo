<?
error_reporting(0);
$krdold = $krd;
session_start();
$ruta_raiz = "..";
if(!$krd) $krd = $krdold;
if (!isset($_SESSION['dependencia']))	include "$ruta_raiz/rec_session.php";
error_reporting(7);
if (!$nurad) $nurad= $rad;
if($nurad)
{
	$ent = substr($nurad,-1);
}
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug=true;
include_once "$ruta_raiz/include/combos.php";
include_once "$ruta_raiz/include/tx/Historico.php";
include_once ("$ruta_raiz/class_control/TipoDocumental.php");
include_once "$ruta_raiz/include/tx/Expediente.php";
include_once("$ruta_raiz/class_control/Dependencia.php");
$objDep = new Dependencia($db);
$trd = new TipoDocumental($db);
$dependencia = str_pad($dependencia,3,"0", STR_PAD_LEFT);
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&opcionExp=$opcionExp&numeroExpediente=$numeroExpediente&dependencia=$dependencia&krd=$krd&nurad=$nurad&coddepe=$coddepe&codusua=$codusua&depende=$depende&ent=$ent&tdoc=$tdoc&codiTRDModi=$codiTRDModi&codiTRDEli=$codiTRDEli&codserie=$codserie&tsub=$tsub&ind_ProcAnex=$ind_ProcAnex&dependenciaTerr=$dependenciaTerr&areaExp=$areaExp";

//crea combo de tipos de niveles
$arrNivel=array('0'=>"P&uacute;blico",'1'=>"Privado",'2'=>"Dependencia",'3'=>"Usuario Espec&iacute;fico");
$slcNivel="<select name='nivelExp' id='nivelExp' class='select' onchange='activa();'>";
foreach($arrNivel as $j=>$value)
{
	$nivelExp==$j?$est='selected':$est='';
	$slcNivel.="<option value=$j $est >$value</option>";
}
$slcNivel.="</select>";

//crea combo de dependencias
$cad = $db->conn->Concat($db->conn->IfNull("DEP_SIGLA","''"),"'-'",$db->conn->IfNull("DEPE_NOMB","''"));
$sql = "select $cad as NOMBRE , DEPE_CODI from dependencia d ORDER BY 1";
$rs  = $db->conn->Execute($sql);
if($rs and !$rs->EOF)
{
	$selectDep="<select name='selDepPriv[]' id='selDepPriv' size='3' class='select' multiple onChange=\"verUsuarios('$numExpediente','3','cDependencias');\" >";
	while(!$rs->EOF)
	{
		if($selDepPriv)in_array($rs->fields['DEPE_CODI'],$selDepPriv)?$estDep='selected':$estDep='';
		$selectDep.="<option value=".$rs->fields['DEPE_CODI']." $estDep >".$rs->fields['NOMBRE']."</option>";
		$rs->MoveNext();
	}
	$selectDep.="</select>";
}

if(!$fechaExp) $fechaExp = date("Y-m-d");
$objDep->Dependencia_codigo($dependencia);
$descDep=$objDep->depe_nomb;
$objCombo= new combo();
?>
<html>
<head>
<title>Crear Expediente</title>
<link href="../estilos/orfeo.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript" src="../js/funciones.js"></script>
<script language="javascript" src="<?=$ruta_raiz;?>/js/ajax.js"></script>
<script>
var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "TipoDocu", "fechaExp","btnDate1","<?=$fechaExp?>",scBTNMODE_CUSTOMBLUE);
<?php echo $objCombo->arrayToJsArray($vecAreas,"varea");?>
function regresar(){
	document.TipoDocu.submit();
}

function Start(URL, WIDTH, HEIGHT)
{
    windowprops = "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width="+WIDTH+",height="+HEIGHT;
    preview = window.open(URL , "preview", windowprops);
}
function activa()
{
	document.getElementById('trDep').style.display='none';
	document.getElementById('trUsu').style.display='none';
	document.getElementById('trTblUsu').style.display='none';		
	document.getElementById('consecutivoExp').readOnly=true;
	if(document.getElementById('crearExpediente'))document.getElementById('crearExpediente').style.display='none';
	if(document.getElementById('crearExpediente') && document.getElementById('usuaDocExp').value!=0)
	{
		document.getElementById('crearExpediente').style.display='';
	}
	if(document.getElementById('codProc').options.length <=1)
	{
		document.getElementById('trProceso').style.display='none';
	}
	
	//alert(document.getElementById('selDepPriv').selectedIndex)
	if(document.getElementById('nivelExp').value==0)
	{
		document.getElementById('selDepPriv').selectedIndex=-1
		document.getElementById('usuSel').value='';
		document.getElementById('textos').innerHTML='<center>El Expediente ser&aacute; p&uacute;blico para cualquier usuario.</center>';
	}
	if(document.getElementById('nivelExp').value==1)
	{
		document.getElementById('selDepPriv').selectedIndex=-1
		document.getElementById('usuSel').value='';
		document.getElementById('textos').innerHTML='<center>Si selecciona Privado, La persona responsable del Expediente ser&aacute; la &uacute;nica que lo podr&aacute; ver.</center>';
	}
	if(document.getElementById('nivelExp').value==2)
	{
		document.getElementById('selDepPriv').selectedIndex=-1
		document.getElementById('usuSel').value='';
		document.getElementById('textos').innerHTML='<center>Si selecciona Dependencia, solo los usuarios de su Dependencia podr&aacute;n ver el Expediente.</center>';
	}
	if(document.getElementById('nivelExp').value==3)
	{
		document.getElementById('trDep').style.display='';
		document.getElementById('trTblUsu').style.display='';
		document.getElementById('textos').innerHTML='<center>Solo los usuarios que seleccione podr&aacute;n ver el Expediente.</center>';
	}
	verUsuarios('',3,'');
	
}
function valida()
{
	var band=true;
	var msg='';
	if(document.getElementById('codProc').options.length>1)
	{
		if(document.getElementById('codProc').value==0)
		{
			msg +='Por favor seleccione un proceso!\n';
			document.getElementById('codProc').focus();
			band =false;
		}
	}
	if(document.getElementById('codserie').value==0)
	{
		msg +='Seleccione serie!\n';
	    band =false;
	}
	if(document.getElementById('tsub').value==0)
	{
            msg +='Seleccione Subserie!\n';
	    band =false;
	}

        if(!document.getElementById('txtNombre').value)
	{
            msg +='Debe llenar el campo Nombre!\n';
            band =false;
	}
	if(document.getElementById('expManual').checked==true)
	{
		if(document.getElementById('consecutivoExp').value==0)
		{
			msg +='Debe digitar un consecutivo !\n';
		    band =false;
		}
	}
	if(document.getElementById('nivelExp').value==3)
	{
		if(document.getElementById('selDepPriv') && document.getElementById('selDepPriv').selectedIndex==-1)
		{
			msg +='Debe seleccionar una Dependencia especifica para la seguridad';
			band =false;
		}
		if(document.getElementById('selUsuPriv[]') && document.getElementById('selUsuPriv[]').selectedIndex==-1)
		{
			msg +='Debe seleccionar un Usuario especifico para la seguridad';
			band =false;
		}
	}
	if(!valMaxChars(document.getElementById('txt_asuExp'),250,30))
	{
		return false;
	}
	if(!band) alert(msg);
	return band;
}

function mayus(obj)
{
	 obj.value=obj.value.toUpperCase( );
}
function redimensiona()
{
	window.moveTo(0,0);
	window.resizeTo(screen.width,230);
}

function usuaSel()
{
	if(document.getElementById('selUsuPriv[]'))
  	{	    var num =0;
  			var car='';
  			objUsu=document.getElementById('selUsuPriv[]');
  			document.getElementById('usuSel').value='';
  			for (i=0; opt=objUsu.options[i];i++)
	  		{
	  			car = (num > 0) ? ',' : '';
	    		if (opt.selected)
	    		{
	    			document.getElementById('usuSel').value += car + objUsu.options[i].value;
	    			num++;
	    		}
	  		}
	  		//alert(document.getElementById('usuSel').value);  		
  	}
}

function verUsuarios(numExp,tip,desde)
{
	if (xmlHttp)
	{
		obj = document.getElementById('selDepPriv');
  		var num =0;
  		var deps='';
  		var car='';
  		for (i=0; opt=obj.options[i];i++)
  		{
  			car = (num > 0) ? ',' : '';
    		if (opt.selected)
    		{
    			deps += car + obj.options[i].value;
    			num++;
    		}
  		}
  		vl2    = encodeURIComponent(deps);
		numExp = encodeURIComponent(numExp);
  		var tipo = "deps="+vl2+"&i="+tip+"&numExp="+numExp;
  		if(document.getElementById('usuSel').value)
  		{
	  		var usuarios = encodeURIComponent(document.getElementById('usuSel').value);
	  		if(desde=='cDependencias')document.getElementById('usuSel').value='';
	  		tipo+="&usuSel="+usuarios;
	  	}
		cache.push(tipo);
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
				xmlHttp.open("POST", "../tx/cTxSeguridad.php", true);
				xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				
				xmlHttp.onreadystatechange = handleRequestStateChange;
				xmlHttp.send(tipo);
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
		// turn error displaying OffUsuario  	 
		showErrors = false;
		// display error message
		alert("Error encountered: \n" + $message);
		// retry validation after 10 seconds
		setTimeout("actualizarCarpetas();", 10000);
	}
}

// read server's response
function readResponse()
{
	// retrieve the server's response
	var response = xmlHttp.responseText;
	// server error?
	if (response.indexOf("ERRNO") >= 0
	|| response.indexOf("error:") >= 0
	|| response.length == 0)
	throw(response.length == 0 ? "Server error." : response);
	if(response.length>0)
	{
		if(response.substr(-1)=='3')
		{
			document.getElementById('trUsu').style.display='';
			document.getElementById('divUsu').innerHTML=response.substr(0, response.length-1);
		}
		if(response.substr(-1)=='4')
		{
			document.getElementById('divTblUsu').innerHTML=response.substr(0, response.length-1);
		}
	}
	//setTimeout("validate();", 500);
}
function cscManual()
{
    document.getElementById('consecutivoExp').readOnly=true;
    if(document.getElementById('expManual').checked==true)document.getElementById('consecutivoExp').readOnly=false;
}
var nav4 = window.Event ? true : false;
function acceptNum(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
return (key <= 13 || (key >= 48 && key <= 57));
}
</script>
</head>
<body bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
<form method="post" action="<?=$encabezadol?>" name="TipoDocu" id="TipoDocu">
<?
/*
  * Adicion nuevo Registro
*/
if ($Actualizar && $tsub !=0 && $codserie !=0 )
{
	if(!$digCheck)
	{
		$digCheck = "E";
	}
  	$codiSRD = $codserie;
	$codiSBRD = $tsub;
	$trdExp = substr("000".$codiSRD,-3) . substr("00".$codiSBRD,-2);
	$expediente = new Expediente($db);
	$cheka='checked';
	if(!$expManual)
	{
		$cheka='';
		$secExp = $expediente->secExpediente($dependencia,$codiSRD,$codiSBRD,$anoExp);
	}else
	{
		$cheka='checked';
		$secExp = $consecutivoExp;
	}
	$consecutivoExp = substr("00000".$secExp,-5);
	$numeroExpediente = $anoExp . $dependencia . $trdExp . $consecutivoExp . $digCheck;

    foreach ( $_POST as $elementos => $valor )
    {
        if ( strncmp ( $elementos, 'parExp_', 7) == 0 )
        {
            $indice = ( int ) substr ( $elementos, 7 );
            $arrParametro[ $indice ] = $valor;
        }
    }

	/**  Procedimiento que Crea el Numero de  Expediente
	  *  @param $numeroExpediente String  Numero Tentativo del expediente, Hya que recordar que en la creacion busca la ultima secuencia creada.
	  *  @param $nurad  Numeric Numero de radicado que se insertara en un expediente.
      *  Modificado: 09-Junio-2006 Supersolidaria
      *  La funcion crearExpediente() recibe los parametros $codiPROC y $arrParametro
	  */
		$numeroExpedienteE = $expediente->crearExpediente( $numeroExpediente,$nurad,$dependencia,$codusuario,$usua_doc,$usuaDocExp,$codiSRD,$codiSBRD,'false',$fechaExp,$_POST['codProc'], $arrParametro, $_POST['txtNombre'],$_POST['txt_asuExp'],$nivelExp);
		if($numeroExpedienteE==0)
		{
			echo "<CENTER><table class=borde_tab><tr><td class=titulosError>EL EXPEDIENTE QUE INTENTO CREAR YA EXISTE.</td></tr></table>";
		}else
		{
			/**  Procedimiento que Inserta el Radicado en el Expediente
			  *  @param $insercionExp Numeric  Devuelve 1 si inserto el expediente correctamente 0 si Fallo.
				*
			  */
			$insercionExp = $expediente->insertar_expediente( $numeroExpediente,$nurad,$dependencia,$codusuario,$usua_doc);
			if($nivelExp==3)
                        {
                            $query = "UPDATE SGD_SEXP_SECEXPEDIENTES SET SGD_SEXP_NIVELSEG=$nivelExp where SGD_EXP_NUMERO='$numeroExpediente'";
                            $observa = "Expediente Confidencial(Visible solo Usuario(s) Espec&iacute;fico(s))";
                            if(is_array($selUsuPriv))
                            {
                                foreach ($selUsuPriv as $login)
                                {
                                    $insertUsuarios="insert into sgd_matriz_nivelexp (sgd_exp_numero, usua_login) values('$numeroExpediente','$login')";
                                    $rsIns=$db->conn->Execute($insertUsuarios);
                                }
                            }
			}
		}
                $codiTRDS = $codiTRD;
                $i++;
                $TRD = $codiTRD;
                $observa = "*TRD*".$codserie."/".$codiSBRD." (Creacion de Expediente.)";
                include_once "$ruta_raiz/include/tx/Historico.php";
                $radicados[] = $nurad;
                $tipoTx = 51;
                $Historico = new Historico($db);
                $Historico->insertarHistoricoExp($numeroExpediente,$radicados, $dependencia,$codusuario, $observa, $tipoTx,0);
                include ("$ruta_raiz/include/tx/Flujo.php");
                $objFlujo = new Flujo($db, $_POST['codProc'],$usua_doc);
                $expEstadoActual = $objFlujo->actualNodoExpediente($numeroExpediente);
                $arrayAristas =$objFlujo->aristasSiguiente($expEstadoActual);
                $aristaActual = $arrayAristas[0];
                $objFlujo->cambioNodoExpediente($numeroExpediente,$nurad,$expEstadoActual,$aristaActual,1,"Creacion Expediente");
                
/***************************** INSERTAR METADATOS ******************/
                            $db->conn->StartTrans();
                            $tabla = "SGD_MMR_MATRIMETAEXPE";
                            $r['SGD_EXP_NUMERO'] = $numeroExpedienteE;
                            foreach ($_POST as $k => $v) {
                                if (substr($k, 0, 8) == "txt_mtd_") {
                                    $idMtd = substr($k, 8);
                                    $r['SGD_MTD_CODIGO'] = $idMtd;
                                    $r['SGD_MMR_DATO'] = $_POST['txt_mtd_' . $idMtd];
                                    $db->conn->Replace(&$tabla, $r, array('SGD_EXP_NUMERO', 'SGD_MTD_CODIGO'), true);
                                }
                            }
                            $ok = $db->conn->CompleteTrans();
/*********************************************************************/
  }
	?>
<table border=0 width=100% align="center" class="borde_tab" cellspacing="1" cellpadding="0">
<?php
if( $numeroExpedienteE != 0 )
{
?>
<tr align="center" class="listado2">
	<td width="33%" height="25" align="center" colspan="2">
		<font color="#CC0000" face="arial" size="2">
			Se ha creado el Expediente No.
		</font>
		<b>
		<font color="#000000" face="arial" size="2">
			<?php print $numeroExpedienteE; ?>
                </font>
		</b>
		<font color="#CC0000" face="arial" size="2">
			con la siguiente informaci&oacute;n:
		</font>
	</td>
</tr>
<?php
}
?>
<tr align="center" class="titulos2">
	<td height="15" class="titulos2" colspan="2">APLICACION DE LA TRD DEL EXPEDIENTE</td>
</tr>
<?php
if( $numeroExpedienteE != 0 )
{
	$arrTRDExp = $expediente->getTRDExp( $numeroExpediente, $codserie, $tsub, $codProc );
?>
<tr class="titulos5">
	<td>SERIE</td>
	<td><?php print $arrTRDExp['serie']; ?></td>
</tr>
<tr class="titulos5">
	<td>SUBSERIE</td>
	<td><?php print $arrTRDExp['subserie']; ?></td>
</tr>
<tr class="titulos5">
	<td>PROCESO</td>
	<td><?php print $arrTRDExp['proceso']; ?></td>
</tr>
<?php
}
?>
</table><br>
<?php
if ( !isset( $Actualizar ) ) //Inicio if( $Actualizar )
{
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="borde_tab">
<tr >
	<td width="15%" class="titulos5" >SERIE</td>
	<td width="85%" class=listado5 >
	<?php
	if(!$tdoc) $tdoc = 0;
	if(!$codserie) $codserie = 0;
	if(!$tsub) $tsub = 0;
	$fechah=date("dmy") . " ". time("h_m_s");
	$fecha_hoy = Date("Y-m-d");
	$sqlFechaHoy=$db->conn->DBDate($fecha_hoy);
	$check=1;
	$fechaf=date("dmy") . "_" . time("hms");
	$num_car = 4;
	$nomb_varc = "s.sgd_srd_codigo";
	$nomb_varde = "s.sgd_srd_descrip";
	include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
	$querySerie = "select distinct ($sqlConcat) as detalle, s.sgd_srd_codigo
					from sgd_mrd_matrird m, sgd_srd_seriesrd s
					where m.depe_codi = '$coddepe'
					and s.sgd_srd_codigo = m.sgd_srd_codigo
					and ".$sqlFechaHoy." between $sgd_srd_fechini and $sgd_srd_fechfin
					order by detalle";
	$rsD=$db->conn->Execute($querySerie);
	$comentarioDev = "Muestra las Series Docuementales";
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsD->GetMenu2("codserie", $codserie, "0:-- Seleccione --", false,""," id='codserie' onChange='submit()' class='select'" );
 ?>
	</td>
</tr>
<tr>
	<td class="titulos5" >SUBSERIE</td>
	<td class=listado5 >
	<?
	$nomb_varc = "su.sgd_sbrd_codigo";
	$nomb_varde = "su.sgd_sbrd_descrip";
	include "$ruta_raiz/include/query/trd/queryCodiDetalle.php";
	$querySub = "select distinct ($sqlConcat) as detalle, su.sgd_sbrd_codigo
				 from sgd_mrd_matrird m, sgd_sbrd_subserierd su
				 where m.depe_codi = '$coddepe'
				 and m.sgd_srd_codigo = '$codserie'
				 and su.sgd_srd_codigo = '$codserie'
				 and su.sgd_sbrd_codigo = m.sgd_sbrd_codigo
				 and ".$sqlFechaHoy." between $sgd_sbrd_fechini and $sgd_sbrd_fechfin
				 order by detalle";
	$rsSub=$db->conn->Execute($querySub);
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsSub->GetMenu2("tsub", $tsub, "0:-- Seleccione --", false,""," id='tsub' onChange='submit()' class='select'" );
	if(!$codiSRD)
	{
		$codiSRD = $codserie;
		$codiSBRD = $tsub;
	}
    /**********************************************/
    // Modificacion: 22-Mayo-2006
    // Selecciona el proceso y el codigo correspondiente segun la combinacion
    // Serie-Subserie
   	// $queryPEXP = "select SGD_PEXP_DESCRIP,SGD_PEXP_TERMINOS FROM
   	$queryPEXP = "select SGD_PEXP_DESCRIP,SGD_PEXP_CODIGO FROM
			SGD_PEXP_PROCEXPEDIENTES
			WHERE
				SGD_SRD_CODIGO=$codiSRD
				AND SGD_SBRD_CODIGO=$codiSBRD
			";
	$rs=$db->conn->Execute($queryPEXP);
	$texp = $rs->fields["SGD_PEXP_CODIGO"];
    /*
	$expTerminos = $rs->fields["SGD_PEXP_TERMINOS"];
    if ($expTerminos)
    {
    $expDesc = " $expTerminos Dias Calendario de Termino Total";
    }
    */
    /**********************************************/
?>
	</td>
</tr>
<tr>
	<td colspan="2">
    <?php
    	$idSerie = $codserie;
		$idSSerie = $tsub;
        $metadatosAmostrar = 'S';	//Tipo Documental
        $registrosAmostrar = 'E';  //Expedientes
    	require "../listado_metadatos.php";
    ?>
    </td>
</tr>
<tr id="trProceso">
    <td class="titulos5" >PROCESO</td>
    <td class="listado5" colspan="2" >
    <?
	 $comentarioDev = "Muestra los procesos segun la combinacion Serie-Subserie";
     include "$ruta_raiz/include/tx/ComentarioTx.php";
     print $rs->GetMenu2("codProc", $codProc, "0:-- Seleccione --", false,""," id='codProc' onChange='submit()' class='select'" );
     /*
        *  Modificado: 17-Agosto-2006 Supersolidaria
        *  Se crea un arreglo con los procesos asociados a serie-subserie.
    */
     $rs->MoveFirst();
     while ( !$rs->EOF )
 	 {
 	 	$arrProceso[ $rs->fields["SGD_PEXP_CODIGO"] ] = $rs->fields["SGD_PEXP_DESCRIP"];
        $rs->MoveNext();
     }
    // Si se selecciono Serie-Subserie-Proceso
     if( $codProc != "" && $codProc != 0 && $codserie != "" && $codserie != 0 && $tsub != "" && $tsub != 0 )
     {
     	// Termino del proceso seleccionado
        $queryPEXP  = "select SGD_PEXP_TERMINOS";
        $queryPEXP .= " FROM SGD_PEXP_PROCEXPEDIENTES";
        $queryPEXP .= " WHERE SGD_PEXP_CODIGO  = ".$codProc;
        $rs=$db->conn->Execute($queryPEXP);
        $expTerminos = $rs->fields["SGD_PEXP_TERMINOS"];
        if ( $expTerminos != "" )
        {
        	$expDesc = " $expTerminos Dias Calendario de Termino Total";
        }
      }
      print "&nbsp;".$expDesc;
?>
      </td>
</tr>
</table>
<br>
<table border=0 width=100% align="center" class="borde_tab">
<tr>
	<td width="13%" height="25" class="titulos5" colspan="1">N&uacute;mero de Expediente</td>
	<?
	if(!$digCheck)
	{
		$digCheck = "E";
	}
	$expediente = new Expediente($db);
	if(!$expManual)
	{
		if(!$anoExp) $anoExp = date("Y");
		$secExp = $expediente->secExpediente($dependencia,$codiSRD,$codiSBRD,$anoExp,$dependenciaTerr);
	}else
	{
		$secExp = $consecutivoExp;
	}
	$trdExp = substr("000".$codiSRD,-3) . substr("00".$codiSBRD,-2);
	$consecutivoExp = substr("00000".$secExp,-5);
	if(!$anoExp) $anoExp = date("Y");
    for ($ano=date('Y'); $ano>=1945; $ano--)
    {
    	$sel = ($ano==$_POST['anoExp']) ? ' selected ' : '';
        $opc .= "<option value='$ano' $sel>$ano</option>";
    }
	?>
	<td width="33%" class="listado2" height="25" colspan="5">
	<table>
	<tr>
		<td><center>
		<select name=anoExp id=anoExp class=select onChange="submit();">
			<?php echo $opc?>
		</select></center>
		</td>
		<td><center><input type=text name=depExp value='<?=$dependencia?>' class=select maxlength="3" size="2" readonly></center></td>
		<td><center><input type=text name=depExp value='<?=$trdExp?>' class=select maxlength="5" size="5" readonly></center></td>
		<td><center><input type=text name=consecutivoExp id='consecutivoExp' value='<?=$consecutivoExp?>'  class=select maxlength="5" size=4 readonly onKeyPress="return acceptNum(event)"></center></td>
		<td><center><input type=text name=digCheckExp value='<?=$digCheck?>' class=select maxlength="1" size="1" readonly></center></td>
		<?$numeroExpediente = $anoExp . $dependencia . $trdExp . $consecutivoExp . $digCheck;?>
	</tr>
	<tr>
		<td><center><font size="1">A&ntilde;o</font></center></td>
		<td><center><font size="1">Dependencia</font></center></td>
		<td><center><font size="1">Serie Subserie</font></center></td>
		<td><center><font size="1">Consecutivo</font></center></td>
		<td><center><font size="1">E</font></center></td>
		</tr>
	<tr>
	<td colspan="6"><font size="1">El consecutivo "<?=$consecutivoExp?>" es temporal y puede cambiar en el momento de crear el expediente.
			<br></font><font size="2" ><b>
			<?=$anoExp. $dependencia . $trdExp . $consecutivoExp . $digCheck?></b>
		</font></td>
	</tr>
	</table>
	</td>
</tr>
<tr align="left">
    <td class="titulos5"  colspan="6">Dependencia: &nbsp;&nbsp;
        <span class=listado2><?php echo $descDep?></span>
    </td>
</tr>
<tr align="left">
	<td width="13%" height="25" class="titulos5" colspan="1">Consecutivo de Expediente Manual</td>
	<td class=listado2 colspan="5">
	<?if($expManual) $datosEM=" checked "; else $datosEM = "";?>
            <input type=checkbox name=expManual id=expManual <?=$cheka?> <?=$datosEM?>  onchange="cscManual()">
	</td>
</tr>
<tr >

    <td class=titulos5 colspan="1">Nombre del Expediente</td>
    <td class=listado2 colspan="5">
        <input  type="text" name="txtNombre" class="caja_text" id="txtNombre" size="60" maxlength="60" onchange="mayus(this)" onblur="mayus(this)" value="<?=$_POST['txtNombre'] ?>">
    </td>
</tr>
<tr >
    <td class=titulos5 colspan="1">Asunto del Expediente</td>
    <td class=listado2 colspan="5">
        <textarea name="txt_asuExp" id="txt_asuExp" class="tex_area" rows="2" cols="78" onchange="mayus(this)" onblur="mayus(this)"><?= $_POST['txt_asuExp']?></textarea>
    </td>
</tr>
  <?php
	// Modificado SGD 24-Septiembre-2007
    $sqlParExp  = "SELECT SGD_PAREXP_ETIQUETA, SGD_PAREXP_ORDEN,";
	$sqlParExp .= " SGD_PAREXP_EDITABLE";
    $sqlParExp .= " FROM SGD_PAREXP_PARAMEXPEDIENTE PE";
    $sqlParExp .= " WHERE PE.DEPE_CODI = ".$dependencia;
    $sqlParExp .= " ORDER BY SGD_PAREXP_ORDEN";
    // print $sqlParExp;
    $rsParExp = $db->conn->Execute( $sqlParExp );
    while ( !$rsParExp->EOF )
    {
  ?>
<tr align="center">
	<td width="13%" height="25" class="titulos5" align="left" colspan="1">
<?php
    print $rsParExp->fields['SGD_PAREXP_ETIQUETA'];
// Modificado SGD 24-Septiembre-2007
	if( $rsParExp->fields['SGD_PAREXP_EDITABLE'] == 1 )
	{
		$readonly = "";
	}
	else
	{
		$readonly = "readonly";
	}
?>
    </td>
    <td width="13%" height="25" class="titulos5" align="left" colspan="5">
    	<input type="text" name="parExp_<?php print $rsParExp->fields['SGD_PAREXP_ORDEN']; ?>" value="<?php print $_POST[ 'parExp_'.$rsParExp->fields['SGD_PAREXP_ORDEN'] ]; ?>" size="60" <?php print $readonly; ?>>
    </td>
</tr>
  <?php
        $rsParExp->MoveNext();
}
?>
<!--
<tr align="center">
	<td width="13%" height="25" class="titulos5" align="center" colspan="2"><input type="button" name="Button" value="BUSCAR" class="botones" onClick="Start('buscarParametro.php?busq_salida=<?=$busq_salida?>&krd=<?=$krd?>',1024,420);"></td>
</tr>
-->
<tr>
    <td class=titulos5 colspan="1">Fecha de Inicio del Proceso.</TD>
    <td class=listado2 colspan="5">
        <script language="javascript">
                dateAvailable1.date = "<?=date('Y-m-d');?>";
                dateAvailable1.writeControl();
                dateAvailable1.dateFormat="yyyy-MM-dd";
        </script>
    </td>
</tr>
<tr>
	<td class=titulos5 colspan="1">Usuario Responsable del Proceso</td>
	<td class=listado2 colspan="5">
<?
	$queryUs = "select usua_nomb, usua_doc from usuario where depe_codi=$dependencia AND USUA_ESTA='1'
							order by usua_nomb";
	$rsUs = $db->conn->Execute($queryUs);
	print $rsUs->GetMenu2("usuaDocExp", "$usuaDocExp", "0:-- Seleccione --", false,""," id='usuaDocExp' class='select' onChange='activa()'");

?>
	</td>
</tr>
<tr>
<td class=titulos5 colspan="1">Seguridad</td>
	<td class=listado2 colspan="5">
	 <table>
	 	<tr >
			<td class="titulos5" >Nivel</td>
			<td class=listado5 ><?=$slcNivel?></td>
		</tr>
		<tr id="trDep">
			<td class="titulos5" >Dependencia</td>
			<td class=listado5 ><?=$selectDep?></td>
		</tr>
		<tr id="trUsu" style="display:none">
			<td class="titulos5" >Usuario</td>
			<td class=listado5 >
				<span id="divUsu">..</span>
			</td>
		</tr>
		<tr id="trTblUsu">
			<td class=listado5 colspan="2"><span id="divTblUsu"><?=$usuariosNv?></span></td>
		</tr>
		<tr>
			<td class=listado5 colspan="2"><span id="textos" ></span></td>
		</tr>
	  </table>
	 </td>
</tr>
</table>
<br>
<?
if( $crearExpediente )
{
?>
<table border=0 width=100% align="center" class="borde_tab">
    <tr align="center">
        <td width="33%" height="25" class="listado2" align="center">
            <center class="titulosError2">
            ESTA SEGURO DE CREAR EL EXPEDIENTE ? <BR>
            EL EXPEDIENTE QUE VA HA CREAR ES EL :
            </center><B><center class="style1"><?=$numeroExpediente?></center>
            </B>
            <div align="justify"><br>
              <strong><b>Recuerde:</b>No podr&aacute; modificar el numero de expediente si hay un error en el expediente, mas adelante tendr&aacute; que excluir este radicado del expediente y si es el caso solicitar la anulaci&oacute;n del mismo. Ademas debe tener en cuenta que apenas coloca un nombre de expediente, en Archivo crean una carpeta f&iacute;sica en el cual empezaran a incluir los documentos pertenecientes al mismo. </strong>
            </div>
    </td>
	</tr>
  </table>
<?
}
?>

<?php
}// Fin if( $Actualizar )
?>
<table border=0 width=100% align="center" class="borde_tab">
<tr align="center">
	<td width="33%" height="25" class="listado2" align="center">
	<center>
	<?
	if(!$crearExpediente) 
	{ 
	?>
		<input name="crearExpediente"  id="crearExpediente" type=submit class="botones_funcion" value=" Crear Expediente "  onclick="return valida();" style="display:none">
	<?
	}  
	if($tsub and $codserie && !$Actualizar and $usuaDocExp)
	{
		if($crearExpediente)
		{
	?>
			<input name="Actualizar" type=submit class="botones_funcion" value=" Confirmacion Creacion de Expediente " onclick="return valida();">
	<?
		}
	}
	?>
	</center>
	</td>
	<td width="33%" class="listado2" height="25"><center><input name="cerrar" type="button" class="botones_funcion" id="envia22" onClick="opener.regresar(); window.close();" value=" Cerrar "></center></TD>
</tr>
</table>
<input type="hidden" name="usuSel" id="usuSel" value="<?=$usuSel?>">
<script>
function borrarArchivo(anexo,linkarch){
	if (confirm('Esta seguro de borrar este Registro ?'))
	{
		nombreventana="ventanaBorrarR1";
		url="tipificar_documentos_transacciones.php?borrar=1&usua=<?=$krd?>&codusua=<?=$codusua?>&coddepe=<?=$coddepe?>&nurad=<?=$nurad?>&codiTRDEli="+anexo+"&linkarchivo="+linkarch;
		window.open(url,nombreventana,'height=250,width=300');
	}
return;
}
function procModificar()
{
	if (document.TipoDocu.tdoc.value != 0 &&  document.TipoDocu.codserie.value != 0 &&  document.TipoDocu.tsub.value != 0)
	{
	  <?php
			$sql = "SELECT RADI_NUME_RADI
					FROM SGD_RDF_RETDOCF
					WHERE RADI_NUME_RADI = '$nurad'
					AND  DEPE_CODI =  '$coddepe'";
			$rs=$db->conn->Execute($sql);
			$radiNumero = $rs->fields["RADI_NUME_RADI"];
			if ($radiNumero !='') 
			{
			?>
				if (confirm('Esta Seguro de Modificar el Registro de su Dependencia ?'))
				{
					nombreventana="ventanaModiR1";
					url="tipificar_documentos_transacciones.php?modificar=1&usua=<?=$krd?>&codusua=<?=$codusua?>&tdoc=<?=$tdoc?>&tsub=<?=$tsub?>&codserie=<?=$codserie?>&coddepe=<?=$coddepe?>&nurad=<?=$nurad?>";
					window.open(url,nombreventana,'height=200,width=300');
				}
			<?php
		 	}
		 	else
			{
				?>
				alert("No existe Registro para Modificar ");
				<?php
			}
	       ?>
	}
    else
    {
    	alert("Campos obligatorios ");
    }
return;
}
<?php //if(!$Actualizar){?>
setTimeout("activa()",0);
<?php// }?>
<?php
if( $numeroExpedienteE != 0 )
{
?>
setTimeout("redimensiona()",0);
<?php }?>
</script>
</form>

<p>
<?=$mensaje_err?>
</p>
</body>
</html>
