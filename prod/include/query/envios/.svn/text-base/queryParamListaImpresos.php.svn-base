<?php

/**
 * CONSULTA VERIFICACION PREVIA A LA RADICACION
 */
switch ($db->driver) {
    case 'mssql':

        $strRad = "convert(char(14),a.radi_nume_salida) AS \"IMG_Radicado Salida\"";
        $strCopia = $db->conn->substr . "(convert(char(3),a.sgd_dir_tipo),2,3) AS \"Copia\"";
        $radSal = "convert(char(14),a.radi_nume_salida)";
        $dirTipo = "convert(char(3),a.sgd_dir_tipo)";
        break;
    case 'oracle':
    case 'oci8':
    case 'oci805':
    case 'oci8po':
        $strRad = "a.radi_nume_salida AS \"IMG_Radicado Salida\"";
        $strCopia = "substr(cast(a.sgd_dir_tipo as varchar2(14)),2,3) AS \"Copia\"";
        $radSal = " a.radi_nume_salida ";
        $dirTipo = "a.sgd_dir_tipo";
        break;

    case 'postgres':
    default:
        $strRad = "a.radi_nume_salida AS \"IMG_Radicado salida\"";
        $strCopia = "substr(cast(a.sgd_dir_tipo as varchar),2,3) AS \"Copia\"";
        $radSal = " cast(a.radi_nume_salida as varchar) ";
        $dirTipo = "a.sgd_dir_tipo";
}
if ($tip_radi == 0) {
    $where_tipRadi .= "";
} else {
    $where_tipRadi .= " and $radSal like '%$tip_radi'";
}

$descripcion = utf8_encode("Descripcion");
$fechaimpresion = utf8_encode("Fecha impresion");
$medioenvio = utf8_encode("Medio envio");
if ($DepeCod != 999) {
    $depFilter = " and c.radi_depe_radi=$DepeCod ";
} else {
    if ($_SESSION["usua_perm_impresion"] == 2) {
        /*
         * select depe_codi,depe_nomb from dependencia where depe_codi in (select depe_codi from impusrrel where usua_doc='1019014153')
         */
        $depFilter = " and c.radi_depe_radi in (select depe_codi from impusrrel where usua_doc='" . $_SESSION["usua_doc"] . "') ";
    }
}
$isql = 'select 
            a.anex_estado AS "CHU_ESTADO"
            ,a.sgd_deve_codigo AS "HID_DEVE_CODIGO"
            ,a.sgd_deve_fech AS "HID_SGD_DEVE_FECH" 
            ,' . $strRad . '
            ,c.RADI_PATH AS "HID_RADI_PATH"
            ,' . $strCopia . '
            ,a.anex_radi_nume AS "Radicado padre"
            ,c.radi_fech_radi AS "Fecha radicado"
            ,a.anex_desc AS "' . $descripcion . '"
            ,a.sgd_fech_impres AS "' . $fechaimpresion . '"
            ,d.sgd_dir_nomremdes as "Destinatario"
            ,mr.mrec_desc as "' . $medioenvio . '"
            ,a.anex_creador AS "Generado por"
            ,mr.mrec_codi as "HID_MREC_CODI"
            ,' . $db->conn->Concat("$radSal", "'-'", "$dirTipo") . ' AS "CHK_RADI_NUME_SALIDA" 
            ,a.sgd_deve_codigo AS "HID_DEVE_CODIGO1"
            ,a.anex_estado AS "HID_ANEX_ESTADO1"
            ,a.anex_nomb_archivo AS "HID_ANEX_NOMB_ARCHIVO" 
            ,a.anex_tamano AS "HID_ANEX_TAMANO"
            ,a.anex_radi_fech AS "HID_ANEX_RADI_FECH"  
            ,a.anex_tipo AS "HID_ANEX_TIPO" 
            ,a.anex_radi_nume AS "HID_ANEX_RADI_NUME" 
            ,a.sgd_dir_tipo AS "HID_SGD_DIR_TIPO"
            ,a.sgd_deve_codigo AS "HID_SGD_DEVE_CODIGO"
            from anexos a
            JOIN usuario b ON a.anex_creador=b.usua_login
            JOIN radicado c ON ((c.SGD_EANU_CODIGO != 2 AND c.SGD_EANU_CODIGO != 1) or c.SGD_EANU_CODIGO IS NULL)  AND a.radi_nume_salida=c.radi_nume_radi
            JOIN sgd_dir_drecciones d ON a.radi_nume_salida=d.radi_nume_radi AND a.sgd_dir_tipo = d.sgd_dir_tipo
            JOIN dependencia dep ON dep.depe_codi=c.radi_depe_radi
            left join medio_recepcion mr on mr.mrec_codi=d.mrec_codi
        where a.radi_nume_salida=c.radi_nume_radi' .
        $dependencia_busq2 .
        $where_tipRadi .
        $where_fecha . '
            and a.anex_creador=b.usua_login
            and a.anex_borrado= ' . "'N'" . '
            and a.sgd_dir_tipo != 7
            and (a.sgd_deve_codigo >= 90 or a.sgd_deve_codigo =0 or a.sgd_deve_codigo is null)
            AND ((c.SGD_EANU_CODIGO != 2 AND c.SGD_EANU_CODIGO != 1) or c.SGD_EANU_CODIGO IS NULL)
            and a.radi_nume_salida=d.radi_nume_radi
            and a.sgd_dir_tipo = d.sgd_dir_tipo
            and a.anex_estado=3
            and dep.depe_codi=c.radi_depe_radi 
            ' . $depFilter . '
            ' . $whereInterna . '
         order by a.radi_nume_salida ,a.sgd_dir_tipo asc';
?>