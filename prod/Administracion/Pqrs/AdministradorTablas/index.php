
<!DOCTYPE html>
<html>
	<head>
            
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap2.css" rel="stylesheet" type="text/css"/>
    <title>Administración de pqr</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript">
     $(document).ready(function(){
          $("#Guardar").click(function(){
             if($('#contenido').val() == null || $('#contenido').val() == ""){
                 $('#mensage').html("El contenido esta vacido");
                 return false;
             }
             if($("#tablas").val() == 0){
                  $('#mensage').html("no ha selecionado la tabla");o
                  return false;
             }
               $.ajax({
                 type: "POST",
                 url: "adm_tablas.php",
                 data:{tabla:$("#tablas").val(),
                     contenido:$("#contenido").val(),
                     textabla:$("#tablas option:selected").html()
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
               
                $("#tablas").change(function(){
              
               $.ajax({
                 type: "POST",
                 url: "adm_tablas.php",
                 data:{tabla:$("#tablas").val(),
                     contenido:$("#contenido").val(),
                     textabla:$("#tablas option:selected").html(),
                     listar:1
                 },
                 success: function (data) {
                        
                        $('#listar').html(data);
                    },
                    error: function(e) {
	//called when there is an error
                    alert(e.message);
                    console.log(e.message);
                 }         
             });
               



          });
          
          
            $("#contenido").keypress(function(){
              $.ajax({
                 type: "POST",
                 url: "adm_tablas.php",
                 data:{tabla:$("#tablas").val(),
                     contenido:$("#contenido").val(),
                     textabla:$("#tablas option:selected").html(),
                     listar:2
                 },
                 success: function (data) {
                        
                        $('#listar').html(data);
                    },
                    error: function(e) {
	//called when there is an error
                    alert(e.message);
                    console.log(e.message);
                 }      
              
          });
       });       
      

 
       });       
      
       function eliminar(ex)
          {
              $.ajax({
                 type: "POST",
                 url: "adm_tablas.php",
                 data:{tabla:$("#tablas").val(),
                       id:ex,
                     textabla:$("#tablas option:selected").html(),
                     eliminar:1
                 },
                 success: function (data) {
                        
                        $('#listar').html(data);
                    },
                    error: function(e) {
	//called when there is an error
                    alert(e.message);
                    console.log(e.message);
                 }         
             });
          }
          
          function DesactivarActivar(ex,val){
              $.ajax({
                 type: "POST",
                 url: "adm_tablas.php",
                 data:{tabla:$("#tablas").val(),
                       id:ex,
                       textabla:$("#tablas option:selected").html(),
                       activar:1,
                       valor:val
                 },
                 success: function (data) {
                        
                        $('#listar').html(data);
                    },
                    error: function(e) {
	//called when there is an error
                    alert(e.message);
                    console.log(e.message);
                 }         
             });
          }
      </script>
    <script src="../scripts/bootstrap.min.js" type="text/javascript"></script>
	</head>
	<body>
	
<?php include './menu.php';?>

<div class="page-header">
  <h1>ADMINISTRADOR DE TABLAS </h1>
</div>
<div class="col-sm-6">
    
  <form   role="form" class="form-horizontal" >
           
                
                <tr>
                    <td class="text-left ">
                        <div class="form-group">
                          <label class="control-label " for="email">Selecione la tabla:</label> 
                    
                        
                            <select id="tablas" class="form-control">
                                <option value="0">
                                    Seleccione
                                </option>
                                <option value="1">
                                    profesion
                                </option>
                                <option value="2">
                                    Cargo
                                </option>
                                <option value="3">
                                    Asunto
                                </option>
                                <option value="3">
                                    formulariopqr
                                </option>
                            </select>
                        </div>
                      
                    </td>
                </tr>
                <tr>
                    <td class="text-left ">
                        <div class="form-group">
                        <label class="control-label " for="contenido">Ingrese el Contenido:</label> 
                   
                        
                            <input id="contenido" value="" class="form-control"/>
                       
                        </div> 
                    </td>
                </tr>
                
                 
                <br>
    
      

  </form>
    <button id="Guardar" class="btn-primary" >Guardar</button>
    <br>
    <br>
<!--       <button id="Listar" class="btn-primary">Listar</button>-->
  <div id="mensage"></div>
<div id="listar">     
</div>

    
</div>
<!-- Columns are always 50% wide, on mobile ancd desktop -->
		
	
	</body>
</html>
