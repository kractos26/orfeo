<?php
include_once    ("confSmarty.php");
    /**
     * Created on 16/07/2010
     * include_once ("confSmarty.php")
     * trae la session, adodb, elementos
     * enviados desde el Post, Get, sesion
     * y la configuracion de los templates
     */ 
    
    
    /**
     * Buscamos los soportes existentes y los mostramos en la tabla
     */
        
     $sql2           ="
                        SELECT 
                            SO.SGD_SOP_EST      AS ESTADO,                            
                            US.USUA_LOGIN
                        FROM 
                            SGD_SOP_SOPORTE SO,
                            USUARIO US,
                            SGD_TSOP_TIPOSOPORTE TS
                            
                        WHERE
                            SO.DEPE_CODI    = US.DEPE_CODI      AND
                            SO.USUA_CODI    = US.USUA_CODI      AND
                            SO.SGD_TSOP_ID  = TS.SGD_TSOP_ID    AND
                            so.sgd_sop_id   = $ticket
                            ORDER by SGD_SOP_FECHAINI desc
                       ";

    $rs2            =   $db->conn->Execute($sql2); 
    
    //Si esta en 1 no mostrar el boton de cerrar ticket
    $estado         =   $rs2->fields["ESTADO"];
    $usua_login     =   $rs2->fields["USUA_LOGIN"]; 
    
    //Login del usuario actual
    $usuaAct_login  = trim($_SESSION['USUA_LOGIN']);
    
    //Si el usuario actual es el mismo que creo el ticket y 
    //este no esta cerrado el puede hacer esta accion.
    if($usua_login == $usuaAct_login && $estado == 0 ){
        $mosCerrar  =   true;
    }
      

    //Consulta los soportes actuales     
    $sql3           ="       
                        SELECT     
                          COS.SGD_CSOP_COMENT   AS  COMENTARIO,
                          US.USUA_NOMB          AS  NOM_USUARIO,
                          COS.SGD_CSOP_FECHA    AS  FECHA_COMET
                          
                        FROM 
                          USUARIO US,
                          SGD_CSOP_COMENT COS
                          
                        WHERE
                           COS.DEPE_CODI    = US.DEPE_CODI      AND
                           COS.USUA_CODI    = US.USUA_CODI    
                     ";  

    $rs3            =   $db->conn->Execute($sql3);
    
     while(!$rs3->EOF){        
        $coment[]    =  array(  'COMENTARIO'    => $rs2->fields["COMENTARIO"   ],
                                'USUARIO'       => $rs2->fields["NOM_USUARIO"  ],
                                'FECHACOMT'     => $rs2->fields["FECHA_COMET"  ]
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
