<?php 
session_start();

    $ruta_raiz = "."; 
    if (!$_SESSION['dependencia'])
        header ("Location: $ruta_raiz/cerrar_session.php");

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;

$dependencia = $_SESSION["dependencia"];
$usua_doc    = $_SESSION["usua_doc"];
$codusuario  = $_SESSION["codusuario"];

include_once  "$ruta_raiz/include/db/ConnectionHandler.php";
$db = new ConnectionHandler($ruta_raiz);	
?>

<html>
<title>Adm - Contrase&ntilde;as - ORFEO </title>
<HEAD>
<link rel="stylesheet" href="estilos/orfeo.css">
</HEAD>
	<body>
	<CENTER>
<?php
if(!$depsel) $depsel = $dependencia;
if($aceptar=="grabar"){
    $isql = "update 
                usuario 
                set 
                usua_nuevo     = '1',
                usua_pasw      ='".SUBSTR(md5($contraver),1,26)."', 
                USUA_SESION    = 'camClav".date("Ymd")."' 
            where 
                DEPE_CODI = $dependencia and
                USUA_CODI = $codusuario";
    $rs = $db->conn->query($isql);
    if($rs==-1){
        echo "<P><P><center>No se ha podido cambiar la contrase&ntilde;a, Verifique los datos e intente de nuevo</center>";
    }else{
        header ("Location: $ruta_raiz/cerrar_session.php");
    }
}else{
   if($contradrd==$contraver){
?>
	</p>
   <form action="usuarionuevo.php" method=post><CENTER>
        <input type='hidden' value="<?=$contraver?>" name='contraver'>
        <input type='hidden' value="<?=$contradrd?>" name="contradrd">
	    <input type='hidden' value='<?=session_id()?>' name='<?=session_name()?>'> 
	    <table border = 0 width="300px">
		    <tr><td class=listado2><center>Esta Seguro de estos datos ? </td></tr>
	    </table>
		<input type=submit value='grabar' name=aceptar class=botones> 
    </form>
	<?php
	 }else
	 {?>
	<table border = 0 width="300px">
    <tr ><td class="listado2">
       <center><p>Las contrase&ntilde;as no coinciden</P>
       <a href="contraxx.php?<?=session_name()."=".session_id()?>"><input type="submit" value="Regresar" class="botones"/></a>
    </td></tr> 
	 </table>
    <?
		}
		}
 ?>	

</body>
</html>
