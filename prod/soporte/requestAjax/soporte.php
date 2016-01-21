<?php
include_once('dataCommon.php');
    /*
     * dataCommon.php comparte los datos mas relevantes y los 
     * objetos mas utilizados como session,adodb, etc.
     */
    
    $mensaje1       = "<br/><font color='red'><b>El comentario tiene menos de 20 caracteres</b></font>";
    $mensaje2       = "<br/><font color='#377584'><b>Se creo el nuevo soporte</b></font>";
    
    echo $come_sop;
    
    $coment         = strValido($come_sop);    
    $fechasistema   = $db->conn->OffsetDate(0,$db->conn->sysTimeStamp);
    if(strlen($coment)>20){
        
    switch($db->driver){
        case 'oci8':

            $sqlIns     = " INSERT INTO         
                                SGD_SOP_SOPORTE(
                                       SGD_SOP_ID
                                     , USUA_CODI
                                     , DEPE_CODI
                                     , SGD_SOP_COMENT                                 
                                     , SGD_TSOP_ID
                                     , SGD_SOP_FECHAINI)
                    
                                VALUES (
                                       SEC_SOP_ID.nextval 
                                     , $codusuario
                                     , $depenUsua
                                     , '$coment'
                                     , $selectTipSop
                                     , (select sysdate from dual)                                 
                                    )";
        default:
            $sqlIns     = " INSERT INTO         
                                SGD_SOP_SOPORTE(
                                       SGD_SOP_ID
                                     , USUA_CODI
                                     , DEPE_CODI
                                     , SGD_SOP_COMENT                                 
                                     , SGD_TSOP_ID
                                     , SGD_SOP_FECHAINI)
                    
                                VALUES (
                                       nextval('sgd_sop_soporte_sgd_sop_id_seq')
                                     , $codusuario
                                     , $depenUsua
                                     , '$coment'
                                     , $selectTipSop
                                     , $fechasistema
                                    )";
               
    }
        $result     = $db->conn->Execute($sqlIns);
        
        if($result->EOF) {
            print($mensaje2);
            exit;   
        }
    }else{
        print($mensaje1);
    };      
?>
