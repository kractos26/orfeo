            
function PostMod(){
    if($('#sl_ciu').is(':visible'))
    {  
       
        if($("#sl_ciu").val()==0){
            document.form1.reset();
             $('#idcont1 > option[value="1"]').attr('selected', 'selected');
              var getNuevoCombo2="<option value='170'>COLOMBIA</option>";
                 $("#idpais1").append(getNuevoCombo2);
                
                $('#idpais1 > option[value="170"]').attr('selected', 'selected');
             $('#idpais1> option[value="170"]').attr('selected', 'selected');
              var getNuevoCombo1="<option value='170-11'>D.C</option>";
                 $("#codep_us1").append(getNuevoCombo1);
             $('#codep_us1 > option[value="170-11"]').attr('selected', 'selected');
            var getNuevoCombo="<option value='170-11-1'>BOGOTA</option>";
            $("#muni_us1").append(getNuevoCombo);
             $('#muni_us1 > option[value="170-11-1"]').attr('selected', 'selected');
          
           
           
        }
        else{
           
            
         
              $.post("CiuEntAux.php",{
                 ModType:$('select[name="ModType"]').val()
                 ,
              ciudadano:$("#sl_ciu").val()
                  ,
                 entidad:$("#sl_ent").val()
                 },function(result){
                $("#SearchResult").empty().html(result);
            });
        }
        
        
    }
    
    else if($('#sl_ent').is(':visible'))
        {   
         
             if($("#sl_ent").val()==0){ 
              document.form1.reset()
                $('#idcont1 > option[value="1"]').attr('selected', 'selected');
                var getNuevoCombo2="<option value='170'>COLOMBIA</option>";
                 $("#idpais1").append(getNuevoCombo2);
                
                $('#idpais1 > option[value="170"]').attr('selected', 'selected');
                 var getNuevoCombo1="<option value='170-11'>D.C</option>";
                 $("#codep_us1").append(getNuevoCombo1);
                $('#codep_us1 > option[value="170-11"]').attr('selected', 'selected');
                var getNuevoCombo="<option value='170-11-1'>BOGOTA</option>";
                $("#muni_us1").append(getNuevoCombo);
                $('#muni_us1 > option[value="170-11-1"]').attr('selected', 'selected');
        } 
        else{
           
             $.post("CiuEntAux.php",{
        ModType:$('select[name="ModType"]').val()
        ,
        ciudadano:$("#sl_ciu").val()
        ,
        entidad:$("#sl_ent").val()
    },function(result){
        $("#SearchResult").empty().html(result);
    });
            
        }
        
         }
        
    
}
function PostModDef(){
    if($("#Codi").val()==""){
                        alert("No se ha seleccionado un registro a modificar");                        
                    }else{ 
                        
           if($("#txt_name").val()=='' || $("#txt_dir").val()=='' ||$("#idcont1").val()=='' || $("#idpais1").val() ==0 || $("#codep_us1").val()==0 || $("#muni_us1").val() ==0 ||   $("#Slc_act").val()==0){
                        alert("Por favor complete todos los campos del registro");                        
                    }else{             
                        
                        
                 var i = 2;
    
     
    $.post("CiuEntAux.php",{
           bandera:i,
        ModType:$('select[name="ModType"]').val()
        ,
        ciudadano:$("#sl_ciu").val()
        ,
        entidad:$("#sl_ent").val()
        ,
        Act:$("#Slc_act").val()
        ,
        nombre:$("#txt_name").val()
        ,
        cc:$("#txt_id").val()
        ,
        primerape:$("#txt_apell1").val()
        ,
        segundoape:$("#txt_apell2").val()
        ,
        correo:$("#txt_mail").val()
        ,
        tel:$("#txt_tel").val()
        ,
        dir:$("#txt_dir").val()
        ,
        codconti:$("#idcont1").val()
        ,
        codciu:$("#idpais1").val()
        ,
        coddep:$("#codep_us1").val()
        ,
        codmuni:$("#muni_us1").val()
        ,
        nit:$("#txt_id").val()
        ,
        sigla:$("#txt_sig").val()
        ,
        repre:$("#txt_rep").val()
        
        
    },function(result){
        $("#SearchResult").empty().html(result);
    });
     }
                    }  
}

function PostInsDef()
{  
 
    
    if($("#txt_name").val()=='' || $("#txt_dir").val()=='' ||$("#idcont1").val()=='' || $("#idpais1").val() ==0 || $("#codep_us1").val()==0 || $("#muni_us1").val() ==0 ||   $("#Slc_act").val()==0){
                        alert("Por favor complete todos los campos del registro");                        
                    }else{
    var i = 1;
     $.post("CiuEntAux.php",{
        bandera:i,
        ModType:$('select[name="ModType"]').val()
        ,
        ciudadano:$("#sl_ciu").val()
        ,
        entidad:$("#sl_ent").val()
        ,
        Act:$("#Slc_act").val()
        ,
        nombre:$("#txt_name").val()
        ,
        cc:$("#txt_id").val()
        ,
        primerape:$("#txt_apell1").val()
        ,
        segundoape:$("#txt_apell2").val()
        ,
        correo:$("#txt_mail").val()
        ,
        tel:$("#txt_tel").val()
        ,
        dir:$("#txt_dir").val()
        ,
        codconti:$("#idcont1").val()
        ,
        codciu:$("#idpais1").val()
        ,
        coddep:$("#codep_us1").val()
        ,
        codmuni:$("#muni_us1").val()
        ,
        nit:$("#txt_id").val()
        ,
        sigla:$("#txt_sig").val()
        ,
        repre:$("#txt_rep").val()
        
    },function(result){
       
        $("#SearchResult").empty().html(result);
    });
}
 }
 
 function PostDelDef(){
    var i = 3;
     $.post("CiuEntAux.php",{
        bandera:i,
        ModType:$('select[name="ModType"]').val()
        ,
        ciudadano:$("#sl_ciu").val()
        ,
        entidad:$("#sl_ent").val()
    },function(result){
       
        $("#SearchResult").empty().html(result);
    });
 
 }