<?
session_start();
require_once("$ruta_raiz/include/db/ConnectionHandler.php");

if (!$db)	$db = new ConnectionHandler($ruta_raiz);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);

if(!isset($_SESSION['dependencia'])) include "$ruta_raiz/rec_session.php";
 
include_once("$ruta_raiz/include/combos.php");
 
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
$db->conn->debug = false; 
?>
<script>
function abrirSancionados()
{	//alert ("Se selecciona " +  document.form_decision.decis.value);
decision = document.form_decision.decis.value;
swAbreSanciona=0;
	<?
	$sql =  "select * from SGD_TDEC_TIPODECISION where SGD_APLI_CODI=1 and SGD_TDEC_SANCIONAR=1 ";
	$rs=$db->query($sql);
	while  ($rs && !$rs->EOF )
	{	print (" if  (decision == ".$rs->fields['SGD_TDEC_CODIGO'].") ");
		print ("swAbreSanciona = 1;");
		$rs->MoveNext();
	}
	?>
urlSancRegist="<?=$lksancionados?>&usuario=<?=$krd.'&nsesion='.trim(session_id())?>&nro=<?=$verradicado?><?=$datos_envio?>&ruta_raiz=.";
if (swAbreSanciona==1)	window.open(urlSancRegist,"Sancionados",'top=0,height=580,width=850,scrollbars=yes');
document.form_decision.submit();
}
</script>

<form name=form_decision  method='post' action='decision/decision_registro.php?<?=session_name()?>=<?=trim(session_id())?>&krd=<?=$krd?>&verrad=<?=$verradicado?>'>
<table border=0 width 100% cellpadding="0" cellspacing="5" class="borde_tab">
<tr>
	<td  class="titulos2" >Sancionados</td>
	<td width="323" >
		<select name="decis" class="select">
		<?php
		// Arma la lista desplegable con los tipos de documento a anexar
		//$db->conn->debug=true;
		$a = new combo($db);
		if (!strlen(trim ($sgd_tdes_codigo)))	$sgd_tdes_codigo = "null";
		$s =  "select * from SGD_TDEC_TIPODECISION where SGD_APLI_CODI=1 and (SGD_TDEC_SHOWMENU=1 or SGD_TDEC_CODIGO = $sgd_tdes_codigo)";
		// print($s);
		$r = "SGD_TDEC_CODIGO"; 
		$t = "SGD_TDEC_DESCRIP";
		$v = $sgd_tdes_codigo;
		$sim = 0; 
		$a->conectar($s,$r,$t,$v,$sim,$sim);
		?>
        </select>
	</td>
</tr>
<tr>
	<td bgcolor='#cccccc' colspan="2">
		<input type=button  name=grabar_decision value='Grabar Cambio' class='botones' onclick="abrirSancionados()">
	</td>
</tr>
</table>
</form>