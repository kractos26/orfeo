/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$('input[name="usua_super"]').change(function(){
    if($('input[name="usua_super"]:checked').val() == 2){
        $("#DepMenu").show();
        $("#SuperDep").show();
        PostSecMenu();               
    }else{
        $("#DepMenu").empty();
        $("#SuperDep").empty();
    }
});
/*Dependencias de Super usuarios*/
function PostSecMenuNew(){
    /*DepMenu*/
    $("#DepMenu").empty();
    $("#SuperDep").empty();
    $.post("SecSpcUsrAux.php",{
        UsuaDoc:UsuaDoc,
        DepMenu:true,
        New:true
    },function(result){
        $("#DepMenu").empty().html(result);
        PostSecDepsNew();
    });
}
function PostSecDepsNew(){
    /*SuperDep*/
    $.post("SecSpcUsrAux.php",{
        UsuaDoc:UsuaDoc,
        SuperDep:true,
        New:true
    },function(){
        PostSecMenu();
        document.frmPermisos.submit();
    });
/*,function(result){
        $("#SuperDep").empty().html(result);
    }
     **/
}
function PostSecMenu(){
    /*DepMenu*/
    $("#DepMenu").empty();
    $("#SuperDep").empty();
    $("#SuperDep").show();
    $.post("SecSpcUsrAux.php",{
        UsuaDoc:UsuaDoc,
        DepMenu:true
    },function(result){
        $("#DepMenu").empty().html(result);
        PostSecDeps();
    });
}
function PostSecDeps(){
    /*SuperDep*/
    $.post("SecSpcUsrAux.php",{
        UsuaDoc:UsuaDoc,
        SuperDep:true
    },function(result){
        $("#SuperDep").empty().html(result);
    });
}
function PostSecDep(Act,dep){
    $("#SuperDep").hide();
    if(Act=="Add"){
        if(SuperDeps!=null){
            var esta=BuscaData(SuperDeps,dep);
        }else{
            esta=false;
        }
        if(esta==false){
            SuperDeps.push(dep);
        }
    }else if(Act=="Del"){
        SuperDeps=Elim(SuperDeps,dep);   
    }
    $.post("SecSpcUsrAux.php",{
        Act: Act,
        UsuaDoc:UsuaDoc,
        Dep:dep,
        SuperDeps:SuperDeps
    },function(result){
        $("#DepMenu").html(result);
    });
}
function PostSecDef(){
    $.post("SecSpcUsrAux.php",{
        Def:true,
        UsuaDoc:UsuaDoc,
        SuperDeps:SuperDeps
    },function(){
        PostSecMenu();
        document.frmPermisos.submit();
    });
}
