<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SecSuperClass
 *
 * @author John Guerrero
 */
class SecSuperClass {
    /*
     * Usuario
     */

    var $UsuaDoc;
    /*
     * Codigo de usuario en la dependencia
     */
    var $UsuaCodi;

    /*
     * Dependencia del usuario
     */
    var $UsuaDep;

    /*
     * Sec. Perm
     */
    var $UsrPerm;

    /*
     * Objeto de base de datos
     */
    var $cursor;

    /*
     * Dep. Habilitadas
     */
    var $Dep;
    /*
     * Radicados informados
     */
    var $Informados;

    /*
     * Radicados agendados 
     */
    var $Agendados;

    /*
     * Radicados creados
     */
    var $Propios;

    /*
     * Select Dep. habilitadas
     */
    var $select;
 
    function SecSuperClass($db = FALSE, $NoSes = FALSE) {
        $this->cursor = & $db;
        $this->cursor->conn->SetFetchMode(ADODB_FETCH_ASSOC);
        IF ($NoSes) {
            session_start();
            $this->SecSuperFill($_SESSION['usua_doc']);
        }
    }

    function SecSuperFill($UsuaDoc, $New2 = false, $edit = false) {
        $this->cursor->conn->SetFetchMode(ADODB_FETCH_ASSOC);
        $this->UsuaDoc = $UsuaDoc;
        $sql = " select usua_super_perm PERM,usua_codi CODI, depe_codi DEPE from usuario where usua_doc='$UsuaDoc' ";
        $sqlInfor = " select radi_nume_radi from informados where info_codi='$UsuaDoc' ";
        $sqlAgend = " select radi_nume_radi from sgd_agen_agendados where usua_doc='$UsuaDoc' ";
        $sqlProp = " select radi_nume_radi from hist_eventos where cast(radi_nume_radi as varchar(14)) not like '%2' and usua_doc='$UsuaDoc' ";
        $rs = $this->cursor->conn->query($sqlInfor);
        if ($rs && !$rs->EOF) {
            while ($arr = $rs->FetchRow()) {
                if ($rs->fields['RADI_NUME_RADI']) {
                    $Informado = $arr['RADI_NUME_RADI'];
                } else {
                    $Informado = $arr['radi_nume_radi'];
                }
                $this->Informados[] = $Informado;
            }
        }
        $rs = $this->cursor->conn->query($sqlAgend);
        if ($rs && !$rs->EOF) {
            while ($arr = $rs->FetchRow()) {
                if ($rs->fields['RADI_NUME_RADI']) {
                    $Agendado = $arr['RADI_NUME_RADI'];
                } else {
                    $Agendado = $arr['radi_nume_radi'];
                }
                $this->Agendados[] = $Agendado;
            }
        }

        $rs = $this->cursor->conn->query($sqlProp);
        if ($rs && !$rs->EOF) {
            while ($arr = $rs->FetchRow()) {
                if ($rs->fields['RADI_NUME_RADI']) {
                    $Propio = $arr['RADI_NUME_RADI'];
                } else {
                    $Propio = $arr['radi_nume_radi'];
                }
                $this->Propios[] = $Propio;
            }
        }

        $rs = $this->cursor->conn->query($sql);
        if ($rs->fields['CODI'] == null) {
            $this->UsuaCodi = $rs->fields['codi'];
            $this->UsuaDep = $rs->fields['depe'];
            $this->UsrPerm = $rs->fields['perm'];
        } else {
            $this->UsuaCodi = $rs->fields['CODI'];
            $this->UsuaDep = $rs->fields['DEPE'];
            $this->UsrPerm = $rs->fields['PERM'];
        }
        if ($this->UsrPerm == 2 || $New2 || $edit) {
            if ($New2) {
                $this->SecDelAllDeps($UsuaDoc);
            }
            $sql = " select 
                    Spc.depe_codi, 
                    dep.depe_nomb 
                    from 
                    UsrSuperRel Spc 
                    inner join 
                    dependencia dep on Spc.depe_codi=dep.depe_codi 
                    where 
                    usua_doc='$UsuaDoc' order by Spc.depe_codi ";
            $rs = $this->cursor->conn->query($sql);
            $this->select = " <select name = 'UsrAsDep' multiple = 'multiple'> ";
            if ($rs && !$rs->EOF) {

                while ($arr = $rs->FetchRow()) {
                    if ($arr['DEPE_CODI']) {
                        $this->Dep[] = array($arr['DEPE_CODI'], $arr['DEPE_NOMB']);
                        $this->select.= " <option value='" . $arr['DEPE_CODI'] . "'>[" . $arr['DEPE_CODI'] . "]" . $arr['DEPE_NOMB'] . "</option> ";
                    } else {
                        $this->Dep[] = array($arr['depe_codi'], $arr['depe_nomb']);
                        $this->select.= " <option value='" . $arr['depe_codi'] . "'>[" . $arr['depe_codi'] . "]" . $arr['depe_nomb'] . "</option> ";
                    }
                }
            } else {
                //$this->Dep[] = 0;
            }
            $this->select.= " </select> ";
        }
    }

    function SecSuperAdd($UsuaDoc, $dep) {
        $sql = " select depe_codi from UsrSuperRel where usua_doc='$UsuaDoc' and depe_codi=$dep ";
        $rs = $this->cursor->conn->query($sql);
        if ($rs->fields['DEPE_CODI'] != $dep or $rs->EOF) {
            $sql = " INSERT INTO UsrSuperRel (usua_doc,depe_codi)
                    VALUES ('$UsuaDoc', $dep)";
            $rs = $this->cursor->query($sql);
            return true;
        }
        return false;
    }

    function SecSuperDel($UsuaDoc, $dep) {
        $sql = " delete from UsrSuperRel where usua_doc='$UsuaDoc' and depe_codi=$dep ";
        $rs = $this->cursor->conn->Execute($sql);
        if ($rs)
            return true;
        else
            return false;
    }

    function SecDelAllDeps($UsuaDoc) {
        $sql = " delete from UsrSuperRel where usua_doc='$UsuaDoc' ";
        $rs = $this->cursor->conn->Execute($sql);
        if ($rs)
            return true;
        else
            return false;
    }

    function SecureCheck($radicado) {

        $sql = "select rad.radi_depe_actu depe, rad.radi_usua_actu usua from radicado rad where rad.radi_nume_radi=$radicado ";
        $rs = $this->cursor->conn->Execute($sql);
        if ($rs->fields['DEPE']) {
            $depeAct = $rs->fields['DEPE'];
            $codiAct = $rs->fields['USUA'];
        } else {
            $depeAct = $rs->fields['depe'];
            $codiAct = $rs->fields['usua'];
        }
        switch ($this->UsrPerm) {
            case 0:
                return;
                break;
            case 1:
                $esta = false;
                if ($this->UsuaDep == $depeAct && $codiAct == $this->UsuaCodi) {
                    $esta = true;
                    return $esta;
                    break;
                }
                $esta = $this->CheckRadicados($radicado);
                return $esta;
                break;
            case 2:
                $esta = false;
                foreach ($this->Dep as $key => $DepBusc) {
                    if (($depeAct == $DepBusc[0]) || ($this->UsuaDep == $depeAct && $codiAct == $this->UsuaCodi)) {
                        $esta = TRUE;
                        break;
                    }
                }
                if ($esta == false) {
                    $esta = $this->CheckRadicados($radicado);
                }
                return $esta;
                break;
        }
    }

    function CheckRadicados($radicado) {
        $esta = $this->CheckInformados($radicado);
        if ($esta == true) {
            return $esta;
            break;
        }
        $esta = $this->CheckAgendados($radicado);
        if ($esta == true) {
            return $esta;
            break;
        }
        $esta = $this->CheckPropios($radicado);
        if ($esta == true) {
            return $esta;
            break;
        }
    }

    function CheckInformados($radicado) {
        foreach ($this->Informados as $Informado) {
            if (($radicado == $Informado)) {
                $esta = TRUE;
                return $esta;
                break;
            }
        }
    }

    function CheckAgendados($radicado) {
        foreach ($this->Agendados as $Agendado) {
            if (($radicado == $Agendado)) {
                $esta = TRUE;
                return $esta;
                break;
            }
        }
    }

    function CheckPropios($radicado) {
        foreach ($this->Propios as $Propio) {
            if (($radicado == $Propio)) {
                $esta = TRUE;
                return $esta;
                break;
            }
        }
    }

}

?>
