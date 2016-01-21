<?php

if (!$ruta_raiz) $ruta_raiz= ".";

if ($numfe&&$numfe!=0){
      
	if ($numerar)
		include("$ruta_raiz/numerar_paquete_anexos.php");
	else if ($radicar&&$radicar_a=="si") 
		include("$ruta_raiz/radicar_paquete_anexos.php");
	else if ($radicar)
		include("$ruta_raiz/genarchivo.php");
	else if($borrar)
		include("$ruta_raiz/borrar_paquete_anexos.php");
}
else {
    
	if ($radicar) 
		include("$ruta_raiz/genarchivo.php");
	else if ($borrar)
		include("$ruta_raiz/borrar_archivos.php");

}
?>