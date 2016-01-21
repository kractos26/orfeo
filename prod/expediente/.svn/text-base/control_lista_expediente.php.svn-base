<?php
include_once( "$ruta_raiz/include/tx/Historico.php" );
include_once( "$ruta_raiz/include/tx/Expediente.php" );
$expediente = new Expediente($db);
$Historico = new Historico($db);
$q_exp  = "SELECT  SGD_EXP_NUMERO as valor, SGD_EXP_NUMERO as etiqueta, SGD_EXP_FECH as fecha";
$q_exp .= " FROM SGD_EXP_EXPEDIENTE ";
$q_exp .= " WHERE RADI_NUME_RADI = " . $numrad;
$q_exp .= " AND SGD_EXP_ESTADO <> 2";
$q_exp .= " ORDER BY fecha";
$ADODB_COUNTRECS=true;
$rs_exp = $db->conn->query( $q_exp );
$ADODB_COUNTRECS=false;
if(!$numExpActual)$numExpActual=$rs_exp->fields['VALOR'];
$selExpIncluidos=$rs_exp->GetMenu( 'expIncluido[]',$numExpActual, false, true, 3, "id='expIncluido[]' class='select' onChange='cambiaExp()'", false );
if(isset($_POST['btnMoverCarp']))
{
	if(isset($_POST['checkRads']) && $numExpActual)
	{
		$Historico = new Historico($db);
		foreach($_POST['checkRads'] as $rads=>$valu)
		{
                        //$db->conn->debug=true;
			if($_POST['selCarpetas']==0)
			{
		
				$sqlDel="delete from sgd_exp_radcarpeta where sgd_carpeta_id in (select sgd_carpeta_id from sgd_carpeta_expediente where sgd_exp_numero='$numExpActual') and radi_nume_radi=$rads";
				$rsDel=$db->conn->Execute($sqlDel);
				if($rsDel)
				{	
					$codiRegE[0]=$rads;  
					$radiModi = $Historico->insertarHistoricoExp($numExpActual,$codiRegE , $_SESSION['dependencia'], $_SESSION['codusuario'],"Radicado sin carpeta", 66, 0);
				}
			}
			else
			{
				$sqlDel="delete from sgd_exp_radcarpeta where sgd_carpeta_id in (select sgd_carpeta_id from sgd_carpeta_expediente where sgd_exp_numero='$numExpActual') and radi_nume_radi=$rads";
				$rsDel=$db->conn->Execute($sqlDel);
				$sqlIns="insert into sgd_exp_radcarpeta(radi_nume_radi,sgd_carpeta_id) values($rads,".$_POST['selCarpetas'].")";
				$rsIns=$db->conn->Execute($sqlIns);
				if($rsIns)
				{
					$sql="select * from sgd_carpeta_expediente where sgd_carpeta_id=".$_POST['selCarpetas'];
					$rs=$db->conn->Execute($sql);
					$codiRegE[0]=$rads;
					$radiModi = $Historico->insertarHistoricoExp($numExpActual,$codiRegE , $_SESSION['dependencia'], $_SESSION['codusuario'],"Se incluye Radicado en la carpeta No [".$rs->fields['SGD_CARPETA_NUMERO']."] ".$rs->fields['SGD_CARPETA_DESCRIPCION'], 66, 0);
				}
			}
			
		}
	}
}

if(isset($_POST['btnAanexoAsociado']))
{
	if(isset($_POST['chkRadsInc']) && $numExpActual)
	{
		foreach($_POST['chkRadsInc'] as $rads=>$valu)
		{
            $resultadoExp = $expediente->insertar_expediente( $numExpActual, $rads, $dependencia, $codusuario, $usua_doc );
            if( $resultadoExp == 1 )
            {
            	$observa = "Se incluye Anexo/Asociado del radicado No:$numrad al Expediente";
                $tipoTx = 53;
                $radicados[0] = $rads;
                $Historico->insertarHistoricoExp( $numExpActual, $radicados, $dependencia, $codusuario, $observa, $tipoTx, 0 );
             }
             else
             {
                print '<hr><font color=red>No se incluyo el radicado No. '.$numRadicado.' en el expediente No. '.$numExpediente.'. Por favor intente de nuevo.</font><hr>';
                break;
             }
		}
	}
}

?>
<script language="javascript" src="<?=$ruta_raiz?>/js/ajax.js"></script>
<script>
<?if($rs_exp && $rs_exp->RecordCount()>0){?>
setTimeout("cambiaExp()",0);
<?}?>
function regresar(){
	
	if(window.document.frmExp)
	{
	    if(document.getElementById('expIncluido[]'))window.document.frmExp.action=<?="'".$_SERVER['PHP_SELF']."?verrad=$numrad&numExpediente='+document.getElementById('expIncluido[]').value+'&numExpActual='+document.getElementById('expIncluido[]').value+'&menu_ver_tmp=4'"?>;
	    else window.document.frmExp.action=<?="'".$_SERVER['PHP_SELF']."?verrad=$numrad&menu_ver_tmp=4'"?>;
		window.document.frmExp.submit();
	}
	else window.location.reload();
	
	window.close();
}

function cambiaExp()
{
	if(xmlHttp) 
	{
		 var obj = document.getElementById('listaConsulta');
		 xmlHttp.open("GET", "<?=$ruta_raiz?>/expediente/listaConsulta.php?numExpediente="+document.getElementById('expIncluido[]').value+"&ruta_raizImg=.&verrad=<?=$verrad?>&frmActual=<?=$_SERVER['PHP_SELF']?>");
		 xmlHttp.onreadystatechange = function()
		 {
			  if (xmlHttp.readyState == 4 && xmlHttp.status == 200) 
			  {
			  	obj.innerHTML = xmlHttp.responseText;
			  }
		  }
		  xmlHttp.send(null);
	}
}

function insertarExpediente()
{
    window.open( "<?=$ruta_raiz?>/expediente/insertarExpediente.php?sessid=<?=session_id()?>&nurad=<?=$verrad?>&krd=<?=$krd?>&ind_ProcAnex=<?=$ind_ProcAnex?>","HistExp<?=$fechaH?>","height=300,width=600,scrollbars=yes" );
}

function excluirExpediente() {
    window.open( "<?=$ruta_raiz?>/expediente/excluirExpediente.php?sessid=<?=session_id()?>&nurad=<?=$verrad?>&krd=<?=$krd?>&ind_ProcAnex=<?=$ind_ProcAnex?>","HistExp<?=$fechaH?>","height=300,width=600,scrollbars=yes" );
}

function verTipoExpediente() 
{
  	var anchoPantalla = screen.availWidth;
  	var altoPantalla  = screen.availHeight; 
  	window.open("<?=$ruta_raiz?>/expediente/tipificarExpediente.php?nurad=<?=$verrad?>&krd=<?=$krd?>&dependencia=<?=$dependencia?>&fechaExp=<?=substr($radi_fech_radi,0,10)?>&codusua=<?=$codusua?>&coddepe=<?=$coddepe?>","MflujoExp<?=$fechaH?>","height="+altoPantalla+","+"width="+anchoPantalla+",scrollbars=yes");
}

function Responsable(numeroExpediente) 
{
	window.open("<?=$ruta_raiz?>/expediente/responsable.php?&numeroExpediente="+numeroExpediente+"&krd=<?=$krd?>","Responsable","height=300,width=450,scrollbars=yes");
}
function nombreExp(numeroExpediente,w,h,pos)
{
    if(pos=="random")	{myleft=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;mytop=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
    if(pos=="center")	{myleft=(screen.width)?(screen.width-w)/2:100;mytop=(screen.height)?(screen.height-h)/2:100;}
    else if((pos!='center' && pos!="random") || pos==null){myleft=0;mytop=20}
    settings="width=" + w + ",height=" + h + ",top=" + mytop + ",left=" + myleft + ",scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no";
    window.open("<?=$ruta_raiz?>/expediente/nombreExp.php?&expNUM="+numeroExpediente+"&krd=<?=$krd?>","modExp",settings);
}

function modFlujo(numeroExpediente,texp,codigoFldExp)
{
	window.open("<?=$ruta_raiz?>/flujo/modFlujoExp.php?codigoFldExp="+codigoFldExp+"&krd=<?=$krd?>&numeroExpediente="+numeroExpediente+"&texp="+texp+"&krd=<?=$krd?>","TexpE<?=$fechaH?>","height=250,width=750,scrollbars=yes");
}

function markAll()
{
	if(document.frmExp.elements['checkAll'].checked)
	{
		for(i=1;i<document.frmExp.elements.length;i++)
		{
			if(document.frmExp.elements[i].name.slice(0,9)=='checkRads')
			document.frmExp.elements[i].checked=1;
		}
	}
	else
	{
		for(i=1;i<document.frmExp.elements.length;i++)
		{
			if(document.frmExp.elements[i].name.slice(0,9)=='checkRads')
			document.frmExp.elements[i].checked=0;
		}
	}
}

function todosInc()
{
	if(document.frmExp.elements['checkTodosInc'].checked)
	{
		for(i=1;i<document.frmExp.elements.length;i++)
		{
			if(document.frmExp.elements[i].name.slice(0,10)=='chkRadsInc')
			document.frmExp.elements[i].checked=1;
		}
	}
	else
	{
		for(i=1;i<document.frmExp.elements.length;i++)
		{
			if(document.frmExp.elements[i].name.slice(0,10)=='chkRadsInc')
			document.frmExp.elements[i].checked=0;
		}
	}
}

function crearProc(numeroExpediente)
{
	 window.open("<?=$ruta_raiz?>/expediente/crearProceso.php?sessid=<?=session_id()?>&numeroExpediente="+numeroExpediente+"&krd=<?=$krd?>&ind_ProcAnex=<?=$ind_ProcAnex?>","HistExp<?=$fechaH?>","height=320,width=600,scrollbars=yes");
}

function creaCarpeta(exp)
{
	windowprops = "location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=550,height=300";
	 window.open( "<?=$ruta_raiz?>/expediente/carpetaExp.php?sessid=<?=session_id()?>&expNum="+exp+"&krd=<?=$krd?>&ind_ProcAnex=<?=$ind_ProcAnex?>","subExp<?=$fechaH?>",windowprops );
}

function valida()
{
	marcados = 0;
	for(i=0;i<document.frmExp.elements.length;i++)
	{	
		if(document.frmExp.elements[i].name.slice(0,9)=='checkRads' && document.frmExp.elements[i].checked==1)
		{
			marcados++;
        }
        
    }
	if(marcados>=1)
	{
	  return true;
	}
	else
	{
		alert("Debe marcar un elemento");
		return false;
	}
}

function validaAA()
{
	marcados = 0;
	for(i=0;i<document.frmExp.elements.length;i++)
	{	
		if(document.frmExp.elements[i].name.slice(0,10)=='chkRadsInc' && document.frmExp.elements[i].checked==1 )
		{
			marcados++;
        }
    }
	if(marcados>=1)
	{
	  return true;
	}
	else
	{
		alert("Debe marcar un elemento");
		return false;
	}
}

function verHistExpediente(numeroExpediente,codserie,tsub,tdoc,opcionExp) {
  var pagHist = window.open("<?=$ruta_raiz?>/expediente/verHistoricoExp.php?sessid=<?=session_id()?>&opcionExp="+opcionExp+"&numeroExpediente="+numeroExpediente+"&krd=<?=$krd?>","HistExp<?=$fechaH?>","scrollbars,fullscreen=");
}

function verBorrados() 
{ 
	if( document.getElementById("borrados"))
	{
	      borrado = document.getElementById("borrados");
	      descrip = document.getElementById("descBtn"); 
	      switch(borrado.style.display) {  
	         case "inline"   :  
	         case ""         :   borrado.style.display = "none";
	         					 descrip.innerHTML = "<br>Ver Borrados"; 
	                        
	                        break; 
	         case "none"      :    borrado.style.display = "";
	         					   descrip.innerHTML = "<br>Ocultar Borrados";
	                        break; 
	      }
	} 
}

function incluirDocumentosExp()
{
    var strRadSeleccionados = "";
    frm = document.frmRel;
    if( typeof frm.check_uno.length != "undefined" ) {
        for( i = 0; i < frm.check_uno.length; i++ ) {
            if( frm.check_uno[i].checked ) {
                if( strRadSeleccionados == "" ) {
                    coma = "";
                }
                else {
                    coma = ",";
                }
                strRadSeleccionados += coma + frm.check_uno[i].value;
            }
        }
    } else {
        if( frm.check_uno.checked ) {
            strRadSeleccionados = frm.check_uno.value;
        }
    }

    if( strRadSeleccionados != "" ) {
        	window.open( "<?=$ruta_raiz?>/expediente/incluirDocumentosExp.php?sessid=<?=session_id()?>&nurad=<?=$verrad?>&krd=<?=$krd?>&ind_ProcAnex=<?=$ind_ProcAnex?>&strRadSeleccionados="+strRadSeleccionados,"HistExp<?=$fechaH?>","height=300,width=600,scrollbars=yes" );
	} else {
		alert( "Debe seleccionar por lo menos un \n\r documento para archivar en el expediente." );
		return false;
	}
}

function modificarExp(numExpediente)
{
	var anchoPantalla = screen.availWidth;
  	var altoPantalla  = screen.availHeight; 
    window.open("<?=$ruta_raiz?>/expediente/modificarExpediente.php?sessid=<?=session_id()?>&numExpediente="+numExpediente+"&krd=<?=$krd?>&isEditMTD=1","modExp","height="+altoPantalla+",width="+anchoPantalla+",scrollbars=yes");
}
function noPermiso(tip)
{
    if(tip==0)
        alert ("No tiene permiso para acceder, su nivel es inferior al del usuario actual");
    if(tip==1)
        alert ("No tiene permiso para ver la imagen, el Radicado es confidencial");
}

function solcitarPretamo(exp)
{
	var anchoPantalla = 300;
  	var altoPantalla  = 300;
  	var x = (screen.availWidth/2)-150
  	var y = (screen.availHeight/2)-150
    window.open("<?=$ruta_raiz?>/expediente/prestamo/solicitar.php?sessid=<?=session_id()?>&expNum="+exp+"&krd=<?=$krd?>","modExp","top="+y+",left="+x+",height="+altoPantalla+",width="+anchoPantalla+",scrollbars=yes");
}
</script>
<table border="0" width="100%" class="borde_tab" align="center" class="titulos2">
<?if($rs_exp && $rs_exp->RecordCount()>0){?>
<tr class="titulos2">
    <td align="center" class="titulos2">
      <span class="titulos2" align="center">
        <b>ESTE DOCUMENTO SE ENCUENTRA INCLUIDO EN EL(LOS) SIGUIENTE(S) EXPEDIENTE(S).</b>
      </span>
    </td>
    <td align="center"><?=$selExpIncluidos?></td>
    <td align="center" nowrap>
	    <a href="#" onClick="insertarExpediente();" ><span class="leidos2"><b>ARCHIVAR EN</b></span></a>
	      <br><br>
	    <a href="#" onClick="excluirExpediente();" ><span class="leidos2"><b>EXCLUIR DE</b></span></a>
	      <br><br>
	    <?if($_SESSION['usuaPermExpediente']>=1){?><a href="#" onClick="verTipoExpediente()" ><span class="leidos"><b>CREAR EXPEDIENTE</b></span></a><?}?>
	</td>
</tr>
<?}else{?>
<tr>
    <td>
        <table class="borde_tab" align="center" border="0" width="98%">
        <tr class="titulos2">
            <td align="center" class="titulos2"><span class="leidos2" class="titulos2" align="center"><b>ESTE DOCUMENTO NO HA SIDO INCLUIDO EN NINGUN EXPEDIENTE.</b></span></td>
        </tr>
        </table>
        <table border="0" width="100%" class='borde_tab' align="center" cellspacing=1 >
        <tr >
          <td class="listado5" colspan="6">
                <a href="#" onClick="insertarExpediente();" ><span class="leidos"><b>ARCHIVAR EN</b></span></a> &nbsp;
                <?if($_SESSION['usuaPermExpediente']>=1){?><a href="#" onClick="verTipoExpediente()" ><span class="leidos"><b>CREAR EXPEDIENTE</b></span></a><?}?>
          </td>
        </tr>
        </table>
    </td>
</tr>
<?}?>
</table>
<div id='listaConsulta'>
</div>
