/** Fila que graba radicados en la session
  * @autor Correlibre.org aurigadl@gmail.com
  * @fecha 2010/08
*/
    /*Funcio para crear evento cuando todo el dom este cargado*/   
    $(document).ready(function(){
        /*Funcion  que es llamada para los que tengan el name _carrito */                 
        $('input:checkbox').change(function(){                
                ajaxCarriRad($('#'+ this.id).attr('checked'), this.id);
            }            
        );           
    }); 
        
    /* Funcio que realiza el envio para adjuntar o elimnar
     * radicados del carrito
     */    
    function ajaxCarriRad(radAction, raidCarrito){
        var radicados   = raidCarrito; //radicados separados por comas
        var action      = radAction;
                      
        /*Evio de datos para acciones ajax*/
        $.ajax({
            type: "GET",
            url: "include/ajax/ajaxRadSel.php",
            cache: false,
            data:   "accion="   + action +
                    "&rad="     + radicados +
                    "&krd="     + returnKrd(),
            success: function(html){
                        parent.topFrame.document.getElementById('numeroCarrito').innerHTML = html;                        
                    }      
        });
    };
    
    
    //Selecciona todos los radicados de las distintas carpetas
    function markAll(){
        if (document.form1.elements['checkAll'].checked) 
            for (i = 1; i < document.form1.elements.length; i++){
                if(document.form1.elements[i].type == "checkbox"){
                    document.form1.elements[i].checked = 1;
                    ajaxCarriRad(true,document.form1.elements[i].id);    
                }                
            }   
        else 
            for (i = 1; i < document.form1.elements.length; i++){
                if (document.form1.elements[i].type == "checkbox") {
                    document.form1.elements[i].checked = 0;
                    ajaxCarriRad(false,document.form1.elements[i].id);    
                }
            }   
    };