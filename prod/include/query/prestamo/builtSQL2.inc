<?PHP

/********* SEGUNDA PARTE DE LA CONSULTA. WHERE PARA LOS CRITERIOS DE BUSQUEDA DEFINIDOS POR EL USUARIO prestamo.php *********/



            // Adecuación de las fechas

	    $sqlWHERE_PRES_FECH_PEDI=$db->conn->SQLDate("Ymd","P.PRES_FECH_PEDI"); 
	    $sqlWHERE_PRES_FECH_CANC=$db->conn->SQLDate("Ymd","P.PRES_FECH_CANC"); 
	    $sqlWHERE_PRES_FECH_DEVO=$db->conn->SQLDate("Ymd","P.PRES_FECH_DEVO"); 
	    $sqlWHERE_PRES_FECH_PRES=$db->conn->SQLDate("Ymd","P.PRES_FECH_PRES"); 
	    $sqlWHERE_PRES_FECH_VENC=$db->conn->SQLDate("Ymd","P.PRES_FECH_VENC"); 
	    $sqlWHERE_PRES_FECH_PEDI_HOR=$db->conn->SQLDate("YmdhiA","P.PRES_FECH_PEDI");



            // inicialización de algunos parámetros para limitar la búsqueda

            if ($ps_RADI_NUME_RADI!="")    { $sWhere.=" and  cast (P.RADI_NUME_RADI AS VARCHAR) LIKE '%".$ps_RADI_NUME_RADI."'"; }
      	    if ($ps_USUA_LOGIN!="")        { $sWhere.=" and P.USUA_LOGIN_ACTU LIKE '".strtoupper($ps_USUA_LOGIN)."'";}
      	    if ($ps_DEPE_NOMB!="")         { $sWhere.=" and P.DEPE_CODI=".$ps_DEPE_NOMB;	         }     									 
            if ($ps_PRES_REQUERIMIENTO!=""){ $sWhere.=" and P.PRES_REQUERIMIENTO=".$ps_PRES_REQUERIMIENTO; }
      	    if ($ps_USUA_NOMB!="")         { 
	       if (strcasecmp(strtoupper($ps_USUA_NOMB),strtoupper($ps_USUA_LOGIN))!=0) {
    		  $sWhere.=" and P.USUA_LOGIN_ACTU LIKE '".strtoupper($ps_USUA_NOMB)."'";			  
	       }
 	    }	



            // condición para limitar por fechas y estado la búsqueda según la opción del menú seleccionada

            if ($opcionMenu==0 || $opcionMenu==4) { //reporte y estado de reservas
   	       if ($ps_PRES_ESTADO=="") { 
		  if ($fechaInicial!="" || $fechaFinal!="")         { $sWhere.=" and ".$sqlWHERE_PRES_FECH_PEDI; } // Fecha de creación del registro
               }
               else {
		  if($ps_PRES_ESTADO!=-1){ //diferentes a vencido
		     $sWhere.=" and P.PRES_ESTADO=".$ps_PRES_ESTADO." "; 
		     if ($fechaInicial!="" || $fechaFinal!="") {
		        if($ps_PRES_ESTADO==2 || $ps_PRES_ESTADO==5){ $sWhere.=" and ".$sqlWHERE_PRES_FECH_PRES; }
			elseif($ps_PRES_ESTADO==1)                  { $sWhere.=" and ".$sqlWHERE_PRES_FECH_PEDI; }					 					 						
			elseif($ps_PRES_ESTADO==3)                  { $sWhere.=" and ".$sqlWHERE_PRES_FECH_DEVO; }					 
			elseif($ps_PRES_ESTADO==4)                  { $sWhere.=" and ".$sqlWHERE_PRES_FECH_CANC; }
		     }
		  }
		  else { // estado vencido
		     $sWhere.=" and P.PRES_ESTADO=2 and ".$sqlWHERE_PRES_FECH_VENC;
		     if ($fechaInicial=="" && $fechaFinal==""){ $sWhere.="<'".date('Ymd')."' "; }
		  }
               }   
            }
            elseif ($opcionMenu==1 || $opcionMenu==3) { //prestamo y cancelación
    	       $sWhere.=" and P.PRES_ESTADO=1 "; 
	       if ($opcionMenu==3) { $sWhere.=" and ".$sqlWHERE_PRES_FECH_PEDI_HOR; } // fecha hasta la cual se cancelan				  
	    }			   
            elseif ($opcionMenu==2) { //devolucion
	       $sWhere.=" and P.PRES_ESTADO in (2,5) ";
	    }		



            // termina la sentencia con el respectivo valor de la fecha	 
              
	    if (($fechaInicial!="" || $fechaFinal!="") && $opcionMenu!=1 && $opcionMenu!=2) {
	       $sqlFechaInicial=str_replace('-','',$fechaInicial);
               $sqlFechaFinal  =str_replace('-','',$fechaFinal); 			   
	       if ($opcionMenu==3){ $sqlFechaFinal.=$ps_hora_limite.$ps_minuto_limite.$ps_meridiano;  }
	       if    ($fechaInicial!="" && $fechaFinal==""){ $sWhere.=">='".$sqlFechaInicial."' "; }
	       elseif($fechaInicial=="" && $fechaFinal!=""){ $sWhere.="<='".$sqlFechaFinal."' "; }
	       elseif($fechaInicial!="" && $fechaFinal!=""){ 
                  // Verifica que la fecha inicial sea menor que la final
	          if ($sqlFechaFinal<$sqlFechaInicial) {
		     $a=$sqlFechaInicial;
	      	     $sqlFechaInicial=$sqlFechaFinal;
		     $sqlFechaFinal=$a;
  	          }					 
                  $sWhere.=" between '".$sqlFechaInicial."' and '".$sqlFechaFinal."' "; 
	       }			
            }



            // limita los resultados a la territorial que custodia los documentos

            if ($opcionMenu==1 || $opcionMenu==2 || $opcionMenu==3) { //préstamo, devolución o cancelación
               $sWhere.=" and DA.DEPE_CODI_TERRITORIAL=
                          ( select UD.DEPE_CODI_TERRITORIAL 
                            from   USUARIO UP, DEPENDENCIA UD 
                            where  UP.USUA_LOGIN LIKE '".strtoupper($krd)."' and UP.DEPE_CODI=UD.DEPE_CODI ) ";
            }	 
?>		 
