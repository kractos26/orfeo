<?
/*************************************************************************************/
/* ORFEO GPL:Sistema de Gestion Documental		http://www.orfeogpl.org	     */
/*	Idea Original de la SUPERINTENDENCIA DE SERVICIOS PUBLICOS DOMICILIARIOS     */
/*				COLOMBIA TEL. (57) (1) 6913005  orfeogpl@gmail.com   */
/* ===========================                                                       */
/*                                                                                   */
/* Este programa es software libre. usted puede redistribuirlo y/o modificarlo       */
/* bajo los terminos de la licencia GNU General Public publicada por                 */
/* la "Free Software Foundation"; Licencia version 2. 			                     */
/*                                                                                   */
/* Copyright (c) 2005 por :	  	  	                                                 */
/* SSPS "Superintendencia de Servicios Publicos Domiciliarios"                       */
/*   Jairo Hernan Losada  jlosada@gmail.com                Desarrollador             */
/*   Sixto Angel PinzÃ³n LÃ³pez --- angel.pinzon@gmail.com   Desarrollador           */
/* C.R.A.  "COMISION DE REGULACION DE AGUAS Y SANEAMIENTO AMBIENTAL"                 */
/*   Lucia Ojeda          lojedaster@gmail.com             Desarrolladora            */
/* D.N.P. "Departamento Nacional de PlaneaciÃ³n"                                     */
/*   Hollman Ladino       hollmanlp@gmail.com                Desarrollador           */
/*                                                                                   */
/* Colocar desde esta lInea las Modificaciones Realizadas Luego de la Version 3.5    */
/*  Nombre Desarrollador   Correo     Fecha   Modificacion                           */
/*************************************************************************************/


?>
<html>
<head>
<title>menu</title>
<link href="orfeo.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body bgcolor="#ffffff">
<table border="0" cellpadding="0" cellspacing="0" width="160">
<tr>
	<td><img src="imagenes/spacer.gif" width="10" height="1" border="0" alt=""></td>
	<td><img src="imagenes/spacer.gif" width="150" height="1" border="0" alt=""></td>
	<td><img src="imagenes/spacer.gif" width="1" height="1" border="0" alt=""></td>
</tr>
<tr>
		<td colspan="2"><img name="menu_r3_c1" src="imagenes/administracionimg.jpg" width="148" height="31" border="0" alt=""></td>

	<td><img src="imagenes/administracionimg.jpg" width="1" height="25" border="0" alt=""></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td valign="top">
		<table width="150"  border="0" cellpadding="0" cellspacing="0" class=eMenu>
		<tr>
			<td valign="top">
				<table width="150"  border="0" cellpadding="0" cellspacing="3" class=eMenu>
<?php
if($_SESSION["usua_admin_sistema"]==1)
{
?>
				<tr valign="middle">
					
					<td width="125">
						<a href="Administracion/formAdministracion.php?<?=$phpsession ?>&krd=<?=$krd?>&<? echo "fechah=$fechah&usr=".md5($dep)."&primera=1&ent=1"; ?>" target='mainFrame' class="menu_princ">Administraci&oacute;n</a>
					</td>
				</tr>
<?php
}
if($_SESSION["usua_perm_adminflujos"]==1)
{
?>
				<tr valign="middle">
					
					<td width="125">
						<a href="Administracion/flujos/texto_version2/mnuFlujosBasico.php?<?=$phpsession ?>&krd=<?=$krd?>" class="menu_princ" target='mainFrame'>Editor flujos</a>
						</td>
				</tr>				
<?php
}
if($_SESSION["usua_perm_envios"]>=1)
{
?>
				<tr valign="middle">
					
					<td width="125">
						<a href="radicacion/formRadEnvios.php?<?=$phpsession ?>&krd=<?=$krd?>&<? echo "fechah=$fechah&usr=".md5($dep)."&primera=1&ent=1"; ?>" target='mainFrame' class="menu_princ">Env&iacute;os</a>
					</td>
				</tr>
<?php
}
if($_SESSION["usua_perm_modifica"] >=1)
{
?>
				<tr valign="middle">
					
					<td width="125">
						<span class="Estilo12"><a href="radicacion/edtradicado.php?<?=$phpsession ?>&krd=<?=$krd?>&<? ECHO "&fechah=$fechah&primera=1&ent=2"; ?>" target='mainFrame'  class="menu_princ">Modificaci&oacute;n</a></span>
					</td>
				</tr>
<?php
}
if($_SESSION["usua_perm_firma"]==1 || $_SESSION["usua_perm_firma"]==3)
{
?>
				<tr valign="middle">
					 
					<td width="125">
						<span class="Estilo12"><a href="firma/cuerpoPendientesFirma.php?<?=$phpsession?>&krd=<?=$krd?>&<?php echo "fechaf=$fechah&carpeta=8&nomcarpeta=Documentos Para Firma Digital&orderTipo=desc&orderNo=3"; ?>" target='mainFrame' class="menu_princ">Firma digital</a></span>
					</td>
				</tr>
<?php
}
if($_SESSION["usua_perm_intergapps"]==1 )
{
?>
				<tr valign="middle">
					 
					<td width="125">
						<span class="Estilo12"><a href="aplintegra/cuerpoApLIntegradas.php?<?=$phpsession?>&krd=<?=$krd?>&<?php echo "fechaf=$fechah&carpeta=8&nomcarpeta=Aplicaciones integradas&orderTipo=desc&orderNo=3"; ?>" target='mainFrame' class="menu_princ">Aplicaciones integradas</a></span>
					</td>
				</tr>
<?php
}
if($_SESSION["usua_perm_impresion"] >= 1)
{
	$nomcarpeta= utf8_encode("Documentos Para Impresi�n");
?>
				<tr valign="middle">
					 
					<td width="125">
						<span class="Estilo12"><a href="envios/cuerpoMarcaEnviar.php?<?=$phpsession?>&krd=<?=$krd?>&<?php echo "fechaf=$fechah&usua_perm_impresion=$$usua_perm_impresion&carpeta=8&nomcarpeta=$nomcarpeta&orderTipo=desc&orderNo=3"; ?>" target='mainFrame' class="menu_princ">Impresi&oacute;n</a></span>
					</td>
				</tr>
<?php
}

if($_SESSION["usua_perm_comisiones"] >= 1) {
?>
				<tr valign="middle">
					 
					<td width="125">
						<span class="Estilo12"><a href="<?php echo URLCOMISIONES;?>index.php?<?=$phpsession?>&krd=<?=$krd?>&depeCodi=<?=$_SESSION["dependencia"]?>" target='mainFrame' class="menu_princ">Comisiones</a></span>
					</td>
				</tr>
<?php
}
if ($_SESSION["usua_perm_anu"]==3 or $_SESSION["usua_perm_anu"]==1)
{
?>
				<tr valign="middle">
					 
					<td width="125">
						<span class="Estilo12"><a href="anulacion/cuerpo_anulacion.php?<?=$phpsession?>&krd=<?=$krd?>&krd=<?=$krd?>&tpAnulacion=1&<? echo "fechah=$fechah"; ?>" target='mainFrame' class="menu_princ">Solicitud de Anulaci&oacute;n</a></span>
					</td>
				</tr>
<?php
}
//jean
if (($_SESSION["usua_perm_anu"]==3) or ($_SESSION["usua_perm_anu"] > 1 && $_SESSION["usua_admin_archivo"]>=1)) //Agregado para el IPSE por IIAC Modificado por Aquiles Canto

{?>

				<tr valign="middle">

				

					<td width="125">

						<span class="Estilo12"><a href="anulacion/menuAnulacion.php?<?=$phpsession?>&krd=<?=$krd?>&<? echo "fechah=$fechah"; ?>" target='mainFrame' class="menu_princ">Anulaci&oacute;n</a></span>

					</td>

				</tr>

<?php

}
//jean
if ($_SESSION["usua_perm_trd"]==1)
{
?>
				<tr valign="middle">
					 
					<td width="125">
						<span class="Estilo12"><a href="trd/menu_trd.php?<?=$phpsession ?>&krd=<?=$krd?>&krd=<?=$krd?>&<? echo "fechah=$fechah"; ?>" target='mainFrame' class="menu_princ">Tablas retenci&oacute;n documental</a></span>
					</td>
				</tr>
<?php
}
if ($_SESSION["usua_perm_remit_tercero"]==1)
{
?>
				<tr valign="middle">
					 
					<td width="125">
						<span class="Estilo12"><a href="Administracion/tbasicas/adm_esp.php?<?=$phpsession ?>&krd=<?=$krd?>&<? echo "fechah=$fechah"; ?>" target='mainFrame' class="menu_princ">Remitente / Terceros</a></span>
					</td>
				</tr>
<?php
}
?>
				<tr valign="middle">
					 
					<td width="125">
						<span class="Estilo12"><a href="busqueda/busquedaPiloto.php?<?=$phpsession ?>&etapa=1&&s_Listado=VerListado&krd=<?=$krd?>&<? echo "fechah=$fechah"; ?>" target='mainFrame' class="menu_princ">Consultas</a></span>
					</td>
				</tr>
<?php
/**
 *  $usua_admin_archivo Viene del campo con el mismo nombre en usuario y Establece permiso para ver informaci&oacute;n de
 *  documentos que tienen que bicarse fisicamente en Archivo
 *  (Por. Jh 20031101)
 */
if($_SESSION["usua_admin_archivo"]>=1)
{
    if($_SESSION["usua_admin_archivo"]==1)$where=" AND d.DEPE_CODI_TERRITORIAL=".$_SESSION["depe_codi_territorial"];
    $isql = "select count(*) as CONTADOR from SGD_SEXP_SECEXPEDIENTES exp JOIN DEPENDENCIA d ON exp.DEPE_CODI=d.DEPE_CODI where exp.SGD_SEXP_FASEEXP=1  $where";
    $rs=$db->conn->Execute($isql);
    $num_exp = $rs->fields["CONTADOR"];
?>
				<tr>
                                    <td>
                                             <div id=menuArchivo>&nbsp;&nbsp;<span class="Estilo12"><a href='archivo/archivo.php?<?=$phpsession?>&krd=<?=$krd?>&<?="carpeta=8&nomcarpeta=Expedientes&orno=1&adodb_next_page=1"; ?>' target='mainFrame' class="menu_princ"><b>Archivo(<?=$num_exp?>)</a></span></div>
					</td>
				</tr>
<?php
}

///////////////////////////////////////////////////
if($_SESSION['Administracionpqr']==1)
{
    if($_SESSION["usua_admin_archivo"]==1)$where=" AND d.DEPE_CODI_TERRITORIAL=".$_SESSION["depe_codi_territorial"];
    $isql = "select count(*) as CONTADOR from SGD_SEXP_SECEXPEDIENTES exp JOIN DEPENDENCIA d ON exp.DEPE_CODI=d.DEPE_CODI where exp.SGD_SEXP_FASEEXP=1  $where";
    $rs=$db->conn->Execute($isql);
    $num_exp = $rs->fields["CONTADOR"];
?>
				<tr>
                                             <div id=menuArchivo><span class="Estilo12"><a href='./Administracion/Pqrs/menuadmipqrs.php' target='mainFrame' class="menu_princ"><b>Administraci&oacute;n PQR's</a></span></div>
					</td>
				</tr>
<?php
}
if($_SESSION['ciudadanosempresas']==1)
{
    if($_SESSION["usua_admin_archivo"]==1)$where=" AND d.DEPE_CODI_TERRITORIAL=".$_SESSION["depe_codi_territorial"];
    $isql = "select count(*) as CONTADOR from SGD_SEXP_SECEXPEDIENTES exp JOIN DEPENDENCIA d ON exp.DEPE_CODI=d.DEPE_CODI where exp.SGD_SEXP_FASEEXP=1  $where";
    $rs=$db->conn->Execute($isql);
    $num_exp = $rs->fields["CONTADOR"];
?>
				<tr>
                                         <td>
                                             <div id=menuArchivo><span class="Estilo12"><a href='./Administracion/RemDest/adm_rem_dest.php' target='mainFrame' class="menu_princ"><b>Ciudadanos / Empresas</a></span></div>
					</td>
				</tr>
<?php
}
if ($_SESSION["usua_perm_prestamo"]==1)
{
    if($_SESSION["usua_admin_archivo"]==1)$where=" AND d.DEPE_CODI_TERRITORIAL=".$_SESSION["depe_codi_territorial"];
    $isql = "select count(*) as CONTADOR from PRESTAMO p JOIN DEPENDENCIA d ON p.DEPE_CODI=d.DEPE_CODI where p.PRES_ESTADO=1 and p.SGD_EXP_NUMERO is not null $where";
    $rs=$db->conn->Execute($isql);
    $num_exp = $rs->fields["CONTADOR"];
?>
				<tr valign="middle">
					 
					<td width="125">
						<div id=menuPrestamo><span class="Estilo12"><a href="prestamo/menu_prestamo.php?<?=$phpsession ?>&etapa=1&&s_Listado=VerListado&krd=<?=$krd?>&<? echo "fechah=$fechah"; ?>" target='mainFrame' class="menu_princ">Pr&eacute;stamo(<?=$num_exp?>)</a></span></div>
					</td>
				</tr>
<?php
}
/**
 *  $usua_perm_dev  Permiso de ver documentos de devolucion de documentos enviados.
 *  (Por. Jh)
 */
if($_SESSION["usua_perm_dev"]==1)
{
?>
				<tr>
					<TD>
						<span class="Estilo12">
						<a href='devolucion/cuerpoDevCorreo.php?<?=$phpsession?>&krd=<?=$krd?>&<?php echo "fechaf=$fechah&carpeta=8&devolucion=2&estado_sal=4&nomcarpeta=Documentos Para Impresion&orno=1&adodb_next_page=1"; ?>' target='mainFrame' class="menu_princ" >Dev correo</span></a>
					</td>
				</tr>
<?php
}
?>
				
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
