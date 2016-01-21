<?
/*************************************************************************************/
/* ORFEO GPL:Sistema de Gestion Documental		http://www.orfeogpl.org	     */
/*	Idea Original de la SUPERINTENDENCIA DE SERVICIOS PUBLICOS DOMICILIARIOS     */
/*				COLOMBIA TEL. (57) (1) 6913005  orfeogpl@gmail.com   */
/* ===========================                                                       */
/*                                                                                   */
/* Este programa es software libre. usted puede redistribuirlo y/o modificarlo       */
/* bajo los terminos de la licencia GNU General Public publicada por                 */
/* la "Free Software Foundation"; Licencia version 2. 			             */
/*                                                                                   */
/* Copyright (c) 2005 por :	  	  	                                     */
/* SSPS "Superintendencia de Servicios Publicos Domiciliarios"                       */
/*   Jairo Hernan Losada  jlosada@gmail.com                Desarrollador             */
/*   Sixto Angel Pinz�n L�pez --- angel.pinzon@gmail.com   Desarrollador             */
/* C.R.A.  "COMISION DE REGULACION DE AGUAS Y SANEAMIENTO AMBIENTAL"                 */ 
/*   Liliana Gomez        lgomezv@gmail.com                Desarrolladora            */
/*   Lucia Ojeda          lojedaster@gmail.com             Desarrolladora            */
/* D.N.P. "Departamento Nacional de Planeaci�n"                                      */
/*   Hollman Ladino       hollmanlp@gmail.com                Desarrollador             */
/*                                                                                   */
/* Colocar desde esta lInea las Modificaciones Realizadas Luego de la Version 3.5    */
/*  Nombre Desarrollador   Correo     Fecha   Modificacion                           */
/*************************************************************************************/
?>
<?php
session_start();
error_reporting(7);
$anoActual = date("Y");
if(!$fecha_busq) $fecha_busq=date("Y-m-d");
if(!$fecha_busq2) $fecha_busq2=date("Y-m-d");
$ruta_raiz = "..";
if (!$_SESSION['dependencia'] and !$_SESSION['depe_codi_territorial'])	include "../rec_session.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");	
//$db->conn->debug=true;
if (!defined('ADODB_FETCH_ASSOC'))	define('ADODB_FETCH_ASSOC',2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$sqlMS="select sgd_msa_codigo, sgd_msa_sigla from sgd_msa_medsoparchivo where sgd_msa_estado=1";
$medioSoporte=$db->conn->GetArray($sqlMS);
foreach ($medioSoporte as $i)
    $tdMedioSoporte.="<td>$i[SGD_MSA_SIGLA]</td>";
?>
<head>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<BODY>
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<TABLE width="100%" class='borde_tab' cellspacing="5">
<TR><TD height="30" valign="middle"   class='titulos5' align="center">INFORME TABLAS DE RETENCION DOCUMENTAL</td></tr>
</table>
<table><tr><td></td></tr></table>
<form name="inf_trd"  action='../trd/informe_trd.php?<?=session_name()."=".session_id()."&krd=$krd&fecha_h=$fechah"?>' method=post>
<TABLE width="550" class='borde_tab' align="center">
  <!--DWLayoutTable-->
  <TR>
    <TD height="26" class='titulos5'>Dependencia</TD>
    <TD valign="top">
	<?
	error_reporting(7);
	$ss_RADI_DEPE_ACTUDisplayValue = "--- TODAS LAS DEPENDENCIAS ---";
	$valor = 0;
	include "$ruta_raiz/include/query/devolucion/querydependencia.php";
	$sqlD = "select $sqlConcat ,depe_codi from dependencia where depe_estado=1
							order by depe_codi";
			$rsDep = $db->conn->Execute($sqlD);
	       print $rsDep->GetMenu2("dep_sel","$dep_sel",$blank1stItem = "$valor:$ss_RADI_DEPE_ACTUDisplayValue", false, 0," onChange='submit();' class='select'");	
	?>
  </TR>
  <tr>
    <td height="26" colspan="2" valign="top" class='titulos5'> <center>
		<input type=SUBMIT name=generar_informe value=' Generar Informe' class=botones_mediano>
    </center>
		</td>
	</tr>
</TABLE>

<?php
if($_POST['generar_informe'])
{
  if ($_POST['dep_sel'] == 0)
    {
      /*
      *Seleccionar todas las dependencias
      */
      $where_depe = '';
     }
   else
     {
      
//parametro solo de la SSPD
				if($entidad == "SSPD")
				{
					if($dep_sel=="527" || $dep_sel=="810" || $dep_sel=="820" || $dep_sel=="830" || $dep_sel=="840" || $dep_sel=="850") 
					{
						
						$where_depe = " AND ( ( m.depe_codi = ". $_POST['dep_sel'] ."  AND m.SGD_SRD_CODIGO = 15) OR (m.depe_codi = " . $_POST['dep_sel'] . " AND m.SGD_SRD_CODIGO <> 15))";
					}else {
						$where_depe = " AND m.depe_codi = ". $_POST['dep_sel'] ." AND m.SGD_SRD_CODIGO <> 15 ";
					}
				}else {
					 $where_depe = " and m.depe_codi = ".$_POST['dep_sel'];
				}
     }
    $generar_informe = 'generar_informe';
	error_reporting(7);
	$guion     = "' '";
	include "$ruta_raiz/include/query/trd/queryinforme_trd.php";
	$order_isql = " order by m.depe_codi, m.sgd_srd_codigo,m.sgd_sbrd_codigo,m.sgd_tpr_codigo ";
	$query_t = $query . $where_depe . $order_isql ;
	$ruta_raiz = "..";
	error_reporting(7);
	$rs = $db->query($query_t);
echo "<hr>---<hr>";
?>
<table class='borde_tab'>
<?
$nSRD_ant = "";
$nSBRD_ant = "";
$openTR = "";
?>
<tr class=titulos5>
<td colspan="3" align="center">Codigo</td>
<td align="center" rowspan="2">Series Y Tipos Documentales</td>
<td colspan="2" align="center">Retencion<br> A&#241;os</td>
<td colspan="4" align="center">Disposicion<br> Final</td>
<td colspan="<?=count($medioSoporte)?>" align="center">Soporte</td>
<td rowspan="2" align="center" width=30%>Procedimiento </td>
</tr>
<tr class=titulos5>
<td align="center">D</td><td align="center">S</td><td align="center">Sb</td>
<td align="center">AG</td><TD>AC</TD>
<td>CT</TD><TD>E</TD><TD>M</TD><TD>S</TD>
<?=$tdMedioSoporte?>
</tr>
<?
$tdMedioSoporte='';
$depTDR = $rs->fields['DEPE_CODI'];   //Dependencia
	while(!$rs->EOF and $rs)
	{
			
			$nSRD = strtoupper($rs->fields['SGD_SRD_DESCRIP']);	//Nombre Serie					
			$nSBRD = $rs->fields['SGD_SBRD_DESCRIP'];			//Nombre SubSerie
			$cSRD = $rs->fields['SGD_SRD_CODIGO'];				//Codigo Serie
			$cSBRD = $rs->fields['SGD_SBRD_CODIGO'];			//Codigo Subserie
			$nTDoc = lcfirst_orf($rs->fields['SGD_TPR_DESCRIP']);	//Nombre Tipo Documental
			if($nSRD==$nSRD_ant and $depTDR == $rs->fields['DEPE_CODI'])
			{
				$pSRD=""; 
			}
                        else
                        {

                            $pSRD = "$nSRD";
                            if($openTR=="Si")
                            {
                                    echo "$colFinales";
                            }
                              $depTDR = $rs->fields['DEPE_CODI'];
                              echo "<tr class=listado5><td><font size=2 face='Arial'>$depTDR</font></td>
                              <td>&nbsp;<font size=2 face='Arial'>$cSRD</font></td>
                              <td>&nbsp;</td><td colspan=11><font size=2 face='Arial'>$pSRD</font></td>";
                                    echo "</tr>";
                                    $openTR = "No";
                                    $band=1;
			}
			if($nSBRD==$nSBRD_ant and $band===0)
			{
				 $pSBRD="&nbsp;&nbsp;&nbsp;- <font size=2 face='Arial'>$nTDoc</font><br>"; 
				 echo "<tr class=leidos><td colspan=3></td><td><font size=2 face='Arial'>$pSBRD</font></td><td colspan=10></td></tr>";
			}else
			{
				
				$conservCT="&nbsp;";
				$conservE="&nbsp;";
				$conservI="&nbsp;";
				$conservS="&nbsp;";
				$conserv = strtoupper(substr(trim($rs->fields['DISPOSICION']),0,1));
				$pSBRD = "<a href=#><font size=2 face='Arial'>$nSBRD</font></a><br>&nbsp;&nbsp;&nbsp;- 
				<font size=2 face='Arial'>$nTDoc</font>";
				echo "<tr valign=top class=leidos>
				<td><center><font size=2 face='Arial'>$depTDR</font></center></td>
				<td><center>&nbsp;<font size=2 face='Arial'>$cSRD</font></center></td>
				<td><center><font size=2 face='Arial'>$cSBRD</font></center></td>
				<td><font size=2 face='Arial'>$pSBRD</font><br>";
				$openTR = "Si";
				if($conserv=="C") $conservCT="X";
				if($conserv=="E") $conservE="X";
				if($conserv=="M") $conservI="X";
				if($conserv=="S") $conservS="X";
				$tiemag = $rs->fields['SGD_SBRD_TIEMAG'];
				$tiemac = $rs->fields['SGD_SBRD_TIEMAC'];
				$nObservacion = $rs->fields['SGD_SBRD_PROCEDI'];
				$conservacion = "<td><font size=2 face='Arial'><font size=2 face='Arial'>$conservCT</font></td>
				<td><center><font size=2 face='Arial'>$conservE</font></center></td>
				<td><center><font size=2 face='Arial'>$conservI</font></center></td>
				<td><center><font size=2 face='Arial'>$conservS</font></center></td>";
                                foreach ($medioSoporte as $i){
                                    if($i['SGD_MSA_CODIGO']==$rs->fields['SGD_SBRD_SOPORTE'])$tdMedioSoporte.="<td><center><font size=2 face='Arial'>X</font></center></td>";
                                    else $tdMedioSoporte.="<td><center><font size=2 face='Arial'>&nbsp;</font></center></td>";
                                }
				echo "<td><font size=2 face='Arial'>&nbsp;$tiemag</td>
				<td>&nbsp;<font size=2 face='Arial'>$tiemac</font></td>
				<font size=2 face='Arial'>$conservacion $tdMedioSoporte</font>
				<td>&nbsp;<font size=2 face='Arial'>".$nObservacion."</font>
				</td></tr>";
                                $band=0;
                                $tdMedioSoporte='';
			}
			$nSRD_ant = $nSRD;
			$nSBRD_ant = $nSBRD;
			$rs->MoveNext();
	}
	if($openTR=="Si")
	{
		echo "$colFinales";
	}
?>
</table>
<?
}

function lcfirst_orf($str)
{
    require_once($GLOBALS['ruta_raiz']."/radsalida/masiva/OpenDocText.class.php");
    $odt = new OpenDocText();
   return mb_strtoupper(substr($str, 0, 1),ini_get("default_charset")) . mb_strtolower(substr($str, 1),ini_get("default_charset"));
}
?>
<hr>
---
<hr>
</form>
<HR>
