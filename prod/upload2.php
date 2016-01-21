<?php
session_start();
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

if ((!$codigo && $userfile1_size==0)||($codigo && $userfile1_size>=return_bytes(ini_get('upload_max_filesize')))) {
    die("<table><tr><td>El tama&ntilde;o del archivo no es correcto.</td></tr><tr><td><li>se permiten archivos de ".ini_get('upload_max_filesize')." m&aacute;ximo.</td></tr><tr><td><input type='button' value='cerrar' onclick='opener.regresar();window.close();'></td></tr></table>");

}
//print ("Entra....");
$fechaHoy = Date("Y-m-d");
if (!$ruta_raiz) $ruta_raiz= ".";
include("$ruta_raiz/config.php");
include_once("$ruta_raiz/class_control/anexo.php");
include_once("$ruta_raiz/class_control/anex_tipo.php");
session_start();
if (!isset($_SESSION['dependencia']))	include "./rec_session.php";

if (!is_object($db))	$db = new ConnectionHandler($ruta_raiz);
//$db->conn->debug=true;

$sqlFechaHoy= $db->conn->OffsetDate(0,$db->conn->sysTimeStamp);
$anex = & new Anexo($db);
$anexTip = & new Anex_tipo($db);

if (!$aplinteg)
	$aplinteg='null';
if (!$tpradic)
	$tpradic='null';

	error_reporting(7);

	if($codigo)
		$nuevo="no";
	else
		$nuevo="si";
	if ($_POST['sololect'])
  		$auxsololect="S";
	else
		$auxsololect="N";
	$db->conn->BeginTrans();
  	if($nuevo=="si")
  	{	$auxnumero=$anex->obtenerMaximoNumeroAnexo($radi);
		do
		{	$auxnumero+=1;
  			$codigo=trim($radi).trim(str_pad($auxnumero,5,"0",STR_PAD_LEFT));
  		}while ($anex->existeAnexo($codigo));
	}
	else
	{	$bien = true;
    	$auxnumero=substr($codigo,-4);
    	$codigo=trim($radi).trim(str_pad($auxnumero,5,"0",STR_PAD_LEFT));
	}
	if($radicado_salida)
	{	$anex_salida = 1;	}
	else
	{	$anex_salida = 0;	}

	$bien = "si";

	if ($bien and $tipo)
	{	error_reporting(7);
		$anexTip->anex_tipo_codigo($tipo);
		$ext=$anexTip->get_anex_tipo_ext();
		$ext = strtolower($ext);
		$auxnumero = str_pad($auxnumero,5,"0",STR_PAD_LEFT);
		$archivo=trim($radi."_".$auxnumero.".".$ext);
		$archivoconversion=trim("1").trim(trim($radi)."_".trim($auxnumero).".".trim($ext));
	}

	if(!$radicado_rem)
		$radicado_rem=7;
	if($userfile1)
		$tamano = (filesize($userfile1)/1000);

	if ($nuevo=="si")
	{
		// $radi = radicado padre
		// $radicado_rem = Codigo del tipo de remitente = sgd_dir_tipo
		// $codigo = ID UNICO DE LA TABLA
		// $tamano = tama�o del archivo
		// $auxsololect' = solo lectuta?
		// $usua = usuario creador
		// $descr = Descripci�n, el asunto
		// $auxnumero = Es c�digo del consecutivo del anexo del radicado
		// Est� borrdo?
		// $anex_salida = marca con 1 si es un radicado de salida

		include "$ruta_raiz/include/query/queryUpload2.php";
		if ($expIncluidoAnexo) {
			$expAnexo = 	$expIncluidoAnexo;
		}else {
			$expAnexo = null;
		}
                $anex_est=(substr($radi ,-1) == 3)?(isset($_POST['estado'])?$_POST['estado']:1):1;
                
		$isql = "insert into anexos
				(sgd_rem_destino,anex_radi_nume,anex_codigo,anex_tipo,anex_tamano   ,anex_solo_lect,anex_creador,anex_desc,anex_numero,anex_nomb_archivo   ,anex_borrado,anex_salida ,sgd_dir_tipo,anex_depe_creador,sgd_tpr_codigo,anex_fech_anex,SGD_APLI_CODI,SGD_TRAD_CODIGO, SGD_EXP_NUMERO,anex_estado)
	           values ($radicado_rem  ,$radi         ,'$codigo'    ,$tipo    ,$tamano     ,'$auxsololect','$usua'     ,'$descr' ,$auxnumero ,'$archivoconversion','N'         ,$anex_salida,$radicado_rem,$dependencia,null,$sqlFechaHoy,        $aplinteg    ,$tpradic, '$expAnexo','$anex_est') ";
		$subir_archivo= "yes hhhhhhh";
	}
	else
	{
           
                if(($radicado_rem==7 && $radicado_rem_ori==1 && $i_copias<=0 )or ($radicado_rem==7 && $radicado_rem_ori==1 && !$direccion_us1 && !$button))
                    $radicado_rem=1;
		if($userfile1) $subir_archivo = " anex_nomb_archivo='1$archivo',anex_tamano = $tamano,anex_tipo=$tipo, "; else {$subir_archivo="";}
	 	$isql = "update anexos set $subir_archivo anex_salida=$anex_salida,sgd_rem_destino=$radicado_rem,sgd_dir_tipo=$radicado_rem,anex_desc='".$_POST['descr']."', SGD_TRAD_CODIGO =$tpradic , SGD_APLI_CODI = $aplinteg,ANEX_SOLO_LECT='$auxsololect'  where anex_codigo='$codigo'";
	}
        
        
	//$db->conn->debug=true;
	// print ("trata doss codigo($codigo)($nuevo)");
        
        
    $bien=$db->query($isql);
	//print("Ha efectuado la transaccion($isql)($dependencia)");

	if ($bien)	//Si actualizo BD correctamente
	{	$respUpdate="OK";
		$bien2 = false;
		if ($subir_archivo)
		{
			$directorio="$carpetaBodega/".substr(trim($archivo),0,4)."/".substr(trim($archivo),4,3)."/docs/";
			echo $directorio;
			$bien2=move_uploaded_file($userfile1,$directorio.trim(strtolower($archivoconversion)));
			if ($bien2)	//Si intent� anexar archivo y Subio correctamente
			{	$resp1="OK";
				$db->conn->CommitTrans();
			}
			else
			{	$resp1="ERROR";
				$db->conn->RollbackTrans();

			}
		}
		else {
			$db->conn->CommitTrans();

		}
	}
	else{
		$db->conn->RollbackTrans();
		
	}

include "nuevo_archivo.php";
?>
