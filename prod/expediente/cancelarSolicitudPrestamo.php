<?
session_start();
$ruta_raiz = "..";
include($ruta_raiz.'/config.php'); 			// incluir configuracion.
define('ADODB_ASSOC_CASE', 1);
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db= new ConnectionHandler("$ruta_raiz");
if(!$fecha_fin) $fecha_fin = date("Y/m/d");
if($db) {
    //$db->conn->debug=true;
    function verMensaje($accion,$lst) {
        global $usua_nomb;
        global $depe_nomb;
        $tblMsg="
			<table border=0 cellspace=2 cellpad=2 WIDTH=50%  class='t_bordeGris' id=tb_general align='left'>
			  <tr>
			  	<td colspan='2' class='titulos4'>ACCION REQUERIDA COMPLETADA</td>
			  </tr>
			  <tr>
			  	<td align='right' bgcolor='#CCCCCC' height='25' class='titulos2'>ACCION REQUERIDA:</td>
			    <td  width='65%' height='25' class='listado2_no_identa'>$accion</td>
			  </tr>
			  <tr>
			  	<td align='right' bgcolor='#CCCCCC' height='25' class='titulos2'>EXPEDIENTES INVOLUCRADOS:</td>
			    <td  width='65%' height='25' class='listado2_no_identa'>$lst</td>
			  </tr>
			  <tr>
			    <td align='right' bgcolor='#CCCCCC' height=25 class='titulos2'>FECHA:</td>
			    <td  width=65% height='25' class='listado2_no_identa'>".date('Y-m-d h:i:s a')."</td>
			  </tr>	  
			  <tr>
			     <td align='right' bgcolor='#CCCCCC' height='25' class='titulos2'>USUARIO ORIGEN:</td>
			     <td  width='65%' height='25' class='listado2_no_identa'>$usua_nomb</td>
			   </tr>
			   <tr>
			     <td align='right' bgcolor='#CCCCCC' height='25' class='titulos2'>DEPENDENCIA ORIGEN:</td>
			     <td  width='65%' height='25' class='listado2_no_identa'>$depe_nomb</td>
			   </tr>	
			</table>";
        return $tblMsg;

    }
    if($_SESSION["usua_admin_archivo"]==1) {
        $whereSecc="and D.DEPE_CODI_TERRITORIAL=".$_SESSION["depe_codi_territorial"];
        $blank1stItem = "99999:Todas las Dependencias de la Seccional";
    }
    else $blank1stItem = "99999:Todas las Dependencias";

    !$accion?($accion= $_GET['accion']?$_GET['accion']:$_POST['accion']):0;
    if($accion) {
        switch ($accion) {
            case 'Buscar':

                if($dependenciaSel!=99999)$where.=" and p.DEPE_CODI=$dependenciaSel";
                if($selUsu)$where.=" and p.USUA_LOGIN_ACTU='$selUsu'";
                $sqlPRES_FECH_PEDI=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PEDI");
                $sqlPRES_FECH_CANC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_CANC");
                $sqlPRES_FECH_DEVO=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_DEVO");
                $sqlPRES_FECH_PRES=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_PRES");
                $sqlPRES_FECH_VENC=$db->conn->SQLDate("Y-m-d H:i A","p.PRES_FECH_VENC");
                $diasEspera=" date_part('days', ".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI)";
                switch($db->driver) {
                    case 'postgres':
                        $diasEspera=" date_part('days', ".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI)";
                        break;
                    case 'oci8':
                    case 'oci8po':
                        $diasEspera= " cast((".$db->conn->sysTimeStamp." - p.PRES_FECH_PEDI) as number(3)) ";
                        break;
                    default:

                }
                $sSQL="select p.PRES_ID as PRESTAMO_ID, p.SGD_EXP_NUMERO as EXPEDIENTE, carp.sgd_carpeta_numero as CARPETA,
			                p.USUA_LOGIN_ACTU as LOGIN, D.DEPE_NOMB as DEPENDENCIA,".$sqlPRES_FECH_PEDI." as F_SOLICITUD,".$sqlPRES_FECH_VENC." as F_VENCIMIENTO,".
                        $sqlPRES_FECH_CANC." as F_CANCELACION,".$sqlPRES_FECH_PRES." as F_PRESTAMO,".$sqlPRES_FECH_DEVO." as F_DEVOLUCION,
			                G.PARAM_VALOR as REQUERIMIENTO, E.PARAM_VALOR as ESTADO,p.PRES_ESTADO as ID_ESTADO,p.PRES_REQUERIMIENTO, $diasEspera as DIASSOL
			            from
					      	 PRESTAMO p
					      	 join DEPENDENCIA D on D.DEPE_CODI=p.DEPE_CODI
					      	 join SGD_PARAMETRO E on E.PARAM_CODI=p.PRES_ESTADO
					      	 join SGD_PARAMETRO G on G.PARAM_CODI=p.PRES_REQUERIMIENTO
					      	 left join SGD_CARPETA_EXPEDIENTE carp on carp.SGD_CARPETA_ID=p.SGD_CARPETA_ID
			            where
			                p.PRES_ESTADO in (1) and
			   		 		E.PARAM_NOMB='PRESTAMO_ESTADO' and 
					 		G.PARAM_NOMB='PRESTAMO_REQUERIMIENTO'
					 		and p.SGD_EXP_NUMERO is not null
					 		and ".$db->conn->SQLDate("Y/m/d","p.PRES_FECH_PEDI")." <= '$fecha_fin'
                        $where
                        $whereSecc";
                //$db->conn->debug=true;
                $rs=$db->query($sSQL);
                if($rs && !$rs->EOF) {
                    /****************************/

                    $v = "<br><input name='checkAll' value='checkAll' onclick='markAll();' checked='checked' type='checkbox'>";
                    $tblPrestados="<table width='100%' border=0 cellpadding=0 cellspacing=2 class='borde_tab'>";
                    $tblPrestados.="<tr><td class='titulos2' colspan='11'>EXPEDIENTES SOLICITADOS</td></tr>";
                    $tblPrestados.="<tr class='titulos3' align='center' valign='middle'>";
                    $tblPrestados.="<td><font class='titulos3'>Expediente</font></td>";
                    $tblPrestados.="<td><font class=titulos3'>Login</font></td>";
                    $tblPrestados.="<td><font class='titulos3'>Dependencia</font></td>";
                    $tblPrestados.="<td><font class=titulos3>Fecha<br>Solicitud</font></td>";
                    $tblPrestados.="<td><font class='titulos3'>Tiempo<br>Espera</font></td>";
                    $tblPrestados.="<td><font class='titulos3'>Requerimiento</font></td>";
                    $tblPrestados.="<td><font class='titulos3'>No. Carpeta</font></td>";
                    $tblPrestados.="<td><font class='titulos3'>$v</font></td></tr>";
                    $iCounter = 0;
                    // Display result
                    while($rs && !$rs->EOF) {
                        $v = "<input name='checkValue[".$rs->fields['PRESTAMO_ID']."]' value='".$rs->fields["LOGIN"]."' checked='checked' type='checkbox'>";
                        $iCounter++;
                        if (strcasecmp($krd,$rs->fields["LOGIN"])==0 && $rs->fields["ID_ESTADO"]==1) {
                            $accion="<a href=\"javascript: cancelar(".$rs->fields["PRESTAMO_ID"]."); \">Cancelar Solicitud</a>";
                        }
                        if($iCounter%2==0) {
                            $tipoListado="class=\"listado2\"";
                        }
                        else {
                            $tipoListado="class=\"listado1\"";
                        }
                        if($rs->fields["CARPETA"])$ncar=" No. ".$rs->fields["CARPETA"];
                        $tblPrestados.="<tr $tipoListado align='center'>";
                        $tblPrestados.="<td class='leidos'>".$rs->fields["EXPEDIENTE"]."</td>";
                        $tblPrestados.="<td class='leidos'>".$rs->fields["LOGIN"]."</td>";
                        $tblPrestados.="<td class='leidos'>".$rs->fields["DEPENDENCIA"]."</td>";
                        $tblPrestados.="<td class='leidos'>".$rs->fields["F_SOLICITUD"]."</td>";
                        $tblPrestados.="<td class='leidos'>".$rs->fields["DIASSOL"]."</td>";
                        $tblPrestados.="<td class='leidos'>".$rs->fields["REQUERIMIENTO"].$ncar."</td>";
                        $tblPrestados.="<td class='leidos'><center>".$rs->fields["CARPETA"]."</center></td>";
                        $tblPrestados.="<td class='leidos'>".$v."</td></tr>";
                        $tipoReq=$rs->fields["PRES_REQUERIMIENTO"];
                        $rs->MoveNext();
                    }
                    $tblPrestados.=" <tr  align='center'><td class='titulos3' colspan='11' align='center'><input type='submit' class='botones' value='Cancelar' name='accion' onClick='return validar();'></td></tr></table><br>";

                }


                break;
            case 'Cancelar':

                $lst=implode(',',array_keys($_POST['checkValue']));
                $setFecha="PRES_FECH_CANC=".$db->conn->OffsetDate(0,$db->conn->sysTimeStamp).", USUA_LOGIN_CANC='".$krd."'";
                $sqlUp = "update PRESTAMO set ".$setFecha.",PRES_ESTADO=4, canc_desc='Solicitud cancelada por vencimiento en su recolecci&oacute;n'
			   	where PRES_ID in (".$lst.")";
                if($db->conn->query($sqlUp)) {
                    $sql="select distinct sgd_exp_numero from prestamo where pres_id in ($lst)";
                    $rsLst=$db->conn->GetArray($sql);

                    foreach ($rsLst as $i=>$val) {
                        $regs .=$val[0].',';
                    }
                    $tblConfirma=verMensaje('CANCELAR SOLICITUD',$regs);
                }
                break;
            case 'combo':
                include "$ruta_raiz/class_control/usuario.php";
                $objUsu = new Usuario($db);
                die($objUsu->usuarioDep($dep));
                break;
        }
    }
    $sql = "SELECT dep_sigla ".$db->conn->concat_operator."'-'".$db->conn->concat_operator." DEPE_NOMB, DEPE_CODI FROM DEPENDENCIA where depe_estado=1 and depe_codi_territorial=".$_SESSION["depe_codi_territorial"]." ORDER BY 1";
    $rs = $db->conn->execute($sql);
    $selDep = $rs->GetMenu2('dependenciaSel', $dependenciaSel, $blank1stItem,false,0," id='dependenciaSel' class=select onChange='combos(this)'");
}
?>
<html>
    <head>
        <link href="../estilos/orfeo.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
        <script language="javascript" src="../js/funciones.js"></script>
        <script language="javascript" src="../js/ajax.js"></script>
        <script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
        <script language="javascript">
            var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "frmCancelar", "fecha_fin","btnDate2","<?=$fecha_fin?>",scBTNMODE_CUSTOMBLUE);
        </script>

        <script language="JavaScript">
            function regresar()
            {
                window.document.frmCancelar.action ='<?=$ruta_raiz?>/prestamo/menu_prestamo.php?krd=<?=$krd?>';
                window.document.frmCancelar.submit();
            }



            function combos()
            {
                var obj=document.getElementById('dependenciaSel')
                var objD = document.getElementById('cmbUsu');
                if(obj.value!='99999')
                {
                    if(xmlHttp)
                    {
                        xmlHttp.open("GET", "./cancelarSolicitudPrestamo.php?accion=combo&dep="+obj.value);
                        xmlHttp.onreadystatechange = function()
                        {
                            if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                            {
                                objD.innerHTML = xmlHttp.responseText;
                            }
                        }
                        xmlHttp.send(null);
                    }
                }
                else objD.innerHTML="<select name='selUsu'  class='select'><option value='0'>-TODOS LOS USUARIOS-</option></select>";
            }

            function validar()
            {
                marcados = 0;
                for(i=0;i<document.frmCancelar.elements.length;i++)
                {
                    if(document.frmCancelar.elements[i].checked==true )
                    {
                        if(document.frmCancelar.elements[i].name!='checkAll')
                        {
                            marcados++;
                        }

                    }
                }
                if(marcados)return true;
                else
                {
                    alert('Debe seleccionar un registro')
                    return false;
                }
            }

            function markAll()
            {
                if(document.frmCancelar.elements['checkAll'].checked)
                {
                    for(i=1;i<document.frmCancelar.elements.length;i++)
                    {
                        if(document.frmCancelar.elements[i].name.slice(0, 10)=='checkValue')
                        {
                            document.frmCancelar.elements[i].checked=true;
                        }
                    }
                }
                else
                    for(i=1;i<document.frmCancelar.elements.length;i++)
                        document.frmCancelar.elements[i].checked=false;

            }
        </script>
        <title>Orfeo - Cancelar Solicitudes de Prestamos</title>
    </head>
    <body>
        <div id="spiffycalendar" class="text"></div>
        <form name="frmCancelar" method="post" action="<?= $_SERVER['PHP_SELF']?>?expNum=<?=$expNum?>&krd=<?=$krd?>" >
<?if($tblConfirma)die($tblConfirma);?>
            <table width="60%" align="center" border=0 cellpadding=0 cellspacing=2 class='borde_tab'>
                <tbody>
                    <tr>
                        <td  class="titulos4" colspan="2">CANCELAR SOLICITUDES DE PR&Eacute;STAMO</td>
                    </tr>
                    <tr>
                        <td class="titulos5">Dependecia</td>
                        <td class="listado5"><?=$selDep?></td>
                    </tr>
                    <tr>
                        <td class="titulos5">Usuario</td>
                        <td class="listado5"><div id='cmbUsu'></div></td>
                    </tr>
                    <tr>
                        <td class="titulos5">Hasta Fecha (yyyy/mm/dd)</td>
                        <td class="listado5">
                            <script language="javascript">
                                dateAvailable1.writeControl();
                                dateAvailable1.dateFormat="yyyy/MM/dd";
                            </script>
                        </td>
                    </tr>
                    <tr bordercolor="#FFFFFF">
                        <td colspan="2" class="listado2">
                            <center><input name="accion" type="submit" class="botones" id="accion" value="Buscar">
                                &nbsp;<input name="accion" type="button" class="botones" id="accion" value="Regresar" onClick="regresar();"></center>
                        </td>
                    </tr>
                </tbody>
            </table>
<?=$tblPrestados?>
        </form>
    </body>
    <script>setTimeout("combos()",0);</script>
</html>