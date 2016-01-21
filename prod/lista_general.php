<?php
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
/*   Sixto Angel Pinzón López --- angel.pinzon@gmail.com   Desarrollador             */
/* C.R.A.  "COMISION DE REGULACION DE AGUAS Y SANEAMIENTO AMBIENTAL"                 */ 
/*   Liliana Gomez        lgomezv@gmail.com                Desarrolladora            */
/*   Lucia Ojeda          lojedaster@gmail.com             Desarrolladora            */
/* D.N.P. "Departamento Nacional de Planeación"                                      */
/*   Hollman Ladino       hollmanlp@gmail.com                Desarrollador          */
/*                                                                                   */
/* Colocar desde esta lInea las Modificaciones Realizadas Luego de la Version 3.5    */
/*  Nombre Desarrollador   Correo     Fecha   Modificacion                           */
/*************************************************************************************/
include_once "class_control/AplIntegrada.php";
$objApl = new AplIntegrada($db);
$lkGenerico = "&usuario=$krd&nsesion=".trim(session_id())."&nro=$verradicado"."$datos_envio";
$ADODB_COUNTRECS = true;
?>
<script src="js/popcalendar.js"></script>
<script>
function regresar()
{	//window.history.go(0);
	window.location.reload();
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="borde_tab">
<tr class="titulosenca2"> 
    <td class="titulosenca2" colspan="6" >INFORMACI&Oacute;N GENERAL </td>
</tr>
</table>
<table border=0 cellspace=2 cellpad=2 WIDTH=100% align="left" class="borde_tab" id=tb_general>
<tr> 
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2" >FECHA DE RADICADO</td>
    <td  width="25%" height="25" class="listado2"><?=substr($radi_fech_radi , 0, 19)?></td>
    <td bgcolor="#CCCCCC" width="25%" align="right" height="25" class="titulos2" >ASUNTO</td>
    <td class='listado2' colspan="3" width="25%" size="3000"><?=$ra_asun?></td>
</tr>
<tr> 
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2"><?=$tip3Nombre[1][$ent]?></td>
	<td class='listado2' width="25%" height="25"><?=$nombret_us1 ?></td>
	<td bgcolor="#CCCCCC" width="25%" align="right" height="25" class="titulos2" >DIRECCI&Oacute;N CORRESPONDENCIA</td>
	<td class='listado2' width="25%"><?=$direccion_us1 ?></td>
	<td bgcolor="#CCCCCC" width="25%" align="right" height="25" class="titulos2" >MUN/DPTO</td>
	<td class='listado2' width="25%"><?=$dpto_nombre_us1."/".$muni_nombre_us1 ?></td>
</tr>
<tr> 
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2"><?=$tip3Nombre[2][$ent]?></td>
	<td class='listado2' width="25%" height="25"> <?=$nombret_us2 ?></td>
    <td bgcolor="#CCCCCC" width="25%" align="right" height="25" class="titulos2">DIRECCI&Oacute;N CORRESPONDENCIA </td>
    <td class='listado2' width="25%"> <?=$direccion_us2 ?></td>
    <td bgcolor="#CCCCCC" width="25%" align="right" height="25" class="titulos2">MUN/DPTO</td>
    <td class='listado2' width="25%"> <?=$dpto_nombre_us2."/".$muni_nombre_us2 ?></td>
</tr>
<tr>
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2"><?=$tip3Nombre[3][$ent]?></td>
	<td class='listado2' width="25%" height="25"> <?=$nombret_us3 ?></td>
    <td bgcolor="#CCCCCC" width="25%" align="right" height="25" class="titulos2">DIRECCI&Oacute;N CORRESPONDENCIA </td>
    <td class='listado2' width="25%"> <?=$direccion_us3 ?></td>
    <td bgcolor="#CCCCCC" width="25%" align="right" height="25" class="titulos2">MUN/DPTO</td>
    <td class='listado2' width="25%"> <?=$dpto_nombre_us3."/".$muni_nombre_us3 ?></td>
</tr>
<tr>
	<td height="25" bgcolor="#CCCCCC" align="right" class="titulos2"> <p>N&ordm; DE P&Aacute;GINAS</p></td>
    <td class='listado2' width="25%" height="25"> <?=$radi_nume_hoja ?></td>
    <td bgcolor="#CCCCCC" width="25%" height="25" align="right" class="titulos2"> DESCRIPCI&Oacute;N ANEXOS </td>
    <td class='listado2'  width="25%" height="11"> <?=$radi_desc_anex ?></td>
    <td bgcolor="#CCCCCC" width="25%" align="right" height="25" class="titulos2">&nbsp;</td>
    <td class='listado2' width="25%">&nbsp;</td>
</tr>
<tr> 
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">DOCUMENTO<br>Anexo/Asociado</td>
	<td class='listado2' width="25%" height="25">
	<?	if($radi_tipo_deri!=1 and $radi_nume_deri)
		{	echo $radi_nume_deri;
			echo "<br>(<a class='vinculos' href='$ruta_raiz/verradicado.php?verrad=$radi_nume_deri &session_name()=session_id()&krd=$krd' target='VERRAD$radi_nume_deri_".date("Ymdhi")."'>Ver Datos</a>)";
		}
		if($verradPermisos == "Full" or $datoVer=="985")
		{
	?>
		<input type=button name=mostrar_anexo value='...' class=botones_2 onClick="verVinculoDocto();">
	<?
		}
	?>
	</td>
    <td bgcolor="#CCCCCC" width="25%" align="right" height="25" class="titulos2">REF/OFICIO/CUENTA INTERNA </td>
    <td class='listado2' colspan="3" width="25%"> <?=$cuentai ?>&#160;&#160;&#160;&#160;&#160;
    <?
		$muniCodiFac = "";
		$dptoCodiFac = "";
		if($sector_grb==6 and $cuentai and $espcodi)
		{	if($muni_us2 and $codep_us2)
			{	$muniCodiFac = $muni_us2;
				$dptoCodiFac = $codep_us2;
			}
			else
			{	if($muni_us1 and $codep_us1)
				{	$muniCodiFac = $muni_us1;
					$dptoCodiFac = $codep_us1;
				}
			}
	?>
		<a href="./consultaSUI/facturacionSUI.php?cuentai=<?=$cuentai?>&muniCodi=<?=$muniCodiFac?>&deptoCodi=<?=$dptoCodiFac?>&espCodi=<?=$espcodi?>" target="FacSUI<?=$cuentai?>"><span class="vinculos">Ver Facturaci&oacute;n</span></a>
	<?
		}
	?>
    </td>
  </tr>
  <tr> 
	<td align="right" height="25" class="titulos2">IMAGEN</td>
	<td class='listado2' colspan="1"><span class='vinculos'><?=$imagenv ?></span></td>
	<!--<td align="right" height="25"  class="titulos2">ESTADO ACTUAL</td>
	<td class='listado2' >
		<?=$flujo_nombre?>
		<? 
			if($verradPermisos == "Full" or $datoVer=="985")
	  		{
	  	?>
			<input type=button name=mostrar_causal value='...' class=botones_2 onClick="ver_flujo();">
		<?
			}
		?>
	</td>-->
	<td align="right" height="25"  class="titulos2">NIVEL DE SEGURIDAD</td>
	<td class='listado2' colspan="3">
	<?
		if($nivelRad==0)
		{	
			echo "P&uacute;blico";	
		}
		if($nivelRad==1)
		{	
			echo "Privado";	
		}
		if($nivelRad==2)
		{	
			echo "Dependencia";	
		}
		if($nivelRad==3)
		{	
			echo "Usuario Especifico";	
		}
		if($verradPermisos == "Full" or $datoVer=="985")
	  	{	$varEnvio = "krd=$krd&numRad=$verrad&nivelRad=$nivelRad";
	?>
		<input type=button name=mostrar_causal value='...' class=botones_2 onClick="window.open('<?=$ruta_raiz?>/seguridad/radicado.php?<?=$varEnvio?>','Cambio Nivel de Seguridad Radicado', 'height=350, width=700,scrollbars=yes,resizable=yes')">
	<?
		}
	?>
	</td>
</tr>
<tr> 
	<td align="right" height="25" class="titulos2">TRD</td>
	<td class='listado2' colspan="6">
	<?
		if(!$codserie) $codserie = "0";
		if(!$tsub) $tsub = "0";
		if(trim($val_tpdoc_grbTRD)=="///") $val_tpdoc_grbTRD = "";
	?>
		<?=$serie_nombre ?><font color=black>/</font><?=$subserie_nombre ?><font color=black>/</font><?=$tpdoc_nombreTRD ?>
	<?
		if($verradPermisos == "Full" or $datoVer=="985") {
	?>
                    <input type=button name=mosrtar_tipo_doc2 value='...' class=botones_2 onClick="ver_tipodocuTRD(<?=$codserie?>,<?=$tsub?>);">
	<?
                }
                
	?>
                
	</td>
</tr>
<!--<tr> 
	<td align="right" height="25" class="titulos2">RELACION PROCEDIMENTAL</td>
	<td class='listado2' colspan="6"> 
	<?
		if(Trim($val_tpdoc_grb)=="///") $val_tpdoc_grb = "";
	?>
      <?=$tpdoc_nombre ?>
      <font color=black>/ </font><?=$funcion_nombre ?><font color=black>/ </font>
      <?=$proceso_nombre ?><font color=black>/ </font> <?=$procedimiento_nombre ?>
      <?
	  if($verradPermisos == "Full" or $datoVer=="985")
	  {
	  ?>
		<input type=button name=mosrtar_tipo_doc2 value='...' class=botones_2 onClick="ver_tipodocumento();">      
      <?
	  }
	  ?>
	</td>
</tr>-->
        
       <!--  Visualizacion de los Metadatos 
             Funcionalidad nueva para OPAIN S.A.
             Realizador: Grupo Iyunxi Ltda.
        ---------------------------------------------------------------------------------------------------------------------->
        <tr>
            <td align="right" height="25" class="titulos2">METADATO</td>
            <td class='listado2' colspan="6">
                <? 
                $sqlMetadato = "select sgd_mmr_dato from sgd_mmr_matrimetaradi where radi_nume_radi = $verradicado ";
                $rsMetadato = $db->conn->Execute($sqlMetadato);
                while(!$rsMetadato->EOF)
                {                   
                    $metadato = $rsMetadato->fields["SGD_MMR_DATO"];
                    echo $metadato. " / ";
                    $rsMetadato->MoveNext();
                }
                ?>
            </td>
        </tr>
        <!-- ----------------------------------------------------------------------------------------------------------------->
<!--<tr> 
	<td align="right" height="25" class="titulos2">NOTIFICACI&Oacute;N</td>
	<td class='listado2' colspan="6"> 
      <?
       if ($sgd_apli_codi==1){
       		$objApl->AplIntegrada_codigo($sgd_apli_codi);
        	$lksancionados = $objApl->get_sgd_apli_lk1();
       		$lkagotamiento = $objApl->get_sgd_apli_lk2();
       		$lksancion = $objApl->get_sgd_apli_lk3();
       		$lkfirmesa = $objApl->get_sgd_apli_lk4();
       		
       }
       	
	  if ($tipoNotDesc){
	  	echo("$tipoNotDesc "); if ($tFechNot) echo ("Notificacion($tFechNot)/"); if ($tFechFija) echo ("Fijacion($tFechFija)/"); if ($tFechDesFija) echo ("Desfij($tFechDesFija)"); echo("/  Notificador($tNotNotifica)/  Notificado($tNotNotificado)/  "); if ($tNotEdicto) echo ("Edicto ($tNotEdicto)"); }
	  if(($verradPermisos == "Full"  or $datoVer=="985") &&  $usua_perm_notifica==1 )
	  {
	  ?>
      <input type=button name=mostrarNotificacion value='...' class=botones_2 onClick="verNotificacion();">
      <?
       //Mira si la decision actual permite ver agotamiento
       if (!$sgd_tdes_codigo)
       		$sgd_tdes_codigo = 'null';
       $sql =  "select * from SGD_TDEC_TIPODECISION where SGD_APLI_CODI=1 and SGD_TDEC_VERAGOTA=1
       			and SGD_TDEC_CODIGO = $sgd_tdes_codigo ";
       $rs=$db->query($sql); 
       
       if (strlen (trim($tipoNotDesc)) > 0) {
       	$swDecAgotam = false;
       
       	if ($rs && !$rs->EOF)
       		$swDecAgotam = true;
       
       		//Mira si ya se ha tipificado agotamiento
       	$swYaAgotam = false; 
       	
       	$sql = "select a.hist_obse 
					from hist_eventos a
				 	where 
					a.radi_nume_radi =$verradicado and
					a.hist_obse  like  '%SE HA AGOTADO LA VIA GUBERNATIVA%' and
					a.sgd_ttr_codigo = 35
					order by hist_fech desc ";  
	 	$rs=$db->query($sql); 	
	 	
	 	if ( $rs && !$rs->EOF ) 
	 			$swYaAgotam = true;
       	
	       	 
       
       	if ( $swDecAgotam==true &&  $swYaAgotam==false  ) { 
       	$datos_enviobk = $etiqueta_body = str_replace("&", "|", $datos_envio); 
       	
       	$lkagotamiento = $lkagotamiento.$lkGenerico;
       
       	$lkagotamiento = str_replace("/", "|", $lkagotamiento);
       	$lkgen=str_replace("&", "|", $lkGenerico);
       	?>
      	<a class='vinculos' href='javascript:abrirAgotamiento()'>Agotamiento Via 
      	Gubernativa</a> 
      	<script>
         function abrirAgotamiento (){
       		window.open('abre_en_frame.php?lkparam=<?=$lkagotamiento?>&datoenvio=<?=$lkgen?>',"Agotamiento",'top=0,height=580,width=850,scrollbars=yes');
       	  }
       
       	</script>
      <? }
	  }
       if ($tipoNotDesc && $sgd_tdec_firmeza && $tipoNotific){
	  	   	$lkfirmesa = $lkfirmesa .$lkGenerico;
    	?>
      <?
	// Si se ha notificado y se ha tipificado decisi�n como   Agotamiento de via gubernativa
		
				 	
	 			if ( $swYaAgotam == true ) {
					$sql =  "select * from SGD_TDEC_TIPODECISION where SGD_APLI_CODI=1  and SGD_TDEC_FIRMEZA=1 
					 	and SGD_TDEC_CODIGO = $sgd_tdes_codigo ";
	  				$rs=$db->query($sql);
	 				$lkfirmesa = str_replace("/", "|", $lkfirmesa);
	 					$lkgen=str_replace("&", "|", $lkGenerico);
	  				if  ($rs && !$rs->EOF && $usua_perm_sancionad>=3 ){
	 					print ("  <script> ");
	 					print ("  function abrirFirmeza(){ ");
	 					//print (" 	window.open('$lkfirmesa"."$lkGenerico','Firmeza','top=0,height=580,width=850,scrollbars=yes'); ");
	 					print ("    window.open('abre_en_frame.php?lkparam=$lkfirmesa&datoenvio=$lkgen','Agotamiento','top=0,height=580,width=850,scrollbars=yes'); ");
	 					print ("  }  </script> ");
	 					print (" <a class='vinculos' href='javascript:abrirFirmeza()'>Registrar Firmeza</a> ");
		  			}	
	 			}
	  	   	
		}
	  }
	  ?>
    </td>
  </tr>-->
  <?
  //Si el radicado est� relacionado con el aplicativo de sancionados 
  if ($sgd_apli_codi==1){ ?>
  <tr> 
    <td align="right" height="25" class="titulos2">SANCIONADOS</td>
    <td class='listado2' colspan="6"> 
      <?
	  if ($sgd_tdes_descrip)
	  	echo("$sgd_tdes_descrip"); 
	  if(($verradPermisos == "Full"  or $datoVer=="985"  ) && $usua_perm_sancionad>=1)
	  {
	  ?>
      <input type=button name=mostrarSubtipo value='...' class=botones_2 onClick="verDecision();">
      <?
	  }
	 
	  if ( $sgd_tdec_versancion ) {
	  ?>
      <a class='vinculos' href='javascript:abrirSancion()'><span class=tpar> 
      <script>
       function abrirSancion(){
       
      //alert ("Se selecciona " +  document.form_decision.decis.value);
	
	swVerSancion=1;
	
	if (swVerSancion==1)
		
		window.open('<?=$lksancion.$lkGenerico?>',"Sancion",'top=0,height=580,width=850,scrollbars=yes');
       	
       }
       </script>
      </span></a> <a class='vinculos' href="javascript:abrirSancion();">Ver Sancion</a>
      <?
	  }
	  ?>
    </td>
  </tr>
    
  <tr> 
   <? }?>
    <td align="right" height="25" class="titulos2">RESOLUCI&Oacute;N</td>
    <td class='listado2' colspan="6"> 
      <?
        if ($sgd_tres_codigo)
        {   include "include/class/resoluciones.class.php";
            $objRes = new Resoluciones($db->conn);
            $sgd_tres_descrip = $objRes->Get_Descripcion($sgd_tres_codigo);
            echo("$sgd_tres_descrip");
        }
	  if($verradPermisos == "Full"  or $datoVer=="985")
	  {
	  ?>
      <input type=button name=mostrarSubtipo value='...' class='botones_2' onClick="verResolucion();">
      <?
	  }
	  ?>
    </td>
  </tr>
  <tr> 
    <td align="right" height="25" class="titulos2">SECTOR</td>
    <td class='listado2' colspan="6"> 
      <?=$sector_nombre?>
      <? 
		$nombreSession = session_name();
		$idSession = session_id();
		if ($verradPermisos == "Full"  or $datoVer=="985") {
	  		$sector_grb = (isset($sector_grb)) ? $sector_grb : 0;
	  		$causal_grb = (isset($causal_grb) ||$causal_grb !='') ? $causal_grb : 0;
	  		$deta_causal_grb = (isset($deta_causal_grb) || $deta_causal_grb!='') ? $deta_causal_grb : 0;
	  		
			$datosEnviar = "'$ruta_raiz/causales/mod_causal.php?" . 
											$nombreSession . "=" . $idSession .
											"&krd=" . $krd . 
											"&verrad=" . $verrad . 
											"&sector=" . $sector_grb . 
											"&sectorCodigoAnt=" . $sector_grb . 
											"&sectorNombreAnt=" . $sector_nombre . 
											"&causal_grb=" . $causal_grb . 
											"&causal_nombre=" . $causal_nombre . 
											"&deta_causal_grb=" . $deta_causal_grb . 
											"&dcausal_nombre=". $dcausal_nombre . "'";
	  ?>
      <input type=button name="mostrar_causal" value="..." class="botones_2" onClick="window.open(<?=$datosEnviar?>,'Tipificacion_Documento','height=300,width=750,scrollbars=no')">
      <input type="hidden" name="mostrarCausal" value="N">
      <?
	   }
	   ?>
    </td>
  </tr>
  <tr> 
    <td align="right" height="25" class="titulos2">CAUSAL</td>
    <?
	$causal_nombre_grb = $causal_nombre;
	$dcausal_nombre_grb = $dcausal_nombre;
	?>
    <td class='listado2' colspan="6"> 
      <?=$causal_nombre ?>
      / 
      <?=$dcausal_nombre ?>
      / 
      <?=$ddcausal_nombre ?>
      / 
      <? 
	  if ($verradPermisos == "Full"  or $datoVer=="985" ) {
	  ?>
      	<input type=button name="mostrar_causal" value="..." class='botones_2' onClick="window.open(<?=$datosEnviar?>,'Tipificacion_Documento','height=300,width=750,scrollbars=no')">
      <?
	  } 
	  ?>
    </td>
  </tr>
  <tr> 
    <td align="right" height="25" class="titulos2">TEMA</td>
    <td class='listado2' colspan="6"> 
      <?=$sector_nombre?>
      <?php 
		$nombreSession = session_name();
		$idSession = session_id();
		if ($verradPermisos == "Full"  or $datoVer=="985") {
	  		$sector_grb = (isset($sector_grb)) ? $sector_grb : 1;
	  		$causal_grb = (isset($causal_grb) ||$causal_grb !='') ? $causal_grb : 0;
	  		$deta_causal_grb = (isset($deta_causal_grb) || $deta_causal_grb!='') ? $deta_causal_grb : 0;
	  		
			$datosEnviar = "'$ruta_raiz/causales/mod_causal.php?" . 						$nombreSession . "=" . $idSession .
					"&krd=" . $krd . 
					"&verrad=" . $verrad . 
					"&sector=" . $sector_grb . 
					"&sectorCodigoAnt=" . $sector_grb . 
					"&sectorNombreAnt=" . $sector_nombre . 
					"&causal_grb=" . $causal_grb . 
					"&causal_nombre=" . $causal_nombre . 
					"&deta_causal_grb=" . $deta_causal_grb .
					"&ddca_causal_grb=" . $ddca_causal .  
					"&ddca_causal_nombre=". $ddca_causal_nombre . "'";
	  ?>
      <input type=button name="mostrar_causal" value="..." class="botones_2" onClick="window.open(<?=$datosEnviar?>,'Tipificacion_Documento','height=300,width=750,scrollbars=no')">
      <input type="hidden" name="mostrarCausal" value="N">
      <?php
	   }
	   ?>
    </td>
  </tr>
</table>
</form>
<table align="center" border=0 id=ver_datos witdth=80% >
<tr><td>
<?php
 $ruta_raiz = ".";
 error_reporting(7);
 if(($verradPermisos=="Full" or $datoVer=="985")&&$SecSuperAux->UsrPerm==0) {
 	include ("tipo_documento.php");
 }
?>
</td></tr>
<tr>
    <td align='center'>
<?php
 // <input type=button name=mod_tipo_doc3 value='Ver datos' class=botones_2 onClick="ver_datos();">
?>
</td></tr>

</table>
