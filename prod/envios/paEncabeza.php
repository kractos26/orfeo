<?php
    $krdOld = $krd;
	$carpetaOld = $carpeta;
	$tipoCarpOld = $tipo_carp;
	session_start();
	error_reporting(7);	
	if(!$krd) $krd=$krdOsld;
	if(!$_SESSION['dependencia'] or !$_SESSION['tpDepeRad']) include_once("$ruta_raiz/rec_session.php");
	include_once "$ruta_raiz/include/db/ConnectionHandler.php";
	$db = new ConnectionHandler($ruta_raiz);	 
	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
	$nomcarpetaOLD = $nomcarpeta;
	if (!isset($_GET['carpeta']))
	{
	  $carpeta = "0";
	  $nomcarpeta = "Entrada";
	}
?>
<table BORDER=0  cellpad=2 cellspacing='0' WIDTH=100% class='borde_tab' valign='top' align='center' >
  <tr>
    <td width='35%' >
      <table width='100%' border='0' cellspacing='1' cellpadding='0'>
        <tr> 
          <td class=titulos2 width='35%'>LISTADO DE:</td>
        </tr>
		<tr class="info">
          <td height="20"><?=$_GET['nomcarpeta']?></td>
        </tr>
      </table>
    </td>
     <td width='35%' >
      <table width='100%' border='0' cellspacing='1' cellpadding='0'>
        <tr> 
          <td class="titulos2">USUARIO</td>
        </tr>
		<tr class="info">
          <td height="20" ><?=$_SESSION['usua_nomb']?></td>
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
          <td height="20" ><?=$_SESSION['depe_nomb']?></td>
        </tr>
      </table>
     </td>
	<?
    } else {
    ?>
	<td width="35%">
    <table width="100%" border="0" cellspacing="5" cellpadding="0">
     <tr class="info" >
    	<td class="titulos2" >DEPENDENCIA</td>
        </tr>
		<tr>
		<form name=formboton action='<?=$pagina_actual?>?<?=session_name()."=".session_id()."&krd=$krd" ?>&estado_sal=<?=$estado_sal?>&estado_sal_max=<?=$estado_sal_max?>&pagina_sig=<?=$pagina_sig?>&dep_sel=<?=$dep_sel?>&nomcarpeta=<?=$nomcarpeta?>' method=post>		  		
		<td height="1">
		<?		
		include_once "$ruta_raiz/include/query/envios/queryPaencabeza.php";			
		$sqlConcat = $db->conn->Concat("dep_sigla", "'-'",$db->conn->substr."(depe_nomb,1,30) ");
                if($_SESSION["usua_perm_impresion"]==2){
                    /*
                     * select depe_codi,depe_nomb from dependencia where depe_codi in (select depe_codi from impusrrel where usua_doc='1019014153')
                     */
                    $DepFilt=" and depe_codi in (select depe_codi from impusrrel where usua_doc='".$_SESSION["usua_doc"]."') ";
                    $DepFiltPager=" and dep.depe_codi in (select depe_codi from impusrrel where usua_doc='".$_SESSION["usua_doc"]."') ";
                }
		$sql = "select $sqlConcat ,depe_codi from dependencia where depe_estado=1 $DepFilt
						order by 1";
		$rsDep = $db->conn->Execute($sql);
		if(!$depeBuscada) $depeBuscada=$dependencia;
		print $rsDep->GetMenu2("dep_sel","$dep_sel","9999:TODAS LAS DEPENDENCIAS", false, 0," onChange='submit();' class='select'");
?>			
		</td>
		 	  </form>
		</tr>
      </table>
    </td>

	<?
    } 
    ?>

  </tr>
</table>