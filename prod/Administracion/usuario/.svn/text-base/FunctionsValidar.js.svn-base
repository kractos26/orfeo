/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*Permisos de Impresion*/
function PostImpMenuNew(){
    /*ImpDepMenu*/
    $("#ImpDepMenu").empty();
    $("#ImpAux").empty();
    $.post("ImpUsrAux.php",{
        UsuaDoc:UsuaDoc,
        ImpDepMenu:true
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
    },function(result){
        $("#ImpAux").empty().html(result);
    });
}
function PostImpMenu(){
    /*ImpDepMenu*/
    $("#ImpDepMenu").empty();
    $("#ImpAux").empty();
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
    $.post("ImpUsrAux.php",{
        Act: Act,
        UsuaDoc:UsuaDoc,
        Dep:dep
    },function(){
        PostImpMenu();
    });
}
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
    },function(result){
        $("#SuperDep").empty().html(result);
    });
}
function PostSecMenu(){
    /*DepMenu*/
    $("#DepMenu").empty();
    $("#SuperDep").empty();
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
    $.post("SecSpcUsrAux.php",{
        Act: Act,
        UsuaDoc:UsuaDoc,
        Dep:dep
    },function(){
        PostSecMenu();
    });
}
$('input[name="impresion"]').change(function(){
    if($('input[name="impresion"]:checked').val() == 2){
        PostImpMenuNew();               
    }else{
        $("#ImpDepMenu").empty();
        $("#ImpAux").empty();
    }
});
/*$('select[name="ImpUsrAsDep"]').change(function(){
    PostImpDep("Del",$('select[name="ImpUsrAsDep"]').val());
});
$('select[name="ImpDepHab"]').change(function(){
    PostImpDep("Add",$('select[name="ImpDepHab"]').val());
});*/

$('input[name="usua_super"]').change(function(){
    if($('input[name="usua_super"]:checked').val() == 2){
        PostSecMenuNew();               
    }else{
        $("#DepMenu").empty();
        $("#SuperDep").empty();
    }
});
/*$('select[name="UsrAsDep"]').change(function(){
    PostSecDep("Del",$('select[name="UsrAsDep"]').val());
});
$('select[name="DepHab"]').change(function(){
    PostSecDep("Add",$('select[name="DepHab"]').val());
});*/

/*$('input[name="impresion"]').change(function(){
    if($('input[name="impresion"]:checked').val() == 2){
        PostImpDepMenu();               
    }else{
        $("#ImpDepMenu").empty();
        $("#ImpAux").empty();
        $("#SuperDep").empty();
    }
});

$('input[name="usua_super"]').change(function(){
    if($('input[name="usua_super"]:checked').val() == 2){
        PostUsrDepMenu();               
    }else{
        $("#DepMenu").empty();
        $("#ImpAux").empty();
        $("#SuperDep").empty();
    }
});

$('select[name="UsrAsDep"]').change(function(){
    $("#ImpAux").empty();
    $("#SuperDep").empty();
    PostDep("Del",$('select[name="UsrAsDep"]').val());
});
$('select[name="DepHab"]').change(function(){
    $("#ImpAux").empty();
    $("#SuperDep").empty();
    PostDep("Add",$('select[name="DepHab"]').val());
});

$('select[name="ImpUsrAsDep"]').change(function(){
    $("#ImpAux").empty();
    PostImpDep("Del",$('select[name="ImpUsrAsDep"]').val());
});
$('select[name="ImpDepHab"]').change(function(){
    $("#ImpAux").empty();
    $("#SuperDep").empty();
    PostImpDep("Add",$('select[name="ImpDepHab"]').val());
});

function PostDep(Act,dep){
    $.post("SecSpcUsrAux.php",{
        Act: Act,
        UsuaDoc:UsuaDoc,
        Dep: dep
    },function(result){
        $("#SuperDep").empty();
        $("#SuperDep").empty().html(result);
    });
}

function PostDepMenu(){
    $.post("SecSpcUsrAux.php",{
        UsuaDoc:UsuaDoc,
        DepMenu:true
    },function(result){
        $("#SuperDep").empty();
        $("#DepMenu").empty().html(result);
    });
}
function PostImpDepMenu(){
    $.post("ImpUsrAux.php",{
        UsuaDoc:UsuaDoc,
        ImpDepMenu:true
    },function(result){
        $("#ImpDepMenu").empty().html(result);
    });
}
function PostUsrDepMenu(){
    $.post("SecSpcUsrAux.php",{
        UsuaDoc:UsuaDoc,
        SuperDep:true
    },function(result1){
        $("#SuperDep").empty().html(result1);
    });
}

function PostImpDepMenuStart(){
    $.post("ImpUsrAux.php",{
        UsuaDoc:UsuaDoc,
        ImpDepMenu:true
    },function(result){
        $("#ImpDepMenu").empty().html(result);
    });
}
function PostUsrDepMenuStart(){
    $.post("SecSpcUsrAux.php",{
        UsuaDoc:UsuaDoc,
        SuperDep:true
    },function(result1){
        $("#SuperDep").empty().html(result1);
    });
}*/

