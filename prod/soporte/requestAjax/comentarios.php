<?php
include_once('dataCommon.php');
    /*
     * dataCommon.php comparte los datos mas relevantes y los 
     * objetos mas utilizados como session,adodb, etc.
     */
   
    /**
     * Buscamos los soportes existentes y los mostramos en la tabla
     */
     
     //Estado actual del ticket y el propietario
     $sql2           ="
                        SELECT 
                            SO.SGD_SOP_EST      AS ESTADO,                            
                            US.USUA_LOGIN
                        FROM 
                            SGD_SOP_SOPORTE SO,
                            USUARIO US
                        WHERE
                            SO.DEPE_CODI    = US.DEPE_CODI      AND
                            SO.USUA_CODI    = US.USUA_CODI      AND
                            so.sgd_sop_id   = $ticket
                            ORDER by SGD_SOP_FECHAINI desc";

    $rs2            =   $db->conn->Execute($sql2); 
        
    $estado         =   $rs2->fields["ESTADO"];
    $usua_login     =   $rs2->fields["USUA_LOGIN"]; 
    
    //Login del usuario actual
    $usuaAct_login  = trim($_SESSION['krd']);
    
    
    //Permisos de comentar ticket por personal de soporte
    $sql4           ="
                        SELECT
                            US.USUA_LOGIN
                        FROM
                            SGD_SOP_SOPORTE SO,
                            USUARIO US,
                            SGD_TSOP_TIPOSOPORTE TS
                        WHERE
                            US.USUA_CODI    = TS.SGD_TSOP_USUA_CODI AND
                            US.DEPE_CODI    = TS.SGD_TSOP_DEPE_CODI AND
                            SO.SGD_TSOP_ID  = TS.SGD_TSOP_ID        AND
                            so.sgd_sop_id   = $ticket";

    $rs4            = $db->conn->Execute($sql4);
    $loginAdmin     = $rs4->fields["USUA_LOGIN"];

    
    //Si el usuario actual es el mismo que creo el ticket
    //no esta cerrado el puede hacer esta accion.
    $mosCerrar  =  0; //No permite comentar el ticket
    if($usua_login == $usuaAct_login && $estado == 0 ){
        $mosCerrar  =  2; // Permite comentar y cerrar
    }if($usuaAct_login == $loginAdmin && $estado == 0){
        $mosCerrar  =  1; // Permite comentar
    }   

    //Consulta los soportes actuales     
    $sql3           ="       
                        SELECT     
                          COS.SGD_CSOP_COMENT   AS  COMENTARIO,
                          US.USUA_NOMB          AS  NOM_USUARIO,
                          COS.SGD_CSOP_FECHA    AS  FECHA_COMET
                          
                        FROM 
                          USUARIO US,
                          SGD_CSOP_COMENT COS,
                          SGD_SOP_SOPORTE SO
                          
                        WHERE
                           COS.DEPE_CODI    = US.DEPE_CODI      AND
                           COS.USUA_CODI    = US.USUA_CODI      AND
                           COS.SGD_SOP_ID   = SO.SGD_SOP_ID     AND
                           SO.SGD_SOP_ID    = $ticket
                           ORDER by SGD_CSOP_FECHA desc
                     ";  
                     
    $rs3            =   $db->conn->Execute($sql3);
    
    while(!$rs3->EOF){        
        $coment[]    =  array(  'COMENTARIO'    => $rs3->fields["COMENTARIO"   ],
                                'USUARIO'       => $rs3->fields["NOM_USUARIO"  ],
                                'FECHACOMT'     => $rs3->fields["FECHA_COMET"  ]
                            );
        $rs3->MoveNext();                
    }
    /**
     * El resultados de la logica se coloca en las variables
     * de la plantilla comentarios.tpl
     */
    
    $smarty->assign("coment"    ,$coment        ); //Arreglo de comentarios
    $smarty->assign("mosCerrar" ,$mosCerrar     ); //Tipo de soportes
    $smarty->assign("ticket"    ,$ticket        ); //Numero del ticket
    $smarty->assign("sessid"    ,session_id()   ); //Id de la session
    $smarty->assign("sesNam"    ,session_name() ); //Nombre de la session

    //Plantilla que imprime codigo html
    $smarty->display('comentarios.tpl');
    
?>
