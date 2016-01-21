<?php
	$sqlConcat = $db->conn->Concat("usua_doc","'-'","usua_login");

	switch($db->driver)
	{
	case 'mssql':
		$isql = "select 
			u.usua_nomb      		AS NOMBRE
			,u.usua_login	     	AS USUARIO
			,d.depe_nomb			AS DEPENDENCIA
			," . $sqlConcat  . " 	AS CHR_USUA_DOC
		from usuario u, dependencia d 
		where u.depe_codi = " . $dep_sel .
		" AND u.depe_codi = d.depe_codi " . $dependencia_busq2 . "
		order by " . $order . " " . $orderTipo;

		break;
	default:
		if($dep_sel)
                {
                    $isql = 'select u.usua_nomb AS "NOMBRE" ,u.usua_login AS "USUARIO" ,
                    d.depe_nomb	AS "DEPENDENCIA" 
                    ,CASE  WHEN u.usua_codi=1 THEN '."'Jefe'".' END AS "ROL"
                    ,CASE  WHEN u.usua_esta='."'1'".' '
                                      . 'THEN '."'Activo'".' WHEN  U.USUA_ESTA<>'."'1'".' '
                                      . 'THEN '."'Inactivo'".' END AS "ESTADO"
                                      ,u.usua_email EMAIL,
                    

                   '.$sqlConcat.' AS "CHR_USUA_DOC"
                    from usuario u inner join dependencia d
                    on u.depe_codi = d.depe_codi
                        where u.depe_codi = ' . $dep_sel .'
                        order by ' . $order . ' ' . $orderTipo;
                }
                if($_POST["busqRadicados"]){
                    
                      $isql = 'select u.usua_nomb AS "NOMBRE" ,
                          u.usua_login AS "USUARIO" 
                          ,CASE  WHEN u.usua_codi=1 THEN '."'Jefe'".' END AS "ROL"
                    ,CASE  WHEN u.usua_esta='."'1'".' '
                                      . 'THEN '."'Activo'".' WHEN  U.USUA_ESTA<>'."'1'".' '
                                      . 'THEN '."'Inactivo'".' END AS "ESTADO"
                                      ,u.usua_email EMAIL,
                    d.depe_nomb	AS "DEPENDENCIA" ,'.$sqlConcat.' AS "CHR_USUA_DOC"
                    from usuario u left join dependencia d
                    on u.depe_codi = d.depe_codi
                    where '.$busq_radicados_tmp;
                }

	break;
	}
?>
