<?php
$ruta_raiz = "..";
session_start();
if (!isset($_SESSION['dependencia']))
    include "$ruta_raiz/rec_session.php";
if ($_SESSION['usua_admin_sistema'] != 1)
    die(include "$ruta_raiz/sinacceso.php");
?>
<html>
    <head>
        <title>Documento  sin t&iacute;tulo</title>
                  <link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
    </head>
    <body>
        <table width="50%" align="center" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
            <tr bordercolor="#FFFFFF">
                <td colspan="2" class="titulos4"><div align="center"><strong>M&Oacute;DULO DE ADMINISTRACI&Oacute;N</strong></div></td>
            </tr>
            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="48%">
                    <a href='usuario/mnuUsuarios.php?krd=<?= $krd ?>' target='mainFrame' class="vinculos">1. USUARIOS Y PERFILES</a>
                </td>
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_dependencias.php" class="vinculos" target="mainFrame">2. DEPENDENCIAS</a></td>
            </tr>
            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="48%"> <a   href="tbasicas/tipSoporte.php"class="vinculos" target='mainFrame'>3. TIPO RECEP/ENV&Iacute;O </a></td>
                <td align="center" class="listado2" width="48%"><a  href="tbasicas/adm_fenvios.php" class="vinculos" target='mainFrame'>4. ENV&Iacute;O DE CORRESPONDENCIA</a> </td>
            </tr>
            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_tsencillas.php" class="vinculos" target='mainFrame'>5. TABLAS SENCILLAS</a></td>
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_trad.php?krd=<?= $krd ?>" class="vinculos" target='mainFrame'>6. TIPOS DE RADICACI&Oacute;N</a></td>
            </tr>
            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_paises.php" class="vinculos" target='mainFrame'>7. PA&Iacute;SES</a></td>
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_dptos.php" class="vinculos" target='mainFrame'>8. DEPARTAMENTOS</a></td>
            </tr>
            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_mcpios.php" class="vinculos" target='mainFrame'>9. MUNICIPIOS</a></td>
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_tarifas.php" class="vinculos" target='mainFrame'>10. TARIFAS</a></td>
            </tr>

            <tr bordercolor="#FFFFFF">

                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_temas.php" class="vinculos" target='mainFrame'>11. TABLAS TEM&Aacute;TICAS</a></td>
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_plantillas.php" class="vinculos" target='mainFrame'>12. PLANTILLAS</a></td>
            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="33%"><a href="tbasicas/adm_eaplicativos.php" class="vinculos" target='mainFrame'>13. APLICATIVOS ENLACE</a></td>
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_contactos.php" class="vinculos" target='mainFrame'>14. CONTACTOS</a></td>
            </tr>
            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_esp.php?krd=<?= $krd ?>" class="vinculos" target='mainFrame'>15. REMITENTES / TERCEROS</a></td>
                <td align="center" class="listado2" width="33%"><a href="tbasicas/adm_msarchivo.php" class="vinculos" target='mainFrame'>16. MEDIOS DE SOPORTE ARCHIVO</a></td>
            </tr>
            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_mime.php" class="vinculos" target='mainFrame'>17. MIME (Tipos de Archivos)</a></td>
                <td align="center" class="listado2" width="48%"> <a  href="adm_nohabiles.php" class="vinculos" target='mainFrame'>18. D&Iacute;AS NO H&Aacute;BILES</a></td>

            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_detalleCausal.php" class="vinculos" target='mainFrame'>19. DETALLES CAUSAL</a></td>
                <td align="center" class="listado2" width="48%"><a href="tbasicas/adm_metadatos.php" class="vinculos" target='mainFrame'>20. METADATOS</a></td>
            </tr>
            <tr bordercolor="#FFFFFF">
                <td align="center" class="listado2" width="48%"><a href="RemDest/adm_rem_dest.php" class="vinculos" target='mainFrame'>21. CIUDADANOS Y EMPRESAS</a></td>
                <td align="center" class="listado2" width="48%"></td>
            </tr>
        </table>
    </body>
</html>
