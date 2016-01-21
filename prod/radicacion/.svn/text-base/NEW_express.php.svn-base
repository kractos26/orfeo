	<?php
/**
 * Modulo de radicacion Express.
 * Desarollo: Grupo Iyunxi Ltda.
 * Autor: IYU.
 * Julio de 2010.
 */

//Seguridad
session_start();
if (!$_SESSION["usua_perm_tpx"]) die("Error accesando la p&aacute;gina. No tiene Privilegios.");

$ruta_raiz="..";
include "$ruta_raiz/config.php";		// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include "$ADODB_PATH/adodb.inc.php";	// $ADODB_PATH configurada en config.php
include "$ruta_raiz/include/db/ConnectionHandler.php";
$ADODB_COUNTRECS = false;

$error = 0;
$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
$conn = NewADOConnection($dsn);
$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug=true;
if ($conn && $db)
{	
	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
	
	$sqlfn = $db->conn->SQLDate('Y-m-d',$db->conn->sysDate);
	$sql = "SELECT $sqlfn as fecha_hoy FROM usuario";
	if ($var_date = $conn->GetOne($sql))
	{
		$var = split('-',$var_date);
		$txt_dia = $var[2];
		$txt_mes = $var[1];
		$txt_ano = $var[0];
	}
	else                                                   
	{}
	
	if (isset($_POST['btn_rad']))
	{
		include("$ruta_raiz/include/tx/Historico.php");
		$hst = new Historico($db);

		$SecName = "SECR_TP2"."_".$tpDepeRad[2];
		$secNew = $db->conn->GenID($SecName);
		$nextval = $db->conn->GenID("sec_dir_direcciones");
		$newRadicado = $txt_ano.str_pad($_SESSION['dependencia'],3,"0", STR_PAD_LEFT).str_pad($secNew,6,"0",STR_PAD_LEFT)."2";
		
		$db->conn->StartTrans();
		$record=null;
		$record["RADI_NUME_RADI"] = $newRadicado;
		$record["RADI_FECH_RADI"] = $db->conn->sysTimeStamp;
		$record["CARP_PER"] = 0;
		$record["CARP_CODI"] = 0;
		$record["TDOC_CODI"] = 0;
		$record["RADI_DESC_ANEX"] = $db->conn->qstr($_POST['txt_desc']);
		$record["RADI_DEPE_RADI"] = $slc_dep;
		$record["RADI_USUA_RADI"] = $_SESSION["codusuario"];
		$record["RADI_DEPE_ACTU"] = $slc_dep ; 
		$record["RADI_USUA_ACTU"] = 0;
	    	$tipstri = (string)$record["RADI_NUME_RADI"];
		$tiporadi = substr($tipstri, -1);
		/*if($tiporadi == "2") 
		{
       			$record["SGD_SPUB_CODIGO"] = 1;
		}*/
		foreach ($record as $key => $value)
		{
			$campo .= "$key,";
			$valor .= "$value,";
		}
		$campo = substr($campo,0,strlen($campo)-1);
		$valor = substr($valor,0,strlen($valor)-1);
		
		$sql = "INSERT INTO RADICADO ($campo) VALUES ($valor)";
		$db->conn->Execute($sql);
		
		$isqDep = "select DEPE_NOMB from dependencia where depe_codi=$slc_dep";
		$rsDep = $db->conn->Execute($isqDep);			      	   
		$dependencia_asig = $rsDep->fields["DEPE_NOMB"];
	    
		$radicadosSel[0] = $newRadicado;    
		$hst->insertarHistorico($radicadosSel,$_SESSION['dependencia'],$_SESSION["codusuario"], 998, 2, "Rad. Express", 2);
		
		$record = null;
		$record["RADI_NUME_RADI"] = $newRadicado;
		$record['SGD_DIR_TIPO'] = 1;
		$record['SGD_DIR_CODIGO'] = $nextval;
		$insertSQL = $db->conn->Replace("SGD_DIR_DRECCIONES", $record, array('RADI_NUME_RADI','SGD_DIR_TIPO'), $autoquote = true);
		
		$ok = $db->conn->CompleteTrans();
		if ($ok)
		{	$ses = session_name()."=".session_id();
			$msg  = "<tr><td><center><b><font face='Arial'>";
			$msg .= "Se ha generado el radicado No. </font><font face='Arial' size='4' color='red'>";
			$msg .= "<a href=\"javascript:NewWindow('$ruta_raiz/radicacion/gen_etiqueta.php?r=".base64_encode($newRadicado.'%')."&$ses','popup_ver_estiquer',350,150,'center','front');\">$newRadicado</a>";
			$msg .= "</font></b></center></td></tr>";
		}
		else
		{
			$msg = "<tr><td>Error al generar radicado.</td></tr>";
	}	}
	
	$cat_depe = $conn->concat('dep_sigla',"' - '",'depe_nomb');
	$sql = "select $cat_depe, d.depe_codi from dependencia d, usuario u where (u.depe_codi= d.depe_codi and usua_codi=1 and d.depe_estado=1 and d.depe_codi_territorial= ".$_SESSION['depe_codi_territorial'].") order by d.dep_sigla";
	$rs = $conn->Execute($sql);
	$slc_dep1 = $rs->GetMenu2('slc_dep',0,'0:&lt;&lt seleccione &gt;&gt;',false,false,'Class="select"');
}
?>
<html>
<head>
<title>Orfeo- Formulario de Radicaci&oacute;n Express.</title>
<link rel="stylesheet" href="<?=$ruta_raiz?>/estilos/orfeo.css" type="text/css">
<script language="JavaScript">
var win=null;
function NewWindow(mypage,myname,w,h,pos,infocus)
{
	if(pos=="random")	{myleft=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;mytop=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
	if(pos=="center")	{myleft=(screen.width)?(screen.width-w)/2:100;mytop=(screen.height)?(screen.height-h)/2:100;}
	else if((pos!='center' && pos!="random") || pos==null){myleft=0;mytop=20}
	settings="width=" + w + ",height=" + h + ",top=" + mytop + ",left=" + myleft + ",scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no";
	win=window.open(mypage,myname,settings);
	win.focus();
}

function sel_boton()
{
	document.frm_express.btn_rad.focus();
}

function validarad()
{
	var slc = document.frm_express.slc_dep.value;

	if(slc == 0){ alert("Debe escoger una dependencia para elaborar el radicado");
	return false;
	}	
	return true;
	}
// -->
</script>
</head>
<body onLoad='document.getElementById("txt_desc").focus();'>
<form action="<?=$_SERVER['PHP_SELF']?>" name="frm_express" id="frm_express" method="post" style="font-family:Arial;" >
<table cellpad=2 cellspacing='0' WIDTH=80% class='borde_tab' valign='top' align='center'>
<tr class="titulos4">
	<td align="center"><font size="2">ASIGNACI&Oacute;N DE N&Uacute;MERO DE RADICADO DE ENTRADA</font></td>
</tr>
<tr>
	<td class="listado2">
	<table width='100%' border='0' cellspacing='1' cellpadding='0'>
	<tr>
		<td align="center"><font size="2">
			Al tomar este n&uacute;mero se guardar&aacute; en la Base de Datos del Sistema.<br>
			Este n&uacute;mero es <b>OFICIAL</b><br>Si no est&aacute; seguro de la operaci&oacute;n, por favor no la realice.</font>
		</td>
	</tr>
	<tr><td>&nbsp</td></tr>
	<tr>
		<td align="center"><font size="2">
			Fecha:
				<input type="text" name="txt_dia" id="txt_dia" value="<?= $txt_dia?>" size="2" disabled>
				<input type="text" name="txt_mes" id="txt_mes" value="<?= $txt_mes?>" size="2" disabled>
				<input type="text" name="txt_ano" id="txt_ano" value="<?= $txt_ano?>" size="4" disabled>
			</font>
		</td>
	</tr>
	<tr class="border_tab">
		<td align="center"><font size="2">
			<table cellpad=2 cellspacing='0' WIDTH=70% class='borde_tab' valign='top' align='center'>
			<tr>
			<td><font size="2">Dependencia</font></td>
				<td>
				<?= $slc_dep1?>
				</td>
			</tr>
			<tr>
				<td><font size="2">Anexos</font></td>
				<td><input type="text" name="txt_desc" id="txt_desc" size="40" maxlength="60"> </td>
			</tr>
			</table>				
		</td>
	</tr>
	<tr>
		<td align="center"><br>
			<input type="submit" name="btn_rad" id="btn_rad"  class="botones_largo" value="Radicar" onclick="return validarad();">
		</td>
	</tr>
	</table>
</td>
</tr>
<?=$msg?>
</table>
</form>
</body>
</html>
