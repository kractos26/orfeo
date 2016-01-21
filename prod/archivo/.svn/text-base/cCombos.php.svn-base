<?php
$_continente=$_GET['continente'];
$_pais=$_GET['pais'];
$_departamento=$_GET['departamento'];
$_tipo=$_GET['tipo'];
include("Combos.Class.php");
$obj= new Combos();

switch($_tipo)
{
    case "pais":
        $a=$obj->getPaises($_continente);
    break;
    case "depto":
        $a=$obj->getDepartamentos($_continente,$_pais);
    break;
    case "mnpio":
        $a=$obj->getMunicipios($_continente,$_pais,$_departamento);
    break;
}
echo $a;
?>
