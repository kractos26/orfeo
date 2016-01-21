
<?php
session_start();
error_reporting(7);
$anoActual = date("Y");
if(!$fecha_busq) $fecha_busq=date("Y-m-d");
if(!$fecha_busq2) $fecha_busq2=date("Y-m-d");


$ruta_raiz = "..";
if (!$dependencia and !$depe_codi_territorial)include "../rec_session.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");	
define('ADODB_FETCH_ASSOC',2);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
?>
<?php
//$db->conn->debug=true;
if($db)
{   
    //combo formas de envio
    error_reporting(7);
	$ss_RADI_DEPE_ACTUDisplayValue = "--- TODOS LOS TIPOS ---";
	$valor = 0;
	include "../include/query/reportes/querytipo_envio.php";
	$sqlTS = "select $sqlConcat ,SGD_FENV_CODIGO from SGD_FENV_FRMENVIO
					order by SGD_FENV_CODIGO";
	$rsTs = $db->conn->Execute($sqlTS);
	$selFEnv= $rsTs->GetMenu2("tipo_envio","$tipo_envio",$blank1stItem = "$valor:$ss_RADI_DEPE_ACTUDisplayValue", false, 0," class='select'");


    //combo dependencias
	error_reporting(7);
	$ss_RADI_DEPE_ACTUDisplayValue = "--- TODAS LAS DEPENDENCIAS ---";
	$valor = 0;
	include "$ruta_raiz/include/query/devolucion/querydependencia.php";
	$sqlD = "select $sqlConcat ,depe_codi from dependencia
	        where depe_codi_territorial = $depe_codi_territorial
							order by depe_codi";
    $rsDep = $db->conn->Execute($sqlD);
	$selDep=$rsDep->GetMenu2("dep_sel","$dep_sel",$blank1stItem = "$valor:$ss_RADI_DEPE_ACTUDisplayValue", false, 0," class='select'");

    //genera informe
    if($generar_informe)
    {
        if ($tipo_envio == 0)
        {
         $where_tipo = "";
        }else
        {
         $where_tipo = " and a.SGD_FENV_CODIGO = $tipo_envio ";
        }
        if ($dep_sel == 0)
        {
        /*
        *Seleccionar todas las dependencias de una territorial
        */
            include "$ruta_raiz/include/query/devolucion/querydependencia.php";
            $sqlD = "select $sqlConcat ,depe_codi from dependencia
                    where depe_codi_territorial = '$depe_codi_territorial'
                    order by depe_codi";
            $rsDep = $db->conn->Execute($sqlD);
            while(!$rsDep->EOF)
                 {
                    $depcod = $rsDep->fields["DEPE_CODI"];
                    $lista_depcod .= " $depcod,";
                    $rsDep->MoveNext();
                   }
            $lista_depcod .= "0";
        }else
        {
        $lista_depcod = $dep_sel;
        }
        //Se limita la consulta al substring del numero de radicado de salida 27092005
        include "../include/query/reportes/querydepe_selecc.php";

        $generar_informe = 'generar_informe';
            error_reporting(7);
            $fecha_ini = $fecha_busq;
            $fecha_fin = $fecha_busq2;
            
            
            $fecha_ini = mktime($hora_ini,$minu_ini,$seg_ini,substr($fecha_ini,5,2),substr($fecha_ini,8,2),substr($fecha_ini,0,4));
            $fecha_fin = mktime($hora_fin,$minu_fin,$seg_fin,substr($fecha_fin,5,2),substr($fecha_fin,8,2),substr($fecha_fin,0,4));
            $guion     = "' '";
           
            include "$ruta_raiz/include/query/busqueda/busquedaPiloto1.php";
            include "$ruta_raiz/include/query/reportes/querygenerar_estadisticas_envio.php";
            if($tipo_envio=="101" or $tipo_envio=="108" )
            {
             $where_isql .= " AND a.SGD_RENV_PLANILLA IS NOT NULL AND
                    a.SGD_RENV_PLANILLA != '00'
                ";
            }
            if($tipo_envio==0)
            {
             $where_isql .= " and ((a.sgd_fenv_codigo != '101' and a.sgd_fenv_codigo != '108' )
                              or (a.sgd_renv_planilla is not null and a.sgd_renv_planilla != '00'))
                ";
            }
            $query_t = $query . $where_isql . $where_tipo . $where_depe . $order_isql ;
            $query_t1 = $query1 . $where_isql . $where_tipo . $where_depe . $order_isql ;
            
           
            $respu=$db->conn->Execute($query_t1);
             
          
            
         
           //$db->conn->debug=true;
            $ruta_raiz = "..";
            error_reporting(7);
            define('ADODB_FETCH_NUM',1);
            $ADODB_FETCH_MODE = ADODB_FETCH_NUM;
            require "../anulacion/class_control_anu.php";
            $db->conn->SetFetchMode(ADODB_FETCH_NUM);

         
        
           
            
        /* */
          
            
            //////////////////////////////
            $btt = new CONTROL_ORFEO($db);
            $campos_align = array("C","L","L","L","L","L","L","L","L","L","L","L","L");
            $campos_tabla = array("depe_nomb","radi_nume_sal","sgd_renv_nombre","sgd_renv_dir","sgd_renv_mpio","sgd_renv_depto","sgd_renv_fech","sgd_fenv_descrip","sgd_renv_planilla","sgd_renv_observa");
            $campos_vista = array ("Dependencia","Radicado","Destinatario","Direccion","Municipio","Departamento","Fecha de envio","Forma de envio","N&uacute;mero de gui&iacute;a","Observaciones");
            $campos_width = array (150,80,210           ,250        ,70        ,80            ,60 ,80,77,120);

            
            
            $btt->campos_align = $campos_align;
            
            $btt->campos_tabla = $campos_tabla;
            $btt->campos_vista = $campos_vista;
            $btt->campos_width = $campos_width;
    }
}

//ciclo for para generar las opciones en los combos de horas,minutos y segundos
$hora_ini= $hora_ini ? $hora_ini : 8;
$minu_ini= $minu_ini ? $minu_ini : 00;
$seg_ini=  $seg_ini  ? $seg_ini  : 00;

$hora_fin= $hora_fin ? $hora_fin : 17;
$minu_fin= $minu_fin ? $minu_fin : 59;
$seg_fin = $seg_fin  ? $seg_fin  : 59;

	for ($h=0; $h<60; $h++ )
	{
        if($h<24)
        {   $tmpi = ($h==$hora_ini)? 'selected' : '';
            $ih .="<option value='$h' $tmpi>$h</option>";
            $tmpf = ($h==$hora_fin)? 'selected' : '';
            $fh .="<option value='$h' $tmpf>$h</option>";
        }

        $tmpi = ($h==$minu_ini)? 'selected' : '';
		$im .="<option value='$h' $tmpi>$h</option>";
		$tmpf = ($h==$minu_fin)? 'selected' : '';
		$fm .="<option value='$h' $tmpf>$h</option>";

        $tmpi = ($h==$seg_ini)? 'selected' : '';
		$is .="<option value='$h' $tmpi>$h</option>";
		$tmpf = ($h==$seg_fin)? 'selected' : '';
		$fs .="<option value='$h' $tmpf>$h</option>";
	}
	
?>
<head>
<link rel="stylesheet" href="<?=$ruta_raiz."/estilos/".$_SESSION["ESTILOS_PATH"]?>/orfeo.css">
</head>
<BODY>
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript"><!--
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "new_product", "fecha_busq","btnDate1","<?=$fecha_busq?>",scBTNMODE_CUSTOMBLUE);
	var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "new_product", "fecha_busq2","btnDate2","<?=$fecha_busq2?>",scBTNMODE_CUSTOMBLUE);
//--></script>
<table width="100%" class='borde_tab' cellspacing="5">
  <tr>
    <td height="30" valign="middle"   class='titulos5' align="center">LISTADO DE DOCUMENTOS ENVIADOS POR AGENCIA DE CORREO
	</td>
  </tr>
</table>
<table><tr><td></td></tr></table>
<form name="new_product"  action='../reportes/generar_estadisticas_envio.php?<?=session_name()."=".session_id()."&krd=$krd&fecha_h=$fechah&fecha_busq=$fecha_busq&fecha_busq2=$fecha_busq2"?>' method=post>
<center>
<TABLE width="80%" class='borde_tab'>
  <!--DWLayoutTable-->
  <TR>
    <TD width="25%" height="21"  class='titulos3'> Fecha desde<br>
	<?php
	  echo "($fecha_busq)";
	?>
	</TD>
    <TD width="75%" align="left" class='titulos5'>

        <script language="javascript">
            dateAvailable.date = "2003-08-05";
            dateAvailable.writeControl();
            dateAvailable.dateFormat="yyyy-MM-dd";
    	</script>
        &nbsp;&nbsp;&nbsp;Hora inicial:
        <select name="hora_ini" id="hora_ini" class='select'><?php echo $ih; ?></select>:
		<select name="minu_ini" id="minu_ini" class='select'><?php echo $im; ?></select>:
		<select name="seg_ini" id="seg_ini" class='select'><?php echo $is; ?></select>
</TD>
  </TR>
  <TR>
    <TD height="21"  class='titulos3'> Fecha Hasta<br>
	<?php
	  echo "($fecha_busq2)";
	?>
	</TD>
    <TD align="left"  class='titulos5'>
        <script language="javascript">
		        dateAvailable2.date = "2003-08-05";
			    dateAvailable2.writeControl();
			    dateAvailable2.dateFormat="yyyy-MM-dd";
    	  </script>
          &nbsp;&nbsp;&nbsp;Hora final:&nbsp;&nbsp;&nbsp;
          <select name="hora_fin" id="hora_fin" class="select"><?php echo $fh; ?></select>:
		  <select name="minu_fin" id="minu_fin" class="select"><?php echo $fm; ?></select>:
		  <select name="seg_fin"  id="seg_fin"  class="select"><?php echo $fs; ?></select>
</TD>
  </TR>
  <tr>
    <TD height="26" class='titulos3'>Tipo de Salida</TD>
    <TD valign="top" align="left" class='titulos5'><?=$selFEnv?></TD>
  </tr>
  <TR>
    <TD height="26" class='titulos3'>Dependencia</TD>
    <TD valign="top" class='titulos5'><?=$selDep?></TD>
  </TR>
  <tr>
    <td height="26" colspan="2" valign="top" class='titulos5'> <center>
		<INPUT TYPE=SUBMIT name=generar_informe Value=' Generar Informe ' class=botones_mediano></center>
		</td>
	</tr>
  </TABLE>

<?php
if($btt)
{
?>
	</center>
	<span class="etextomenu">
	<b>Listado de documentos Enviados</b><br>
	Fecha Inicial <?=$fecha_busq .  "  $hora_ini:$minu_ini:$seg_ini" ?> <br>
	Fecha Final   <?=$fecha_busq2 . "  $hora_fin:$minu_fin:$seg_fin" ?> <br>
	Fecha Generado <? echo date("Ymd - H:i:s"); ?>
 <?php
	$btt->tabla_sql($query_t);
	
	error_reporting(7);
       if(count($planillasgeneradas)>0)
            {
            foreach ($planillasgeneradas as $key => $value) 
            {
                 echo "<a href='../seguridadImagen.php?fec=".base64_encode($value)."' target='".date("dmYh").time("his")."'>Planilla N° $key</a>";
                echo "<br>";
            }
            }
        
	if($respu->fields)
        {   
                 
                include './reporteenviopdf.php';
                $pdf = new PDF("..");
                $pdf->sql = $query_t1;
                $pdf->fecha_busq =  $fecha_busq." ".$hora_ini.":".$minu_ini.":".$seg_ini;
                $pdf->fecha_busq2= $fecha_busq2." ".$hora_fin.":".$minu_fin.":".$seg_fin;
             
                
                
                $pdf->creaHoja();
                $arpdf_tmp = "/pdfs/planillas/envios/".$dependencia."_".$krd. date("Ymd_hms") . "_envio.pdf";
                $pdf->Output("../poolsgc2013".$arpdf_tmp);      
                  
           
            
            echo "<a href='../seguridadImagen.php?fec=".base64_encode($arpdf_tmp)."' target='".date("dmYh").time("his")."'>Abrir Archivo Pdf</a>";
        //include 'pdf.php';
        }
}
?>
</form>
<HR>


