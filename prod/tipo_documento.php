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
/*   Sixto Angel Pinzón López --- angel.pinzon@gmail.com   Desarrollador             */
/* C.R.A.  "COMISION DE REGULACION DE AGUAS Y SANEAMIENTO AMBIENTAL"                 */ 
/*   Liliana Gomez        lgomezv@gmail.com                Desarrolladora            */
/*   Lucia Ojeda          lojedaster@gmail.com             Desarrolladora            */
/* D.N.P. "Departamento Nacional de Planeación"                                      */
/*   Hollman Ladino       hladino@gmail.com                Desarrollador             */
/*                                                                                   */
/* Colocar desde esta lInea las Modificaciones Realizadas Luego de la Version 3.5    */
/*  Nombre Desarrollador   Correo     Fecha   Modificacion                           */
/*************************************************************************************/
?>
<table border=0 id="mod_sector" align="center" cellpadding="0" cellspacing="5" class="borde_tab">
<?PHP
  error_reporting(7);
?>
</table>
 <table border=0 id="mod_causales" cellpadding="0" cellspacing="5" class="borde_tab" >
<?PHP
  error_reporting(7);
?>
</table>
<table border=0 id="mod_temas" align="center" cellpadding="0" cellspacing="5" class="borde_tab">
  <TR><TD align="center"  class="titulos2" >MODIFICAR TEMA</TD></TR>
 <tr><td>
<?PHP
  include "temas/mod_tema.php";
?>
</td></tr>
</table>
<table border=0 id="mod_flujo" align="center">
<TR><TD class='titulos2'>MODIFICAR ESTADO </TD></TR>
 <tr><td>
<?PHP
  error_reporting(7);
  include "./flujo/mod_flujo.php";
?>
</td></tr>
</table>

<table width="100%" bgcolor="#FFFFFF" id="mod_tipodocumento">
<form name="form_tipo_doc" method="post" action='verradicado.php?<?=session_name()?>=<?=trim(session_id())?>&krd=<?=$krd?>&verrad=<?=$verrad?>&<?="&mostrar_opc_envio=$mostrar_opc_envio&carpeta=$carpeta&nomcarpeta=$nomcarpeta&datoVer=$datoVer&leido=$leido"?>'>
  <input type=hidden name=ver_tipodoc value="Si ver tipo de Documento">
  <?php
	if($tpdoc_rad) $tpdoc = $tpdoc_rad;
	if($tpdoc_new) $tpdoc = $tpdoc_new;
	if($cod_tmp_new) $cod_tmp= $cod_tmp_new;

	$fechah=date("dmy") . " ". time("h_m_s");
	$fecha_hoy = Date("Y-m-d");
	$sqlFechaHoy=$db->conn->DBDate($fecha_hoy);
	
	$check=1;
	$fechaf=date("dmy") . "_" . time("hms");
    $numeroa=0;$numero=0;$numeros=0;$numerot=0;$numerop=0;$numeroh=0;
	/*
	*Se modifica para que tome el tipo de docuento TRD de la dependencia 
	*/
	 $isql = "select t.SGD_TPR_CODIGO , t.SGD_TPR_DESCRIP
		from sgd_rdf_retdocf mf, 
		sgd_mrd_matrird m, 
		sgd_tpr_tpdcumento t
		where mf.sgd_mrd_codigo=m.sgd_mrd_codigo 
		and mf.depe_codi='$dependencia' 
		and mf.RADI_NUME_RADI = '$verradicado' 
		and t.sgd_tpr_codigo = m.sgd_tpr_codigo 
		";
	  	$rs=$db->query($isql);
	if  (!$rs->EOF)
		$tpdoDepe    = $rs->fields["SGD_TPR_CODIGO"];
	
	?>
  <tr>
      <td  ALIGN='RIGHT'  width="27%" class="titulos2">
			TIPO DE DOCUMENTO</td>
      <td colspan="3" width="73%" class="celdaGris">
	
        <select name="tpdoc_new" onChange=submit();>
          <?
	/*
	*Se modifica para que tome el tipo de docuento TRD de la dependencia
	*/
	$tpdoc = $tpdoDepe;
    //$campos = $rs->RecordCount();
	if (!$rs->EOF && $rs)
	{
	
	if($tpdoc_new) $cod_tipo = $tpdoc_new; else $cod_tipo = $tpdoc;
	if(!$cod_tipo) $cod_tipo=tdoc;
	$prim_cod = $tpr_cod = $rs->fields["SGD_TPR_CODIGO"];
	do{
	    $tpr_cod = $rs->fields["SGD_TPR_CODIGO"];
	    $tpr_nombre = $rs->fields["SGD_TPR_DESCRIP"];		
		if($cod_tipo == $tpr_cod)
		 {
		   $datos = "  SELECTED ";
		   $mat_codigo =  $rs->fields["SGD_MAT_CODIGO"];		
		 }else{$datos = "  ";}
	   ?>
          <option value='<?=$tpr_cod ?>' '<?=$datos ?>'>
          <?=$tpr_nombre ?>
          </option>
          <?
	$rs->MoveNext();
	}while(!$rs->EOF);
    if($prim_cod!=$tpdoc_new)
    {
      $tpdoc_new = $prim_cod;
    }

	}
 ?>
        </select>   
        <input type=submit name=grabar_tipo value='Grabar Cambio' class='botones'>
   <?
    if($grabar_tipo and $cod_tmp_new > 0)
	{//print ("grabando tipoooooooooooooooooooooo");
	//$db->conn->debug=true;
		
	$fechaTx = $db->conn->OffsetDate(0,$db->conn->sysTimeStamp);
	$recordSet["TDOC_CODI"] = $tpdoc;		
	$recordSet["SGD_MTD_CODIGO"] = $cod_tmp;			
	$recordWhere["RADI_NUME_RADI"] = $verrad;					
	$db->update("RADICADO", $recordSet,$recordWhere);
	array_splice($recordSet, 0);	   
	array_splice($recordWhere, 0);	
	$flag==0;
  	if ($flag==1) 
	echo "No se grabo ....";
	$isql = "select a.SGD_HMTD_CODIGO from  SGD_HMTD_HISMATDOC a
						where rownum < 10 
		         order by a.SGD_HMTD_CODIGO desc";	
	$rs=$db->query($isql);
	$cod_hmtd = $rs->fields["SGD_HMTD_CODIGO"];			
	$cod_hmtd++;
	
	$recordSet["SGD_HMTD_CODIGO"] = $cod_hmtd;
	$recordSet["SGD_HMTD_FECHA"] = $db->conn->OffsetDate(0,$db->conn->sysTimeStamp);
	$recordSet["RADI_NUME_RADI"] = $verrad ;
	$recordSet["USUA_CODI"] = $codusuario;
	$recordSet["SGD_HMTD_OBSE"] = "'Cambio Tipo'";
	$recordSet["USUA_DOC"] = $usua_doc;		
	$recordSet["DEPE_CODI"] = $dependencia;		
	$recordSet["SGD_MTD_CODIGO"] = $cod_tmp;
	
	$db->insert("SGD_HMtD_HISMATDOC", $recordSet);

	array_splice($recordSet, 0);
	
	$observa = "*Cambio Tipo Documento* ($val_tpdoc_grbTRD)";
    $codusdp = str_pad($dependencia, 3, "0", STR_PAD_LEFT).str_pad($codusuario, 3, "0", STR_PAD_LEFT);
	
	$recordSet["DEPE_CODI"] = $dependencia;
	$recordSet["HIST_FECH"] = $fechaTx;
	$recordSet["USUA_CODI"] = $codusuario;
	$recordSet["RADI_NUME_RADI"] = "$verrad";
	$recordSet["HIST_OBSE"] = "'".$observa."'";
	$recordSet["USUA_CODI_DEST"] = "$codusdp";		
	$recordSet["USUA_DOC"] = "$usua_doc";
	$recordSet["SGD_TTR_CODIGO"] = "19";
	$db->insert("hist_eventos", $recordSet);		 
	$radicados[] = $verrad;
	   }
   
   ?>
</td> 
  </tr>
	<? 
    if($tpdoc)
	{
	$isql = "select distinct a.* from SGD_FUN_FUNCIONES a, sgd_mat_matriz b,SGD_MTD_MATRIZ_DOC c
             where b.sgd_mat_codigo=c.sgd_mat_codigo and c.sgd_tpr_codigo=$tpdoc and
			   a.sgd_fun_codigo=b.sgd_fun_codigo and b.depe_codi=$dependencia  ";
	$rs=$db->query($isql);			   
	?>
	<tr>
      <td ALIGN='RIGHT' width="27%" class="titulos2" >FUNCIONES</td>
      <td class="celdaGris"  colspan="3" width="73%" > 
        <select name="funciones"  onChange=submit();>
    <?
    $prim_cod = $rs->fields["SGD_FUN_CODIGO"] ;
	do
		{
	    $tpr_cod = $rs->fields["SGD_FUN_CODIGO"] ;
	    $tpr_nombre = substr($rs->fields["SGD_FUN_DESCRIP"],0,100);
		if($funciones == $tpr_cod)
			{
		  	$datos = "  SELECTED ";
		  	$prim_cod  = $rs->fields["SGD_FUN_CODIGO"];
			}
		else 
			{
		  	$datos = "  ";
			}		
	   ?>
    <option value='<?=$tpr_cod ?>'  <?=$datos ?>> 
    <?=$tpr_nombre ?>
    </option>
    <?
		$rs->MoveNext();
		}while(!$rs->EOF);
}
    if($prim_cod!=$funciones)
    {
      $funciones = $prim_cod;
    }

	?>
    
  </select>
  </td></tr>
  <tr>
      <td class="titulos2" ALIGN='RIGHT' width="27%">PROCESOS</td>
      <td class="celdaGris"  colspan="3" width="73%"> 
	<?
	  $isql = "select distinct a.* from sgd_prc_proceso a, sgd_mat_matriz b 
	            where a.sgd_prc_codigo=b.sgd_prc_codigo and b.depe_codi=$dependencia and 
	            b.sgd_fun_codigo=$funciones ";
	?> 
   <select name="procesos"  onChange=submit();>
   <?php
   	$rs=$db->query($isql);
	$prim_cod = $rs->fields["SGD_PRC_CODIGO"];
	//$campos = $rs->RecordCount();
	if ((!$rs->EOF && $rs))
	{
	do{
	    $tpr_cod = $rs->fields["SGD_PRC_CODIGO"];
	    $tpr_nombre = $rs->fields["SGD_PRC_DESCRIP"];		
		if($procesos == $tpr_cod)
		 {
		   $datos = "  SELECTED ";
		   $prim_cod = $rs->fields["SGD_PRC_CODIGO"];
		 }
		  else
		 {
		   $datos = "  ";
		 }
	   ?>
      <option value='<?=$tpr_cod ?>'  <?=$datos ?>> 
      <?=$tpr_nombre ?>
      </option>
      <?php
	$rs->MoveNext();
	}while(!$rs->EOF);
	}
	 if($prim_cod!=$procesos)
    {
      $procesos = $prim_cod;
    }
	// #   **************************************** 	
	// #  SELECCION DE PROCEDIMIENTOS
	// #   ****************************************

	?>
      </select>
      </td></tr><tr>
      <td  ALIGN='RIGHT' width="27%" class="titulos2"> PROCEDIMIENTOS</td>
      <td class="celdaGris"  colspan="3" width="73%"> <?php
  	$isql = "select distinct a.* from sgd_prd_prcdmentos a, sgd_mat_matriz b ";
	$isql .= " where a.sgd_prd_codigo=b.sgd_prd_codigo and b.depe_codi=$dependencia and ";
	$isql .= "  b.sgd_fun_codigo=$funciones and b.sgd_prc_codigo=$procesos "; 
	$rs=$db->query($isql);
	if($procedimientos_new)   
		$procedimientos = $procedimientos_new;
 ?> 
        <select name="procedimientos_new"  onChange=submit(); onDblClick=submit();>
	  	
   <?php
    $prim_cod = $rs->fields["SGD_PRD_CODIGO"];
	//$campos = $rs->RecordCount();
	if ((!$rs->EOF && $rs))
	{	
	do{
	    $tpr_cod = $rs->fields["SGD_PRD_CODIGO"];
	    $tpr_nombre = substr($rs->fields["SGD_PRD_DESCRIP"],0,100);
		if($procedimientos == $tpr_cod)
		{
		  $datos = "  SELECTED ";
	      $prim_cod = $rs->fields["SGD_PRD_CODIGO"];
		}
		 else
		{
		  $datos = "  ";
	    }		
		
	   ?>
      <option value='<?=$tpr_cod ?>'  <?=$datos ?>> 
      <?=$tpr_nombre ?>
      </option>
      <?php
	$rs->MoveNext();
	}while(!$rs->EOF);
	}
 if($prim_cod!=$procedimientos)
 {
   $procedimientos = $prim_cod;
 }
 ?>
    </select>
	</td></tr>
	<tr>
      <td width="27%" colspan="2"  class='listado2'> 
        <input type="hidden" name="PHPSESSID" value="<?=session_id() ?>" />
	<input type="hidden" name="grabar" value="si">
	<center>
	<?php
 /**  Encuentra el nuevo codigo de la combinacion */
  		$isql = "select  c.SGD_MTD_CODIGO from sgd_mat_matriz b,SGD_MTD_MATRIZ_DOC c
             where b.sgd_mat_codigo=c.sgd_mat_codigo and c.sgd_tpr_codigo=$tpdoc and
			   b.depe_codi=$dependencia 
			   and b.SGD_FUN_CODIGO=$funciones
			   and b.SGD_PRC_CODIGO=$procesos 
			   and b.SGD_PRD_CODIGO=$procedimientos";
	$rs=$db->query($isql);			   
    $cod_tmp_new = $rs->fields["SGD_MTD_CODIGO"];
   /* cod_tmp es el codigo de la combinacion a grabar. */	
	echo "Codigo Combinaci?n $cod_tmp_new";
	?>
	  <input type=hidden name=cod_tmp_new value='<?=$cod_tmp_new ?>'>
	 </center>
</td></tr>
</form>
</table>
<table border=0 id=mod_notificacion cellpadding="0" cellspacing="5" class="borde_tab">
  <tr> 
    <td align="center"  class='titulos2'> 
      <p>MODIFICAR DATOS DE NOTIFICACION </p>
    </td>
  </tr>
  <tr> 
    <td> 
      <?PHP
  error_reporting(7);
  include "notificacion/notificacion.php";
?>
    </td>
  </tr>
</table>
<table border=0 id=mod_resolucion cellpadding="0" cellspacing="5" class="borde_tab">
  <tr> 
    <td align="center" class='titulos2'> 
      <p>Modifcaci&oacute;n de empresa destino</p>
    </td>
  </tr>
  <tr> 
    <td> 
      <?PHP
  error_reporting(7);
  include "subtipo_docto/resolucion.php";
?>
    </td>
  </tr>
</table>
<table border=0 id=mod_decision cellpadding="0" cellspacing="5" class="borde_tab" >
  <tr> 
    <td align="center" class='titulos2'> 
      <p>PROCESO SANCIONADOS </p>
    </td>
  </tr>
  <tr> 
    <td> 
      <?PHP
  error_reporting(7);
  include "decision/decision.php";
?>
    </td>
  </tr>
</table>

