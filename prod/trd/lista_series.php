<?php
session_start();
if (!$ruta_raiz)
    $ruta_raiz = "..";
$sqlFechaDocto = $db->conn->SQLDate("Y-m-D H:i:s A", "mf.sgd_rdf_fech");
$sqlFechaD = $db->conn->SQLDate("Y-m-d H:i A", "SGD_SRD_FECHINI");
$sqlFechaH = $db->conn->SQLDate("Y-m-d H:i A", "SGD_SRD_FECHFIN");
$isqlC = "select SGD_SRD_CODIGO AS CODIGO,
            SGD_SRD_DESCRIP AS SERIE,
            $sqlFechaD AS DESDE,
            $sqlFechaH AS HASTA
        from SGD_SRD_SERIESRD $whereBusqueda order by SGD_SRD_DESCRIP";
error_reporting(7);
?>
<table class=borde_tab width='100%' cellspacing="5">
    <tr><td class=titulos2><center>SERIES DOCUMENTALES</center></td></tr>
</table>
<br/>
<br/>
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
        $codserie = $rsC->fields["CODIGO"];
        $dserie = $rsC->fields["SERIE"];
        $fini = $rsC->fields["DESDE"];
        $ffin = $rsC->fields["HASTA"];
        ?> 
        <tr class=paginacion>
            <td> <?= $codserie ?></td>
            <td align=left> <?= $dserie ?> </td>
            <td> <?= $fini ?> </td>
            <td> <?= $ffin ?> </td>
        </tr>
        <?php
        $rsC->MoveNext();
    }
    ?>
</TABLE>