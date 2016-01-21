<?php
session_start();

if (!$ruta_raiz)$ruta_raiz= ".";
define('ADODB_ASSOC_CASE', 1);
(!$_POST)?$error = 0:$error=-1;
$i_copias = 0;
if (is_object($db))
	$conn = $db->conn;
else
{	
	include("$ruta_raiz/config.php");
	include($ADODB_PATH.'/adodb.inc.php');	// $ADODB_PATH configurada en config.php
	$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$servicio;
	$conn = NewADOConnection($dsn);
}
include("$ruta_raiz/config.php");
$nombreTp3 = $tip3Nombre[3][$ent];
if ($conn)
{   //$conn->debug=true;
    $conn->SetFetchMode(ADODB_FETCH_ASSOC);
    include "$ruta_raiz/include/class/DatoOtros.php";
    $objOtro = new DatoOtros($conn);
    $bandOtro=false;
    if($_GET['dir_codigo_us1'])
    {
        $dato_dir_direccion1 = $objOtro->obtieneDatosDir($_GET['dir_codigo_us1']);
        $datos1=$objOtro->obtieneDatosReales($_GET['dir_codigo_us1']);
        $otro_us11=$datos1[0]['NOMBRE'];
        $dpto_nombre_us11=$dato_dir_direccion1[0]['DEPARTAMENTO'];
        $direccion_us11=$dato_dir_direccion1[0]['DIRECCION'];
        $muni_nombre_us11=$dato_dir_direccion1[0]['MUNICIPIO'];
        $nombret_us11=$datos1[0]['APELLIDO'];
        $mrec_dest1=$dato_dir_direccion1[0]['MREC_DESC'];
    }
    if($_GET['dir_codigo_us2'])
    {
        $dato_dir_direccion2 = $objOtro->obtieneDatosDir($_GET['dir_codigo_us2']);
        $datos2=$objOtro->obtieneDatosReales($_GET['dir_codigo_us2']);
        $otro_us2=$datos2[0]['NOMBRE'];
        $dpto_nombre_us2=$dato_dir_direccion2[0]['DEPARTAMENTO'];
        $muni_nombre_us2=$dato_dir_direccion2[0]['MUNICIPIO'];
        $direccion_us2=$dato_dir_direccion2[0]['DIRECCION'];
        $nombret_us2=$datos2[0]['APELLIDO'];
        $mrec_dest2=$dato_dir_direccion2[0]['MREC_DESC'];
    }
    if($_GET['dir_codigo_us3'])
    {
        $objOtro->setdatoEnt($_GET['dir_codigo_us3']);
        $dato_dir_direccion3 = $objOtro->obtieneDatosDir($_GET['dir_codigo_us3']);
        $datos3=$objOtro->getdatoEnt();
        $dpto_nombre_us3=$datos3[0]['DEPARTAMENTO'];
        $muni_nombre_us3=$datos3[0]['MUNICIPIO'];
        $direccion_us3=$datos3[0]['DIRECCION'];
        $nombret_us3=$datos3[0]['NOMBRE'];
        $mrec_dest3=$dato_dir_direccion3[0]['MREC_DESC'];
    }

    $enviado="";
    //solo lectura
    $sol_lect=$_POST['sololect']?$_POST['sololect']: $_GET['sol_lect'];
    ($sol_lect=='S' or $sol_lect=='1')?$solec="checked":$solec="";

    //borra otros destinatarios o cc
    if($borrar)
    {
        if($borrar>1)
        {
            $isql = "delete from sgd_dir_drecciones
                     where sgd_anex_codigo='$codigo' and sgd_dir_tipo = $borrar ";
            $rsBorra=$conn->Execute($isql);
        }
        if($borrar==1)
        {
                $isql = "delete from anexos
                         where radi_nume_salida=$radsalida and sgd_dir_tipo=1 and sgd_rem_destino=0";
                $rsBorra=$conn->Execute($isql);
                $id_Dir_otro='';
        }
        $rsBorra?$error=7:$error=8;
        $i_copias=$i_copias-1;
    }
    if($ent!=2 and !$codigo)
    {   
        $sqlAnex="select * from anexos where anex_radi_nume=$radi and anex_salida = 1 and anex_borrado <> 'S'";
        $ADODB_COUNTRECS=true;
        $rsAnex=$conn->Execute($sqlAnex);
        $ADODB_COUNTRECS=true;
        $nAnex=$rsAnex->RecordCount();
        if($nAnex==0)
        {
            $sqlAsun = "select ra_asun from radicado  where radi_nume_radi = $numrad";
            $rsAsun=$conn->Execute($sqlAsun);
            $descr=$rsAsun->fields['RA_ASUN'];
            $primero=1;
        }
    }

    //datos si ya fue anexado y radicado
    if ($codigo)
    {
        $q_Anex = "select CODI_NIVEL
                ,ANEX_SOLO_LECT
                ,ANEX_CREADOR
                ,ANEX_DESC
                ,ANEX_TIPO_EXT
                ,ANEX_NUMERO
                ,ANEX_RADI_NUME 
                ,ANEX_NOMB_ARCHIVO AS nombre
                ,ANEX_SALIDA,ANEX_ESTADO,SGD_DIR_TIPO,RADI_NUME_SALIDA,SGD_DIR_DIRECCION from anexos, anexos_tipo,radicado ".
                "where anex_codigo='$codigo' and anex_radi_nume=radi_nume_radi and anex_tipo=anex_tipo_codi";

        $rsAnex=$conn->Execute($q_Anex);
        if (!$rsAnex->EOF && $rsAnex)
        {
            $docunivel=($rsAnex->fields["CODI_NIVEL"]);
            $remitente=$rsAnex->fields["SGD_DIR_TIPO"];
            $extension=$rsAnex->fields["ANEX_TIPO_EXT"];
            $anex_estado=$rsAnex->fields["ANEX_ESTADO"];
            $descr=$rsAnex->fields["ANEX_DESC"];
            $radsalida = $rsAnex->fields["RADI_NUME_SALIDA"];
            $direccionAlterna = $rsAnex->fields["SGD_DIR_DIRECCION"];
        }
        if($radsalida)
        {
        	
            $radicado_salida=$rsAnex->fields["ANEX_SALIDA"];
            $chk=" checked ";
            $dsbl=" disabled=true ";
        }
        if($tpradic!=0)$chk=" checked ";
        $ro="disabled";
    }

    //llena combo de tipo de anexos
    $sqlConcat = $conn->Concat("ANEX_TIPO_DESC","' - '","'(.'","ANEX_TIPO_EXT","')'");
    $q_tAnex = "select  $sqlConcat,ANEX_TIPO_CODI,ANEX_TIPO_EXT from anexos_tipo order by anex_tipo_desc desc";
    $rs_tAnex=$conn->Execute($q_tAnex);
    $rs_tAnex_aux=$conn->GetArray($q_tAnex);//arreglo para validar javascript escogio_archivo()
    $rs_tAnex?$sel_tAnex=$rs_tAnex->GetMenu2("tipo",$tipo,false,false,0,"class='select' id='tipo_clase' $ro"):$error=1;

    //llena combo de Tipos de radicacion
    foreach ($_SESSION["tpNumRad"]as $key => $valueTp)
    {
        if($tpPerRad[$valueTp]==2 or $tpPerRad[$valueTp]==3)$radtp[]=$valueTp;
        else $radtp[]=0;
    }
    $sqlConcat = $conn->Concat("SGD_TRAD_DESCR","' '","'(-'","SGD_TRAD_CODIGO","')'");
    $q_tRad = "select  $sqlConcat,SGD_TRAD_CODIGO from SGD_TRAD_TIPORAD where SGD_TRAD_CODIGO in (".implode(',',$radtp).") and SGD_TRAD_CODIGO <> 2";
    $rs_tRad=$conn->Execute($q_tRad);
    $rs_tRad?$sel_tRad=$rs_tRad->GetMenu2("tpradic",$tpradic,"0:&lt;&lt;Seleccione &gt;&gt;",false,0,"class='select' $dsbl"):$error=1;

    //trae los datos Expediente
    $q_exp  = "SELECT DISTINCT SGD_EXP_NUMERO as valor, SGD_EXP_NUMERO as etiqueta, SGD_EXP_FECH as fecha";
    $q_exp .= " FROM SGD_EXP_EXPEDIENTE ";
    $q_exp .= " WHERE RADI_NUME_RADI = ".$numrad;
    $q_exp .= " AND SGD_EXP_ESTADO <> 2";
    $q_exp .= " ORDER BY fecha desc";
    $ADODB_COUNTRECS=true;
    $rs_exp = $conn->Execute( $q_exp );
    $ADODB_COUNTRECS=false;
    $rs_exp->RecordCount()?$sel_exp=$rs_exp->GetMenu2("expIncluidoAnexo",$expIncluidoAnexo,false,false,0," multiple class='select'"):$sel_exp="<b>EL RADICADO PADRE NO ESTA INCLUIDO  EN UN EXPEDIENTE.</b>";

     //agrega nuevos destinatarios
    if($cc)
    {
            if(($nombre_us1 ) and  $direccion_us1 and $selMnpio and $selDepto)
            {
                    $isql = "select sgd_dir_tipo as NUM
                                     from   sgd_dir_drecciones
                                     where
                                     sgd_dir_tipo > 700 and sgd_anex_codigo='$codigo'
                                     order by sgd_dir_tipo desc";
                    $rsCC=$conn->Execute($isql);
                    if (!$rsCC->EOF)	$num_anexos = substr($rsCC->fields["NUM"],1,2);
                    $nurad = $radi;
                    if (!$conexion)	$conexion = new ConnectionHandler($ruta_raiz);
                    include "$ruta_raiz/radicacion/grb_direcciones.php";
                    if($cc=='AgregarDestinatario' && $error!=11 && $error!=12)$error=5;
                    else if($error!=11 && $error!=12) $error=10;
                   
            }
            else
            {
                    $error=6;
            }
    }

    ///datos a enviar
    $variables = "ent=$ent&radi=$radi&krd=$krd&".session_name()."=".trim(session_id())."&usua=$krd&contra=$drde&tipo=$tipo&ent=$ent&codigo=$codigo&numrad=$numrad&sololect=$sololect&radicado_rem=$radicado_rem&dir_codigo_us1=".$_GET['dir_codigo_us1']."&dir_codigo_us2=".$_GET['dir_codigo_us2']."&dir_codigo_us3=".$_GET['dir_codigo_us3']."&id_Dir_otro=$id_Dir_otro&tpradic=$tpradic";

    //otros usuarios
    if($id_Dir_otro)
    {
    	$sqlRenv="select sgd_dir_codigo, sgd_deve_fech, max(sgd_renv_codigo) as maximo from sgd_renv_regenvio where sgd_dir_codigo=".$id_Dir_otro." group by sgd_dir_codigo, sgd_deve_fech order by 3 desc ";
    	$ADODB_COUNTRECS=true;
    	$rsRenv=$conn->Execute($sqlRenv);
    	$ADODB_COUNTRECS=false;
    	$val=$rsRenv->RecordCount();
        $datos_otros_dir=$objOtro->obtieneDatosDir($id_Dir_otro);
	$datos_otros=$objOtro->obtieneDatosReales($id_Dir_otro);
        $datos_otros?$otro_dest="<span style='display: none' id='imgEdit[".$id_Dir_otro."]' ><img src='./imagenes/editar.png' width='20' height='20'></span><br>".$datos_otros_dir[0]["NOMBRE"]." - ".$datos_otros_dir[0]["APELLIDO"]."<br>".$datos_otros_dir[0]["DIRECCION"]."<br>".$datos_otros_dir[0]["DEPARTAMENTO"]."/".$datos_otros_dir[0]["MUNICIPIO"]."<br>"."Medio Envio: ".$datos_otros_dir[0]["MREC_DESC"]."&nbsp; ":0;
        if(!$val){
            $otro_dest.="<br><a href='nuevo_archivo.php?$variables&borrar=1&tpradic=$tpradic&radsalida=$radsalida'>Borrar</a>";
            $otro_dest.="<br><a href='javascript:pasarDatos(".$id_Dir_otro.")'>Modificar</a> &nbsp;&nbsp;";
        }
        else
        {
        	$rsRenv->fields['SGD_DEVE_FECH']?$otro_dest.="<b><br>(Devuelto)":$otro_dest.="<b><br>(Enviado)";
                $rsRenv->fields['SGD_DEVE_FECH']?$otro_dest.="<br><a href='javascript:pasarDatos(".$id_Dir_otro.")'>Modificar</a> &nbsp;&nbsp;":0;
        	$i_copias++;
                
        }
        $bandOtro=true;
       $vecDatosCC[$id_Dir_otro]["DIRIGIDOA"]=$datos_otros_dir[0]["APELLIDO"];
       $vecDatosCC[$id_Dir_otro]["DOCUMENTO"]=$datos_otros_dir[0]["DOCUMENTO"];
       $vecDatosCC[$id_Dir_otro]["NOMBRE"]=$datos_otros_dir[0]["NOMBRE"];
       $vecDatosCC[$id_Dir_otro]["DIRECCION"]=$datos_otros_dir[0]["DIRECCION"];
       $vecDatosCC[$id_Dir_otro]["TELEFONO"]=$datos_otros_dir[0]["TELEFONO"];
       $vecDatosCC[$id_Dir_otro]["MAIL"]=$datos_otros_dir[0]["MAIL"];
       $vecDatosCC[$id_Dir_otro]["COD_CONTINENTE"]=$datos_otros_dir[0]["COD_CONTINENTE"];
       $vecDatosCC[$id_Dir_otro]["COD_PAIS"]=$datos_otros_dir[0]["COD_PAIS"];
       $vecDatosCC[$id_Dir_otro]["COD_DEPARTAMENTO"]=$datos_otros_dir[0]["COD_DEPARTAMENTO"];
       $vecDatosCC[$id_Dir_otro]["COD_MUNICIPIO"]=$datos_otros_dir[0]["COD_MUNICIPIO"];
       $vecDatosCC[$id_Dir_otro]["MEDIO_ENVIO"]=$datos_otros_dir[0]["MEDIO_ENVIO"];
       $vecDatosCC[$id_Dir_otro]["SGD_DIR_TIPO"]=$datos_otros_dir[0]["SGD_DIR_TIPO"];
       $vecDatosCC[$id_Dir_otro]["SGD_DIR_CODIGO"]=$id_Dir_otro;
       $vecDatosCC[$id_Dir_otro]["SGD_CIU_CODIGO"]=$datos_otros_dir[0]["SGD_CIU_CODIGO"];
       $vecDatosCC[$id_Dir_otro]["SGD_OEM_CODIGO"]=$datos_otros_dir[0]["SGD_OEM_CODIGO"];
       $vecDatosCC[$id_Dir_otro]["SGD_ESP_CODI"]=$datos_otros_dir[0]["SGD_ESP_CODI"];
       $vecDatosCC[$id_Dir_otro]["SGD_DOC_FUN"]=$datos_otros_dir[0]["SGD_DOC_FUN"];
    }
    else $radicado_rem==1;
    include_once "$ruta_raiz/include/query/queryNuevo_archivo.php";
    $isql = $query1;
    $ADODB_COUNTRECS=true;
    $rs=$conn->Execute($isql);
    $ADODB_COUNTRECS=false;
    
    if($rs && $rs->RecordCount() > 0)
    {
        $otros_usuarios .="   <tr align='center' >
                                            <td CLASS=titulos2 >Documento</td>
                                            <td CLASS=titulos2 >Destinatario</td>
                                            <td CLASS=titulos2 >Dirigido a</td>
                                            <td CLASS=titulos2 >Direcci&oacute;n</td>
                                            <td CLASS=titulos2 >Telefeono</td>
                                            <td CLASS=titulos2 >Email</td>
                                            <td CLASS=titulos2 >Medio env&iacute;o</td>
                                            <td CLASS=titulos2 >Acci&oacute;n</td>
                                        </tr>";
        while(!$rs->EOF)
        {
            $sqlRenv="select sgd_dir_codigo, sgd_deve_fech from sgd_renv_regenvio where sgd_dir_codigo=".$rs->fields["SGD_DIR_CODIGO"];
            $sqlRenv="select sgd_dir_codigo, sgd_deve_fech, max(sgd_renv_codigo) as maximo from sgd_renv_regenvio where sgd_dir_codigo=".$rs->fields["SGD_DIR_CODIGO"]." group by sgd_dir_codigo, sgd_deve_fech order by 3 desc";
            $ADODB_COUNTRECS=true;
            $rsRenv=$conn->Execute($sqlRenv);
            $ADODB_COUNTRECS=false;
            $val=$rsRenv->RecordCount();
            $i_copias++;
            $ccDatos_dir=$objOtro->obtieneDatosDir($rs->fields["SGD_DIR_CODIGO"]);
            //$ccDatos=$objOtro->obtieneDatosReales($rs->fields["SGD_DIR_CODIGO"]);
            $rs2=$conn->Execute($isql);
            if($rs2 && !$rs2->EOF)
            {
                  $otros_usuarios .="   
                                        <tr>
                                        <td width='68' align='center' class='listado2'>&nbsp;
                                        	<span style='display: none' id='imgEdit[".$rs->fields["SGD_DIR_CODIGO"]."]' ><img src='./imagenes/editar.png' width='20' height='20'></span><font size=1>".$ccDatos_dir[0]["DOCUMENTO"]."</font>
                                        </td>
                                        <td class='listado2'>&nbsp;
                                        	<font size=1>".$ccDatos_dir[0]["NOMBRE"]."&nbsp;</font><font size=1>&nbsp;</font>
                                        </td>
                                        <td  class='listado2'>&nbsp;
                                        	<font size=1>".$ccDatos_dir[0]["APELLIDO"]."&nbsp;</font>
                                        </td>
                                       	<td align='center' class='listado2'>&nbsp;
                                        	<font size=1>".$ccDatos_dir[0]["DIRECCION"]."</font>
                                        </td>
                                        <td align='center' class='listado2'>&nbsp;
                                        	<font size=1>".$ccDatos_dir[0]["TELEFONO"]."</font>
                                        </td>
                                        <td width='68' align='center' class='listado2'>&nbsp;
                                        	<font size=1>".$ccDatos_dir[0]["MAIL"]."</font>
                                        </td>
                                        <td  class='listado2'>
                                                <font size=1>".$ccDatos_dir[0]["MREC_DESC"]."</font>
                                        </td>
                                        <td width='68' align='center' class='listado2'>&nbsp;
                                        
                                        <font size=1>";
                   if(!$val)
                   {
                       $otros_usuarios.="   <a href='nuevo_archivo.php?$variables&borrar=".$ccDatos_dir[0]["SGD_DIR_TIPO"]."&tpradic=$tpradic&radicado_rem=$radicado_rem&radsalida=$radsalida&id_Dir_otro=$id_Dir_otro'>Borrar</a>";
		       $otros_usuarios.="   <a href='javascript:pasarDatos(".$rs->fields["SGD_DIR_CODIGO"].")'>Modificar</a> &nbsp;&nbsp;";
                   }
                   else
                   {
                       $rsRenv->fields['SGD_DEVE_FECH']?$otros_usuarios.="(Devuelto)":$otros_usuarios.="(Enviado)";
		       $rsRenv->fields['SGD_DEVE_FECH']?$otros_usuarios.="   <a href='javascript:pasarDatos(".$rs->fields["SGD_DIR_CODIGO"].")'>Modificar</a> &nbsp;&nbsp;":0;
                       $i_copias=$i_copias-1;
                   }
                   $otros_usuarios.="   </font>
                                        </td>
                                        </tr>";
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["DIRIGIDOA"]=$ccDatos_dir[0]["APELLIDO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["DOCUMENTO"]=$ccDatos_dir[0]["DOCUMENTO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["NOMBRE"]=$ccDatos_dir[0]["NOMBRE"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["DIRECCION"]=$ccDatos_dir[0]["DIRECCION"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["TELEFONO"]=$ccDatos_dir[0]["TELEFONO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["MAIL"]=$ccDatos_dir[0]["MAIL"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["COD_CONTINENTE"]=$ccDatos_dir[0]["COD_CONTINENTE"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["COD_PAIS"]=$ccDatos_dir[0]["COD_PAIS"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["COD_DEPARTAMENTO"]=$ccDatos_dir[0]["COD_DEPARTAMENTO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["COD_MUNICIPIO"]=$ccDatos_dir[0]["COD_MUNICIPIO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["MEDIO_ENVIO"]=$ccDatos_dir[0]["MEDIO_ENVIO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["SGD_DIR_TIPO"]=$ccDatos_dir[0]["SGD_DIR_TIPO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["SGD_DIR_CODIGO"]=$rs->fields["SGD_DIR_CODIGO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["SGD_CIU_CODIGO"]=$ccDatos_dir[0]["SGD_CIU_CODIGO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["SGD_OEM_CODIGO"]=$ccDatos_dir[0]["SGD_OEM_CODIGO"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["SGD_ESP_CODI"]=$ccDatos_dir[0]["SGD_ESP_CODI"];
                   $vecDatosCC[$rs->fields["SGD_DIR_CODIGO"]]["SGD_DOC_FUN"]=$ccDatos_dir[0]["SGD_DOC_FUN"];
            }
            $rs->MoveNext();
        }
    }
    if($borrar && $i_copias<=-1 && !$bandOtro)
    {
        $upAnexo="update anexos set sgd_rem_destino=1, sgd_dir_tipo=1 where anex_codigo='$codigo'";
        $rsUpAnex=$conn->Execute($upAnexo);
        $radicado_rem=1;
    }
	$sqlMREC_ENV = "Select MREC_DESC, MREC_CODI from MEDIO_RECEPCION where MREC_ENV=1  ORDER BY 1";
    $rsMREC_ENV=$conn->Execute($sqlMREC_ENV );
    if($rsMREC_ENV) {
       $slcMREC_ENV=  $rsMREC_ENV->GetMenu2("med",0, "$opcMenu", false,"","class='select' " );
    }
    include("$ruta_raiz/include/class/Combos.Class.php");
    $obj= new Combos($ruta_raiz);
    $vecDatosJS=$obj->arrayToJsArray($vecDatosCC, "vecDatosCC");
	$continente=$obj->getContinentes(1);
}

else $error=9;
if($resp1=="OK") $error=2;
else if($resp1=="ERROR")$error=3;
$alert = '<tr bordercolor="#FFFFFF">
     	  <td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
switch ($error)
{	
	case 0:	//inicial
			$alert =" ";
			break;
	case 1:	//ERROR EJECUCCIÓN SQL
			$alert .="Error al cargar datos de tipos de anexos";
			break;
	case 2:	//ARCHIVO SUBIDO SATISFACTORIAMENTE
			$alert .="Archivo anexado correctamente";
               break;
	case 3:	//NO SUBIO EL ARCHIVO
			$alert .="Error al anexar archivos!";
               break;
	case 4:	//NO AENXO DESTINATARIO
			$alert .="NO ANEXO NING&Uacute;N DESTINATARIO";
               break;
    case 5:	//ANEXO DESTINATARIO
			$alert .="Ha sido agregado el destinatario.";
            break;
    case 6:	//NO ANEXO DESTINATARIO
			$alert .="No se pudo grabar otro destinatario, ya que faltan datos.(Los datos m&iacute;nimos de envio: Nombre, direccion, departamento, municipio)";
            break;
    case 7:	//Se borra otro destinatario linea 22.
			$alert .="Se borr&oacute; destinatario correctamente";
            break;
    case 8:	//Error borrando destnatario linea 22
			$alert .="Error Borrando destinatario";
            break;
    case 9:	//NO CONECCION A BD
			$alert .="Error al conectar a BD, comun&iacute;quese con el Administrador de sistema !!";
			break;
    case 10:	//NO CONECCION A BD
			$alert .="Destinatario modificado correctamente !!";
			break;
	 case 11:	//NO CONECCION A BD
			$alert .="!Error ingresando nuevo destinatario, Comuniquese con el administrador";
			break;
	 case 12:	//NO CONECCION A BD
			$alert .="!Error modificando destinatario, Comuniquese con el administrador";
			break;
    default:
      		$alert .="Actualizado correctamente";
}
	$alert .= '</td></tr>';
?>
<html>
<head>
<title>Informaci&oacute;n de Anexos</title>
<link rel="stylesheet" href="estilos/orfeo.css">
<script type="text/javascript" Language="JavaScript" SRC="js/crea_combos_2.js"></script>
<script type="text/javascript" language="JavaScript" src="js/funciones.js"></script>
<script type="text/javascript" language="JavaScript" src="js/ajax.js"></script>
<script type="text/javascript" language="JavaScript" SRC="js/formchek.js"></script>
<script type="text/javascript" language="javascript">
function habilitar()
{ <? if($chk){?>
  document.formulario.radicado_salida.checked=true;
  <?}?>
  <?if($dsbl){?>
  document.formulario.radicado_salida.disabled=true;
  <?}?>
   <?if($enviado==true){?>
  document.formulario.radicado_rem.disabled=true;
  <?}?>
   <?if($primero){?>
  document.formulario.radicado_salida.checked=true;
  document.formulario.tpradic.value=<?=$ent?>;
  <?}?>
  <? if(!$codigo){?>
     document.formulario.rusuario.checked=true;
  <? }?>
}
function mostrar(nombreCapa)
{
  document.getElementById(nombreCapa).style.display="";
}
function continuar_grabar(accion)
{	
	<? if(!$codigo){?>
    archivo=document.getElementById('userfile').value;
	if (archivo=="")
	{
              alert('Por favor escoja un archivo');
              return false;
	}
	<? } ?>
	if(!document.formulario.id_Dir_otro.value && document.getElementById("rotro").checked==true && !document.getElementById("documento_us1").value && !document.getElementById("tipo_emp_us1").value )
        {
                if(parseInt(document.getElementById("i_copias").value,10)<=0)
                {
                    alert("!!No agreg\xf3 ning\xFAn Destinatario!!")
                    return false;
                }
        }
        else if(accion.slice(0,22)=='Modificar Destinatario' && parseInt(document.getElementById("i_copias").value,10)<=0 && document.getElementById("rotro").checked==true)
        {
            alert("El destinatario no puede ser principal debido a  que\nlo registr\xF3 como copia y ya ha sido enviado, si desea\nagregar otro usuario como principal debera grabarlo\ncomo nuevo.");
            return false;
        }
        <? if($radsalida){?>
        archivo_up = document.getElementById('userfile').value;
        valor=0;
        lonExt= archivo_up.lastIndexOf('.')+1;
        extension = archivo_up.substr(lonExt).toLowerCase();
        if(document.getElementById('tipo_clase').value==14 && extension!='odt' && extension)
        {
                 alert("El archivo que escogi\363 debe ser de tipo ODT.");
                 document.getElementById('tipo_clase').disabled = true;
                 return false;
        }
        <?}?>
            
        if(document.formulario.direccion_us1.value=='')
        {
            alert("Debe llenar el campo direcci\xf3n");
            return false;
        }    
        if (!isEmail(trim(document.formulario.mail_us1.value),true))
        {   alert('El correo electr\xf3nico no es correcto.\n');
            return false;
        }
        if(!actualizar(accion))return false;
	document.formulario.tpradic.disabled=false;
	if(accion=='Agregar Destinatario'){
	document.formulario.action=document.formulario.action+"&cc=AgregarDestinatario";}
	else{
		document.formulario.action=document.formulario.action+"&cc=GrabarDestinatario";}
	document.formulario.submit();
}
function mostrarNombre(nombreCapa)
{
  document.formulario.elements[nombreCapa].style.display="";
}
function ocultarNombre(nombreCapa)
{
  document.formulario.elements[nombreCapa].style.display="none";
}
function ocultar(nombreCapa)
{
  document.getElementById(nombreCapa).style.display="none";
}

function Start(URL, WIDTH, HEIGHT)
{
 windowprops = "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=1020,height=500";
 preview = window.open(URL , "preview", windowprops);
}


function f_close(){
	//window.history.go(0);
	opener.regresar();
	window.close();
}

function regresar(){
    window.document.formulario.action="<?=$ruta_raiz?>/nuevo_archivo.php?codigo=<?=$codigo?>&<?="krd=$krd&".session_name()."=".trim(session_id()) ?>&usua=<?=$krd?>&numrad=<?=$verrad ?>&contra=<?=$drde?>&radi=<?=$verrad?>&tipo=<?=$tipo?>&ent=<?=$ent?><?=$variables?>&ruta_raiz=<?=$ruta_raiz?>&tpradic=<?=$tpradic?>&radicado_rem=<?=$radicado_rem?>&id_Dir_otro=<?=$id_Dir_otro?>&sol_lect=<?=$sol_lect?>&tipo=<?=$tipo?>";
    window.document.formulario.submit();
    //window.location.reload();
}
function escogio_archivo()
{ 
  var valor,lonExt;
  document.getElementById('tipo_clase').disabled = false;
  archivo_up = document.getElementById('userfile').value;
  valor=0;
  lonExt= archivo_up.lastIndexOf('.')+1;
  extension = archivo_up.substr(lonExt).toLowerCase();
<?
foreach($rs_tAnex_aux as $i)
{
         echo "
               if (extension=='".$i["ANEX_TIPO_EXT"]."')
                       {valor=".$i["ANEX_TIPO_CODI"].";
               }\n";
}
if($radsalida){
?>
        if(document.getElementById('tipo_clase').value==14 && valor!=14)
        {
             alert("El archivo que escogi\363 debe ser de tipo ODT.");
             document.getElementById('tipo_clase').disabled = true;
             document.getElementById('userfile').value='';
             return false;
        }
<?}?>
        document.getElementById('tipo_clase').value = valor;
        if(document.getElementById('radicado_salida').checked==true && valor!=14 && valor!=16)
        {
            alert("Atenci\363n. Si el archivo no es ODT o XML no podr\341 realizar combinaci\363n de correspondencia. \n\n otros archivos no facilitan su acceso");
            document.formulario.radicado_salida.checked=false;
            document.formulario.tpradic.value=0;
        }
        return true;
}



function actualizar(accion)
{
	retorno=true;
	msg='';
    if(!document.formulario.radicado_salida.checked && document.formulario.tpradic.value!=0)
    {
        msg+="\nDebe marcar 'Documento ser\xE1 radicado o quitar seleccion en \xABTipo de radicaci\xF3n\xBB'";
        retorno= false;
    }
    if(document.formulario.radicado_salida.checked)
    {
        if(document.formulario.tpradic.value==0)
        {
            msg+="\nDebe seleccionar un tipo de radicaci\xF3n";
            retorno= false;
        }
        if(document.formulario.descr.value.length <6)
        {
            msg+="\nDebe llenar el campo asunto con minimo 6 caracteres"+"(Digitos:"+document.formulario.descr.value.length+")";
            retorno= false;
        }
		var destino = document.getElementsByName('radicado_rem');
		if (destino[0].checked == false && destino[1].checked == false && destino[2].checked == false && destino[3].checked == false)
		{
			msg = msg + '\n' + "Debe seleccionar el tipo de destinatario.";
			retorno = false;
		} 
	}
    if(document.formulario.descr.value.length > 349)
 	{
 		msg+="\nDemasiados caracteres en el texto asunto, solo se permiten 350";
                retorno= false;
 	}
    if(document.getElementById("rusuario").checked==false && document.getElementById("rotro").checked==false)
    {
        <?php
        if($_GET['dir_codigo_us2'] && $_GET['dir_codigo_us3'])
        {
        ?>
        if(document.getElementById("rempre").checked==false && document.getElementById("rpredi").checked==false)
        {
           msg+="\nDebe seleccionar un destinatario";
            retorno= false;
        }
        <?php
        }
        ?>
        <?php
        if(!$_GET['dir_codigo_us2'] && !$_GET['dir_codigo_us3'])
        {
        ?>
        if(document.getElementById("rempre").checked==true || document.getElementById("rpredi").checked==true)
        {
           msg+="\nDebe seleccionar un destinatario";
            retorno= false;
        }
        <?php
        }
        ?>
    }
    if(accion.slice(0,10)=='ACTUALIZAR')
    {
        if(!document.formulario.id_Dir_otro.value && document.getElementById("rotro").checked==true)
        { 
            if(parseInt(document.getElementById("i_copias").value)<=0 && document.getElementById("rotro").checked==true)
            {
                msg+="\n!!No agreg\xf3 ning\xFAn Destinatario!!"
                retorno=false;
            }
        }
    }
    else
    {
        if(!document.formulario.id_Dir_otro.value && document.getElementById("rotro").checked==true && !document.getElementById("documento_us1").value && !document.getElementById("tipo_emp_us1").value )
            {
                if(parseInt(document.getElementById("i_copias").value,10)<=0)
                {
                    alert("!!No agreg\xf3 ning\xFAn Destinatario!!")
                    return false;
                }
            }
    }
<?php if(!$codigo){?>
    archivo=document.getElementById('userfile').value;
	if (archivo=="")
	{
		msg = msg + '\n' + 'Por favor escoja un archivo';
      	retorno = false;
	}
    else
    {
        if(retorno)
        {
            retorno = escogio_archivo();
        }
    }
<?php }
  else{?>
    archivo=document.getElementById('userfile').value;
	if (archivo!="" && retorno)
	{
            retorno = escogio_archivo();
        }
    else if(document.getElementById('tipo_clase').value != 14)
    {
        document.formulario.radicado_salida.checked=false;
        document.formulario.tpradic.value=0
    }
<?php }?>
    document.formulario.radicado_salida.disabled=false;
    if(document.formulario.radicado_salida.checked)document.formulario.radicado_salida.value=1;
    else document.formulario.radicado_salida.value=0;
    document.formulario.tpradic.disabled=false;
    if (msg!='') alert(msg);
    return retorno;
}

var divAutilizar;

function pedirCombosDivipola(fuenteDatos, divID,tipo,continente,pais,departamento,municipio)
{
	if(xmlHttp)
	{
		// obtain a reference to the <div> element on the page
		divAutilizar = document.getElementById(divID);
		try
		{
			xmlHttp.open("GET", fuenteDatos+"?tipo="+tipo+"&continente="+continente+"&pais="+pais+"&departamento="+departamento+"&municipio="+municipio);
			xmlHttp.onreadystatechange = handleRequestStateChange;
			xmlHttp.send(null);
		}
		//display the error in case of failure
		catch (e)
		{
			alert("Can't connect to server:\n" + e.toString());
		}
	}
}
//handles the response received from the server
function readResponse()
{
	// read the message from the server
	var xmlResponse = xmlHttp.responseText;
	// display the HTML output
        if(xmlResponse.lastIndexOf('@1')==-1)
            divAutilizar.innerHTML = xmlResponse+'<font color="Red" >*</font>';
        else
        {
        	if(document.getElementById('DivPais') && document.getElementById('DivDepto') && document.getElementById('DivMnpio'))
        	{
	            document.getElementById('DivPais').innerHTML=xmlResponse.substring(0,xmlResponse.lastIndexOf('@1'))+'<font color="Red" >*</font>';
	            document.getElementById('DivDepto').innerHTML=xmlResponse.substring(xmlResponse.lastIndexOf('@1')+2,xmlResponse.lastIndexOf('@2'))+'<font color="Red" >*</font>';
	            document.getElementById('DivMnpio').innerHTML=xmlResponse.substring(xmlResponse.lastIndexOf('@2')+2,xmlResponse.length)+'<font color="Red" >*</font>';
        	}
        	else
        	{
        		pedirCombosDivipola('cCombos.php', 'NA','todos',1,170,11,1);
        	}
        }

}
function mostrarForm()
{
	var tipifica = document.formulario.radicado_salida.checked;
	if(tipifica)
		document.getElementById("anexaExp").style.display = 'block';
	else
		document.getElementById("anexaExp").style.display = 'none';
            
}
function verMedioEnvio(rad,tip,anex)
{
	var anchoPantalla = screen.availWidth;
    var altoPantalla  = screen.availHeight;
	window.open('<?=$ruta_raiz?>/envios/cambiarMedioEnvio.php?krd=<?=$krd?>&numRad='+rad+'&tip='+tip+'&anex_codi='+anex,'Cambio Medio Envio', 'top='+(altoPantalla/3)+',left='+(anchoPantalla/3)+', height='+(altoPantalla*0.20)+', width='+(anchoPantalla*0.37)+', scrollbars=yes,resizable=yes')
}
function pasarDatos(dir)
{
        document.formulario.cc_documento_us1.value=vecDatosCC[dir]["DOCUMENTO"];
        document.formulario.nombre_us1.value=vecDatosCC[dir]["NOMBRE"];
        document.formulario.otro_us7.value=vecDatosCC[dir]["DIRIGIDOA"];
        document.formulario.direccion_us1.value=vecDatosCC[dir]["DIRECCION"];
        document.formulario.telefono_us1.value=vecDatosCC[dir]["TELEFONO"];
        document.formulario.mail_us1.value=vecDatosCC[dir]["MAIL"];
        document.formulario.med.value=vecDatosCC[dir]["MEDIO_ENVIO"];
        document.formulario.selCont.value=vecDatosCC[dir]["COD_CONTINENTE"];
        pedirCombosDivipola('cCombos.php', 'NA','todos',vecDatosCC[dir]["COD_CONTINENTE"],vecDatosCC[dir]["COD_PAIS"],vecDatosCC[dir]["COD_DEPARTAMENTO"],vecDatosCC[dir]["COD_MUNICIPIO"]);
        document.formulario.med.value=vecDatosCC[dir]["MEDIO_ENVIO"];
        document.formulario.sgd_dir_tipo.value=vecDatosCC[dir]["SGD_DIR_TIPO"];
        document.formulario.sgd_dir_codigo_cc.value=vecDatosCC[dir]["SGD_DIR_CODIGO"];
        if(vecDatosCC[dir]["SGD_CIU_CODIGO"]){
            document.formulario.tipo_emp_us1.value=0;
            document.formulario.documento_us1.value=vecDatosCC[dir]["SGD_CIU_CODIGO"];
        }
        else if(vecDatosCC[dir]["SGD_OEM_CODIGO"]){
            document.formulario.tipo_emp_us1.value=2;
            document.formulario.documento_us1.value=vecDatosCC[dir]["SGD_OEM_CODIGO"];
        }
        else if(vecDatosCC[dir]["SGD_ESP_CODI"]){
            document.formulario.tipo_emp_us1.value=1;
            document.formulario.documento_us1.value=vecDatosCC[dir]["SGD_ESP_CODI"];
        }
        else if(vecDatosCC[dir]["SGD_DOC_FUN"]){
            document.formulario.tipo_emp_us1.value=6;
            document.formulario.documento_us1.value=vecDatosCC[dir]["SGD_DOC_FUN"];
        }
        document.getElementById('btnModificar').style.display='inline';
        if(dirAct)
            document.getElementById('imgEdit['+dirAct+']').style.display='none';
        
        document.getElementById('imgEdit['+dir+']').style.display='inline';
        dirAct=dir;    
}
var dirAct;
setTimeout("pedirCombosDivipola('cCombos.php', 'NA','todos',1,170,11,1)",0);
<?=$vecDatosJS?>
</script>
</head>
<body bgcolor="#FFFFFF" topmargin="0">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="js/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript"><!--
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "formulario", "fecha_doc","btnDate1","",scBTNMODE_CUSTOMBLUE);
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<form enctype="multipart/form-data" method="post" name="formulario" id="formulario" action='upload2.php?<?=$variables?>'>
<input type="hidden" name="usua" value="<?=$usua?>">
<input type="hidden" name="contra" value="<?=$contra?>">
<input type="hidden" name="anex_origen" value="<?=$tipo?>">
<input type="hidden" name="tipo" value="<?=$tipo?>">
<input type="hidden" name="tipoLista" value="<?=$tipoLista?>">
<input type="hidden" name="krd" value="<?=$krd?>">
<input type="hidden" name="id_Dir_otro" value="<?=$id_Dir_otro?>">
<input type="hidden" name="i_copias" id="i_copias" value="<?=$i_copias?>">
<input type="hidden" name="tipoDocumentoSeleccionado" value="<?php echo $tipoDocumentoSeleccionado ?>">
<input type="hidden" name="radicado_rem_ori" value="<?php echo $radicado_rem ?>">

<input type=hidden name=sgd_dir_codigo_cc id=sgd_dir_codigo_cc class=tex_area size=3 value='' >
<input type=hidden name=tipo_emp_us1 id=tipo_emp_us1 class=tex_area size=3 value='' >
<input type=hidden name=documento_us1 id=documento_us1 class=tex_area size=3 value='' >
<input type=hidden name="idcont1" id="idcont1" value='' class=e_cajas size=4 >
<input type=hidden name="idpais1" id="idpais1" value='' class=e_cajas size=4 >
<input type=hidden name="codep_us1" id="codep_us1" value='' class=e_cajas size=4 >
<input type=hidden name="muni_us1" id="muni_us1"  value='' class=e_cajas size=4 >
<input type=hidden name="prim_apel_us1" id="prim_apel_us1"  value='' class=e_cajas size=4 >
<input type=hidden name="seg_apel_us1" id="seg_apel_us1"  value='' class=e_cajas size=4 >
<input type="hidden" name="sgd_dir_tipo" id="sgd_dir_tipo" value="<?php echo $sgd_dir_tipo ?>">
<div align="center">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
<tr>
    <td  height="25" align="center" class="titulos4" colspan="5">DESCRIPCI&Oacute;N DEL DOCUMENTO</td>
</tr>
<tr>
    <td class="titulos2" height="25" align="left" colspan="5" > ATRIBUTOS </td>
</tr>
<tr>
    <td  colspan="5">
        <table border=0 width=100%  >
        <tr>
            <td width="20"  colspan="5" class="listado2">Tipo de anexo:
                <?echo $sel_tAnex?>
            </td>
        </tr>
        <tr>
             <td class="listado2" colspan="2"><input type="checkbox" class="select" name="radicado_salida" value="1" id="radicado_salida">Este documento ser&aacute; radicado</td>
             <td class="listado2" colspan="3">Tipos de radicaci&oacute;n: &nbsp;
             	<?echo $sel_tRad;?>
             </td>
        </tr>
        <tr valign="top" >
           <td class="listado2" ><b>Descripci&oacute;n o asunto</b></td>
           <td class="listado2" colspan="4">
                <textarea name="descr" cols="35" rows="4" class="tex_area" id="descr"><?=$descr?></textarea>
            </td>
        </tr>
        <tr>
	        <td class="listado2"><b>Adjuntar archivo</b></td>
		    <td class="listado2" colspan="2"><input name="userfile1" type="file" class="tex_area"  size="43" onChange="escogio_archivo();" id="userfile" value="valor"></td>
		    <td class="listado2" colspan="2"><input type="checkbox" class="select"  name="sololect" id="sololect" value='1' <?=$solec?>>Solo lectura</td>
		</tr>
        <tr>
            <td class="titulos2"  colspan="5" >DESTINATARIO</td>
        </tr>
        <tr valign="top" >
            <td  valign="top" class="listado2" colspan="3" >
                <input type="radio"   name="radicado_rem"  value=1  id="rusuario" <?=$datoss1;echo $enviado?> <?php if($radicado_rem==1) echo " checked ";?> >
                <?=$tip3Nombre[1][$ent]?>
                <br>
                <?=$otro_us11." - ".substr($nombret_us11,0,35)?>
                <br>
                <?=$direccion_us11?>
                <br>
                <?="$dpto_nombre_us11/$muni_nombre_us11"?>
            </td>
            <td  valign="top" class="listado2" colspan="2">
                <input type="radio" name="radicado_rem" id="rempre"  value=3 <?=$datoss3;echo $enviado?> <?php  if($radicado_rem==3){echo " checked ";}?>>
                <?=$tip3Nombre[3][$ent]?>
                <br>
                <?=substr($nombret_us3,0,35)?>
                <br>
                <?=$direccion_us3?>
                <br>
                <?="$dpto_nombre_us3/$muni_nombre_us3"?><br>
                </td>
                <?php if($mrec_dest3){?><br>
                Medio Envio: <?=$mrec_dest3?>
                <?php }?>
         </tr>
         <tr valign="top">
            <td valign="top" class="listado2" colspan="3">
                <input type="radio" name="radicado_rem" id="rpredi"  value=2  <?=$datoss2;echo $enviado?> <?php  if($radicado_rem==2){echo " checked ";}  ?>>
				<?=$tip3Nombre[2][$ent]?><br>
				<?=$otro_us2." - ".substr($nombret_us2,0,35)?>
				<br>
				<?=$direccion_us2?>
				<br>
				<?="$dpto_nombre_us2/$muni_nombre_us2"?>
                                <?php if($mrec_dest2){?><br>
                                Medio Envio: <?=$mrec_dest2?>
                                <?php }?>
            </td>
            <td  valign="top" class="listado2" colspan="2">
                    <input type="radio" name="radicado_rem"  value=7 id="rotro" <?=$datoss4;echo $enviado?> <?php  if($radicado_rem==7)echo " checked ";  ?>  id="rotro">
                    Otro:<?=$otro_dest?>
            </td>
         </tr>
         
         <tr valign="top">
            <td valign="top" class="titulos2" colspan="5">
                <input type="radio" name="estado" id="restado"  value=4> <b>Seleccione este campo si el documento es de uso Interno (SGC).</b>				
            </td>
         </tr>
         
        </table>
    </td>
</tr>
</table>
</div>
<div align="center">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab" >
<tr>
    <td class='celdaGris'  colspan="2">
    <font size="1">
        <table  width="100%" border="0" cellpadding="0" cellspacing="5" class="borde_tab"  id='tbl_otros'>
        <tr>
            <td width="100%" class='titulos2' colspan="4" > <font size="1" class="etextomenu"><center>
                OTRO DESTINATARIO
                </center></font>
            </td>
            <td width="25%" class='titulos2' colspan="4">
                <input type="button" name="Button" value="BUSCAR" class="botones" onClick="Start('<?=$ruta_raiz?>/radicacion/buscar_usuario.php?busq_salida=true&nombreTp3=<?=$nombreTp3?>&krd=<?=$krd?>',1024,500);">
            </td>
        </tr>
        
        <tr>
            <td width="100%" colspan="8" > 
                <table border="1" width="100%">
                    <tbody>
                        <tr>
                            <td class="titulos2">Destinatario</td>
                            <td class="listado2"> <input type=text name=nombre_us1 value=''  size=100 class=tex_area readonly></td>
                            <td class="titulos2">Documento</td>
                            <td class="listado2"><input type=text name=cc_documento_us1 value='' class=e_cajas size=14 readonly ></td>
                        </tr>
                        <tr>
                            <td class="titulos2">Dirigido a</td>
                            <td class="listado2" colspan="3"><input type=text name=otro_us7 value='' class=tex_area   size=100 maxlength="45"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="titulos2">Direcci&oacute;n</td>
                            <td class="listado2"><input type=text name=direccion_us1 value='' class=tex_area  size=100 ></td>
                            <td class="titulos2">Tel&eacute;fono</td>
                            <td class="listado2"><input type=text name=telefono_us1 value='' class=tex_area  size=14 ></td>
                        </tr>
                        <tr >
                            <td class="titulos2">Continente</td>
                            <td class="listado2"><?php echo $continente;?><font color="Red" >*</font></td>
                            <td class="titulos2">Pa&iacute;s</td>
                            <td class="listado2"><div id="DivPais"><select class="select" id="selPais"><option value="0">&lt;&lt Seleccione &gt;&gt</select><font color="Red" >*</font></div></td>
                        </tr>
                        <tr >
                            <td class="titulos2">Departamento</td>
                            <td class="listado2"><div id="DivDepto"><select class="select" id="selDepto"><option value="0">&lt;&lt Seleccione &gt;&gt</select><font color="Red" >*</font></div></td>
                            <td class="titulos2">Municipio</td>
                            <td class="listado2"><div id="DivMnpio"><select class="select" id="selMnpio"><option value="0">&lt;&lt Seleccione &gt;&gt</select><font color="Red" >*</font></div></td>
                        </tr>
                        <tr>
                            <td class="titulos2">Medio env&iacute;o</td>
                            <td class="listado2"><?=$slcMREC_ENV?></td>
                            <td class="titulos2">Email</td>
                            <td class="listado2"><input type=text name=mail_us1 value='' class=tex_area size=15 ></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>      
        <tr>
            <td colspan="8" class="listado2" align="center">
                <center>
                    <input type="button" name="cc" value="Agregar destinatario" class="botones_mediano"  onClick="document.formulario.i_copias.value=1;document.formulario.sgd_dir_codigo_cc.value='';continuar_grabar(this.value);" >
                    <span id="btnModificar" style="display: none"><input type="button" name="cc" value="Modificar Destinatario" class="botones_mediano"  onClick="continuar_grabar(this.value);" ></span>
                </center>
            </td>
        </tr>
        <?php
        echo $otros_usuarios;
        ?>
        </table>
    </font>
    </td>
</tr>
<tr>
	<td colspan="5"><?= $alert?></td>
</tr>
<tr>
	<td class='celdaGris' align="center" ><font size="1"> <input name="button" type="submit" class="botones_largo" onClick="return actualizar(this.value)" value="ACTUALIZAR <?=$codigo?>"></font></td>
	<td > <input type='button' class ='botones' value='CERRAR' onclick='f_close()'></td>
</tr>
</table>
</div>
<input name="usuar" type="hidden" id="usuar" value="<?php echo $usuar ?>"><br>
<input name="predi" type="hidden" id="predi" value="<?php echo $predi ?>">
<input name="empre" type="hidden" id="empre" value="<?php echo $empre ?>">
</form>
</td>
</tr>
</table>
<script>setTimeout("habilitar()", 0);</script>
</body>
</html>
