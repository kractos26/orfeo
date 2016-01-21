<?php
session_start();

$ruta_raiz = "."; 
if (!$_SESSION['dependencia'])
    header ("Location: $ruta_raiz/cerrar_session.php");

 foreach ($_GET as $key => $valor)  ${$key} = $valor;
 foreach ($_POST as $key => $valor) ${$key} = $valor;

 $krd         = $_SESSION["krd"];
 $dependencia = $_SESSION["dependencia"];
 $usua_doc    = $_SESSION["usua_doc"];
 $codusuario  = $_SESSION["codusuario"];

$ruta_raiz = "..";
$mensaje_error = false;
include_once "$ruta_raiz/js/funtionImage.php";
include_once "$ruta_raiz/include/db/ConnectionHandler.php";
if (!isset($db))	$db = new ConnectionHandler("$ruta_raiz");
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
require_once("$ruta_raiz/class_control/Dependencia.php");
$objDep = new Dependencia($db);
/*
* Generamos el encabezado que envia las variable a la paginas siguientes.
* Por problemas en las sesiones enviamos el usuario.
* @$encabezado  Incluye las variables que deben enviarse a la singuiente pagina.
* @$linkPagina  Link en caso de recarga de esta pagina.
*/
$encabezado = "".session_name()."=".session_id()."&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion";
$linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=";

/*  FILTRO DE DATOS
 */

if($checkValue)
{	$num = count($checkValue);
	reset($checkValue);
	$i = 0;
	$jglCounter = 0;
	$resultadoJGL = "";
	while (list($recordid,$tmp) = each($checkValue))
	{	$record_id = $recordid;
		switch ($codTx)
		{	case  7:
			case  8:
				{	if (strpos($record_id,'-'))
					{	//Si trae el informador concatena el informador con el radicado sino solo concatena los radicados.
						$tmp = explode('-',$record_id);
						if ($tmp[0])
						{	$whereFiltro .= ' (b.radi_nume_radi = '.$tmp[1].' and i.info_codi='.$tmp[0].') or';
							$tmp_arr_id=2;
						}
						else
						{	$whereFiltro .= ' b.radi_nume_radi = '.$tmp[1].' or';
							$tmp_arr_id=1;
						}

					}
					else
					{	$whereFiltro .= ' b.radi_nume_radi = '.$record_id.' or';
						$tmp_arr_id=0;
					}
					$record_id = $tmp[1];
				}break;
			case  9: 
			case 12:
                                 if($codTx == 12){
				            $isqlw="select b.RADI_USU_ANTE as RADI_USU_ANTE  from radicado  b, usuario u where b.radi_nume_radi = ".$record_id." AND b.RADI_USU_ANTE=u.USUA_LOGIN and  u.usua_esta='0'";
					    $UsuIn  = $db->query($isqlw);										 					
			    	            $usuInAct=$UsuIn->fields["RADI_USU_ANTE"];	
					if ($usuInAct != null)
		    			{
		    				 	$pasaFiltro2 = "No";
			    		        break;
			    		}else{
			    			 	$pasaFiltro2 = "Si";
		    				
		    			}
                                }
				
			case 13:
				{	
					$condicionAnexBorrados =  " and anex_borrado = 'N'";
					/*
				 	* Se crea condicion de obligatoriedad clasificacion TRD  and ($dependencia!=100 and $codusuario != 1)
				 	*/
					if ((($codTx == 9 or $codTx == 12)  and $codusuario != 1) or $codTx == 16 or $codTx == 13)
					{	include_once "$ruta_raiz/include/db/ConnectionHandler.php";
					    $db = new ConnectionHandler("$ruta_raiz");

					    include_once("../include/query/busqueda/busquedaPiloto1.php");
						/*
						* Condicion Radicado Padre
						*/
						$anoRad = substr($record_id,0,4);
						$isqlTRDP = "select $radi_nume_radi as RADI_NUME_RADI from SGD_RDF_RETDOCF r where r.RADI_NUME_RADI = '$record_id'";
						if($anoRad == "2005" or $anoRad == "2004" or $anoRad == "2012" or $anoRad == "2013") $pasaFiltro = "Si";
					 	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
						$rsTRDP = $db->conn->Execute($isqlTRDP);
						$radiNumero = $rsTRDP->fields["RADI_NUME_RADI"];

						if( !($anoRad == "2005" or $anoRad == "2004" or $anoRad == "2012" or $anoRad == "2013")  && strlen (trim($radiNumero)==0))
						{	$pasaFiltro = "No";
						   	$setFiltroSinTRD .= $record_id ;
						   	if($i<=($num))
							{  $setFiltroSinTRD .= ",";
							}
							break;
						}
						$pasaFiltro="Si";
					if($codTx == 12){
				            $isqlw="select b.RADI_USU_ANTE as RADI_USU_ANTE  from radicado  b, usuario u where b.radi_nume_radi = ".$record_id." AND b.RADI_USU_ANTE=u.USUA_LOGIN and  u.usua_esta=0";
					    $UsuIn  = $db->query($isqlw);										 					
			    	            $usuInAct=$UsuIn->fields["RADI_USU_ANTE"];	
					if ($usuInAct != null)
		    			{
		    				 	$pasaFiltro2 = "No";
			    		        break;
			    		}else{
			    			 	$pasaFiltro2 = "Si";
		    				
		    			}
					 //$pasaFiltro2 = "Si";
				 	}
					 $pasaFiltro = "Si";
					   /*
						* Condicion Anexos Radicados
						*/
					   $isqlTRDA = "select $radi_nume_salida as RADI_NUME_SALIDA from anexos
						where ANEX_RADI_NUME = '$record_id' and RADI_NUME_SALIDA != 0
						and RADI_NUME_SALIDA not in(select RADI_NUME_RADI from SGD_RDF_RETDOCF)";
					   
					   if($codTx == 12 || $codTx == 13 || $codTx ==9) {
				   			$isqlTRDA  .= $condicionAnexBorrados ;
					   }
						$rsTRDA = $db->conn->Execute($isqlTRDA);

						while($rsTRDA && !$rsTRDA->EOF && $pasaFiltro!="No")
						{	$radiNumero = $rsTRDA->fields["RADI_NUME_SALIDA"];
						 	$anoRadsal=substr($radiNumero,0,4);

					    	if ($radiNumero !='' && !($anoRadsal == "2005" or $anoRadsal == "2004" or $anoRadsal == "2003"))
					    	{	$pasaFiltro="No";
								$setFiltroSinTRD .= $record_id ;
								if($i<=($num))
								{
									$setFiltroSinTRD .= ",";
								}break;
							}
							$rsTRDA->MoveNext();
						}
						$i++;
					}
					$whereFiltro.= ' b.radi_nume_radi = '.$record_id.' or';
					 $pasaFiltro = "Si";


					/**
					 * Modificaciones Febrero de 2007, por SSPD para el DNP
					 * Archivar:
					 * Se verifica si el radicado se encuentra o no en un expediente,
					 * si es negativa la verificacion, ese radicado no se puede archivar
					 */
	
					if ( $codTx == 13 && $archivado_requiere_exp )
					{
												
					    include_once "$ruta_raiz/include/db/ConnectionHandler.php";
					    $db = new ConnectionHandler("$ruta_raiz");
				
					   $isqlExp = "select SGD_EXP_NUMERO as NumExpediente from SGD_EXP_EXPEDIENTE
						where RADI_NUME_RADI = '$record_id'";
						$rsExp = $db->conn->Execute($isqlExp);
						$resultadoJGL .= "CONSULTA: $isqlExp ";
						if ( $rsExp && !$rsExp->EOF )
						{
							$expNumero = $rsExp->fields[0];

					    	if ( $expNumero =='' || $expNumero == null )
					    	{
								$setFiltroSinEXP .= $record_id ;
								if($jglCounter<=($num))
								{
									$setFiltroSinEXP .= ",";
								}
								break;
							}

							$rsExp->MoveNext();
						}else {
							$setFiltroSinEXP .= $record_id ;
								if($jglCounter<=($num))
								{
									$setFiltroSinEXP .= ",";
								}
						}
						$jglCounter++;
					}
				}break;
			case 16:
			{
					/*
				 	* Se crea condicion de obligatoriedad clasificacion TRD
				 	*/
						include_once "$ruta_raiz/include/db/ConnectionHandler.php";
					    $db = new ConnectionHandler("$ruta_raiz");
					    include_once("../include/query/busqueda/busquedaPiloto1.php");
						/*
						* Condicion Radicado Padre
						*/
						$anoRad = substr($record_id,0,4);
						$isqlTRDP = "select $radi_nume_radi as RADI_NUME_RADI from SGD_RDF_RETDOCF r where r.RADI_NUME_RADI = '$record_id'";
						if($anoRad == "2005" or $anoRad == "2004" or $anoRad == "2003") $pasaFiltro = "Si";
					 	$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
						$rsTRDP = $db->conn->Execute($isqlTRDP);
						$radiNumero = $rsTRDP->fields["RADI_NUME_RADI"];

						if( !($anoRad == "2005" or $anoRad == "2004" or $anoRad == "2003")  && strlen (trim($radiNumero)==0))
						{	$pasaFiltro = "No";
						   	$setFiltroSinTRD .= $record_id ;
						   	if($i<=($num))
							{  $setFiltroSinTRD .= ",";
							}
							break;
						}
					$pasaFiltro = "Si";	
						
					   /*
						* Condicion Anexos Radicados
						*/
					   $isqlTRDA = "select $radi_nume_salida as RADI_NUME_SALIDA from anexos
						where ANEX_RADI_NUME = '$record_id' and RADI_NUME_SALIDA != 0
						and RADI_NUME_SALIDA not in(select RADI_NUME_RADI from SGD_RDF_RETDOCF)";
					   					$condicionAnexBorrados =  " and anex_borrado = 'N'";

					   $isqlTRDA  .= $condicionAnexBorrados ;
					   
						$rsTRDA = $db->conn->Execute($isqlTRDA);

						while($rsTRDA && !$rsTRDA->EOF && $pasaFiltro!="No")
						{	$radiNumero = $rsTRDA->fields["RADI_NUME_SALIDA"];
						 	$anoRadsal=substr($radiNumero,0,4);

					    	if ($radiNumero !='' && !($anoRadsal == "2005" or $anoRadsal == "2004" or $anoRadsal == "2003"))
					    	{	$pasaFiltro="No";
								$setFiltroSinTRD .= $record_id ;
								if($i<=($num))
								{
									$setFiltroSinTRD .= ",";
								}break;
							}
							$rsTRDA->MoveNext();
						}
						$i++;
					
					$whereFiltro.= ' b.radi_nume_radi = '.$record_id.' or';
 $pasaFiltro = "Si";

					/**
					 * Modificaciones Febrero de 2007, por SSPD para el DNP
					 * Archivar:
					 * Se verifica si el radicado se encuentra o no en un expediente,
					 * si es negativa la verificacion, ese radicado no se puede archivar
					 */
					//echo $codTx;&& $archivado_requiere_exp
					
												
					    include_once "$ruta_raiz/include/db/ConnectionHandler.php";
					    $db = new ConnectionHandler("$ruta_raiz");

					   $isqlExp = "select SGD_EXP_NUMERO as NumExpediente from SGD_EXP_EXPEDIENTE
						where RADI_NUME_RADI = '$record_id'";
						$rsExp = $db->conn->Execute($isqlExp);
						$resultadoJGL .= "CONSULTA: $isqlExp ";
						if ( $rsExp && !$rsExp->EOF )
						{
							$expNumero = $rsExp->fields[0];

					    	if ( $expNumero =='' || $expNumero == null )
					    	{
								$setFiltroSinEXP .= $record_id ;
								if($jglCounter<=($num))
								{
									$setFiltroSinEXP .= ",";
								}
								break;
							}

							$rsExp->MoveNext();
						}else {
							$setFiltroSinEXP .= $record_id ;
								if($jglCounter<=($num))
								{
									$setFiltroSinEXP .= ",";
								}
						}
						$jglCounter++;
					
			
				}break;			
			default:
				{
					$whereFiltro.= ' b.radi_nume_radi = '.$record_id.' or';
				}break;
		}

		$setFiltroSelect .= "$record_id,";
	}
 //$pasaFiltro = "Si";
	if($setFiltroSinTRD and $pasaFiltro=="No")
	{
	//Modificado idrd para aplicar trd
		$mensaje_error = "NO SE PERMITE ESTA OPERACION PARA LOS RADICADOS <BR> < $setFiltroSinTRD > <BR> FALTA CLASIFICACION TRD PARA ESTOS O PARA SUS ANEXOS <BR> FAVOR APLICAR TRD";
	}
//Se agrega condicional para no de volver al usuario inactivo 
	if ($pasaFiltro2 == "No") {
		$mensaje_error = "NO SE PERMITE ESTA OPERACION El USUARIO <BR> < $usuInAct > <BR> SE ENCUENTRA INACTIVO  ";
	}
	/**
	 * Modificaciones Febrero de 2007, por SSPD para el DNP
	 * Archivar:
	 * si la variable $setFiltroSinEXP tiene algo, es porque algun radicado no esta en expediente
	 */
	if ( $setFiltroSinEXP ) {
			$mensaje_errorEXP = "<br>NO SE PERMITE ESTA OPERACION PARA LOS RADICADOS <BR> < $setFiltroSinEXP > <BR> PORQUE NO SE ENCUENTRAN EN NING&Uacute;N EXPEDIENTE";
	}

	if(substr($whereFiltro,-2)=="or")
	{	$whereFiltro = substr($whereFiltro,0,strlen($whereFiltro)-2);
	}
	if(trim($whereFiltro))
	{	$whereFiltro = "and ( $whereFiltro ) ";
	}

  $radicadosTx .= $record_id.",";
}
else
{	$mensaje_error="NO HAY REGISTROS SELECCIONADOS";
}
?>
<html>
<head>
<title>Enviar Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="<?=$ruta_raiz; ?>/estilos/orfeo.css">
<!-- Cargando los temas para el calendario Java -->
<link rel="stylesheet" href="../include/zpcal/themes/fancyblue.css" />

<!-- cargando los Javascripts para el calendario -->
<script type="text/javascript" src="../include/zpcal/src/utils.js"></script>
<script type="text/javascript" src="../include/zpcal/src/calendar.js"></script>
<script type="text/javascript" src="../include/zpcal/src/calendar-setup.js"></script>

<!-- Cargando los archivos de definicion -->
<script type="text/javascript" src="../include/zpcal/lang/calendar-sp.js"></script>

<!-- Cargando archivos para trabajo con ajax -->
<script type='text/javascript' src="../include/ajax/usuarios/usuariosServer.php?client=all"></script>
<script type='text/javascript' src="../include/ajax/usuarios/usuariosServer.php?stub=usuarios"></script>
<script type='text/javascript' src="../include/ajax/radicacion/radicacionServer.php?client=all"></script>
<script type='text/javascript' src="../include/ajax/radicacion/radicacionServer.php?stub=radicacionAjax"></script>
<script type='text/javascript'>
// Objeto de HTML_AJAX pear para Traer usuarios
  var remote = new usuarios({}); // pass in an empty hash so were in async mode
  var remoteRad = new radicacionAjax({});
</script>   

<script>
function notSupported()
{ alert('Su browser no soporta las funciones Javascript de esta pagina.'); }

function setSel(start,end)
{	document.realizarTx.observa.focus();
	var t=document.realizarTx.observa;
	if(t.setSelectionRange)
	{	t.setSelectionRange(start,end);
    	t.focus();
  		//f.t.value = t.value.substr(t.selectionStart,t.selectionEnd-t.selectionStart);
  	}
  	else notSupported();
}

function valMaxChars(maxchars)
{	document.realizarTx.observa.focus();
 	if(document.realizarTx.observa.value.length > maxchars)
 	{	/*  alert('Demasiados caracteres en el texto ! Por favor borre '+
    	(document.realizarTx.observa.value.length - maxchars)+ ' caracteres pues solo se permiten '+ maxchars);*/
 		alert('Demasiados caracteres en el texto, solo se permiten '+ maxchars);
 		setSel(maxchars,document.realizarTx.observa.value.length);
   	return false;
 	}
 	else	return true;
}

/*
 * OPERACIONES EN JAVASCRIPT
 * @marcados Esta variable almacena el numeo de chaeck seleccionados.
 * @document.realizarTx  Este subNombre de variable me indica el formulario principal del listado generado.
 * @tipoAnulacion Define si es una solicitud de anulacion  o la Anulacion Final del Radicado.
 *
 * Funciones o Metodos EN JAVA SCRIPT
 * Anular()  Anula o solicita esta dependiendo del tipo de anulacin.  Previamente verifica que este seleccionado algun  radicado.
 * markAll() Marca o desmarca los check de la pagina.
 *
 */

function Anular(tipoAnulacion)
{
	marcados = 0;
	for(i=0;i<document.realizarTx.elements.length;i++)
	{	if(document.realizarTx.elements[i].checked==1 )
		{
			marcados++;
		}	
	}
	<?
	if($codusuario==1 || $usuario_reasignacion==1)
	{
	?>
		if(document.realizarTx){
			if(document.realizarTx.chkNivel.checked==1)	 marcados = marcados -1 ;
		}
	<?
	}	
    ?>
	if(marcados>=1)
	{
	  return 1;
	}
	else
	{
		alert("Debe marcar un elemento");
		return 0;
	}
}

function markAll(noRad)
{
	if(document.realizarTx.elements.checkAll.checked || noRad >=1)
	{
		for(i=7;i<document.realizarTx.elements.length;i++)
		{
			document.realizarTx.elements[i].checked=1;
		}
	}
	else
	{
		for(i=3;i<document.realizarTx.elements.length;i++)
		{
			document.realizarTx.elements[i].checked=0;
		}
	}
}

function okTx()
{
	valCheck = Anular(0);
	
	if(valCheck==0) return 0;
	numCaracteres = document.realizarTx.observa.value.length;	
	if(numCaracteres>=6)
	{	//alert(document.realizarTx.usCodSelect.options.selected);
		if (valMaxChars(550))
			document.realizarTx.submit();
	}else
	{
		alert("Atencion:  Falta la observacion, el numero de caracteres minimo es de 6 letras, (Digito :"+numCaracteres+")");
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head>
<body bgcolor="#FFFFFF" topmargin="0" >


<?php
	/**
	 * Modificaciones Febrero de 2007, por SSPD para el DNP
	 * Archivar:
	 * Hay algun error, ya sea por tipificacion o por Expediente, luego se muestra mensaje
	 * donde se indica que no se puede archivar el(los) radicado(s)
	 */
if ($mensaje_errorEXP || $mensaje_error )
{
	die ("<center><table class='borde_tab' width=100% CELSPACING=5><tr class=titulosError><td align='center'>$mensaje_errorEXP <br> $mensaje_error</td></tr></table></CENTER>");
}
else
{
?>
<table border=0 width=100% cellpadding="0" cellspacing="0">
<tr>
	<td width=100%>
	<br>
	<form action='realizarTx.php?<?=$encabezado?>' method='POST'  name="realizarTx" >
	<input type='hidden' name=depsel8 value="<?=implode($depsel8,',')?>">
	<input type='hidden' name=codTx value='<?=$codTx?>'>
	<input type='hidden' name=EnviaraV value='<?=$EnviaraV?>'>
	<input type='hidden' name=fechaAgenda value='<?=$fechaAgenda?>'>
	<table width="98%" border="0" cellpadding="0" cellspacing="5" class="borde_tab">
	<TR>
				<TD width=30% class="titulos4">USUARIO:<br><br><?=$_SESSION['usua_nomb']?> </TD>
				<TD width='30%' class="titulos4">DEPENDENCIA:<br><br><?=$_SESSION['depe_nomb']?><br></TD>
				<td class="titulos4">
<?
switch ($codTx)
{	case 7:
		{	print "Borrar Informados ";
			echo "<input type='hidden' name='info_doc' value='".$tmp_arr_id."'>";
		}break;
	case 8:	$usDefault = 1;
			//$cad = $db->conn->Concat("RTRIM(u.depe_codi)","'-'","RTRIM(u.usua_codi)");
			//$cad2 = $db->conn->Concat($db->conn->IfNull("d.DEP_SIGLA", "'N.N.'"),"'-'","RTRIM(u.usua_nomb)");
			$cad = $db->conn->Concat("CAST(u.depe_codi as char(10))","'-'","cast(u.usua_codi as char(10))");
			$cad2 = $db->conn->Concat($db->conn->IfNull("d.DEP_SIGLA", "'N.N.'"),"'-'","RTRIM(u.usua_nomb)");
			$sql = "select $cad2 as usua_nomb, $cad as usua_codi from usuario u,dependencia d where u.depe_codi in(".implode($depsel8,',').")
					$whereReasignar and u.USUA_ESTA='1' and u.depe_codi = d.depe_codi ORDER BY usua_nomb";
	

			$rs = $db->conn->Execute($sql);
			$usuario = $codUsuario;
			print "Informados";
			print $rs->GetMenu2('usCodSelect[]',$usDefault,false,true,10," id='usCodSelect' class='select' ");
			break;
	case 9:	$whereDep = "and u.depe_codi=$depsel ";
		if($dependencia==$depsel)
		{	$usDefault = $codusuario;	}
		// Esta seccion selecciona las dependencias que se deben visualizar a partir de otras
		$sql = "SELECT DEPENDENCIA_OBSERVA, DEPENDENCIA_VISIBLE FROM DEPENDENCIA_VISIBILIDAD WHERE DEPENDENCIA_OBSERVA=$dependencia and DEPENDENCIA_VISIBLE = " . $depsel;
			//$sql = "SELECT DEPENDENCIA_VISIBLE FROM DEPENDENCIA_VISIBILIDAD WHERE DEPENDENCIA_OBSERVA = " . $depsel;
			$rs1 = $db->conn->Execute($sql);
			$usuario_publico = "";
			if (!$rs1->EOF)
			{	//Se adicionan las dependencias que puedan ver a otras en la consulta
				$usuario_publico = "or (u.DEPE_CODI in (";
				while(!$rs1->EOF)
				{	$usuario_publico = $usuario_publico .$rs1->fields["DEPENDENCIA_VISIBLE"].",";
					$rs1->MoveNext();
				}
				$usuario_publico = substr($usuario_publico , 0, strlen($usuario_publico) - 1). ") AND USUA_ESTA='1') AND u.USUARIO_PUBLICO = 1 ";
			}
			//Fin Modificacion
			//
			if((($codusuario==1 || $usuario_reasignacion==1)&& $dependencia!=$depsel ) || ($dependencia==$depsel && ($codusuario!=1 || $usuario_reasignacion !=1)&& $EnviaraV=="VoBo"))
			{	$whereReasignar = " and u.usua_codi=1";
				$usDefault = 1;
			}

			if(($codusuario==1 || $usuario_reasignacion == 1)&& $dependencia==$depsel && $EnviaraV=="VoBo" )
			{	if ($objDep->Dependencia_codigo($dependencia))
				{	$depPadre=$objDep->getDepe_codi_padre(); 
				}
				print ("La dependencia  padre ...($depPadre)");

				$whereDep =  " and u.depe_codi=$depPadre  and u.usua_codi=1 ";
				$depsel=$depPadre;
			}

			if($EnviaraV=="VoBo")
			{	$proccarp = "Visto Bueno";
				$usuario_publico = "";
			}
				$cad = $db->conn->Concat("cast(depe_codi as char(10))","'-'","cast(u.usua_codi as char(10))");
				$sql = "select
						u.USUA_NOMB
						, $cad as USUA_COD
						,u.DEPE_CODI
				,u.USUA_CODI
						from usuario u
						where
						u.USUA_ESTA='1'
						$whereReasignar
						and u.depe_codi=$dependencia
						$usuario_publico
						ORDER BY USUA_NOMB";
				$rs = $db->conn->Execute($sql);
                                
				$usuario = $codUsuario;
				//print $rs->GetMenu2('usCodSelect',$usDefault,false,false,0," id ='usCodSelect' class='select' ");
				?>				
				<select name=usCodSelect class=select>
					<option value="-1">-- Seleccione un funcionario --</option>
				<?
				while(!$rs->EOF)
				{

					$depCodiP = $rs->fields["DEPE_CODI"];
					$usuNombP = $rs->fields["USUA_NOMB"];
					$usuCodiP = $rs->fields["USUA_COD"];
					$usuCodi = $rs->fields["USUA_CODI"];

					$valOptionP = "";
					$valOptionP =$usuNombP;
					$class = "";
					if($usuCodi==1) 
						{
						$defaultUs = "selected"; 
						
					}else {$defaultUs = "";}
					if($depCodiP!=$dependencia)
						{
							$sql = "select DEPE_NOMB from dependencia where depe_codi=$depCodiP";
							$rs2 = $db->conn->Execute($sql);
							$depNombP = $rs2->fields["DEPE_NOMB"];
							$valOptionP .= " [ ".$depNombP."] ";
							

							$class = " class='leidos'";
						}

				?>
				<option <?=$class?>  value='<?=$usuCodiP?>' <?=$defaultUs?>><?=$valOptionP?></option>
				<?
				$rs->MoveNext();
				}
				?>
				</select>
				<?
				print "Reasignar $proccarp";
				break;
	case 10:
			   $carpetaTipo = substr($carpSel,1,1);
			   $carpetaCodigo = intval(substr($carpSel,-3));
			   if($carpetaTipo==1)
			   {
			   	  $sql = "select NOMB_CARP as carp_desc from CARPETA_PER
					   where
					     codi_carp=$carpetaCodigo
						 and usua_codi=$codusuario
						 and depe_codi=$dependencia";
				}
				else
				{
				   $sql = "select carp_desc from carpeta where carp_codi=$carpetaCodigo";
				}
				$rs = $db->conn->Execute($sql); # Ejecuta la busqueda y obtiene el recordset vacio
				$carpetaNombre = $rs->fields['carp_desc'];
				print "Movimiento a Carpeta <b>$carpetaNombre</b>
				<input type=hidden name='carpetaCodigo' value=$carpetaCodigo>
				<input type=hidden name='carpetaTipo' value=$carpetaTipo>
				<input type=hidden name='carpetaNombre' value=$carpetaNombre>
				";
			   break;
		   case 12:
				print "Devolver documentos a Usuario Anterior ";
				break;
		   case 13:
		   	    print "Archivo de Documentos";
				break;
			/*case 16:
		   	    print "Archivo de NRR";
				break;*/
		}
		?>
		<BR>
		</td>
		<td width='5' class="grisCCCCCC">
			<input type=button value=REALIZAR 
			onClick="<?php if($codTx==8){ ?> if(document.getElementById('usCodSelect').value==''){ alert('Debe seleccionar al menos un funcionario.'); return false;  }<?php } ?> <?php if ($codTx==9) { ?>
		if(document.realizarTx.usCodSelect.value=='-1')
		{	
			alert('Debe seleccionar un funcionario.');
			return false;
		}
	<?php } ?> okTx();" name=enviardoc align=bottom class=botones id=REALIZAR>
		</td>
	</TR>
	<tr align="center">
	<td colspan="4" class="celdaGris" align=center>
	<?
         if($codTx==8 && $varTramiteConjunto==1){
        ?>
        <input type=checkbox name=chkConjunto Value="Si">
        <span class="info">Tramite Conjunto  </span> 
        <?
	}
		if((($codusuario==1) || ($usuario_reasignacion == 1)) && $codTx!=13)
		{						
		?>		
        <input type=checkbox name=chkNivel checked class=ebutton>
		<span class="info">El documento tomara el nivel del usuario destino.</span>
			<?
		}elseif($codTx==13){
			?>
			<input type="hidden" name="usCodSelect">
			<input type="hidden" name=chkNivel>
			<span class="info">El documento conservar&aacute; el nivel del usuario que archiva.</span><br>
			<?php 
		}
		?>
		<center>
		<table width="900"  border=0 align="center" bgcolor="White">
		<TR bgcolor="White"><TD width="100">
				<center>
				<img src="<?=$ruta_raiz?>/iconos/tuxTx.gif" alt="Tux Transaccion" title="Tux Transaccion">
				</center>
		</td><TD align="left">
        <span class="etextomenu">
        </span>
		        <textarea name=observa id=observa cols=80 rows=5  class=ecajasfecha></textarea>
			</TD></TR>
		</center>
		<input type=hidden name=enviar value=enviarsi>
		<input type=hidden name=enviara value='9'>
		<input type=hidden name=carpeta value=12>
		<input type=hidden name=carpper value=10001>
	</td>
	</tr>
	
        <?php
        if ($codTx=="9")
        {
            $scriptCargarUsuarios = " onClick=".'"'."remote.getUsuarios('usuariosInformar',document.getElementById('coddepeinf').value,0)".'";';
            ?>
	    <tr bgcolor=white>
            <td class="titulos2" bgcolor="white" colspan=4>
            <? if($varTramiteConjunto==1){  ?>
	     <input type=checkbox name=chkConjunto Value="Si" id="chkConjunto" >
             <span class="info">Tramite Conjunto  </span><br> 
	    <? }else{    ?>
		<input type=checkbox name=chkConjunto id="chkConjunto" disabled >


	     <? }  ?>
	    </td>
	    </tr>
            <tr bgcolor=white>
            <td class="titulos2" bgcolor="white"><font face="Verdana" size="1"><b>
            Informar   A:</td><td class=listado2>
                <?php
	$query ="SELECT DEPE_NOMB, DEPE_CODI
            from DEPENDENCIA
            where depe_estado=1
            ORDER BY 1";
	$rs=$db->conn->Execute($query);
	$varQuery = $query;
	print $rs->GetMenu2("coddepeinf", $coddepeinf, false, true,5," $scriptCargarUsuarios class='select' id='coddepeinf'");
	$observaInf = "document.getElementById('observa').value";
        ?>
            </td>	
        <td align=center class=titulos2>
				<INPUT TYPE='radio' name='accionIR' checked id='accionInformar' value='InformarOtrosD'>
        Seleccione los Usuarios<br>
	 <select name="usuariosInformar" id="usuariosInformar" size="5" width=450
    onclick="remote.informarUsuario('usuariosInformados','<?=$radicadosTx?>','<?=$krd?>','<?=$dependencia?>','<?=$codusuario ?>',document.getElementById('coddepeinf').value,document.getElementById('usuariosInformar').value,<?=$observaInf?> , document.getElementById('accionInformar').checked, 0,  document.getElementById('chkConjunto').checked,'<?=$usua_doc?>') ; " 
    class="select" align="LEFT" >
   </select>

	</td>	
        </tr>
            <tr bgcolor=white>
            <td class="ecajasfecha" bgcolor="white"><font face="Verdana" size="1"><b>
            Agendar </b></font></td><td class="ecajasfecha">
            <input type="text" id="calendar" name="fechaAgenda"/>
            <button id="trigger"><img src="../include/zpcal/calendar2.ico" width="25" height="25"></button>
            <script type="text/javascript">//<![CDATA[
            Zapatec.Calendar.setup({
                firstDay          : 1,
                weekNumbers       : true,
                showOthers        : false,
                showsTime         : false,
                timeFormat        : "24",
                step              : 2,
                range             : [1900.01, 2999.12],
                electric          : false,
                singleClick       : true,
                inputField        : "calendar",
                button            : "trigger",
                ifFormat          : "%Y-%m-%d",
                daFormat          : "%Y/%m/%d",
                align             : "Br"
            });
            //]]></script>
        <noscript>
        <br/>
        Este sitio usa un calendario java </a>, pero su navegador no soporta java. 
        <br/>
        Instale o actualice Java en su equipo.
        </noscript>
            </td>
            </tr>
            <?php
        }
        ?>
            <tr><td colspan=6>
        <div id="usuariosInformados">
        </div>
                </td></tr>
</TABLE>
	<br>
		<?
	/*  GENERACION LISTADO DE RADICADOS
	 *  Aqui utilizamos la clase adodb para generar el listado de los radicados
	 *  Esta clase cuenta con una adaptacion a las clases utiilzadas de orfeo.
	 *  el archivo original es adodb-pager.inc.php la modificada es adodb-paginacion.inc.php
	 */
	error_reporting(0);
	if(!$orderNo)  $orderNo=0;
	$order = $orderNo + 1;

	$sqlFecha = $db->conn->SQLDate("d-m-Y H:i A","b.RADI_FECH_RADI");
	include_once "../include/query/tx/queryFormEnvio.php";
	switch ($codTx)
	{	case 12:
			{	$isql = str_replace("Enviado Por" ,"Devolver a",$isql);
			}break;
		default:break;
	}
	$pager = new ADODB_Pager($db,$isql,'adodb', true,$orderNo,$orderTipo);
	$pager->toRefLinks = $linkPagina;
	$pager->toRefVars = $encabezado;
	$pager->checkAll = true;
	$pager->checkTitulo = true;
	$pager->Render($rows_per_page=50,$linkPagina,$checkbox=chkAnulados);
?>
<input type='hidden' name=depsel value='<?=$depsel?>'>
</form>
<?
}
?>
</body>
</html>

