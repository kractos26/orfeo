<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImpUsrClass
 *
 * @author John Guerrero
 */
class ImpUsrClass {
    /*
     * Usuario
     */

    var $UsuaDoc;

    /*
     * Imp. Perm
     */
    var $UsrPerm;
    /*
     * Dependencia de usuario
     */
    var $UsrDep;
    /*
     * Objeto de base de datos
     */
    var $cursor;

    /*
     * Dep. Habilitadas
     */
    var $Dep;

    /*
     * Select Dep. habilitadas
     */
    var $select;

    function ImpUsrClass($db = FALSE) {
        $this->cursor = & $db;
    }

    function ImpUsrFill($UsuaDoc, $New2 = false, $edit = false) {
        $sql = " select usua_super_perm, depe_codi from usuario where usua_doc='$UsuaDoc' ";
        $rs = $this->cursor->conn->query($sql);
        $this->UsrPerm = $rs->fields['USUA_SUPER_PERM'];
        $this->UsrDep = $rs->fields['DEPE_CODI'];
        if ($this->UsrPerm == 2 || $New2 || $edit) {

            if ($New2) {
                $this->ImpDelAllDeps($UsuaDoc);
            }
            if (!$this->OwnDep($this->UsrDep)) {
                $this->ImpUsrAdd($UsuaDoc, $this->UsrDep);
            }

            $sql = " select 
                    Imp.depe_codi, 
                    dep.depe_nomb 
                    from 
                    ImpUsrRel Imp 
                    inner join 
                    dependencia dep on Imp.depe_codi=dep.depe_codi 
                    where 
                    usua_doc='$UsuaDoc' order by Imp.depe_codi ";
            $rs = $this->cursor->conn->query($sql);
            $this->select = " <select name = 'ImpUsrAsDep' multiple = 'multiple'> ";
            if ($rs && !$rs->EOF) {

                while ($arr = $rs->FetchRow()) {
                    $this->Dep[] = array($arr['DEPE_CODI'], $arr['DEPE_NOMB']);
                    $this->select.= " <option value='" . $arr['DEPE_CODI'] . "'>[" . $arr['DEPE_CODI'] . "]" . $arr['DEPE_NOMB'] . "</option> ";
                }
            } else {
                $this->Dep[] = 0;
            }
            $this->select.= " </select> ";
        }
    }

    function ImpUsrAdd($UsuaDoc, $dep) {
        $sql = " select depe_codi from ImpUsrRel where usua_doc='$UsuaDoc' and depe_codi=$dep ";
        $rs = $this->cursor->conn->query($sql);
        if ($rs->fields['DEPE_CODI']!=$dep or $rs->EOF) {
            $sql = " INSERT INTO ImpUsrRel (usua_doc,depe_codi)
                    VALUES ('$UsuaDoc', $dep)";
            $rs = $this->cursor->query($sql);
            return true;
        }
        return false;
    }

    function ImpUsrDel($UsuaDoc, $dep) {
        $sql = " delete from ImpUsrRel where usua_doc='$UsuaDoc' and depe_codi=$dep ";
        $rs = $this->cursor->conn->Execute($sql);
        if ($rs)
            return true;
        else
            return false;
    }

    function ImpDelAllDeps($UsuaDoc) {
        $sql = " delete from ImpUsrRel where usua_doc='$UsuaDoc' ";
        $rs = $this->cursor->conn->Execute($sql);
        if ($rs)
            return true;
        else
            return false;
    }

    function OwnDep($dep) {
        $sql = " select 
                    Imp.depe_codi
                    from 
                    ImpUsrRel Imp 
                    inner join 
                    dependencia dep on Imp.depe_codi=dep.depe_codi 
                    where 
                    usua_doc='$UsuaDoc' and Imp.depe_codi=$dep order by Imp.depe_codi ";
        $rs = $this->cursor->conn->Execute($sql);
        if ($rs && !$rs->EOF)
            return true;
        else
            return false;
    }

}

?>
