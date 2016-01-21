<?php
$dir = ".";

// Abrir un directorio conocido, y proceder a leer sus contenidos
if (is_dir($dir)) {
    if ($gd = opendir($dir)) {
        while (($archivo = readdir($gd)) !== false) {
            echo "nombre de archivo: $archivo : tipo de archivo: " . filetype($dir . $archivo) . "<br>";
        }
        closedir($gd);
    }
}
?>

