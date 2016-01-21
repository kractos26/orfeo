<?
session_start();
$ruta_raiz = "..";
if(!$_SESSION['dependencia']) include_once "$ruta_raiz/rec_session.php";

/**
 * Retorna la cantidad de bytes de una expresion como 7M, 4G u 8K.
 *
 * @param char $var
 * @return numeric
 */
function return_bytes($val)
{	$val = trim($val);
	$ultimo = strtolower($val{strlen($val)-1});
	switch($ultimo)
	{	// El modificador 'G' se encuentra disponible desde PHP 5.1.0
		case 'g':	$val *= 1024;
		case 'm':	$val *= 1024;
		case 'k':	$val *= 1024;
	}
	return $val;
}

/*  REALIZAR TRANSACCIONES
 *  Este archivo realiza las transacciones de radicados en Orfeo.
 */
?>
<html>
<head>
<title>Realizar Transaccion - Orfeo </title>
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>
<?
/**
  * Inclusion de archivos para utilizar la libreria ADODB
  *
  */
   include_once "$ruta_raiz/include/db/ConnectionHandler.php";
   $db = new ConnectionHandler("$ruta_raiz");
   //$db->conn->debug=true;
 /*
	* Genreamos el encabezado que envia las variable a la paginas siguientes.
	* Por problemas en las sesiones enviamos el usuario.
	* @$encabezado  Incluye las variables que deben enviarse a la singuiente pagina.
	* @$linkPagina  Link en caso de recarga de esta pagina.
	*/
	$encabezado = "".session_name()."=".session_id()."&krd=$krd&depeBuscada=$depeBuscada&filtroSelect=$filtroSelect&tpAnulacion=$tpAnulacion";

/*  FILTRO DE DATOS
 *  @$setFiltroSelect  Contiene los valores digitados por el usuario separados por coma.
 *  @$filtroSelect Si SetfiltoSelect contiene algunvalor la siguiente rutina realiza el arreglo de la condici� para la consulta a la base de datos y lo almacena en whereFiltro.
 *  @$whereFiltro  Si filtroSelect trae valor la rutina del where para este filtro es almacenado aqui.
 *
 */
if($checkValue)
{
	$num = count($checkValue);
	$i = 0;
	while ($i < $num)
	{
		$record_id = key($checkValue);
		$setFiltroSelect .= $record_id ;
		$radicadosSel[] = $record_id;
		if($i<=($num-2))
		{
			$setFiltroSelect .= ",";
		}
  	next($checkValue);
	$i++;
	}
	if ($radicadosSel)
	{
		$whereFiltro = " and b.radi_nume_radi in($setFiltroSelect)";
	}
}
 if($setFiltroSelect)
 {
		$filtroSelect = $setFiltroSelect;
 }

echo "<hr>$filtroSelect<hr>";
//session_start();

//if (!$dependencia or !$nivelus)  include "./rec_session.php";
$causaAccion = "Asociar Imagen a Radicado";
?>
<body>
<br>
<?
/**
 * Aqui se intenta subir el archivo al sitio original
 *
 */
$dbTmp=$db;
$ruta_raiz = "..";
include("$ruta_raiz/config.php");
$db=$dbTmp;
include ("$ruta_raiz/include/upload/upload_class.php"); //classes is the map where the class file is stored (one above the root)
$max_size = return_bytes(ini_get('upload_max_filesize')); // the max. size for uploading
$my_upload = new file_upload;
$my_upload->language="es";
$my_upload->upload_dir = "$ruta_raiz/$carpetaBodega/tmp/"; // "files" is the folder for the uploaded files (you have to create this folder)
$my_upload->extensions = array(".tif", ".pdf",  ".jpg", ".odt", ".tiff"); // specify the allowed extensions here
//$my_upload->extensions = "de"; // use this to switch the messages into an other language (translate first!!!)
$my_upload->max_length_filename = 100; // change this value to fit your field length in your database (standard 100)
$my_upload->rename_file = true;
if(isset($_POST['Realizar'])) {
	$tmpFile = trim($_FILES['upload']['name']);
	$newFile = $valRadio;
	$uploadDir = "$ruta_raiz/$carpetaBodega/".substr($valRadio,0,4)."/".substr($valRadio,4,3)."/";
	$fileGrb = substr($valRadio,0,4)."/".substr($valRadio,4,3)."/$valRadio".".".substr($tmpFile,  strripos($tmpFile, ".")+1,  strlen($tmpFile)-strripos($tmpFile, ".")+1);
	$my_upload->upload_dir = $uploadDir;

	$my_upload->the_temp_file = $_FILES['upload']['tmp_name'];
	$my_upload->the_file = $_FILES['upload']['name'];
	$my_upload->http_error = $_FILES['upload']['error'];
	$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "n"; // because only a checked checkboxes is true
	$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
	//$new_name = (isset($_POST['name'])) ? $_POST['name'] : "";
	if ($my_upload->upload($newFile)) {
		// new name is an additional filename information, use this to rename the uploaded file
		$full_path = $my_upload->upload_dir.$my_upload->file_copy;
		$info = $my_upload->get_uploaded_file_info($full_path);
		if( (strtolower(substr($tmpFile,-3))=="pdf") || (strtolower(substr($tmpFile,-3))=="tif") || (strtolower(substr($tmpFile,-3))=="tiff") ) {
			try {
                            if (strtolower(substr($tmpFile,-3))!="pdf") {
				$im = new Imagick($full_path);
				$datos = $im->identifyimage();
				$pagecount = $im->getnumberimages();
                            }else
                            {
                                $pdftext = file_get_contents($full_path);
                                $pagecount = preg_match_all("/\/Page\W/", $pdftext,$dummy);
                            }
			} catch (Exception $e) {
				if (strtolower(substr($tmpFile,-3))=="pdf") {
                                    $pdftext = file_get_contents($full_path);
                                    $pagecount = preg_match_all("/\/Page\W/", $pdftext,$dummy);
				} else $pagecount=1;
			}
		} else $pagecount=1;
		// ... or do something like insert the filename to the database
	}else
	{

			die("<table class=borde_tab><tr><td class=titulosError>Ocurrio un Error la Fila no fue cargada Correctamente <p>".$my_upload->show_error_string()."<br><blockquote>".nl2br($info)."</blockquote></td></tr></table>");
	}
}
?>
<table cellspace=2 WIDTH=60% id=tb_general align="left" class="borde_tab">
<tr>
	<td colspan="2" class="titulos4">ACCION REQUERIDA --> <?=$causaAccion ?> </td>
</tr>
<tr>
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">ACCION REQUERIDA :
</td>
	<td  width="65%" height="25" class="listado2_no_identa">
	ASOCIACION DE IMAGEN A RADICADO
	</td>
</tr>
<tr>
	<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">RADICADOS INVOLUCRADOS :
	</td>
<td  width="65%" height="25" class="listado2_no_identa"><?=$valRadio?>
</td>
</tr>
<tr>
<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">Datos Fila Asociada :
</td>
<td  width="65%" height="25" class="listado2_no_identa">
<?=$info?>
</td>
</tr>
<tr>
<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">FECHA Y HORA :
</td>
<td  width="65%" height="25" class="listado2_no_identa">
<?=date("m-d-Y  H:i:s")?>
</td>
</tr>
<tr>
<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">USUARIO ORIGEN:
</td>
<td  width="65%" height="25" class="listado2_no_identa">
<?=$_SESSION['usua_nomb']?>
</td>
</tr>
<tr>
<td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">DEPENDENCIA ORIGEN:
</td>
<td  width="65%" height="25" class="listado2_no_identa">
<?=$_SESSION['depe_nomb']?>
</td>
</tr>
</table>
<table class="borde_tab">
<tr><td class="titulosError">
<?
  $query = "update radicado
  			set radi_path='$fileGrb', radi_nume_hoja=$pagecount
  			where radi_nume_radi=$valRadio
                        ";
  if($db->conn->Execute($query))
  {
	$radicadosSel[] = $valRadio;
	$codTx = 42;	//Codigo de la transaccion
	include "$ruta_raiz/include/tx/Historico.php";
	$hist = new Historico($db);
	$hist->insertarHistorico($radicadosSel,  $dependencia , $codusuario, $dependencia, $codusuario," ($pagecount Paginas) ". $observa, $codTx);
	}else{
  	echo "<hr>No actualizo la BD <hr>";
  }
?>
</td></tr>
</table>
</form>
</body>
</html>

