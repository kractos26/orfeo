<?php
function listar_directorios_ruta($ruta)
{

// abrir un directorio y listarlo recursivo
if (is_dir($ruta))
{

    if ($dh = opendir($ruta))
    {
        while (($file = readdir($dh)) !== false)
        {

            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
            //mostraría tanto archivos como directorios
            echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file);
            if (is_dir($ruta .'/'. $file) && $file!="." or  $file!="..")
            {
                //solo si el archivo es un directorio, distinto que “.” y “..”
                echo "<br>Directorio: $ruta/$file";
                listar_directorios_ruta($ruta . $file . "/");
            }
        }
        closedir($dh);
     }
}
else echo "No es ruta valida";
}
$ruta=".";
listar_directorios_ruta($ruta);

?>
