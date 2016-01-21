<?
/**
 * Programa que actualiza la variable que almacena la selecci�n que ha efectuado el usuario desce resultConsultaESP.php
 * @author      Sixto Angel Pinz�n
 * @version     1.0
 */

session_start();

//variable que almacena la cantidad de empresas seleccionadas en el formulario
$num = count($check_value);
$i = 0; 
//almacena todos los elementos seleccionados desde el formulario
$seleccTodos="";
//almacena todos los contactos de los elementos seleccionados desde el formulario
$seleccTodos_idcct="";
//Recorre el arreglo de elementos seleccionados desde el formulario
$tmp_cad1 = "selected".$_POST['slc_tb'];
$tmp_cad2 = "selectedctt".$_POST['slc_tb'];
$selected = ${$tmp_cad1};
$selectedctt = ${$tmp_cad2};

while ($i < $num)
{	$idEntCiuSelec = key($check_value);
	if (isset($slc_ctt) && is_array($slc_ctt[$idEntCiuSelec]))
	{	//Recorremos todos los contactos seleccionados
		for($idContacto=0; $idContacto<count($slc_ctt[$idEntCiuSelec]); $idContacto++)
		{	//si no hay previos seleccionados
			if (empty($selected))
			{
				$totalCodEntCiuSelec .= $idEntCiuSelec . ",";
				$totalCodContacSelec .= $slc_ctt[$idEntCiuSelec][$idContacto]. ",";
			}
			else
			{
				if (array_search($slc_ctt[$idEntCiuSelec][$idContacto],explode(",", $selectedctt)) === FALSE)
				{
					$totalCodEntCiuSelec .= $idEntCiuSelec . ",";
					$totalCodContacSelec .= $slc_ctt[$idEntCiuSelec][$idContacto]. ",";
				}
			}
		}
	}
	else
	{
		$totalCodEntCiuSelec .= $idEntCiuSelec . ",";
		$totalCodContacSelec .= "0,";
	}
	next($check_value); 		
	$i++;
}

if (strlen($totalCodEntCiuSelec)>1)	$seleccNuevacct=$totalCodEntCiuSelec . $selected; 
if (strlen($totalCodContacSelec)>1)	$selectedFinalcct = $totalCodContacSelec . $selectedctt;

if (substr(trim($seleccNuevacct), -1) == ",") $seleccNuevacct = substr($totalCodEntCiuSelec,0,strlen($totalCodEntCiuSelec)-1);
if (substr(trim($selectedFinalcct), -1) == ",") $selectedFinalcct=substr($totalCodContacSelec,0,strlen($totalCodContacSelec)-1);

//se actualiza la variable que almacena la la selecci�n global
${$tmp_cad1} = $seleccNuevacct;
${$tmp_cad2} = $selectedFinalcct;

unset($tmp_cad1); unset($tmp_cad2);
require_once("consultaESP.php");
?>