<? 
session_start();
$ruta_raiz = "..";
include("$ruta_raiz/config.php"); 			// incluir configuracion.
include_once "$ruta_raiz/include/tx/Historico.php";
include "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler("$ruta_raiz");

if($db)
{	//$db->conn->debug=true;
	if(isset($exps))
	{
            $objHistorico= new Historico($db);
            $expsIn=str_ireplace(",","','",$exps);
            $sqlUp="update sgd_sexp_secexpedientes set sgd_sexp_faseexp=1, sgd_fech_soltransferencia=".$db->conn->OffsetDate(0,$db->conn->sysTimeStamp)."
                    where sgd_exp_numero in ('$expsIn') ";
            $rsUp=$db->conn->Execute($sqlUp);
            if($rsUp)
            {
                    $sqlSel="select sgd_exp_numero from sgd_sexp_secexpedientes where sgd_exp_numero in ('$expsIn') ";
                    $expsVec=$db->conn->GetArray($sqlSel);
                    $radicados[] = "NULL";
                    foreach($expsVec as $i=>$valExp)
                    {
                            $objHistorico->insertarHistoricoExp($valExp[0],$radicados,$_SESSION['dependencia'],$_SESSION['codusuario'],"Solicitud de Transferencia Archivo Central. ".$_POST['txtNCarpeta'],67,'0');
                    }
            }
            $table="<table  class='borde_tab'>
                            <tr>
                                    <td class='titulos5'><font size=3 color=red>
                                            Se realiz&oacute; la solicitud.
                                    </td>
                            </tr>
                            </table>";

	}
}
 

?>
<html>
<head>
<title>Solicitar Transferencias de Expedientes</title>
<link rel="stylesheet" href="../estilos/orfeo.css">
<center>
<body bgcolor="#FFFFFF">
<script>
function cerrar()
{
	window.close();
}
</script>
<form name=solTransf method='post' action="<?php echo $_SERVER['PHP_SELF']."?numExpediente=$numExpediente";?>">
<table class="borde_tab">
<tr>
	<td>
		<?=$table?>
	</td>
</tr>
<tr>
	<td>
		<center>
			<input type="button" id="btnCierra" value="Cerrar" onclick="cerrar();" class="botones_mediano">
		</center>
	</td>
</tr>
</table>
</form>
</center>
</html>