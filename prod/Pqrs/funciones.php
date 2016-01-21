<?
//muestra nombre mes
function nombremes($mes)
{
	switch($mes)
	{
		case "01":
			return "enero";
		case "02":
			return "febrero";
		case "03":
			return "marzo";
		case "04":
			return "abril";
		case "05":
			return "mayo";
		case "06":
			return "junio";
		case "07":
			return "julio";
		case "08":
			return "agosto";
		case "09":
			return "septiembre";
		case "10":
			return "octubre";
		case "11":
			return "noviembre";
		case "12":
			return "diciembre";
	}
}
//muestra nombre dia
function nombredia($dia)
{
	switch($dia)
		{
		case 1:
			return "Lunes";
		case 2:
			return "Martes";
		case 3:
			return "Miercoles";
		case 4:
			return "Jueves";
		case 5:
			return "Viernes";
		case 6:
			return "Sabado";
		case 7:
			return "Domingo";
		}
}
//inserta en cualquier tabla, los parametros campos y valores son arreglos
function inserta($tabla,$campos,$valores,$db)
{
	$tcampos=count($campos);
	$tvalores=count($valores);
	$sql="insert into ".$tabla;
	$sql.="(";
	$k=1;
	foreach($campos as $valorc)
		{
			$sql.=$valorc;
			if($k < $tcampos)
				$sql.=",";
			$k++;
		}
	$sql.=")values(";
	$k=1;
	foreach($valores as $valorv)
		{
			if(gettype($valorv)=="string")
				$sql.="'".$valorv."'";
			else	
				$sql.=$valorv;
			if($k < $tvalores)
				$sql.=",";
			$k++;
		}
	$sql.=")";
$db->conn->Execute($sql);
//echo $sql;
echo $db->ErrorMsg();
}
//\ el ultimo consecutivo de cualquier tabla
function consecutivo($tabla,$primaria,$db)
{
$sql="select MAX(".$primaria.") as cont from ".$tabla;
$rs=$db->conn->Execute($sql);
$ultimo=$rs->fields['cont'];
return $ultimo;
}
//borra un registro
function borra($tabla,$campo,$valor,$db)
{
$sql_del="delete from ".$tabla." where ".$campo."=".$valor;
$rs_del=$db->conn->Execute($sql_del);
}
//reemplaza tildes
function texto_ajax($texto)
{
	if($texto)
	{
		$texto=replace($texto,"á","&aacute;");
		$texto=replace($texto,"Á","&Aacute;");
		$texto=replace($texto,"é","&eacute;");
		$texto=replace($texto,"É","&Eacute;");
		$texto=replace($texto,"í","&iacute;");
		$texto=replace($texto,"Í","&Iacute;");
		$texto=replace($texto,"ó","&oacute;");
		$texto=replace($texto,"Ó","&Oacute;");
		$texto=replace($texto,"ú","&uacute;");
		$texto=replace($texto,"Ú","&Uacute;");
		$texto=replace($texto,"ñ","&ntilde;");
		$texto=replace($texto,"Ñ","&Ntilde;");
		$texto=replace($texto,"¿","&iquest;");
		$texto=replace($texto,"?","&#63;");
		
		
//		$texto=replace($texto,'"',"&quot;");
//		$texto=replace($texto,"\\","");
//		$texto=replace($texto,'"',"&quot;");
//		$texto=replace($texto,"\"","&");
	}
	return $texto;
}
function texto_ajax2($texto)
{
	if($texto)
	{
		$texto=replace($texto,"&aacute;","¿");
		$texto=replace($texto,"&Aacute;","¿");
		$texto=replace($texto,"&eacute;","¿");
		$texto=replace($texto,"&Eacute;","¿");
		$texto=replace($texto,"&iacute;","¿");
		$texto=replace($texto,"&Iacute;","¿");
		$texto=replace($texto,"&oacute;","¿");
		$texto=replace($texto,"&Oacute;","¿");
		$texto=replace($texto,"&uacute;","¿");
		$texto=replace($texto,"&Uacute;","¿");
		$texto=replace($texto,"&ntilde;","¿");
		$texto=replace($texto,"&Ntilde;","¿");
//		$texto=replace($texto,'"',"&quot;");
//		$texto=replace($texto,"\"","&");
	}
	return $texto;
}

function replace($original,$nuevo,$otro)
{
	return str_replace($nuevo,$otro,$original);
}
//funcion para validar direcciones de correo electronico
function check_email_address($email) 
{
	// Primero, chequeamos que solo haya un simbolo @, y que los largos sean correctos
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) 
	{
		// correo invalido por numero incorrecto de caracteres en una parte, o numero incorrecto de simbolos @
    return false;
  }
  // se divide en partes para hacerlo mas sencillo
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) 
	{
    if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) 
		{
      return false;
    }
  } 
  // se revisa si el dominio es una IP. Si no, debe ser un nombre de dominio valido
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) 
	{ 
     $domain_array = explode(".", $email_array[1]);
     if (sizeof($domain_array) < 2) 
		 {
        return false; // No son suficientes partes o secciones para se un dominio
     }
     for ($i = 0; $i < sizeof($domain_array); $i++) 
		 {
        if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) 
				{
           return false;
        }
     }
  }
  return true;
}
//validador de correos
function emailValidator($email){
	$email	= trim($email);
	if(!(preg_match('/^[\w\-\.]+[@][A-z0-9]+[\w\-.]*([.][A-z]{2,6}){1}([.][A-z]{2}){0,1}$/x',$email))){
		return false;
	}
	return true;
}
// web en miniatura
function miniatura_web($url, $servicio = "browsercamp", $tamanio = "1", $calidad = "high"){
	$tamanios = array("800", "832", "1024", "1280", "1600");
	$calidades = array("png" => "1", "high" => "2", "medium" => "3", "low" => "4");
	if("ipinfo" == $servicio){
		$sevicios = 'http://ipinfo.info/netrenderer/index.php?browser=ie7&url='.$url;
		$exp_info = '!http://renderer.geotek.de/image.php\?imgid=(.+)&browser=ie7!U';
		$query = @file_get_contents($sevicios);
		preg_match_all($exp_info, $query, $info);
		$s = $info[0][0];
		return $s;
	}
	if("browsercamp" == $servicio){
		$sevicios  = "http://www.browsrcamp.com/?get=1&width=".$tamanios[$tamanio]."&url=".$url;
		$sevicios .= "&quality=".$calidades[$calidad];
		$exp_info = '!<a href="(.+)" target="_blank">!U';
		$query = @file_get_contents($sevicios);
		preg_match_all($exp_info, $query, $info);
		$s = array(
			"full" => $info[1][0],
			"thumb" => str_replace("full", "thumb", $info[1][0])
		);
		return $s;
	}
	if("thumbalizr" == $servicio){
		$s = "http://www.thumbalizr.com/api/?url=".$url."&width=".$tamanios[$tamanio];
		return $s;
	}
}
function ordena_fecha($fecha)
{
	$fechav=split("-",$fecha);
	$fechac=$fechav[2]."-".$fechav[1]."-".$fechav[0];
	return $fechac;
}

function textoPDF($texto){
	return iconv('UTF-8', 'ISO-8859-1//IGNORE', $texto);
//	return $texto;
}

function valida_fecha($db)
{

$num_dias[]=0;
$num_dias[]=31;
$num_dias[]=28;
$num_dias[]=31;
$num_dias[]=30;
$num_dias[]=31;
$num_dias[]=30;
$num_dias[]=31;
$num_dias[]=31;
$num_dias[]=30;
$num_dias[]=31;
$num_dias[]=30;
$num_dias[]=31;
//consulta si la fecha es festivo, sabado o domingo
$dia=date('j');
$mes=date('n');
$ano=date('Y');
$dia_num=date('N');

/*
$dia=1;
$mes=11;
$ano=2009;
$dia_num=7;
*/

$j="";
$k=0;
while($j!='ok')
	{
		$sql_fes="select count(*) as k from sgd_noh_nohabiles where noh_fecha=to_date('".$dia."/".$mes."/".$ano." ','dd/mm/yyyy')";
		$rs_fes=$db->conn->Execute($sql_fes);
		if((($rs_fes->fields['K']) != 1) && ($dia_num != 6 && $dia_num != 7))
			{
				$dia=$dia;
				$mes=$mes;
				$ano=$ano;
				$j='ok';
			}
		else
			{
				if($num_dias[$mes] > $dia)
					{
						$dia=$dia+1;
						$dia_num=$dia_num+1;
						$k=1;
					}
				if($num_dias[$mes] == $dia)
					{
						$dia=1;
						$mes=$mes+1;
						$dia_num=$dia_num+1;
						$k=1;
					}
			}
	}
$hora=date('G');
$minuto=date('i');
/*
$hora=16;
$minuto=31;
*/

$fechah=date('h:i:s');
//valida la hora de radicacion

if($k==0)
	{
		if(($hora <= 8) && ($minuto < 30))
			$fechah="08:30:00";
		if(($hora >= 16) && ($minuto > 30))
			{
			$fechah="08:30:00";
			if($num_dias[$mes] > $dia)
					{
						$dia=$dia+1;
					}
				if($num_dias[$mes] == $dia)
					{
						$dia=1;
						$mes=$mes+1;
					}
			}
	}
else
	$fechah="08:30:00";

$fecha=$dia."/".$mes."/".$ano." ".$fechah;
return $fecha;
}

function getNumPagesPdf($filepath){
    $fp = @fopen(preg_replace("/\[(.*?)\]/i", "",$filepath),"r");
    $max=0;
    while(!feof($fp)) {
            $line = fgets($fp,255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)){
                    preg_match('/[0-9]+/',$matches[0], $matches2);
                    if ($max<$matches2[0]) $max=$matches2[0];
            }
    }
    fclose($fp);
    if($max==0){
        $im = new imagick($filepath);
        $max=$im->getNumberImages();
    }

    return $max;
}


?>
