<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Julian Andres Ortiz Moreno Desarrollador julecci@gmail.com 3213006681
 */
?>
<?php

session_start();
$ruta_raiz = "../..";
if (!$dependencia)   include "../../rec_session.php";

$ano_ini = date("Y");
$mes_ini = substr("00".(date("m")-1),-2);
if ($mes_ini==0) {$ano_ini=$ano_ini-1; $mes_ini="12";}
$dia_ini = date("d");
$ano_ini = date("Y");
if(!$fecha_ini) $fecha_ini = "$ano_ini/$mes_ini/$dia_ini";
$fecha_fin = date("Y/m/d") ;
$where_fecha="";
$radSelec = "";
//$tpDepeRad = "NADA";
?>

<html>
<head>
<title>Envio de Documentos. Orfeo...</title>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
<script type="text/javascript">
     function masivaTranspaso(){
            sw=0;
            var radicados = new Array();
            var list = new Array();
            var depen;
            var depen1;
            for(var i=1;i<document.formEnviar.elements.length;i++){
              if (document.formEnviar.elements[i].checked && document.formEnviar.elements[i].name!="checkAll") {
              sw++;
              valor = document.formEnviar.elements[i].name;
              valor = valor.replace("checkValue[", "");
              valor = valor.replace("]", "");
              radicados[sw] = valor;
              list.push(valor);
              };
            };
            depen = document.getElementById('dep_tras').value;
            
            depen1 = document.getElementById('dep_sel').value;
            
            
            window.location.href = "CuerpoTranslado.php?"+"<?=session_name()?>"+"="+"<?=session_id()?>"+"&krd"+"<?=$krd?>"+"&usuarios="+list+"&depen="+depen+"&trans=2&dep="+ depen1;
           
}
    </script>
</head>
<body bgcolor="#FFFFFF" topmargin="0" onLoad="window_onload();">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="<?=$ruta_raiz."/js/spiffyCal/spiffyCal_v2_1.css"?>">

<?php
$ruta_raiz = "../..";
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
 $db = new ConnectionHandler("$ruta_raiz");	 
 if (!$dep_sel) $dep_sel = $dependencia;
 $nomcarpeta = "Consulta Usuarios";

if($_GET['trans']==2)
{ 
    $item = explode(",",$_GET['usuarios']);
   $db->conn->debug = true;
    $arreglo = array();
    for($i = 0; $i<count($item); $i++)
    {                        $isql = "SELECT MAX(USUA_CODI) AS NUMERO FROM USUARIO WHERE DEPE_CODI = ".$_GET['depen'];
            $rs7= $db->query($isql);
            $nusua_codi = $rs7->fields["NUMERO"] + 1;
            $coduser = $item[$i];
                            $stmt = $db->conn->PrepareSP(
                                "BEGIN
                                    Depend_Radicados(:CodUsuario,:NewCodUsuario,:CodDepend,:NewCodDepend);
                                END;");
                            $db->conn->InParameter($stmt,$coduser,'CodUsuario');
                            $db->conn->InParameter($stmt,$nusua_codi,'NewCodUsuario');
                            $db->conn->InParameter($stmt,$_GET['dep'],'CodDepend');
                            $db->conn->InParameter($stmt,$_GET['depen'],'NewCodDepend');
                            $db->conn->Execute($stmt);
                            $arreglo[$i] = $nusua_codi;
                            
                        
    }
     $cadena = implode(",", $arreglo);
     $cadena = "SELECT u.USUA_NOMB, d.DEPE_NOMB FROM USUARIO u INNER JOIN DEPENDENCIA d "
             . "ON d.DEPE_CODI = u.DEPE_CODI WHERE u.USUA_CODI IN(".$cadena.")"." AND"
             . " u.DEPE_CODI =".$_GET['depen'];
     
    header("location: RespuestaTrasnlado.php?sql=$cadena");
    $Mensaje = "usuarios transladados con exito";
}
 

 if ($busq_radicados) {
    $busq_radicados = trim($busq_radicados);
    $textElements = split (",", $busq_radicados);
    $newText = "";
    $i = 0;
    foreach ($textElements as $item)  {
    	$item = trim ( $item );
        if ( strlen ( $item ) != 0 ) { 
		   $i++; 
		   if ($i > 1) $busq_and = " and "; else $busq_and = " ";
		      $busq_radicados_tmp .= " $busq_and radi_nume_sal like '%$item%' ";
		}
     }
	 $dependencia_busq1 .= " and $busq_radicados_tmp ";
				
 }else  {
    $sql_masiva = "";
 }

 if ($orden_cambio==1)  {
 	if (!$orderTipo)  {
	   $orderTipo="desc";
	}else  {
	   $orderTipo="";
	}
 }

 $encabezado = "".session_name()."=".session_id()."&krd=$krd&pagina_sig=$pagina_sig&accion_sal=$accion_sal&radSelec=$radSelec&dependencia=$dependencia&dep_sel=$dep_sel&selecdoc=$selecdoc&nomcarpeta=$nomcarpeta&orderTipo=$orderTipo&orderNo=";
 $linkPagina = "$PHP_SELF?$encabezado&radSelec=$radSelec&accion_sal=$accion_sal&nomcarpeta=$nomcarpeta&orderTipo=$orderTipo&orderNo=$orderNo";
 $carpeta = "nada";
 $swBusqDep = "si";
 
 $pagina_actual = "../usuario/CuerpoTranslado.php";
 include "../paEncabeza.php";
 $varBuscada = "USUA_NOMB";
 $tituloBuscar = "Buscar Usuario(s) (Separados por coma)";
 include "../paBuscar.php";   
 $pagina_sig = "../usuario/CuerpoTranslado.php";
 $accion_sal = "Transladar"; 
 include "../paOpciones.php";  
 
 $rsDep1 = $db->conn->Execute($sql);
 ?>
 
<?php
 
 if($busq_radicados_tmp)  {
   $where_fecha=" ";
 }
 else  {
    $fecha_ini = mktime(00,00,00,substr($fecha_ini,5,2),substr($fecha_ini,8,2),substr($fecha_ini,0,4));
	$fecha_fin = mktime(23,59,59,substr($fecha_fin,5,2),substr($fecha_fin,8,2),substr($fecha_fin,0,4));
    $where_fecha = " (a.SGD_RENV_FECH >= ". $db->conn->DBTimeStamp($fecha_ini) ." and a.SGD_RENV_FECH <= ". $db->conn->DBTimeStamp($fecha_fin).") " ;
    $dependencia_busq1 .= " $where_fecha and ";
 } 

	/*  GENERACION LISTADO DE RADICADOS
	 *  Aqui utilizamos la clase adodb para generar el listado de los radicados
	 *  Esta clase cuenta con una adaptacion a las clases utiilzadas de orfeo.
	 *  el archivo original es adodb-pager.inc.php la modificada es adodb-paginacion.inc.php
	 */

	error_reporting(0);
?>
  <form name=formEnviar action='#' method=post>
      <table cellpadding="0" cellspacing="0" border="0" width="100%" class="borde_tab">
        <tr>
            <td width='50%' align='left'  class="titulos2" >Seleccione la dependencia a la cual desea hacer el translados</td>
            <td width='50%' class="titulos2"><?=$rsDep1->GetMenu2("dep_tras","$dep_sel",false, false, 0," class='select' id='dep_tras'")?></td>
        </tr>
    </table>
 <?php
    if ($orderNo==98 or $orderNo==99) {
       $order=1; 
	   if ($orderNo==98)   $orderTipo="desc";

       if ($orderNo==99)   $orderTipo="";
	}  
    else  {
	   if (!$orderNo)  {
  		  $orderNo=0;
	   }
	   $order = $orderNo + 1;
    }
	$sqlChar = $db->conn->SQLDate("d-m-Y H:i A","SGD_RENV_FECH");
	$sqlConcat = $db->conn->Concat("a.radi_nume_sal","'-'","a.sgd_renv_codigo","'-'","a.sgd_fenv_codigo","'-'","a.sgd_renv_peso");
	include "$ruta_raiz/include/query/administracion/queryCuerpoConsulta.php";

	//$db->conn->debug = true;
       
    $rs=$db->conn->Execute($isql);
	$nregis = $rs->fields["NOMBRE"];		
	if (!$nregis)  {
		echo "<hr><center><b>NO se encontro nada con el criterio de busqueda</center></b></hr>";}
	else  {
                

		   $pager = new ADODB_Pager($db,$isql,'adodb');
                    $pager->checkAll = true;
                    $pager->checkTitulo = true;
                    $pager->toRefLinks = $linkPagina;
                    $pager->toRefVars = $encabezado;
                    $pager->descCarpetasGen=$descCarpetasGen;
                    $pager->descCarpetasPer=$descCarpetasPer;
                      $pager->Render($rows_per_page=20,$linkPagina,$checkbox=true);
	      }
 ?>
      <input type="hidden" name="trans" value="transladar"/>
  </form>
<span><?=$Mensaje?></span>  
</body>

</html>


