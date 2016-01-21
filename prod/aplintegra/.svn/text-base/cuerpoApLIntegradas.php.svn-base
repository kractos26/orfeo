<?
session_start();
if (!$ruta_raiz)
	$ruta_raiz = "..";
if (!$dependencia)   include "$ruta_raiz/rec_session.php";
$phpsession = "nsesion=".session_id();
?>
<html>
<head>
<script>
function abrirFuncion(url){

		window.open(url,"Opcion",'top=0,scrollbars=yes,resizable=yes');
       	
}
       
</script>
<title>Editar Firmantes</title>
<link rel="stylesheet" href="<?=$ruta_raiz?>/estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF" topmargin="0" >
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="js/spiffyCal/spiffyCal_v2_1.css">
<?
 
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
error_reporting(7);
 $db = new ConnectionHandler("$ruta_raiz");	 
 //$db->conn->debug = true;
 $accion_sal = "Funciones de aplicativos integrados";
 $nomcarpeta = "Funciones de aplicativos integrados";
 //$pagina_sig = "firmarDocumentos.php";
 

 
 
 
 if ($orden_cambio==1)  {
 	if (!$orderTipo)  {
	   $orderTipo=" DESC";
	}else  {
	   $orderTipo="";
	}
 }
 
 	if (!$orderNo)  {
	   		$orderNo=0;
			$orderTipo=" desc ";
	}

	if($busqRadicados)
	{
   
    $busqRadicados = trim($busqRadicados);
    $textElements = split (",", $busqRadicados);
    $newText = "";
	$dep_sel = $dependencia;
    foreach ($textElements as $item)
    {
         $item = trim ( $item );
         if ( strlen ( $item ) != 0)
		 {
 	        $busqRadicadosTmp .= " fr.radi_nume_radi like '%$item%' or";
		 }
    }
	if(substr($busqRadicadosTmp,-2)=="or")
	{
	 $busqRadicadosTmp = substr($busqRadicadosTmp,0,strlen($busqRadicadosTmp)-2);
	}
	if(trim($busqRadicadosTmp)) 
	{
	 $whereFiltro .= "and ( $busqRadicadosTmp ) ";
	}

	}
	 

 $encabezado = "".session_name()."=".session_id()."&ruta_raiz=$ruta_raiz&krd=$krd&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&orderTipo=$orderTipo&radicado=$radicado&orderNo=";
 $linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";
 $carpeta = "nada";
 include "../envios/paEncabeza.php";
 $pagina_actual = $PHP_SELF;


 


	/*  GENERACION LISTADO DE RADICADOS
	 *  Aqui utilizamos la clase adodb para generar el listado de los radicados
	 *  Esta clase cuenta con una adaptacion a las clases utiilzadas de orfeo.
	 *  el archivo original es adodb-pager.inc.php la modificada es adodb-paginacion.inc.php
	 */
error_reporting(7);

?>
  <form name=formEnviar action='' method=post>
  
 <?


	//include "$ruta_raiz/include/query/firma/queryCuerpoPendientesFirma.php";
	//$db->conn->debug = true;
	$query= " select a.SGD_APLI_DESCRIP,a.SGD_APLI_CODI, f.SGD_APLFAD_MENU,f.SGD_APLFAD_LK1 from 
					SGD_APLI_APLINTEGRA a ,
				  SGD_APLUS_PLICUSUA  u,
				  SGD_APLFAD_PLICFUNADI f
		           where u.USUA_DOC = '$usua_doc' and a.SGD_APLI_CODI<> 0 and  a.SGD_APLI_CODI =  u.SGD_APLI_CODI 
		           and f.SGD_APLI_CODI = a.SGD_APLI_CODI
				 ";
	
	$rs=$db->conn->Execute($query);
	$codApli=-1;
	$codApliNext = -2;
	if (!$rs->EOF)  {
		$codApli = $rs->fields['SGD_APLI_CODI'];
		while (!$rs->EOF){
			$aplicacion = strtoupper( $rs->fields['SGD_APLI_DESCRIP']);
			$menu = strtoupper( $rs->fields['SGD_APLFAD_MENU']);
			$link =  $rs->fields['SGD_APLFAD_LK1'];
			if ($codApliNext != $codApli){
				$codApliNext = $codApli;
				echo ("<table width='40%' align='center' border='0' cellpadding='0' cellspacing='5' class='borde_tab'>");
				echo ( "<tr> 
      					<td height='25' class='titulos4' align='center' > 
        				$aplicacion
      					</td>
    					</tr>");
			}
			
				echo (" <tr align='center'> 
      				<td class='listado2' > 
        			<a href=\"javascript:abrirFuncion('$link&$phpsession&usuario=$krd')\" class='vinculos'  target='mainFrame'>$menu</a>
      			    </td>
    				</tr> ");
   				
   				$rs->MoveNext();
				$codApliNext = $rs->fields['SGD_APLI_CODI'];
				
				if ($codApliNext != $codApli)
					echo ("</table>
					       <BR>");
			   
			}
	} 
	else{
		echo "<hr><center><b>NO se encontro nada con el criterio de busqueda</center></b></hr>";	
	}
	
 ?>
  </form>

</body>

</html>

