<?php
session_start();

    $ruta_raiz = "../";
    if (!$_SESSION['dependencia'])
        header ("Location: $ruta_raiz/cerrar_session.php");
    
    
$krd         = $_SESSION["krd"];
$dependencia = $_SESSION["dependencia"];
$usua_doc    = $_SESSION["usua_doc"];
$codusuario  = $_SESSION["codusuario"];
$tip3Nombre  = $_SESSION["tip3Nombre"];
$tip3desc    = $_SESSION["tip3desc"];
$tip3img     = $_SESSION["tip3img"];

/*
 * Lista Subseries documentales
 * @autor Jairo Losada
 * @fecha 2009/06 Modificacion Variables Globales. Arreglo cambio de los request Gracias a recomendacion de Hollman Ladino
 */

foreach ($_POST as $key => $valor)   ${$key} = $valor;
foreach ($_GET as $key => $valor)   ${$key} = $valor;






if (!$dep_sel) $dep_sel = $dependencia;
?>
<html>
<head>
<title>Envio de Documentos. Orfeo...</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<body bgcolor="#FFFFFF" topmargin="0">
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="<?=$ruta_raiz?>js/spiffyCal/spiffyCal_v2_1.css">
<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>
<?php
 include_once "$ruta_raiz/js/funtionImage.php";
 include_once "$ruta_raiz/include/db/ConnectionHandler.php";
 $db = new ConnectionHandler("$ruta_raiz");	 
 if(!$carpeta) $carpeta=0;
 if(!$estado_sal)   {$estado_sal=2;}
 if(!$estado_sal_max) $estado_sal_max=3;

 if($estado_sal==3 && (!$bTodasDep && !$busqradicados  )  ) {
    $accion_sal = "Envio de Documentos";
	$pagina_sig = "cuerpoEnvioNormal.php";
	$nomcarpeta = "Radicados Para Envio";
	if(!$dep_sel) $dep_sel = $dependencia;
	$dependencia_busq1 = " and c.radi_depe_radi = $dep_sel ";
	$dependencia_busq2 = " and c.radi_depe_radi = $dep_sel";
 }
$accion_sal = "Envio de Documentos";
 
  if ($orden_cambio==1)  {
 	if (!$orderTipo)  {
	   $orderTipo="desc";
	}else  {
	   $orderTipo="";
	}
 }

 $encabezado = "".session_name()."=".session_id()."&estado_sal_max=$estado_sal_max&accion_sal=$accion_sal&dependencia_busq2=$dependencia_busq2&dep_sel=$dep_sel&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion&nomcarpeta=$nomcarpeta&orderTipo=$orderTipo&orderNo=";
 $linkPagina = "$PHP_SELF?$encabezado&orderNo = $orderNo";
 $swBusqDep  = "si";
 $carpeta    = "nada";
 $swListar   = "Si";
 $varBuscada    = "radi_nume_salida";
 include "$ruta_raiz/envios/paEncabeza.php";
 include "$ruta_raiz/envios/paBuscar.php";   
 include "$ruta_raiz/envios/paOpciones2.php";   
 $pagina_actual = "$ruta_raiz/envios/cuerpoEnvioNormal.php";
 $pagina_sig    = "$ruta_raiz/envios/envia.php";

 /*  GENERACION LISTADO DE RADICADOS
 *  Aqui utilizamos la clase adodb para generar el listado de los radicados
 *  Esta clase cuenta con una adaptacion a las clases utiilzadas de orfeo.
 *  el archivo original es adodb-pager.inc.php la modificada es adodb-paginacion.inc.php
 */
 
?>

 <form name=formEnviar action='../envios/envia.php?<?=$encabezado?>' method=GET>
	<input type='hidden' name='<?=session_name()?>' value='<?=session_id()?>'> 
	<input type='hidden' name='estado_sal' value='<?= $estado_sal ?>'>
	<input type='hidden' name='estado_sal_max' value='<?= $estado_sal_max ?>'>
  <?php 
    if ($orderNo==98 or $orderNo==99) {
       $order=1; 
	   if ($orderNo==98)   $orderTipo="desc";
       if ($orderNo==99)   $orderTipo="";
	}  
    else  {
	   if (!$orderNo)  {
	   		$orderNo=3;
			$orderTipo="desc";
		}
	   $order = $orderNo + 1;
    }

 	$radiPath = $db->conn->Concat($db->conn->substr."(a.anex_codigo,1,4) ", "'/'",$db->conn->substr."(a.anex_codigo,5,3) ","'/docs/'","a.anex_nomb_archivo");
 	include "$ruta_raiz/include/query/envios/queryCuerpoEnvioNormal.php";
    
	echo "<hr>";
    $rsTestAnex = $db->conn->Execute($isqlTestAnex);
   ?>
        <script type="text/javascript">

                function BuscaData(stg,Srch4){
                    var i=0;
                    var esta=false;
                    for (i=0;i<stg.length;i++)
                    {
                        if(stg[i]==Srch4){
                            esta=true;
                            break;
                        }
                    }
                    return esta;
                }
                
                var RadicadosCon=[];
<? do {
    ?>
    <? if ($rsTestAnex->fields["TESTIMG"] == 'SI') { ?>
                RadicadosCon.push('<?= $rsTestAnex->fields["CHR_RADI_NUME_SALIDA"] ?>'); 
    <? } ?>
    <?
    $rsTestAnex->MoveNext();
} while (!$rsTestAnex->EOF);
?> 
    function RadiSearch(Radicado){
        var esta=false;
        esta=BuscaData(RadicadosCon,Radicado);
        return esta;
    }
    
   
    function Marcar(tipoAnulacion)
    {   
        marcados = 0;
        
        for(i=0;i<document.formEnviar.elements.length;i++)
        {
            if(document.formEnviar.elements[i].name.slice(0,9)!='checkAll' && document.formEnviar.elements[i].checked==1)
            {
                marcados++;
            }
        }
        if(marcados>=1)
        {                     
            
            var esta=false;
            var RadMarcados=$('input[name="valRadio"]:checked').val();
            /*
             *($('input[name="usua_super"]:checked').val()
             **/
            esta = RadiSearch(RadMarcados);
            if(esta==false){
                alert("El radicado seleccionado no tiene una imagen asociada");
            }else{
                document.formEnviar.submit();
            }
            
        }
        else
        {
            alert("Debe seleccionar un radicado");
        }
    }
    <!-- Funcion que activa el sistema de marcar o desmarcar todos los check  -->
    function getCheckedValue(radioObj) {
        if(!radioObj)
            return "";
        var radioLength = radioObj.length;
        if(radioLength == undefined)
            if(radioObj.checked)
                return radioObj.value;
        else
            return "";
        for(var i = 0; i < radioLength; i++) {
            if(radioObj[i].checked) {
                return radioObj[i].value;
            }
        }
        return "";
    }

    function markAll()
    {
        if(document.formEnviar.elements['checkAll'].checked)
            for(i=1;i<document.formEnviar.elements.length;i++)
                document.formEnviar.elements[i].checked=1;
        else
            for(i=1;i<document.formEnviar.elements.length;i++)
                document.formEnviar.elements[i].checked=0;
    }
            
            </script>
        
        <?php
         $ADODB_COUNTRECS = true;
            $rs_env = $db->conn->Execute($isql);
            $ADODB_COUNTRECS = false;
	if ($rs->EOF){
        echo "<table class=borde_tab width='100%'><tr><td class=titulosError><center>NO se encontro nada con el criterio de busqueda</center></td></tr></table>";
    }
	else  {
		$pager = new ADODB_Pager($db,$isql,'adodb', true,$orderNo,$orderTipo);
		$pager->toRefLinks = $linkPagina;
		$pager->toRefVars = $encabezado;
		$pager->Render($rows_per_page=120,$linkPagina,$checkbox=chkEnviar);
	}
 ?>
  </form>
</body>
</html>
