<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MetaDatoClass
 *
 * @author iyu
 */
class MetaDatoClass {
    /*
     * Metadatos asociados a un tipo de documento
     */

    var $MetaTpDoc;
    /*
     * Metadatos asociados a una combinacion de serie y subserie
     */
    var $MetaSS;
    /*
     * Tipo de metadato
     */
    var $tipo;
    /*
     * Radicado
     */
    var $Radicado;
    /*
     * Ruta
     */
    var $path;
    /*
     * Fecha Radicacion
     */
    var $Fech;

    /*
     * Expediente
     */
    var $Expediente;

    /*
     * MetaDatos
     */
    var $Metas;

    /*$v = "<a href=".$rutaRaiz."/verradicado.php?verrad=".$verNumRadicado."&".$encabezado."><span class=$radFileClass>".$v."</span></a>";
     * $v = "<a href=".$rutaRaiz."/expediente/listaConsulta.php?numExpediente=$verNumExp&".$encabezado." target='expediente'><span class=$radFileClass>".$v."</span></a>";
     * $radFileClass = "leidos";
     * Link
     */
    //var $Link;
    
    /*
     * Cursor de conexion a base de datos
     */
    var $cursor;
    
    

    function MetaDatoClass($db, $tipo = false, $num = false) {
        $this->cursor = $db;
        if ($tipo) {
            if ($tipo == 'T') {
                $this->RadiFill($num);
            } else {
                $this->expFill($num);
            }
        }
    }

    function RadiFill($radi) {
        $sql = " select radi_nume_radi,tdoc_codi AS TIPO, radi_path, " . $this->cursor->conn->SQLDate('d-m-Y', 'radi_fech_radi') . " as FECHA from radicado where radi_nume_radi=$radi ";
        $rs = $this->cursor->conn->query($sql);
        if ($rs && !$rs->EOF) {
            $this->Fech = $rs->fields['FECHA'];
            if ($rs->fields['RADI_PATH']) {
                $this->path = $rs->fields['RADI_PATH'];
            }
            $this->MetaFillTpDoc($rs->fields['TIPO']);
            if ($this->MetaTpDoc == 0) {
                $this->Metas = 0;
            } else {
                $sql = "select radi_nume_radi, sgd_mtd_codigo AS CODIGO, sgd_mmr_dato AS INFO from sgd_mmr_matrimetaradi where radi_nume_radi=$radi order by sgd_mtd_codigo";
                $rs = $this->cursor->conn->query($sql);
                if ($rs && !$rs->EOF) {
                    while ($arr = $rs->FetchRow()) {
                        $this->Metas[$arr['CODIGO']] = $arr['INFO'];
                    }
                }
            }
        } else {
            
        }
    }

    function expFill($Exp) {
        $sql = " select sgd_exp_numero,sgd_srd_codigo as SERIE, sgd_sbrd_codigo as SUBSERIE, " . $this->cursor->conn->SQLDate('d-m-Y', 'sgd_sexp_fech') . " as FECHA from sgd_sexp_secexpedientes where sgd_exp_numero='$Exp' ";
        $rs = $this->cursor->conn->query($sql);
        if ($rs && !$rs->EOF) {
            $this->Fech = $rs->fields['FECHA'];
            $this->MetaFillSS($rs->fields['SERIE'],$rs->fields['SUBSERIE']);
            if ($this->MetaSS == 0) {
                $this->Metas = 0;
            } else {
                $sql = "select sgd_exp_numero, sgd_mtd_codigo AS CODIGO, sgd_mmr_dato AS INFO from sgd_mmr_matrimetaexpe where sgd_exp_numero='$Exp' order by sgd_mtd_codigo";
                $rs = $this->cursor->conn->query($sql);
                if ($rs && !$rs->EOF) {
                    while ($arr = $rs->FetchRow()) {
                        $this->Metas[$arr['CODIGO']] = $arr['INFO'];
                    }
                }
            }
        } else {
            
        }
    }

    function MetaFillTpDoc($tpDoc) {
        $this->tipo = "T";
        $sql = "select sgd_mtd_codigo as CODIGO,sgd_mtd_nombre as NOMBRE
                from sgd_mtd_metadatos
                where sgd_tpr_codigo=$tpDoc and sgd_mtd_estado=1 ";
        $rs = $this->cursor->conn->query($sql);
        if ($rs && !$rs->EOF) {
            while ($arr = $rs->FetchRow()) {
                $this->MetaTpDoc[$arr['CODIGO']] = $arr['NOMBRE'];
            }
        } else {
            $this->MetaTpDoc = 0;
        }
    }

    function MetaFillSS($serie, $subSerie) {
        $this->tipo = "S";
        $sql = "select sgd_mtd_codigo as CODIGO,sgd_mtd_nombre as NOMBRE
                from sgd_mtd_metadatos
                where sgd_srd_codigo=$serie and sgd_sbrd_codigo=$subSerie and sgd_mtd_estado=1 ";
        $rs = $this->cursor->conn->query($sql);
        if ($rs && !$rs->EOF) {
            while ($arr = $rs->FetchRow()) {
                $this->MetaSS[$arr['CODIGO']] = $arr['NOMBRE'];
            }
        } else {
            $this->MetaSS = 0;
        }
    }

}

?>
