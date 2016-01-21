<?php
$ruta_raiz = "../..";
include "$ruta_raiz/config.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");
if (!defined('ADODB_FETCH_ASSOC'))
    define('ADODB_FETCH_ASSOC', 2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
//$db->conn->debug = true;

include "SecSuperClass.php";

if ($_POST['DepMenu']) {
    $sql = " select depe_codi,depe_nomb from dependencia where depe_codi not in (select depe_codi from UsrSuperRel where usua_doc='" . $_POST['UsuaDoc'] . "') order by depe_codi ";
    $rs = $db->conn->query($sql);
    if ($rs) {
        $DepMenu = " <select name='DepHab'> ";
        $DepMenu.="<option >Seleccione la(s) dependencias</option>";
        while ($arr = $rs->FetchRow()) {
            $DepMenu.="<option value='" . $arr['DEPE_CODI'] . "'>[" . $arr['DEPE_CODI'] . "]" . $arr['DEPE_NOMB'] . "</option>";
        }
        $DepMenu .= " </select> ";
    } else {
        echo("No quedan mas dependencias por asignar");
    }
    echo $DepMenu;
    /* $UsrAux = new SecSuperClass($db);
      $UsrAux->SecSuperFill($_POST['UsuaDoc'], TRUE);
      echo $UsrAux->select;
      if ($_POST['UsuaDoc']) {
      $FunctReload = "<script type=\"text/javascript\" src=\"FunctionsValidar.js\"></script>";
      echo $FunctReload;
      } */
}
if ($_POST['SuperDep']) {
    $UsrAux = new SecSuperClass($db);
    if ($_POST['New']) {
        $UsrAux->SecSuperFill($_POST['UsuaDoc'], true);
    } else {
        $UsrAux->SecSuperFill($_POST['UsuaDoc'], false, TRUE);
    }
    foreach($UsrAux->Dep as $value){
        $depArray[]=$value[0];
    }
    include "$ruta_raiz/radicacion/crea_combos_universales.php";
    $ArrayUpdate= arrayToJsArray($depArray, "SuperDeps");
    $script = "<script type='text/javascript'>
                $('select[name=\"UsrAsDep\"]').change(function(){
                PostSecDep(\"Del\",$('select[name=\"UsrAsDep\"]').val());
                });
                $('select[name=\"DepHab\"]').change(function(){
                PostSecDep(\"Add\",$('select[name=\"DepHab\"]').val());
                });
                $ArrayUpdate
                </script>";
    echo $UsrAux->select . $script;
    $FunctReload = "<script type=\"text/javascript\" src=\"FunctionsValidar.js\"></script>";
    //echo $FunctReload;
}
if ($_POST['Act'] == 'Add') {
    echo CreateSelect($_POST['SuperDeps'], $db);
    //$UsrAux = new SecSuperClass($db);
    //$UsrAux->SecSuperAdd($_POST['UsuaDoc'], $_POST['Dep']);
    //echo (" Hola ");
}
if ($_POST['Act'] == 'Del') {
    echo CreateSelect($_POST['SuperDeps'], $db);
    //$UsrAux = new SecSuperClass($db);
    //$UsrAux->SecSuperDel($_POST['UsuaDoc'], $_POST['Dep'][0]);
    //echo (" Hola ");
}
if ($_POST['Def']) {
    $UsrAux = new SecSuperClass($db);
    $UsrAux->SecDelAllDeps($_POST['UsuaDoc']);
    foreach ($_POST['SuperDeps'] as $dep) {
        $UsrAux->SecSuperAdd($_POST['UsuaDoc'], $dep);
    }

    echo (" Hola ");
}

function CreateSelect($depArray, $db) {
    $sql = " select depe_codi,depe_nomb from dependencia order by depe_codi ";
    $rs = $db->conn->query($sql);
    if ($rs) {
        $DepMenu = " <select name='DepHab'> ";
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
        $SecDepMenu = " <select name = 'UsrAsDep' multiple = 'multiple'> ";
        //$DepMenu.="<option >Seleccione la(s) dependencias</option>";
        while ($arr = $rs->FetchRow()) {
            $SecDepMenu.="<option value='" . $arr['DEPE_CODI'] . "'>[" . $arr['DEPE_CODI'] . "]" . $arr['DEPE_NOMB'] . "</option>";
        }
        $SecDepMenu .= " </select> ";
    } else {
        $SecDepMenu = "No han sido seleccionadas dependencias";
    }
    $script = "<script type='text/javascript'>
                $('select[name=\"UsrAsDep\"]').change(function(){
                PostSecDep(\"Del\",$('select[name=\"UsrAsDep\"]').val());
                });
                $('select[name=\"DepHab\"]').change(function(){
                PostSecDep(\"Add\",$('select[name=\"DepHab\"]').val());
                });
                </script>";
    return $DepMenu . $SecDepMenu . $script;
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
