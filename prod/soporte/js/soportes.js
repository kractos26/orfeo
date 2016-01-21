/**
 * @author aurigadl@gmail.com
 * @projectDescription Manejo de eventos para enviar formulario de soporte ajax
 */

    //Evento y accion de ajax para crear un soporte
    
    $(document).ready(function(){
        var options1 = {
            target: '#output1',                 // updated with server response            
            //success: showResponse,              // post-submit callback            
            url: './requestAjax/soporte.php',   // override for form's 'action' attribute 
            type: 'post',                       // 'get' or 'post'
            resetForm: true                     // reset the form after successful submit
            //dataType: 'json',                 // 'xml', 'script', or 'json' (expected server response type) 
            //clearForm: true                   // clear all form fields after successful submit        
            //$.ajax options can be used here too, for example: 
            //timeout:   3000 
        };     
        // bind form using 'ajaxForm' 
        $('#creSoporte').ajaxForm(options1);
        
        
        
        //Evento y ajax para mostrar los comentarios
        
        $("input[name*='ticket']").click(function() {
            //identificacion del formulario y del div
            //al cual se adjunta la respuesta
            var idForm = parseInt(this.name);
                        
            var options2 = {
                target: '#' + idForm + '_resul',    // updated with server response            
                //success: showResponse,              // post-submit callback            
                url: './requestAjax/comentarios.php',   // override for form's 'action' attribute 
                type: 'post',                       // 'get' or 'post'
                resetForm: true                     // reset the form after successful submit
                //dataType: 'json',                 // 'xml', 'script', or 'json' (expected server response type) 
                //clearForm: true                   // clear all form fields after successful submit        
                //$.ajax options can be used here too, for example: 
                //timeout:   3000 
            };
            
            // bind form using 'ajaxForm'
            $('#' + idForm).ajaxForm(options2);            
        });
        
        
        //Evento y ajax para crear  un comentario y cerrar ticket 
        
        $("input[name*='_coment']").click(function(){
            //identificacion del formulario y del div
            //al cual se adjunta la respuesta            
            var idForm = parseInt(this.name);     
                        
            var options3 = {
                target: '#' + 'outputCom_' + idForm,    // updated with server response            
                url: './requestAjax/grabComent.php',   // override for form's 'action' attribute 
                type: 'post',                           // 'get' or 'post'
                resetForm: true                         // reset the form after successful submit
                //dataType: 'json',                     // 'xml', 'script', or 'json' (expected server response type) 
                //clearForm: true                       // clear all form fields after successful submit        
                //$.ajax options can be used here too, for example: 
                //timeout:   3000 
            };
            
            // bind form using 'ajaxForm'
            $('#' + 'coment_' + idForm).ajaxForm(options3);            
        });
      
	  	//Contador de texto para los soportes
		$("textarea").charCounter(600, {
			container: "#contador",
			format: "%1 caracteres digitados!",
			pulse: false,
			delay: 100
		});

        $("input[name='actualizar']").click(function(){
            location.reload(true);  
        });
        
        $("select[name='pagNo'],input[name='cantidad']").change(function(){
            document.ordSopor.submit() 
        });
    });
