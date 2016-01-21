<?php
session_start();
$_continente=$_GET['continente'];
$_pais=$_GET['pais'];
$_departamento=$_GET['departamento'];
$_municipio=$_GET['municipio'];
$_tipo=$_GET['tipo'];
$ruta_fuente = $_GET['ruta_fuente']?$_GET['ruta_fuente']:".";
include("./include/class/Combos.Class.php");
$obj= new Combos(".",$ruta_fuente);

switch($_tipo)
{
    case "pais":
        $a=$obj->getPaises($_continente,$_val);
    break;
    case "depto":
        $a=$obj->getDepartamentos($_continente,$_pais,$_val);
    break;
    case "mnpio":
        $a=$obj->getMunicipios($_continente,$_pais,$_departamento,$_val);
    break;
    case "todos":
        $a.=$obj->getPaises($_continente,$_pais)."@1";
        $a.=$obj->getDepartamentos($_continente,$_pais,$_departamento)."@2";
        $a.=$obj->getMunicipios($_continente,$_pais,$_departamento,$municipio);
    break;
}
echo $a;
?>
