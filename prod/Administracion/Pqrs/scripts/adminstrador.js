/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $(document).ready(function(){
               
                jQuery("#formulario").change(
                        function(){
                            window.location.href = "FormularioCiudadano.php?formulario="+jQuery("#formulario").val();}
                        );
                                              
                        jQuery('.solo-numero').keyup(function (){
                        this.value = (this.value + '').replace(/[^0-9]/g, '');

                          });  
                          
                  jQuery('.solo-correos').blur(function(){
                    if(jQuery(".solo-correos").val().indexOf('@', 0) == -1 || jQuery(".solo_numeros").val().indexOf('.', 0) == -1) {
                          alert('El correo electrónico introducido no es correcto.');
                          
                          return false;
                        }  
                 });
                    
             
     
       
      
             
});

var onloadCallback =  function ()  { 
        grecaptcha . render ( 'html_element' ,  { 
          'sitekey'  :  '6LcoORQTAAAAAHTelY43XFzWfHzWD63GZF0PaXNL' 
        }); 
      };
 function captcha(){
            var v1 = jQuery("input#recaptcha_challenge_field").val();
            var v2 = jQuery("input#recaptcha_response_field").val();
                   
            jQuery.ajax({
                  type: "POST",
                  url: "comprobarrecatcha.php",
                  data: {
                            "recaptcha_challenge_field" : v1, 
                            "recaptcha_response_field" : v2
                  },
                  dataType: "text",
                  error: function(){
                        alert("error petición ajax");
                  },
                  success: function(data){ 
                        alert(data);
                  }
            });
             
      }
                  
                
function desactivarprivados()
                {
                  if(jQuery("#anonimo").is(':checked')) {  
                    jQuery(".privado").hide(); 
                    jQuery("#mensaje2").html("La respuesta a su solicitud le será enviada a través de la dirección de correspondencia o al correo electrónico, por lo tanto verifique que los datos se incluyeron correctamente\n\
                                              Elija el medio por el cual desea recibir la respuesta a su solicitud");
                    } else {  
                    jQuery(".privado").show(); 
                    jQuery("#mensaje2").html("");
                    }  
                   
                   
                }
                
                
                
        


function desplegable(a)
   {   
       if(jQuery("#desplegable_"+a).is(':checked')) {  
        jQuery("#oculto_"+a).hide(); 
        jQuery("#tamano_"+a).hide();
        jQuery("#tipocampo_"+a).hide();
        jQuery("#tipocampo_"+a).val(0);
       }
       else
       {
           jQuery("#oculto_"+a).show(); 
           jQuery("#tamano_"+a).show();
           jQuery("#tipocampo_"+a).show();
       } 
                   
                   
     }
     
function continente()
{
    jQuery("#paisresi").load("combos.php", {campo: 1, valor: jQuery("#continenteresi").val()}, function(){
         
      });
}

     
function paises()
{ 
   
    jQuery("#departamentoresi").load("combos.php", {campo: 2, valor: jQuery("#paisresi").val()}, function(){
         
      });
}
function departamentos()
{
    jQuery("#munisipioresi").load("combos.php", 
    {campo: 3,
        valor:     jQuery("#departamentoresi").val(),
        valorcon:jQuery("#continenteresi").val(),
        valorpais:jQuery("#paisresi").val()
        
    }, function(){
         
      });
}

function continentecontac()
{
    jQuery("#paisconta").load("combos.php", {campo: 1, valor: jQuery("#conticonta").val()}, function(){
         
      });
}

     
function paisescontac()
{ 
   
    jQuery("#departaconta").load("combos.php", {campo: 2, valor: jQuery("#paisconta").val()}, function(){
         
      });
}
function departamentoscontac()
{
    jQuery("#municonta").load("combos.php", 
    {campo: 3,
        valor:     jQuery("#departaconta").val(),
        valorcon:jQuery("#conticonta").val(),
        valorpais:jQuery("#paisconta").val()
        
    }, function(){
         
      });
}
     
 
function usuariooempresa()
{    
    if(jQuery("#tipoid").val() == 4)
    {
      jQuery("#segunnombre").attr('disabled','disabled');
      jQuery("#primerapellido").attr('disabled','disabled');
      jQuery("#segundoapellido").attr('disabled','disabled');
      jQuery("#numid").attr('min','8000000000');
      jQuery("#numid").attr('max','9999999999');
    }
    else
    {
         jQuery("#segunnombre").removeAttr('disabled');
         jQuery("#primerapellido").removeAttr('disabled');
         jQuery("#segundoapellido").removeAttr('disabled');
         jQuery("#numid").removeAttr('min');
         jQuery("#numid").removeAttr('max');
    }
}
        
 function sololetras(a)
 {
     
 }
 
 
 function oculto(a)
 {
     if(jQuery("#oculto_"+a).is(':checked')) {  
        jQuery("#desplegable_"+a).hide(); 
        jQuery("#tamano_"+a).hide();
        jQuery("#tipocampo_"+a).hide();
        jQuery("#tipocampo_"+a).val(0);
       }
       else
       {
           jQuery("#desplegable_"+a).show(); 
           jQuery("#tamano_"+a).show();
           jQuery("#tipocampo_"+a).show();
       } 
 }
 function tipocampo(a)
 {
    if(jQuery("#tipocampo_"+a).val() > 0)
    {
        jQuery("#desplegable_"+a).hide(); 
        jQuery("#oculto_"+a).hide();
    }
    else
    {
       jQuery("#desplegable_"+a).show(); 
        jQuery("#oculto_"+a).show();
    }
 }