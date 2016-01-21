/** Inicia o termina la session para grabar radicados en carro
  * @autor Correlibre.org
  * @fecha 2010/08
*/

/*Funcio para crear evento cuando todo el dom este cargado*/   
    $(document).ready(function(){        
        /*Funcion es llamada para los que tengan el name _carrito */
        $("div[name*='_carrito']").click(function(){
            /*Evio de datos para acciones ajax*/
            $.ajax({
                type: "GET",
                url: "include/ajax/ajaxSessionRads.php",
                cache: false,
                data:   "accionSession=" + this.id +
                        "&krd=" + returnKrdF_top(),
                success: function(html){
                        $("#numeroCarrito").html(html);                        
                    } 
            });
        });
    });