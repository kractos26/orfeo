<img width="50px" class="img">
<?php
/*Elavorado por Julian Andres Ortiz Morno 
cel 3213006681
 * julecci@gamil.com desarrollador */
 
$ruta_raiz = "../..";
    session_start();
   
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
include './PintarFormulario.php';
include 'cofigpqrs.php';
$db = new ConnectionHandler("$ruta_raiz");	
define('ADODB_FETCH_ASSOC',2);


include('captcha/simple-php-captcha.php');
$_SESSION['captcha_formulario'] = captcha();

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
    $numformulario = (isset($_REQUEST['formulario']))?$_REQUEST['formulario']:1;
    
    $sqlgrupos = "SELECT DISTINCT g.ID,NOMBREGRUPO ,g.DESCRIPCION FROM GRUPOPQR g
                    inner join CAMPOPQR c on
                    g.ID = c.IDGRUPO inner join FORMULARIOCAMPOPQR d on d.IDCAMPO = c.ID
                               where  d.ACTIVO = 1 and d.IDFORMULARIO = $numformulario
    order by g.ID";
    $grupo = $db->query($sqlgrupos);
    $objpintar = new PintarFormulario($ruta_raiz);
     $sqlformularios = "SELECT ID,NOMBRE FROM FORMULARIOPQR";
    
     $formulario = $db->query($sqlformularios);
     
     $publico = ($_REQUEST['ANONIMO'])?1:null;
     
     $sqlvideo="SELECT VALUE,IDCAMPO from   FORMULARIOCAMPOPQR WHERE IDFORMULARIO = $numformulario and TIPOCAMPO = 8 AND ACTIVO = 1";
     
     $video = $db->query($sqlvideo);
   
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sistema de pqrs: grupo: sgc</title>
        <meta charset="ISO-8859-1"/>
        <meta name="description" content="Siste de peticion quejas y reclamos(pqrs) el cual permitira al ciudadano realizar algunos tramites solicitando información de SGC(Servicio Geologico Colombiano)">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <meta name="author" content="Julian Andres Ortiz">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="estilospqrs.css">
        <link rel="stylesheet" href="css/structure2.css" type="text/css" />
        <link rel="stylesheet" href="css/form.css" type="text/css" />
        <link rel="stylesheet" href="css/fineuploader.css" type="text/css" />
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        
        <script src="scripts/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="scripts/bootstrap.min.js" type="text/javascript"></script>
       
        <script type="text/javascript" src="scripts/adminstrador.js"></script>
        <script type="text/javascript" src="scripts/prototype.js" ></script>
        <script type="text/javascript" src="scripts/wufoo.js"></script>
        <script src="scripts/validator.js" type="text/javascript"></script>
        
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="text/javascript" src="scripts/jquery.fineuploader-3.0.js"></script>
        <script type="text/javascript" src="ajax.js">
          
        </script>
        <script>

</script>
        <script>
    window.onload = createUploader;
</script>
          
    </head>
    
    <body>
        <nav class="navbar navbar-default"> 
	<div class="navbar-header"> 
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
		 
                        <span class="icon-bar">
                        </span> <span class="icon-bar">

                        </span>
                         <span class="icon-bar">
	        </button> 
                  
                    <img src="../../logoEntidad.jpg" alt="" class="img-circle">
                
            </div>
          
	
   <div class="row">
   		<div class="collapse navbar-collapse col-xs-12 col-sm-8 col-md-8 " id="example-navbar-collapse"> 
    
    	<ul class="nav navbar-nav"> 
    		<li>
                    <a href="<?= $video->fields['VALUE']?>">Ayuda</a>
					
	        </li>
    		
                                
                               
				
				
         </ul>
 </div> 
 
 
   </div>
    
</nav>
        
        <div class="container"> 
  
            
            <div class="col-sm-8 text-justify">
                <h1>PQRS SISTEMA DE PQRD SERVICIO GEOLOGICO COLOMBIANO </h1>
                <p class="text-justify">El Servicio Geológico Colombiano pone a disposición del público este servicio para recibir y/o resolver sus inquietudes,  felicitaciones, sugerencias, peticiones,
                    quejas, denuncias y reclamos sobre los temas de su competencia.</p>
                
                <p class="text-justify">Para radicar su solicitud diligencie el formulario en línea, a continuación</p>
                <p class="text-justify">Los campos marcados con <span class="astirisco"  > '*'</span> son de carácter obligatorio.</p>
            </div>
        
            <div class="col-sm-8">
          
                <form id="formulariox" data-toggle="validator"  action="formulariotx.php" data-error="holas" method="post" class="form-horizontal" enctype="multipart/form-data" >
            <?php
            $i=0;
            $j=0;
                while(!$grupo->EOF)
                    { $sql = "SELECT c.ID,c.NAME,ETIQUETA,ACTIVO,PUBLICO,OBLIGATORIO,AYUDA,d.EVENTO,d.FUNCIONJS,d.TABLA,d.TIPOCAMPO,d.VALUE,d.OPCION,d.TAMANO from CAMPOPQR c 
                        inner join FORMULARIOCAMPOPQR d on c.Id = d.idcampo
                         WHERE d.IDFORMULARIO = $numformulario and c.IDGRUPO = ".$grupo->fields['ID']." and ACTIVO = 1 and d.TIPOCAMPO != 6 and d.TIPOCAMPO != 8 order by d.PRIORIDAD ";
                         $resultado = $db->query($sql);
                         $j++;
                      ?>

                <h2>
                    <?=$grupo->fields['NOMBREGRUPO']?>
                </h2>
                    <h3><?=$grupo->fields['DESCRIPCION']?></h3>
                    <label id="mensaje<?=$j?>"></label>
                <?php if($grupo->fields['ID']==1){ ?>
                    
                <table  class="table" >
                    
                     
                    <tr>
                    <td class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-4">
                                   <label class="control-label" for="formulario">TIPO DE PQRS </label>
                                </div>
                                <div class="col-sm-7">
                                    <div class="col-sm-1">
                                        &nbsp;&nbsp;
                                    </div>
                                    <div class="col-sm-11">
                                       <?=$objpintar->PintarControles('formulario', "select", "FORMULARIOPQR", "NOMBRE", "ID", "Elija el tipo de pqr", "0", "", "", $numformulario, 0) ?>
                                      

                                    </div>

                                </div>
                            </div>
                        </td>
                                                
                   </tr>
                </table>
                <?php
                    }
                ?>
                <table class="table table-condensed"  >
                  
                    
                    <?php
                    while(!$resultado->EOF){
                        $i++;
                       
                        
                    $clasepubli = ($resultado->fields['PUBLICO'])?"":"privado";
                    ?>
                    <tr class="<?=$clasepubli?>">
                        <td class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-4 text-left">
                                   <label class="control-label text-left" for="<?=$resultado->fields['NAME']?>">
                                        <?= trim($resultado->fields['ETIQUETA'])?> 
                                   </label>
                                </div>
                                <div class="col-sm-7">  
                                    <div class="col-sm-1">
                                       <?=($resultado->fields['OBLIGATORIO'])?"<label class='astirisco' for='".$resultado->fields['NAME']."' title='obligatorio'>*</label>":"&nbsp;&nbsp;"?> 
                                    </div>
                                    <div class="col-sm-11">
                                      <?=$objpintar->PintarControles($resultado->fields['NAME'], $resultado->fields['TIPOCAMPO'],$resultado->fields['TABLA'], $resultado->fields['OPCION'], $resultado->fields['VALUE'],$resultado->fields['AYUDA'],$resultado->fields['OBLIGATORIO'],$resultado->fields['EVENTO'],$resultado->fields['FUNCIONJS'],"",$resultado->fields['TAMANO'],$i)?>
                                    </div>
                                    
                                </div >
                            </div>
                        </td>
                        
                    </tr>
                    <?php
                        $resultado->MoveNext();
                    }
                    ?>
                    
                </table>
                    <?php
                      $grupo->MoveNext();
                    }
                ?>
                <table  class="table" >
                  
                    <tr class="text-left">
                    <td class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-4 " >
                                   <label class="control-label" for="formulario">Autorizo al SGC para realizar el tratamiento de datos personales de conformidad con la política establecida por el SGC?</label>
                                  
                                </div>
                                <div class="col-sm-7">
                                    <div class="col-sm-1">
                                        &nbsp;&nbsp;
                                    </div>
                                    <div class="col-sm-11">
                                       <?=$objpintar->PintarControles('habeasdata', 3,"habeasdata", "NOMBRE","ID","","0","","",$numformulario)?>  
                                        <a href="#" >leer política de tratamiento y protección de datos personales</a>
                                    </div>

                                </div>
                            </div>
                        </td>
                                                
                   </tr>
                </table>
                <?php
                 $sql = "SELECT c.ID,NAME,ETIQUETA,ACTIVO,PUBLICO,OBLIGATORIO,AYUDA,d.EVENTO,d.FUNCIONJS,d.TABLA,d.TIPOCAMPO,d.VALUE,d.OPCION from CAMPOPQR c 
                            inner join FORMULARIOCAMPOPQR d on c.Id = d.idcampo
                         WHERE d.IDFORMULARIO = $numformulario  and ACTIVO = 1 and d.TIPOCAMPO = 6  order by c.ID ";
                 
                $res =  $db->query($sql);
                while(!$res->EOF)
                {
                    
                echo $objpintar->PintarControles($res->fields['NAME'], $res->fields['TIPOCAMPO'],"","", $resultado->fields['VALUE'],$resultado->fields['AYUDA'],$resultado->fields['OBLIGATORIO'],$resultado->fields['EVENTO'],$resultado->fields['FUNCIONJS'],$selectdefault,$tamano,$tabindex);
                     $res->MoveNext();
                }

              ?>
                
                

                <div class="form-group">
                    <input type="hidden" id="adjuntosSubidos" name="adjuntosSubidos"
                    value="" /> &nbsp;</div>
                    <div align="right" id="charNum"></div>
                    <input type="hidden" value="<?=$_SESSION['captcha_formulario']['code']?>" id="capchta2"/>
                    <input type="hidden" value="<?=($_REQUEST['formulario'])?$_REQUEST['formulario']:1?>" name="tdoccodigo"/>
                    <center>
                        <input id="saveForm" type="submit" class="btn btn-primary"  value="ENVIAR" onclick="valida_form();" >
                    
                    </center>
                    
                </div>
           
            </form>
            </div>     
        </div>
            
    </body>
</html>




