<?
session_start();
/**
  * Modificacion Variables Globales Fabian losada 2009-07
  * Licencia GNU/GPL 
  */

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;


$krd = $_SESSION["krd"];
$dependencia = $_SESSION["dependencia"];
$usua_doc = $_SESSION["usua_doc"];
$codusuario = $_SESSION["codusuario"];
$tpNumRad = $_SESSION["tpNumRad"];
$tpPerRad = $_SESSION["tpPerRad"];
$tpDescRad = $_SESSION["tpDescRad"];
$tpDepeRad = $_SESSION["tpDepeRad"];
$ruta_raiz = "..";
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
$db = new ConnectionHandler("$ruta_raiz");
include_once("$ruta_raiz/include/combos.php");
include_once "$ruta_raiz/include/tx/Historico.php";

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

$objHistorico= new Historico($db);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$phpsession = session_name()."=".session_id();
    $params=$phpsession."&krd=$krd&codusua=$codusua&coddepe=$coddepe&arch=$arch";
    $hora=date("H")."_".date("i");
    // var que almacena el dia de la fecha
$ddate=date('d');
// var que almacena el mes de la fecha
$mdate=date('m');
// var que almacena el a�o de la fecha
$adate=date('Y');
// var que almacena  la fecha formateada
$fecha=$adate."_".$mdate."_".$ddate;
$arcCsv=$fecha."_".$hora;
$p=1;
?>
<head>
<title>Cargar en CSV</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../estilos/orfeo.css">
</head>

<body bgcolor="#FFFFFF" topmargin="0" onLoad="window_onload();">
<script language="JavaScript" type="text/JavaScript">

function validar() {

	archCSV = document.formAdjuntarArchivos.archivoCsv.value;

	if ( (archCSV.substring(archCSV.length-1-3,archCSV.length)).indexOf(".csv") == -1 ){
		alert ("El archivo de datos debe ser .csv");
		return false;
	}

	if (document.formAdjuntarArchivos.archivoCsv.value.length<1){
		alert ("Debe ingresar el archivo CSV");
		return false;
	}
	return true;
}

function enviar() {

	if (!validar()){
	<?$carga_tmp=true;?>
		return;
	}
	//document.formAdjuntarArchivos.accion.value="PRUEBA";
	document.formAdjuntarArchivos.submit();
}

</script>
<CENTER>
<form action="cargarcsv.php?<?=$params?>" name="formAdjuntarArchivos" method="POST" enctype="multipart/form-data" >
<?
if ($archivoCsv_size >= 10000000 )
{	echo "el tama&nacute;o de los archivos no es correcto. <br><br><table><tr><td><li>se permiten archivos de 100 Kb m&aacute;ximo.</td></tr></table>";
}
include ("$ruta_raiz/include/upload/upload_class.php");
$max_size = return_bytes(ini_get('upload_max_filesize')); // the max. size for uploading
$my_upload = new file_upload;
 $my_upload->language="es";
$my_upload->upload_dir = "$ruta_raiz/bodega/tmp/"; // "files" is the folder for the uploaded files (you have to create this folder

$my_upload->extensions = array(".csv"); // specify the allowed extensions here
//$my_upload->extensions = "de"; // use this to switch the messages into an other language (translate first!!!)
$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
$my_upload->rename_file = true;
$archivoCsv = $_POST['cargarArchivo'];
if(isset($archivoCsv)) {
	$tmpFile = trim($_FILES['archivoCsv']['name']);
	$newFile = $arcCsv;
	$uploadDir = "$ruta_raiz/bodega/tmp/";
	$fileGrb = $arcCsv;
	$my_upload->upload_dir = $uploadDir;

	$my_upload->the_temp_file = $_FILES['archivoCsv']['tmp_name'];
	$my_upload->the_file = $_FILES['archivoCsv']['name'];
	$my_upload->http_error = $_FILES['archivoCsv']['error'];
	$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "n"; // because only a checked checkboxes is true
	$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
	//$new_name = (isset($_POST['name'])) ? $_POST['name'] : "";
	if ($my_upload->upload($newFile)) {
		// new name is an additional filename information, use this to rename the uploaded file
		$full_path = $my_upload->upload_dir.$my_upload->file_copy;
		$info = $my_upload->get_uploaded_file_info($full_path);
		// ... or do something like insert the filename to the database
		$h = fopen($full_path,"r") ;
		if (!$h)
		{	echo "<BR> No hay un archivo csv llamado *". $full_path."*";
		}
		else
		{	$alltext_csv = "";
			$encabezado = array();
			$datos = array();
			$j=-1;
			while ($line=fgetcsv ($h, 10000, ","))
			//	Comentariada por HLP. Para puebas de arhivo csv delimitado por ;
			//while ($line=fgetcsv ($h, 10000, ";"))
			{
				$j++;
				if ($j==0)
					$encabezado = array_merge ($encabezado,array($line));
				else
					$datos=  array_merge ($datos,array($line));
			} // while get

			//	echo ("El encabezado es " . $this->encabezado[0][0] .", ". $this->encabezado[0][1] .", ". $this->encabezado[0][2] .", ");
			//  echo ("Las lineas de datos son " . count ($this->datos));
			$c=0;
			while ($c < count ($datos))
			{	$c++;	}
		}
		if($arch==1){
			for($ii=0; $ii < count ($datos) ; $ii++)
			{  
				$i=0;
				$numeroExpediente = "";
				// Aqui se accede a la clase class_control para actualizar expedientes.
				$ruta_raiz = $ruta_raiz;
				// Por cada etiqueta de los campos del encabezado del CSV efect�a un reemplazo
				foreach($encabezado[0] as $campos_d)
				{
					if (strlen(trim($datos[$ii][$i]))<1 )
						$datos[$ii][$i]='';
						$dato_r = iconv("UTF-8", "ISO-8859-1", $dato_r);
					$dato_r = $datos[$ii][$i];
					$texto_tmp = str_replace($campos_d,$dato_r,$texto_tmp);
					if($campos_d=="*DEPENDENCIA*") $depe =$dato_r;
					if($campos_d=="*TIPO*") $tipo =$dato_r;
					if($campos_d=="*NRO_ORDEN*") $orden =$dato_r;
					if($campos_d=="*YEAR*") $ano =$dato_r;
					if($campos_d=="*DEMANDADO_O_TITULO*") $deman =$dato_r;
					if($campos_d=="*DEMANDANTE_O_REMITENTE*") $demant =$dato_r;
					if($campos_d=="*UNIDAD_DOCUMENTAL*") $unidocu =$dato_r;
					if($campos_d=="*FECHA_INICIAL*") $fini =$dato_r;
					if($campos_d=="*FECHA_FINAL*") $ffin =$dato_r;
					if($campos_d=="*ANEXOS*") $anexo =$dato_r;
					if($campos_d=="*FOLIOS*") $folios =$dato_r;
					if($campos_d=="*ZONA*") $zona =$dato_r;
					if($campos_d=="*CARRO*") $carro =$dato_r;
					if($campos_d=="*CARA*") $cara =$dato_r;
					if($campos_d=="*ESTANTE*") $estante =$dato_r;
					if($campos_d=="*ENTREPANO*") $entrepa =$dato_r;
					if($campos_d=="*CAJA*") $caja =$dato_r;
					if($campos_d=="*SRD*") $srd =$dato_r;
					if($campos_d=="*SBRD*") $sbrd =$dato_r;
					if($campos_d=="*CEDULA*") $ced =$dato_r;
					if($campos_d=="*MATERIAL_INSERTADO*") $mata =$dato_r;
				$i++;
				}
				//$db->conn->debug=true;
				$gre="select depe_nomb from dependencia where depe_codi like '$depe'";
				$rge=$db->conn->Execute($gre);
				if($rge->RecordCount()==0)echo "La dependencia a ingresar es incorrecta";
				else{
				$queryUs = "select depe_codi from usuario where USUA_LOGIN='$krd' AND USUA_ESTA='1'";
				$rsu=$db->conn->Execute($queryUs);
				if(!$rsu->EOF)$depeU=$rsu->fields['DEPE_CODI'];
				if($fini=="")$fini="01-01-".$ano;
				if($ffin=="")$fini="31-12-".$ano;
				if($srd=="")$srd=0;
				if($sbrd=="")$sbrd=0;
				$timei="TO_DATE('$fini', 'DD/MM/RR')";
				$timef="TO_DATE('$ffin', 'DD/MM/RR')";
				$sec=$db->conn->nextId('SEC_CENTRAL');
				$expe=$ano.$depe.$sec.'C';
				$dat=$db->conn->OffsetDate(0,$db->conn->sysTimeStamp);
				$sqlm="insert into sgd_archivo_central (sgd_archivo_id,sgd_archivo_depe,sgd_archivo_tipo,sgd_archivo_orden,sgd_archivo_demandado,sgd_archivo_demandante,sgd_archivo_year,sgd_archivo_unidocu,sgd_archivo_fechai,sgd_archivo_fechaf,sgd_archivo_anexo,sgd_archivo_folios,
				sgd_archivo_zona,sgd_archivo_carro,sgd_archivo_cara,sgd_archivo_estante,sgd_archivo_entrepano,sgd_archivo_caja,sgd_archivo_rad,sgd_archivo_srd,sgd_archivo_sbrd,depe_codi,sgd_archivo_usua,sgd_archivo_mata,sgd_archivo_fech,sgd_archivo_cc_demandante)
				values ('$sec','$depe','$tipo','$orden','$deman','$demant','$ano','$unidocu',$timei,$timef,'$anexo','$folios','$zona','$carro','$cara','$estante','$entrepa','$caja','$expe','$srd','$sbrd','$depeU','$krd','$mata',$dat,'$ced')";
				//$db->conn->debug=true;
				$rs3=$db->query($sqlm);
				if($rs3->EOF){
					$p++;
					$ree=$db->conn->Execute("select max(HIST_ID) as coe from sgd_archivo_hist");
					$co=$ree->fields['COE']+1;
					$rad2[1]=$expe;
					$queryUs = "select usua_codi from usuario where USUA_LOGIN='$krd' AND USUA_ESTA='1'";
					$rsu=$db->conn->Execute($queryUs);
					if(!$rsu->EOF){
						$usuacod=$rsu->fields['USUA_CODI'];
					}
					$observa="Ingreso de registro en archivo central en la ubicacion: Zona ".$zona."-Carro ".$carro."-Cara ".$cara."-Estante ".$estante."-Entrepano ".$entrepa."-Caja ".$caja;
					$objHistorico->insertarHistoricoArch($co,$rad2,$depeU,$usuacod,$observa, 64);
					echo $ii." ".$expe." <br>";
				}
				
				}
			}
		}
		else{
			for($ii=0; $ii < count ($datos) ; $ii++)
			{  
				$i=0;
				$numeroExpediente = "";
				// Aqui se accede a la clase class_control para actualizar expedientes.
				$ruta_raiz = $ruta_raiz;
				// Por cada etiqueta de los campos del encabezado del CSV efect�a un reemplazo
				foreach($encabezado[0] as $campos_d)
				{
					if (strlen(trim($datos[$ii][$i]))<1 )
						$datos[$ii][$i]="<ESPACIO>";
					$dato_r = $datos[$ii][$i];
					$texto_tmp = str_replace($campos_d,$dato_r,$texto_tmp);
					if($campos_d=="*No_UNIDAD_DOCUMENTAL_BODEGA*") $nun_doc =$dato_r;
					if($campos_d=="*RADICADOS*") $rad =$dato_r;
					if($campos_d=="*CAJA_BODEGA*") $caja =$dato_r;
					if($campos_d=="*UBICACION*") $ubica =$dato_r;
					if($campos_d=="*OBSERVACION*") $observa =$dato_r;
					if($campos_d=="*No_EXPEDIENTE*") $numeroExpediente =$dato_r;
				$i++;
				}
	
				$sqlm="update sgd_exp_expediente set SGD_EXP_CAJA_BODEGA='$caja', SGD_EXP_CARPETA_BODEGA='$nun_doc',
				SGD_EXP_ASUNTO='$observa' where SGD_EXP_NUMERO LIKE '$numeroExpediente' AND RADI_NUME_RADI = '$rad'";
				$rs3=$db->query($sqlm);
				if($rs3->EOF)$p++;
			}
		}
		if ($p==1)echo "El archivo no pudo ser cargado";
			else echo "El archivo fue cargado con exito";
	}else
	{
	die("<table class=borde_tab><tr><td class=titulosError>Ocurrio un Error la Fila no fue cargada Correctamente <p>".$my_upload->show_error_string()."<br><blockquote>".nl2br($info)."</blockquote></td></tr></table>");
	}



}

	?>
<table width="90%" border="0" cellspacing="5" class="borde_tab">
    <tr align="center">
    <td class="titulos5" colspan="2">Inserte el Nombre del Archivo CSV </td></tr>
<tr>
    <td> <input name="archivoCsv" type="file" class="tex_area" id=archivoCsv  value='<?=$archivoCsv?>'>
<input type=hidden value='cargarArchivo' name=cargarArchivo>
    </td>
    </tr>
    <tr><td align="center"> <input type="button" class="botones_funcion" onClick="enviar();" id="envia22" name="Cargar" value="Cargar">

    <input type="button" value="Cerrar" class="botones_funcion"  onclick="window.close();"> </td>
    </tr>
    </table>
</FORM>