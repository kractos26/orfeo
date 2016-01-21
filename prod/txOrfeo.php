<?
 include "pestanas.js";
 /**  TRANSACCIONES DE DOCUMENTOS
   *  @depsel number  contiene el codigo de la dependcia en caso de reasignacion de documentos
   *  @depsel8 number Contiene el Codigo de la dependencia en caso de Informar el documento
   *  @carpper number Indica codigo de la carpeta a la cual se va a mover el documento.
   *  @codTx   number Indica la transaccion a Trabajar. 8->Informat, 9->Reasignar, 21->Devlver
   */
?>
<script>
function envioTx()
{
   document.form1.submit();
}
function window_onload()
{
   document.getElementById('depsel').style.display = '';
   document.getElementById('Enviara').style.display = '';
   document.getElementById('depsel8').style.display = 'none';
   document.getElementById('carpper').style.display = 'none';
   document.getElementById('movera_r').style.display = 'none';
   document.getElementById('reasignar_r').style.display = 'none';
   document.getElementById('reasignar_r').style.display = 'none';
   document.getElementById('informar_r').style.display = 'none';
   document.getElementById('informar').style.display = '';
   changedepesel(9);
     <?php
     if($carpeta==11 and $codusuario==1){
        echo "document.getElementById('salida').style.display = ''; ";
	    echo "document.getElementById('enviara').style.display = ''; ";
		echo "document.getElementById('Enviar').style.display = ''; ";
      }ELSE{
	      echo " ";
	  }
  	  if($carpeta==11 and $codusuario!=1){
		 echo "document.getElementById('enviara').style.display = 'none'; ";
		 echo "document.getElementById('Enviar').style.display = 'none'; ";
	  }
  ?>
}
</script>
   <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
   <!--DWLayoutTable-->
   <?
	/* Si esta en la Carpeta de Visto Bueno no muesta las opciones de reenviar
	 *
	 */
	 if($mostrar_opc_envio==0)
	 {
	?>
	  <tr> 
		<td   valign="bottom" width="68%" height="33"> <a href=# onClick="changedepesel(21);"><font size="1">
		  <script language="javascript">
			dateAvailable.date = "2003-08-05";
			dateAvailable.writeControl();
			dateAvailable.dateFormat="yyyy-MM-dd";
		  </script>
		  </font></a>
			<input align="top" type="button" value='agendar' name=agendar  valign='middle' class='ebuttons2' id=agendar onClick="f_agendar('SI');">
            <input align="top" type="button" value='sacar de la agenda' name=no_agendar  valign='middle' class='ebuttons2' id=no_agendar onClick="f_agendar('NO');">
            </td>
            <td valign="bottom" align="right" width="11%" rowspan="2"> <font color="#0000ff">&nbsp; 
            </font> </td>
            <td valign="bottom" align="right" width="21%" rowspan="2">
            <input align="top" type=button value='Devolver' name=Enviara  valign='middle' class='ebuttons2' id=Enviara onClick="changedepesel(21);">
            <?
			 if (($depe_codi_padre and $codusuario==1) or $codusuario!=1)
				{
				?>
              <input type=submit value='VoBo' name=EnviaraV id=Enviar  class='ebuttons2'>
              <?
				}
			  ?>
              <input type=submit value='Archivar' name=salida id=salida align=bottom class=ebuttons2>
            </td>
          </tr>
          <tr>
          <td   valign="bottom" width="68%"><a href=# onClick="changedepesel(10);" ><img src="imagenes/moverA.gif" height="25"  border=0 width="110" id=movera><img src="imagenes/moverA_R.gif"
height="25" border=0 width="110" id=movera_r></a><a href=# onClick="changedepesel(9);" ><img src="imagenes/reasignar.gif" border=0 width="110" height="25" id=reasignar><img
src="imagenes/reasignar_R.gif" id=reasignar_r  border=0 width="110" height="25"></a><a href=# onClick="changedepesel(8);"><img align="baseline" src="imagenes/informar.gif" border=0  id=informar><img
src="imagenes/informar_R.gif" border=0 id=informar_r></a><font color="#0000ff">&nbsp; 
          </font></td>
          </tr>
          <?
		   }
		   /* Final de opcion de enviar para carpetas que no son 11 y 0(VoBo)
		    */
		 ?>
          <tr>
            <td  height="59" colspan="3" bgcolor="#CCCCCC"> 
              <table BORDER=0  cellpad=2 cellspacing='2' WIDTH=98%  align='center' class="t_bordeGris" cellpadding="2">

                <tr> 
                  <td width='94%'   class="grisCCCCCC" >
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                      <tr> 
                        <td width="11%"><img src="imagenes/listar.gif" width="73" height="20"></td>
                        <td width="89%"> <a href='cuerpo.php?<?=session_name()."=".trim(session_id()).$encabezado."7&ordcambio=1"; ?>' alt='Ordenar Por Leidos'><span class='tpar'>Leídos 
                          </span></a> 
                          <?=$img7 ?>
                          <a href='cuerpo.php?<?=session_name()."=".trim(session_id()).$encabezado."8&ordcambio=1" ?>' alt='Ordenar Por Leidos' class="tparr"><span class='tparr'> 
                          No Leídos</span></a></td>
                      </tr>
                    </table>
                  </td>
                  <?
		    /* si esta en la Carpeta de Visto Bueno no muesta las opciones de reenviar
			   */
			if($mostrar_opc_envio==0)
			{
		?>
                  
        <td width='94%'  align="right" class="grisCCCCCC" > 
          <?
	//ora_commiton($handle);
	//$cursor = ora_open($handle);
    //ora_parse($cursor,"select depe_codi,depe_nomb from DEPENDENCIA ORDER BY DEPE_NOMB");
	//ora_exec($cursor);
    //$numerot = ora_numrows($cursor);
	$row1 = array();
	//$result1=ora_fetch_into($cursor,$row1, ORA_FETCHINTO_NULLS|ORA_FETCHINTO_ASSOC);
	// Combo en el que se muestran las dependencias, en el caso  de que el usuario escoja reasignar.
	?>
          <?
	$dependencianomb=substr($dependencianomb,0,35);
	$subDependencia = $db->conn->substr ."(depe_nomb,0,50)";
	if($codusuario!=1)
	{
	  $whereReasignar = " where depe_codi = $denpendencia";
	}
	else
	{
	  $whereReasignar = "";
	}
	$sql = "select 
			$subDependencia
			, depe_codi 
			from DEPENDENCIA 
			$whereReasignar
			ORDER BY DEPE_NOMB";
    $rs = $db->conn->Execute($sql);
    print $rs->GetMenu('depsel',$dependencia,false,false,0," id=depsel class=ebuttons2 ");
	  // genera las dependencias para informar
	     //ora_parse($cursor,"select depe_codi,depe_nomb from DEPENDENCIA ORDER BY DEPE_NOMB");
		 $row1 = array();

	$dependencianomb=substr($dependencianomb,0,35);
	$subDependencia = $db->conn->substr ."(depe_nomb,0,50)";
	$sql = "select 
			$subDependencia
			, depe_codi 
			from DEPENDENCIA 
			ORDER BY DEPE_NOMB";
    $rs = $db->conn->Execute($sql);
    print $rs->GetMenu2('depsel8',$dependencia,false,false,0," id=depsel8 class=ebuttons2 ");
	 // Aqui se muestran las carpetas Personales
	 
	$dependencianomb=substr($dependencianomb,0,35);
	$datoPersonal = "(Personal)";
	$nombreCarpeta = $db->conn->Concat('nomb_carp',"' $datoPersonal'");
	//$db->conn->debug = false;
	$sql = "select carp_desc  as nomb_carp, carp_codi as codi_carp,0 as orden 
	        from carpeta
	        union
			select
			 $nombreCarpeta
			 ,codi_carp 
			 ,1 as orden			 
			 from carpeta_per 
			 where
			   usua_codi = $codusuario
			   and depe_codi = $dependencia
		    order by orden, carp_codi
					 ";
    $rs = $db->conn->Execute($sql);
    print $rs->GetMenu2('carpper',1,false,false,0," id=carpper class=ebuttons2 ");


	  // genera las dependencias para informar
	     //ora_commiton($handle);
	     //$cursor = ora_open($handle);
	     //ora_parse($cursor,"select depe_codi,depe_nomb from DEPENDENCIA ORDER BY DEPE_NOMB");
  		 //ora_exec($cursor);
	 // Fin de Muestra de Carpetas personales

	 ?>
         <INPUT TYPE=hidden name=enviara value=9>
          </td>
          <td width='6%' align="right" class="grisCCCCCC" > 
            <input type=button value='ENVIAR' name=Enviar id=Enviar valign='middle' class='ebuttons2' onClick="envioTx();">
			<input type=hidden name=codTx value=9>
          </td>
          <?
    /* Fin no mostrar opc_envio*/
    }
  ?>
        </TR>
      </TABLE>
  <?
/**  FIN DE VISTA DE TRANSACCIONES
  *
  *
  */
?>
