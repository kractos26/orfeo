<?php

$ruta_raiz = "../..";
include "$ruta_raiz/config.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");
if (!defined('ADODB_FETCH_ASSOC'))
    define('ADODB_FETCH_ASSOC', 2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
//$db->conn->debug = true;

include "ImpUsrClass.php";

if ($_POST['ImpDepMenu']) {
    $sql = " select depe_codi,depe_nomb from dependencia where depe_codi not in (select depe_codi from ImpUsrRel where usua_doc='" . $_POST['UsuaDoc'] . "') order by depe_codi ";
    $rs = $db->conn->query($sql);
    if ($rs) {
        $DepMenu = " <select name='ImpDepHab'> ";
        $DepMenu.="<option >Seleccione la(s) dependencias</option>";
        while ($arr = $rs->FetchRow()) {
            $DepMenu.="<option value='" . $arr['DEPE_CODI'] . "'>[" . $arr['DEPE_CODI'] . "]" . $arr['DEPE_NOMB'] . "</option>";
        }
        $DepMenu .= " </select> ";
    } else {
        echo("No quedan mas dependencias por asignar");
    }
    echo $DepMenu;

    //$UsrAux = new ImpUsrClass($db);
    //$UsrAux->ImpUsrFill($_POST['UsuaDoc'], TRUE);
    //echo $UsrAux->select;
    /* if ($_POST['UsuaDoc']) {
      $FunctReload = "<script type=\"text/javascript\" src=\"FunctionsValidar.js\"></script>";
      echo $FunctReload;
      } */
}
if ($_POST['ImpUsrDep']) {
    $UsrAux = new ImpUsrClass($db);
    if ($_POST['New']) {
        $UsrAux->ImpUsrFill($_POST['UsuaDoc'], true);
    } else {
        $UsrAux->ImpUsrFill($_POST['UsuaDoc'], false, true);
    }
    //$ArrayUpdate = "<script type=\"text/javascript\"> ImpDeps=[]; ";
//    $UsrAux = new ImpUsrClass($db);
//    $UsrAux->ImpUsrFill($_POST['UsuaDoc']);

    /* foreach ($ImpAux->Dep as $key => $value) {
      $ArrayUpdate.=" ImpDeps.push(\"" . $value[0] . "\"); ";
      } */
    foreach($UsrAux->Dep as $value){
        $depArray[]=$value[0];
    }
    include "$ruta_raiz/radicacion/crea_combos_universales.php";
    $ArrayUpdate= arrayToJsArray($depArray, "ImpDeps");
    //$ArrayUpdate.= "</script>";
    
    $script = "<script type='text/javascript'>
                $('select[name=\"ImpUsrAsDep\"]').change(function(){
                PostImpDep(\"Del\",$('select[name=\"ImpUsrAsDep\"]').val());
                });
                $('select[name=\"ImpDepHab\"]').change(function(){
                PostImpDep(\"Add\",$('select[name=\"ImpDepHab\"]').val());
                });
                $ArrayUpdate
                </script>";
    echo $UsrAux->select . $script;
    $FunctReload = "<script type=\"text/javascript\" src=\"FunctionsValidar.js\"></script>";
    //echo $FunctReload;
}
if ($_POST['Act'] == 'Add') {
    echo CreateSelect($_POST['ImpDeps'], $db);
    //$UsrAux = new ImpUsrClass($db);
    //$UsrAux->ImpUsrAdd($_POST['UsuaDoc'], $_POST['Dep']);
    //echo (" Hola ");
}
if ($_POST['Act'] == 'Del') {
    echo CreateSelect($_POST['ImpDeps'], $db);
    //$UsrAux = new ImpUsrClass($db);
    //$UsrAux->ImpUsrDel($_POST['UsuaDoc'], $_POST['Dep'][0]);
    //echo (" Hola ");
}
if ($_POST['Def']) {
    $UsrAux = new ImpUsrClass($db);
    $UsrAux->ImpDelAllDeps($_POST['UsuaDoc']);
    $UsrAux->ImpUsrFill($_POST['UsuaDoc']);
    foreach ($_POST['ImpDeps'] as $dep) {
        $UsrAux->ImpUsrAdd($_POST['UsuaDoc'], $dep);
    }

    echo (" Hola ");
}

function CreateSelect($depArray, $db) {
    $sql = " select depe_codi,depe_nomb from dependencia order by depe_codi ";
    $rs = $db->conn->query($sql);
    if ($rs) {
        $DepMenu = " <select name='ImpDepHab'> ";
        $DepMenu.="<option >Seleccione la(s) dependencias</option>";
        while ($arr = $rs->FetchRow()) {
            $esta = Search4($depArray, $arr['DEPE_CODI']);
            if ($esta == false) {
                $DepMenu.="<option value='" . $arr['DEPE_CODI'] . "'>[" . $arr['DEPE_CODI'] . "]" . $arr['DEPE_NOMB'] . "</option>";
            }
        }
        $DepMenu .= " </select> ";
    } else {
        $DepMenu = "No quedan mas dependencias por asignar";
    }

    $DepString = implode(",", $depArray);
    $sql = " select depe_codi, depe_nomb from dependencia where depe_codi in ($DepString) order by depe_codi";
    $rs = $db->conn->query($sql);
    if ($rs) {
        $ImpDepMenu = " <select name = 'ImpUsrAsDep' multiple = 'multiple'> ";
        //$DepMenu.="<option >Seleccione la(s) dependencias</option>";
        while ($arr = $rs->FetchRow()) {
            $ImpDepMenu.="<option value='" . $arr['DEPE_CODI'] . "'>[" . $arr['DEPE_CODI'] . "]" . $arr['DEPE_NOMB'] . "</option>";
        }
        $ImpDepMenu .= " </select> ";
    } else {
        $ImpDepMenu = "No han sido seleccionadas dependencias";
    }
    $script = "<script type='text/javascript'>
                $('select[name=\"ImpUsrAsDep\"]').change(function(){
                PostImpDep(\"Del\",$('select[name=\"ImpUsrAsDep\"]').val());
                });
                $('select[name=\"ImpDepHab\"]').change(function(){
                PostImpDep(\"Add\",$('select[name=\"ImpDepHab\"]').val());
                });
                </script>";
    return $DepMenu . $ImpDepMenu . $script;
}

function Search4($depArray, $Search) {
    $esta = false;
    foreach ($depArray as $key) {
        if ($key == $Search) {
            $esta = true;
            break;
        }
    }
    return $esta;
}

?>