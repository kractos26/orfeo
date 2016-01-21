<?php 
    $ruta_raiz = "../../..";
    include_once "$ruta_raiz/include/db/ConnectionHandler.php";
	
    define('ADODB_FETCH_ASSOC',2);
    $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
    $db = new ConnectionHandler("$ruta_raiz");
    
    $sqlgrupos = "SELECT NOMBREGRUPO,ID FROM GRUPOPQR";
    $grupos=$db->query($sqlgrupos);
    $lista= $grupos->GetMenu2( $name,"selecione",true, false, 0,'class="form-control" id="grupo"' );

?>

<!DOCTYPE html>
<html lang="es">
	<head>
            
         <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript">
     $(document).ready(function(){
          $("#Guardar").click(function(){
             if($('#contenido').val() == null || $('#contenido').val() == ""){
                 $('#mensage').html("El contenido esta vacido");
                 
                 return false;
             }
             if($('#contenido').val().length > 150){
                  $('#mensage').html("Ingrese un contenido mas resumido que no pase de 150 caractes");
                  return false;
             }
             if($("#grupo").val() == 0){
                  $('#mensage').html("no ha selecionado el grupo");o
                  return false;
             }
               $.ajax({
                 type: "POST",
                 url: "descripciongrupos.php",
                 data:{tabla:$("#tablas").val(),
                     contenido:$("#contenido").val(),
                     textabla:$("#grupo").val()
                 },
                 success: function (data) {
                        
                        $('#mensage').html(data);
                    },
                    error: function(e) {
	//called when there is an error
                    alert(e.message);
                    console.log(e.message);
                 }         
             });
               



               });
               
//                $("#Listar").click(function(){
//              
//               $.ajax({
//                 type: "POST",
//                 url: "adm_tablas.php",
//                 data:{tabla:$("#tablas").val(),
//                     contenido:$("#contenido").val(),
//                     textabla:$("#tablas option:selected").html(),
//                     listar:1
//                 },
//                 success: function (data) {
//                        
//                        $('#listar').html(data);
//                    },
//                    error: function(e) {
//	//called when there is an error
//                    alert(e.message);
//                    console.log(e.message);
//                 }         
//             });
//               



//               });

 
       });       
      

      </script>
  <script src="../scripts/bootstrap.min.js" type="text/javascript"></script>
	</head>
	<body>
	

<!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
<?php  include './menu.php';?>
<div class="page-header">
    <h1>DESCRIPCI&Oacute;N DE GRUPOS </h1>
</div>
<div class="col-sm-6">
    
  <form   role="form"  class="form-horizontal" >
            <table class="table">
                
                <tr>
                    <td class="text-left ">
                        <div class="form-group">
                          <label class="control-label" for="email">Seleccione la tabla:</label> 
                    
                        
                            <?=$lista?>
                        
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <div class="form-group">
                        <label class="control-label " for="contenido">Ingrese el Contenido:</label> 
                    
                        
                            <textarea id="contenido" value="" class="form-control" cols="150"></textarea>
                        </div>
                    </td>
                </tr>
                
                 
            </table>
    
      

  </form>
    <button id="Guardar" class="btn-primary" >Guardar</button>
<!--       <button id="Listar" class="btn-primary">Listar</button>-->
  <div id="mensage"></div>
<div id="listar">     
</div>

    
</div>
<!-- Columns are always 50% wide, on mobile ancd desktop -->
		
	
	</body>
</html>
