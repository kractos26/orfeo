<?php 
error_reporting( 7 ); 
$krdold = $krd;
session_start(); 
$ruta_raiz = ".."; 

if (!isset($_SESSION['dependencia']))	include "$ruta_raiz/rec_session.php";
error_reporting( 7 );

include_once( "$ruta_raiz/include/db/ConnectionHandler.php" );
$db = new ConnectionHandler( "$ruta_raiz" );
include_once( "$ruta_raiz/include/tx/Historico.php" );
include_once( "$ruta_raiz/include/tx/Expediente.php" );

$expediente = new Expediente( $db );
$radicadosrecibidos == '' ? $radicadosrecibidos = $_GET['radicados'] : $radicadosrecibidos = $radicadosrecibidos;

$arryradicado = split(",", $radicadosrecibidos);

$encabezado = "$PHP_SELF?".session_name()."=".session_id()."&opcionExp=$opcionExp&numeroExpediente=$numeroExpediente&radicadosrecibidos=$radicadosrecibidos&dependencia=$dependencia&krd=$krd&nurad=$nurad&coddepe=$coddepe&codusua=$codusua&depende=$depende&ent=$ent&tdoc=$tdoc&codiTRDModi=$codiTRDModi&codiTRDEli=$codiTRDEli&codserie=$codserie&tsub=$tsub&ind_ProcAnex=$ind_ProcAnex";
$band=0;

if( $funExpediente == "INSERT_EXP" )
{
	$expediente->getExpediente($_POST['numeroExpediente']);
	
	if($expediente->estado==0)
   	{
   		$msg = '<center><b><font color="red">Resultado inclusi&oacute;n de radicados.</font></b></center>';
   		$arraymsg = array();
   		foreach ($arryradicado as $key => $value){
   		  
   		  $arrExpedientes = $expediente->expedientesRadicado( $value );
   		  
   		  if(in_array($_POST['numeroExpediente'],$arrExpedientes)){
   		  	$arraymsg [$key] = '<b><font color="red">El radicado ya est&aacute; incluido en el expediente</font></b>';
   		  	$band=1;
   		  }else{
   		  	
   		  	$resultadoExp = $expediente->insertar_expediente( $_POST['numeroExpediente'], $value, $dependencia, $codusuario, $usua_doc );
   		  	
   		  	if( $resultadoExp == 1 )
		    {
		    	$arraymsg [$key] = '<b><font  color="green">Se incluyo correctamente el radicado</font></b>';
		    	
		    	$observa = "Archivar radicado en Expediente";
		         include_once "$ruta_raiz/include/tx/Historico.php";
		         $radicados[] = $value;
		         $tipoTx = 53;
		         $Historico = new Historico( $db );
		         $Historico->insertarHistoricoExp( $_POST['numeroExpediente'], $radicados, $dependencia, $codusuario, $observa, $tipoTx, 0 );
		         $band=1;
		    }else{
		    	$arraymsg [$key] = '<b><font  color="red">Hubo un error al incluir este radicado, verifiquelo e intente de nuevo</font></b>';
		    	$band=1;
		    }   		  	
   		  }
   		
   		}
   	}else{
   		$msg= '<center><b><font color="red">No se pueden incluir m&aacute;s Radicados al Expediente No.'.$_POST['numeroExpediente'].', este ya se encuentra cerrado</font></b></center>';
	    $band=1;
   	}
	
}
?>
<html>
<head>
<title>Archivar en Expediente</title>
<link href="../estilos/orfeo.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function validarNumExpediente()
{
    numExpediente = document.getElementById( 'numeroExpediente' ).value;
	
    // Valida que se haya digitado el nombre del expediente
    // a�o dependencia serie subserie consecutivo E
    if( numExpediente.length != 0 && numExpediente != "" )
    {
        insertarExpedienteVal = true;
    }
    else if( numExpediente.length == 0 || numExpediente == "" )
    {
        alert( "Error. Debe especificar el nombre de un expediente." );
        document.getElementById( 'numeroExpediente' ).focus();
        insertarExpedienteVal = false;
    }
    
    if( insertarExpedienteVal == true )
	{
        document.insExp.submit();
	}
}

function confirmaIncluir()
{
    document.getElementById( 'funExpediente' ).value = "INSERT_EXP";
    document.insExp.submit();
}

function start(URL, WIDTH, HEIGHT)
{
 windowprops = "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=1020,height=500";
 preview = window.open(URL , "preview", windowprops);
}
</script>
</head>
<body bgcolor="#FFFFFF" onLoad="document.insExp.numeroExpediente.focus();">
<form method="post" action="<?php print $encabezado; ?>" name="insExp">
<input type="hidden" name='funExpediente' id='funExpediente' value="" >
<input type="hidden" name='confirmaIncluirExp' id='confirmaIncluirExp' value="" >
<input type="hidden" name='radicadosrecibidos' id='radicadosrecibidos' value="<?php echo $radicadosrecibidos; ?>" >
  <table border=0 width=100% align="center" class="borde_tab" cellspacing="1" cellpadding="0">        
    <tr align="center" class="titulos2">
      <td height="15" class="titulos2" colspan="2">ARCHIVAR EN  EL EXPEDIENTE</td>
    </tr>
  </table>
<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="borde_tab">

</table>
<table border=0 width=100% align="center" class="borde_tab">
      <tr align="center">
      <td class="titulos5" align="left" nowrap>N&uacute;mero del Expediente </td>
      <td class="titulos5" align="left">
        <input type="text" name="numeroExpediente" id="numeroExpediente" value="<?php print $_POST['numeroExpediente']; ?>" size="30">
        &nbsp;<input name="Button" value="BUSCAR" class="botones" onclick="start('../busqueda/busquedaExp.php?<?=session_name()."=".session_id()."&krd=$krd&insertaExp=1"?>',1024,500);" type="button">
      </td>
    </tr>
</table>
<table border=0 align="center" width="100%" class="borde_tab">
	<tr align="center">

	<td class="listado2" align="center">
	<center>
	  <input name="btnIncluirExp" type="button" class="botones_funcion" id="btnIncluirExp" onClick="validarNumExpediente();" value="Archivar en Exp">
		</center></td>
	<td  class="listado2"><center><input name="btnCerrar" type="button" class="botones_funcion" id="btnCerrar" onClick="opener.location.reload(); window.close();" value=" Cerrar "></center></td>
	</tr>
</table>
<?
// Consulta si existe o no el expediente.
if ( $expediente->existeExpediente( $_POST['numeroExpediente'] ) !== 0 and $band==0 )
{
?>
<table border=0 width=100% align="center" class="borde_tab">
  <tr align="center">
    <td width="33%" height="25" class="listado2" align="center">
      <center class="titulosError2">
        ESTA SEGURO DE ARCHIVAR ESTOS RADICADOS EN EL EXPEDIENTE: 
      </center>
      <B>
        <center class="style1"><b><?php print $numeroExpediente; ?></b></center>
      </B>
      <div align="justify"><br>
        <strong><b>Recuerde:</b>No podr&aacute; modificar el numero de expediente si hay
        un error en el expediente, m&aacute;s adelante tendr&aacute; que excluir este radicado del
        expediente y si es el caso solicitar la anulaci&oacute;n del mismo. Adem&aacute;s debe
        tener en cuenta que tan pronto coloca un nombre de expediente, en Archivo crean
        una carpeta f&iacute;sica en el cual empezaran a archivar los documentos
        pertenecientes al mismo.
        </strong>
      </div>
    </td>
  </tr>
</table>
<table border=0 width=100% align="center" class="borde_tab">
  <tr align="center">
    <td class="listado2" align="center">
	  <center>
	    <input name="btnConfirmar" type="button" onClick="confirmaIncluir();" class="botones_funcion" value="Confirmar">
	  </center>
    </td>
	<td width="33%" class="listado2" height="25">
	<center><input name="cerrar" type="button" class="botones_funcion" id="envia22" onClick="opener.regresar(); window.close();" value=" Cerrar "></center></TD>
	</tr>
</table>
<?	
}
else if ( $_POST['numeroExpediente'] != "" && ( $expediente->existeExpediente( $_POST['numeroExpediente'] ) === 0 ) )
{
    ?>
    <script language="JavaScript">
      alert( "Error. El nombre del Expediente en el que desea archivar este radicado \n\r no existe en el sistema. Por favor verifique e intente de nuevo." );
      document.getElementById( 'numeroExpediente' ).focus();
    </script>
    <?php
}
else{
?>
<table border=0 width=100% align="center" class="borde_tab">
  <tr align="center">
    <td width="33%" height="25" class="listado2" align="center">
      <?=$msg?>
    </td>
  </tr>
</table>
<?}?>
<br>
<br>
<table border=0 width=80% align="center" class="borde_tab" cellspacing="1" cellpadding="0">        
    <tr align="center" class="titulos2">
      <td height="15" class="titulos2">RADICADOS A INCLUIR</td>
    </tr>
    <?php 
       foreach($arryradicado as $clave => $valor){
    ?>
    <tr>
    <td class="listado2">
    <?php echo "".$valor.": ".$arraymsg[$clave];?>
    </td>
    </tr>
    <?php 
       }
    ?>
  </table>
</form>
</body>
</html>