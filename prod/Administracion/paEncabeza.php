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

/*Modificaciones
       Julian Andres Ortiz Moreno
       3213006681:
       julecci@gmail.com // cuadre de estilos

*/
?>
<?php
    $krdOld = $krd;
	$carpetaOld = $carpeta;
	$tipoCarpOld = $tipo_carp;
	//session_start();
	error_reporting(0);	
	if(!$krd) $krd=$krdOsld;
	if(!$dependencia or !$tpDepeRad) include "$ruta_raiz/rec_session.php";
	include_once "$ruta_raiz/include/db/ConnectionHandler.php";
	$db = new ConnectionHandler($ruta_raiz);	 
	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
	$nomcarpetaOLD = $nomcarpeta;

		if (!$carpeta) 
		{
		  $carpeta = "0";
		  $nomcarpeta = "Entrada";
		}
?>
<table border="0" cellpad="2" cellspacing="0" width="100%" class="borde_tab" valign="top" align="center">
  <tr>
    <td width='35%' >
      <table width='100%' border='0' cellspacing='1' cellpadding='0'>
        <tr>
            <td class=titulos2 width='35%'>
                 Listado De:
            </td>
        </tr>
		<tr class="info">
          <td height="20"><?=$nomcarpeta?></td>
        </tr>
      </table>
    </td>
     <td width='35%' >
      <table width='100%' border='0' cellspacing='1' cellpadding='0'>
        <tr> 
          <td  class="titulos2">USUARIO </td>
        </tr>
		<tr class="info">
          <td height="20" ><?=$usua_nomb?></td>
        </tr>
      </table>
    </td>
	<?
    if (!$swBusqDep)  {
    ?>
 	<td width="33%">
	    <table width='100%' border='0' cellspacing='1' cellpadding='0'>
        <tr> 
          <td class="titulos2">DEPENDENCIA</td>
        </tr>
		<tr class="info">
          <td  ><?=$depe_nomb?></td>
        </tr>
      </table>
     </td>
	<?
    } else {
    ?>
	<td width="35%">
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
     <tr class="info" >
    	<td class="titulos2">DEPENDENCIA</td>
        </tr>
		<tr>
		  <form name=formboton action='<?=$pagina_actual?>?<?=session_name()."=".session_id()."&krd=$krd" ?>&estado_sal=<?=$estado_sal?>&estado_sal_max=<?=$estado_sal_max?>&pagina_sig=<?=$pagina_sig?>&dep_sel=<?=$dep_sel?>&nomcarpeta=<?=$nomcarpeta?>' method=post>	
			<td height="1">
<?		
			include_once "$ruta_raiz/include/query/envios/queryPaencabeza.php";			
 			$sqlConcat = $db->conn->Concat($db->conn->substr."($conversion,1,5) ", "'-'",$db->conn->substr."(depe_nomb,1,30) ");
			$sql = "select $sqlConcat ,depe_codi from dependencia where depe_estado=1 order by depe_codi";
			$rsDep = $db->conn->Execute($sql);
			if(!$depeBuscada) $depeBuscada=$dependencia;
			print $rsDep->GetMenu2("dep_sel","$dep_sel",false, false, 0," onChange='submit();' class='select' id='dep_sel'");
?>			
		      </td>
                      <?php
                      if($_REQUEST["trans"])
                        {
                           echo '<input type="hidden" name="trans" value="1">';
                          }
                          ?>
 		  </form>
		</tr>
      </table>
    </td>

	<?
    } 
    ?>

  </tr>
</table>
