<?php 
session_start();

$ruta_raiz = "."; 
if (!$_SESSION['dependencia'])
    header ("Location: $ruta_raiz/cerrar_session.php");

$krd            = $_SESSION["krd"];
$dependencia    = $_SESSION["dependencia"];
$usua_doc       = $_SESSION["usua_doc"];
$codusuario     = $_SESSION["codusuario"];
$tip3Nombre     = $_SESSION["tip3Nombre"];
$tip3desc       = $_SESSION["tip3desc"];
$tip3img        = $_SESSION["tip3img"];
$ESTILOS_PATH   = $_SESSION["ESTILOS_PATH"];
$fechah         = date("Ymdhms");
$ruta_raiz      = ".";


// Mostrar el numero de radicados actules en el carrito
// de radicados

//$archivo = "sessR$krd";
//$fila = "$ruta_raiz/$carpetaBodega/tmp/$archivo";
//
//if(file_exists($fila)){
//
//    $fp             = fopen($fila, "r");    
//    $contenido      = fread($fp, filesize($fila));            
//    fclose($fp);
//    
//    //Extraemos el contenido del archivo en un arreglo de
//    //solo radicados                                                
//    $arrayData      = preg_split('/[\D]+/',$contenido);                
//    
//    //Filtrar solo datos numericos
//    $arrayData      = array_filter($arrayData, "is_numeric");        
//    
//    //Dato a mostrar en el div
//    $radActuales    = count($arrayData);
//}else{
//    $radActuales = 0;
//}
$radActuales = 0;
?>
    <html>
        <head>
            
            <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
            
            <!--Se agregan localmente para no dañar el resto de pagians
            se arregla formato mediante el sisguiente css -->
            <style type="text/css">
            body {
                margin-bottom:0;
                margin-left:0;
                margin-right:0;
                margin-top:0;
                padding-bottom:0;
                padding-left:0;
                padding-right:0;
                padding-top:0; 
            }
            </style>
            
            
            
            <!-- xINICIO Script que crea la sesion y la cierra para el carro de compras-->
            <script language="javascript">                
                function returnKrdF_top(){
                    return '<?=$krd?>';
                };
    
                function nueva(){
                    open('plantillas.php?<?=session_name()."=".session_id()?>', 'Sizewindow', 'width=800,height=600,scrollbars=yes,toolbar=no') 
                } 

            </script>
            <script type="text/javascript" src="<?=$ruta_raiz?>/js/jquery-1.4.2.min.js"></script>            
            <script type="text/javascript" src="<?=$ruta_raiz?>/js/ajaxSessionRads.js"></script>                      
            <!-- FIN    Script que crea la sesion y la cierra para el carro de compras-->
            
            
            <script language="JavaScript" type="text/javascript">

                function cerrar_session() {
		    if (confirm('Seguro de cerrar sesion ?')){
                        <?$fechah = date("Ymdhms"); ?>
                        url="login.php?adios=chao";document.form_cerrar.submit();
	                url = 'login.php?<?= session_name()."=".session_id()."&fechah=$fechah"?>';
			window.location.href=url;
		    }
		}
            </script>
            <script language="JavaScript" type="text/javascript">                
                
                function MM_swapImgRestore(){
                    var i,x,a=document.MM_sr; for(i=0;a&&i
                    <a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
                }
                
                function MM_preloadImages(){
                    var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
                    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i
                    <a.length; i++)
                    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
                }
                
                function MM_findObj(n, d){
                    var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                    if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i
                    <d.forms.length;i++) x=d.forms[i][n];
                    for(i=0;!x&&d.layers&&i
                    <d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                    if(!x && d.getElementById) x=d.getElementById(n); return x;
                }
                
                function MM_swapImage(){
                    var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i
                    <(a.length-2);i+=3)
                    if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
                }
            </script>

        </head>
        <body topmargin="0" leftmargin="0" onLoad="MM_preloadImages('');MM_preloadImages('');MM_preloadImages('');MM_preloadImages('')">
            <form name="form_cerrar" action="cerrar_session.php?<?=session_name()."=".session_id()."&fechah=$fechah"?>" target="_parent method=post">
	            <input type='hidden' name='<?=session_name()?>' value='<?=session_id()?>'> 
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="eFrameTop" width="40px">
                    <tr>
                        <td valign="top" >
                            <img name="cabezote_r1_c1" src="imagenes/logo.gif" width=100px height=40px  border="0" alt="" topmargin=0 top=0>
                        </td>
                        <td background="imagenes/cabezote_r1_c2.gif">
			    <DIV style="position: absolute; top: 0px; left: 260px; height:36px; width:50px;"><img src=logoEntidadLogin.png width=100></DIV>
                        </td>
                        <td width="42" background="imagenes/carritoD2.gif" border="0">
                                <div id="carrito" >
                                        <div id="numeroCarrito" title="Carrito de Documentos">
                                            <?=$radActuales?>
                                        </div>
                                        <div id="activar" name="0_carrito" title="Activar Carro de Documentos">
                                            <img src='imagenes/carritoOn.gif' border=0  alt="Activar Carro de Documentos" width=12>
                                        </div>
                                        <div id="inactivar" name="1_carrito" title="Inactivar Carro de Documentos">
                                            <img src='imagenes/carritoOff.gif' border=0   alt="Inactivar Carro de Documentos" width=12>
                                        </div>
                                        <a href="./cuerpoCarrito.php?<?=session_name()."=".session_id()?>" target="mainFrame" width=16>
                                            <div id="carroRadi"></div>           
                                        </a>                     
                                </div>                                                    
                        </td>
                        <td width="52" background="./imagenes/plant.gif">
                            <a href="javascript:nueva()" width=16 ><div id="carroRadi" width=26 height=20 title="Plantillas para Radicacion"></div>  </a>
                        </td>
                        <td width="52"  background="./imagenes/ayuda.gif">
                            <a href="./Manuales/index.php" target="Ayuda_Orfeo" />
			     <div id="carroRadi" width=20px height=42px title="Ayuda OrfeoGPL"></div>  
			    </a>
                        </td>
                        <td width="52" background="./imagenes/info.gif" title="Modificar Datos de Mi Cuenta" />
                            <a href="mod_datos.php?<?=session_name()."=".session_id()."&fechah=$fechah&krd=$krd&info=false"?>" target=mainFrame>
			      <div id="carroRadi" width=20px height=42px></div>  
			    </a>
                        </td>
                        <td width="52" background="imagenes/creditos.gif" title="Creditos">
                            <a href="menu/creditos.php?<?=session_name()."=".session_id()."&fechah=$fechah&krd=$krd&info=false"?>" target=mainFrame>
				      <div id="carroRadi" width=20px height=42px></div>  
			    </a>
                        </td>
			<?php
      if ($_SESSION["autentica_por_LDAP"] == 1)
          $imagen="imagenes/cabezote_r1_c2.gif";  else $imagen="imagenes/contrasena.gif";
  if ($_SESSION["autentica_por_LDAP"] != 1){   
  ?>
  <td width="42" background="<?=$imagen?>">
      <a href='contraxx.php?<?=session_name()."=".session_id()."&fechah=$fechah"?>' target=mainFrame>
   <div id="carroRadi" width=20px height=20 title="Cambio de Password"></div>  
   </a>
  </td>
  <?php
  }
  ?>
                        <td width="42" background="imagenes/estadistic.gif">
                            <a href="./estadisticas/vistaFormConsulta.php?<?=session_name()."=".trim(session_id())."&fechah=$fechah"?>" target=mainFrame>
				    <div id="carroRadi" width=20px height=20 title="Generar Estadisticas / Reportes"></div>  
			    </a>
                        </td>
                        <td width="42" background="imagenes/salir.gif">
                            <a href="cerrar_session.php?<?= session_name()."=".session_id()?>">
			      <div id="carroRadi" width=20px height=42px title="Salir de Orfeo"></div>  
			    </a>
                        </td>
                        <td width="38" background="imagenes/soporte.gif" >
                            <a href="./soporte/index.php?<?=session_name()."=".session_id()."&krd=$krd"?>" target=mainFrame>
			      <div id="carroRadi" width=20px height=42px></div>  
			    </a>
                        </td>
                    </tr>
                </table>
            </form>
        </body>
    </html>
