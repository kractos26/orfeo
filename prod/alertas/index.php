<?php
session_start();
/**
  * Pagina de Estadisticas  que muestra el contenido de las Carpetas
	* Fundacion Correlibre.org
	* Añadida por Informetrika - IDRD en el año 2009
	*	Tomado de Alertas Diseñadas en Supersolidaria.
	*
	* Se añadio a la 3.8.0 por
  * @autor Jairo Losada 2009-07,aurigadl@gmail.com 2010-08
  * @licencia GNU/GPL
  */

error_reporting(E_ALL);
ini_set('display_errors', '1');
    foreach ($_GET as $key => $valor)   ${$key} = $valor;
    foreach ($_POST as $key => $valor)   ${$key} = $valor;
    
    if (isset($_GET["nomcarpeta"])){
        $nomcarpeta = $_GET["nomcarpeta"];
    }else{
        $nomcarpeta = "";
    }
    
    
    error_reporting(0);
    
    define('ADODB_ASSOC_CASE', 2);
    
    $krd            = $_SESSION["krd"];
    $dependencia    = $_SESSION["dependencia"];
    $usua_doc       = $_SESSION["usua_doc"];
    $codusuario     = $_SESSION["codusuario"];
    $tip3Nombre     = $_SESSION["tip3Nombre"];
    $tip3desc       = $_SESSION["tip3desc"];
    $tip3img        = $_SESSION["tip3img"];
     
    $tipo_carp=$_REQUEST["tipo_carpt"];
    
    $ruta_raiz = "..";


    require_once ($ruta_raiz . "/include/db/ConnectionHandler.php");

    $db = new ConnectionHandler($ruta_raiz);
    $db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
    
    include_once("func_date.inc.php");
    
    $ini = '2005-12-23';
    $fin = '2006-01-07';

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Estado de radicados en bandejas</title>
        <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$ESTILOS_PATH?>/orfeo.css">
        
        <!--INICIO envio de datos graficas -->
         <script language="javascript">                
            function returnUsu_Dep(){
                return 'codusuario=<?=$codusuario?>&dependencia=<?=$dependencia?>';
            }    
          </script>
        <!--FIN envio de datos graficas -->
        
        <!--INICIO js para graficas -->
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/jquery.jqplot.js"></script>
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/jqplot.pieRenderer.js"></script>
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/jqplot.barRenderer.js"></script>
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/jqplot.categoryAxisRenderer.js"></script>
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/jqplot.canvasAxisLabelRenderer.js"></script>
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/jqplot.canvasAxisTickRenderer.js"></script>
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/jqplot.canvasTextRenderer.js"></script>
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/jqplot.pointLabels.min.js"></script>
        
        <!-- Invocación y uso de las librerías -->
        <script type="text/javascript" src="<?=$ruta_raiz?>/js/graficosRadi.js"></script>        
        <!--FIN js para graficas -->
        
        <script language="javascript">
            function cambia_page(pageNo, orderPos){
                document.forms['consulta'].pos.value = orderPos;
                document.forms['consulta'].pagina.value = pageNo;
                setTimeout("document.forms['consulta'].submit()", 100);
            }
            
            function cambia_order(orderBy){
                var orderPos = document.forms['consulta'].pos.value;
                if (orderPos == "ASC") 
                    document.forms['consulta'].pos.value = "DESC";
                else 
                    document.forms['consulta'].pos.value = "ASC";
                document.forms['consulta'].order.value = orderBy;
                setTimeout("document.forms['consulta'].submit()", 100);
            }
        </script>
        
        <style type="text/css">
            
            .alerta_roja {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 10px;
                font-weight: normal;
                background-image: url(alerta_roja.gif);
                background-repeat: no-repeat;
                padding-left: 20px;
            }
            
            .alerta_amarilla {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 10px;
                font-weight: normal;
                background-image: url(alerta_amarilla.gif);
                background-repeat: no-repeat;
                padding-left: 20px;
            }
            
            .sin_alerta {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 10px;
                font-weight: normal;
                padding-left: 20px;
            }
            
            div.pagination {
                padding: 3px;
                margin: 3px;
                text-align: center;
            }
            
            div.pagination a {
                padding: 2px 5px 2px 5px;
                margin: 2px;
                border: 1px solid #A8BAC6;
                text-decoration: none; /* no underline */
                color: #A8BAC6; /*#739ECE;*/
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10px;
            }
            
            div.pagination a:hover, div.pagination a:active {
                border: 1px solid #217285; /* B6C2BE */
                color: #217285;
            }
            
            div.pagination span.current {
                padding: 2px 5px 2px 5px;
                margin: 2px;
                border: 1px solid #A8BAC6;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 11px;
                text-decoration: none;
                font-weight: bold;
                background-color: #A8BAC6;
                color: #FFFFFF;
            }
            
            div.resultado {
                padding: 3px;
                margin: 3px;
                text-align: center;
            }
            
            div.resultado span.search {
                padding: 2px 5px 2px 5px;
                margin: 2px;
                color: #000000;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 11px;
            }            
        </style>
    </head>
    <body>
    <center>
    
    <!--INICIO graficas del estado actual de los radicados -->
    <table class="borde_tab" width="100%">
        <tr>
            <TD colspan="5" align="center">
                <img src="../logoEntidad.gif" width=100>
            </TD>
        </tr>
        <TR height="410px" valign="top">
            <TD align="left">
                <div id="chart1" style="margin-top:20px; margin-left:20px; width:750px; height:400px;">
                    <div class="listado1" id="grafAlerInfo1"></div>
                </div>
            </TD>            
            <TD align="right">                
                <div id="chart2" style="margin-top:20px; margin-right:20px; width:180px; height:250px;">
                    <div class="listado1" id="grafAlerInfo2"></div>
                </div>                
            </TD>            
        </TR>
    </table>
    <!--FIN graficas del estado actual de los radicados -->
    
    <?
    include "../menu/mensajes.php";
    ?>
    <br>
    <a class="listado1">El estado de sus documentos criticos es el siguiente.</a>
    </center>
    <?
    	
    ?>
    </hrZ>
    <?
    $order  = $_POST["order"];
    $pos    = $_POST["pos"];
    $pagina = $_POST["pagina"];
    
    ?>
    
    <form name="consulta" method="post">
    <input type="hidden" name="order" value="<?=$order?>">
    <input type="hidden" name="pos" value="<?=$pos?>">
    <input type="hidden" name="pagina" value="<?=$pagina?>">
    </form>
    
    <?php
    $registros = '20';
    $total_links = '4';
    
    if(!$pagina){ 
    	$inicio = 0; 
    	$pagina = 1; 
    	} 
    else{ 
    	$inicio = ($pagina - 1) * $registros; 
    	}
    
    
    $sql_usu = "SELECT * FROM USUARIO WHERE USUA_LOGIN = '$krd'"; //$krd CCASTANEDA FALDANA CLRODRIGUEZ
    //echo $sql_usu;
    $rs_usu = $db->query($sql_usu);
    if(!$rs_usu->EOF){
    	$usua_codi = $rs_usu->fields["USUA_CODI"];
    	$depe_codi = $rs_usu->fields["DEPE_CODI"];
    	}
    if($tipo_alerta == 1){
    	$where_usu = " AND r.RADI_USUA_ACTU = '$usua_codi' AND r.RADI_DEPE_ACTU = '$depe_codi'";
    	}
    if($tipo_alerta == 2){
    	$sql_uxd = "SELECT * FROM SES_USUARIOXDEPENDENCIA WHERE USUA_CODI = '$usua_codi' AND DEPE_CODI = '$depe_codi'";
    	$rs_uxd = $db->query($sql_uxd);
    //	$db->debug = true;
    	if(!$rs_uxd->EOF){
    		$uxd_verdependencia = $rs_uxd->fields["UXD_VERDEPENDENCIA"];
    		$where_usu = " AND (";
    		$where_usu .= "r.RADI_DEPE_ACTU IN(" . $uxd_verdependencia . ")";
    		$where_usu .= ")";
    		}
    	else{
    		$where_usu = " AND r.RADI_USUA_ACTU = '$usua_codi' AND r.RADI_DEPE_ACTU = '$depe_codi'";
    		}
    	}
    $sql = "SELECT * FROM RADICADO r, ANEXOS a, BODEGA_EMPRESAS b, SGD_TPR_TPDCUMENTO t, SGD_EMPUS_EMPUSUARIO eu, USUARIO u, DEPENDENCIA d 
    					WHERE a.ANEX_RADI_NUME = r.RADI_NUME_RADI 
    						AND b.IDENTIFICADOR_EMPRESA = r.EESP_CODI 
    						AND eu.IDENTIFICADOR_EMPRESA = r.EESP_CODI 
    						AND u.USUA_LOGIN = eu.USUA_LOGIN 
    						AND d.DEPE_CODI = u.DEPE_CODI 
    						AND r.RADI_NUME_DERI IS NULL 
    						AND a.SGD_FECH_IMPRES IS NULL 
    						AND t.SGD_TPR_CODIGO = r.TDOC_CODI 
    						AND t.SGD_TPR_TERMINO IS NOT NULL 
    						AND a.RADI_NUME_SALIDA IS NOT NULL 
    						AND a.ANEX_TIPO <> 20 
    						AND a.ANEX_ESTADO < 3";
    						
    $sql .= $where_usu;
    
    $sql_tmp = $sql;
    //echo $sql_tmp;
    $rs_tmp = $db->query($sql_tmp);
    
    if($rs_tmp){
    	$i = 0;
    	if(!$radi_nume_salida) $radi_nume_salida = 1;
    	while(!$rs_tmp->EOF){
    		$radi_nume_salida = $rs_tmp->fields["RADI_NUME_SALIDA"];
    		if(!$radi_nume_salida) $radi_nume_salida = 0;
    		$sql_anx = "SELECT * FROM ANEXOS WHERE RADI_NUME_SALIDA = $radi_nume_salida AND ANEX_TIPO = 20";
    //		echo $sql_anx;
    		$rs_anx = $db->query($sql_anx);
    		if(!$rs_anx->EOF ){
    			if($rs_anx->fields["ANEX_ESTADO"] < 3){
    				$radicados[$i] = $rs_tmp->fields["RADI_NUME_RADI"];
    				}
    			else{
    				$no_radicados[$i] = $rs_tmp->fields["RADI_NUME_RADI"];
    				}
    			$i ++;
    			}
    		if(!$rs_tmp->EOF) $rs_tmp->MoveNext();
    	}
    	
    	$radi = implode(',', $radicados);
    //	print_r($radi);
    	$no_radi = implode(',', $no_radicados);
    	if(!$no_radi)
    		$no_radi="0";
    	
    	if(sizeof($radicados) != 0){
    		$in_rad = " AND r.RADI_NUME_RADI IN($radi)";
    		}
    	else{
    		$in_rad = " AND r.radi_nume_radi = (SELECT ax.anex_radi_nume FROM anexos ax 
    						WHERE ax.radi_nume_salida = a.radi_nume_salida 
    							AND ax.anex_tipo <> 20 
    							AND ax.anex_estado < 3) 
    					AND r.radi_nume_radi NOT IN($no_radi)";
    		}
    	}
    else{
    	$in_rad = "";
    	}
    	
    	$sql_rad = "select r.RADI_NUME_RADI AS \"Numero radicado\", 
    				TO_CHAR(r.RADI_FECH_RADI, 'YYYY-MM-DD') AS \"Fecha radicado\", 
    				r.RA_ASUN AS \"Asunto\", 
    				b.NOMBRE_DE_LA_EMPRESA AS \"Entidad Solidaria\",
    				b.SIGLA_DE_LA_EMPRESA AS \"Sigla\", 
    				t.SGD_TPR_DESCRIP AS \"Tipo Documento\", 
    				r.RADI_USU_ANTE AS \"Enviado Por\", 
    				u.USUA_LOGIN AS \"Funcionario\", 
    				d.DEPE_NOMB AS \"Grupo\", 
    				t.SGD_TPR_TERMINO AS \"Termino\", 
    				t.SGD_TPR_TIPTERMINO AS \"Tipo de Termino\" 
    from
    	radicado r 
    	left join anexos a on r.RADI_NUME_RADI=a.ANEX_RADI_NUME and a.ANEX_BORRADO  = 'N'
    	inner join SGD_TPR_TPDCUMENTO t on t.SGD_TPR_CODIGO = r.TDOC_CODI and t.SGD_TPR_TERMINO IS NOT NULL
    	inner join USUARIO u on  u.USUA_CODI=r.RADI_USUA_ACTU and u.DEPE_CODI = r.RADI_DEPE_ACTU
    	inner join DEPENDENCIA d on d.DEPE_CODI = r.RADI_DEPE_ACTU
    	left join BODEGA_EMPRESAS b on r.EESP_CODI=b.IDENTIFICADOR_EMPRESA 
    where
    	   1=1 ";
    
    $sql_rad .= $where_usu;
    $sql_rad .=" group by  r.RADI_NUME_RADI, a.RADI_NUME_SALIDA , r.RADI_FECH_RADI , r.RA_ASUN, b.NOMBRE_DE_LA_EMPRESA ,b.SIGLA_DE_LA_EMPRESA
    	  ,t.SGD_TPR_DESCRIP, r.RADI_USU_ANTE , u.USUA_LOGIN , d.DEPE_NOMB , t.SGD_TPR_TERMINO , t.SGD_TPR_TIPTERMINO,a.ANEX_TIPO , a.ANEX_ESTADO , a.ANEX_SALIDA, a.ANEX_BORRADO  
    having
     a.ANEX_TIPO <> 20 and a.ANEX_ESTADO < 3 and a.ANEX_SALIDA = 1  ";
    
    $sql_num = "SELECT COUNT(r.RADI_NUME_RADI) AS \"num_reg\"
    				from
    	radicado r 
    	left join anexos a on r.RADI_NUME_RADI=a.ANEX_RADI_NUME and a.ANEX_BORRADO  = 'N'
    	inner join SGD_TPR_TPDCUMENTO t on t.SGD_TPR_CODIGO = r.TDOC_CODI and t.SGD_TPR_TERMINO IS NOT NULL
    	inner join USUARIO u on  u.USUA_CODI=r.RADI_USUA_ACTU and u.DEPE_CODI = r.RADI_DEPE_ACTU
    	inner join DEPENDENCIA d on d.DEPE_CODI = r.RADI_DEPE_ACTU
    	left join BODEGA_EMPRESAS b on r.EESP_CODI=b.IDENTIFICADOR_EMPRESA
    where
    	   1=1 ";//se adicono linea porque mostraba todos los documentos y no revisaba el estado maqr 20080418
    
    $sql_num .= $in_rad;
    
    $sql_num .=" group by  r.RADI_NUME_RADI, a.RADI_NUME_SALIDA , r.RADI_FECH_RADI , r.RA_ASUN, b.NOMBRE_DE_LA_EMPRESA ,b.SIGLA_DE_LA_EMPRESA
    	  ,t.SGD_TPR_DESCRIP, r.RADI_USU_ANTE , u.USUA_LOGIN , d.DEPE_NOMB , t.SGD_TPR_TERMINO , t.SGD_TPR_TIPTERMINO,a.ANEX_TIPO , a.ANEX_ESTADO , a.ANEX_SALIDA
    having
     a.ANEX_TIPO <> 20 and a.ANEX_ESTADO < 3 and a.ANEX_SALIDA = 1 or a.radi_nume_salida is null";
    /*
    						AND r.RADI_USUA_ACTU = '1'
    						AND r.RADI_DEPE_ACTU = '210'";
    */
    
    $sql_num .= $where_usu;
    
    $rs_num = $db->query($sql_num);
    //echo $sql_rad;
    $total_registros = $rs_num->fields['num_reg']; 
    $total_paginas = ceil($total_registros / $registros); 
    
    if(isset($order)){
    	$sql_rad .=  " ORDER BY \"" . $order . "\" ";
    	}
    else{
    	$order = 'Fecha radicado';
    	echo "<script language=\"javascript\">document.consulta.order.value = 'Fecha radicado';</script>";
    	$sql_rad .=  " ORDER BY \"" . $order . "\" ";
    	}
    	
    if(isset($pos)){
    	$sql_rad .= $pos;
    	}
    else{
    	$pos = 'DESC';
    	echo "<script language=\"javascript\">document.consulta.pos.value = 'ASC';</script>";
    	$sql_rad .= $pos;
    	}
    
    //$rs_rad = $db->query($sql_rad);
    $rs_rad = $db->conn->SelectLimit($sql_rad, $registros, $inicio);
    //echo $sql_rad;
    if($rs_rad){
    	$arr = array();
    	$nom = array();
    	$tam_fields = sizeof($rs_rad->fields);
    	$i = 0;
    	while(!$rs_rad->EOF){
    		$j = 0;
    		foreach($rs_rad->fields as $label => $value){
    			$nom[$j] = $label;
    			$arr[$i][$nom[$j]] = $value;
    			$j ++;
    			}
    		$i ++;
    		$rs_rad->MoveNext();
    		}
    	echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"3\" width=\"100%\" class=\"borde_tab\">";
    	echo "<tr>";
    	echo "<td class=\"titulos2\" style=\"padding:10px; text-align:center;\">";
    	echo "Dias Restantes";
    	echo "</td>";
    	
    	for($j = 0; $j < sizeof($nom); $j ++){
    		echo "<td class=\"titulos2\" style=\"padding:10px; text-align:center;\">";
    		if($order == $nom[$j]){
    			if($pos == 'ASC'){
    				echo "<img src=\"../iconos/flechaasc.gif\" border=\"0\" align=\"left\">";
    				}
    			else{
    				echo "<img src=\"../iconos/flechadesc.gif\" border=\"0\" align=\"left\">";
    				}
    			}
    		echo "<a href=\"#\" class=\"textoOpcion\" onClick='cambia_order(\"$nom[$j]\");'><span class=\"titulos3\">$nom[$j]</span></a>";
    		echo "</td>";
    		}
    	
    	echo "<td class=\"titulos2\" style=\"padding:10px; text-align:center;\">";
    	echo "Fecha Limite";
    	echo "</td>";
    	echo "</tr>";
    	
    	for($i = 0; $i < $rs_rad->RowCount(); $i ++){
    		$clase = ($i % 2) + 1;
    		echo "<tr class=\"listado$clase\">";
    		for($j = 0; $j < sizeof($nom); $j ++){
    			if($nom[$j] == 'Fecha radicado'){
    				$fecha_ini = $arr[ $i ][ $nom[$j] ];
    				}
    			if($nom[$j] == 'Termino'){
    				$termino = $arr[ $i ][ $nom[$j] ];
    				}
    			if($nom[$j] == 'Tipo de Termino'){
    				if($arr[ $i ][ $nom[$j] ] == 1){
    					$habil = $arr[ $i ][ $nom[$j] ];
    					}
    				else{
    					$habil = $arr[ $i ][ $nom[$j] ];
    					}
    				}
    			}
    		echo "<td>";
    		
    		$amarilla = floor(40 * $termino / 100);
    		$roja = floor(20 * $termino / 100);
    		
    		$now = getDate();
    		$day_now = $now["mday"];
    		$month_now = $now["mon"];
    		$year_now = $now["year"];
    		
    		$date_now = date("Y-m-d", mktime(0,0,0, $month_now, $day_now, $year_now));
    		
    //		$fecha_ini = suma_dias($fecha_ini, 365, $habil);
    		
    		$fecha_fin = suma_dias($fecha_ini, $termino, $habil);
    
    		list($anio_ini, $mes_ini, $dia_ini) = parte_fecha($fecha_ini);
    		list($anio_fin, $mes_fin, $dia_fin) = parte_fecha($fecha_fin);
    		
    		$dias = floor((mktime(0,0,0, $mes_fin, $dia_fin, $anio_fin) - mktime(0,0,0, $month_now, $day_now, $year_now)) / (24 * 60 * 60));
    
    		$fiestas = 0;
    
    		for($i_add = 1; $i_add <= $dias; $i_add ++){
    			$fecha_new = date("Y-m-d", mktime(0,0,0, $month_now, $day_now, $year_now) + 1 * 24 * 60 * 60);
    			list($year_now, $month_now, $day_now) = parte_fecha($fecha_new);
    			$fiesta = es_festivo($day_now, $month_now, $year_now);
    			if($fiesta == 1){
    				$fiestas ++;
    				$$dias ++;
    				}
    			}
    
    		if($habil == 1){
    			$dias = $dias - $fiestas;
    			}
    
    		if($dias <= $amarilla && $dias > $roja){
    			$msj = "Falta(n)<br><b><u>" . $dias . "</u></b> dia(s)";
    			$class_div = 'alerta_amarilla';
    			}
    		elseif($dias <= $roja){
    			if($dias < 0){
    				$msj = "Sobrepaso<br><b><u>" . abs($dias) . "</u></b> dia(s)";
    				}
    			else{
    				$msj = "Falta(n)<br><b><u>" . $dias . "</u></b> dia(s)";
    				}
    			$class_div = 'alerta_roja';
    			}
    		else{
    			$msj = "Falta(n)<br><b><u>" . $dias . "</u></b> dia(s)";
    			$class_div = 'sin_alerta';
    			}
    		
    		echo "<div class=\"$class_div\">"; //style=\"text-transform:uppercase;\"
    		echo $msj;
    		echo "</div>";
    		echo "</td>";
    
    		for($j = 0; $j < sizeof($nom); $j ++){
    			echo "<td>";
    			if($nom[$j] == 'Tipo de Termino'){
    				if($arr[ $i ][ $nom[$j] ] == 1){
    					$msj_habil = "habil(es)";
    					$habil = $arr[ $i ][ $nom[$j] ];
    					}
    				else{
    					$msj_habil = "calendario";
    					$habil = $arr[ $i ][ $nom[$j] ];
    					}
    				$arr[ $i ][ $nom[$j] ] = $msj_habil;
    				}
    			if($nom[$j] == 'Fecha radicado'){
    				$encabezado = "".session_name()."=".session_id()."&adodb_next_page=1&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&orderTipo=$orderTipo&orderNo=";
    				?>
    				<a id="link_<?=$i?>" href="<?=$ruta_raiz?>/verradicado.php?verrad=<?=$arr[ $i ][ $nom[$j - 1] ]?>&<?=$encabezado?>" target="mainFrame"><?=$arr[ $i ][ $nom[$j] ]?></a>
    				<?php
    				}
    			else{
    				echo $arr[ $i ][ $nom[$j] ]." ";
    				}
    			echo "</td>";
    			}
    		
    		echo "<td>";
    		echo $anio_fin . "-" . $mes_fin . "-" . $dia_fin;
    		echo "</td>";
    		echo "</tr>";
    		}
    	
    	echo "</table>";
    	}
    else{	
    	echo "<script language=\"javascript\">window.close();</script>";
    	echo "<div align=\"center\" class=\"resultado\">";
    	echo "<span class=\"search\">";
    	echo "No tiene radicados con ALERTA";
    	echo "</span>";
    	echo "</div>";
    	}
    
    if($total_registros){
    	echo "<br><div class=\"pagination\">";
    	if(($pagina - 1) > 0) {
    		echo "<a href='#' onClick='cambia_page(1, \"$pos\");'><<</a> ";
    		echo "<a href='#' onClick='cambia_page(" . ($pagina - 1) . ", \"$pos\");'><</a> ";
    		}
    
    	if($pagina >= ($total_links + 3)) {
    		echo '&nbsp;...&nbsp;';
    		}
    	
    	if (($pagina - $total_links) <= 1) {
    		$start = 1;
    		} 
    	elseif ($pagina > ($total_paginas - $total_links)) {
    		$start = $total_paginas - (2 * $total_links);
    		} 
    	else {
    		$start = $pagina - $total_links;
    		}
    
    	if (($pagina + $total_links) >= $total_paginas) {
    		$end = $total_paginas;
    		} 
    	elseif ($pagina < ($total_links + 1)) {
    		$end = (2 * $total_links) + 1;
    		} 
    	else {
    		$end = $pagina + $total_links;
    		}
    
    	for ($i = $start; $i <= $end; $i ++) {
    		if ($pagina == $i) {
    			echo "<span class=\"current\">$i</span>";
    			}
    		else
    			echo "<a href='#' onClick='cambia_page(" . $i . ", \"$pos\");'>$i</a> ";
    		}
    
    	if($pagina <= ($total_paginas - $total_links - 2)) {
    		echo '&nbsp;...&nbsp;';
    		}
    	
    	if($pagina <= ($total_paginas - 1)) {
    		echo "<a href='#' onClick='cambia_page(" . ($pagina + 1) . ", \"$pos\");'>></a> ";
    		echo "<a href='#' onClick='cambia_page(" . $total_paginas . ", \"$pos\");'>>></a> ";
    		}
    	
    	echo "</div><br>";
    	?>
    	<div class="resultado">
    	<span class="search">
    	<?php
    	$final = $inicio + $rs_rad->RowCount();
    	echo "Mostrando de ".($inicio + 1)." a ".$final."<br><br>";
    	echo "P&aacute;gina $pagina/$total_paginas<br>";
    	echo "<br>(".$total_registros.") registro (s)";
    	?>
    	</span>
    	</div>
    	<?php
    	echo "</div>";
    	}
    
    	?>
    <p></p>
    <hr>
    <a class=titulos5>
    El sistema de gestion Orfeo y su comunidad OrfeoGpl es mantenida por la Fundacion Correlibre (<a href="http://www.correlibre.org" class=titulos5>http://www.correlibre.org)</a>.
    </body>
</html>
