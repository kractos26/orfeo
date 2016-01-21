<?
session_start();
if (!$ruta_raiz)	$ruta_raiz="..";
//if(!$_SESSION['dependencia']) include "$ruta_raiz/rec_session.php"; 

require_once("$ruta_raiz/include/db/ConnectionHandler.php");
if (!$db) $db = new ConnectionHandler("$ruta_raiz");
include("crea_combos_universales.php");	
error_reporting(7);
$db->conn->SetFetchMode(ADODB_FETCH_NUM);	
//$db->conn->debug=true;
?>
<html>
<head>
<title>Busqueda Remitente / Destino</title>
<link rel="stylesheet" href="../estilos/orfeo.css" type="text/css">
<SCRIPT Language="JavaScript" SRC="../js/crea_combos_2.js"></SCRIPT>
<SCRIPT type="text/javascript" language="JavaScript" SRC="../js/formchek.js"></SCRIPT>
<script LANGUAGE="JavaScript">

<?php
// Convertimos los vectores de los paises, dptos y municipios creados en crea_combos_universales.php a vectores en JavaScript.
echo arrayToJsArray($vpaisesv,'vp'); 
echo arrayToJsArray($vdptosv,'vd');
echo arrayToJsArray($vmcposv,'vm');
?>

function verif_data(obj)
{	
	if (document.formu1.direccion_nus1.value=='')
    {       alert("Debe colocar una Direccion");
            return false;
    }
    if (document.formu1.nombre_nus1.value=='')
    {       alert("Debe colocar un nombre.");
            return false;
     }
    if (document.formu1.idcont4.value==0 || document.formu1.idpais4.value==0 || document.formu1.codep_us4.value==0 || document.formu1.muni_us4.value==0)
    {       alert("Seleccione la geograf\xEDa completa del destinatario");
            return false;
    }
    if (!isEmail(document.forms[0].mail_nus1.value,true))
    {       alert("El campo mail del Usuario no tiene formato correcto.");
            document.forms[0].mail_nus1.focus();
            return false;
    }
    
    return true;
}
function pasar_datos(fecha)
{
<?php
	($busq_salida==true)? $i_registros=1 : $i_registros=3;
	$i_registros=3;
	 for($i=1;$i<=$i_registros;$i++)
	 {
	 echo "documento = document.formu1.documento_us$i.value;\n";
	 echo "if(documento)
			{	if(opener.document.formulario.otro_us7){
         
                                    if(document.formu1.tbusqueda.value==0 )
                                    {
                                        nombre = document.formu1.nombre_us$i.value + ' '+document.formu1.prim_apell_us$i.value+' '+document.formu1.seg_apell_us$i.value;
                                        opener.document.formulario.otro_us7.value = '';
                                    }
                                    else if( document.formu1.tbusqueda.value==6 )
                                     {
                                        nombre = document.formu1.nombre_us$i.value + ' '+document.formu1.prim_apell_us$i.value;
                                        opener.document.formulario.otro_us7.value = '';
                                     }
                                    else{ 
                                        nombre = document.formu1.nombre_us$i.value + ' '+document.formu1.prim_apell_us$i.value;
                                        opener.document.formulario.otro_us7.value = document.formu1.seg_apell_us$i.value;
                                    }
                                }
                                else
                                    nombre = document.formu1.nombre_us$i.value + ' ';
         
				apellido1 = document.formu1.prim_apell_us$i.value  + ' ' ;
				apellido2 = document.formu1.seg_apell_us$i.value  + ' ' ;
				opener.document.formulario.documento_us$i.value = documento;
				opener.document.formulario.nombre_us$i.value = nombre ;
				opener.document.formulario.prim_apel_us$i.value = apellido1;
				opener.document.formulario.seg_apel_us$i.value  = apellido2;
				opener.document.formulario.telefono_us$i.value  = document.formu1.telefono_us$i.value;      
				opener.document.formulario.mail_us$i.value      = document.formu1.mail_us$i.value;  
				opener.document.formulario.direccion_us$i.value = document.formu1.direccion_us$i.value;
				opener.document.formulario.tipo_emp_us$i.value = document.formu1.tipo_emp_us$i.value;
				opener.document.formulario.cc_documento_us$i.value = document.formu1.cc_documento_us$i.value;";
	 			
				if ($_GET['tipoval'])
				{	echo "	opener.document.formulario.idcont$i.value = document.formu1.idcont$i.value;
						opener.document.formulario.idpais$i.value = document.formu1.idpais$i.value;
						opener.document.formulario.codep_us$i.value = document.formu1.codep_us$i.value;
						opener.document.formulario.muni_us$i.value = document.formu1.muni_us$i.value;
						}\n";
				}
				else
				{	echo "	opener.document.formulario.idcont$i.value = document.formu1.idcont$i.value;
						opener.cambia(opener.document.formulario,'idpais$i','idcont$i');
						opener.document.formulario.idpais$i.value = document.formu1.idpais$i.value;
						opener.cambia(opener.document.formulario,'codep_us$i','idpais$i');
						opener.document.formulario.codep_us$i.value = document.formu1.codep_us$i.value;
						opener.cambia(opener.document.formulario,'muni_us$i','codep_us$i');
						opener.document.formulario.muni_us$i.value = document.formu1.muni_us$i.value;
						}\n";
				}
	}
	?>
    if(opener.document.formulario.otro_us7){
        opener.pedirCombosDivipola('cCombos.php', 'NA','todos',document.formu1.idcont1.value,document.formu1.idpais1.value,document.formu1.codep_us1.value.substr(document.formu1.codep_us1.value.lastIndexOf('-')+1),document.formu1.muni_us1.value.substr(document.formu1.muni_us1.value.lastIndexOf('-')+1));
    }
    if(opener.document.formulario.otro_us1)
    {
        opener.document.formulario.otro_us1.focus();opener.focus();
    }
    window.close();
}
</script>
</head>
<body bgcolor="#FFFFFF">
<script LANGUAGE="JavaScript">
tipo_emp=new Array();
nombre=new Array();
documento=new Array();
cc_documento=new Array();      
direccion=new Array();
apell1=new Array();
apell2=new Array();
telefono=new Array();
mail=new Array();
codigo = new Array();
codigo_muni = new Array();   
codigo_dpto = new Array();      
codigo_pais = new Array();
codigo_cont = new Array();
function pasar(indice,tipo_us)
{ 
<?
	error_reporting(0);
	$nombre_essp = strtoupper($nombre_essp);

	(!$envio_salida and !$busq_salida)? $i_registros=3 : $i_registros=1;	
    $i_registros=3;
	for($i=1;$i<=$i_registros;$i++) 
	{
	
		echo "if(tipo_us==$i)
		{
                    document.formu1.documento_us$i.value = documento[indice];
                    document.formu1.no_documento1.value = cc_documento[indice];
                    document.formu1.cc_documento_us$i.value = cc_documento[indice];
                    document.formu1.nombre_nus1.value = nombre[indice]; 
                    document.formu1.nombre_us$i.value = nombre[indice]; 
                    document.formu1.prim_apell_us$i.value = apell1[indice];
                    document.formu1.prim_apell_nus1.value = apell1[indice];
                    document.formu1.seg_apell_us$i.value = apell2[indice];
                    document.formu1.seg_apell_nus1.value = apell2[indice];			   
                    document.formu1.direccion_us$i.value = direccion[indice];
                    document.formu1.direccion_nus1.value = direccion[indice];			   
                    document.formu1.telefono_us$i.value = telefono[indice];
                    document.formu1.telefono_nus1.value = telefono[indice];			   
                    document.formu1.mail_us$i.value = mail[indice];
                    document.formu1.mail_nus1.value = mail[indice];			   
                    document.formu1.tipo_emp_us$i.value = tipo_emp[indice];
                    document.formu1.tagregar.value = tipo_emp[indice];			   
                    document.formu1.muni_us$i.value = codigo_muni[indice];
                    document.formu1.codep_us$i.value = codigo_dpto[indice];
                    document.formu1.idpais$i.value = codigo_pais[indice];
                    document.formu1.idcont$i.value = codigo_cont[indice];
                    document.formu1.idcont4.value = codigo_cont[indice];
                    cambia(formu1,'idpais4','idcont4');
                    document.formu1.idpais4.value = codigo_pais[indice];
                    cambia(formu1,'codep_us4','idpais4');
                    document.formu1.codep_us4.value = codigo_dpto[indice];
                    cambia(formu1,'muni_us4','codep_us4');
                    document.formu1.muni_us4.value = codigo_muni[indice];
		}";
		}
	?>
}

function activa_chk(forma)
{	//alert(forma.tbusqueda.value);
	//var obj = document.getElementById(chk_desact);
	if (forma.tbusqueda.value == 1)
		forma.chk_desact.disabled = false;
	else
		forma.chk_desact.disabled = true;
}
</script>

<?php
if(!$envio_salida and !$busq_salida)
{
	$label_us = $nombreTp1;
	$label_pred = $nombreTp2;
	$label_emp = $nombreTp3;
}
else
{
	$label_us = "DESTINATARIO";
	$label_pred = "$nombreTp2";	
	$label_emp = "$nombreTp3"; 
}

$tbusqueda = $agregar? $tagregar: $_POST['tbusqueda'];

if($no_documento1 and ($agregar or $modificar))	{	$no_documento = $no_documento1; }
if(!$no_documento1 and $nombre_nus1 and ($agregar or $modificar))	{	$nombre_essp = $nombre_nus1;	}

if(!$formulario)
{
?>  
<form method="post" name="formu1" id="formu1" action="buscar_usuario.php?busq_salida=<?=$busq_salida?>&krd=<?=$krd?>&verrad=<?=$verrad?>&nombreTp1=<?=$nombreTp1?>&nombreTp2=<?=$nombreTp2?>&nombreTp3=<?=$nombreTp3?>&tipoval=<?=$_GET['tipoval'] ?>" >
<?
}
?> 
<input type="hidden" name="radicados" value="<?= $radicados_old?>">
<table border=0 width="78%" class="borde_tab" cellpadding="0" cellspacing="5">
<tr> 
	<td width="30%" class="titulos5"><font class="tituloListado">BUSCAR POR</font></td>
	<td width="50%" class="titulos5">
		<select name='tbusqueda' class='select' onchange="activa_chk(this.form)">
				<?
				if($tbusqueda==0){$datos = "selected";$tbusqueda=0;}else{$datos= "";}
				?> 
			<option value=0 <?=$datos ?>>PERSONA NATURAL</option>
				<?
				if($tbusqueda==1){$datos = "selected";$tbusqueda=1;}else{$datos= "";}
                                echo "<option value=1 $datos>ENTIDADES</option>";
				
				if($tbusqueda==2){$datos = "selected";$tbusqueda=2;}else{$datos= "";}
				?> 
				<option value=2 <?=$datos ?>>EMPRESAS</option>
				<? if($tbusqueda==6){$datos = " selected ";$tbusqueda=6;}else{$datos= "";}?>
			<option value=6 <?=$datos ?>>FUNCIONARIO</option>
		</select>
	</td>
	<td width="20%" rowspan="2" align="center" class="titulos5" > 
		<input type=submit name=buscar value='BUSCAR' class="botones">
	</td>
</tr>
<tr> 
	<td class="listado5" valign="middle"><font>
		<span class="titulos5">Documento</span> 
		<input type=text name=no_documento value='' class="tex_area">
		</font>
	</td>
	<td class="listado5" valign="middle">
		<span class="titulos5">Nombre</span> 
		<input type=text name=nombre_essp value='' class="tex_area">
		<input type="checkbox" name="chk_desact" id="chk_desact" <? ($_POST['tbusqueda'] != 1)? print "disabled" : print "";?>>Incluir no vigentes  
	</td>
</tr>
</table>
<br>
<TABLE class="borde_tab" width="100%">
<tr class=listado2><td colspan=10>
<center>RESULTADO DE BUSQUEDA</center>
</td></tr></TABLE>
<table class=borde_tab width="100%" cellpadding="0" cellspacing="5">
  <!--DWLayoutTable-->
<tr class="grisCCCCCC" align="center"> 
	<td width="11%" CLASS="titulos5" >DOCUMENTO</td>
	<td width="11%" CLASS="titulos5" >NOMBRE</td>
	<td width="14%" CLASS="titulos5" >PRIM.<BR>APELLIDO o SIGLA</td>
	<td width="15%" CLASS="titulos5" >SEG.<BR>APELLIDO o R Legal</td>
	<td width="14%" CLASS="titulos5">DIRECCION</td>
	<td width="9%" CLASS="titulos5" >TELEFONO</td>
	<td width="7%" CLASS="titulos5" >EMAIL</td>
	<td colspan="3" CLASS="titulos5" >COLOCAR COMO </td>
</tr> 
  <?
   $grilla = "timpar";
   $i = 0;
   // ********************************
   
   // ********************************
	if($modificar=="MODIFICAR" or $agregar=="AGREGAR")
	{
		$muni_tmp = explode("-",$muni_us4);
   		$muni_tmp = $muni_tmp[2];
   		$dpto_tmp = explode("-",$codep_us4);
   		$dpto_tmp = $dpto_tmp[1];
   }
   if($modificar=="MODIFICAR" and $tagregar==0)
   {	$isql = "update SGD_CIU_CIUDADANO set SGD_CIU_CEDULA='$no_documento1', SGD_CIU_NOMBRE='".str_ireplace("'","''",$nombre_nus1)."',
      			SGD_CIU_DIRECCION='".str_ireplace("'","''",$direccion_nus1)."', SGD_CIU_APELL1='".str_ireplace("'","''",$prim_apell_nus1)."', SGD_CIU_APELL2='".str_ireplace("'","''",$seg_apell_nus1)."',
      			SGD_CIU_TELEFONO='$telefono_nus1', SGD_CIU_EMAIL='$mail_nus1', ID_CONT=$idcont4, ID_PAIS=$idpais4, 
      			DPTO_CODI=$dpto_tmp, MUNI_CODI=$muni_tmp where SGD_CIU_CODIGO=$codigo ";
	   	$rs=$db->query($isql);
			if (!$rs){
				die ("<span class='etextomenu'>No se pudo actualizar SGD_CIU_CIUDADANO ($isql) "); 	
			}
      $isql = "select * from SGD_CIU_CIUDADANO where SGD_CIU_CEDULA='$no_documento1'";
			$rs=$db->query($isql);

	  }

	 $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);		
   if($agregar=="AGREGAR" and $tagregar==0)
   {
		$cedula = 999999;
		if($no_documento)
	{
			$isql = "select SGD_CIU_CEDULA  from SGD_CIU_CIUDADANO WHERE  SGD_CIU_CEDULA='$no_documento'";
			$rs=$db->query($isql);
			
			if  (!$rs->EOF)	$cedula = $rs->fields["SGD_CIU_CEDULA"] ;
	   $flag ==0;
	  }
	   //echo "--->Doc >$no_documento<";
     if($cedula==$no_documento and $no_documento!="" and $no_documento!=0)
	 {
	   echo "<center><b><font color=red><center><< No se ha podido agregar el usuario, El usuario ya se encuentra >> </center></font>";
     }else
	 {
	 	 
 	
   	$nextval=$db->nextId("sec_ciu_ciudadano");
		if ($nextval==-1){
			die ("<span class='etextomenu'>No se encontr&oacute; la secuencia sec_ciu_ciudadano ");
		}
	   error_reporting(7);
			$isql = "INSERT INTO SGD_CIU_CIUDADANO(SGD_CIU_CEDULA, TDID_CODI, SGD_CIU_CODIGO, SGD_CIU_NOMBRE,
					SGD_CIU_DIRECCION, SGD_CIU_APELL1, SGD_CIU_APELL2, SGD_CIU_TELEFONO, SGD_CIU_EMAIL, ID_CONT, ID_PAIS, 
					DPTO_CODI, MUNI_CODI) values ('$no_documento', 2, $nextval, '".str_ireplace("'","''",$nombre_nus1)."', '".str_ireplace("'","''",$direccion_nus1)."',
					'".str_ireplace("'","''",$prim_apell_nus1)."', '".str_ireplace("'","''",$seg_apell_nus1)."','$telefono_nus1', '$mail_nus1',
					$idcont4, $idpais4, $dpto_tmp, $muni_tmp)";
	   if (!trim($no_documento)) $nombre_essp = "$nombre_nus1 $prim_apell_nus1 $seg_apell_nus1";
		 $rs=$db->query($isql);
		 if (!$rs){
				$db->conn->RollbackTrans();
				die ("<span class='etextomenu'>No se pudo actualizar SGD_CIU_CIUDADANO ($isql) "); 	
		 }
	   }
	   if ($flag==1)
	   {
			echo "<center><b><font color=red><center>No se ha podido agregar el usuario, verifique que los datos sean correctos</center></font>";
	   }
       $isql = "select * from SGD_CIU_CIUDADANO where SGD_CIU_CEDULA='$no_documento1'";
	   	 $rs=$db->query($isql);
   }
   if($agregar=="AGREGAR" and $tagregar==2)
   {
			$nextval=$db->nextId("sec_oem_oempresas");

		if ($nextval==-1)
		{	die ("<span class='etextomenu'>No se encontr&oacute; la secuencia sec_oem_oempresas ");						   
		}
			 
		$isql = "INSERT INTO SGD_OEM_OEMPRESAS( tdid_codi, SGD_OEM_CODIGO, SGD_OEM_NIT, SGD_OEM_OEMPRESA, SGD_OEM_DIRECCION, 
				SGD_OEM_REP_LEGAL, SGD_OEM_SIGLA, SGD_OEM_TELEFONO, ID_CONT, ID_PAIS, DPTO_CODI, MUNI_CODI) 
				values (4, $nextval, '$no_documento', '".str_ireplace("'","''",$nombre_nus1)."', '".str_ireplace("'","''",$direccion_nus1)."', '".str_ireplace("'","''",$seg_apell_nus1)."',
						'".str_ireplace("'","''",$prim_apell_nus1)."', '$telefono_nus1',$idcont4, $idpais4, $dpto_tmp, $muni_tmp)";
		$rs=$db->query($isql);
			 
		if (!$rs)
				die ("<span class='titulosError'>No se pudo insertar en SGD_OEM_OEMPRESAS ($isql) "); 	
		
 }
   if($modificar=="MODIFICAR" and $tagregar==2)
	{	$isql = "UPDATE SGD_OEM_OEMPRESAS SET SGD_OEM_NIT='$no_documento1', SGD_OEM_OEMPRESA='".str_ireplace("'","''",$nombre_nus1)."',
				SGD_OEM_DIRECCION='".str_ireplace("'","''",$direccion_nus1)."', SGD_OEM_REP_LEGAL='".str_ireplace("'","''",$seg_apell_nus1)."', SGD_OEM_SIGLA='".str_ireplace("'","''",$prim_apell_nus1)."',
				SGD_OEM_TELEFONO='$telefono_nus1', ID_CONT=$idcont4, ID_PAIS= $idpais4, DPTO_CODI=$dpto_tmp, 
				MUNI_CODI=$muni_tmp where SGD_OEM_CODIGO='$codigo'";
		$rs=$db->query($isql);
		 
		 if (!$rs){
				$db->conn->RollbackTrans();
		 }
 	 }
$nombre_essp=mb_strtoupper(trim($nombre_essp),ini_get('default_charset'));
if($no_documento or $nombre_essp)
{	if($tbusqueda==0)
	{	$array_nombre = split(" ",$nombre_essp);
   		$isql = "select * from SGD_CIU_CIUDADANO ";
		if($nombre_essp)
   		{	if($array_nombre[0]) {$where_split = $db->conn->Concat("UPPER(".$db->conn->IfNull("sgd_ciu_nombre","''").")","UPPER( ".$db->conn->IfNull("sgd_ciu_apell1","''")." )","UPPER(".$db->conn->IfNull("sgd_ciu_apell1","''").")"). " LIKE '%". strtoupper($array_nombre[0]) ."%' ";}
			if($array_nombre[1]) {$where_split .= " and ". $db->conn->Concat("UPPER(".$db->conn->IfNull("sgd_ciu_nombre","''").")","UPPER( ".$db->conn->IfNull("sgd_ciu_apell1","''")." )","UPPER(".$db->conn->IfNull("sgd_ciu_apell1","''").")"). " LIKE '%". strtoupper($array_nombre[1]) ."%' ";}
			if($array_nombre[2]) {$where_split .= " and ". $db->conn->Concat("UPPER(".$db->conn->IfNull("sgd_ciu_nombre","''").")","UPPER( ".$db->conn->IfNull("sgd_ciu_apell1","''")." )","UPPER(".$db->conn->IfNull("sgd_ciu_apell1","''").")"). " LIKE '%". strtoupper($array_nombre[2]) ."%' ";}
			if($array_nombre[3]) {$where_split .= " and ". $db->conn->Concat("UPPER(".$db->conn->IfNull("sgd_ciu_nombre","''").")","UPPER( ".$db->conn->IfNull("sgd_ciu_apell1","''")." )","UPPER(".$db->conn->IfNull("sgd_ciu_apell1","''").")"). " LIKE '%". strtoupper($array_nombre[3]) ."%' ";}
			$isql .= " where $where_split and SGD_CIU_ACT=1 ";
		}

	   if($no_documento)
	   {	if($nombre_eesp) $isql .= " and "; else 	   $isql .= " where ";
			$isql .= " SGD_CIU_CEDULA='$no_documento' and UPPER(".$db->conn->IfNull("sgd_ciu_nombre","''").") like '%".strtoupper($nombre_essp)."%' ";
	   }
	   $isql .= " order by sgd_ciu_nombre,sgd_ciu_apell1,sgd_ciu_apell2 "; 
	}
	if($tbusqueda==2)
	{	$isql = "select SGD_OEM_NIT AS SGD_CIU_CEDULA,SGD_OEM_OEMPRESA as SGD_CIU_NOMBRE,SGD_OEM_REP_LEGAL as SGD_CIU_APELL2, ".
				"SGD_OEM_CODIGO AS SGD_CIU_CODIGO,SGD_OEM_DIRECCION as SGD_CIU_DIRECCION,SGD_OEM_TELEFONO AS SGD_CIU_TELEFONO, ".
				"SGD_OEM_SIGLA AS SGD_CIU_APELL1,MUNI_CODI,DPTO_CODI,ID_PAIS,ID_CONT from SGD_OEM_OEMPRESAS	where (UPPER(".$db->conn->IfNull("SGD_OEM_OEMPRESA","''").") LIKE '%".strtoupper($nombre_essp)."%' or UPPER(".$db->conn->IfNull("SGD_OEM_SIGLA","''").") LIKE '%".strtoupper($nombre_essp)."%') and sgd_oem_act=1 ";
		if($no_documento)	{	$isql .= " and SGD_OEM_NIT LIKE '%".$no_documento."%'   ";  }
		$isql .= " order by sgd_oem_oempresa"; 
	}
	if($tbusqueda==1)
	{	
            
            $isql = "select NIT_DE_LA_EMPRESA AS SGD_CIU_CEDULA,NOMBRE_DE_LA_EMPRESA as SGD_CIU_NOMBRE,SIGLA_DE_LA_EMPRESA as SGD_CIU_APELL1, ".
				"IDENTIFICADOR_EMPRESA AS SGD_CIU_CODIGO,DIRECCION as SGD_CIU_DIRECCION,TELEFONO_1 AS SGD_CIU_TELEFONO, ".
				"NOMBRE_REP_LEGAL as SGD_CIU_APELL2,SIGLA_DE_LA_EMPRESA as SGD_CIU_APELL1,CODIGO_DEL_DEPARTAMENTO as DPTO_CODI, ".
				"CODIGO_DEL_MUNICIPIO as MUNI_CODI,ID_PAIS, ID_CONT from BODEGA_EMPRESAS ".
				"WHERE (UPPER(".$db->conn->IfNull("SIGLA_DE_LA_EMPRESA","''").") LIKE '%".strtoupper($nombre_essp)."%' OR UPPER(".$db->conn->IfNull("NOMBRE_DE_LA_EMPRESA","''").") LIKE '%".strtoupper($nombre_essp)."%') ";
		//Si incluye ESP desactivas
		if (!isset($_POST['chk_desact']))	$isql.= " and ACTIVA = 1 ";
		if(strlen(trim($no_documento))>0)
		{	$isql.= " and NIT_DE_LA_EMPRESA like '%$no_documento%'"; 
			$isql .= " order by NOMBRE_DE_LA_EMPRESA ";
	   	}
	}
		if($tbusqueda==6)
   		{	$array_nombre = split(" ",$nombre_essp."    ");
   			//Query que busca funcionario
	 		$isql = "select usua_doc AS SGD_CIU_CEDULA,usua_nomb as SGD_CIU_NOMBRE,'' as SGD_CIU_APELL1,USUA_DOC AS SGD_CIU_CODIGO, ".
					"dependencia.depe_nomb as SGD_CIU_DIRECCION,USUARIO.USUA_EXT  AS SGD_CIU_TELEFONO,USUARIO.USUA_LOGIN as SGD_CIU_APELL2, ".
					"'' as SGD_CIU_APELL1,dependencia.ID_CONT, dependencia.ID_PAIS, dependencia.DPTO_CODI as DPTO_CODI,dependencia.MUNI_CODI as MUNI_CODI,USUARIO.usua_email as SGD_CIU_EMAIL ".
       				"from USUARIO,dependencia where USUA_ESTA='1' AND USUARIO.depe_codi = dependencia.depe_codi ";
			if($nombre_essp)
   			{	if($array_nombre[0]) {$where_split = "  UPPER(USUA_NOMB) LIKE '%". strtoupper($array_nombre[0]) ."%' ";}
				if($array_nombre[1]) {$where_split .= " AND UPPER(".$db->conn->IfNull("USUA_NOMB","''").") LIKE '%". strtoupper($array_nombre[1]) ."%' ";}
				if($array_nombre[2]) {$where_split .= " AND UPPER(".$db->conn->IfNull("USUA_NOMB","''").") LIKE '%". strtoupper($array_nombre[2]) ."%' ";}
				if($array_nombre[3]) {$where_split .= " AND UPPER(".$db->conn->IfNull("USUA_NOMB","''").") LIKE '%". strtoupper($array_nombre[3]) ."%' ";}
				$isql .= " and $where_split ";
   			}
			if($no_documento)
			{	if($nombre_eesp) $isql .= " and "; else 	   $isql .= " and ";
				$isql .= " usua_doc='$no_documento' ";
			}
			$isql .= " order by usua_nomb "; 
		}
	  	$rs=$db->query($isql); 
	  	$tipo_emp = $tbusqueda;
		if($rs && !$rs->EOF)
		{	//echo $isql;
			while(!$rs->EOF)
			{	
				($grilla=="timparr") ? $grilla="timparr" : $grilla="tparr";
?>
				<tr class='<?=$grilla ?>'> 
					<TD class="listado5"> <font size="-3"><?=$rs->fields["SGD_CIU_CEDULA"] ?></font></TD>
					<TD class="listado5"> <font size="-3"> <?=substr($rs->fields["SGD_CIU_NOMBRE"],0,120) ?></font></TD>
					<TD class="listado5"> <font size="-3"> <?=substr($rs->fields["SGD_CIU_APELL1"],0,70) ?></font></TD>
					<TD class="listado5"> <font size="-3"> <?=$rs->fields["SGD_CIU_APELL2"] ?> </font></TD>
					<TD class="listado5"> <font size="-3"> <?=$rs->fields["SGD_CIU_DIRECCION"] ?></font></TD>
					<TD class="listado5"> <font size="-3"> <?=$rs->fields["SGD_CIU_TELEFONO"] ?> </font></TD>
					<TD class="listado5"> <font size="-3"> <?=$rs->fields["SGD_CIU_EMAIL"] ?></font></TD>
					<TD width="6%" align="center" valign="top" class="listado5">
						<font size="-3"><a href="#btnpasar" onClick="pasar('<?=$i ?>',1);" class="titulos5"><?=$label_us?></a></font>
					</TD>
    <? 
				if(!$envio_salida or $ent==5) 
				{ 
	?>
					<td width="6%" align="center" valign="top" class="listado5">
						<font size="-3"><a href="#btnpasar" onClick="pasar('<?=$i ?>',2);" class="titulos5"><?=$label_pred?></a></font>
					</td>
    <?
					if($tbusqueda==1)
					{
	?>
						<td width="7%" align="center" valign="top" class="listado5"><font size="-3">
							<a href="#btnpasar" onClick="pasar('<?=$i ?>',3);" class="titulos5"><?=$label_emp?></a></font>
						</td>
    <?
					}
				}
		?>
  </tr><script>
		<? 
			$cc_documento = trim($rs->fields["SGD_CIU_CODIGO"]) . " ";			
			$email = str_replace('"',' ',$rs->fields["SGD_CIU_EMAIL"]) . " ";
			$telefono = str_replace('"',' ',$rs->fields["SGD_CIU_TELEFONO"]) . " ";
			$direccion = str_replace('"',' ',$rs->fields["SGD_CIU_DIRECCION"]) . " ";
			$apell2 = str_replace('"',' ',$rs->fields["SGD_CIU_APELL2"]) . " ";
			$apell1 = str_replace('"',' ',$rs->fields["SGD_CIU_APELL1"]) . " ";
			$nombre = str_replace('"',' ',$rs->fields["SGD_CIU_NOMBRE"]) . " ";
			$codigo = trim($rs->fields["SGD_CIU_CODIGO"]);
				
			$codigo_cont = $rs->fields["ID_CONT"] ;
			$codigo_pais = $rs->fields["ID_PAIS"] ;
			$codigo_dpto = $codigo_pais."-".$rs->fields["DPTO_CODI"];
			$codigo_muni = $codigo_dpto."-".$rs->fields["MUNI_CODI"];
			$cc_documento = trim($rs->fields["SGD_CIU_CEDULA"]) ;			
		?>
			tipo_emp[<?=$i?>]= "<?=$tbusqueda?>";
			documento[<?=$i?>]= "<?=$codigo?>";
			cc_documento[<?=$i?>]= "<?=$cc_documento?>";
			nombre[<?=$i?>]= "<?=$nombre?>";
			apell1[<?=$i?>]= "<?=$apell1?>";
			apell2[<?=$i?>]= "<?=$apell2?>";
			direccion[<?=$i?>]= "<?=$direccion?>";
			telefono[<?=$i?>]= "<?=$telefono?>";
			mail[<?=$i?>]= "<?=$email?>";
			codigo[<?=$i?>]= "<?=$codigo?>";			 
			codigo_muni[<?=$i?>]= "<?=$codigo_muni?>";
			codigo_dpto[<?=$i?>]= "<?=$codigo_dpto?>";			 
			codigo_pais[<?=$i?>]= "<?=$codigo_pais?>";
			codigo_cont[<?=$i?>]= "<?=$codigo_cont?>";
		</script>
  <?
				$i++;
				$rs->MoveNext();
			}
		echo "<span class='listado2'>Registros Encontrados</span>";
	}else 
	{
			echo "<span class='titulosError'>No se encontraron Registros -- $no_documento</span>";
	}
	}
	?>
</table>
<BR>
<table class=borde_tab width="100%" cellpadding="0" cellspacing="4">
<tr class=listado2>
	<TD colspan="10">
	<center>DATOS A COLOCAR EN LA RADICACION</center>
	</TD>
</tr>
<tr align="center" > 
	<td CLASS=titulos5>USUARIO</td>
	<td CLASS=titulos5 >DOCUMENTO</td>
	<td CLASS=titulos5 >NOMBRE</td>
	<td CLASS=titulos5 >PRIM.<BR>APELLIDO o SIGLA</td>
	<td CLASS=titulos5 >SEG.<BR>APELLIDO o REP LEGAL</td>
	<td CLASS=titulos5 >DIRECCION</td>
	<td CLASS=titulos5 >TELEFONO</td>
	<td CLASS=titulos5 >EMAIL</td>
</tr>
<tr class='<?=$grilla ?>'> 
	<td align="center"  class="listado5"><font face="Arial, Helvetica, sans-serif"><?=$nombreTp1?></font></td>
	<TD align="center" class="listado5">
		<input type="hidden" name="tipo_emp_us1" value="<?=$tipo_emp_us1?>">
		<input type="hidden" name="documento_us1" size="3" value="<?=$documento_us1?>" >
		<input type="hidden" name="muni_us1" value="<?=$muni_us1 ?>" >
		<input type="hidden" name="codep_us1" value="<?=$codep_us1 ?>" >
		<input type="hidden" name="idpais1" value="<?=$idpais1 ?>" >
		<input type="hidden" name="idcont1" value="<?=$idcont1 ?>" >
		<input type="text" readonly="yes" name="cc_documento_us1" value="<?=$cc_documento_us1 ?>" class="ecajasfecha">
	</TD>
	<TD align="center" class="listado5"> <input type="text" readonly="yes" name="nombre_us1" value="<?=$nombre_us1?>" class="ecajasfecha" size="15"> </TD>
	<TD align="center" class="listado5"> <input type="text" readonly="yes" name="prim_apell_us1" value="<?=$prim_apell_us1 ?>" class="ecajasfecha" size="14"> </TD>
	<TD align="center" class="listado5"> <input type="text" readonly="yes" name="seg_apell_us1" value="<?=$seg_apell_us1 ?>" class="ecajasfecha" size="14"> </TD>
	<TD align="center" class="listado5"> <input type="text" readonly="yes" name="direccion_us1" value="<?=$direccion_us1 ?>" class="ecajasfecha" size="15"> </TD>
	<TD align="center" class="listado5"> <input type="text" readonly="yes" name="telefono_us1" value="<?=$telefono_us1 ?>" class="ecajasfecha" size="10"> </TD>
	<TD align="center" class="listado5"> <input type="text" readonly="yes" name="mail_us1" value="<?=$mail_us1 ?>" class="ecajasfecha" size="16"> </TD>
	
</tr>

<tr class='<?=$grilla ?>'> 
	<td align="center" class="listado5"> <font face="Arial, Helvetica, sans-serif"><?=$nombreTp2?><br> o Seg. Not</font></td>
	<TD align="center" class="listado5">
		<input type="hidden" name="tipo_emp_us2" value="<?=$tipo_emp_us2?>" > 
		<input type="hidden" name="documento_us2" value="<?=$documento_us2?>" >
		<input type="hidden" name="codep_us2" value="<?=$codep_us2 ?>" >
		<input type="hidden" name="muni_us2" value="<?=$muni_us2 ?>" >
		<input type="hidden" name="idpais2" value="<?=$idpais2 ?>" >
		<input type="hidden" name="idcont2" value="<?=$idcont2 ?>" > 
		<input type="text" name="cc_documento_us2" value="<?=$cc_documento_us2?>" class="ecajasfecha" size="13" >
	</TD>
	<TD align="center" class="listado5"> <input type="text" name="nombre_us2" value="<?=$nombre_us2 ?>" class="ecajasfecha" size="15"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="prim_apell_us2" value="<?=$prim_apell_us2 ?>" class="ecajasfecha" size="14"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="seg_apell_us2" value="<?=$seg_apell_us2 ?>" class="ecajasfecha" size="14"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="direccion_us2" value="<?=$direccion_us2 ?>" class="ecajasfecha" size="15"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="telefono_us2" value="<?=$telefono_us2 ?>" class="ecajasfecha" size="10"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="mail_us2" value="<?=$mail_us2 ?>" class="ecajasfecha" size="16"> </TD>
</tr>
<tr class='<?=$grilla ?>'> 
<td align="center" class="listado5"><font face="Arial, Helvetica, sans-serif"><?=$nombreTp3?></font></td>
	<TD align="center" class="listado5"><input type=hidden name='tipo_emp_us3' value='<?=$tipo_emp_us3?>' class="ecajasfecha" >
		<font face="Arial, Helvetica, sans-serif"> 
		<input type="hidden" name="tipo_emp_us3" value="<?=$tipo_emp_us3?>" > 
		<input type=hidden name=documento_us3 class=e_cajas size=3  value='<?=$documento_us3?>' >
		<input type=hidden name=codep_us3 value='<?=$codep_us3 ?>' size=4 class="ecajasfecha">
		<input type=hidden name=muni_us3 value='<?=$muni_us3 ?>' size=4 class="ecajasfecha">
		<input type="hidden" name="idpais3" value="<?=$idpais3 ?>" >
		<input type="hidden" name="idcont3" value="<?=$idcont3 ?>" >
		<input type=text name=cc_documento_us3 value='<?=$cc_documento_us3?>' size=13 class="ecajasfecha">
        </font>
	</TD>
	<TD align="center" class="listado5"> <input type="text" name="nombre_us3" value="<?=$nombre_us3 ?>" class="ecajasfecha" size="15"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="prim_apell_us3" value="<?=$prim_apell_us3 ?>" class="ecajasfecha" size="14"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="seg_apell_us3" value="<?=$seg_apell_us3 ?>" class="ecajasfecha" size="14"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="direccion_us3" value="<?=$direccion_us3 ?>"class="ecajasfecha" size="15"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="telefono_us3" value="<?=$telefono_us3 ?>" class="ecajasfecha" size="10"> </TD>
	<TD align="center" class="listado5"> <input type="text" name="mail_us3" value="<?=$mail_us3 ?>" class="ecajasfecha" size="16"> </TD>
</tr>
	<?
	$nombre_tt = str_replace('"',' ',$rs->fields["SGD_CIU_NOMBRE"]);
	?><script>
		 nombre[<?=$i ?>]= "<?=$nombre_tt?>"; 
	</script>
  </table>
  
  <center>
  <?
    if($envio_salida) 
	{
	?>
      <input type=submit name=grb_destino value='Grabar el Destino de Este Radicado' class="botones:largo">
      <input type=hidden name=verrad_sal value='<?=$verrad_sal?>' >
    <? 
	}else
	{
	?>
       <b><a href="javascript:pasar_datos('<?=$fechah?>');" name="btnpasar"><span name=btnpasardatos id=btnpasardatos class="botones_largo" >PASAR DATOS AL FORMULARIO DE RADICACION</span></a></b>
      <input type=hidden name=verrad_sal value='<?=$verrad_sal?>' >
    <?
	}
	?> 
    <br><br>
    </center>
    
<table class=borde_tab width="100%" cellpadding="0" cellspacing="4">
<!--
<tr align="center" > 
	<td CLASS=titulos5>DOCUMENTO</td>
	<td CLASS=titulos5>NOMBRE</td>
	<td CLASS=titulos5>PRIMER<BR>APELLIDO o Sigla</td>
	<td CLASS=titulos5>SEG.<BR>APELLIDO o REP LEGAL</td>
	<td CLASS=titulos5>DIRECCION</td>
	<td CLASS=titulos5>TELEFONO</td>
	<td CLASS=titulos5>EMAIL</td>
</tr>
-->
	<tr class='listado5' align="center"> 
	<TD>  
		<input type="hidden" name="codigo" id="codigo" class="e_cajas" size="3"  readonly value='<?=$codigo?>' >
		<input type="hidden" name="no_documento1" value="<?=$no_documento ?>" size="13" class="ecajasfecha">
	</TD>
	<TD><input type="hidden" name="nombre_nus1" value="<?=$nombre_nus1?>"class="ecajasfecha" size=15></TD>
	<TD><input type="hidden" name="prim_apell_nus1" value="<?=$prim_apell_nus1?>"class="ecajasfecha" size="14"></TD>
	<TD><input type="hidden" name="seg_apell_nus1" value="<?=$seg_apell_nus1?>" class="ecajasfecha" size="14"></TD>
	<TD><input type="hidden" name="direccion_nus1" value="<?=$direccion_nus1?>"class="ecajasfecha" size="15"></TD>
	<TD><input type="hidden" name="telefono_nus1" value="<?=$telefono_nus1?>" class="ecajasfecha" size="10"></TD>
	<TD><input type="hidden" name="mail_nus1" value="<?=$mail_nus1?>" class="ecajasfecha" size=16></TD>
</tr>
<tr align="center" > 
        <!--
	<td CLASS=titulos5><font>Continente</font></td>
	<td CLASS=titulos5><font>Pa&iacute;s</font></td>
	<td CLASS=titulos5><font>Dpto / Estado</font></td>
	<td CLASS=titulos5><font>Municipio</font></td>
	-->
        <td colspan="3" rowspan="2" CLASS=grisCCCCCC>
            <input type="hidden" name="tagregar" id="tagregar" class="select"></input>
            <!--
		<select type="hidden" name="tagregar" id="tagregar" class="select">
			<option value='0'>USUARIO(Ciudadano) </option>
			<option value='2'>EMPRESAS </option
                </select>
		<input type='SUBMIT' name='modificar'id="modificar" value='MODIFICAR' class="botones" onclick="return verif_data(this);">
		<input type='SUBMIT' name='agregar' value='AGREGAR' class="botones" onclick="return verif_data(this);">
                -->
	</td>
</tr>
<tr class='celdaGris' align="center"> 
    <!--
	<TD>
	<?php
		$i = 4;
		
		echo $Rs_Cont->GetMenu2("idcont$i",substr($_SESSION['cod_local'],0,1)*1,"$0:&lt;&lt; seleccione &gt;&gt;",false,0," CLASS=\"select\" id=\"idcont$i\" onchange=\"cambia(this.form, 'idpais$i', 'idcont$i')\" ");
		$Rs_Cont->Move(0);
	?>
	</TD>
	<TD>
	<?php
		if ($_SESSION['cod_local']) 
			$paiscodi = substr($_SESSION['cod_local'],2,3)*1;
		echo "<SELECT NAME=\"idpais$i\" ID=\"idpais$i\" CLASS=\"select\" onchange=\"cambia(this.form, 'codep_us$i', 'idpais$i')\">";
		while (!$Rs_pais->EOF)
		{	if ($_SESSION['cod_local'] and ($Rs_pais->fields['ID0'] == substr($_SESSION['cod_local'],0,1)*1))
				
				//Si hay local Y pais pertenece al continente.
				{	($paiscodi == $Rs_pais->fields['ID1'])? $s = " selected='selected'" : $s = "";
					echo "<option".$s." value='".$Rs_pais->fields['ID1']."'>".$Rs_pais->fields['NOMBRE']."</option>";
				}
			$Rs_pais->MoveNext();
		}
		echo "</SELECT>";
		$Rs_pais->Move(0);
	?>
	</TD>
	<TD>
	<?php
		echo "<SELECT NAME=\"codep_us$i\" ID=\"codep_us$i\" CLASS=\"select\" onchange=\"cambia(this.form, 'muni_us$i', 'codep_us$i')\">";
		while (!$Rs_dpto->EOF)
		{	if ($_SESSION['cod_local'] and ($Rs_dpto->fields['ID0'] == substr($_SESSION['cod_local'],2,3)*1))	//Si hay local Y dpto pertenece al pais.
			{	((substr($_SESSION['cod_local'],2,3)*1)."-".(substr($_SESSION['cod_local'],6,3)*1) == $Rs_dpto->fields['ID1'])? $s = " selected='selected'" : $s = "";
				echo "<option".$s." value='".$Rs_dpto->fields['ID1']."'>".$Rs_dpto->fields['NOMBRE']."</option>";
			}
			$Rs_dpto->MoveNext();
		}
		echo "</SELECT>";
		$Rs_dpto->Move(0);
	?>
	</TD>
	<td>
	<?php
		echo "<SELECT NAME=\"muni_us$i\" ID=\"muni_us$i\" CLASS=\"select\" >";
		while (!$Rs_mcpo->EOF)
		{	if ($_SESSION['cod_local'] and ($Rs_mcpo->fields['ID'] == substr($_SESSION['cod_local'],2,3)*1) and ($Rs_mcpo->fields['ID0'] == substr($_SESSION['cod_local'],6,3)*1))	//Si hay local Y mcpio pertenece al pais Y dpto.
			{	((substr($_SESSION['cod_local'],2,3)*1)."-".(substr($_SESSION['cod_local'],10,3)*1) == $Rs_mcpo->fields['ID1'])? $s = " selected='selected'" : $s = "";
				echo "<option".$s." value='".$Rs_mcpo->fields['ID1']."'>".$Rs_mcpo->fields['NOMBRE']."</option>";
			}
			$Rs_mcpo->MoveNext();
		}
		echo "</SELECT>";
		$Rs_mcpo->Move(0);
	?> 
	</td>
    -->
</tr>
</table>
<?
if(!$formulario)
{
?>
</form>
<?
}
?>
<center><input type='button' value='Cerrar' class="botones_largo" onclick='window.close()'></center>
</body>
</html>
