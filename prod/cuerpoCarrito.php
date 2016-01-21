<?php
session_start();
    /**
        * Paggina Cuerpo.php que muestra el contenido de las Carpetas
        * Creado en la SSPD en el año 2003
        * 
        * Se añadio compatibilidad con variables globales en Off
        * @autor Jairo Losada 2009-05
        * @licencia GNU/GPL V 3
    */
    include 'config.php';
    foreach ($_GET as $key => $valor)   ${$key} = $valor;
    foreach ($_POST as $key => $valor)   ${$key} = $valor;
    
    $nomcarpeta="Carrito de Documentos";
    $_GET['nomcarpeta']="Radicados seleccionados";
    define('ADODB_ASSOC_CASE', 2);
    
    $krd            = $_SESSION["krd"];
    $dependencia    = $_SESSION["dependencia"];
    $usua_doc       = $_SESSION["usua_doc"];
    $codusuario     = $_SESSION["codusuario"];
    $tip3Nombre     = $_SESSION["tip3Nombre"];
    $tip3desc       = $_SESSION["tip3desc"];
    $tip3img        = $_SESSION["tip3img"];
    $ESTILOS_PATH = $_SESSION["ESTILOS_PATH"];
    $ruta_raiz      = ".";
    if(!isset($_SESSION['dependencia'])) include "./rec_session.php";
    error_reporting(7);
    $verrad = "";
    $_SESSION['numExpedienteSelected'] = null;
?>
<html>
    <head>
        <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css" />
        <script src="js/popcalendar.js"></script>
        <script src="js/mensajeria.js"></script>
        <div id="spiffycalendar" class="text"></div>
    </head>
    
    <? include "./envios/paEncabeza.php"; ?>
    
    <body bgcolor="#FFFFFF" topmargin="0" onLoad="window_onload();">
    <?
    	include_once "./include/db/ConnectionHandler.php";
    	require_once("$ruta_raiz/class_control/Mensaje.php");
    	if (!$db) $db = new ConnectionHandler($ruta_raiz);
    	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);

    	$objMensaje= new Mensaje($db);
    	$mesajes = $objMensaje->getMsgsUsr($_SESSION['usua_doc'],$_SESSION['dependencia']);
    
        if ($swLog==1) 	echo ($mesajes);
    	if(trim($orderTipo)=="") $orderTipo="DESC";
        
        if($orden_cambio==1)
    	{
    	  if(trim($orderTipo)!="DESC")
    		{
    		   $orderTipo="DESC";
    		}else
    		{
    			$orderTipo="ASC";
    		}
    	}
    
    	if($busqRadicados){
            $busqRadicados = trim($busqRadicados);
            $textElements = split (",", $busqRadicados);
            $newText = "";
        	$dep_sel = $dependencia;
            foreach ($textElements as $item)
            {
                 $item = trim ( $item );
                 if ( strlen ( $item ) != 0)
        		 {
         	        $busqRadicadosTmp .= " b.radi_nume_radi like '%$item%' or";
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
        
        $encabezado = "".session_name()."=".session_id()."&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&chkCarpeta=$chkCarpeta&busqRadicados=$busqRadicados&nomcarpeta=$nomcarpeta&agendado=$agendado&";
        $linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";
        $encabezado = "".session_name()."=".session_id()."&adodb_next_page=1&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&carpeta=$carpeta&tipo_carp=$tipo_carp&nomcarpeta=$nomcarpeta&agendado=$agendado&orderTipo=$orderTipo&orderNo=";
    ?>
        <table width="100%" align="center" cellspacing="0" cellpadding="0" class="borde_tab">
            <tr class="tablas">
                <td>
                    <form name="form_busq_rad" id="form_busq_rad" action='<?=$_SERVER['PHP_SELF']?>?<?=$encabezado?>' method="POST">
                        <span class="etextomenu">
                            
                                Buscar radicado(s) (Separados por coma)<span class="etextomenu">
                                <input name="busqRadicados" type="text" size="40" class="tex_area" value="<?=$busqRadicados?>">
                                <input type=submit value='Buscar ' name=Buscar valign='middle' class='botones'>
                        </span>
                        <?
                            $fecha_hoy      = Date("Y-m-d");
                            $sqlFechaHoy    = $db->conn->DBDate($fecha_hoy);
                        ?>
                        <input type="checkbox" name="chkCarpeta" value=xxx <?=$chkValue?> > Todas las carpetas
                        </span>
                    </form>                
                </td>
            </tr>
        </table>    
        <form name="form1" id="form1" action="./tx/formEnvio.php?<?=$encabezado?>" method="POST">    
            <?php
            include "./tx/txOrfeo.php"; 
        
            /*  GENERACION LISTADO DE RADICADOS
            *  Aqui utilizamos la clase adodb para generar el listado de los radicados
            *  Esta clase cuenta con una adaptacion a las clases utiilzadas de orfeo.
            *  el archivo original es adodb-pager.inc.php la modificada es adodb-paginacion.inc.php
            */
           
            error_reporting(7);
            
            if (strlen($orderNo) == 0) {
                $orderNo = "2";
                $order   = 3;
            } else {
                $order   = $orderNo + 1;
            }
            
            $fila           ="./$carpetaBodega/tmp/sessR$krd";   
            
            if(file_exists($fila)){
                $fp             = fopen($fila, "r");    
                $contenido      = fread($fp, filesize($fila));            
                fclose($fp);
                
                $archivo        = "sessR$krd";
                $contenido      = str_replace("$archivo,","",$contenido);
                
                //Extraemos el contenido del archivo en un arreglo de
                //solo radicados                                                
                $arrayData      = preg_split('/[\D]+/',$contenido);                
                
                //Es numerico el dato
                $arrayData      = array_filter($arrayData, "is_numeric");
                
                //Convertir el array en un lista separada por comas
                $radiCarri      = implode(",", $arrayData);             
            }
            
            //Contenido si esta vacio, agregue un 0
            $contenido      = (empty($radiCarri))? '0': $radiCarri; 
            
            //Ajuntar resultado a la consulta de de radicados                                 
            $whereCarrito   = "AND b.RADI_NUME_RADI IN($contenido)";   
            
            $sqlFecha       = $db->conn->SQLDate("Y-m-d H:i A","b.RADI_FECH_RADI");            
            include "$ruta_raiz/include/query/queryCuerpoCarrito.php";
            
            $rs             =$db->conn->Execute($isql);
            if ($rs->EOF and $busqRadicados)  {
                echo "<hr><center><b><span class='alarmas'>No se encuentra ningun radicado con el criterio de busqueda</span></center></b></hr>";
            }
            else{
                $pager = new ADODB_Pager($db,$isql,'adodb', true,$orderNo,$orderTipo);
                $pager->checkAll = true;
                $pager->session = true;
                $pager->checkTitulo = true;
                $pager->toRefLinks = $linkPagina;
                $pager->toRefVars = $encabezado;
                $pager->descCarpetasGen=$descCarpetasGen;
                $pager->descCarpetasPer=$descCarpetasPer;
                $pager->Render($rows_per_page=500,$linkPagina,$checkbox=chkAnulados);
            }
            ?>        
        </form>
    </body>
</html>
