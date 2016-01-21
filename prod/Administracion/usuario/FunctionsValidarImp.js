/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$('input[name="impresion"]').change(function(){
    if($('input[name="impresion"]:checked').val() == 2){
        $("#ImpDepMenu").show();
        $("#ImpAux").show();
        PostImpMenu();               
    }else{
        $("#ImpDepMenu").empty();
        $("#ImpAux").empty();
    }
});
/*Permisos de Impresion*/
function PostImpMenuNew(){
    /*ImpDepMenu*/
    $("#ImpDepMenu").empty();
    $("#ImpAux").empty();
    $.post("ImpUsrAux.php",{
        UsuaDoc:UsuaDoc,
        ImpDepMenu:true,
        New:true
    },function(result){
        $("#ImpDepMenu").empty().html(result);
        PostImpDepsNew();
    });
}
function PostImpDepsNew(){
    /*ImpUsrDep*/
    $.post("ImpUsrAux.php",{
        UsuaDoc:UsuaDoc,
        ImpUsrDep:true,
        New:true
    },function(){
        PostImpMenu();
    });
/*
     *,function(result){
        //$("#ImpAux").empty().html(result);
        }
     **/
}
function PostImpMenu(){
    /*ImpDepMenu*/
    $("#ImpDepMenu").empty();
    $("#ImpAux").empty();
    $("#ImpAux").show();
    $.post("ImpUsrAux.php",{
        UsuaDoc:UsuaDoc,
        ImpDepMenu:true
    },function(result){
        $("#ImpDepMenu").empty().html(result);
        PostImpDeps();
    });
}
function PostImpDeps(){
    /*ImpUsrDep*/
    $.post("ImpUsrAux.php",{
        UsuaDoc:UsuaDoc,
        ImpUsrDep:true
    },function(result){
        $("#ImpAux").empty().html(result);
    });
}
function PostImpDep(Act,dep){
    $("#ImpAux").hide();
    if(Act=="Add"){
        if(ImpDeps!=null){
            var esta=BuscaData(ImpDeps,dep);
        }else{
            esta=false;
        }
        if(esta==false){
            ImpDeps.push(dep);
        }
    }else if(Act=="Del"){
        ImpDeps=Elim(ImpDeps,dep);   
    }
    $.post("ImpUsrAux.php",{
        Act: Act,
        UsuaDoc:UsuaDoc,
        Dep:dep,
        ImpDeps:ImpDeps
    },function(result){
        $("#ImpDepMenu").html(result);
    });
}
function PostImpDef(){
    $.post("ImpUsrAux.php",{
        Def:true,
        UsuaDoc:UsuaDoc,
        ImpDeps:ImpDeps
    },function(){
        PostImpMenu();
    });
/*
     *,function(result){
        //$("#ImpAux").empty().html(result);
    }
 **/
}
