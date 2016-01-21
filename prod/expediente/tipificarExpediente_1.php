<?php
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

include_once "$ruta_raiz/include/tx/Historico.php";
include_once ("$ruta_raiz/class_control/TipoDocumental.php");
include_once "$ruta_raiz/include/tx/Expediente.php";
$trd = new TipoDocumental($db);
$dependencia = str_pad($dependencia,3,"0", STR_PAD_LEFT);
$encabezadol = "$PHP_SELF?".session_name()."=".session_id()."&opcionExp=$opcionExp&numeroExpediente=$numeroExpediente&dependencia=$dependencia&krd=$krd&nurad=$nurad&coddepe=$coddepe&codusua=$codusua&depende=$depende&ent=$ent&tdoc=$tdoc&codiTRDModi=$codiTRDModi&codiTRDEli=$codiTRDEli&codserie=$codserie&tsub=$tsub&ind_ProcAnex=$ind_ProcAnex";
?>
<html>
<head>
<title>Tipificar Expediente</title>
<link href="../estilos/orfeo.css" rel="stylesheet" type="text/css"><script>

function regresar(){
	document.TipoDocu.submit();
}

function Start(URL, WIDTH, HEIGHT)
{
    windowprops = "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width="+WIDTH+",height="+HEIGHT;
    preview = window.open(URL , "preview", windowprops);
}
function habilitaCsc()
{
   document.getElementById('consecutivoExp').readOnly=true;
    if(document.getElementById('expManual').checked)
    {
        document.getElementById('consecutivoExp').readOnly=false;
    }
}

function valida_longitud(nombreobjeto)
{
    var objeto = document.getElementById(nombreobjeto);
    var num_caracteres = objeto.textLength;
    //alert('num_caracteres:'+num_caracteres+'\nobjeto.value: '+objeto.value);
    if (parseInt(num_caracteres) > 600)
    {
        objeto.value = contenido_textarea
    }
    else
    {
        contenido_textarea = objeto.value
    }
}

function activa()
{
	if(document.getElementById('crearExpediente'))document.getElementById('crearExpediente').style.display='none';
	if(document.getElementById('slcTipo').value==1)
	{
		document.getElementById('frmAdministrativo1').style.display='';
		document.getElementById('frmAdministrativo2').style.display='';
		document.getElementById('txtNrad').value='';
		document.getElementById('txtSindi').value='';
		document.getElementById('txtVicti').value='';
		document.getElementById('txtDenun').value='';
		document.getElementById('txtDelito').value='';
		document.getElementById('txtCondi').value='';
                document.getElementById('txtAutorDespacho').value='';
	}
	if(document.getElementById('slcTipo').value==2)
	{
		document.getElementById('frmProceso1').style.display='';
		document.getElementById('frmProceso2').style.display='';
		document.getElementById('frmProceso3').style.display='';
		document.getElementById('frmProceso4').style.display='';
		document.getElementById('frmProceso5').style.display='';
		document.getElementById('frmProceso6').style.display='';
                document.getElementById('frmProceso7').style.display='';
		document.getElementById('txtNombre').value='';
		document.getElementById('txt_asuExp').value='';
	}
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
	if(document.getElementById('areaExp').value==000)
	{
		msg +='Seleccione un \xE1rea !\n';
	    band =false;
	}
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
	if(document.getElementById('slcTipo').value==0)
	{
		msg +='Seleccione un tipo de expediente!\n';
	    band =false;
	}
	if(document.getElementById('slcTipo').value==1)
	{
		if(!document.getElementById('txtNombre').value)
		{
			msg +='Debe llenar el campo Nombre!\n';
	    	band =false;
		}
	}
	else if(document.getElementById('slcTipo').value==2)
	{
		if(!document.getElementById('txtNrad').value)
		{
			msg +='Debe llenar el campo No. Radicaci\xF3n!\n';
	    	band =false;
		}
		if(!document.getElementById('txtSindi').value)
		{
			msg +='Debe llenar el campo Sindicado!\n';
	    	band =false;
		}
		if(!document.getElementById('txtVicti').value)
		{
			msg +='Debe llenar el campo Victima!\n';
	    	band =false;
		}
		if(!document.getElementById('txtDenun').value)
		{
			msg +='Debe llenar el campo Denunciante!\n';
	    	band =false;
		}
		if(!document.getElementById('txtDelito').value)
		{
			msg +='Debe llenar el campo Delito!\n';
	    	band =false;
		}
		if(!document.getElementById('txtCondi').value)
		{
			msg +='Debe llenar el campo Condici\xF3n\n';
	    	band =false;
		}
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
	if(!valMaxChars(document.getElementById('txt_asuExp'),300,30))
	{
		return false;
	}
	if(!band) alert(msg);
	return band;
}
</script><style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<form method="post" action="<?=$encabezadol?>" name="TipoDocu">
 <?php
/**
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
	if(!$expManual)
	{
		$secExp = $expediente->secExpediente($dependencia,$codiSRD,$codiSBRD,$anoExp);
	}else
	{
		$secExp = $consecutivoExp;
	}
	$consecutivoExp = substr("00000".$secExp,-5);
	$numeroExpediente = $anoExp . $dependencia . $trdExp . $consecutivoExp . $digCheck;


    /*
     *  Modificado: 09-Junio-2006 Supersolidaria
     *  Arreglo con los parametros del expediente.
	 */
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
		$numeroExpedienteE = $expediente->crearExpediente( $numeroExpediente,$nurad,$dependencia,$codusuario,$usua_doc,$usuaDocExp,$codiSRD,$codiSBRD,'false',$fechaExp, $_POST['codProc'], $arrParametro, $txt_fueNom );
		if($numeroExpedienteE==0)
		{
			echo "<CENTER><table class=borde_tab><tr><td class=titulosError>EL EXPEDIENTE QUE INTENT&Oacute; CREAR YA EXISTE.</td></tr></table>";
		}else
		{
			/**  Procedimiento que Inserta el Radicado en el Expediente
			  *  @param $insercionExp Numeric  Devuelve 1 si inserto el expediente correctamente 0 si Fallo.
				*
			  */
			$insercionExp = $expediente->insertar_expediente( $numeroExpediente,$nurad,$dependencia,$codusuario,$usua_doc);
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
			$objFlujo->cambioNodoExpediente($numeroExpediente,$nurad,$expEstadoActual,$aristaActual,1,"Creacion Expediente",$_POST['codProc']);
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
      <td height="15" class="titulos2" colspan="2">APLICACION DE LA TRD EL EXPEDIENTE</td>
    </tr>

    <?php
    if( $numeroExpedienteE != 0 )
    {
        $arrTRDExp = $expediente->getTRDExp( $numeroExpediente, $codserie, $tsub, $codProc );
    ?>
    <tr class="titulos5">
      <td>SERIE</td>
      <td>
        <?php print $arrTRDExp['serie']; ?>
	  </td>
	  </tr>
	<tr class="titulos5">
	  <td>SUBSERIE</td>
	  <td>
        <?php print $arrTRDExp['subserie']; ?>
	  </td>
    </tr>
	<tr class="titulos5">
      <td>PROCESO</td>
      <td>
        <?php print $arrTRDExp['proceso']; ?>
       </td>
	</tr>
    <?php
    }
    ?>
</table>
<?php
if ( !isset( $Actualizar ) ) //Inicio if( $Actualizar )
{
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="borde_tab">
<tr>
	<td width="25%" class="titulos5" >SERIE</td>
	<td width="75%" class=listado5 >
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
			and ".$sqlFechaHoy." between s.sgd_srd_fechini and s.sgd_srd_fechfin
		order by detalle";
	$rsD=$db->conn->Execute($querySerie);
	$comentarioDev = "Muestra las Series Docuementales";
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsD->GetMenu2("codserie", $codserie, "0:-- Seleccione --", false,"","onChange='submit()' class='select'" );
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
			and ".$sqlFechaHoy." between su.sgd_sbrd_fechini and su.sgd_sbrd_fechfin
		order by detalle
		";
	$rsSub=$db->conn->Execute($querySub);
	include "$ruta_raiz/include/tx/ComentarioTx.php";
	print $rsSub->GetMenu2("tsub", $tsub, "0:-- Seleccione --", false,"","onChange='submit()' class='select'" );
	if(!$codiSRD)
	{
		$codiSRD = $codserie;
		$codiSBRD = $tsub;
	}
    /**********************************************/
    // Modificacion: 22-Mayo-2006
    // Selecciona el proceso y el codigo correspondiente segun la combinacion
    // Serie-Subserie
   	$queryPEXP = "select SGD_PEXP_DESCRIP,SGD_PEXP_CODIGO FROM
			SGD_PEXP_PROCEXPEDIENTES
			WHERE
				SGD_SRD_CODIGO=$codiSRD
				AND SGD_SBRD_CODIGO=$codiSBRD
			";
	$rs=$db->conn->Execute($queryPEXP);
	$texp = $rs->fields["SGD_PEXP_CODIGO"];
?>
	</td>
</tr>
<tr id="trProceso">
	<td class="titulos5" >PROCESO</td>
    <td class="listado5" colspan="2" >
<?php
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
                // print $queryPEXP;
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
<tr align="center">
	<td width="13%" height="25" class="titulos5" align="center">C&oacute;digo de Expediente</td>
<?php
if(!$digCheck)
{
	$digCheck = "E";
}
$expediente = new Expediente($db);
if(!$expManual)
{
	if(!$anoExp) $anoExp = date("Y");
	$secExp = $expediente->secExpediente($dependencia,$codiSRD,$codiSBRD,$anoExp);
}else
{
	$secExp = $consecutivoExp;
}
$trdExp = substr("000".$codiSRD,-3) . substr("00".$codiSBRD,-2);
$consecutivoExp = substr("00000".$secExp,-5);
if(!$anoExp) $anoExp = date("Y");
?>
	<td width="33%" class="listado2" height="25">
		<p>
		<select name=anoExp  class=select onChange="submit();">
			<?
				if($anoExp==(date('Y'))) $datoss = " selected "; else $datoss= "";
			?>
			<option value='<?=(date('Y'))?>' <?=$datoss?>>
			<?=date('Y')?>
			</option>
			<?
				if($anoExp==(date('Y')-1)) $datoss = " selected "; else $datoss= "";
			?>
			<option value='<?=(date('Y')-1)?>' <?=$datoss?>>
			<?=(date('Y')-1)?>
			</option>
			<?
				if($anoExp==(date('Y')-2)) $datoss = " selected "; else $datoss= "";
			?>
			<option value='<?=(date('Y')-2)?>' <?=$datoss?>>
			<?=(date('Y')-2)?>
			</option>
			<?
				if($anoExp==(date('Y')-3)) $datoss = " selected "; else $datoss= "";
			?>
			<option value='<?=(date('Y')-3)?>' <?=$datoss?>>
			<?=(date('Y')-3)?>
			<?
				if($anoExp==(date('Y')-4)) $datoss = " selected "; else $datoss= "";
			?>
			<option value='<?=(date('Y')-4)?>' <?=$datoss?>>
			<?=(date('Y')-4)?>
			</option>
		</select>
		<input type=text name=depExp value='<?=$dependencia?>' class=select maxlength="3" size="2" readonly>
		<input type=text name=depExp value='<?=$trdExp?>' class=select maxlength="5" size="4" readonly>
		<input type=text name=consecutivoExp id="consecutivoExp" value='<?=$consecutivoExp?>'  class=select maxlength="5" size=4 readonly>
		<input type=text name=digCheckExp value='<?=$digCheck?>' class=select maxlength="1" size="1" readonly>
<?php
	$numeroExpediente = $anoExp . $dependencia . $trdExp . $consecutivoExp . $digCheck;
?>
		<br>A&ntilde;o-Dependencia-Serie Subserie-Consecutivo-E
		<br>El consecutivo "<?=$consecutivoExp?>" es temporal y puede cambiar en el momento de crear el expediente.
		<br><?=$numeroExpediente?>
	</td>
</tr>
<tr align="center">
	<td width="13%" height="25" class="titulos5" align="center">Consecutivo de Expediente Manual</td>
	<td class=listado2>
<?php
	if($expManual) $datoss=" checked "; else $datoss = "";
?>
		<input type=checkbox name='expManual' id="expManual" <?=$datoss?> onclick="habilitaCsc();" >
	</td>
</tr>
<?php
$sqlParExp  = "SELECT SGD_PAREXP_ETIQUETA, SGD_PAREXP_ORDEN,";
$sqlParExp .= " SGD_PAREXP_EDITABLE";
$sqlParExp .= " FROM SGD_PAREXP_PARAMEXPEDIENTE PE";
$sqlParExp .= " WHERE PE.DEPE_CODI = ".$dependencia;
$sqlParExp .= " ORDER BY SGD_PAREXP_ORDEN";

$rsParExp = $db->conn->Execute( $sqlParExp );
while ( !$rsParExp->EOF )
{
?>
<tr align="center">
	<td width="13%" height="25" class="titulos5" align="left">
<?php
print $rsParExp->fields['SGD_PAREXP_ETIQUETA'];
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
	<td width="13%" height="25" class="titulos5" align="left">
		<input type="text" name="parExp_<?php print $rsParExp->fields['SGD_PAREXP_ORDEN']; ?>" value="<?php print $_POST[ 'parExp_'.$rsParExp->fields['SGD_PAREXP_ORDEN'] ]; ?>" size="60" <?php print $readonly; ?>>
	</td>
</tr>
<?php
	$rsParExp->MoveNext();
}
?>
<!--
<tr align="center">
	<td width="13%" height="25" class="titulos5" align="center" colspan="2">
		<input type="button" name="Button" value="BUSCAR" class="botones" onClick="Start('buscarParametro.php?busq_salida=<?=$busq_salida?>&krd=<?=$krd?>',1024,420);">
	</td>
</tr>
-->
<tr>
	<TD class=titulos5>Fecha de Inicio del Proceso.</TD>
	<td class=listado2>
		<script language="javascript">
<?php
if(!$fechaExp) $fechaExp = date("d/m/Y");
?>
var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "TipoDocu", "fechaExp","btnDate1","<?=$fechaExp?>",scBTNMODE_CUSTOMBLUE);
		</script>
		<script language="javascript">
			dateAvailable1.date = "<?=date('Y-m-d');?>";
			dateAvailable1.writeControl();
			dateAvailable1.dateFormat="dd-MM-yyyy";
		</script>
	</td>
</tr>
<tr>
	<td class=titulos5>Usuario Responsable del Proceso</td>
	<td class=listado2>
<?php
$queryUs = "select usua_nomb, usua_doc from usuario where depe_codi=$dependencia AND USUA_ESTA='1' order by usua_nomb";
$rsUs = $db->conn->Execute($queryUs);
print $rsUs->GetMenu2("usuaDocExp", "$usuaDocExp", "0:-- Seleccione --", false,""," class='select' onChange='submit()'");
?>
	</td>
</tr>
<tr>
    <td class=titulos5>Nombre</td>
    <td class=listado2>
        <input type="text" name="txt_fueNom" id="txt_fueNom" size="55" maxlength="160" value="<?= $txt_fueNom?>"></input>
    </td>
</tr>
<tr  id='frmAdministrativo1'>

    <td class=titulos5 colspan="1">Nombre del Expediente</td>
    <td class=listado2 colspan="5">
        <input  type="text" name="txtNombre" class="caja_text" id="txtNombre" size="100" maxlength="200" onchange="mayus(this)" onblur="mayus(this)" value="<?=$_POST['txtNombre'] ?>">
    </td>
</tr>
<tr id='frmAdministrativo2'>
    <td class=titulos5 colspan="1">Asunto del Expediente</td>
    <td class=listado2 colspan="5">
        <textarea name="txt_asuExp" id="txt_asuExp" class="tex_area" rows="2" cols="84" onchange="mayus(this)" onblur="mayus(this)"><?= $_POST['txt_asuExp']?></textarea>
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
		<div align="justify">
            <br>
		    <strong>
                <b>
                    Recuerde:
                </b>
                No podr&aacute; modificar el numero de expediente si hay un error en el expediente, mas adelante tendr&aacute;
                que excluir este radicado del expediente y si es el caso solicitar la anulaci&oacute;n del mismo. Adem&aacute;s debe
                tener en cuenta que apenas coloca un nombre de expediente, en Archivo crean una carpeta f&iacute;sica en el cual
                empezar&aacute;n a incluir los documentos pertenecientes al mismo.
            </strong>
		</div>
	</td>
</tr>
</table>
<?
}
}// Fin if( $Actualizar )
?>
<table border=0 width=100% align="center" class="borde_tab">
<tr align="center">
	<td width="33%" height="25" class="listado2" align="center">
	<center>
<?php
/*
 *  Modificado: 11-Agosto-2006 Supersolidaria
 *  No se tiene en cuenta la seleccion de algun proceso para crear un expediente.
*/
if($tsub and $codserie && !$Actualizar and $usuaDocExp)
{
	if(!$crearExpediente)
	{
		/*
         *  Modificado: 17-Agosto-2006 Supersolidaria
         *  Si hay procesos asociados, muestra un mensaje indicando que se debe seleccionar alguno.
         */
		if( is_array( $arrProceso ) && $codProc == 0 )
		{
?>
		<input name="crearExpediente" type="button" class="botones_funcion" value=" Crear Expediente " onClick="alert('Por favor seleccione un proceso.'); document.TipoDocu.codProc.focus();">
<?php
		}
		else
		{
?>
		<input name="crearExpediente" type=submit class="botones_funcion" value=" Crear Expediente ">
<?php
		}
	}
	else
	{
			?>
			<input name="Actualizar" type=submit class="botones_funcion" value=" Confirmacion Creacion de Expediente ">
			<?
		}
	}
?>
	</center>
	</td>
</tr>
<tr>
	<td width="33%" class="listado2" height="25" colspan="2">
		<center>
    	<input name="cerrar" type="button" class="botones_funcion" id="envia22" onClick="opener.regresar(); window.close();" value=" Cerrar ">
    	</center>
	</td>
</tr>
</table>
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
					WHERE RADI_NUME_RADI = $nurad
				    AND  DEPE_CODI =  $coddepe";
		$rs=$db->conn->Execute($sql);
		$radiNumero = $rs->fields["RADI_NUME_RADI"];
		if ($radiNumero !='') {
			?>
			if (confirm('Esta Seguro de Modificar el Registro de su Dependencia ?'))
				{
					nombreventana="ventanaModiR1";
					url="tipificar_documentos_transacciones.php?modificar=1&usua=<?=$krd?>&codusua=<?=$codusua?>&tdoc=<?=$tdoc?>&tsub=<?=$tsub?>&codserie=<?=$codserie?>&coddepe=<?=$coddepe?>&nurad=<?=$nurad?>";
					window.open(url,nombreventana,'height=200,width=300');
				}
			<?php
	 		}else
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
</script>
</form>
<span>
<p>
<?=$mensaje_err?>
</p>
</span>
</body>
</html>