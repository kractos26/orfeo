<?php 
session_start();

    $ruta_raiz = ".";
    if (!$_SESSION['dependencia'])
        header ("Location: $ruta_raiz/cerrar_session.php");
include("config.php");
include("include/class/Plantillas.class.php");
include_once "include/db/ConnectionHandler.php";

$db = new ConnectionHandler($ruta_raiz);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);

$plantillas = scandir("./".$carpetaBodega."Ayuda/plantillas");
    
foreach ($_POST as $key => $valor) ${$key} = $valor;

$direcTor = "$ruta_raiz/poolsgc2013/plantillas/";
$archivo1 = $direcTor."combiSencilla.xml";
$archivo2 = $direcTor."combiMasiva.xml";
$archivo3 = $direcTor."plantillas.xml";

$doc    = new DOMDocument();

if(file_exists($archivo3)){
    $doc->load($archivo3);
    $campos     = $doc->getElementsByTagName("campo");
    foreach($campos as $campo){
        $campTemp1 = $campo->getElementsByTagName("nombre");
        $campTemp2 = $campo->getElementsByTagName("ruta");
        $temp1     = $campTemp1->item(0)->nodeValue;
        $temp2     = $campTemp2->item(0)->nodeValue;
        
        $plantill  .= "&nbsp; &nbsp;<a href='".$direcTor.$temp2."'>".$temp1."</a><br/>";
    }
}else{
    $msg  .= " No se abrio el archivo $archivo3 generado desde la administracion de plantillas</br>";
}

if(file_exists($archivo2)){
    $doc->load($archivo2);
    $campos     = $doc->getElementsByTagName("campo");
    foreach($campos as $campo){
        $campTemp = $campo->getElementsByTagName("nombre");
        $valor    = $campTemp->item(0)->nodeValue;
        $nombMa   .= empty($nombSe)? " &nbsp; &nbsp; $valor" : "&nbsp; &nbsp;  &nbsp; &nbsp; $valor ";
    }
}else{
    $msg  .= " No se abrio el archivo $archivo2 generado desde la administracion de plantillas</br>";
}

if(file_exists($archivo1)){
    $doc->load($archivo1);
    $campos     = $doc->getElementsByTagName("campo");
    foreach($campos as $campo){
        $campTemp = $campo->getElementsByTagName("nombre");
        $valor    = $campTemp->item(0)->nodeValue;
        $nombSe   .= empty($nombSe)? "&nbsp; &nbsp;$valor" : " &nbsp; &nbsp; $valor ";
    }
}else{
    $msg  .= " No se abrio el archivo $archivo1 generado desde la administracion de plantillas</br>";
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
    <title> :) Plantillas A Usar en Orfeo :)</title>
    <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
    </head>
    <body>
        <table width="100%" border="0" cellspacing="5" cellpadding="0" align="center" class="borde_tab">
            <tr align="center"  class="titulos4"> 
                <td height="25">
                   CAMPOS DE MASIVA COMBINACI&Oacute;N Y PLANTILLAS 
                </td>
            </tr>
            <tr align="left"> 
                <td>
                    <?=$msg?>
                </td>
            </tr>
            <tr align="left" class='titulos2'> 
                <td height="12">
                    <b> Campos de combinaci&oacute;n Masiva</b>
                </td>
            </tr>
            <tr align="center" class="etextomenu"> 
                <td class='listado2'>
                    <?=$nombSe?>
                </td>
            </tr>
            <tr class='titulos2'> 
                <td align="center" height="12">
                    <b> Campos que se pueden usar en una combinaci&oacute;n sencilla</b>
                </td>
            </tr>
            <tr align="justify" class="etextomenu"> 
                <td  class='listado2'>
                    <p><?=$nombMa?></p>
                </td>
            </tr>
            <tr align="justify" class="etextomenu">
                <td  class='listado2'>
                    <p>Listado de Fuentes de Codigo de barra que debe tener instalado en el PC.<br>
		    Para el caso de Windows existen dos formas de Instalarlas. Con click derecho "Guardar enlace como ...".  <br>
                        1. Descargar la fuente y abir directamente con Windows el Administrador de Fuentes, Luego Dar la Opcion Instalar. <br>
			2. o Tambien puede copiar estos archivos en la carpeta c:\windows\fonts</br>	</p>
			<a href='include/fuentes/FREE3OF9.TTF'   class="e"> FREE3OF9.TTF</a> - 
		<a href='include/fuentes/free3of9.ttf'>free3of9.ttf</a> - 
		<a href='include/fuentes/FREE3OF9X.TTF'>FREE3OF9X.TTF</a> -
                Licencia <a href='include/fuentes/FREE3OF9.TXT'>FREE3OF9.TXT </a>
                </td>
            </tr>
            <tr align="left" class='titulos2'> 
                <td height="12">
                    <b> Plantillas</b>
                </td>
            </tr>
            <tr align="left" class="etextomenu"> 
                
                <td class='listado2'>
                    <?php foreach ($plantillas as $value) {
                        if($value != "." && $value != "..")
                        {
                        ?>
                    <a href="<?=$carpetaBodega."Ayuda/plantillas/".$value?>"><?=$value?></a>
                    <br>
                    <?php
                        }
                    }
                    ?>
                </td>
            </tr>

        </table>
    </body>
</html>

