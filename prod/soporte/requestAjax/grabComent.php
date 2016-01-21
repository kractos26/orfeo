<?php
include_once('dataCommon.php');
    /*
     * dataCommon.php comparte los datos mas relevantes y los 
     * objetos mas utilizados como session,adodb, etc.
     */
    
    $mensaje1       = "<br/><font color='red'><b>El comentario tiene menos de 20 caracteres</b></font>";
    $mensaje2       = "<br/><font color='#377584'><b>Se creo el nuevo comentario</b></font>";
    $mensaje3       = "<br/><font color='red'><b>No se cerro el ticket</b></font>";
    $mensaje4       = "<br/><font color='#377584'><b>Se cerro el ticket</b></font>";        
    
    $coment         = strValido($comentario);    
    $accion         = $ticket.'_coment';    
    $fechasistema   = $db->conn->OffsetDate(0,$db->conn->sysTimeStamp);

    /** 
    if(strlen($coment) < 20){
        print($mensaje1);
        exit;
    }
    **/    
    $id_Sec = $db->conn->GenID('sgd_csop_coment_sgd_csop_id_seq');

    $sqlIns     = " INSERT INTO         
                        SGD_CSOP_COMENT(
                               SGD_CSOP_ID
                              ,USUA_CODI
                              ,DEPE_CODI                                  
                              ,SGD_CSOP_COMENT
                              ,SGD_CSOP_FECHA
                              ,SGD_SOP_ID)
            
                        VALUES (
                               $id_Sec
                             , $codusuario
                             , $depenUsua
                             , '$coment'
                             , $fechasistema
                             , $ticket                                                                  
                            )";

                                 
    $result     = $db->conn->Execute($sqlIns);
    
    if($result->EOF) {
        print($mensaje2);        
    }
    
    if('Comentar' != ${$accion}){
    $sqlInsE    ="  UPDATE 
                            SGD_SOP_SOPORTE
                        SET 
                            SGD_SOP_EST = 1,
                            SGD_SOP_FECHAFIN = $fechasistema 
                        WHERE 
                            SGD_SOP_ID = $ticket";
                            
        $result2    = $db->conn->Execute($sqlInsE);
        
        if($result2->EOF) {
            print($mensaje4);
        }else{
            print($mensaje3);            
        }
    }
?>
