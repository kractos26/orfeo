<table width="100%" bgcolor="#FFFFFF" id=mod_tipodocumento>
<form name="form_tipo_doc" method="post" action="../verradicado.php?<?=session_name()?>=<?=trim(session_id())?>">
  <input type=hidden name=ver_tipodoc value="Si ver tipo de Documento">
  <input type=hidden name=verrad value='<?=$verrad ?>'>

  <?php 
error_reporting(7); 
$ruta_raiz = ".";
include "$ruta_raiz/config.php";
include "$ruta_raiz/san_noti/class.php"; 
error_reporting(7);
$cursor = ora_open($handle);

$sal = new SANC_NOTI($cursor); 
$sal->radicado = $verrad;
       $sal->mostrar_select("SGD_TRS_RESOLUCION","resolucion_new",$cursor,"SGD_TRS_CODIGO","SGD_TRS_DESCRIPT",0);
//$sal->mostrar_select("SGD_TNT_TNoTIFICCN","notificacion_new",$cursor,"SGD_TNT_CODIGO","SGD_TNT_DESCRIPT",0);  
  //include "config.php";
  ?>
  <tr>
      <td bgcolor='#cccccc' ALIGN='RIGHT' width="27%"><span class='etexto'>Tipo de Resoluci&oacute;n</td>
      <td colspan="3" width="73%" class="celdaGris"> 
	  <? 
         $sal->mostrar_select("SGD_TRS_RESOLUCION","resolucion_new",$cursor,"SGD_TRS_CODIGO","SGD_TRS_DESCRIPT",0);

	   ?>
	   <input type=submit name=grabar_tipo value='Grabar Cambio' class='ebuttons2'>
</td> 
  </tr>
	<tr>
      <td bgcolor='#cccccc' ALIGN='RIGHT' width="27%"><span class='etexto'> Numero 
        / Fecha</span></td>
      <td class="celdaGris"  colspan="3" width="73%" >&nbsp; </td>
    </tr>
  <tr>
      <td bgcolor='#cccccc' ALIGN='RIGHT' width="27%"><span class='etexto'>Tipo de Notificación</span></td>
      <td class="celdaGris"  colspan="3" width="73%">
	  <? 
         $sal->mostrar_select("SGD_TNT_TNoTIFICCN","notificacion_new",$cursor,"SGD_TNT_CODIGO","SGD_TNT_DESCRIPT",0);  
	   ?>	   </td>
    </tr><tr>
      <td bgcolor='#cccccc' ALIGN='RIGHT' width="27%"><span class='etexto'> N&uacute;mero 
        / fecha</span></td>
      <td class="celdaGris"  colspan="3" width="73%">&nbsp; </td>
    </tr>
	<tr>
      <td width="27%" colspan="2" class="celdaGris"> 
        <input type="hidden" name="PHPSESSID" value="<?=session_id() ?>" />
	<input type="hidden" name="grabar" value="si">
	<center>
          <input type=hidden name=cod_tmp_new value='<?=$cod_tmp_new ?>'>
	 </center>
</td></tr>
</form>
</table>

