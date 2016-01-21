<?php


if (!$ruta_raiz) 	$ruta_raiz = "..";

$permArchi     = $_SESSION["permArchi"];
$permVobo      = $_SESSION["permVobo"];
$permRespuesta = $_SESSION["usua_perm_respuesta"];

//Eliminamos aquellos elementos que no son convenientes en el Get
$pattern 		= '/[^\w:()áéíóúÁÉÍÓÚ=#°,.ñÑ]+/';
$rad_asun_res 	= preg_replace($pattern, ' ', $rad_asun_res);
?>
<link rel="stylesheet" type="text/css" href="<?=$ruta_raiz?>/js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="<?=$ruta_raiz?>/js/spiffyCal/spiffyCal_v2_1.js"></script>


<!--Incio Script para adjuntar y excluir radicados del carrito -->
<script language="javascript">
    function returnKrd(){
        return '<?=$krd?>';
    }    
</script>

  <script type="text/javascript" src="<?=$ruta_raiz?>/js/jquery-1.4.2.min.js"></script>
  <script type="text/javascript" src="<?=$ruta_raiz?>/js/grabRadSessCarrito.js"></script>
  <!--Fin Script para adjuntar y excluir radicados del carrito -->
  <script language="javascript">       
  setRutaRaiz ('<?=$ruta_raiz?>');   
  <!--
  <?
  // print ("El control agenda en tx($controlAgenda");
  $ano_ini = date("Y");
  $mes_ini = substr("00".(date("m")-1),-2);
  if ($mes_ini==0) {$ano_ini==$ano_ini-1; $mes_ini="12";}
  $dia_ini = date("d");
  if(!$fecha_ini) $fecha_ini = "$ano_ini/$mes_ini/$dia_ini";
    $fecha_busq = date("Y/m/d") ;
  if(!$fecha_fin) $fecha_fin = $fecha_busq;
  ?>//-->
</script>

<?php
require_once("$ruta_raiz/pestanas.js");
 /**  TRANSACCIONES DE DOCUMENTOS
   *  @depsel number  contiene el codigo de la dependcia en caso de reasignacion de documentos
   *  @depsel8 number Contiene el Codigo de la dependencia en caso de Informar el documento
   *  @carpper number Indica codigo de la carpeta a la cual se va a mover el documento.
   *  @codTx   number Indica la transaccion a Trabajar. 8->Informat, 9->Reasignar, 21->Devlver
  */


?>
<script language="JavaScript" type="text/JavaScript">
  // Variable que guarda la ultima opcion de la barra de herramientas de funcionalidades seleccionada
  seleccionBarra = -1;
  <!--
  function MM_swapImgRestore() { //v3.0
    var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
  }
  
  function MM_preloadImages() { //v3.0
    var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
      var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
      if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
  }
  
  function MM_findObj(n, d) { //v4.01
    var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
      d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
    if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
    for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
    if(!x && d.getElementById) x=d.getElementById(n); return x;
  }
  
  function MM_swapImage() { //v3.0
    var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
      if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
  }
  //-->
</script>

<script>    
function vistoBueno()
{

    changedepesel(9);
    document.getElementById('EnviaraV').value = 'VoBo';
    envioTx();
}

function devolver()
{
    changedepesel(12);
    envioTx();
}
function txAgendar()
{
    if (!validaAgendar('SI'))
      return;
  changedepesel(14);
    envioTx();
}
function txNoAgendar()
{
    changedepesel(15);
    envioTx();
}
function archivar()
{
    changedepesel(13);
    envioTx();
}
function nrr()
{
    changedepesel(16);
    envioTx();
}
function tipificar(){
  changedepesel(19);
  envioTx();

}
  function masivaTRD(){
  sw=0;
  var radicados = new Array();
  var list = new Array();
  for(i=1;i<document.form1.elements.length;i++){
    if (document.form1.elements[i].checked && document.form1.elements[i].name!="checkAll") {
    sw++;
    valor = document.form1.elements[i].name;
    valor = valor.replace("checkValue[", "");
    valor = valor.replace("]", "");
    radicados[sw] = valor;
    list.push(valor);
    };
  };
  window.open("accionesMasivas/masivaAsignarTrd.php?<?=session_name()?>=<?=session_id()?>&krd=<?=$krd?>&radicados=" + list, "Masiva_Asignaci�n_TRD", "height=650,width=750,scrollbars=yes");
};

function masivaIncluir(){
  sw=0;
    var list = new Array();
    var radicados = new Array();
    for(i=1;i<document.form1.elements.length;i++){
      if (document.form1.elements[i].checked && document.form1.elements[i].name!="checkAll") {
        sw++;
        valor = document.form1.elements[i].name;
        valor = valor.replace("checkValue[", "");
        valor = valor.replace("]", "");
        radicados[sw] = valor;
        list.push(valor);
};
 window.open("accionesMasivas/masivaIncluirExp.php?<?=session_name()?>=<?=session_id()?>&krd=<?=$krd?>&radicados=" + list, "Masiva_IncluirExp", "height=650,width=750,scrollbars=yes");
    		};  	
     };   	    	   
       
  
  function envioTx()
  {
      sw=0;
      <?
      if(!$verrad)
      {
      ?>
    for(i=1;i<document.form1.elements.length;i++)
    if (document.form1.elements[i].checked && document.form1.elements[i].name!="checkAll")
        sw=1;
    if (sw==0)
    {
    alert ("Debe seleccionar uno o mas radicados");
    return;
    }
    <?
    }
    ?>
      document.form1.submit();
  }




    function respuestaTx(){
        var valor = sw = 0;
        var params      = 'width='+screen.width;
            params      += ', height='+screen.height;
            params      += ', top=0, left=0'
            params      += ', scrollbars=yes'
            params      += ', fullscreen=yes';

      <?if(!$verrad){?>
            for(i=1;i<document.form1.elements.length;i++){
                if (document.form1.elements[i].checked && document.form1.elements[i].name!="checkAll"){
                    sw++;
                    valor = document.form1.elements[i].name;
                    valor = valor.replace("checkValue[", "");
                    valor = valor.replace("]", "");
                }
            }

            if (sw != 1){
                alert("Debe seleccionar UN(1) radicado");
                return;
            }
 

            var url         = "respuestaRapida/index.php?<?=session_name()?>=" +
                              "<?=session_id()?>&radicadopadre=" +
                                + valor + "&krd=<?=$krd?>";
           window.open(url, "Respuesta Rapida", params);

      <?}else{?>
            window.open("respuestaRapida/index.php?<?=session_name()?>=<?=session_id()?>&radicado=" + 
                        '<?php print_r($verrad) ?>' + "&radicadopadre=" + '<?php print_r($verrad) ?>' + 
                        "&asunto=" + '<?php print_r($rad_asun_res)?>' + 
                        "&krd=<?=$krd?>", "Respuesta Rapida", params);
      <?}?>
    }


    function respuestaTx2(){
        var valor = sw = 0;
        var params      = 'width='+screen.width;
            params      += ', height='+screen.height;
            params      += ', top=0, left=0'
            params      += ', scrollbars=yes'
            params      += ', fullscreen=yes';

      <?if(!$verrad){?>
            for(i=1;i<document.form1.elements.length;i++){
                if (document.form1.elements[i].checked && document.form1.elements[i].name!="checkAll"){
                    sw++;
                    valor = document.form1.elements[i].name;
                    valor = valor.replace("checkValue[", "");
                    valor = valor.replace("]", "");
                }
            }

            if (sw != 1){
                alert("Debe seleccionar UN(1) radicado");
                return;
            }


            var url         = "respuestaRapida/index2.php?<?=session_name()?>=" +
                              "<?=session_id()?>&radicadopadre=" +
                                + valor + "&krd=<?=$krd?>";
           window.open(url, "Respuesta Rapida", params);

      <?}else{?>
            window.open("respuestaRapida/index2.php?<?=session_name()?>=<?=session_id()?>&radicado=" +
                        '<?php print_r($verrad) ?>' + "&radicadopadre=" + '<?php print_r($verrad) ?>' +
                        "&asunto=" + '<?php print_r($rad_asun_res)?>' +
                        "&krd=<?=$krd?>", "Respuesta Rapida", params);
      <?}?>
    }








  function window_onload()
  {
      document.getElementById('depsel').style.display = 'none';
    // document.getElementById('Enviara').style.display = '';
      document.getElementById('depsel8').style.display = 'none';
      document.getElementById('carpper').style.display = 'none';
      document.getElementById('Enviar').style.display = 'none';
  
    // document.getElementById('movera_r').style.display = 'none';
    // document.getElementById('reasignar_r').style.display = 'none';
    // document.getElementById('reasignar_r').style.display = 'none';
    // document.getElementById('informar_r').style.display = 'none';
    // document.getElementById('informar').style.display = '';
      //changedepesel(9);
      <?
      if(!$verrad)
      {
      }
      else
      {
      ?>
      window_onload2();
      <?
      }
      if($carpeta==11 and $_SESSION['codusuario']==1){
          echo "document.getElementById('salida').style.display = ''; ";
        echo "document.getElementById('enviara').style.display = ''; ";
      echo "document.getElementById('Enviar').style.display = ''; ";
        }ELSE{
          echo " ";
      }
        if($carpeta==11 and $_SESSION['codusuario']!=1){
        echo "document.getElementById('enviara').style.display = 'none'; ";
        echo "document.getElementById('Enviar').style.display = 'none'; ";
      }
    ?>
  }
  function optionSelect(control){
    var seleccionados=document.getElementById("seleccion");
    if(control.selected){
      selecionados.value= selecionados.value+","+control.value;
    }else{
          var posicion=selccionados.value.indexOf(control.value);
      if(posicion!=-1){
      selccionados.value=selccionados.value.substr(0,posicion)+selccionados.value.substr(posicion+control.value.length);
    }
      }
  }
</script>

<body onload="MM_preloadImages('<?=$ruta_raiz?>/imagenes/internas/overVobo.gif','<?=$ruta_raiz?>/imagenes/internas/overNRR.gif','<?=$ruta_raiz?>/imagenes/internas/overMoverA.gif','<?=$ruta_raiz?>/imagenes/internas/overReasignar.gif','<?=$ruta_raiz?>/imagenes/internas/overInformar.gif','<?=$ruta_raiz?>/imagenes/internas/overDevolver.gif','<?=$ruta_raiz?>/imagenes/internas/overArchivar.gif')"><table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
<!--DWLayoutTable-->
<?php
/* Si esta en la Carpeta de Visto Bueno no muesta las opciones de reenviar
 *
*/
if (($mostrar_opc_envio==0) || ($_SESSION['codusuario'] == $radi_usua_actu && $_SESSION['dependencia'] == $radi_depe_actu)) {
?>
        <tr>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="1200" height=28 valign="bottom">
<?php
if ($controlAgenda==1)
{	//Si el esta consultando la carpeta de documentos agendados entonces muestra el boton de sacar de la agenda
	if ($agendado)
	{	 	echo ("<input name='Submit2' type='button' class='botones_mediano' value=' Sacar de La Agenda &gt;&gt;' onClick='txNoAgendar();'>");
	}
	else
	{	echo(" ");
?>
			<script language="javascript">
				var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "form1","fechaAgenda","btnDate1","",scBTNMODE_CUSTOMBLUE);
		 		dateAvailable.date = "2003-08-05";
				dateAvailable.writeControl();
				dateAvailable.dateFormat="yyyy-MM-dd";
			</script>
			<input name="Submit2" type="button" class="botones" value="Agendar &gt;&gt;" onClick='txAgendar();'>
<?php
}	}
if ($nomcarpeta)
{
?>		</td>
<!-- INICIO Permisos de acciones masivas  -->
					<?PHP	echo	'<td width="25" valign="bottom">
			             <img name="principal_r4_c3" src=".//imagenes/internas/principal_r4_c3.gif" border="0" alt="" height=51 ></td>'; 
				
                        if ($accMasiva_trd != 1 and !$verradPermisos or $_GET["nomcarpeta"]) {
                        	echo '<td valign="bottom">
                        		<a href= "#" title="Asignar TRD" onmouseOver="document.ejemplo1.src=\''.$ruta_raiz.'/imagenes/internas/masTRDO.gif\';" onClick="masivaTRD();" onmouseOut="document.ejemplo1.src=\''.$ruta_raiz.'/imagenes/internas/masTRD.gif\';"><img name="ejemplo1"  alt="Asignar Trd masiva" src=\''.$ruta_raiz.'/imagenes/internas/masTRD.gif\'  border="0" ></a>
                        	 </td>';
                        }
                        if ($accMasiva_prestamo == 1) {
                        	echo '<td valign="bottom">
                        		<a href= "#" title="Solicitud prestamo" onmouseOver="document.ejemplo2.src=\''.$ruta_raiz.'/imagenes/internas/masPrestO.gif\';" onClick="masivaPrestamo();" onmouseOut="document.ejemplo2.src=\''.$ruta_raiz.'/imagenes/internas/masPrest.gif\';"><img name="ejemplo2" src=\''.$ruta_raiz.'/imagenes/internas/masPrest.gif\' border="0" height=51></a>
                        	  </td>';
                        }
                        
                        if ($accMasiva_temas == 1) {
                        	echo '<td valign="bottom">
                        			<a href= "#" title="Asignar Sector y Tema" onmouseOver="document.ejemplo3.src=\''.$ruta_raiz.'/imagenes/internas/masTemaO.gif\';" onClick="masivaTemaSector();" onmouseOut="document.ejemplo3.src=\''.$ruta_raiz.'/imagenes/internas/masTema.gif\';"><img name="ejemplo3" src=\''.$ruta_raiz.'/imagenes/internas/masTema.gif\' ></a>
                          </td>';
                        }
                        
                        if ($accMasiva_incluir != 1 and !$verradPermisos or $_GET["nomcarpeta"] ) {
                        	echo '<td valign="bottom">
                        			<a href= "#" title="Incluir radicado en expediente" onmouseOver="document.ejemplo4.src=\''.$ruta_raiz.'/imagenes/internas/masInclO.gif\';" onClick="masivaIncluir();" onmouseOut="document.ejemplo4.src=\''.$ruta_raiz.'/imagenes/internas/masIncl.gif\';"><img name="ejemplo4" src=\''.$ruta_raiz.'/imagenes/internas/masIncl.gif\' border="0"></a>
                        	 </td>';
                        }
					?>
					<!-- FIN Permisos de acciones masivas  --> 
<?php
}
if (!$agendado) {
		
?>
	<!--	<td width="25" valign="bottom">
			<img name="principal_r4_c3" src="<?=$ruta_raiz?>/imagenes/internas/principal_r4_c3.gif" width="25" height="51" border="0" alt="">		</td> --> 
       
	
        <td  valign="bottom">
        	<a href="#" onMouseOut="MM_swapImgRestore()" onClick="seleccionBarra = 10;changedepesel(10);" onMouseOver="MM_swapImage('Image8','','<?=$ruta_raiz?>/imagenes/internas/overMoverA.gif',1)">
        	<img src="<?=$ruta_raiz?>/imagenes/internas/moverA.gif" name="Image8" border="0" height=53  ></a>		</td>
		<td  valign="bottom">
			<a href="#" onMouseOut="MM_swapImgRestore()" onClick="seleccionBarra = 9;changedepesel(9);" onMouseOver="MM_swapImage('Image9','','<?=$ruta_raiz?>/imagenes/internas/overReasignar.gif',1)">
			<img src="<?=$ruta_raiz?>/imagenes/internas/reasignar.gif" name="Image9" border="0" height=53  ></a>		</td>
		<td  valign="bottom">
			<a href="#" onMouseOut="MM_swapImgRestore()" onClick="seleccionBarra = 8;changedepesel(8);" onMouseOver="MM_swapImage('Image10','','<?=$ruta_raiz?>/imagenes/internas/overInformar.gif',1)">
			<img src="<?=$ruta_raiz?>/imagenes/internas/informar.gif" name="Image10" border="0"></a>		</td>
		<td  valign="bottom">
			<a href="#" onMouseOut="MM_swapImgRestore()" onClick="seleccionBarra = 12;changedepesel(12);" onMouseOver="MM_swapImage('Image11','','<?=$ruta_raiz?>/imagenes/internas/overDevolver.gif',1)">
			<img src="<?=$ruta_raiz?>/imagenes/internas/devolver.gif" name="Image11"  border="0" height=56></a>		</td>
	<?php
	if (($_SESSION['depe_codi_padre'] && $_SESSION['codusuario']==1) || $_SESSION['codusuario']!=1) {
		if(!empty($permVobo) && $permVobo != 0) {
	?>
		<td valign="bottom"><a href="#" onmouseout="MM_swapImgRestore()" onclick="seleccionBarra = 14;vistoBueno();" onmouseover="MM_swapImage('Image12','','<?=$ruta_raiz?>/imagenes/internas/overVobo.gif',1)"><img src="<?=$ruta_raiz?>/imagenes/internas/vobo.gif" name="Image12" height="51" border="0" /></a></td>
    <?
    		}
	}
	?>
		<?php
		   if(!empty($_SESSION["usua_perm_trdmasiva"]) && $_SESSION["usua_perm_trdmasiva"]!=0 ){
		   	?>
			<td  valign="bottom">
			                        <a href="#" onMouseOut="MM_swapImgRestore()" onClick="seleccionBarra = 19;tipificar();" onMouseOver="MM_swapImage('Image19','','<?=$ruta_raiz?>/imagenes/internas/tipificarA.gif',1)">
						                        <img src="<?=$ruta_raiz?>/imagenes/internas/tipificar.gif" name="Image19" border="0"></a></td>
		  <?php  }

			if(!empty($permArchi) && $permArchi != 0) {
			?>
		<td valign="bottom">
			<a href="#" onMouseOut="MM_swapImgRestore()" onClick="seleccionBarra = 13;changedepesel(13);" onMouseOver="MM_swapImage('Image13','','<?=$ruta_raiz?>/imagenes/internas/overArchivar.gif',1)">
			<img src="<?=$ruta_raiz?>/imagenes/internas/archivar.gif" name="Image13" border="0" height=55></a>		</td>
		<?php
			}
			/*if($codusuario == 1){
			?>
		<td width="61" valign="bottom"><a href="#" onmouseout="MM_swapImgRestore()" onclick="seleccionBarra = 14;changedepesel(16);" onmouseover="MM_swapImage('Image14','','<?=$ruta_raiz?>/imagenes/internas/overNRR.gif',1)"><img src="<?=$ruta_raiz?>/imagenes/internas/NRR.gif" name="Image14" width="61" height="51" border="0" /></a></td>
		<?php
		}*/
	}
?>
	</tr>
	</table>
	</td>
<tr/>
<?
}
/* Final de opcion de enviar para carpetas que no son 11 y 0(VoBo)
*/
?>
<tr>
	<td colspan="3" >
	<table BORDER=0   WIDTH=100%  align='center' class="borde_tab"  >
	<tr class=titulos2>
		<td width='40%'>
		<? if ($controlAgenda==1 || $permRespuesta == 1){ ?>
			<table width="100%"  border="0" cellpadding="0" cellspacing="5" class="titulos2">
			<tr>
				<td width="15%" class="titulos2">LISTAR POR: </td>
				<td width="60%" class="titulos2">
					<a href='<?=$ruta_raiz?>/cuerpo.php?<?=$encabezado."7&orderTipo=DESC&orderNo=10"; ?>' alt='Ordenar Por Leidos'>
					<span class='leidos'>Le&iacute;dos</span></a><?=$img7 ?>&nbsp;
					<a href='<?=$ruta_raiz?>/cuerpo.php?<?=$encabezado."8&orderTipo=ASC&orderNo=10" ?>' alt='Ordenar Por Le&iacute;dos' class="tparr"><span class='no_leidos'>No le&iacute;dos</span></a>
				</td>
                <td width='30%'class="titulos2">
                    <? if ($permRespuesta == 1) { ?>
                    <input type="button" value="Respuesta Rapida" 
                    onClick="respuestaTx()" width="100" name="asignatem" align="bottom" 
                    class="botonesNew" id="asignatem">
                    <? } ?>
		<? if ($permRespuesta == 1) { ?>
                    <center> <input type="button" value="RR / Doc"
                    onClick="respuestaTx2()" width="100" name="asignatem" align="bottom"
                    class="botonesNew" id="asignatem"></center>
                    <? } ?>

                </td>				
			</tr>
			</table>
			<?}?>
		</td>
<?php
/* si esta en la Carpeta de Visto Bueno no muesta las opciones de reenviar
*/
if (($mostrar_opc_envio==0) || ($_SESSION['codusuario'] == $radi_usua_actu && $_SESSION['dependencia'] == $radi_depe_actu))
{
?>
		<td width='55%'  align="right" class="titulos2"  >
	<?php
	$row1 = array();
	// Combo en el que se muestran las dependencias, en el caso  de que el usuario escoja reasignar.
	$dependencianomb=substr($dependencianomb,0,35);
  if($db->driver=="ARMADA"){
    $subDependencia = $db->conn->substr ."(".$db->conn->Concat("depe_nomb").",0,80)";
  }else{
     $subDependencia = $db->conn->substr ."(depe_nomb,0,80)";
  }
	if($_SESSION["codusuario"]!=1 && $_SESSION["usuario_reasignacion"] !=1)
	{
	  $whereReasignar = " where depe_codi = $dependencia and depe_estado = 1";
	}
	else
	{
	  $whereReasignar = "where depe_estado = 1";
	}
	$sql = "select $subDependencia, depe_codi from DEPENDENCIA $whereReasignar ORDER BY DEPE_NOMB";
	$rs = $db->query($sql);
	print $rs->GetMenu2('depsel',$dependencia,false,false,0," id=depsel class=select ");
	// genera las dependencias para informar
	$row1 = array();

	$dependencianomb=substr($dependencianomb,0,35);
        $subDependencia = $db->conn->substr ."(".$db->conn->Concat($db->conn->IfNull('DEP_SIGLA', "'XT'"),"' - '","depe_nomb").",0,50)";
       
	$subDependencia = $db->conn->substr ."(depe_nomb,0,80)";
	$sql = "select $subDependencia, depe_codi from DEPENDENCIA ORDER BY DEPE_NOMB";
	$rs = $db->conn->Execute($sql);
	print $rs->GetMenu2('depsel8[]',$dependencia,false,true,5," id='depsel8' class='select' ");
	// Aqui se muestran las carpetas Personales

	$dependencianomb=substr($dependencianomb,0,35);
	$datoPersonal = "(Personal)";
	$nombreCarpeta = $db->conn->Concat("' $datoPersonal'",'nomb_carp');
	$codigoCarpetaGen = $db->conn->Concat("10000","cast(carp_codi as varchar(10))");
	$codigoCarpetaPer = $db->conn->Concat("11000","cast(codi_carp as varchar(10))");
	$sql = "select carp_desc  as nomb_carp
			,$codigoCarpetaGen as carp_codi, 0 as orden
			from carpeta
			where carp_codi <> 11
			union
			select $nombreCarpeta as nomb_carp
			,$codigoCarpetaPer as carp_codi
			,1 as orden
			from carpeta_per
			where
			usua_codi = $codusuario
			and depe_codi = $dependencia
			order by orden, carp_codi";
	$rs = $db->conn->Execute($sql);
	print $rs->GetMenu2('carpSel',1,false,false,0," id=carpper class=select ");

	// Fin de Muestra de Carpetas personales
	?>
		<INPUT TYPE=hidden name=enviara value=9>
		<INPUT TYPE=hidden name=EnviaraV id=EnviaraV value=''>
		</td>
		<td width='5%' align="right">
			<input type="button" value='>>1' name="Enviar" id="Enviar" valign='middle' class='botones_2' onClick="envioTx();">
			<input type="hidden" name="codTx" value=9>
		</td>
<?php
/* Fin no mostrar opc_envio*/
}
?>
</TR>
</TABLE>
<?php
/**  FIN DE VISTA DE TRANSACCIONES
  *
  *
  */
?>
