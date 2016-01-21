<?php
include_once    ("confSmarty.php");
    /**
     * Created on 14/07/2010
     * include_once ("confSmarty.php")
     * trae la session, adodb, elementos
     * enviados desde el Post, Get, sesion
     * y la configuracion de los templates
     */ 
    
        
    //Si el usuario esta filtrando modifique la consulta
    if($filtros){
        if(!empty($noTicket) && is_numeric($noTicket)){
            $filtrar    = "AND SO.SGD_SOP_ID  = $noTicket ";    
        }if(!empty($selectTipSop)){
            $filtrar    .= "AND TS.SGD_TSOP_ID = $selectTipSop ";
        }if(!empty($usuExte)){           
            $usuArr     = explode("_", $usuExte);
                        
            $filtrar    .= "AND US.DEPE_CODI   = $usuArr[0]
                            AND US.USUA_CODI   = $usuArr[1]                             
                           ";                            
        }if($estadoTick != 3){
            $filtrar    .= "AND SO.SGD_SOP_EST = $estadoTick ";
        }if(!empty($respons)){           
            $usuArr      = explode("_", $respons);
                        
            $filtrar    .= "AND TS.SGD_TSOP_USUA_CODI   = $usuArr[1]
                            AND TS.SGD_TSOP_DEPE_CODI   = $usuArr[0]                             
                           ";                            
        }
    }

    //cantidad de datos por pagina
    //El dato llega como un string
    $cantidad = $cantidad * 1;
    if(empty($cantidad)) $cantidad = 20;
    
    //Pagina inicial
    if(empty($pagNo)) $pagNo = 1; 

    /**
     * Consultamos los tipo de soportes existentes
     * y los mostramos en un select
     */

    $sql1           =   "SELECT
                            TS.SGD_TSOP_DESCR AS DESCRP,
                            TS.SGD_TSOP_ID    AS CODIGO
                        FROM 
                            SGD_TSOP_TIPOSOPORTE TS
                        WHERE
                            TS.SGD_TSOP_ESTADO = 1";

    $rs             =   $db->conn->Execute($sql1);
    
    while(!$rs->EOF){
        $tipoSop[$rs->fields["CODIGO"]] = $rs->fields["DESCRP"];
        $rs->MoveNext();                
    }    
    
    /**
     * Filtros para mostrar solo los ticket deseados
     */
    

    
    //filtro de usuario con tickets
   $isqla  ="
                SELECT 
                    DISTINCT US.usua_nomb   AS NOMBRE,
                    US.depe_codi || '_' ||  US.usua_codi        AS DEPE_USUA
                FROM 
                    SGD_SOP_SOPORTE SG,
                    USUARIO US
                WHERE 
                    SG.depe_codi = us.depe_codi AND
                    SG.usua_codi = US.usua_codi 
            ";
            
    $rsa             =   $db->conn->Execute($isqla);
    
    while(!$rsa->EOF){
        $usuExteArr[$rsa->fields["DEPE_USUA"]] = $rsa->fields["NOMBRE"];
        $rsa->MoveNext();                
    }

    //filtro de usuario responsable
   $isqla  ="
                SELECT 
                    DISTINCT US.USUA_NOMB   AS NOMBRE,
                    US.depe_codi || '_' ||  US.usua_codi        AS DEPE_USUA
                FROM 
                    SGD_TSOP_TIPOSOPORTE TS,
                    USUARIO US
                WHERE 
                    TS.SGD_TSOP_USUA_CODI = US.USUA_CODI AND
                    TS.SGD_TSOP_DEPE_CODI = US.DEPE_CODI 
           ";
            
    $rsb  =   $db->conn->Execute($isqla);
    
    while(!$rsb->EOF){
        $usuRespArr[$rsb->fields["DEPE_USUA"]] = $rsb->fields["NOMBRE"];
        $rsb->MoveNext();                
    }

    //Estados del ticket 
    $ticEstado[3] = '--';
    $ticEstado[0] = 'Activo';
    $ticEstado[1] = 'Cerrado';
     
    /**
     * Buscamos los soportes existentes y los mostramos en la tabla
     */

    $isqlb   = "select count(1) AS TOTAL from SGD_SOP_SOPORTE";
    $rsb     = $db->conn->Execute($isqlb);
    $totalRe = $rsb->fields["TOTAL"];

    //Cantidad de paginas
    if($totalRe > $cantidad){ 
        $num  = ceil($totalRe/$cantidad);
    }else{
        $num  = 1;
    }
    $numPag   = range(1, $num);
    $pagina   = (($pagNo - 1) * $cantidad) ; 

    //consulta final realizada con filtros y paginacion 
    switch($db->driver){
        case 'oci8':
            $sql2    ="
                    SELECT 
                            *
                    FROM ( 
                            SELECT 
                                A.*
                                , ROWNUM row_number
                            FROM (
                                SELECT 
                                    SO.SGD_SOP_ID       AS TICKET,
                                    TS.SGD_TSOP_DESCR   AS TIPO,
                                    SO.SGD_SOP_FECHAINI AS FECHAINI,
                                    SO.SGD_SOP_FECHAFIN AS FECHAFIN,                            
                                    SO.SGD_SOP_EST      AS ESTADO,                            
                                    US.USUA_NOMB        AS NOMBRE,
                                    SO.SGD_SOP_COMENT   AS COMENT,
                                    DOS.USUA_NOMB       AS RESPONSA
                                    
                                FROM 
                                    SGD_SOP_SOPORTE SO,
                                    USUARIO US,
                                    USUARIO DOS,
                                    SGD_TSOP_TIPOSOPORTE TS
                                    
                                WHERE
                                    SO.DEPE_CODI    = US.DEPE_CODI        AND
                                    SO.USUA_CODI    = US.USUA_CODI        AND
                                    SO.SGD_TSOP_ID  = TS.SGD_TSOP_ID      AND
                                    TS.SGD_TSOP_USUA_CODI = DOS.USUA_CODI AND
                                    TS.SGD_TSOP_DEPE_CODI = DOS.DEPE_CODI 
                                    $filtrar
                                order by 
                                    SO.SGD_SOP_FECHAINI DESC
                            ) A
                            WHERE 
                                ROWNUM < (($pagNo * $cantidad) + 1 )
                        )
                    WHERE   
                        row_number >= ((($pagNo - 1) * $cantidad) + 1)
                        order by 1 desc 
                    ";                       

	        break;

        default:
            $sql2    ="
                        SELECT 
                            SO.SGD_SOP_ID       AS TICKET,
                            TS.SGD_TSOP_DESCR   AS TIPO,
                            SO.SGD_SOP_FECHAINI AS FECHAINI,
                            SO.SGD_SOP_FECHAFIN AS FECHAFIN,                            
                            SO.SGD_SOP_EST      AS ESTADO,                            
                            US.USUA_NOMB        AS NOMBRE,
                            SO.SGD_SOP_COMENT   AS COMENT,
                            DOS.USUA_NOMB       AS RESPONSA
                            
                        FROM 
                            SGD_SOP_SOPORTE SO,
                            USUARIO US,
                            USUARIO DOS,
                            SGD_TSOP_TIPOSOPORTE TS
                            
                        WHERE
                            SO.DEPE_CODI    = US.DEPE_CODI        AND
                            SO.USUA_CODI    = US.USUA_CODI        AND
                            SO.SGD_TSOP_ID  = TS.SGD_TSOP_ID      AND
                            TS.SGD_TSOP_USUA_CODI = DOS.USUA_CODI AND
                            TS.SGD_TSOP_DEPE_CODI = DOS.DEPE_CODI 
                            $filtrar
                        order by 
                            SO.SGD_SOP_FECHAINI DESC  
                        LIMIT $cantidad OFFSET $pagina";                       
    }
    
    $rs2            =   $db->conn->Execute($sql2);
    
    while(!$rs2->EOF){        
        $sopor[]    =  array(   'TICKET'    => $rs2->fields["TICKET"    ],
                                'TIPO'      => $rs2->fields["TIPO"      ],
                                'FECHAINI'  => $rs2->fields["FECHAINI"  ],
                                'FECHAFIN'  => $rs2->fields["FECHAFIN"  ],
                                'ESTADO'    => $rs2->fields["ESTADO"    ],
                                'NOMBRE'    => $rs2->fields["NOMBRE"    ],
                                'COMENT'    => $rs2->fields["COMENT"    ],
                                'RESPON'    => $rs2->fields["RESPONSA"  ]
                            );
        $rs2->MoveNext();                
    }   

    /**
     * El resultados de la logica se coloca en las variables
     * de la plantilla index.tpl
     * parametros para javascript y generar resultados a partir
     * de la depedencia a la cual pertenece el usuario
     */

    //variables de los filtros    
    $smarty->assign("noTicket"     ,$noTicket      ); //Numero del ticket digitado por el usuario
    $smarty->assign("selectTipSop" ,$selectTipSop  ); //Tipo de soporte seleccionado por usuario
    $smarty->assign("usuExte"      ,$usuExte       ); //Usuario seleccionado por usuario
    $smarty->assign("estadoTick"   ,$estadoTick    ); //Usuario seleccionado por usuario
    $smarty->assign("cantidad"     ,$cantidad      ); //Cantidad de datos por pagina
    $smarty->assign("pagNo"        ,$pagNo         ); //Pagina seleccionada
    
    $smarty->assign("sopor"        ,$sopor         ); //Arreglo de soportes
    $smarty->assign("usuExteArr"   ,$usuExteArr    ); //Arreglo Usuarios con ticket    
    $smarty->assign("ticRespon"    ,$usuRespArr    ); //Arreglo Usuarios con ticket    
    $smarty->assign("numPag"       ,$numPag        ); //Arreglo paginas a seleccionar
    $smarty->assign("tipoSop"      ,$tipoSop       ); //Tipo de soportes
    $smarty->assign("ticEstado"    ,$ticEstado     ); //Estados de los soportes
    $smarty->assign("respons"      ,$respons       ); //Responsable del ticket
    
    $smarty->assign("sessid"       ,session_id()   ); //Id de la session
    $smarty->assign("sesNam"       ,session_name() ); //Nombre de la session

    //Plantilla que imprime codigo html
    $smarty->display('index.tpl');
?>
