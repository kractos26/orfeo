<?
/**
 * Programa que despliega el resultado de la consulta, seg�n los par�metros enviados desde consulta_depmuni.php
 * @author      Sixto Angel Pinz�n
 * @version     1.0
 */
session_start();
$ruta_raiz = "../..";

require_once("$ruta_raiz/include/db/ConnectionHandler.php");
if (!$db)	$db = new ConnectionHandler($ruta_raiz);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
error_reporting(7);
include "$ruta_raiz/jh_class/funciones_sgd.php";

//Si no llega la dependencia recupera la sesi�n
if(!$_SESSION['dependencia']) include "$ruta_raiz/rec_session.php";
//$db->conn->debug=true;

$consulta = $_POST['consulta'];
?>
<html>
<head>
<title>Consulta de DIVIPOLA</title>
<link rel="stylesheet" href="../../estilos/orfeo.css">
</head>
<body>
<?
//variable que almacena los datos de la sesi�n
$phpsession = session_name()."=".session_id();
//variable que almacena el dato a consultar
$consulta=strtoupper($consulta);
//$db->debug = true;
//variable que almacena el query
switch($db->driver)
{	case 'mssql':
		$c_Continet1="convert(varchar(3),c.ID_CONT)";
		$c_Continet2="convert(varchar(3),'' )";
		$c_pais1="convert(varchar(3),p.ID_CONT)";
		$c_pais2="convert(varchar(3),p.ID_PAIS )";
		$c_depto1="convert(varchar(3),d.ID_CONT)";
		$c_depto2="convert(varchar(3),d.ID_PAIS)";
		$c_depto3="convert(varchar(3),d.DPTO_CODI)";
		$c_mnpio1="convert(varchar(3),m.ID_CONT)";
		$c_mnpio2="convert(varchar(3),m.ID_PAIS)";
		$c_mnpio3="convert(varchar(3),m.DPTO_CODI)";
		$c_mnpio4="convert(varchar(3),m.MUNI_CODI )";
		break;
	 default:
	 	$c_Continet1="c.ID_CONT";
		$c_Continet2="'' ";
		$c_pais1="p.ID_CONT";
		$c_pais2="p.ID_PAIS";
		$c_depto1="d.ID_CONT";
		$c_depto2="d.ID_PAIS";
		$c_depto3="d.DPTO_CODI";
		$c_mnpio1="m.ID_CONT";
		$c_mnpio2="m.ID_PAIS";
		$c_mnpio3="m.DPTO_CODI";
		$c_mnpio4="m.MUNI_CODI";
	 	break;

}
$q = "SELECT ".$db->conn->Concat($c_Continet1,$c_Continet2." AS IDP")."
		FROM SGD_DEF_CONTINENTES c WHERE c.NOMBRE_CONT LIKE '%$consulta%'
	UNION
	  SELECT ".$db->conn->Concat($c_pais1," '-' ",$c_pais2." AS IDP")."
		FROM SGD_DEF_PAISES p WHERE p.NOMBRE_PAIS LIKE '%$consulta%'
	UNION
	  SELECT ".$db->conn->Concat($c_depto1, "'-'",$c_depto2,"'-'",$c_depto3." AS IDP")."
		FROM DEPARTAMENTO d WHERE d.DPTO_NOMB LIKE '%$consulta%'
	UNION
	  SELECT ".$db->conn->Concat($c_mnpio1," '-'",$c_mnpio2," '-'",$c_mnpio3," '-'",$c_mnpio4." AS IDP")."
		FROM MUNICIPIO m WHERE m.MUNI_NOMB LIKE '%$consulta%'";
/*
$q = "SELECT  SGD_DEF_CONTINENTES.ID_CONT AS ID_CONT, SGD_DEF_PAISES.ID_PAIS,  dep.ID_PAIS || '-' || dep.DPTO_CODI AS depto
        , mun.ID_PAIS || '-' || mun.DPTO_CODI || '-' || mun.MUNI_CODI AS municip
		FROM SGD_DEF_CONTINENTES, SGD_DEF_PAISES,  DEPARTAMENTO dep, MUNICIPIO mun
		WHERE (dep.DPTO_NOMB LIKE '%$consulta%' OR mun.MUNI_NOMB LIKE '%$consulta%' )  and mun.DPTO_CODI = dep.DPTO_CODI ";*/

$rs=$db->query($q);

unset($q);
?>
<form action="consulta_depmuni.php?<?=$phpsession?>&krd<?=$krd?>&dependencia=<?=$dependencia?>" method="post" enctype="multipart/form-data" name="formAdjuntarArchivos">
<table width='55%'  cellspacing="5"  align='center' class='borde_tab'>
	<tr align='center' class='titulos5'>
		<td  class='titulos5' colspan='4'>
        	RADICACION MASIVA <BR>CONSULTA DE LA DIVISION POLITICA ADMINISTRATIVA <BR>(DIVIPOLA)
        </td>
	</tr>
	<tr>
		<td class="listado2" height="12" colspan="4">
        	<BR>Resultado de b&uacute;squeda: <?=$consulta ?><BR>
		</td>
	</tr>
	<tr>
		<td width="10%" height="12" align="center" class="titulos3">Continente</td>
		<td width="30%" height="12" align="center" class="titulos3">Pa&iacute;s</td>
		<td width="30%" height="12" align="center" class="titulos3">Departamento</td>
		<td width="30%" height="12" align="center" class="titulos3">Municipio</td>
	</tr>
<?
	if (!$rs) {
		echo "<br><b>No trae nada de la DB</b>";
	}
	//Recorre la consulta
	while  ($rs&&!$rs->EOF)
	{
		$vecRs =  explode("-",$rs->fields['IDP']);
        if(sizeof($vecRs)==1)
        {
            $codCont=$vecRs[0];
            $codPais=null;
            $codDep =null;
            $codMun =null;
        }
        if(sizeof($vecRs)==2)
        {   $codCont=$vecRs[0];
            $codPais=$vecRs[1];
            $codDep =null;
            $codMun =null;
        }
        if(sizeof($vecRs)==3)
        {   $codCont=$vecRs[0];
            $codPais=$vecRs[1];
            $codDep =$vecRs[1]."-".$vecRs[2];
            $codMun =null;
        }
        if(sizeof($vecRs)==4)
        {   $codCont=$vecRs[0];
            $codPais=$vecRs[1];
            $codDep =$vecRs[1]."-".$vecRs[2];
            $codMun =$vecRs[1]."-".$vecRs[2]."-".$vecRs[3];
        }

		$a = new LOCALIZACION( $codDep  ,  $codMun ,$db );

		$a->GET_NOMBRE_CONT($codCont,$db);
		$a->GET_NOMBRE_PAIS($codPais,$db);
?>
	<tr align="center">
		<td class="listado2" height="12" ><span class="etextomenu"><?=$a->continente ?></span></td>
		<td class="listado2" height="12" ><span class="etextomenu"><?=$a->pais ?></span></td>
		<td class="listado2" height="12" ><span class="etextomenu"><?=$a->departamento ?></span></td>
		<td class="listado2" height="12" ><span class="etextomenu"><?=$a->municipio ?></span></td>
	</tr>
<?
		$rs->MoveNext();
	 }
?>
	<tr align="center">
		<td height="30" class="listado2" colspan="4">
			<center>
			<input name="enviaPrueba" type="button"  class="botones" id="envia22"  onClick="document.formAdjuntarArchivos.action='menu_masiva.php?<?=$phpsession?>&krd=<?=$krd?>';document.formAdjuntarArchivos.submit();" value="Cerrar">
			<input name="consultar" type="SUBMIT"  class="botones" id="envia22"  value="Consultar"></center>
		</td>
	</tr>
</table>
</form>
</body>
</html>