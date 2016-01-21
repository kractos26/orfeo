<?php
session_start();
if (!$ruta_raiz)
    $ruta_raiz = "..";
$sqlFechaDocto = $db->conn->SQLDate("Y-m-D H:i:s A", "mf.sgd_rdf_fech");
$sqlFechaD = $db->conn->SQLDate("Y-m-d H:i A", "SGD_SBRD_FECHINI");
$sqlFechaH = $db->conn->SQLDate("Y-m-d H:i A", "SGD_SBRD_FECHFIN");
$isqlC = "select SGD_SBRD_CODIGO AS CODIGO,
            SGD_SBRD_DESCRIP    AS SUBSERIE,
            $sqlFechaD AS DESDE,
            $sqlFechaH AS HASTA
         from SGD_SBRD_SUBSERIERD
         where SGD_SRD_CODIGO = $codserie  $whereBusqueda order by SGD_SBRD_DESCRIP";
error_reporting(7);
?>
<br>
<br>
<table class=borde_tab width='100%' cellspacing="5"><tr><td class=titulos2><center>SUBSERIES DOCUMENTALES</center></td></tr></table>
<table><tr><td></td></tr></table>
<br>
<TABLE width="100%" class="borde_tab" cellspacing="5">
    <tr class=tpar> 
        <td class=titulos3 align=center>C&Oacute;DIGO </td>
        <td class=titulos3 align=center>DESCRIPCI&Oacute;N </td>
        <td class=titulos3 align=center>DESDE </td>
        <td class=titulos3 align=center>HASTA </td>
    </tr>
    <?php
    $rsC = $db->query($isqlC);
    while (!$rsC->EOF) {
        $tsub = $rsC->fields["CODIGO"];
        $dsubserie = $rsC->fields["SUBSERIE"];
        $fini = $rsC->fields["DESDE"];
        $ffin = $rsC->fields["HASTA"];
        ?> 
        <tr class=paginacion>
            <td> <?= $tsub ?> </td>
            <td align=left><?= $dsubserie ?> </td>
            <td> <?= $fini ?> </td>
            <td> <?= $ffin ?></td> 
        </tr>
        <?
        $rsC->MoveNext();
    }
    ?>
</table>
