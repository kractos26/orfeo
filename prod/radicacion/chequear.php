<?
$krdOld = $krd;
session_start();
error_reporting(7);
$ruta_raiz = "..";
include '../config.php';
if(!isset($_SESSION['dependencia'])) include "../rec_session.php";
define('ADODB_ASSOC_CASE', 1); 
include_once "../include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
//$db->conn->SetFetchMode(ADODB_FETCH_NUM);
session_cache_limiter('public');

$fechah = date("dmy") . "_" . time("hms");
if($buscar_por_radicado) $buscar_por_radicado = trim($buscar_por_radicado);
/** RADICA UN DOCUMENTO TIPO $ent EN LA DEP $dependencia \n Trae la secuencia de la dependencia **/

/**
 * RESERVA DE FAX. Aqui se reservan los fax, cuando un usuario entra a radicarlo.
 * @author      Jairo Hernan Losada
 * @version     3.0
 */
/** var $faxPath;
   * Variable que trae la ruta actual de un fax entrante.
   * @var string
   * @access public
   */
if($faxPath)
{
	$iSql= " SELECT SGD_RFAX_FAX, USUA_LOGIN, SGD_RFAX_FECHRADI
							FROM   SGD_RFAX_RESERVAFAX
							WHERE SGD_RFAX_FAX='$faxPath'
								AND USUA_LOGIN='$krd'
					";
	$rs = $db->conn->query($iSql);
	$krdTmp = $rs->fields("USUA_LOGIN");
	$fechRadicacion = $rs->fields("SGD_RFAX_FECHRADI");
  if($krdTmp!=$krd)
	{
		if(!$krdTmp)
		{
		}
		{
			if(trim($krdTmp)!="")
			{
		?>
		<hr><font color=red>POR FAVOR VERIFIQUE CON <?=$krdTmp?> QUE EL FAX QUE TOMO NO SEA RADICADO POR SEGUNDA VEZ, YA OTRA PERSONA (<?=$krdTmp?>) lo habia radicado</font><hr>
		<?
		}
		if($fechRadicacion)
		{
		?>
		<hr><font  color= red>CUIDADO !!!!! ESTE FAX YA APARECE CON FECHA DE RADICACI&Oacute;N !!!!!!! <?=$krdTmp?> CONSULTE
CON (<?=$krdTmp?>) FECHA DE RADICACION <?=$fechRadicacion?></font><hr>
		<?
		}
		}
		$codigoFax = substr($faxPath,3,9);
		$iSql= " insert into SGD_RFAX_RESERVAFAX
		( sgd_rfax_codigo
		, sgd_rfax_fax
		, usua_login
		, sgd_rfax_fech
		) values
		(
		$codigoFax
		,'$faxPath'
		,'$krd'
		,".$db->conn->OffsetDate(0,$db->conn->sysTimeStamp)."
		)
   ";
	$db->conn->query($iSql);
	}
}
?>
<html>
<head>
  <meta http-equiv="expires" content="99999999999">
  <meta http-equiv="Cache-Control" content="cache">
  <meta http-equiv="Pragma" content="public">
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>
<body topmargin="0" bgcolor="#FFFFFF">
   <div id="spiffycalendar" class="text"></div>
   <div id="spiffycalendar2" class="text"></div>
     <link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
		 <script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
		 <script language="javascript">
		 <!--
			<?
				$ano_ini = date("Y");
				$mes_ini = substr("00".(date("m")-1),-2);
				if ($mes_ini=="00") {$ano_ini=$ano_ini-1; $mes_ini="12";}
				$dia_ini = date("d");
				if(!$fecha_ini) $fecha_ini = "$ano_ini/$mes_ini/$dia_ini";
					$fecha_busq = date("Y/m/d") ;
				if(!$fecha_fin) $fecha_fin = $fecha_busq;
			?>
   var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "formulario", "fecha_ini","btnDate1","<?=$fecha_ini?>",scBTNMODE_CUSTOMBLUE);
   var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "formulario", "fecha_fin","btnDate2","<?=$fecha_fin?>",scBTNMODE_CUSTOMBLUE);
   function validar()
   {    marcados=0;
      
       for(i=0;i<document.form1.elements.length;i++)
        {            
            if(document.form1.elements[i].checked==true )
            {
                marcados++;
            }
        }

       if(marcados  <= 0)
        {
               alert('!Debe seleccionar un Radicado!')
               return false;
        }
           
       
   }
   function noPermiso(tip)
    {
    if(tip==0)
        alert ("No tiene permiso para acceder, su nivel es inferior al del usuario actual");
    if(tip==1)
        alert ("No tiene permiso para ver la imagen, el Radicado es confidencial");
    if(tip==2)
        alert("No tiene permiso para ver este radicado");
    }

//--></script>
<?
   if(!$busq)  $busq = 1;
    if(!$tip_rem){$tip_rem=3;}
   if($Submit)
   {
   	if($busq ==1){$cuentai = $buscar_por;}
    if($busq ==2){$noradicado = $buscar_por;}
    if($busq ==3){$documento = $buscar_por;}
    if($busq ==4){$nombres = $buscar_por;}

   }
$query = "select SGD_TRAD_CODIGO
						, SGD_TRAD_DESCR from sgd_trad_tiporad
					where SGD_TRAD_CODIGO=$ent";

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$rs=$db->conn->query($query);
$tRadicacionDesc = " - " .strtoupper($rs->fields["SGD_TRAD_DESCR"]);
$datos_enviar = session_name()."=".trim(session_id())."&krd=$krd&fechah=$fechah&faxPath=$faxPath";
?>
<form name="formulario1" method="post" action='chequear.php?dependencia=<?=$dependencia?>&krd=<?=$krd?>&<?=session_name()."=".trim(session_id())?>&krd=<?=$krd?>&faxPath=<?=$faxPath?>'>
  <!--<input name="buscareesp" type="text" class="ecajasfecha" size="20" value=<?php  echo "buscareesp"; ?>>
   <input name="buscareespbot" type=submit class="ebuttons2" value="Limitar EESP">-->
</form>
<form name="formulario" method="post" action='chequear.php?<?=session_name()."=".session_id()?>&krd=<?=$krd?>&dependencia=<?=$dependencia?>&krd=<?=$krd?>&faxPath=<?=$faxPath?>'>
  <div><input type=hidden name=ent value='<?=$ent?>'>

		
	<?
  /**
	 * MODULO DE RADICACION PREVIA
	 * @autor JAIRO H LOSADA
	 * @fecha 2005-02
	 */
  include "formRadPrevia.php";
?>
  </div>
</form>
<form action='NEW.php?<?=session_name()."=".trim(session_id())?>&krd=<?=$krd?>&dependencia=<?=$dependencia?>&krd=<?=$krd?>&faxPath=<?=$faxPath?>' method="post" name="form1" class="style1">
<input type=hidden name=ent value='<?=$ent?>'>
<tr> 
 <td colspan="3"> <div align="center">
    <table border=0 width=100% class="borde_tab" cellspacing="0" name="tbl_nvo"  id="tbl_nvo" >
    <tr>
        <td height="25" class="listado2" align="center">
            <center><input name="rad1"  size="10" type=submit class="botones_funcion" value="Nuevo"></center>
        </td>
    </tr>
    </table>
    <table border=0 width=100% class="borde_tab" cellspacing="0" >
	<tr align="center" class="titulos2" id="tbl_dsp" style="display:none" >
	<td height="15" class="titulos2" >RADICAR COMO...</td>
    </tr></table>
	<table border=0 width=100% class="borde_tab"   >
	<tr align="center" id="tbl_btns" style="display:none">
		<td width="33%" height="25" class="listado2" align="center">
         <center><input name="rad1" id="rad1" type=submit class="botones_funcion" value="Nuevo (Copia Datos)" style="display:none"></center>
        </td>
		<td width="33%" class="listado2" height="25">
			<center><input name="rad0" id="rad0" type=submit class="botones_funcion" value="Como Anexo" style="display:none" onclick="return validar()"></center></td>
		<td width="33%" class="listado2" height="25">
			<center><input name="rad2"  id="rad2" type=submit class="botones_funcion" value="Asociado" style="display:none" onclick="return validar();"></center>
		</td>
	</tr>
    </table>
<?php
$accion="&accion=buscar";
$variables = "&pnom=".strtoupper($pnom)."&papl=".$papl."$sapl=".$sapl."&numdoc=".$numdoc.$accion;
$target="_parent";
$hoy = date('d/m/Y');
$hace_catorce_dias = date ('d/m/Y', mktime (0,0,0,date('m'),date('d')-14,date('Y')));
$where ="   ";
// **** limite de Fecha 
$fecha_ini = mktime(00,00,00,substr($fecha_ini,5,2),substr($fecha_ini,8,2),substr($fecha_ini,0,4));
$fecha_fin = mktime(23,59,59,substr($fecha_fin,5,2),substr($fecha_fin,8,2),substr($fecha_fin,0,4));
$where_fecha = " and (a.radi_fech_radi >= ". $db->conn->DBTimeStamp($fecha_ini) ." and a.radi_fech_radi <= ". $db->conn->DBTimeStamp($fecha_fin).") " ;
$dato1=1;
$where_general  = " $where_fecha ";
if(!$and_cuentai){ $and_cuentai = " and ";}else { $and_cuentai = " or ";}
if(!$and_radicado){ $and_radicado = " and ";}else { $and_radicado = " or ";}
if(!$and_exp){ $and_exp = " and ";}else { $and_exp = " or ";}
if(!$and_doc){ $and_doc = " and ";}else { $and_doc = " or ";}
if(!$and_nombres){ $and_nombres = " and ";}else { $and_nombres = " or ";}
if($buscar_por_cuentai){ $where_general .= " $and_cuentai a.radi_cuentai like '%$buscar_por_cuentai%' ";}
if($buscar_por_radicado){ $where_general .= " $and_radicado a.radi_nume_radi = $buscar_por_radicado ";}
if($buscar_por_dep_rad){ $where_general .= " $and a.radi_depe_radi in($buscar_por_dep_rad) ";}
//echo $where_general;
if($buscar_por_doc)
{ 
  $where_ciu .= " $and_doc d.SGD_DIR_DOC = '$buscar_por_doc'";
}
if($buscar_por_exp)
{
	$where_ciu .= " $and_exp  g.SGD_EXP_NUMERO LIKE '%$buscar_por_exp%' ";
} 
$nombres = strtoupper(trim($buscar_por_nombres));
if(trim($nombres))
{	$array_nombre = explode(" ",$nombres);
	$strCamposConcat = $db->conn->Concat("UPPER(d.SGD_DIR_NOMREMDES)","UPPER(d.SGD_DIR_NOMBRE)");
	for($i=0;$i<count($array_nombre);$i++)
	{	$nombres = trim($array_nombre[$i]); 
		$where_ciu .= " and $strCamposConcat LIKE '%$nombres%' ";
	} 
}

$dato=2;
error_reporting(7);
if($primera!=1 and $Submit=="BUSCAR" and ($buscar_por_cuentai or $buscar_por_radicado or $buscar_por_nombres or $buscar_por_doc or $buscar_por_dep_rad or $buscar_por_exp ) )
{

$db = new ConnectionHandler("..");
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);	
$sqlFecha = $db->conn->SQLDate("d-m-Y H:i","a.RADI_FECH_RADI");

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

switch ($iBusqueda) {
case 1:
	$query = $query1;
	$eTitulo = "<table><tr><td></td></tr></table><table class='t_bordeGris' width=100%><tr class=eTitulo><td><span class=tpar>Resultados Busqueda por Ciudadanos</td></tr></table>";
	break;
case 2:
	$query = $query2;
	$eTitulo ="<table bgcolor=red><tr><td></td></tr></table><table class='t_bordeGris' width=100%><tr><td><span class=tpar>Resultados Busqueda por Otras Empresas</td></tr></table>";
	break;
case 3:
	$query = $query3;
	$eTitulo ="<table bgcolor=red><tr><td></td></tr></table><table class='t_bordeGris' width=100%><tr><td><span class=tpar>Resultados Busqueda por Esp</td></tr></table>";
	break;
case 4:
	$query = $query4;
	$eTitulo ="<table bgcolor=red><tr><td></td></tr></table><table class='t_bordeGris' width=100%><tr><td><span class=tpar>Resultados Busqueda por Funcionarios</td></tr></table>";
	break;
}


$tpBuscarSel = "";
if($tpBusqueda1) {
	echo $eTitulo; 
	$tpBuscarSel = "ok";
	$whereTrd = "1";
}

if($tpBusqueda2) {
	echo $eTitulo; 
	$tpBuscarSel = "ok";
	if($whereTrd) $whereTrd .= ",";
	$whereTrd .= "2";
}

if($tpBusqueda3) {
	echo $eTitulo; 
	$tpBuscarSel = "ok";
	if($whereTrd) $whereTrd .= ",";
	$whereTrd .= "3";
}
if($tpBusqueda4) {
	echo $eTitulo; 
	$tpBuscarSel = "ok";
	if($whereTrd) $whereTrd .= ",";
	$whereTrd .= "4";
}
if($whereTrd) $whereTrd = " AND d.SGD_TRD_CODIGO IN ($whereTrd)"; else $whereTrd = "";
include "$ruta_raiz/include/query/queryChequear.php";
$query = $query1;
$ADODB_COUNTRECS=true;
$rsCheck=$db->query($query);

$ADODB_COUNTRECS=true;

$varjh=1;
if (!$rsCheck and $tpBuscarSel=="ok"){
	
  echo "<center><img src='img_alerta_1.gif' alt='Esta alerta indica que no se encontraron los datos que buscar e Intente buscar con otro nombre, apellido o No. IDD'>";
  echo "<center><font size='3' face='arial' class='etextomenu'><b>No se encontraron datos con las caracteristicas solicitadas</b></font>";
}else {
?>
  <table width='100%' class="borde_tab">

<?php
$cent=0;
$varjh=2;
$radicado_anterior=0;

/**
	*  Busqueda de radicados 
	*/
$num_busq=0;
 while(!$rsCheck->EOF)
 {  $num_busq=$rsCheck->RecordCount();
	$nume_radi = "";
	$nombret_us1= "";
	$nombret_us2= "";
	$nombret_us3= "";
	$dato= "";
	$fecha= "";
	$cuentai= "";
	$asociado= "";
	$asunto= "";
	$cent = 0;

	//$nume_radi = ora_getcolumn($cursor,2);
	$nume_radi = $rsCheck->fields["RADI_NUME_RADI"];
	
	$nurad = $nume_radi;
	$verrad = $nume_radi;
	$verradicado = $nume_radi;
	$nomb = $rsCheck->fields['SGD_CIU_NOMBRE'];
	$prim_apel = $rsCheck->fields['SGD_CIU_APELL1'];
	$segu_apel = $rsCheck->fields['SGD_CIU_APELL2'];
	$nume_deri = $rsCheck->fields['RADI_NUME_DERI'];
	//$imagenf = $rsCheck->fields['RADI_PATH'];
	$hoj=$rsCheck->fields['RADI_NUME_HOJA'];
	$asunto=$rsCheck->fields['RA_ASUN'];
	$fecha=$rsCheck->fields['RADI_FECH_RADI'];
	$derivado=$rsCheck->fields['RADI_NUME_DERI'];
        $tipoderivado=$rsCheck->fields['RADI_TIPO_DERI'];
        $fldRADI_PATH = $rsCheck->fields['RADI_PATH'];
        $depecoid = $rsCheck->fields['DEPE_CODI'];
        $usuacodi = $rsCheck->fields['USUA_CODI'];
        $nivelsegurad = $rsCheck->fields['SGD_SPUB_CODIGO'];
	$dir_tipo=$rsCheck->fields['SGD_DIR_TIPO'];
	$cuentai=$rsCheck->fields['RADI_CUENTAI'];
	$nume_exp=$rsCheck->fields['SGD_EXP_NUMERO'];
         $nivelRadicado = $rsCheck->fields['CODI_NIVEL'];
         $seguridadRadicado = $rsCheck->fields['SGD_SPUB_CODIGO'];
      
	$ruta_raiz = "..";
	$no_tipo = "true";
	//echo "<hr>Buscando Radicadon NO $verrad";
	include "../ver_datosrad.php";
	if($dir_tipo==1) 
	  {
		 $dir_tipo_desc = "Remitente";
		 //$dignatario1 = ora_getcolumn($cursor,20);
		 $dignatario1=$rsCheck->fields['SGD_DIR_NOMBRE'];
		}
	if($dir_tipo==2) 
	  {
		  $dir_tipo_desc = "Predio";
			//$dignatario2 = ora_getcolumn($cursor,20);
			$dignatario2=$rsCheck->fields['SGD_DIR_NOMBRE'];
		}
	if($dir_tipo==3) 
	  {
		  $dir_tipo_desc = "ESP";
			//$dignatario3 = ora_getcolumn($cursor,20);
			$dignatario3=$rsCheck->fields['SGD_DIR_NOMBRE'];
		}
	if (trim($derivado)){
	  switch ($tipoderivado) {
			case 0:
				$asociado = "Anx > $derivado";
				break;
			case 1:
				$asociado = "";
				break;
			case 2:
				$asociado = "Asc > $derivado";
				break;
		}
	}
	if(trim($fldRADI_PATH)==""){
	     $dato="No Disp";
	}else{
              $dato="<a href='../seguridadImagen.php?fec=".base64_encode($fldRADI_PATH)."' target='otraventana'> Ver Imagen</a>";
            
            if (strlen($fldRADI_PATH))
                $linkDoctoImg = "<a class='vinculos' href='../seguridadImagen.php?fec=" . base64_encode($fldRADI_PATH) . "' target='Imagen$iii'>";
                $linkInfGeneralRad = "<a class='vinculos' href='../verradicado.php?verrad=$fldRADI_NUME_RADI&" . session_name() . "=" . session_id() . "&krd=$krd&carpeta=8&nomcarpeta=Busquedas&tipo_carp=0'>";
           
           echo "<!--".$sql."-->";
           $ry=$db->query($sql);
           //$db->debug = true;
             //echo $ry->fields['SGD_SPUP_CODIGO']."buenas tardes sgc";
                
       
         
                if($ry){echo "estoy haciendo pruebas";}
                if ($nivelsegurad == 1) {
                       //echo "es nivel privado";
                    if ( $usuacodi  == $_SESSION['codusuario'] && $depecoid == $_SESSION['dependencia']) {
                        $prueba = $dato;
                    } else {
                        $prueba = "<a class='vinculos' href='javascript:noPermiso(1)'>Ver Imagen</a> ";
                        
                    }
                } 
                
                if ($nivelsegurad == 2) {
                        if ($depecoid == $_SESSION['dependencia']) {
                    $prueba = $dato;
                     } else {
                    $variable_inventada = $_SESSION['dependencia'];
                    $prueba  = "<a class='vinculos' href='javascript:noPermiso(2)' >Ver Imagen</a> ";
                
                        }
                }
                
                if ($nivelsegurad == 3) {
                $sql = "select * from sgd_matriz_nivelrad where radi_nume_radi=$buscar_por_radicado and usua_login='" . $_SESSION['krd'] . "'";
                $rsVerif = $db->conn->Execute($sql);
                if ($rsVerif && !$rsVerif->EOF or ( $usuacodi  == $_SESSION['codusuario'] && $depecoid == $_SESSION['dependencia'])) {
                    $prueba = $dato;
                } else {
                    $prueba = "<a class='vinculos' href='javascript:noPermiso(1)' > Ver Imagen</a>";
                    
                }
            }
            if($nivelsegurad == 0) {
               $prueba = $dato;
                
            }
            
                
                
               
            

            
            
            /*if ($_SESSION['usua_super_perm'] != 0) {//$UsrSecAux->UsrPerm 
                $UsrSecAux = new SecSuperClass($db);
                $UsrSecAux->SecSuperFill($_SESSION['usua_doc']);
                if ($UsrSecAux->SecureCheck($fldRADI_NUME_RADI) == false) {
                    $linkDocto = "<a class='vinculos' href='javascript:noPermiso(2)' > ";
                    $linkInfGeneral = "<a class='vinculos' href='javascript:noPermiso(2)' > ";
                }
            }*/

      
	     }
	    if($radicado_anterior!=$nume_radi)
		  {
			 if($iii==1){
				 $fila = "<tr class='tparr'>";
				 $iii=2;
			 }else{
				$fila = "<tr class='timparr'>";
				$iii=1;
			 }
		  ?>
	<tr class='borde_tab'><?=$fila ?>
		<td class="listado2">
        <table class="borde_tab" width="100%">
          <tr>
            <td width="18%" class="titulos5"><input name='radicadopadre' id="rbtn" type='radio' value='<?=$nume_radi ?>' title='Radicado No <?=$nume_radi ?>' >
      Radicado </td>
            <td width="39%" class=listado5><?=$nume_radi ?>
                <?
			if($nume_exp)
			{
		 	?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Expediente
      <?=$nume_exp ?>
      <?
		 	}
			?>
            </td>
            <td width="12%" class="titulos5">Fecha Rad</td>
            <td width="31%" class="listado5"><?=$fecha ?></td>
          </tr>
  <td class="titulos5" >Remitente</td>
      <td class=listado5 ><?=$nombret_us1." - ".$dignatario1?></td>
      <td class="titulos5"><span class="tituloListado">Cuenta Interna</span> </td>
      <td class="listado5"><?=$cuentai?></td>
  <tr>
    <td class="titulos5" >Predio</td>
    <td class=listado5 ><?=$nombret_us2." - ".$dignatario2 ?></td>
    <td class="titulos5"><span class="tituloListado">Doc Asociado</span> </td>
    <td class="listado5"><?=$asociado?></td>
  </tr>
  <tr>
    <td class="titulos5">Entidad</td>
    <td class=listado5 > <?=$nombret_us3." - ".$dignatario3 ?>
      <?  echo $prueba; ?>
    </td>
    <td class="titulos5">Asunto</td>
    <td class="listado5"><?=$asunto ?></td>
  </tr>
        </table></td>
		</tr>
		<?
}
$cent ++;
$radicado_anterior=$nume_radi;
$rsCheck->MoveNext();
 }
    if ($cent == 0 and $tpBuscarSel=="ok"){
    ?>
          <tr>
            <td align='center' colspan='7' CLASS=titulosError>&nbsp;<font>
			LO SENTIMOS NO HAY REGISTROS</font></td>
          </tr>
          <?
	}
}
}else { 
	if($Submit)
	{
		?>
		<center><table></table><table class="borde_tab" width="100%"><tr><td class="titulosError"><center>Debe digitar un Dato para realizar la busqueda !! </center></td></tr></table></center>
		<? 
		$nobuscar = "No Buscar";
	}
	}
	if(trim($imagenf)=="")
	{
		$dato=" ";
	}
	else
	{
		$dato="<a href='bodega/$imagenf' target='otraventana'></a>";
	}
?> 
</table>
<?php
	$cent ++;
	echo"<input type='hidden' name='usr' value='$usr'>";
	echo"<input type='hidden' name='ent' value='$ent'>";
	echo"<input type='hidden' name='depende' value='$depende'>";
	echo"<input type='hidden' name='contra' value='$contra'>";
	echo"<input type='hidden' name='pnom' value='$pnom'>";
	//echo"<input type='hidden' name='pnom' value='$pnom'>";
	echo"<input type='hidden' name='sapl' value='$sapl'>";
	echo"<input type='hidden' name='papl' value='$papl'>";
	echo"<input type='hidden' name='numdoc' value='$numdoc'>";
	echo"<input type='hidden' name='tip_doc' value='$tip_doc'>";
	echo"<input type='hidden' name='tip_rem' value='$tip_rem'>";
	echo"<input type='hidden' name='codusuario' value='$codusuario'>";
	echo"<input type='hidden' name='pcodi' value='$pcodi'>";
	echo"<input type='hidden' name='hoj' value='$hoj'>";
	//echo"<input type='hidden' name='buscareesp' value='$buscareesp'>";
	//<input name="Radicar" type=submit class='ebuttons2' value="TIENE DOCUMENTO PADRE">
?>
<br>
<br>
</div>
</td>
<div align="center">
<?php echo "";?>
<br>
<?php
	if($Submit and !$nobuscar)
?>
<br>
</div>
<?php
echo "<input type=hidden name=drde value=$drde>";
echo "<input type=hidden name=krd value=$krd>";
echo " ";
?>
</form>
<script >
    function habilitar()
    {
        document.getElementById('rad0').style.display = 'block';
        document.getElementById('tbl_dsp').style.display = '';
        document.getElementById('tbl_btns').style.display = '';
        document.getElementById('rad1').style.display = 'block';
        document.getElementById('rad2').style.display = 'block';
        document.getElementById('tbl_nvo').style.display = 'none';
    }
    <?if($num_busq>0){?>setTimeout("habilitar();", 0);<?}?>
</script>
</body>
</html>
