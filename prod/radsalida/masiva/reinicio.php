<?php
/**
 * @copyright Grupo Iyunxi Ltda.
 * @param string $path Ruta fisica de la carpeta
 * @param Octal $mode  Permisos con que debe crearse la carpeta
 * @param Boolean rec  Indica si aplica recursividad.
 * @return Boolean (TRUE) Si existe o fue creada la carpeta.
 */
function rmkdir($path, $mode = 0775, $rec = true)
{
    $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
    $e = explode("/", ltrim($path, "/"));
    if(substr($path, 0, 1) == "/")
    {
        $e[0] = "/".$e[0];
    }
    $c = count($e);
    $cp = $e[0];
    for($i = 1; $i < $c; $i++)
    {
        if(!is_dir($cp) && !@mkdir($cp, $mode, $rec))
        {
            return false;
        }
        $cp .= "/".$e[$i];
    }
    return @mkdir($path, $mode, $rec);
}

$ano=date('Y');
if (isset($_POST['btn_enviar']))
{
	require("config.php");
	if (isset($_POST['chk_dep']))
    {   define('ADODB_ASSOC_CASE', 1);
    	require($ADODB_PATH."/adodb.inc.php");
		$dsn = "$driver://$usuario:$contrasena@$servidor/$servicio";
		$conn = ADONewConnection( $dsn );
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$sql="SELECT depe_codi as DEPE_CODI from dependencia where depe_estado=1";
		$rs = $conn->Execute($sql);
		$msgD = "Estado de dependencias:<br>";
		while (!$rs->EOF)
		{
			$dep = str_pad($rs->fields['DEPE_CODI'],3,"0", STR_PAD_LEFT);
			$tmp = str_replace('reinicio.php',$carpetaBodega,$_SERVER['SCRIPT_FILENAME']);
            $tmp .= "/$ano/".$dep."/docs";
			$ok = rmkdir($tmp);
			if ($ok)
				$msgD .= "<br>Creada dependencia $dep";
			else
				$msgD .= "<br>Error en creaci&oacute;n $dep";
            $rs->MoveNext();
		}
		$rs->Close();
		$conn = null;
	}
	if (isset($_POST['chk_sec']))
	{	define('ADODB_ASSOC_CASE', 1);
    	require($ADODB_PATH."/adodb.inc.php");
		$dsn = "$driver://$usuario:$contrasena@$servidor/$servicio";
		$conn = ADONewConnection( $dsn );
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
        $msgS = "Estado de Secuencias<br>";
        $sql = "select SEQUENCE_NAME as SEQUENCE_NAME  from all_sequences where sequence_owner='".strtoupper($usuario)."' and sequence_name like 'SECR_TP%'";
		$rs = $conn->Execute($sql);
        !$rs?die('Error al generar consulta: '.$sql):0;
        while (!$rs->EOF)
		{
            $secu = $rs->fields['SEQUENCE_NAME'];
            $ok   = $conn->DropSequence($secu);
            if ($ok)
				$msgS .= "<br>Secuencia $secu Eliminada";
			else
				$msgS .= "<br>Secuencia $secu NO Eliminada";
            $rs->MoveNext();
        }
        $rs->Close();
		$conn = null;
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<TITLE>Inicializaci&oacute;n de datos ORFEO. .: GRUPO IYUNXI LTDA:.</TITLE>
<link rel="StyleSheet" href="estilos/orfeo.css">
<script language="JavaScript">
function val()
{
    var chk1 = document.getElementById('chk_dep').checked;
    var chk2 = document.getElementById('chk_sec').checked;
	if (!(chk1 || chk2))   
    {
        alert('No ha seleccionado opcion.');
        return false;
     }
    if(!confirm('Esta seguro de ejecutar la accion ?'))return false;

    
}
</script>
</head>
<body>
<form action="<?php echo $_SERVER['SELF']; ?>" method="POST" name="frm_ppal">
<table width="100%" border="0" align="center">
  <tbody>
    <tr>
      <td colspan="3" align="center"><b>INICIALIZACI&Oacute;N DE DATOS EN ORFEO</b></td>
    </tr>
    <tr>
      <td colspan="3">
        <table width="100%" border="1" bgcolor="Red">
        <tr>
          <td align="center" colspan="3">
		    <p align="center"><font color="Yellow">&lt;&lt;&nbsp;</font>PRECAUCI&Oacute;N<font color="Yellow">&gt;&gt;&nbsp;</font></p>
		      <font color="White">
			    Este script <b>SOLO</b> debe ejecutarse <b>una</b> vez (al iniciar el a&ntilde;o) en la entidad. <br/><br/>
			    Recomiendaciones :
                <ul> * Realizar backup de la BD y BODEGA antes de iniciar cualquier acci&oacute;n.</ul>
                <ul> * No haber usuarios logueados en el sistema.</ul>
		      </font>
	        </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="checkbox" name="chk_dep" id="chk_dep" value="D">Crear estructura de la bodega (dependencias)<br/>
        <input type="checkbox" name="chk_sec" id="chk_sec" value="S">Reinicializar secuencias.
      </td>
      <td></td>
    </tr>
    <tr>
      <td>
      	<?php
      		echo $msgD;
      	?>
      </td>
      <td></td>
      <td>
        <?php
      		echo $msgS;
      	?></td>
    </tr>
    <tr>
      <td align="center" colspan="3">
	<input type="submit" name="btn_enviar" id="btn_enviar" value="INICIAR" class="botones" onclick="return val();"></td>
    </tr>
  </tbody>
</table>
</form>
</body>
</html>
